-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-10-2021 a las 13:07:05
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
-- Estructura de tabla para la tabla `Estados`
--

-- CREATE TABLE `Estados` (
--   `id` int(11) NOT NULL,
--   `nombre` varchar(255) DEFAULT NULL,
--   `siglas` varchar(10) DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Estados`
--

INSERT INTO `Estados` (`id`, `nombre`, `siglas`) VALUES
(1, 'Aguascalientes', 'Ags.'),
(2, 'Baja California', 'BC'),
(3, 'Baja California Sur', 'BCS'),
(4, 'Campeche', 'Camp.'),
(5, 'Coahuila de Zaragoza', 'Coah.'),
(6, 'Colima', 'Col.'),
(7, 'Chiapas', 'Chis.'),
(8, 'Chihuahua', 'Chih.'),
(9, 'Ciudad de México', 'CDMX'),
(10, 'Durango', 'Dgo.'),
(11, 'Guanajuato', 'Gto.'),
(12, 'Guerrero', 'Gro.'),
(13, 'Hidalgo', 'Hgo.'),
(14, 'Jalisco', 'Jal.'),
(15, 'México', 'Mex.'),
(16, 'Michoacán de Ocampo', 'Mich.'),
(17, 'Morelos', 'Mor.'),
(18, 'Nayarit', 'Nay.'),
(19, 'Nuevo León', 'NL'),
(20, 'Oaxaca', 'Oax.'),
(21, 'Puebla', 'Pue.'),
(22, 'Querétaro', 'Qro.'),
(23, 'Quintana Roo', 'Q. Roo'),
(24, 'San Luis Potosí', 'SLP'),
(25, 'Sinaloa', 'Sin.'),
(26, 'Sonora', 'Son.'),
(27, 'Tabasco', 'Tab.'),
(28, 'Tamaulipas', 'Tamps.'),
(29, 'Tlaxcala', 'Tlax.'),
(30, 'Veracruz de Ignacio de la Llave', 'Ver.'),
(31, 'Yucatán', 'Yuc.'),
(32, 'Zacatecas', 'Zac.');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Estados`
--
ALTER TABLE `Estados`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Estados`
--
ALTER TABLE `Estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
