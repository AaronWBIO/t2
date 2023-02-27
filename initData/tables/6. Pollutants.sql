-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-10-2021 a las 22:37:48
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
-- Estructura de tabla para la tabla `Pollutants`
--

-- CREATE TABLE `Pollutants` (
--   `id` int(11) NOT NULL,
--   `name` varchar(45) DEFAULT NULL,
--   `code` varchar(45) DEFAULT NULL,
--   `deleted_at` datetime DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Pollutants`
--

INSERT INTO `Pollutants` (`id`, `name`, `code`, `deleted_at`) VALUES
(1, 'NOx', 'NOX', NULL),
(2, 'CO2', 'CO2', NULL),
(3, 'PM2.5', 'PM25', NULL),
(4, 'PM10', 'PM10', NULL),
(5, 'Carbono Negro', 'CN', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Pollutants`
--
ALTER TABLE `Pollutants`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Pollutants`
--
ALTER TABLE `Pollutants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
