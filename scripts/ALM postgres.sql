CREATE TABLE alm_articulos (
 arti_id serial  NOT NULL,
 barcode varchar(50)  NOT NULL,
 descripcion varchar(50)  NOT NULL,
 costo decimal(14,2) NOT NULL,
 es_caja bool NOT NULL,
 cantidad_caja int4  DEFAULT NULL,
 punto_pedido int4  DEFAULT NULL,
 estado varchar(45)  DEFAULT 'AC',
 unidad_medida varchar(45)  NOT NULL,
 empr_id int4  NOT NULL,
 es_loteado bool NOT NULL,
 fec_alta timestamp DEFAULT CURRENT_TIMESTAMP,
 eliminado bool NOT NULL DEFAULT '0',
 PRIMARY KEY(arti_id)
);

CREATE TABLE alm_depositos (
 depo_id serial NOT NULL,
 descripcion varchar(255) DEFAULT NULL,
 direccion varchar(255) DEFAULT NULL,
 GPS varchar(255) DEFAULT NULL,
 estado int4  DEFAULT NULL,
 loca_id varchar(255) DEFAULT NULL,
 esta_id varchar(255) DEFAULT NULL,
 pais_id varchar(255) DEFAULT NULL,
 empr_id int4  NOT NULL,
 fec_alta timestamp DEFAULT CURRENT_TIMESTAMP,
 eliminado bool NOT NULL DEFAULT '0',
 PRIMARY KEY(depo_id)
);

CREATE TABLE alm_deta_entrega_materiales (
 deen_id serial  NOT NULL ,
 enma_id int4  NOT NULL,
 cantidad int4  NOT NULL,
 arti_id int4  NOT NULL,
 prov_id int4  DEFAULT NULL,
 lote_id int4  NOT NULL,
 depo_id int4  DEFAULT NULL,
 empr_id int4  NOT NULL,
 precio double DEFAULT NULL,
 fec_alta timestamp DEFAULT CURRENT_TIMESTAMP,
 eliminado bool DEFAULT '0',
  PRIMARY KEY (deen_id)
);

CREATE TABLE alm_deta_pedidos_materiales (
 depe_id serial  NOT NULL ,
 cantidad int4  DEFAULT NULL,
 resto int4  DEFAULT NULL,
 fecha_entrega date DEFAULT NULL,
 fecha_entregado date DEFAULT NULL,
 pema_id int4  NOT NULL,
 arti_id int4  NOT NULL,
 fec_alta timestamp DEFAULT CURRENT_TIMESTAMP,
 eliminado bool DEFAULT '0',
  PRIMARY KEY (depe_id)
);

CREATE TABLE alm_deta_recepcion_materiales (
 dere_id serial  NOT NULL ,
 cantidad double NOT NULL,
 precio double NOT NULL,
 empr_id int4  NOT NULL,
 rema_id int4  NOT NULL,
 lote_id int4  NOT NULL,
 prov_id int4  NOT NULL,
 arti_id int4  NOT NULL,
 fec_alta timestamp DEFAULT CURRENT_TIMESTAMP,
 eliminado bool DEFAULT '0',
  PRIMARY KEY (dere_id)
);

CREATE TABLE alm_entrega_materiales (
 enma_id serial  NOT NULL ,
 fecha date DEFAULT NULL,
 solicitante varchar(100)  DEFAULT NULL,
 dni varchar(45)  DEFAULT NULL,
 comprobante varchar(50)  DEFAULT NULL,
 empr_id int4  NOT NULL,
 pema_id int4  DEFAULT NULL,
 fec_alta timestamp DEFAULT CURRENT_TIMESTAMP,
 eliminado bool DEFAULT '0',
  PRIMARY KEY (enma_id)
);


CREATE TABLE alm_lotes (
 lote_id serial  NOT NULL ,
 prov_id int4  NOT NULL,
 arti_id int4  NOT NULL,
 depo_id int4  NOT NULL,
 codigo varchar(255) DEFAULT NULL,
 fec_vencimiento date DEFAULT NULL,
 cantidad float DEFAULT NULL,
 empr_id int4  NOT NULL,
 user_id int4  DEFAULT NULL,
 estado int4  DEFAULT NULL,
 fec_alta timestamp DEFAULT CURRENT_TIMESTAMP,
 eliminado bool DEFAULT '0',
  PRIMARY KEY (lote_id)
);


