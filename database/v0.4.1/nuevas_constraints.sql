ALTER TABLE alm.alm_pedidos_materiales ADD CONSTRAINT alm_pedidos_materiales_batch_id_fk FOREIGN KEY (batch_id) REFERENCES prd.lotes(batch_id);
ALTER TABLE alm.alm_articulos ADD CONSTRAINT alm_articulos_un UNIQUE (barcode);
