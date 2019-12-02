CREATE OR REPLACE FUNCTION prd.asociar_lote_hijo_trg()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
  declare
  v_batch_id_hijo prd.lotes.batch_id%type;
  v_cantidad_hijo alm.alm_deta_entrega_materiales.cantidad%type;
  v_batch_id alm.alm_lotes.batch_id%type;
  v_mensaje varchar;
  v_aux int4;
  BEGIN
    /** primero obtengo el batch_id hijo
     * 
     */
	BEGIN  
		select batch_id
		into strict v_batch_id_hijo
		from alm.alm_pedidos_materiales pema
		     ,alm.alm_entrega_materiales enma
		where pema.pema_id = enma.pema_id
	    and enma.enma_id = new.enma_id;
	   
	   	raise info 'TRASLOHI: batch_id_hijo : %',v_batch_id_hijo;

	exception	
		when no_data_found then 
	        RAISE INFO 'TRASLOHI - error  - Entrega o pedido no existente %', new.enma_id;
			v_mensaje = 'ENMA_NO_ENCONTRADO';
	        raise exception 'ENMA_NO_ENCONTRADO:%',new.enma_id;
	end;
	
	/** Obtengo el batch id del lote de la linea entregada actual **/
	begin
		select batch_id
		into v_batch_id
		from alm.alm_lotes
		where lote_id = new.lote_id;

		raise info 'TRASLOHI: batch id actual : %',v_batch_id;

	exception	
		when no_data_found then 
	        RAISE INFO 'TRASLOHI - error  - alm lote inexistente %', new.lote_id;
			v_mensaje = 'ALOT_NO_ENCONTRADO';
	        raise exception 'ALOT_NO_ENCONTRADO:%',new.lote_id;
		
	end;
	
	/** Verifico si ya se asocio un batch_padre al hijo, sino inserto un registro nuevo de lote hijo**/

	begin
		select 1
		into strict v_aux
		from prd.lotes_hijos
		where batch_id = v_batch_id_hijo
		and batch_id_padre is null;
	
		raise info 'TRASLOHI: hay hijos sin padre con batch id : %',v_batch_id_hijo;

	    update prd.lotes_hijos
	    set batch_id_padre = v_batch_id
	    where batch_id = v_batch_id_hijo
	    and batch_id_padre is null;
	    
	exception
		when no_data_found then 
			/** El lote hijo ya tiene un padre, creo una nueva linea padre para el articulo actual**/
			raise info 'TRASLOHI: NO hay hijos sin padre con batch id : %',v_batch_id_hijo;

			select distinct(cantidad)
			into strict v_cantidad_hijo
			from prd.lotes_hijos
			where batch_id = v_batch_id_hijo;
			
			raise info 'TRASLOHI: cantidad hijo : %',v_cantidad_hijo;
			insert into prd.lotes_hijos
			(batch_id
			 ,batch_id_padre
			 ,empr_id
			 ,cantidad
			 ,cantidad_padre)	
			values(
			v_batch_id_hijo
			,v_batch_id
			,new.empr_id
			,v_cantidad_hijo
			,new.cantidad);

	end;
    
    return new;


exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
	    raise warning 'TRASLOHI: error actualizando lotes hijos %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;
end;

$function$
;

CREATE OR REPLACE FUNCTION prd.cambiar_recipiente(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying, p_cantidad double precision DEFAULT 0)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
#print_strict_params on

declare
	v_result_lote varchar;
	v_mensaje varchar;
	v_updated integer; 
	v_lote_id prd.lotes.lote_id%type;
	v_num_orden_prod prd.lotes.num_orden_prod%type;
    v_depo_id_destino alm.alm_depositos.depo_id%type;
    v_arti_id prd.lotes.arti_id%type;
    v_prov_id alm.alm_lotes.prov_id%type;
    v_fec_vencimiento alm.alm_lotes.fec_vencimiento%type;
    v_existencia alm.alm_lotes.cantidad%type;
