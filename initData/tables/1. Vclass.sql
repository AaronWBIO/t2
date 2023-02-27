-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 11-11-2021 a las 10:11:13
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
-- Base de datos: `ptl_empty`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Vclass`
--


--
-- Volcado de datos para la tabla `Vclass`
--

INSERT INTO `Vclass` (`id`, `name`, `code`, `icon`, `load_type`, `deleted_at`, `weight`) VALUES
(1, 'Clase 2b', 'c2b', 'class2b.png', 1, NULL, '4 - 4.5 ton'),
(2, 'Clase 3', 'c3', 'class3.png', 1, NULL, '4.5 - 6.5 ton'),
(3, 'Clase 4', 'c4', 'class4.png', 1, NULL, '6.5 - 7.5 ton'),
(4, 'Clase 5', 'c5', 'class5.png', 1, NULL, '7.5 - 9 ton'),
(5, 'Clase 6', 'c6', 'class6.png', 1, NULL, '9 - 12 ton'),
(6, 'Clase 7', 'c7', 'class7.png', 1, NULL, '12 - 15 ton'),
(7, 'Clase 8a', 'c8a', 'class8a.png', 2, NULL, '15 - 27 ton'),
(8, 'Clase 8b', 'c8b', 'class8b.png', 2, NULL, '27 ton y mas');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Vclass`
--
ALTER TABLE `Vclass`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Vclass`
--
ALTER TABLE `Vclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
