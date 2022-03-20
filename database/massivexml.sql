-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-02-2022 a las 07:42:51
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `massivexml`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobante`
--

CREATE TABLE `comprobante` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `estado` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_autorizacion` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_autorizacion` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ambiente` bigint(20) UNSIGNED DEFAULT NULL,
  `tipo_emision` bigint(20) UNSIGNED DEFAULT NULL,
  `razon_social` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_comercial` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruc` bigint(250) DEFAULT NULL,
  `clave_acceso` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_doc` bigint(20) NOT NULL,
  `estab` bigint(20) DEFAULT NULL,
  `pto_emi` bigint(20) DEFAULT NULL,
  `secuencial` bigint(20) DEFAULT NULL,
  `dir_matriz` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agente_retencion` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_emision` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dir_establecimiento` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `obligado_contabilidad` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_identificacion_com` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razon_social_comprador` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identificacion_comprador` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_doc_modificado` bigint(20) DEFAULT NULL,
  `num_doc_modificado` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_emision_doc_sustento` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `periodo_fiscal` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_comprador` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_sin_impuestos` double(8,2) DEFAULT NULL,
  `valor_modificacion` double(8,2) DEFAULT NULL,
  `total_descuento` double(8,2) DEFAULT NULL,
  `cod_doc_reembolso` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_comprobante_reemb` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_base_impon_reemb` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_impuesto_reemb` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `propina` double(8,2) DEFAULT NULL,
  `importe_total` double(8,2) DEFAULT NULL,
  `moneda` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `id` bigint(20) NOT NULL,
  `codigo_principal` bigint(20) DEFAULT NULL,
  `codigo_auxiliar` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` double(8,2) DEFAULT NULL,
  `precio_unitario` double(8,2) DEFAULT NULL,
  `descuento` double(8,2) DEFAULT NULL,
  `precio_total_sin_impuesto` double(8,2) DEFAULT NULL,
  `comprobante_id` bigint(20) UNSIGNED NOT NULL,
  `status` int(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_impuesto`
--

CREATE TABLE `detalle_impuesto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` bigint(20) DEFAULT NULL,
  `codigo_porcentaje` bigint(20) DEFAULT NULL,
  `tarifa` double(8,2) DEFAULT NULL,
  `base_imponible` double(8,2) DEFAULT NULL,
  `valor` double(8,2) DEFAULT NULL,
  `detalle_id` bigint(20) UNSIGNED NOT NULL,
  `status` int(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impuesto`
--

CREATE TABLE `impuesto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` bigint(20) UNSIGNED DEFAULT NULL,
  `codigo_porcentaje` bigint(20) UNSIGNED DEFAULT NULL,
  `base_imponible` double(8,2) DEFAULT NULL,
  `tarifa` double(8,2) DEFAULT NULL,
  `valor` double(8,2) DEFAULT NULL,
  `cod_doc_sustento` bigint(20) DEFAULT NULL,
  `num_doc_sustento` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_emision_doc_sustento` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comprobante_id` bigint(20) UNSIGNED NOT NULL,
  `status` int(10) UNSIGNED DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_adicional`
--

CREATE TABLE `info_adicional` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comprobante_id` bigint(20) UNSIGNED NOT NULL,
  `status` int(1) UNSIGNED DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `forma_pago` bigint(20) UNSIGNED DEFAULT NULL,
  `total_pago` double(8,2) DEFAULT NULL,
  `comprobante_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comprobante`
--
ALTER TABLE `comprobante`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comprobante_detalle` (`comprobante_id`);

--
-- Indices de la tabla `detalle_impuesto`
--
ALTER TABLE `detalle_impuesto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `impuesto`
--
ALTER TABLE `impuesto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comprobante_impuesto` (`comprobante_id`);

--
-- Indices de la tabla `info_adicional`
--
ALTER TABLE `info_adicional`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comprobante_infoAdicional` (`comprobante_id`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comprobante_pago` (`comprobante_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comprobante`
--
ALTER TABLE `comprobante`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT de la tabla `detalle`
--
ALTER TABLE `detalle`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT de la tabla `detalle_impuesto`
--
ALTER TABLE `detalle_impuesto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `impuesto`
--
ALTER TABLE `impuesto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT de la tabla `info_adicional`
--
ALTER TABLE `info_adicional`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD CONSTRAINT `fk_comprobante_detalle` FOREIGN KEY (`comprobante_id`) REFERENCES `comprobante` (`id`);

--
-- Filtros para la tabla `impuesto`
--
ALTER TABLE `impuesto`
  ADD CONSTRAINT `fk_comprobante_impuesto` FOREIGN KEY (`comprobante_id`) REFERENCES `comprobante` (`id`);

--
-- Filtros para la tabla `info_adicional`
--
ALTER TABLE `info_adicional`
  ADD CONSTRAINT `fk_comprobante_infoAdicional` FOREIGN KEY (`comprobante_id`) REFERENCES `comprobante` (`id`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `fk_comprobante_pago` FOREIGN KEY (`comprobante_id`) REFERENCES `comprobante` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
