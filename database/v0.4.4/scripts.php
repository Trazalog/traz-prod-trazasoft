ALTER TABLE tst.tareas_planificadas ADD proc_id varchar NULL;
ALTER TABLE tst.tareas_planificadas ADD form_id int NULL;
ALTER TABLE tst.tareas_planificadas ADD rece_id int NULL;

CREATE OR REPLACE FUNCTION alm.fnupdateresto()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
	BEGIN
		update alm.alm_deta_pedidos_materiales set resto = new.cantidad
		where depe_id = new.depe_id;
	    return new; 
	END;
$function$
;

CREATE OR REPLACE FUNCTION alm.fnupdateresto()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
	BEGIN
		update alm.alm_deta_pedidos_materiales set resto = new.cantidad
		where depe_id = new.depe_id;
	    return new; 
	END;
$function$
;

ALTER TABLE frm.formularios ADD empr_id int4 NULL;
ALTER TABLE prd.etapas ADD form_id int4 NULL;

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

-- tst.tareas_planificadas definition

-- Drop table

-- DROP TABLE tst.tareas_planificadas;


-- tst.rel_tareas_pedidos definition

-- Drop table

-- DROP TABLE tst.rel_tareas_pedidos;

CREATE TABLE tst.rel_tareas_pedidos (
	tapl_id int4 NOT NULL,
	pema_id int4 NOT NULL,
	CONSTRAINT newtable_pk PRIMARY KEY (tapl_id, pema_id)
);


-- tst.rel_tareas_pedidos foreign keys

ALTER TABLE tst.rel_tareas_pedidos ADD CONSTRAINT newtable_fk FOREIGN KEY (tapl_id) REFERENCES tst.tareas_planificadas(tapl_id);
ALTER TABLE tst.rel_tareas_pedidos ADD CONSTRAINT newtable_fk_1 FOREIGN KEY (pema_id) REFERENCES alm.alm_pedidos_materiales(pema_id);

ALTER TABLE tst.tareas_planificadas ADD info_id int4 NULL;

ALTER TABLE tst.tareas_planificadas ADD eliminado bool NOT NULL DEFAULT false;

ALTER TABLE tst.tareas_planificadas ADD estado varchar NOT NULL DEFAULT 'creada'::character varying;

ALTER TABLE tst.tareas_planificadas ADD fec_inicio timestamp NULL;

ALTER TABLE tst.tareas_planificadas ADD fec_fin timestamp NULL;

ALTER TABLE tst.tareas_planificadas ADD proc_id varchar NULL;

ALTER TABLE tst.tareas_planificadas ADD form_id int4 NULL;

ALTER TABLE tst.tareas_planificadas ADD descripcion varchar NULL;

ALTER TABLE tst.tareas_planificadas ADD rece_id int4 NULL;