
ALTER TABLE core.equipos ALTER COLUMN sect_id TYPE varchar USING sect_id::varchar;
ALTER TABLE core.equipos ADD CONSTRAINT equipos_sectores_fk FOREIGN KEY (sect_id) REFERENCES core.tablas(tabl_id);
ALTER TABLE prd.etapas_materiales ADD CONSTRAINT etapas_materiales_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id);

CREATE TABLE tst.tareas_planificadas (
	tapl_id serial NOT NULL,
	nombre varchar NOT NULL,
	user_id int4 NULL,
	info_id int4 NULL,
	case_id int4 NULL,
	tare_id int4 NULL,
	fecha date NULL DEFAULT to_date('3000-12-31'::text, 'YYYY-MM-DD'::text),
	eliminado bool NOT NULL DEFAULT false,
	CONSTRAINT tareas_planificadas_pk PRIMARY KEY (tapl_id)
);

-- prd.lotes_tareas_planificadas definition

-- Drop table

-- DROP TABLE prd.lotes_tareas_planificadas;

CREATE TABLE prd.lotes_tareas_planificadas (
	tapl_id int8 NOT NULL,
	batch_id int8 NOT NULL,
	CONSTRAINT lotes_tareas_planificadas_pk PRIMARY KEY (tapl_id, batch_id)
);


-- prd.lotes_tareas_planificadas foreign keys

ALTER TABLE prd.lotes_tareas_planificadas ADD CONSTRAINT lotes_tareas_planificadas_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
ALTER TABLE prd.lotes_tareas_planificadas ADD CONSTRAINT lotes_tareas_planificadas_fk_1 FOREIGN KEY (tapl_id) REFERENCES tst.tareas_planificadas(tapl_id);

-- tst.origen_tarea_planficada definition

-- Drop table

-- DROP TABLE tst.origen_tarea_planficada;

CREATE TABLE tst.origen_tarea_planficada (
	origen varchar NOT NULL,
	tapl_id int8 NOT NULL,
	orta_id int8 NOT NULL,
	CONSTRAINT origen_tarea_planficada_pk PRIMARY KEY (origen, tapl_id, orta_id)
);


-- tst.origen_tarea_planficada foreign keys

ALTER TABLE tst.origen_tarea_planficada ADD CONSTRAINT origen_tarea_planficada_fk FOREIGN KEY (tapl_id) REFERENCES tst.tareas_planificadas(tapl_id);

-- tst.recursos_tareas definition

-- Drop table

-- DROP TABLE tst.recursos_tareas;

CREATE TABLE tst.recursos_tareas (
	tapl_id int4 NOT NULL,
	recu_id int4 NOT NULL
);


-- tst.recursos_tareas foreign keys

ALTER TABLE tst.recursos_tareas ADD CONSTRAINT recursos_tareas_fk_1 FOREIGN KEY (tapl_id) REFERENCES tst.tareas_planificadas(tapl_id);

CREATE OR REPLACE FUNCTION prd.crear_lote_v2(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying DEFAULT 'false'::character varying, p_fec_vencimiento date DEFAULT NULL::date, p_recu_id integer DEFAULT NULL::integer, p_tipo_recurso character varying DEFAULT NULL::character varying, p_planificado character varying DEFAULT 'false'::character varying, p_batch_id bigint DEFAULT NULL::bigint)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
/** Funcion para generar un nuevo lote
 *  Recibe como parametro un id de lote
 *  y un recipiente donde crear el batch.
 *  Si el recipiente esta ocupado, devuelve el error
 */
#print_strict_params on
DECLARE
 v_estado_recipiente prd.recipientes.estado%type; 
 v_batch_id prd.lotes.batch_id%type;
 v_batch_id_aux prd.lotes.batch_id%type;
 v_mensaje varchar;
 v_reci_id_padre prd.recipientes.reci_id%type;
 v_depo_id prd.recipientes.depo_id%type;
 v_lote_id prd.lotes.lote_id%type;
 v_arti_id alm.alm_lotes.arti_id%type;
 v_cantidad_padre alm.alm_lotes.cantidad%type;
 v_recu_id prd.recursos_lotes.recu_id%type;
 v_resultado varchar;
 v_estado varchar;
 v_cantidad float;
 v_cuenta integer;
 v_artDif boolean = false;
 v_lotDif boolean = false;
 v_lotartIgual boolean = false;
 v_countLotesRec integer = 0;
 v_info_error varchar;
 verificarRecipiente CURSOR (p_batch_id INTEGER
			   ,p_arti_id INTEGER
			   ,p_lote_id VARCHAR) for
				select lo.batch_id
				,al.arti_id
				,lo.lote_id
				from prd.lotes lo
				,alm.alm_lotes al
				where reci_id  = p_reci_id
				and (al.arti_id != p_arti_id or lo.lote_id != p_lote_id)
				and lo.batch_id = al.batch_id
				and lo.estado = 'En Curso';


