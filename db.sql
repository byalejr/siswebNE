-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2023 at 05:15 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `alquiler` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `num_dias` int(11) NOT NULL,
  `precio_dia` decimal(10,2) NOT NULL,
  `abono` decimal(10,2) NOT NULL,
  `fecha_prestamo` date NOT NULL,
  `hora` time NOT NULL,
  `fecha_devolucion` date NOT NULL,
  `id_doc` int(11) NOT NULL,
  `observacion` text DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alquiler`
--

INSERT INTO `alquiler` (`id`, `id_cliente`, `id_vehiculo`, `num_dias`, `precio_dia`, `abono`, `fecha_prestamo`, `hora`, `fecha_devolucion`, `id_doc`, `observacion`, `estado`) VALUES
(1, 1, 1, 2, 20.00, 10.00, '2021-11-22', '16:32:26', '2021-11-24', 1, '', 0),
(2, 3, 2, 3, 50.00, 60.00, '2021-11-22', '16:44:31', '2021-11-25', 2, '', 0),
(3, 4, 2, 5, 500.00, 100.00, '2023-03-09', '04:10:27', '2023-03-14', 1, 'NINGUNA TODO OKEY', 0),
(4, 2, 19, 3, 1200.00, 50.00, '2023-03-11', '02:54:27', '2023-03-14', 1, 'SALIO SIN SEGURO', 0),
(5, 9, 18, 5, 2000.00, 20.00, '2023-03-11', '02:59:36', '2023-03-16', 1, 'NINGUNA', 0),
(6, 5, 7, 3, 1200.00, 40.00, '2023-03-11', '16:15:02', '2023-03-14', 1, 'NINGUNA', 0),
(7, 2, 4, 1, 3000.00, 1.00, '2023-04-22', '17:44:43', '2023-04-23', 1, 'LLEGO TARDE', 0);

-- --------------------------------------------------------

--
--tabla `Socios`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `dni` varchar(10) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- listado  `Socios`
--

INSERT INTO `clientes` (`id`, `dni`, `nombre`, `telefono`, `direccion`, `fecha`, `estado`) VALUES
(1, '3025092', 'MODESTO ENCINAS LAIME', '97899789', 'URBANIZACION SANTIVAÑEZ', '2023-03-11 01:09:52', 1),
(2, '3727645', 'RAMIRO SILLERICO ALARCON', '7984613783', 'ZONA LIPES', '2023-03-11 01:08:50', 1),
(3, '5317669', 'MAXIMO AREVALE CARVALLO', '925491523', 'ZONA LIPES', '2023-03-11 01:08:01', 1),
(4, '12524682', 'GUERY MARVIN ENCINAS', '59160356685', 'AV BLANCO GALINDO', '2023-07-12 03:01:33', 1),
(5, '6509161', 'WILDER ENCINAS GUZMAN', '123131123', 'SANTIAVAÑEZ', '2023-03-11 01:10:39', 1),
(6, '8043565', 'ELMER ENCINAS GUZMAN', '323232323', 'SANTIVAÑEZ', '2023-03-11 01:11:24', 1),
(7, '3593267', 'PASCUAL ANTEZANA ROCHA', '434343433', 'SANTIVAÑEZ', '2023-03-11 01:12:18', 1),
(8, '3762036', 'ROSSE MARY VERDUGUEZ', '1212112122', 'SANTIVAÑEZ', '2023-07-12 03:01:28', 1),
(9, '4512745', 'ORLANDO GARCIA', '54545454545', 'SANTIVAÑEZ', '2023-07-12 03:01:44', 1),
(10, '4435681', 'FELIX LEANDO ESCALERA', '4545444455', 'SANTIVAÑEZ', '2023-07-12 03:01:39', 1);

-- --------------------------------------------------------

--
--  tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `ruc` varchar(20) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `mensaje` text NOT NULL,
  `logo` varchar(10) NOT NULL,
  `moneda` int(11) NOT NULL,
  `impuesto` int(11) NOT NULL,
  `cant_factura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Listado tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `ruc`, `nombre`, `telefono`, `correo`, `direccion`, `mensaje`, `logo`, `moneda`, `impuesto`, `cant_factura`) VALUES
(1, '12345678910', 'NUEVA ESPERANZA', '963852147', 'NESPERANZA@GMAIL.COM', 'SANTIVAÑEZ', '<p>Gracias por su<strong> preferencia</strong><br><strong>Nueva Esperanza</strong></p>', 'logo.png', 1, 18, 1000);

-- --------------------------------------------------------

--
--  tabla `detalle_permisos`
--

CREATE TABLE `detalle_permisos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
--  `detalle_permisos`
--

INSERT INTO `detalle_permisos` (`id`, `id_usuario`, `id_permiso`) VALUES
(1, 2, 1),
(2, 2, 7),
(3, 2, 13),
(4, 2, 19),
(5, 2, 25),
(6, 2, 26),
(7, 2, 31),
(8, 2, 32),
(9, 2, 33),
(10, 3, 10),
(11, 3, 26);

-- --------------------------------------------------------

--
-- Tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` int(11) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- muestra `documentos`
--

