-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 02-12-2021 a las 16:39:10
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
-- Base de datos: `urbanogy_ptl`
--

--
-- Volcado de datos para la tabla `Fuels`
--

INSERT INTO `Fuels` (`id`, `name`, `code`, `comment`, `hybrid`, `deleted_at`) VALUES
(1, 'Diésel', 'diesel', 'Litros de diésel utilizado, incluye biodisel y unidades refrigeradas (valores exactos)', 1, NULL),
(2, 'Gasolina', 'gasolina', 'Litros de gasolina utilizado, incluye refrigeradas (valores exactos)', 1, NULL),
(3, 'GLP', 'glp', 'Litros de GLP utilizados (valores exactos)', NULL, NULL),
(4, 'GNL', 'gnl', 'Litros de GNL utilizados (valores exactos)', NULL, NULL),
(5, 'GNC', 'gnc', 'Litros de GNC equivalente a Gasolina utilizados, incluyendo unidades refrigeradas', NULL, NULL),
(6, 'Eléctrico', 'electrico', 'kWhrs de electricidad utilizada (valores exactos)', NULL, NULL),
(7, 'Híbrido', 'hibrido', 'Litros de combustible utilizado, incluye unidades refrigeradoas (valores exactos)', NULL, NULL),
(8, 'Biodiésel', 'biodiesel', NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
