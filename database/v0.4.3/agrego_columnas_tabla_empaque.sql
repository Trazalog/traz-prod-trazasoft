ALTER TABLE prd.empaque ADD tara float8 NULL;
ALTER TABLE prd.empaque ADD arti_id int NULL;
ALTER TABLE prd.empaque ADD CONSTRAINT empaque_fk FOREIGN KEY (arti_id) REFERENCES alm.alm_articulos(arti_id);