begin

		begin
	        RAISE INFO 'seleccionando datos para lote = %, p_lote_id', p_batch_id_origen;

		   /** tomos los datos del lote de origen a copiar en el nuevo lote **/
		    select lo.lote_id
		    	,lo.num_orden_prod
		    	,lo.arti_id
		    	,al.prov_id
		    	,al.fec_vencimiento
		    into strict v_lote_id
		    	 , v_num_orden_prod
		    	 , v_arti_id
		    	 , v_prov_id
		    	 , v_fec_vencimiento
		    from prd.lotes lo
		    	, alm.alm_lotes al
		    where lo.batch_id = p_batch_id_origen
		    and al.batch_id = lo.batch_id;
		   
	        RAISE INFO 'batch, lote y ord prod = %, % , %', p_batch_id_origen,v_lote_id,v_num_orden_prod;

       	exception	   
			when NO_DATA_FOUND then
		        RAISE INFO 'batch no existe %', p_batch_id_origen;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO:%',p_batch_id_origen;
		       
		end;	

	    begin
	        /** obtengo el deposito de destino del recipiente
	         * de destino
	         */
		    select reci.depo_id
		    into strict v_depo_id_destino
		    from prd.recipientes reci
		    where reci.reci_id = p_reci_id_destino;

	   exception	   
			when NO_DATA_FOUND then
		        RAISE INFO 'recipiente no existe %', p_reci_id_destino;
				v_mensaje = 'RECI_NO_ENCONTRADO';
		        raise exception 'RECI_NO_ENCONTRADO:%',p_reci_id_destino;
		       
		end;	
	
		/* Si la cantidad informada es 0, hay que vaciar el lote entero y llevarlo al nuevo recipiente,
		 * sino descuento parcial
		 */
	
		v_existencia = alm.obtener_existencia_batch(p_batch_id_origen);

	 	/* si la cantidad es mayor a la existencia abortamos, sino uso la variable v_existencia para descontar
	 	 * con el valor solicitado por parametro
	 	 */
		if p_cantidad != 0 then
			if p_cantidad > v_existencia then	
			    RAISE INFO 'cantidad mayor a existencia %:%',p_cantidad,v_existencia;
				v_mensaje = 'CANT_MAYOR_EXISTENCIA';
		        raise exception 'CANT_MAYOR_EXISTENCIA:%:%',p_cantidad,v_existencia;
		    else
				v_existencia = p_cantidad;
			end if;
		end if;
	
		/** Crea el batch
		 *  para el movimiento de destino
		 */	   
	   	v_result_lote =
		   	prd.crear_lote(
		   	v_lote_id
		   	,v_arti_id
		   	,v_prov_id
		   	,p_batch_id_origen
		   	,v_existencia
		   	,v_existencia
		   	,v_num_orden_prod  
		   	,p_reci_id_destino 
		   	,p_etap_id_destino
		   	,p_usuario_app 
		   	,p_empre_id
		   	,p_forzar_agregar
		    ,v_fec_vencimiento);
	
	
		return 'CORRECTO';
exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
		raise warning 'cambiar_recipiente: error al crear lote %: %', sqlstate,sqlerrm;

		v_mensaje=sqlerrm;
		if v_mensaje is null or v_mensaje = '' then	
	    	raise '>>TOOLSERROR:ERROR_INTERNO<<';
	    else
	    	raise '>>TOOLSERROR:%<<',v_mensaje;
	    end if;
END; 
$function$
;

CREATE OR REPLACE FUNCTION prd.crear_lote(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying DEFAULT 'false'::character varying, p_fec_vencimiento date DEFAULT NULL::date, p_recu_id integer DEFAULT NULL::integer, p_tipo_recurso character varying DEFAULT NULL::character varying)
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
 v_mensaje varchar;
 v_reci_id_padre prd.recipientes.reci_id%type;
 v_depo_id prd.recipientes.depo_id%type;
 v_lote_id prd.lotes.lote_id%type;
 v_arti_id alm.alm_lotes.arti_id%type;
 v_cantidad_padre alm.alm_lotes.cantidad%type;
 v_recu_id prd.recursos_lotes.recu_id%type;
 v_resultado varchar;