INSERT INTO `documentos` (`id`, `documento`, `estado`, `fecha`) VALUES
(1, 'DNI', 1, '2021-11-11 16:43:11'),
(2, 'NINGUNO', 1, '2023-07-12 03:11:46');

-- --------------------------------------------------------

--
-- Tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- listado `marcas`
--

INSERT INTO `marcas` (`id`, `marca`, `estado`, `fecha`) VALUES
(1, 'JAC', 1, '2023-03-11 01:37:23'),
(2, 'HONDA', 1, '2021-11-11 18:46:06'),
(3, 'NISSAN', 1, '2023-03-11 01:37:53'),
(4, 'TOYOTA', 1, '2021-11-11 18:46:28'),
(5, 'VOLVO', 1, '2021-11-11 18:46:38'),
(6, 'SUZUKI', 1, '2021-11-11 18:46:53'),
(7, 'JBC', 1, '2023-03-11 01:38:07'),
(8, 'NISSAN DIESEL', 1, '2023-03-11 01:37:47'),
(9, 'SCANIA', 1, '2023-03-11 01:51:29');

-- --------------------------------------------------------

--
-- Tablea `moneda`
--

CREATE TABLE `moneda` (
  `id` int(11) NOT NULL,
  `simbolo` varchar(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
--  `moneda`
--

INSERT INTO `moneda` (`id`, `simbolo`, `nombre`, `fecha`, `estado`) VALUES
(1, 'BS', 'Bolivianos', '2021-10-22 16:06:22', 1),
(2, '$', 'DOLAR', '2023-02-28 02:17:06', 1);

-- --------------------------------------------------------

--
-- Tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `permiso` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
--  `permisos`
--

INSERT INTO `permisos` (`id`, `permiso`) VALUES
(1, 'configuracion'),
(2, 'crear moneda'),
(3, 'editar moneda'),
(4, 'eliminar moneda'),
(5, 'restaurar moneda'),
(6, 'crear usuario'),
(7, 'editar usuario'),
(8, 'eliminar usuario'),
(9, 'restaurar usuario'),
(10, 'crear socio'),
(11, 'editar socio'),
(12, 'eliminar socio'),
(13, 'restaurar socio'),
(14, 'crear documento'),
(15, 'editar documento'),
(16, 'eliminar documento'),
(17, 'restaurar documento'),
(18, 'crear marca'),
(19, 'editar marca'),
(20, 'eliminar marca'),
(21, 'restaurar marca'),
(22, 'crear tipo'),
(23, 'editar tipo'),
(24, 'eliminar tipo'),
(25, 'restaurar tipo'),
(26, 'crear vehiculo'),
(27, 'editar vehiculo'),
(28, 'eliminar vehiculo'),
(29, 'restaurar vehiculo'),
(30, 'alquiler'),
(31, 'recibir prestamo'),
(32, 'reportes alquiler'),
(33, 'roles');

-- --------------------------------------------------------

--
-- Tablae `tipos`
--

CREATE TABLE `tipos` (
  `id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
--  `tipos`
--

INSERT INTO `tipos` (`id`, `tipo`, `estado`, `fecha`) VALUES
(1, 'CAMION', 1, '2023-03-11 01:17:41'),
(2, 'TRACTOCAMION', 1, '2023-03-11 01:19:20'),
(3, 'CHASIS CAVINADO', 1, '2023-03-11 01:18:57'),
(4, 'CAMION VOLTEO', 1, '2023-03-11 01:47:30'),
(5, 'VOLQUETA', 1, '2023-03-11 01:46:44'),
(6, 'CAMION', 1, '2021-11-11 18:49:21'),
(7, 'Furgón', 1, '2021-11-11 18:49:54');

-- --------------------------------------------------------

--
-- Tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `correo` varchar(80) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `perfil` varchar(50) NOT NULL DEFAULT 'avatar.svg',
  `clave` varchar(100) NOT NULL,
  `token` varchar(50) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `apellido`, `correo`, `telefono`, `direccion`, `perfil`, `clave`, `token`, `fecha`, `estado`) VALUES
(1, 'ADMIN', 'ADMIN', 'ADMIN', 'nesperanza@gmail.com', '925491523', 'SANTIVAÑEZ', '20230309032227.jpg', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', NULL, '2023-03-10 03:05:39', 1),
(2, 'ANGEL', 'ANGEL SIFUENTES', '', 'angel@gmail.com', '797987897', '', 'avatar.svg', '519ba91a5a5b4afb9dc66f8805ce8c442b6576316c19c6896af2fa9bda6aff71', NULL, '2021-11-12 18:30:22', 1),
(3, 'MARIA', 'MARIA SANCHEZ', NULL, 'maria@gmail.com', '60356685', NULL, 'avatar.svg', '94aec9fbed989ece189a7e172c9cf41669050495152bc4c1dbf2a38d7fd85627', NULL, '2023-03-11 15:09:22', 0);

-- --------------------------------------------------------

--
-- Tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL,
  `placa` varchar(50) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
--  `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `placa`, `id_marca`, `id_tipo`, `modelo`, `foto`, `estado`, `fecha`) VALUES
(1, '79798987', 1, 1, 'X-47', '20211111102853.jpg', 0, '2023-03-11 01:23:04'),
(2, '7987798', 2, 4, '46564CFR', 'default.png', 0, '2023-03-11 01:23:00'),
(3, '78979', 4, 5, 'KI78', 'default.png', 0, '2023-03-11 01:22:54'),
(4, '4756TSX', 5, 2, '2013', '20230311022532.jpg', 1, '2023-04-22 15:59:39'),
(5, '4474EPS', 5, 2, '2015', '20230311022701.jpg', 1, '2023-03-11 01:27:01'),
(6, '4022NNE', 5, 1, '2009', '20230311022935.jpg', 1, '2023-03-11 01:29:35'),
(7, '3063KFH', 5, 2, '2007', '20230311023036.jpg', 1, '2023-03-11 15:22:21'),
(8, '2295PDP', 5, 2, '2002', '20230311023106.jpg', 1, '2023-03-11 01:31:06'),
(9, '1011DLP', 5, 2, '1983', '20230311023133.jpg', 1, '2023-03-11 01:31:33'),
(10, '5339LRB', 5, 2, '2015', 'default.png', 1, '2023-03-11 01:32:18'),
(11, '4792GCY', 5, 2, '2013', 'default.png', 1, '2023-03-11 01:32:51'),
(12, '4980XNB', 5, 2, '2013', 'default.png', 1, '2023-03-11 01:33:53'),
(13, '6003TDR', 1, 1, '2023', 'default.png', 1, '2023-03-11 01:38:45'),
(14, '693EPI', 5, 1, '1980', 'default.png', 1, '2023-03-11 01:39:37'),
(15, '2542DLF', 1, 1, '2011', 'default.png', 1, '2023-03-11 01:40:05'),
(16, '2926RIP', 8, 3, '2007', 'default.png', 1, '2023-03-11 01:42:45'),
(17, '787RKN', 3, 1, '1989', 'default.png', 1, '2023-03-11 01:43:19'),
(18, '2890REY', 7, 1, '2012', 'default.png', 1, '2023-07-12 03:00:57'),
(19, '2057BTK', 5, 5, '1988', 'default.png', 1, '2023-07-12 03:01:05'),
(20, '2480FCC', 5, 3, '2002', 'default.png', 1, '2023-03-11 01:48:43'),
(21, '564HNE', 5, 1, '1979', 'default.png', 1, '2023-03-11 01:49:13'),
(22, '3582SKP', 5, 5, '2008', 'default.png', 1, '2023-03-11 01:49:50'),
(23, '2157DZH', 3, 5, '1997', 'default.png', 1, '2023-03-11 01:50:33'),
(24, '4154UAB', 5, 3, '2011', 'default.png', 1, '2023-03-11 01:51:03'),
(25, '2115NYD', 9, 5, '1988', '20230422174426.jpg', 1, '2023-04-22 15:44:26');

--
-- 
--

--
-- Index `alquiler`
--
ALTER TABLE `alquiler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_vehiculo` (`id_vehiculo`),
  ADD KEY `id_doc` (`id_doc`);

--
-- Index `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexe `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `moneda` (`moneda`);

--
-- Index `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_permiso` (`id_permiso`);

--
-- Index `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexe `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indexe `moneda`
--
ALTER TABLE `moneda`
  ADD PRIMARY KEY (`id`);

--
-- Index `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Index`tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`);

--
-- Index `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Index`vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_marca` (`id_marca`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- 
--

--
-- AUTO_INCREMENT  `alquiler`
--
ALTER TABLE `alquiler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT  `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT  `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT  `moneda`
--
ALTER TABLE `moneda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT  `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT  `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT  `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT  `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- 
--

--
-- restric `alquiler`
--
ALTER TABLE `alquiler`
  ADD CONSTRAINT `alquiler_ibfk_1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alquiler_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alquiler_ibfk_3` FOREIGN KEY (`id_doc`) REFERENCES `documentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- restric `configuracion`
--
ALTER TABLE `configuracion`
  ADD CONSTRAINT `configuracion_ibfk_1` FOREIGN KEY (`moneda`) REFERENCES `moneda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- restric `detalle_permisos`
--
ALTER TABLE `detalle_permisos`
  ADD CONSTRAINT `detalle_permisos_ibfk_1` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_permisos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- restric `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vehiculos_ibfk_2` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