BEGIN
		
		/* seteo el estado inicial dependiendo si se llama al procedure desde Guardar o desde Planificar estapa */
		if (p_planificado='true') then
			v_estado = 'PLANIFICADO';
		else
			v_estado = 'En Curso';
		end if;
		
		/**************************
		 * BLOQUE 1: VALIDO EL ESTADO DEL RECIPIENTE
		 */
		begin
		        
			RAISE INFO 'PRDCRLO - BL1 valido reci - ṕ_forzar_agregar = %, p_lote_id % ', p_forzar_agregar, p_lote_id;

			/** Valido que el recipiente exista y no tenga contenido **/
			select reci.estado
				   ,reci.depo_id
			into strict v_estado_recipiente
				,v_depo_id
			from PRD.RECIPIENTES reci
			where reci.reci_id = p_reci_id;

				       
	    		/*
		 	* 1 - si forzar_agregar = false, verifica si el recipiente esta vacio, si no esta vacio 
		 	*  a) verifica si en el recipiente esta el mismo articulo, sino retorna RECI_NO_VACIO_DIST_ART
		 	*  b) si es mismo articulo y distinto lote retorna RECI_NO_VACIO_DIST_LOTE_IGUAL_ART
		 	*  c) si es mismo arituclo y lote retorna RECI_NO_VACIO_MISMO_IGUAL_ART_LOTE
                	*/	
    
			if v_estado_recipiente != 'VACIO' then
				open verificarRecipiente(p_reci_id,p_arti_id,p_lote_id);
				loop
					fetch verificarRecipiente into v_batch_id_aux ,v_arti_id,v_lote_id;
					exit when NOT FOUND;
      
       				if v_arti_id != p_arti_id then 
       					RAISE DEBUG 'PRDCRLO - revisando recipientes batch v_arti_id p arti id % % %',v_batch_id_aux,v_arti_id,p_arti_id;
						v_artDif = true;
					elsif v_lote_id != p_lote_id then
       					RAISE DEBUG 'PRDCRLO - revisando recipientes batch v_lote_id p lote id % >%< >%<',v_batch_id_aux,v_lote_id,p_lote_id;
						v_lotDif = true;					        		
					else 
						v_lotartIgual = true;
					end if;
				end loop;
				close verificarRecipiente;
				RAISE INFO 'PRDCRLO - revisando recipientes banderas % % %',v_artDif,v_lotDif,v_lotartIgual;
			
				/* Corto la ejecución, hay que advertir al usuario que el recipiente no esta vacio y que decida que hacer **/
	    		if p_forzar_agregar!='true' and p_planificado = 'false' then
	
	    			v_info_error = 'reci_id='||p_reci_id||'-arti_id='||p_arti_id||'-lote_id='||p_lote_id;
					if v_artDif then
			            v_mensaje = 'RECI_NO_VACIO_DIST_ART'; /* caso a */
						raise exception 'RECI_NO_VACIO_DIST_ART-%',v_info_error;
					elsif v_lotDif then
			            v_mensaje = 'RECI_NO_VACIO_DIST_LOTE_IGUAL_ART'; /* caso b */
				    	raise exception 'RECI_NO_VACIO_DIST_LOTE_IGUAL_ART-%',v_info_error;
					else
			            v_mensaje = 'RECI_NO_VACIO_IGUAL_ART_LOTE'; /* caso c */
				    	raise exception 'RECI_NO_VACIO_IGUAL_ART_LOTE-%',v_info_error;
					end if;
				else	
					if v_lotartIgual then
						v_artDif = false;
						v_lotDif = false;
					end if;
				end if;	
	
			end if;
				  
		exception	   
			when too_many_rows then
		        RAISE INFO 'PRDCRLO - error 9 - recipiente duplicado %', p_reci_id;
				v_mensaje = 'RECI_DUPLICADO';
		        raise exception 'RECI_DUPLICADO:%',p_reci_id;

			when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 2 - recipiente no encontrado %', p_reci_id;
				v_mensaje = 'RECI_NO_ENCONTRADO';
		        raise exception 'RECI_NO_ENCONTRADO:%',p_reci_id;
		       
		end;	

   /*******************************************
    * BLOQUE 2 CREO O REUTILIZO LOTE
    * 
    */
	
   /**
    * Una vez validado el recipiente, creo el nuevo lote
    * si forzar agregar = true, entonces
    *  para el caso a) crea un nuevo lote con mismo reci_id (unifica recipientes)
    *  para el caso b) crea un nuevo lote con mismo reci_id (unifica recipientes)
    *  para el caso c) actualiza la existencia del lote con mismo arti y lote (unifica lote)
     **/

    RAISE INFO 'PRDCRLO - BL2  lote -  v_estado_recipiente % v_artDif % v_lotDif % ', v_estado_recipiente,v_artDif,v_lotDif;
		
    if ( p_planificado = 'true' or ( v_estado_recipiente = 'VACIO' or  v_artDif or  v_lotDif ) )then
   
	begin
	
    		if p_batch_id is not null and p_batch_id != 0 then
    		/* me informan un batch id existente, viene de un batch guardado pero no iniciado, no lo inserto*/
    			RAISE INFO 'PRDCRLO - reu lote -  v_estado = %, p_lote_id % y v_batch_id %: ', v_estado, p_lote_id, p_batch_id;

    			v_batch_id = p_batch_id;
    			
    			with updated_batch as (
	    			update prd.lotes 
	    			set lote_id = p_lote_id
	    				,estado = v_estado
	    				,num_orden_prod = p_num_orden_prod
	    				,reci_id = p_reci_id
	    			where batch_id = v_batch_id
	    			returning 1)
	    			
				select count(1)
				from updated_batch
				into strict v_cuenta;

				if v_cuenta = 0 then
			    	    RAISE INFO 'PRDCLO - no se encontro el batch id % cuenta % ', p_batch_id,v_cuenta;
			    	    raise 'BATCH_NO_ENCONTRADO';
			    end if;
    			
				    		
    		else
    		    RAISE INFO 'PRDCRLO - ins lote -  p_lote_id % ', p_lote_id;

				with inserted_batch as (
					insert into 
					prd.lotes (
					lote_id
					,estado
					,num_orden_prod
					,etap_id
					,usuario_app
					,reci_id
					,empr_id)	
					values (
					p_lote_id
					,v_estado
					,p_num_orden_prod
					,p_etap_id
					,p_usuario_app
					,p_reci_id
					,p_empr_id
					)
					returning batch_id
				)

				select batch_id
				into strict v_batch_id
				from inserted_batch;

				RAISE INFO 'PRDCRLO - ins lote -  v_batch_id % ', v_batch_id;

			end if;
		
			/** si estay grabando planificado no debo lockear el recipiente */
			if v_estado != 'PLANIFICADO' then		
			    
			    /** Actualizo el recipiente como lleno
			     */
			    update prd.recipientes 
			    set estado = 'LLENO'
			    where reci_id = p_reci_id;

			end if;
						
		
	   exception
		   when others then
		        RAISE INFO 'PRDCRLO - error 5 - error creando lote y recipiente  %:% ',sqlstate,sqlerrm;
			v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO:%',sqlerrm;
		   end;
    else /** Existe un recipiente lleno con mismo arti_id y lote_id que el lote que queremos crear, no lo creo sino unifico **/
	begin
			RAISE INFO 'PRDCRLO - nada con lote -  p_forzar_agregar = %', p_forzar_agregar;

	        select lo.batch_id
	        into strict v_batch_id
	        from prd.lotes lo
	             ,alm.alm_lotes al
	        where reci_id  = p_reci_id
            and lo.lote_id = p_lote_id 
	        and al.arti_id = p_arti_id
			and lo.batch_id = al.batch_id
	        and lo.estado = 'En Curso';

	       	/** Venia de un lote planificado, que al unificarse con uno existente lo damos por finalizado */
	        if p_batch_id is not null and p_batch_id != '' then 
	        	update prd.lotes 
	        	set estado ='FINALIZADO'
	        	where batch_id = p_batch_id;
	        end if;

    exception
		   when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 20 - error buscando lote para unificar reci,lote,arti:%:%:% error %:% ',p_reci_id,p_lote_id,p_arti_id,sqlstate,sqlerrm;
			v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO:%',sqlerrm;
		   end;
				  
    end if;

   
    /********************************************************************************
     * BLOQUE 3: PADRES
     * ASOCIACION CON LOTES PADRE Y ACTUALIZACION ESTADOS Y DE CANTIDADES
     * 
     */
	RAISE INFO 'PRDCRLO - BL3 -  padres -  estado % batch id padre %',v_estado,p_batch_id_padre;
   
    if v_estado != 'PLANIFICADO' then

    	/** Actualizo el arbol de batchs colocando el 
	     *  nuevo batch como hijo del p_batch_id_padre
	     * si el padre viene en 0 es un batch al inicio 
	     * del proceso productivo 
	     */
		insert into prd.lotes_hijos (
		batch_id
		,batch_id_padre
		,empr_id
		,cantidad
		,cantidad_padre)
		values
		(v_batch_id
		,case when p_batch_id_padre = 0 then null else p_batch_id_padre end
		,p_empr_id
		,p_cantidad
		,p_cantidad_padre);
		
		RAISE INFO 'PRDCRLO - Batch id % generado en recipiente %',v_batch_id,p_reci_id;
	
	    /**Cambiamos el estado del lote origen a FINALIZADO si ya no quedan existencias
		 * y vacio el recipiente
		 */
		if (p_batch_id_padre !=0 and p_cantidad_padre != 0) then
		
			--Obtengo la existencia actual del padre para entender si finalizar
			v_cantidad_padre = alm.obtener_existencia_batch(p_batch_id_padre);
			
			RAISE INFO 'PRDCRLO - cantidad padre existente:informada %.%',v_cantidad_padre,p_cantidad_padre;
	
			if v_cantidad_padre - p_cantidad_padre = 0 then
		
				RAISE INFO 'PRDCRLO - Finalizando lote % ',p_batch_id_padre;
	
				update prd.lotes
				set estado = 'FINALIZADO'
				where batch_id = p_batch_id_padre
				returning reci_id into v_reci_id_padre;
				
				select count(1)
				into strict v_countLotesRec
				from prd.lotes
				where reci_id = v_reci_id_padre
				and estado = 'En Curso';
				
				/** Si no hay mas lotes activos en el recipiente lo pongo como VACIO **/
				if (v_countLotesRec = 0) then
					update prd.recipientes
					set estado = 'VACIO'
					where reci_id = v_reci_id_padre;
				end if;
			end if;
		
	
			/**
			 * Actualizo la existencia del padre
			 */
	
			RAISE INFO 'PRDCRLO - actualizo existencia %:% ',p_batch_id_padre,p_cantidad_padre;
	
			v_resultado = alm.extraer_lote_articulo(p_batch_id_padre,p_cantidad_padre);
		
		end if;
	    /**
	     * Genera el lote asociado en almacenes
	     *
	     */
	
    end if;	

	/*************************************************************************************
	 * BLOQUE 4: ACTUALIZACION DE LOTE DEL PRODUCTO EN PRODUCCION
	 * EN ALMACENES EN CASO DE INFORMARSE ARTI_ID 
	 * 
	 */
	RAISE INFO 'PRDCRLO - BL4 -  lote producto - p_arti_id % v_estado %',p_arti_id,v_estado;
   
	if p_arti_id != 0 and v_estado != 'PLANIFICADO' then --si se informa articulos del lote los inserto en alm_lotes, sino no

		/** mismas condiciones que al insertar batch para insertar lote almacen o actualizar**/
		if v_estado_recipiente = 'VACIO' or  v_artDif or  v_lotDif then
	    		
				v_resultado = alm.crear_lote_articulo(
										p_prov_id
										,p_arti_id 
										,v_depo_id
										,p_lote_id 
										,p_cantidad 
										,p_fec_vencimiento
										,p_empr_id 
										,v_batch_id );
		else
			    RAISE INFO 'PRDCRLO - es un batch existente, agrego cantidad % al batch %',p_cantidad,v_batch_id;
	    		v_resultado = alm.agregar_lote_articulo(v_batch_id ,p_cantidad);

		end if;						
		RAISE INFO 'PRDCRLO - resultado ops almacen %',v_resultado;

	end if;


	/*************************************************************************
	 * BLOQUE 5: ACTUALIZACION DE RECURSO DE TRABAJO EN CASO DE INFORMARSE
	 * 
	 */
    RAISE INFO 'PRDCRLO - BL5 RECURSO TRABAJO - recu_id %',p_recu_id;


	/** Si el actual lote tiene un recurso asociado lo asocio **/
    if p_recu_id is not null and p_recu_id != 0 then
    	
       begin

	       RAISE INFO 'PRDCRLO - p_recu_id = %', p_recu_id;

			/** Valido que el recursos  exista  **/
			select recu_id
			into strict v_recu_id
			from prd.recursos recu
			where recu.recu_id = p_recu_id;

			/** Eliminio todo si fue grabado como planificado**/
			delete from prd.recursos_lotes
			where batch_id = v_batch_id
			and tipo=p_tipo_recurso;

			/* Inserto el recurso **/
			insert into prd.recursos_lotes(batch_id
											,recu_id
											,empr_id
											,cantidad
											,tipo)
					values (v_batch_id
							,p_recu_id
							,p_empr_id
							,p_cantidad
							,p_tipo_recurso);
						
		exception	   
		
			when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 10 - recurso no encontrado %', p_recu_id;
				v_mensaje = 'RECU_NO_ENCONTRADO';
		        raise exception 'RECU_NO_ENCONTRADO:%',p_recu_id;
		       
		end;	

	end if;

	return v_batch_id;


exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
	    raise warning 'crear_lote: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;

END; 
$function$
;