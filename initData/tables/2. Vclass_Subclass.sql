-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-10-2021 a las 13:07:56
-- Versión del servidor: 10.4.20-MariaDB-1:10.4.20+maria~focal-log
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ptl`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Vclass_Subclass`
--

-- CREATE TABLE `Vclass_Subclass` (
--   `id` int(11) NOT NULL,
--   `vclass_id` int(11) DEFAULT NULL,
--   `subclass_id` int(11) DEFAULT NULL,
--   `family` varchar(45) DEFAULT NULL,
--   `boxtype` tinyint(4) DEFAULT NULL,
--   `open` tinyint(4) DEFAULT NULL,
--   `type` varchar(5) DEFAULT NULL,
--   `deleted_at` datetime DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Vclass_Subclass`
--

INSERT INTO `Vclass_Subclass` (`id`, `vclass_id`, `subclass_id`, `family`, `boxtype`, `open`, `type`, `deleted_at`) VALUES
(1, 1, 1, NULL, NULL, NULL, 'load', NULL),
(2, 1, 2, NULL, NULL, NULL, 'load', NULL),
(3, 1, 3, NULL, NULL, NULL, 'load', NULL),
(4, 1, 4, NULL, NULL, NULL, 'load', NULL),
(5, 1, 5, NULL, NULL, NULL, 'load', NULL),
(6, 2, 4, NULL, NULL, NULL, 'load', NULL),
(7, 2, 1, NULL, NULL, NULL, 'load', NULL),
(8, 2, 3, NULL, NULL, NULL, 'load', NULL),
(9, 2, 5, NULL, NULL, NULL, 'load', NULL),
(10, 3, 2, NULL, NULL, NULL, 'load', NULL),
(11, 3, 4, NULL, NULL, NULL, 'load', NULL),
(12, 3, 1, NULL, NULL, NULL, 'load', NULL),
(13, 3, 5, NULL, NULL, NULL, 'load', NULL),
(14, 4, 1, NULL, NULL, NULL, 'load', NULL),
(15, 4, 3, NULL, NULL, NULL, 'load', NULL),
(16, 5, 2, NULL, NULL, NULL, 'load', NULL),
(17, 5, 6, NULL, NULL, NULL, 'load', NULL),
(18, 5, 1, NULL, NULL, NULL, 'load', NULL),
(19, 5, 7, NULL, NULL, NULL, 'load', NULL),
(20, 5, 5, NULL, NULL, NULL, 'load', NULL),
(21, 7, 8, '7unit', NULL, NULL, 'load', NULL),
(22, 6, 2, '7unit', NULL, NULL, 'load', NULL),
(23, 6, 6, '7unit', NULL, NULL, 'load', NULL),
(24, 6, 9, '7unit', NULL, NULL, 'load', NULL),
(25, 6, 7, '7unit', NULL, NULL, 'load', NULL),
(26, 6, 5, '7unit', NULL, NULL, 'load', NULL),
(27, 6, 10, '7carr', NULL, NULL, 'load', NULL),
(28, 6, 11, '7carr', NULL, NULL, 'load', NULL),
(29, 6, 12, '7carr', NULL, NULL, 'load', NULL),
(30, 6, 5, '7carr', NULL, NULL, 'load', NULL),
(31, 7, 2, '8aunit', NULL, NULL, 'load', NULL),
(32, 7, 9, '8aunit', NULL, NULL, 'load', NULL),
(33, 7, 7, '8aunit', NULL, NULL, 'load', NULL),
(34, 7, 6, '8aunit', NULL, NULL, 'load', NULL),
(35, 7, 5, '8aunit', NULL, NULL, 'load', NULL),
(36, 7, 8, '8acarr', NULL, NULL, 'load', NULL),
(37, 7, 10, '8acarr', NULL, NULL, 'load', NULL),
(38, 7, 12, '8acarr', NULL, NULL, 'load', NULL),
(39, 7, 11, '8acarr', NULL, NULL, 'load', NULL),
(40, 7, 13, '8acarr', NULL, NULL, 'load', NULL),
(41, 7, 14, '8acarr', NULL, NULL, 'load', NULL),
(42, 7, 15, '8acarr', NULL, NULL, 'load', NULL),
(43, 7, 5, '8acarr', NULL, NULL, 'load', NULL),
(44, 8, 12, NULL, NULL, NULL, 'load', NULL),
(45, 8, 16, NULL, NULL, NULL, 'load', NULL),
(46, 8, 17, NULL, NULL, NULL, 'load', NULL),
(47, 8, 11, NULL, NULL, NULL, 'load', NULL),
(48, 8, 10, NULL, NULL, NULL, 'load', NULL),
(49, 8, 14, NULL, NULL, NULL, 'load', NULL),
(50, 8, 18, NULL, NULL, NULL, 'load', NULL),
(51, 8, 13, NULL, NULL, NULL, 'load', NULL),
(52, 8, 19, NULL, NULL, NULL, 'load', NULL),
(53, 8, 15, NULL, NULL, NULL, 'load', NULL),
(54, 8, 5, NULL, NULL, NULL, 'load', NULL),
(55, 8, 20, NULL, NULL, NULL, 'load', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Vclass_Subclass`
--
ALTER TABLE `Vclass_Subclass`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Vclass_Subclass_Vclass1_idx` (`vclass_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Vclass_Subclass`
--
ALTER TABLE `Vclass_Subclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Vclass_Subclass`
--
ALTER TABLE `Vclass_Subclass`
  ADD CONSTRAINT `fk_Vclass_Subclass_Vclass1` FOREIGN KEY (`vclass_id`) REFERENCES `Vclass` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