BEGIN


		begin
	        RAISE INFO 'PRDCRLO - ṕ_forzar_agregar = %, p_lote_id % y p_batch_id_padre %: ', p_forzar_agregar, p_lote_id, p_batch_id_padre;

			select reci.estado
				   ,reci.depo_id
			into strict v_estado_recipiente
				,v_depo_id
			from PRD.RECIPIENTES reci
			where reci.reci_id = p_reci_id;

			/** Valido que el recipiente exista y no tenga contenido **/
		    if (p_forzar_agregar!='true') then
				
				    if v_estado_recipiente != 'VACIO' then
		
				        RAISE INFO 'PRDCRLO - error 1 - recipiente lleno , estado = % ', v_estado_recipiente;
		                v_mensaje = 'RECI_NO_VACIO';
				    	raise exception 'RECI_NO_VACIO:%',p_reci_id;
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

   /**
	 * Una vez validado el recipiente, creo el nuevo lote
	 */		
		
    if (p_forzar_agregar='true') then
	    RAISE INFO 'PRDCRLO - 2 - ṕ_forzar_agregar = %, p_lote_id % y p_batch_id_padre %: ', p_forzar_agregar, p_lote_id, p_batch_id_padre;

        begin
	        select lo.batch_id
	        	   ,lo.lote_id
	        	   ,al.arti_id
	        into strict v_batch_id
	        	 ,v_lote_id
	        	 ,v_arti_id
	        from prd.lotes lo
	             ,alm.alm_lotes al
	        where reci_id  = p_reci_id
	        and lo.batch_id = al.batch_id
	        and lo.estado = 'En Curso';

	     /**
	      * Valido que si se quieren unir lotes, coincida el articulo y el nuemro de lote
	      */
	    if v_arti_id != p_arti_id or p_lote_id != v_lote_id then
		        RAISE INFO 'PRDCRLO - error 3 el articulo y lote destino %:% son != de los solicitados %,%',v_arti_id,v_lote_id,p_arti_id,p_lote_id;
				v_mensaje = 'ART_O_LOTE_DISTINTO';
				raise exception 'ART_O_LOTE_DISTINTO:%-%-%-%',v_arti_id,v_lote_id,p_arti_id,p_lote_id;
	    end if;
	       
	    exception
		   when TOO_MANY_ROWS then
		        RAISE INFO 'PRDCRLO - error 20 = %',sqlerrm;
				v_mensaje = 'RECI_DUPLICADO';
				raise exception 'RECI_DUPLICADO:%',p_reci_id;

	    	when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 4 = %',sqlerrm;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
				raise exception 'BATCH_NO_ENCONTRADO:%',sqlerrm;
        end;
	       
    else
		begin
    		RAISE INFO 'PRDCRLO - p_forzar_agregar = %, p_lote_id % y p_batch_id_padre %: ', p_forzar_agregar, p_lote_id, p_batch_id_padre;
	
		    /** Inserto en la tabla de batch, creando el batch_id
		     * de la secuencia de lotes
		     */
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
				,'En Curso'
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
		    
		    /** Actualizo el recipiente como lleno
		     */
		    update prd.recipientes 
		    set estado = 'LLENO'
		    where reci_id = p_reci_id;

	   exception
		   when others then
		        RAISE INFO 'PRDCRLO - error 5 - error creando lote y recipiente  %:% ',sqlstate,sqlerrm;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO:%',sqlerrm;
		   end;
		  
    end if;
		
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
	
		--Obtengo la exisstencia actual del padre para entender si finalizar
		v_cantidad_padre = alm.obtener_existencia_batch(p_batch_id_padre);
		
		RAISE INFO 'PRDCRLO - cantidad padre existente:informada %.%',v_cantidad_padre,p_cantidad_padre;

		if v_cantidad_padre - p_cantidad_padre = 0 then
	
			RAISE INFO 'PRDCRLO - Finalizando lote % ',p_batch_id_padre;

			update prd.lotes
			set estado = 'FINALIZADO'
			where batch_id = p_batch_id_padre
			returning reci_id into v_reci_id_padre;
	
			update prd.recipientes
			set estado = 'VACIO'
			where reci_id = v_reci_id_padre;
		end if;
	

		/**
		 * Actualizo la existencia del padre
		 */

		RAISE INFO 'PRDCRLO - actualizo existencia %:% ',p_batch_id_padre,p_cantidad_padre;

		v_resultado = alm.extraer_lote_articulo(p_batch_id_padre
												,p_cantidad_padre);
	
	end if;
    /**
     * Genera el lote asociado en almacenes
     *
     */
	if p_arti_id != 0 then --si se informa articulos del lote los inserto en alm_lotes, sino no
	    if (p_forzar_agregar='true') then
	
	    	RAISE INFO 'PRDCRLO - forzar agregar es true, agrego cantidad % al batch %',p_cantidad,v_batch_id;
	    	v_resultado = alm.agregar_lote_articulo(v_batch_id
													,p_cantidad);
		else
	    	RAISE INFO 'PRDCRLO - forzar agregar es false, ingreso cantidad % al batch %',p_cantidad,v_batch_id;
	 
			v_resultado = alm.crear_lote_articulo(
									p_prov_id
									,p_arti_id 
									,v_depo_id
									,p_lote_id 
									,p_cantidad 
									,p_fec_vencimiento
									,p_empr_id 
									,v_batch_id );
		end if;						
	end if;

	RAISE INFO 'PRDCRLO - resultado ops almacen %',v_resultado;

	/** Si el actual lote tiene un recurso asociado lo asocio **/
    if p_recu_id is not null and p_recu_id != 0 then
    	
       begin
    		RAISE INFO 'PRDCRLO - p_recu_id = %', p_recu_id;

			/** Valido que el recursos  exista  **/
			select recu_id
			into strict v_recu_id
			from prd.recursos recu
			where recu.recu_id = p_recu_id;

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

CREATE OR REPLACE FUNCTION prd.crear_prd_recurso_trg()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
  DECLARE
  BEGIN
    /** funcion para utilizarse on insert para insertar el articulo como recurso
     * 
     */
    INSERT INTO prd.recursos
    (tipo
     ,arti_id
     ,empr_id
     )
    values
    ('MATERIAL'
     ,new.arti_id
     ,new.empr_id);

    return new;
    END;
$function$
;

CREATE OR REPLACE FUNCTION prd.eliminar_prd_recurso_trg()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
  DECLARE
  BEGIN
    /** funcion para utilizarse on insert para insertar el articulo como recurso
     * 
     */
    delete from prd.recursos
    where arti_id = old.arti_id;
   
	return new;
    END;
$function$
;

