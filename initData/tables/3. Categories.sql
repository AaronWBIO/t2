-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 02-03-2022 a las 11:21:46
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
-- Base de datos: `ptl_semarnat2`
--

--
-- Volcado de datos para la tabla `Categories`
--

INSERT INTO `Categories` (`id`, `name`, `code`) VALUES
(1, 'Acarreo', 'acarreo'),
(2, 'Refrigerado', 'refrigerado'),
(3, 'Carga completa - Caja seca', 'TL-CajaSeca'),
(4, 'Carga consolidada - Caja seca', 'LTL-CajaSeca'),
(5, 'Plataforma', 'plataforma'),
(6, 'Camion cisterna', 'cisterna'),
(7, 'Carga pesada / a granel', 'pesada'),
(8, 'Transporte de Autos (madrinas)', 'madrina'),
(9, 'Mudanza', 'mudanza'),
(11, 'Especializada / Utilitaria', 'especializado'),
(12, 'General (mixta)', 'mixto'),
(13, 'Paquetería', 'paqueteria'),
(14, 'Expedito', 'expedito');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
