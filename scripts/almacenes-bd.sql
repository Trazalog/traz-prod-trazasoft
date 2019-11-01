-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-10-2019 a las 16:54:59
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: 'planner_assetcloud_integracion'
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'alm_articulos'
--

CREATE TABLE 'alm_articulos' (
  'arti_id' int(11) NOT NULL,
  'barcode' varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  'descripcion' varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  'costo' decimal(14,2) NOT NULL,
  'es_caja' tinyint(4) NOT NULL,
  'cantidad_caja' int(11) DEFAULT NULL,
  'punto_pedido' int(11) DEFAULT NULL,
  'estado_id' varchar(45) COLLATE utf8_spanish_ci DEFAULT '1',
  'unidad_id' int(11) NOT NULL,
  'empr_id' int(11) NOT NULL,
  'es_loteado' tinyint(4) NOT NULL,
  'fec_alta' datetime DEFAULT CURRENT_TIMESTAMP,
  'eliminado' tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'alm_depositos'
--

CREATE TABLE 'alm_depositos' (
  'depo_id' int(11) NOT NULL,
  'descripcion' varchar(255) DEFAULT NULL,
  'direccion' varchar(255) DEFAULT NULL,
  'GPS' varchar(255) DEFAULT NULL,
  'estado_id' int(11) DEFAULT NULL,
  'loca_id' varchar(255) DEFAULT NULL,
  'esta_id' varchar(255) DEFAULT NULL,
  'pais_id' varchar(255) DEFAULT NULL,
  'empr_id' int(11) NOT NULL,
  'fec_alta' datetime DEFAULT CURRENT_TIMESTAMP,
  'eliminado' tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'alm_deta_entrega_materiales'
--

CREATE TABLE 'alm_deta_entrega_materiales' (
  'deen_id' int(11) NOT NULL,
  'enma_id' int(11) NOT NULL,
  'cantidad' int(11) NOT NULL,
  'arti_id' int(11) NOT NULL,
  'prov_id' int(10) DEFAULT NULL,
  'lote_id' int(11) NOT NULL,
  'depo_id' int(11) DEFAULT NULL,
  'empr_id' int(11) NOT NULL,
  'precio' double DEFAULT NULL,
  'fec_alta' datetime DEFAULT CURRENT_TIMESTAMP,
  'eliminado' tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'alm_deta_pedidos_materiales'
--

CREATE TABLE 'alm_deta_pedidos_materiales' (
  'depe_id' int(11) NOT NULL,
  'cantidad' int(11) DEFAULT NULL,
  'resto' int(11) DEFAULT NULL,
  'fecha_entrega' date DEFAULT NULL,
  'fecha_entregado' date DEFAULT NULL,
  'pema_id' int(11) NOT NULL,
  'arti_id' int(11) NOT NULL,
  'fec_alta' datetime DEFAULT CURRENT_TIMESTAMP,
  'eliminado' tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'alm_deta_recepcion_materiales'
--

CREATE TABLE 'alm_deta_recepcion_materiales' (
  'dere_id' int(11) NOT NULL,
  'cantidad' double NOT NULL,
  'precio' double NOT NULL,
  'empr_id' int(11) NOT NULL,
  'rema_id' int(11) NOT NULL,
  'lote_id' int(11) NOT NULL,
  'prov_id' int(10) NOT NULL,
  'arti_id' int(11) NOT NULL,
  'fec_alta' datetime DEFAULT CURRENT_TIMESTAMP,
  'eliminado' tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'alm_entrega_materiales'
--

CREATE TABLE 'alm_entrega_materiales' (
  'enma_id' int(11) NOT NULL,
  'fecha' date DEFAULT NULL,
  'solicitante' varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  'dni' varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  'comprobante' varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  'empr_id' int(11) NOT NULL,
  'pema_id' int(11) DEFAULT NULL,
  'fec_alta' datetime DEFAULT CURRENT_TIMESTAMP,
  'eliminado' tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'alm_lotes'
--

CREATE TABLE 'alm_lotes' (
  'lote_id' int(11) NOT NULL,
  'prov_id' int(10) NOT NULL,
  'arti_id' int(11) NOT NULL,
  'depo_id' int(11) NOT NULL,
  'codigo' varchar(255) DEFAULT NULL,
  'fec_vencimiento' date DEFAULT NULL,
  'cantidad' float DEFAULT NULL,
  'empr_id' int(11) NOT NULL,
  'user_id' int(11) DEFAULT NULL,
  'estado_id' int(11) DEFAULT NULL,
  'fec_alta' datetime DEFAULT CURRENT_TIMESTAMP,
  'eliminado' tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'alm_pedidos_extraordinario'
--

CREATE TABLE 'alm_pedidos_extraordinario' (
  'peex_id' int(11) NOT NULL,
  'fecha' date DEFAULT NULL,
  'detalle' varchar(200) COLLATE utf8_turkish_ci DEFAULT NULL,
  'motivo_rechazo' varchar(200) COLLATE utf8_turkish_ci DEFAULT NULL,
  'case_id' int(11) DEFAULT NULL,
  'pema_id' int(11) DEFAULT NULL,
  'ortr_id' int(11) DEFAULT NULL,
  'empr_id' int(11) DEFAULT NULL,
  'fec_alta' datetime DEFAULT CURRENT_TIMESTAMP,
  'eliminado' tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'alm_pedidos_materiales'
--

CREATE TABLE 'alm_pedidos_materiales' (
  'pema_id' int(11) NOT NULL,
  'fecha' date NOT NULL,
  'motivo_rechazo' varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  'justificacion' varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  'case_id' int(11) DEFAULT NULL,
  'ortr_id' int(11) DEFAULT NULL,
  'estado' varchar(45) COLLATE utf8_spanish_ci DEFAULT 'Solicitado',
  'empr_id' int(11) DEFAULT NULL,
  'fec_alta' datetime DEFAULT CURRENT_TIMESTAMP,
  'eliminado' tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'alm_proveedores'
--

CREATE TABLE 'alm_proveedores' (
  'prov_id' int(10) NOT NULL,
  'nombre' varchar(255) DEFAULT NULL,
  'cuit' varchar(50) DEFAULT NULL,
  'domicilio' varchar(255) DEFAULT NULL,
  'telefono' varchar(50) DEFAULT NULL,
  'email' varchar(100) DEFAULT NULL,
  'empr_id' int(11) NOT NULL,
  'fec_alta' datetime DEFAULT CURRENT_TIMESTAMP,
  'eliminado' tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'alm_proveedores_articulos'
--

CREATE TABLE 'alm_proveedores_articulos' (
  'prov_id' int(10) NOT NULL,
  'arti_id' int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'alm_recepcion_materiales'
--

CREATE TABLE 'alm_recepcion_materiales' (
  'rema_id' int(11) NOT NULL,
  'fecha' datetime NOT NULL,
  'comprobante' varchar(255) CHARACTER SET latin1 NOT NULL,
  'empr_id' int(11) NOT NULL,
  'prov_id' int(10) NOT NULL,
  'fec_alta' datetime DEFAULT CURRENT_TIMESTAMP,
  'eliminado' tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'utl_tablas'
--

CREATE TABLE 'utl_tablas' (
  'tabl_id' int(11) NOT NULL,
  'tabla' varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  'valor' varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  'descripcion' varchar(200) COLLATE utf8_turkish_ci DEFAULT NULL,
  'fec_alta' datetime DEFAULT CURRENT_TIMESTAMP,
  'eliminado' tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla 'alm_deta_entrega_materiales'
--
ALTER TABLE 'alm_deta_entrega_materiales'
  ADD PRIMARY KEY ('deen_id');

--
-- Indices de la tabla 'alm_deta_pedidos_materiales'
--
ALTER TABLE 'alm_deta_pedidos_materiales'
  ADD PRIMARY KEY ('depe_id');

--
-- Indices de la tabla 'alm_deta_recepcion_materiales'
--
ALTER TABLE 'alm_deta_recepcion_materiales'
  ADD PRIMARY KEY ('dere_id');

--
-- Indices de la tabla 'alm_entrega_materiales'
--
ALTER TABLE 'alm_entrega_materiales'
  ADD PRIMARY KEY ('enma_id');

--
-- Indices de la tabla 'alm_lotes'
--
ALTER TABLE 'alm_lotes'
  ADD PRIMARY KEY ('lote_id');

--
-- Indices de la tabla 'alm_pedidos_materiales'
--
ALTER TABLE 'alm_pedidos_materiales'
  ADD PRIMARY KEY ('pema_id');

--
-- Indices de la tabla 'alm_recepcion_materiales'
--
ALTER TABLE 'alm_recepcion_materiales'
  ADD PRIMARY KEY ('rema_id');

--
-- Indices de la tabla 'utl_tablas'
--
ALTER TABLE 'utl_tablas'
  ADD PRIMARY KEY ('tabl_id');

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla 'alm_deta_entrega_materiales'
--
ALTER TABLE 'alm_deta_entrega_materiales'
  MODIFY 'deen_id' int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla 'alm_deta_pedidos_materiales'
--
ALTER TABLE 'alm_deta_pedidos_materiales'
  MODIFY 'depe_id' int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla 'alm_deta_recepcion_materiales'
--
ALTER TABLE 'alm_deta_recepcion_materiales'
  MODIFY 'dere_id' int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla 'alm_entrega_materiales'
--
ALTER TABLE 'alm_entrega_materiales'
  MODIFY 'enma_id' int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla 'alm_lotes'
--
ALTER TABLE 'alm_lotes'
  MODIFY 'lote_id' int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla 'alm_pedidos_materiales'
--
ALTER TABLE 'alm_pedidos_materiales'
  MODIFY 'pema_id' int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla 'alm_recepcion_materiales'
--
ALTER TABLE 'alm_recepcion_materiales'
  MODIFY 'rema_id' int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla 'utl_tablas'
--
ALTER TABLE 'utl_tablas'
  MODIFY 'tabl_id' int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
