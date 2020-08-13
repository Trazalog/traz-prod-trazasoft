ALTER TABLE prd.recipientes ADD "row" int4 NULL;

ALTER TABLE prd.recipientes ADD col int4 NULL;

ALTER TABLE prd.recipientes ADD care_id varchar NOT NULL DEFAULT 'cate_recipienteBOX'::character varying;

ALTER TABLE alm.alm_depositos ADD "row" int4 NULL;

ALTER TABLE alm.alm_depositos ADD col int4 NULL;

INSERT INTO core.tablas (tabl_id,tabla,valor,valor2,valor3,descripcion,fec_alta,usuario,eliminado) VALUES 
('cate_recipienteBOX','cate_recipiente','BOX',NULL,NULL,'Box','2020-07-20 18:40:41.935','postgres',false)
,('cate_recipienteBIN','cate_recipiente','BIN',NULL,NULL,NULL,'2020-07-20 18:40:42.310','postgres',false)
;
ALTER TABLE prd.recipientes ADD CONSTRAINT recipientes_alm_depositos_fk FOREIGN KEY (depo_id) REFERENCES alm.alm_depositos(depo_id);

ALTER TABLE prd.recipientes ADD CONSTRAINT recipientes_care_id_fk FOREIGN KEY (care_id) REFERENCES core.tablas(tabl_id);


