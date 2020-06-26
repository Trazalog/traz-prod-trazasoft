

CREATE TABLE prd.etapas_salidas (
	etap_id int4 NOT NULL,
	arti_id int4 NOT NULL,
	CONSTRAINT etapas_salidas_un UNIQUE (etap_id, arti_id)
);

ALTER TABLE prd.etapas_materiales DROP CONSTRAINT "etapa-arti_id_fk";
ALTER TABLE prd.etapas_materiales ADD CONSTRAINT etapas_materiales_etap_id_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id);
ALTER TABLE prd.etapas_materiales ADD CONSTRAINT etapas_materiales_arti_id_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
ALTER TABLE prd.etapas_productos ADD CONSTRAINT etapas_productos_etap_id_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id);
ALTER TABLE prd.etapas_productos ADD CONSTRAINT etapas_productos_arti_id_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
ALTER TABLE prd.etapas_salidas ADD CONSTRAINT etapas_salidas_etap_id_fk FOREIGN KEY (etap_id) REFERENCES prd.etapas(etap_id);
ALTER TABLE prd.etapas_salidas ADD CONSTRAINT etapas_salidas_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);

