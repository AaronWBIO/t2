-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 08-11-2021 a las 16:32:55
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
-- Base de datos: `ptl_empty_2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Validations`
--

CREATE TABLE `Validations` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `field` varchar(100) DEFAULT NULL,
  `message` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Validations`
--

INSERT INTO `Validations` (`id`, `name`, `field`, `message`) VALUES
(1, 'Kilómetros Anuales por Vehículo', 'km_tot', NULL),
(2, 'Kilómetros por Litro', 'km/l', NULL),
(3, 'Porcentaje de Kilómetros en Vacío', 'km_empty', NULL),
(5, 'Promedio de Días de ralentí', 'ralenti_days', NULL),
(6, 'Carga útil promedio', 'payload_avg', NULL),
(7, 'Horas Promedio en Ralentí de Larga Duración', 'ralenti_hours_large', NULL),
(8, 'Horas Promedio en Ralentí de Corta Duración', 'ralenti_hours_short', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Validations`
--
ALTER TABLE `Validations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Validations`
--
ALTER TABLE `Validations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