CREATE TABLE alm_pedidos_extraordinario (
 peex_id serial  NOT NULL,
 fecha date DEFAULT NULL,
 detalle varchar(200) CREATE TABLE  DEFAULT NULL,
 motivo_rechazo varchar(200) CREATE TABLE  DEFAULT NULL,
 case_id int4  DEFAULT NULL,
 pema_id int4  DEFAULT NULL,
 ortr_id int4  DEFAULT NULL,
 empr_id int4  DEFAULT NULL,
 fec_alta timestamp DEFAULT CURRENT_TIMESTAMP,
 eliminado bool DEFAULT '0',
 PRIMARY KEY(peex_id)
);


CREATE TABLE alm_pedidos_materiales (
 pema_id serial  NOT NULL ,
 fecha date NOT NULL,
 motivo_rechazo varchar(500)  DEFAULT NULL,
 justificacion varchar(300)  DEFAULT NULL,
 case_id int4  DEFAULT NULL,
 ortr_id int4  DEFAULT NULL,
 estado varchar(45)  DEFAULT NULL,
 empr_id int4  DEFAULT NULL,
 fec_alta timestamp DEFAULT CURRENT_TIMESTAMP,
 eliminado bool DEFAULT '0',
  PRIMARY KEY (pema_id)
);


CREATE TABLE alm_proveedores (
 prov_id int4  NOT NULL,
 nombre varchar(255) DEFAULT NULL,
 cuit varchar(50) DEFAULT NULL,
 domicilio varchar(255) DEFAULT NULL,
 telefono varchar(50) DEFAULT NULL,
 email varchar(100) DEFAULT NULL,
 empr_id int4  NOT NULL,
 fec_alta timestamp DEFAULT CURRENT_TIMESTAMP,
 eliminado bool DEFAULT '0',
 PRIMARY KEY(prov_id)
);


CREATE TABLE alm_proveedores_articulos (
 prov_id int4  NOT NULL,
 arti_id int4  NOT NULL,
 PRIMARY KEY(prov_id, arti_id)
);


CREATE TABLE alm_recepcion_materiales (
 rema_id serial  NOT NULL ,
 fecha timestamp NOT NULL,
 comprobante varchar(255)  NOT NULL,
 empr_id int4  NOT NULL,
 prov_id int4  NOT NULL,
 fec_alta timestamp DEFAULT CURRENT_TIMESTAMP,
 eliminado bool DEFAULT '0',
  PRIMARY KEY (rema_id)
);


ALTER TABLE public.alm_deta_pedidos_materiales ADD CONSTRAINT alm_deta_pedidos_materiales_fk FOREIGN KEY (arti_id) REFERENCES public.alm_articulos(arti_id);
ALTER TABLE public.alm_deta_pedidos_materiales ADD CONSTRAINT alm_deta_pedidos_materiales_fk_1 FOREIGN KEY (pema_id) REFERENCES public.alm_pedidos_materiales(pema_id);
ALTER TABLE public.alm_entrega_materiales ADD CONSTRAINT alm_entrega_materiales_fk FOREIGN KEY (pema_id) REFERENCES public.alm_pedidos_materiales(pema_id);
ALTER TABLE public.alm_lotes ADD CONSTRAINT alm_lotes_fk FOREIGN KEY (prov_id,arti_id) REFERENCES public.alm_proveedores_articulos(prov_id,arti_id);
ALTER TABLE public.alm_proveedores_articulos ADD CONSTRAINT alm_proveedores_articulos_fk FOREIGN KEY (arti_id) REFERENCES public.alm_articulos(arti_id);
ALTER TABLE public.alm_proveedores_articulos ADD CONSTRAINT alm_proveedores_articulos_fk_1 FOREIGN KEY (prov_id) REFERENCES public.alm_proveedores(prov_id);
ALTER TABLE public.alm_recepcion_materiales ADD CONSTRAINT alm_recepcion_materiales_fk FOREIGN KEY (prov_id) REFERENCES public.alm_proveedores(prov_id);
