CREATE OR REPLACE FUNCTION prd.cambiar_recipiente(p_batch_id_origen bigint, p_reci_id_destino integer, p_etap_id_destino integer, p_empre_id integer, p_usuario_app character varying, p_forzar_agregar character varying)
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
		        RAISE INFO 'batch no existe %', p_batch_id;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
		        raise exception 'BATCH_NO_ENCONTRADO';
		       
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
		        raise exception 'RECI_NO_ENCONTRADO';
		       
		end;	
		   
		v_existencia = alm.obtener_existencia_batch(p_batch_id_origen);
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
	

		if v_result_lote = 'RECI_NO_VACIO' 
			or v_result_lote = 'RECI_NO_ENCONTRADO' 
			or v_result_lote = 'BATCH_NO_ENCONTRADO' 
			or v_result_lote = 'BATCH_NO_CREADO' then
				RAISE INFO 'error al crear batch %', v_result_lote;
				v_mensaje = v_result_lote;
	    		raise 'BATCH_NO_CREADO : %',v_mensaje;
		end if;
	

	
		return 'CORRECTO';
exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
	    raise warning 'cambiar_recipiente: error al crear lote %: %', sqlstate,sqlerrm;
	    if v_mensaje is null or v_mensaje = '' then	
	    	return sqlerrm;
	    else
	    	return v_mensaje;
	    end if;
END; 
$function$
;

CREATE OR REPLACE FUNCTION prd.crear_lote(p_lote_id character varying, p_arti_id integer, p_prov_id integer, p_batch_id_padre bigint, p_cantidad double precision, p_cantidad_padre double precision, p_num_orden_prod character varying, p_reci_id integer, p_etap_id integer, p_usuario_app character varying, p_empr_id integer, p_forzar_agregar character varying DEFAULT 'false'::character varying, p_fec_vencimiento date DEFAULT NULL::date)
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
				    	raise exception 'RECI_NO_VACIO';
				    end if;
				   
		    end if;
		exception	   
			when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 2 - recipiente no encontrado %', p_reci_id;
				v_mensaje = 'RECI_NO_ENCONTRADO';
		        raise exception 'RECI_NO_ENCONTRADO';
		       
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
				raise exception 'ART_O_LOTE_DISTINTO';
	    end if;
	       
	    exception
		   when NO_DATA_FOUND then
		        RAISE INFO 'PRDCRLO - error 4 = %',sqlerrm;
				v_mensaje = 'BATCH_NO_ENCONTRADO';
				raise exception 'BATCH_NO_ENCONTRADO';
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
		        raise exception 'BATCH_NO_ENCONTRADO';
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

	RAISE INFO 'PRDCRLO - resultado ops almacen %',v_resultado;
	
	return v_batch_id;


exception
	when others then
	    /** capturo cualquier posible excepcion y la retorno como respuesta **/
	    raise warning 'crear_lote: error al crear lote %: %', sqlstate,sqlerrm;
	    if v_mensaje is null or v_mensaje = '' then
	    	return sqlerrm;
	    else
	    	return v_mensaje;
	    end if;
END; 
$function$
;

