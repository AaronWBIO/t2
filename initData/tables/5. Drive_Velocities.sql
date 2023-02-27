-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 01-12-2021 a las 13:13:05
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
-- Volcado de datos para la tabla `Drive_Velocities`
--

INSERT INTO `Drive_Velocities` (`id`, `vclass_id`, `fuels_id`, `range_1`, `range_2`, `range_3`, `deceleration`) VALUES
(1, 1, 1, 34.8, 38.2, 12.5, 14.5),
(2, 2, 1, 40.8, 35.8, 12.3, 11.1),
(3, 3, 1, 42, 35.1, 12.3, 10.6),
(4, 4, 1, 42, 35.1, 12.3, 10.6),
(5, 5, 1, 42.2, 35.1, 12.3, 10.4),
(6, 6, 1, 42.3, 35.1, 12.3, 10.3),
(7, 7, 1, 43.6, 35.1, 12.3, 9),
(8, 8, 1, 45, 34.5, 12, 8.5),
(9, 1, 2, 42.9, 33.1, 10.1, 13.9),
(10, 2, 2, 42.8, 34.2, 11.5, 11.5),
(11, 3, 2, 42.2, 34.9, 12.1, 10.8),
(12, 4, 2, 43.2, 33.7, 11.1, 12),
(13, 5, 2, 44.2, 32.5, 10.2, 13.1),
(14, 6, 2, 45.7, 30.7, 8.6, 15),
(15, 7, 2, 47.2, 29, 7.2, 16.6),
(16, 8, 2, 47.2, 29, 7.2, 16.6);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
