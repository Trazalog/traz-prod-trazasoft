CREATE OR REPLACE FUNCTION alm.agregar_lote_articulo(p_batch_id bigint, p_cantidad double precision)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
/**
 * Función para actualizar un lote de almacen con p_batch_id
 * Si no encuentra el lote lanza excepcion BATCH_NO_EXISTE
 */
declare
	v_cuenta integer; 
	v_existencia alm.alm_lotes.cantidad%type;
begin
	with updated_lotes as (	
		update alm.alm_lotes
		set cantidad = cantidad + p_cantidad
		where batch_id = p_batch_id
		returning 1,cantidad)
		
	select count(1)
	from updated_lotes
	into strict v_cuenta
				,v_existencia;

	if v_cuenta = 0 then
    	    RAISE INFO 'ALMEXLO - no se encontro el batch id % ', p_batch_id;
    	    raise 'BATCH_INEXISTENTE';
    end if;

   	RAISE INFO 'ALMEXLO - actualizando el batch id % con cantidad %', p_batch_id,v_existencia;
    return 'CORRECTO';

exception
		when others then 
			raise;
end;
		
$function$
;

CREATE OR REPLACE FUNCTION alm.crear_lote_articulo(p_prov_id integer, p_arti_id integer, p_depo_id integer, p_codigo character varying, p_cantidad double precision, p_fec_vencimiento date, p_empr_id integer, p_batch_id bigint)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
/**
 * Crea un nuevo lote para un articulo determinado en el deposito informado
 */
begin

	insert into alm.alm_lotes (
	prov_id
	,arti_id
	,depo_id
	,codigo
	,cantidad
	,fec_vencimiento
	,empr_id
	,estado
	,batch_id)
	VALUES( 
	p_prov_id
	,p_arti_id
	,p_depo_id
	,p_codigo
	,p_cantidad
	,p_fec_vencimiento
	,p_empr_id
	,'AC'
	,p_batch_id);

	return 'CORRECTO';

exception
	when unique_violation then 
		RAISE INFO 'error al insertar % : %',sqlerrm,sqlstate;
    	RAISE 'DUP_VAL_LOTALM';
    
    when others then 
		RAISE INFO 'error al insertar % : %',sqlerrm,sqlstate;
    	RAISE;
end;
	-- Enter function body here
$function$
;

CREATE OR REPLACE FUNCTION alm.extraer_lote_articulo(p_batch_id bigint, p_cantidad double precision)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
/**
 * Función para actualizar un lote de almacen con p_batch_id
 * Si no encuentra el lote lanza excepcion BATCH_NO_EXISTE
 */
declare
	v_updated integer; 
	v_existencia alm.alm_lotes.cantidad%type;
begin
	
	select cantidad
	into strict v_existencia
	from alm.alm_lotes
	where batch_id = p_batch_id;

	if v_existencia >= p_cantidad then
		update alm.alm_lotes
		set cantidad = cantidad - p_cantidad
		where batch_id = p_batch_id;
	else 
    	    RAISE INFO 'ALMEXLO - la cantidad no puede ser negativa  existencia % ', v_existencia;
    	    raise 'CANT_MAYOR_EXISTENCIA';
    end if;

    return 'CORRECTO';

	exception
		when NO_DATA_FOUND then 
	 	  RAISE INFO 'ALMEXLO - batch no encontrado %', p_batch_id;
    	  raise 'BATCH_NO_EXISTE';
		when others then 
			raise;
end;
		
$function$
;

CREATE OR REPLACE FUNCTION alm.obtener_existencia_batch(p_batch_id bigint)
 RETURNS double precision
 LANGUAGE plpgsql
AS $function$
declare	
	v_cantidad alm.alm_lotes.cantidad%type =0;
begin
	select sum(cantidad)
	into strict v_cantidad
	from alm.alm_lotes
	where batch_id = p_batch_id;

	return v_cantidad;
exception
	when no_data_found then	
		raise 'BATCH_INEXISTENTE';

end;

$function$
;

