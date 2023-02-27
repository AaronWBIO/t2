-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 02-03-2022 a las 11:26:41
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
-- Estructura de tabla para la tabla `Brands`
--

CREATE TABLE `Brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scian` varchar(10) DEFAULT NULL,
  `measure_year` varchar(45) DEFAULT NULL,
  `companies_id` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `num_no_ptl` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Brands_Fleets`
--

CREATE TABLE `Brands_Fleets` (
  `id` int(11) NOT NULL,
  `measure_year` int(11) DEFAULT NULL,
  `brands_id` int(11) DEFAULT NULL,
  `fleets_id` int(11) DEFAULT NULL,
  `no_ptl` tinyint(4) DEFAULT NULL,
  `carrier` tinyint(4) DEFAULT NULL,
  `measure_type` varchar(1) DEFAULT NULL,
  `ton_km` double DEFAULT NULL,
  `tot_km` double DEFAULT NULL,
  `avg_payload` double DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cache`
--

CREATE TABLE `Cache` (
  `id` int(11) NOT NULL,
  `fleets_id` int(11) DEFAULT NULL,
  `json` mediumtext DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `CO2GKM` float DEFAULT NULL,
  `NOXGKM` float DEFAULT NULL,
  `PM25GKM` float DEFAULT NULL,
  `PM10GKM` float DEFAULT NULL,
  `CNGKM` float DEFAULT NULL,
  `CO2GTonKM` float DEFAULT NULL,
  `NOXGTonKM` float DEFAULT NULL,
  `PM25GTonKM` float DEFAULT NULL,
  `PM10GTonKM` float DEFAULT NULL,
  `CNGTonKM` float DEFAULT NULL,
  `CO2` float DEFAULT NULL,
  `NOX` float DEFAULT NULL,
  `PM10` float DEFAULT NULL,
  `PM25` float DEFAULT NULL,
  `CN` float DEFAULT NULL,
  `v_total` int(11) DEFAULT NULL,
  `avg_year` float DEFAULT NULL,
  `km_tot` varchar(45) DEFAULT NULL,
  `lts_tot` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cache_Users`
--

CREATE TABLE `Cache_Users` (
  `id` int(11) NOT NULL,
  `brands_id` int(11) DEFAULT NULL,
  `CO2` float DEFAULT NULL,
  `PM10` float DEFAULT NULL,
  `PM25` float DEFAULT NULL,
  `NOX` float DEFAULT NULL,
  `CN` float DEFAULT NULL,
  `json` text DEFAULT NULL,
  `brand_fleets_id` int(11) DEFAULT NULL,
  `GKMCO2` float DEFAULT NULL,
  `GKMPM10` float DEFAULT NULL,
  `GKMPM25` float DEFAULT NULL,
  `GKMNOX` float DEFAULT NULL,
  `GKMCN` float DEFAULT NULL,
  `GTONKMCO2` float DEFAULT NULL,
  `GTONKMPM10` float DEFAULT NULL,
  `GTONKMPM25` float DEFAULT NULL,
  `GTONKMNOX` float DEFAULT NULL,
  `GTONKMCN` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cache_Vclass`
--

CREATE TABLE `Cache_Vclass` (
  `id` int(11) NOT NULL,
  `fleets_id` int(11) DEFAULT NULL,
  `json` mediumtext DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `CO2GKM` float DEFAULT NULL,
  `NOXGKM` float DEFAULT NULL,
  `PM25GKM` float DEFAULT NULL,
  `PM10GKM` float DEFAULT NULL,
  `CNGKM` float DEFAULT NULL,
  `CO2GTonKM` float DEFAULT NULL,
  `NOXGTonKM` float DEFAULT NULL,
  `PM25GTonKM` float DEFAULT NULL,
  `PM10GTonKM` float DEFAULT NULL,
  `CNGTonKM` float DEFAULT NULL,
  `vclass_code` varchar(10) DEFAULT NULL,
  `fuels_code` varchar(10) DEFAULT NULL,
  `v_total` int(11) DEFAULT NULL,
  `km_tot` double DEFAULT NULL,
  `km_empty` double DEFAULT NULL,
  `payload_avg` int(11) DEFAULT NULL,
  `CO2` double DEFAULT NULL,
  `NOX` double DEFAULT NULL,
  `PM10` double DEFAULT NULL,
  `PM25` double DEFAULT NULL,
  `CN` double DEFAULT NULL,
  `avg_year` double DEFAULT NULL,
  `lts_tot` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categories`
--

CREATE TABLE `Categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Comments`
--

CREATE TABLE `Comments` (
  `id` int(11) NOT NULL,
  `field` varchar(45) DEFAULT NULL,
  `fleets_fuels_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `color` varchar(15) DEFAULT NULL,
  `vclass_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Companies`
--

CREATE TABLE `Companies` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `SEMARNAT_ID` varchar(45) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `municipio` int(11) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `rfc` varchar(14) DEFAULT NULL,
  `telefono` char(10) DEFAULT NULL,
  `rev_year` varchar(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Companies_Emissions`
--

CREATE TABLE `Companies_Emissions` (
  `id` int(11) NOT NULL,
  `measure_year` int(11) DEFAULT NULL,
  `companies_id` int(11) DEFAULT NULL,
  `json` text DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contacts`
--

CREATE TABLE `Contacts` (
  `id` int(11) NOT NULL,
  `companies_id` int(11) DEFAULT NULL,
  `type` varchar(2) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `ext` varchar(5) DEFAULT NULL,
  `phone2` varchar(10) DEFAULT NULL,
  `ext2` varchar(5) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `curp` varchar(18) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Drive_Velocities`
--

CREATE TABLE `Drive_Velocities` (
  `id` int(11) NOT NULL,
  `vclass_id` int(11) DEFAULT NULL,
  `fuels_id` int(11) DEFAULT NULL,
  `range_1` double DEFAULT NULL,
  `range_2` double DEFAULT NULL,
  `range_3` double DEFAULT NULL,
  `deceleration` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Emissions`
--

CREATE TABLE `Emissions` (
  `id` int(11) NOT NULL,
  `fleets_fuels_id` int(11) DEFAULT NULL,
  `json` text DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Emissions_Factors`
--

CREATE TABLE `Emissions_Factors` (
  `id` int(11) NOT NULL,
  `measure_year` varchar(4) DEFAULT NULL,
  `fuels_id` int(11) DEFAULT NULL,
  `vclass_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `pollutants_id` int(11) DEFAULT NULL,
  `ralenti` tinyint(4) DEFAULT NULL,
  `value` double DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `range` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Estados`
--

CREATE TABLE `Estados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `siglas` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Fleets`
--

CREATE TABLE `Fleets` (
  `id` int(11) NOT NULL,
  `companies_id` int(11) DEFAULT NULL,
  `measure_year` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `carga_dedicada` double DEFAULT NULL,
  `carga_consolidada` double DEFAULT NULL,
  `acarreo` double DEFAULT NULL,
  `paqueteria` double DEFAULT NULL,
  `expedito` double DEFAULT NULL,
  `caja_seca` double DEFAULT NULL,
  `refrigerado` double DEFAULT NULL,
  `plataforma` double DEFAULT NULL,
  `cisterna` double DEFAULT NULL,
  `chasis` double DEFAULT NULL,
  `carga_pesada` double DEFAULT NULL,
  `madrina` double DEFAULT NULL,
  `mudanza` double DEFAULT NULL,
  `utilitario` double DEFAULT NULL,
  `especializado` double DEFAULT NULL,
  `usa` double DEFAULT NULL,
  `canada` double DEFAULT NULL,
  `mexico` double DEFAULT NULL,
  `short` double DEFAULT NULL,
  `large` double DEFAULT NULL,
  `intermediary` tinyint(4) DEFAULT NULL,
  `intermediaryPercent` double DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `categories_id` int(11) DEFAULT NULL,
  `json` text DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Fleets_Fuels`
--

CREATE TABLE `Fleets_Fuels` (
  `id` int(11) NOT NULL,
  `fleets_id` int(11) DEFAULT NULL,
  `fuels_id` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Fleets_Fuels_Vclass`
--

CREATE TABLE `Fleets_Fuels_Vclass` (
  `id` int(11) NOT NULL,
  `vclass_id` int(11) DEFAULT NULL,
  `Fleets_Fuels_id` int(11) DEFAULT NULL,
  `euro5` tinyint(4) DEFAULT NULL,
  `euro6` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Fleets_Fuels_Vclass_Travels`
--

CREATE TABLE `Fleets_Fuels_Vclass_Travels` (
  `id` int(11) NOT NULL,
  `fleets_fuels_id` int(11) DEFAULT NULL,
  `vclass_id` int(11) DEFAULT NULL,
  `km_tot` int(11) DEFAULT NULL,
  `km_pay` int(11) DEFAULT NULL,
  `km_empty` int(11) DEFAULT NULL,
  `lts_tot` int(11) DEFAULT NULL,
  `lts_bio` int(11) DEFAULT NULL,
  `payload_avg` double DEFAULT NULL,
  `load_type` tinyint(4) DEFAULT NULL,
  `load_volume` double DEFAULT NULL,
  `avg_volume` double DEFAULT NULL,
  `highway` double DEFAULT NULL,
  `less_40` double DEFAULT NULL,
  `40_80` double DEFAULT NULL,
  `over_80` double DEFAULT NULL,
  `deceleration` double DEFAULT NULL,
  `ralenti_hours_large` int(11) DEFAULT NULL,
  `ralenti_hours_short` int(11) DEFAULT NULL,
  `ralenti_days` int(11) DEFAULT NULL,
  `hybrid_type` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Fleet_Fuels_Vclass_Quantity`
--

CREATE TABLE `Fleet_Fuels_Vclass_Quantity` (
  `id` int(11) NOT NULL,
  `fleets_fuels_id` int(11) DEFAULT NULL,
  `vclass_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `euro5` int(11) DEFAULT NULL,
  `euro6` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Fleet_Fuels_Vclass_Reduction`
--

CREATE TABLE `Fleet_Fuels_Vclass_Reduction` (
  `id` int(11) NOT NULL,
  `fleets_fuels_id` int(11) DEFAULT NULL,
  `vclass_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Fuels`
--

CREATE TABLE `Fuels` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `hybrid` tinyint(4) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Fuels`
--

INSERT INTO `Fuels` (`id`, `name`, `code`, `comment`, `hybrid`, `deleted_at`) VALUES
(1, 'Diésel', 'diesel', 'Litros de diésel utilizado, incluye biodiésel y unidades refrigeradas (valores exactos)', 1, NULL),
(2, 'Gasolina', 'gasolina', 'Litros de gasolina utilizado, incluye refrigeradas (valores exactos)', 1, NULL),
(3, 'GLP', 'glp', 'Litros de GLP utilizados (valores exactos)', NULL, NULL),
(4, 'GNL', 'gnl', 'Litros de GNL utilizados (valores exactos)', NULL, NULL),
(5, 'GNC', 'gnc', 'Litros de GNC equivalente a Gasolina utilizados, incluyendo unidades refrigeradas', NULL, NULL),
(6, 'Eléctrico', 'electrico', 'kWhrs de electricidad utilizada (valores exactos)', NULL, NULL),
(7, 'Híbrido', 'hibrido', 'Litros de combustible utilizado, incluye unidades refrigeradoas (valores exactos)', NULL, NULL),
(8, 'Biodiésel', 'biodiesel', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Municipios`
--

CREATE TABLE `Municipios` (
  `id` int(11) NOT NULL,
  `estados_id` int(11) DEFAULT NULL,
  `c_mnpio` int(3) DEFAULT NULL,
  `nombre` varchar(76) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Municipios`
--

INSERT INTO `Municipios` (`id`, `estados_id`, `c_mnpio`, `nombre`) VALUES
(1, 1, 1, 'Aguascalientes'),
(2, 1, 2, 'Asientos'),
(3, 1, 3, 'Calvillo'),
(4, 1, 4, 'Cosío'),
(5, 1, 5, 'Jesús María'),
(6, 1, 6, 'Pabellón de Arteaga'),
(7, 1, 7, 'Rincón de Romos'),
(8, 1, 8, 'San José de Gracia'),
(9, 1, 9, 'Tepezalá'),
(10, 1, 10, 'El Llano'),
(11, 1, 11, 'San Francisco de los Romo'),
(12, 2, 1, 'Ensenada'),
(13, 2, 2, 'Mexicali'),
(14, 2, 3, 'Tecate'),
(15, 2, 4, 'Tijuana'),
(16, 2, 5, 'Playas de Rosarito'),
(17, 3, 1, 'Comondú'),
(18, 3, 2, 'Mulegé'),
(19, 3, 3, 'La Paz'),
(20, 3, 8, 'Los Cabos'),
(21, 3, 9, 'Loreto'),
(22, 4, 1, 'Calkiní'),
(23, 4, 2, 'Campeche'),
(24, 4, 3, 'Carmen'),
(25, 4, 4, 'Champotón'),
(26, 4, 5, 'Hecelchakán'),
(27, 4, 6, 'Hopelchén'),
(28, 4, 7, 'Palizada'),
(29, 4, 8, 'Tenabo'),
(30, 4, 9, 'Escárcega'),
(31, 4, 10, 'Calakmul'),
(32, 4, 11, 'Candelaria'),
(33, 5, 1, 'Abasolo'),
(34, 5, 2, 'Acuña'),
(35, 5, 3, 'Allende'),
(36, 5, 4, 'Arteaga'),
(37, 5, 5, 'Candela'),
(38, 5, 6, 'Castaños'),
(39, 5, 7, 'Cuatro Ciénegas'),
(40, 5, 8, 'Escobedo'),
(41, 5, 9, 'Francisco I. Madero'),
(42, 5, 10, 'Frontera'),
(43, 5, 11, 'General Cepeda'),
(44, 5, 12, 'Guerrero'),
(45, 5, 13, 'Hidalgo'),
(46, 5, 14, 'Jiménez'),
(47, 5, 15, 'Juárez'),
(48, 5, 16, 'Lamadrid'),
(49, 5, 17, 'Matamoros'),
(50, 5, 18, 'Monclova'),
(51, 5, 19, 'Morelos'),
(52, 5, 20, 'Múzquiz'),
(53, 5, 21, 'Nadadores'),
(54, 5, 22, 'Nava'),
(55, 5, 23, 'Ocampo'),
(56, 5, 24, 'Parras'),
(57, 5, 25, 'Piedras Negras'),
(58, 5, 26, 'Progreso'),
(59, 5, 27, 'Ramos Arizpe'),
(60, 5, 28, 'Sabinas'),
(61, 5, 29, 'Sacramento'),
(62, 5, 30, 'Saltillo'),
(63, 5, 31, 'San Buenaventura'),
(64, 5, 32, 'San Juan de Sabinas'),
(65, 5, 33, 'San Pedro'),
(66, 5, 34, 'Sierra Mojada'),
(67, 5, 35, 'Torreón'),
(68, 5, 36, 'Viesca'),
(69, 5, 37, 'Villa Unión'),
(70, 5, 38, 'Zaragoza'),
(71, 6, 1, 'Armería'),
(72, 6, 2, 'Colima'),
(73, 6, 3, 'Comala'),
(74, 6, 4, 'Coquimatlán'),
(75, 6, 5, 'Cuauhtémoc'),
(76, 6, 6, 'Ixtlahuacán'),
(77, 6, 7, 'Manzanillo'),
(78, 6, 8, 'Minatitlán'),
(79, 6, 9, 'Tecomán'),
(80, 6, 10, 'Villa de Álvarez'),
(81, 7, 1, 'Acacoyagua'),
(82, 7, 2, 'Acala'),
(83, 7, 3, 'Acapetahua'),
(84, 7, 4, 'Altamirano'),
(85, 7, 5, 'Amatán'),
(86, 7, 6, 'Amatenango de la Frontera'),
(87, 7, 7, 'Amatenango del Valle'),
(88, 7, 8, 'Angel Albino Corzo'),
(89, 7, 9, 'Arriaga'),
(90, 7, 10, 'Bejucal de Ocampo'),
(91, 7, 11, 'Bella Vista'),
(92, 7, 12, 'Berriozábal'),
(93, 7, 13, 'Bochil'),
(94, 7, 14, 'El Bosque'),
(95, 7, 15, 'Cacahoatán'),
(96, 7, 16, 'Catazajá'),
(97, 7, 17, 'Cintalapa'),
(98, 7, 18, 'Coapilla'),
(99, 7, 19, 'Comitán de Domínguez'),
(100, 7, 20, 'La Concordia'),
(101, 7, 21, 'Copainalá'),
(102, 7, 22, 'Chalchihuitán'),
(103, 7, 23, 'Chamula'),
(104, 7, 24, 'Chanal'),
(105, 7, 25, 'Chapultenango'),
(106, 7, 26, 'Chenalhó'),
(107, 7, 27, 'Chiapa de Corzo'),
(108, 7, 28, 'Chiapilla'),
(109, 7, 29, 'Chicoasén'),
(110, 7, 30, 'Chicomuselo'),
(111, 7, 31, 'Chilón'),
(112, 7, 32, 'Escuintla'),
(113, 7, 33, 'Francisco León'),
(114, 7, 34, 'Frontera Comalapa'),
(115, 7, 35, 'Frontera Hidalgo'),
(116, 7, 36, 'La Grandeza'),
(117, 7, 37, 'Huehuetán'),
(118, 7, 38, 'Huixtán'),
(119, 7, 39, 'Huitiupán'),
(120, 7, 40, 'Huixtla'),
(121, 7, 41, 'La Independencia'),
(122, 7, 42, 'Ixhuatán'),
(123, 7, 43, 'Ixtacomitán'),
(124, 7, 44, 'Ixtapa'),
(125, 7, 45, 'Ixtapangajoya'),
(126, 7, 46, 'Jiquipilas'),
(127, 7, 47, 'Jitotol'),
(128, 7, 48, 'Juárez'),
(129, 7, 49, 'Larráinzar'),
(130, 7, 50, 'La Libertad'),
(131, 7, 51, 'Mapastepec'),
(132, 7, 52, 'Las Margaritas'),
(133, 7, 53, 'Mazapa de Madero'),
(134, 7, 54, 'Mazatán'),
(135, 7, 55, 'Metapa'),
(136, 7, 56, 'Mitontic'),
(137, 7, 57, 'Motozintla'),
(138, 7, 58, 'Nicolás Ruíz'),
(139, 7, 59, 'Ocosingo'),
(140, 7, 60, 'Ocotepec'),
(141, 7, 61, 'Ocozocoautla de Espinosa'),
(142, 7, 62, 'Ostuacán'),
(143, 7, 63, 'Osumacinta'),
(144, 7, 64, 'Oxchuc'),
(145, 7, 65, 'Palenque'),
(146, 7, 66, 'Pantelhó'),
(147, 7, 67, 'Pantepec'),
(148, 7, 68, 'Pichucalco'),
(149, 7, 69, 'Pijijiapan'),
(150, 7, 70, 'El Porvenir'),
(151, 7, 71, 'Villa Comaltitlán'),
(152, 7, 72, 'Pueblo Nuevo Solistahuacán'),
(153, 7, 73, 'Rayón'),
(154, 7, 74, 'Reforma'),
(155, 7, 75, 'Las Rosas'),
(156, 7, 76, 'Sabanilla'),
(157, 7, 77, 'Salto de Agua'),
(158, 7, 78, 'San Cristóbal de las Casas'),
(159, 7, 79, 'San Fernando'),
(160, 7, 80, 'Siltepec'),
(161, 7, 81, 'Simojovel'),
(162, 7, 82, 'Sitalá'),
(163, 7, 83, 'Socoltenango'),
(164, 7, 84, 'Solosuchiapa'),
(165, 7, 85, 'Soyaló'),
(166, 7, 86, 'Suchiapa'),
(167, 7, 87, 'Suchiate'),
(168, 7, 88, 'Sunuapa'),
(169, 7, 89, 'Tapachula'),
(170, 7, 90, 'Tapalapa'),
(171, 7, 91, 'Tapilula'),
(172, 7, 92, 'Tecpatán'),
(173, 7, 93, 'Tenejapa'),
(174, 7, 94, 'Teopisca'),
(175, 7, 96, 'Tila'),
(176, 7, 97, 'Tonalá'),
(177, 7, 98, 'Totolapa'),
(178, 7, 99, 'La Trinitaria'),
(179, 7, 100, 'Tumbalá'),
(180, 7, 101, 'Tuxtla Gutiérrez'),
(181, 7, 102, 'Tuxtla Chico'),
(182, 7, 103, 'Tuzantán'),
(183, 7, 104, 'Tzimol'),
(184, 7, 105, 'Unión Juárez'),
(185, 7, 106, 'Venustiano Carranza'),
(186, 7, 107, 'Villa Corzo'),
(187, 7, 108, 'Villaflores'),
(188, 7, 109, 'Yajalón'),
(189, 7, 110, 'San Lucas'),
(190, 7, 111, 'Zinacantán'),
(191, 7, 112, 'San Juan Cancuc'),
(192, 7, 113, 'Aldama'),
(193, 7, 114, 'Benemérito de las Américas'),
(194, 7, 115, 'Maravilla Tenejapa'),
(195, 7, 116, 'Marqués de Comillas'),
(196, 7, 117, 'Montecristo de Guerrero'),
(197, 7, 118, 'San Andrés Duraznal'),
(198, 7, 119, 'Santiago el Pinar'),
(199, 8, 1, 'Ahumada'),
(200, 8, 2, 'Aldama'),
(201, 8, 3, 'Allende'),
(202, 8, 4, 'Aquiles Serdán'),
(203, 8, 5, 'Ascensión'),
(204, 8, 6, 'Bachíniva'),
(205, 8, 7, 'Balleza'),
(206, 8, 8, 'Batopilas'),
(207, 8, 9, 'Bocoyna'),
(208, 8, 10, 'Buenaventura'),
(209, 8, 11, 'Camargo'),
(210, 8, 12, 'Carichí'),
(211, 8, 13, 'Casas Grandes'),
(212, 8, 14, 'Coronado'),
(213, 8, 15, 'Coyame del Sotol'),
(214, 8, 16, 'La Cruz'),
(215, 8, 17, 'Cuauhtémoc'),
(216, 8, 18, 'Cusihuiriachi'),
(217, 8, 19, 'Chihuahua'),
(218, 8, 20, 'Chínipas'),
(219, 8, 21, 'Delicias'),
(220, 8, 22, 'Dr. Belisario Domínguez'),
(221, 8, 23, 'Galeana'),
(222, 8, 24, 'Santa Isabel'),
(223, 8, 25, 'Gómez Farías'),
(224, 8, 26, 'Gran Morelos'),
(225, 8, 27, 'Guachochi'),
(226, 8, 28, 'Guadalupe'),
(227, 8, 29, 'Guadalupe y Calvo'),
(228, 8, 30, 'Guazapares'),
(229, 8, 31, 'Guerrero'),
(230, 8, 32, 'Hidalgo del Parral'),
(231, 8, 33, 'Huejotitán'),
(232, 8, 34, 'Ignacio Zaragoza'),
(233, 8, 35, 'Janos'),
(234, 8, 36, 'Jiménez'),
(235, 8, 37, 'Juárez'),
(236, 8, 38, 'Julimes'),
(237, 8, 39, 'López'),
(238, 8, 40, 'Madera'),
(239, 8, 41, 'Maguarichi'),
(240, 8, 42, 'Manuel Benavides'),
(241, 8, 43, 'Matachí'),
(242, 8, 44, 'Matamoros'),
(243, 8, 45, 'Meoqui'),
(244, 8, 46, 'Morelos'),
(245, 8, 47, 'Moris'),
(246, 8, 48, 'Namiquipa'),
(247, 8, 49, 'Nonoava'),
(248, 8, 50, 'Nuevo Casas Grandes'),
(249, 8, 51, 'Ocampo'),
(250, 8, 52, 'Ojinaga'),
(251, 8, 53, 'Praxedis G. Guerrero'),
(252, 8, 54, 'Riva Palacio'),
(253, 8, 55, 'Rosales'),
(254, 8, 56, 'Rosario'),
(255, 8, 57, 'San Francisco de Borja'),
(256, 8, 58, 'San Francisco de Conchos'),
(257, 8, 59, 'San Francisco del Oro'),
(258, 8, 60, 'Santa Bárbara'),
(259, 8, 61, 'Satevó'),
(260, 8, 62, 'Saucillo'),
(261, 8, 63, 'Temósachic'),
(262, 8, 64, 'El Tule'),
(263, 8, 65, 'Urique'),
(264, 8, 66, 'Uruachi'),
(265, 8, 67, 'Valle de Zaragoza'),
(266, 9, 2, 'Azcapotzalco'),
(267, 9, 3, 'Coyoacán'),
(268, 9, 4, 'Cuajimalpa de Morelos'),
(269, 9, 5, 'Gustavo A. Madero'),
(270, 9, 6, 'Iztacalco'),
(271, 9, 7, 'Iztapalapa'),
(272, 9, 8, 'La Magdalena Contreras'),
(273, 9, 9, 'Milpa Alta'),
(274, 9, 10, 'Álvaro Obregón'),
(275, 9, 11, 'Tláhuac'),
(276, 9, 12, 'Tlalpan'),
(277, 9, 13, 'Xochimilco'),
(278, 9, 14, 'Benito Juárez'),
(279, 9, 15, 'Cuauhtémoc'),
(280, 9, 16, 'Miguel Hidalgo'),
(281, 9, 17, 'Venustiano Carranza'),
(282, 10, 1, 'Canatlán'),
(283, 10, 2, 'Canelas'),
(284, 10, 3, 'Coneto de Comonfort'),
(285, 10, 4, 'Cuencamé'),
(286, 10, 5, 'Durango'),
(287, 10, 6, 'General Simón Bolívar'),
(288, 10, 7, 'Gómez Palacio'),
(289, 10, 8, 'Guadalupe Victoria'),
(290, 10, 9, 'Guanaceví'),
(291, 10, 10, 'Hidalgo'),
(292, 10, 11, 'Indé'),
(293, 10, 12, 'Lerdo'),
(294, 10, 13, 'Mapimí'),
(295, 10, 14, 'Mezquital'),
(296, 10, 15, 'Nazas'),
(297, 10, 16, 'Nombre de Dios'),
(298, 10, 17, 'Ocampo'),
(299, 10, 18, 'El Oro'),
(300, 10, 19, 'Otáez'),
(301, 10, 20, 'Pánuco de Coronado'),
(302, 10, 21, 'Peñón Blanco'),
(303, 10, 22, 'Poanas'),
(304, 10, 23, 'Pueblo Nuevo'),
(305, 10, 24, 'Rodeo'),
(306, 10, 25, 'San Bernardo'),
(307, 10, 26, 'San Dimas'),
(308, 10, 27, 'San Juan de Guadalupe'),
(309, 10, 28, 'San Juan del Río'),
(310, 10, 29, 'San Luis del Cordero'),
(311, 10, 30, 'San Pedro del Gallo'),
(312, 10, 31, 'Santa Clara'),
(313, 10, 32, 'Santiago Papasquiaro'),
(314, 10, 33, 'Súchil'),
(315, 10, 34, 'Tamazula'),
(316, 10, 35, 'Tepehuanes'),
(317, 10, 36, 'Tlahualilo'),
(318, 10, 37, 'Topia'),
(319, 10, 38, 'Vicente Guerrero'),
(320, 10, 39, 'Nuevo Ideal'),
(321, 11, 1, 'Abasolo'),
(322, 11, 2, 'Acámbaro'),
(323, 11, 3, 'San Miguel de Allende'),
(324, 11, 4, 'Apaseo el Alto'),
(325, 11, 5, 'Apaseo el Grande'),
(326, 11, 6, 'Atarjea'),
(327, 11, 7, 'Celaya'),
(328, 11, 8, 'Manuel Doblado'),
(329, 11, 9, 'Comonfort'),
(330, 11, 10, 'Coroneo'),
(331, 11, 11, 'Cortazar'),
(332, 11, 12, 'Cuerámaro'),
(333, 11, 13, 'Doctor Mora'),
(334, 11, 14, 'Dolores Hidalgo Cuna de la Independencia Nacional'),
(335, 11, 15, 'Guanajuato'),
(336, 11, 16, 'Huanímaro'),
(337, 11, 17, 'Irapuato'),
(338, 11, 18, 'Jaral del Progreso'),
(339, 11, 19, 'Jerécuaro'),
(340, 11, 20, 'León'),
(341, 11, 21, 'Moroleón'),
(342, 11, 22, 'Ocampo'),
(343, 11, 23, 'Pénjamo'),
(344, 11, 24, 'Pueblo Nuevo'),
(345, 11, 25, 'Purísima del Rincón'),
(346, 11, 26, 'Romita'),
(347, 11, 27, 'Salamanca'),
(348, 11, 28, 'Salvatierra'),
(349, 11, 29, 'San Diego de la Unión'),
(350, 11, 30, 'San Felipe'),
(351, 11, 31, 'San Francisco del Rincón'),
(352, 11, 32, 'San José Iturbide'),
(353, 11, 33, 'San Luis de la Paz'),
(354, 11, 34, 'Santa Catarina'),
(355, 11, 35, 'Santa Cruz de Juventino Rosas'),
(356, 11, 36, 'Santiago Maravatío'),
(357, 11, 37, 'Silao de la Victoria'),
(358, 11, 38, 'Tarandacuao'),
(359, 11, 39, 'Tarimoro'),
(360, 11, 40, 'Tierra Blanca'),
(361, 11, 41, 'Uriangato'),
(362, 11, 42, 'Valle de Santiago'),
(363, 11, 43, 'Victoria'),
(364, 11, 44, 'Villagrán'),
(365, 11, 45, 'Xichú'),
(366, 11, 46, 'Yuriria'),
(367, 12, 1, 'Acapulco de Juárez'),
(368, 12, 2, 'Ahuacuotzingo'),
(369, 12, 3, 'Ajuchitlán del Progreso'),
(370, 12, 4, 'Alcozauca de Guerrero'),
(371, 12, 5, 'Alpoyeca'),
(372, 12, 6, 'Apaxtla'),
(373, 12, 7, 'Arcelia'),
(374, 12, 8, 'Atenango del Río'),
(375, 12, 9, 'Atlamajalcingo del Monte'),
(376, 12, 10, 'Atlixtac'),
(377, 12, 11, 'Atoyac de Álvarez'),
(378, 12, 12, 'Ayutla de los Libres'),
(379, 12, 13, 'Azoyú'),
(380, 12, 14, 'Benito Juárez'),
(381, 12, 15, 'Buenavista de Cuéllar'),
(382, 12, 16, 'Coahuayutla de José María Izazaga'),
(383, 12, 17, 'Cocula'),
(384, 12, 18, 'Copala'),
(385, 12, 19, 'Copalillo'),
(386, 12, 20, 'Copanatoyac'),
(387, 12, 21, 'Coyuca de Benítez'),
(388, 12, 22, 'Coyuca de Catalán'),
(389, 12, 23, 'Cuajinicuilapa'),
(390, 12, 24, 'Cualác'),
(391, 12, 25, 'Cuautepec'),
(392, 12, 26, 'Cuetzala del Progreso'),
(393, 12, 27, 'Cutzamala de Pinzón'),
(394, 12, 28, 'Chilapa de Álvarez'),
(395, 12, 29, 'Chilpancingo de los Bravo'),
(396, 12, 30, 'Florencio Villarreal'),
(397, 12, 31, 'General Canuto A. Neri'),
(398, 12, 32, 'General Heliodoro Castillo'),
(399, 12, 33, 'Huamuxtitlán'),
(400, 12, 34, 'Huitzuco de los Figueroa'),
(401, 12, 35, 'Iguala de la Independencia'),
(402, 12, 36, 'Igualapa'),
(403, 12, 37, 'Ixcateopan de Cuauhtémoc'),
(404, 12, 38, 'Zihuatanejo de Azueta'),
(405, 12, 39, 'Juan R. Escudero'),
(406, 12, 40, 'Leonardo Bravo'),
(407, 12, 41, 'Malinaltepec'),
(408, 12, 42, 'Mártir de Cuilapan'),
(409, 12, 43, 'Metlatónoc'),
(410, 12, 44, 'Mochitlán'),
(411, 12, 45, 'Olinalá'),
(412, 12, 46, 'Ometepec'),
(413, 12, 47, 'Pedro Ascencio Alquisiras'),
(414, 12, 48, 'Petatlán'),
(415, 12, 49, 'Pilcaya'),
(416, 12, 50, 'Pungarabato'),
(417, 12, 51, 'Quechultenango'),
(418, 12, 52, 'San Luis Acatlán'),
(419, 12, 53, 'San Marcos'),
(420, 12, 54, 'San Miguel Totolapan'),
(421, 12, 55, 'Taxco de Alarcón'),
(422, 12, 56, 'Tecoanapa'),
(423, 12, 57, 'Técpan de Galeana'),
(424, 12, 58, 'Teloloapan'),
(425, 12, 59, 'Tepecoacuilco de Trujano'),
(426, 12, 60, 'Tetipac'),
(427, 12, 61, 'Tixtla de Guerrero'),
(428, 12, 62, 'Tlacoachistlahuaca'),
(429, 12, 63, 'Tlacoapa'),
(430, 12, 64, 'Tlalchapa'),
(431, 12, 65, 'Tlalixtaquilla de Maldonado'),
(432, 12, 66, 'Tlapa de Comonfort'),
(433, 12, 67, 'Tlapehuala'),
(434, 12, 68, 'La Unión de Isidoro Montes de Oca'),
(435, 12, 69, 'Xalpatláhuac'),
(436, 12, 70, 'Xochihuehuetlán'),
(437, 12, 71, 'Xochistlahuaca'),
(438, 12, 72, 'Zapotitlán Tablas'),
(439, 12, 73, 'Zirándaro'),
(440, 12, 74, 'Zitlala'),
(441, 12, 75, 'Eduardo Neri'),
(442, 12, 76, 'Acatepec'),
(443, 12, 77, 'Marquelia'),
(444, 12, 78, 'Cochoapa el Grande'),
(445, 12, 79, 'José Joaquín de Herrera'),
(446, 12, 80, 'Juchitán'),
(447, 12, 81, 'Iliatenco'),
(448, 13, 1, 'Acatlán'),
(449, 13, 2, 'Acaxochitlán'),
(450, 13, 3, 'Actopan'),
(451, 13, 4, 'Agua Blanca de Iturbide'),
(452, 13, 5, 'Ajacuba'),
(453, 13, 6, 'Alfajayucan'),
(454, 13, 7, 'Almoloya'),
(455, 13, 8, 'Apan'),
(456, 13, 9, 'El Arenal'),
(457, 13, 10, 'Atitalaquia'),
(458, 13, 11, 'Atlapexco'),
(459, 13, 12, 'Atotonilco el Grande'),
(460, 13, 13, 'Atotonilco de Tula'),
(461, 13, 14, 'Calnali'),
(462, 13, 15, 'Cardonal'),
(463, 13, 16, 'Cuautepec de Hinojosa'),
(464, 13, 17, 'Chapantongo'),
(465, 13, 18, 'Chapulhuacán'),
(466, 13, 19, 'Chilcuautla'),
(467, 13, 20, 'Eloxochitlán'),
(468, 13, 21, 'Emiliano Zapata'),
(469, 13, 22, 'Epazoyucan'),
(470, 13, 23, 'Francisco I. Madero'),
(471, 13, 24, 'Huasca de Ocampo'),
(472, 13, 25, 'Huautla'),
(473, 13, 26, 'Huazalingo'),
(474, 13, 27, 'Huehuetla'),
(475, 13, 28, 'Huejutla de Reyes'),
(476, 13, 29, 'Huichapan'),
(477, 13, 30, 'Ixmiquilpan'),
(478, 13, 31, 'Jacala de Ledezma'),
(479, 13, 32, 'Jaltocán'),
(480, 13, 33, 'Juárez Hidalgo'),
(481, 13, 34, 'Lolotla'),
(482, 13, 35, 'Metepec'),
(483, 13, 36, 'San Agustín Metzquititlán'),
(484, 13, 37, 'Metztitlán'),
(485, 13, 38, 'Mineral del Chico'),
(486, 13, 39, 'Mineral del Monte'),
(487, 13, 40, 'La Misión'),
(488, 13, 41, 'Mixquiahuala de Juárez'),
(489, 13, 42, 'Molango de Escamilla'),
(490, 13, 43, 'Nicolás Flores'),
(491, 13, 44, 'Nopala de Villagrán'),
(492, 13, 45, 'Omitlán de Juárez'),
(493, 13, 46, 'San Felipe Orizatlán'),
(494, 13, 47, 'Pacula'),
(495, 13, 48, 'Pachuca de Soto'),
(496, 13, 49, 'Pisaflores'),
(497, 13, 50, 'Progreso de Obregón'),
(498, 13, 51, 'Mineral de la Reforma'),
(499, 13, 52, 'San Agustín Tlaxiaca'),
(500, 13, 53, 'San Bartolo Tutotepec'),
(501, 13, 54, 'San Salvador'),
(502, 13, 55, 'Santiago de Anaya'),
(503, 13, 56, 'Santiago Tulantepec de Lugo Guerrero'),
(504, 13, 57, 'Singuilucan'),
(505, 13, 58, 'Tasquillo'),
(506, 13, 59, 'Tecozautla'),
(507, 13, 60, 'Tenango de Doria'),
(508, 13, 61, 'Tepeapulco'),
(509, 13, 62, 'Tepehuacán de Guerrero'),
(510, 13, 63, 'Tepeji del Río de Ocampo'),
(511, 13, 64, 'Tepetitlán'),
(512, 13, 65, 'Tetepango'),
(513, 13, 66, 'Villa de Tezontepec'),
(514, 13, 67, 'Tezontepec de Aldama'),
(515, 13, 68, 'Tianguistengo'),
(516, 13, 69, 'Tizayuca'),
(517, 13, 70, 'Tlahuelilpan'),
(518, 13, 71, 'Tlahuiltepa'),
(519, 13, 72, 'Tlanalapa'),
(520, 13, 73, 'Tlanchinol'),
(521, 13, 74, 'Tlaxcoapan'),
(522, 13, 75, 'Tolcayuca'),
(523, 13, 76, 'Tula de Allende'),
(524, 13, 77, 'Tulancingo de Bravo'),
(525, 13, 78, 'Xochiatipan'),
(526, 13, 79, 'Xochicoatlán'),
(527, 13, 80, 'Yahualica'),
(528, 13, 81, 'Zacualtipán de Ángeles'),
(529, 13, 82, 'Zapotlán de Juárez'),
(530, 13, 83, 'Zempoala'),
(531, 13, 84, 'Zimapán'),
(532, 14, 1, 'Acatic'),
(533, 14, 2, 'Acatlán de Juárez'),
(534, 14, 3, 'Ahualulco de Mercado'),
(535, 14, 4, 'Amacueca'),
(536, 14, 5, 'Amatitán'),
(537, 14, 6, 'Ameca'),
(538, 14, 7, 'San Juanito de Escobedo'),
(539, 14, 8, 'Arandas'),
(540, 14, 9, 'El Arenal'),
(541, 14, 10, 'Atemajac de Brizuela'),
(542, 14, 11, 'Atengo'),
(543, 14, 12, 'Atenguillo'),
(544, 14, 13, 'Atotonilco el Alto'),
(545, 14, 14, 'Atoyac'),
(546, 14, 15, 'Autlán de Navarro'),
(547, 14, 16, 'Ayotlán'),
(548, 14, 17, 'Ayutla'),
(549, 14, 18, 'La Barca'),
(550, 14, 19, 'Bolaños'),
(551, 14, 20, 'Cabo Corrientes'),
(552, 14, 21, 'Casimiro Castillo'),
(553, 14, 22, 'Cihuatlán'),
(554, 14, 23, 'Zapotlán el Grande'),
(555, 14, 24, 'Cocula'),
(556, 14, 25, 'Colotlán'),
(557, 14, 26, 'Concepción de Buenos Aires'),
(558, 14, 27, 'Cuautitlán de García Barragán'),
(559, 14, 28, 'Cuautla'),
(560, 14, 29, 'Cuquío'),
(561, 14, 30, 'Chapala'),
(562, 14, 31, 'Chimaltitán'),
(563, 14, 32, 'Chiquilistlán'),
(564, 14, 33, 'Degollado'),
(565, 14, 34, 'Ejutla'),
(566, 14, 35, 'Encarnación de Díaz'),
(567, 14, 36, 'Etzatlán'),
(568, 14, 37, 'El Grullo'),
(569, 14, 38, 'Guachinango'),
(570, 14, 39, 'Guadalajara'),
(571, 14, 40, 'Hostotipaquillo'),
(572, 14, 41, 'Huejúcar'),
(573, 14, 42, 'Huejuquilla el Alto'),
(574, 14, 43, 'La Huerta'),
(575, 14, 44, 'Ixtlahuacán de los Membrillos'),
(576, 14, 45, 'Ixtlahuacán del Río'),
(577, 14, 46, 'Jalostotitlán'),
(578, 14, 47, 'Jamay'),
(579, 14, 48, 'Jesús María'),
(580, 14, 49, 'Jilotlán de los Dolores'),
(581, 14, 50, 'Jocotepec'),
(582, 14, 51, 'Juanacatlán'),
(583, 14, 52, 'Juchitlán'),
(584, 14, 53, 'Lagos de Moreno'),
(585, 14, 54, 'El Limón'),
(586, 14, 55, 'Magdalena'),
(587, 14, 56, 'Santa María del Oro'),
(588, 14, 57, 'La Manzanilla de la Paz'),
(589, 14, 58, 'Mascota'),
(590, 14, 59, 'Mazamitla'),
(591, 14, 60, 'Mexticacán'),
(592, 14, 61, 'Mezquitic'),
(593, 14, 62, 'Mixtlán'),
(594, 14, 63, 'Ocotlán'),
(595, 14, 64, 'Ojuelos de Jalisco'),
(596, 14, 65, 'Pihuamo'),
(597, 14, 66, 'Poncitlán'),
(598, 14, 67, 'Puerto Vallarta'),
(599, 14, 68, 'Villa Purificación'),
(600, 14, 69, 'Quitupan'),
(601, 14, 70, 'El Salto'),
(602, 14, 71, 'San Cristóbal de la Barranca'),
(603, 14, 72, 'San Diego de Alejandría'),
(604, 14, 73, 'San Juan de los Lagos'),
(605, 14, 74, 'San Julián'),
(606, 14, 75, 'San Marcos'),
(607, 14, 76, 'San Martín de Bolaños'),
(608, 14, 77, 'San Martín Hidalgo'),
(609, 14, 78, 'San Miguel el Alto'),
(610, 14, 79, 'Gómez Farías'),
(611, 14, 80, 'San Sebastián del Oeste'),
(612, 14, 81, 'Santa María de los Ángeles'),
(613, 14, 82, 'Sayula'),
(614, 14, 83, 'Tala'),
(615, 14, 84, 'Talpa de Allende'),
(616, 14, 85, 'Tamazula de Gordiano'),
(617, 14, 86, 'Tapalpa'),
(618, 14, 87, 'Tecalitlán'),
(619, 14, 88, 'Tecolotlán'),
(620, 14, 89, 'Techaluta de Montenegro'),
(621, 14, 90, 'Tenamaxtlán'),
(622, 14, 91, 'Teocaltiche'),
(623, 14, 92, 'Teocuitatlán de Corona'),
(624, 14, 93, 'Tepatitlán de Morelos'),
(625, 14, 94, 'Tequila'),
(626, 14, 95, 'Teuchitlán'),
(627, 14, 96, 'Tizapán el Alto'),
(628, 14, 97, 'Tlajomulco de Zúñiga'),
(629, 14, 98, 'San Pedro Tlaquepaque'),
(630, 14, 99, 'Tolimán'),
(631, 14, 100, 'Tomatlán'),
(632, 14, 101, 'Tonalá'),
(633, 14, 102, 'Tonaya'),
(634, 14, 103, 'Tonila'),
(635, 14, 104, 'Totatiche'),
(636, 14, 105, 'Tototlán'),
(637, 14, 106, 'Tuxcacuesco'),
(638, 14, 107, 'Tuxcueca'),
(639, 14, 108, 'Tuxpan'),
(640, 14, 109, 'Unión de San Antonio'),
(641, 14, 110, 'Unión de Tula'),
(642, 14, 111, 'Valle de Guadalupe'),
(643, 14, 112, 'Valle de Juárez'),
(644, 14, 113, 'San Gabriel'),
(645, 14, 114, 'Villa Corona'),
(646, 14, 115, 'Villa Guerrero'),
(647, 14, 116, 'Villa Hidalgo'),
(648, 14, 117, 'Cañadas de Obregón'),
(649, 14, 118, 'Yahualica de González Gallo'),
(650, 14, 119, 'Zacoalco de Torres'),
(651, 14, 120, 'Zapopan'),
(652, 14, 121, 'Zapotiltic'),
(653, 14, 122, 'Zapotitlán de Vadillo'),
(654, 14, 123, 'Zapotlán del Rey'),
(655, 14, 124, 'Zapotlanejo'),
(656, 14, 125, 'San Ignacio Cerro Gordo'),
(657, 15, 1, 'Acambay de Ruíz Castañeda'),
(658, 15, 2, 'Acolman'),
(659, 15, 3, 'Aculco'),
(660, 15, 4, 'Almoloya de Alquisiras'),
(661, 15, 5, 'Almoloya de Juárez'),
(662, 15, 6, 'Almoloya del Río'),
(663, 15, 7, 'Amanalco'),
(664, 15, 8, 'Amatepec'),
(665, 15, 9, 'Amecameca'),
(666, 15, 10, 'Apaxco'),
(667, 15, 11, 'Atenco'),
(668, 15, 12, 'Atizapán'),
(669, 15, 13, 'Atizapán de Zaragoza'),
(670, 15, 14, 'Atlacomulco'),
(671, 15, 15, 'Atlautla'),
(672, 15, 16, 'Axapusco'),
(673, 15, 17, 'Ayapango'),
(674, 15, 18, 'Calimaya'),
(675, 15, 19, 'Capulhuac'),
(676, 15, 20, 'Coacalco de Berriozábal'),
(677, 15, 21, 'Coatepec Harinas'),
(678, 15, 22, 'Cocotitlán'),
(679, 15, 23, 'Coyotepec'),
(680, 15, 24, 'Cuautitlán'),
(681, 15, 25, 'Chalco'),
(682, 15, 26, 'Chapa de Mota'),
(683, 15, 27, 'Chapultepec'),
(684, 15, 28, 'Chiautla'),
(685, 15, 29, 'Chicoloapan'),
(686, 15, 30, 'Chiconcuac'),
(687, 15, 31, 'Chimalhuacán'),
(688, 15, 32, 'Donato Guerra'),
(689, 15, 33, 'Ecatepec de Morelos'),
(690, 15, 34, 'Ecatzingo'),
(691, 15, 35, 'Huehuetoca'),
(692, 15, 36, 'Hueypoxtla'),
(693, 15, 37, 'Huixquilucan'),
(694, 15, 38, 'Isidro Fabela'),
(695, 15, 39, 'Ixtapaluca'),
(696, 15, 40, 'Ixtapan de la Sal'),
(697, 15, 41, 'Ixtapan del Oro'),
(698, 15, 42, 'Ixtlahuaca'),
(699, 15, 43, 'Xalatlaco'),
(700, 15, 44, 'Jaltenco'),
(701, 15, 45, 'Jilotepec'),
(702, 15, 46, 'Jilotzingo'),
(703, 15, 47, 'Jiquipilco'),
(704, 15, 48, 'Jocotitlán'),
(705, 15, 49, 'Joquicingo'),
(706, 15, 50, 'Juchitepec'),
(707, 15, 51, 'Lerma'),
(708, 15, 52, 'Malinalco'),
(709, 15, 53, 'Melchor Ocampo'),
(710, 15, 54, 'Metepec'),
(711, 15, 55, 'Mexicaltzingo'),
(712, 15, 56, 'Morelos'),
(713, 15, 57, 'Naucalpan de Juárez'),
(714, 15, 58, 'Nezahualcóyotl'),
(715, 15, 59, 'Nextlalpan'),
(716, 15, 60, 'Nicolás Romero'),
(717, 15, 61, 'Nopaltepec'),
(718, 15, 62, 'Ocoyoacac'),
(719, 15, 63, 'Ocuilan'),
(720, 15, 64, 'El Oro'),
(721, 15, 65, 'Otumba'),
(722, 15, 66, 'Otzoloapan'),
(723, 15, 67, 'Otzolotepec'),
(724, 15, 68, 'Ozumba'),
(725, 15, 69, 'Papalotla'),
(726, 15, 70, 'La Paz'),
(727, 15, 71, 'Polotitlán'),
(728, 15, 72, 'Rayón'),
(729, 15, 73, 'San Antonio la Isla'),
(730, 15, 74, 'San Felipe del Progreso'),
(731, 15, 75, 'San Martín de las Pirámides'),
(732, 15, 76, 'San Mateo Atenco'),
(733, 15, 77, 'San Simón de Guerrero'),
(734, 15, 78, 'Santo Tomás'),
(735, 15, 79, 'Soyaniquilpan de Juárez'),
(736, 15, 80, 'Sultepec'),
(737, 15, 81, 'Tecámac'),
(738, 15, 82, 'Tejupilco'),
(739, 15, 83, 'Temamatla'),
(740, 15, 84, 'Temascalapa'),
(741, 15, 85, 'Temascalcingo'),
(742, 15, 86, 'Temascaltepec'),
(743, 15, 87, 'Temoaya'),
(744, 15, 88, 'Tenancingo'),
(745, 15, 89, 'Tenango del Aire'),
(746, 15, 90, 'Tenango del Valle'),
(747, 15, 91, 'Teoloyucan'),
(748, 15, 92, 'Teotihuacán'),
(749, 15, 93, 'Tepetlaoxtoc'),
(750, 15, 94, 'Tepetlixpa'),
(751, 15, 95, 'Tepotzotlán'),
(752, 15, 96, 'Tequixquiac'),
(753, 15, 97, 'Texcaltitlán'),
(754, 15, 98, 'Texcalyacac'),
(755, 15, 99, 'Texcoco'),
(756, 15, 100, 'Tezoyuca'),
(757, 15, 101, 'Tianguistenco'),
(758, 15, 102, 'Timilpan'),
(759, 15, 103, 'Tlalmanalco'),
(760, 15, 104, 'Tlalnepantla de Baz'),
(761, 15, 105, 'Tlatlaya'),
(762, 15, 106, 'Toluca'),
(763, 15, 107, 'Tonatico'),
(764, 15, 108, 'Tultepec'),
(765, 15, 109, 'Tultitlán'),
(766, 15, 110, 'Valle de Bravo'),
(767, 15, 111, 'Villa de Allende'),
(768, 15, 112, 'Villa del Carbón'),
(769, 15, 113, 'Villa Guerrero'),
(770, 15, 114, 'Villa Victoria'),
(771, 15, 115, 'Xonacatlán'),
(772, 15, 116, 'Zacazonapan'),
(773, 15, 117, 'Zacualpan'),
(774, 15, 118, 'Zinacantepec'),
(775, 15, 119, 'Zumpahuacán'),
(776, 15, 120, 'Zumpango'),
(777, 15, 121, 'Cuautitlán Izcalli'),
(778, 15, 122, 'Valle de Chalco Solidaridad'),
(779, 15, 123, 'Luvianos'),
(780, 15, 124, 'San José del Rincón'),
(781, 15, 125, 'Tonanitla'),
(782, 16, 1, 'Acuitzio'),
(783, 16, 2, 'Aguililla'),
(784, 16, 3, 'Álvaro Obregón'),
(785, 16, 4, 'Angamacutiro'),
(786, 16, 5, 'Angangueo'),
(787, 16, 6, 'Apatzingán'),
(788, 16, 7, 'Aporo'),
(789, 16, 8, 'Aquila'),
(790, 16, 9, 'Ario'),
(791, 16, 10, 'Arteaga'),
(792, 16, 11, 'Briseñas'),
(793, 16, 12, 'Buenavista'),
(794, 16, 13, 'Carácuaro'),
(795, 16, 14, 'Coahuayana'),
(796, 16, 15, 'Coalcomán de Vázquez Pallares'),
(797, 16, 16, 'Coeneo'),
(798, 16, 17, 'Contepec'),
(799, 16, 18, 'Copándaro'),
(800, 16, 19, 'Cotija'),
(801, 16, 20, 'Cuitzeo'),
(802, 16, 21, 'Charapan'),
(803, 16, 22, 'Charo'),
(804, 16, 23, 'Chavinda'),
(805, 16, 24, 'Cherán'),
(806, 16, 25, 'Chilchota'),
(807, 16, 26, 'Chinicuila'),
(808, 16, 27, 'Chucándiro'),
(809, 16, 28, 'Churintzio'),
(810, 16, 29, 'Churumuco'),
(811, 16, 30, 'Ecuandureo'),
(812, 16, 31, 'Epitacio Huerta'),
(813, 16, 32, 'Erongarícuaro'),
(814, 16, 33, 'Gabriel Zamora'),
(815, 16, 34, 'Hidalgo'),
(816, 16, 35, 'La Huacana'),
(817, 16, 36, 'Huandacareo'),
(818, 16, 37, 'Huaniqueo'),
(819, 16, 38, 'Huetamo'),
(820, 16, 39, 'Huiramba'),
(821, 16, 40, 'Indaparapeo'),
(822, 16, 41, 'Irimbo'),
(823, 16, 42, 'Ixtlán'),
(824, 16, 43, 'Jacona'),
(825, 16, 44, 'Jiménez'),
(826, 16, 45, 'Jiquilpan'),
(827, 16, 46, 'Juárez'),
(828, 16, 47, 'Jungapeo'),
(829, 16, 48, 'Lagunillas'),
(830, 16, 49, 'Madero'),
(831, 16, 50, 'Maravatío'),
(832, 16, 51, 'Marcos Castellanos'),
(833, 16, 52, 'Lázaro Cárdenas'),
(834, 16, 53, 'Morelia'),
(835, 16, 54, 'Morelos'),
(836, 16, 55, 'Múgica'),
(837, 16, 56, 'Nahuatzen'),
(838, 16, 57, 'Nocupétaro'),
(839, 16, 58, 'Nuevo Parangaricutiro'),
(840, 16, 59, 'Nuevo Urecho'),
(841, 16, 60, 'Numarán'),
(842, 16, 61, 'Ocampo'),
(843, 16, 62, 'Pajacuarán'),
(844, 16, 63, 'Panindícuaro'),
(845, 16, 64, 'Parácuaro'),
(846, 16, 65, 'Paracho'),
(847, 16, 66, 'Pátzcuaro'),
(848, 16, 67, 'Penjamillo'),
(849, 16, 68, 'Peribán'),
(850, 16, 69, 'La Piedad'),
(851, 16, 70, 'Purépero'),
(852, 16, 71, 'Puruándiro'),
(853, 16, 72, 'Queréndaro'),
(854, 16, 73, 'Quiroga'),
(855, 16, 74, 'Cojumatlán de Régules'),
(856, 16, 75, 'Los Reyes'),
(857, 16, 76, 'Sahuayo'),
(858, 16, 77, 'San Lucas'),
(859, 16, 78, 'Santa Ana Maya'),
(860, 16, 79, 'Salvador Escalante'),
(861, 16, 80, 'Senguio'),
(862, 16, 81, 'Susupuato'),
(863, 16, 82, 'Tacámbaro'),
(864, 16, 83, 'Tancítaro'),
(865, 16, 84, 'Tangamandapio'),
(866, 16, 85, 'Tangancícuaro'),
(867, 16, 86, 'Tanhuato'),
(868, 16, 87, 'Taretan'),
(869, 16, 88, 'Tarímbaro'),
(870, 16, 89, 'Tepalcatepec'),
(871, 16, 90, 'Tingambato'),
(872, 16, 91, 'Tingüindín'),
(873, 16, 92, 'Tiquicheo de Nicolás Romero'),
(874, 16, 93, 'Tlalpujahua'),
(875, 16, 94, 'Tlazazalca'),
(876, 16, 95, 'Tocumbo'),
(877, 16, 96, 'Tumbiscatío'),
(878, 16, 97, 'Turicato'),
(879, 16, 98, 'Tuxpan'),
(880, 16, 99, 'Tuzantla'),
(881, 16, 100, 'Tzintzuntzan'),
(882, 16, 101, 'Tzitzio'),
(883, 16, 102, 'Uruapan'),
(884, 16, 103, 'Venustiano Carranza'),
(885, 16, 104, 'Villamar'),
(886, 16, 105, 'Vista Hermosa'),
(887, 16, 106, 'Yurécuaro'),
(888, 16, 107, 'Zacapu'),
(889, 16, 108, 'Zamora'),
(890, 16, 109, 'Zináparo'),
(891, 16, 110, 'Zinapécuaro'),
(892, 16, 111, 'Ziracuaretiro'),
(893, 16, 112, 'Zitácuaro'),
(894, 16, 113, 'José Sixto Verduzco'),
(895, 17, 1, 'Amacuzac'),
(896, 17, 2, 'Atlatlahucan'),
(897, 17, 3, 'Axochiapan'),
(898, 17, 4, 'Ayala'),
(899, 17, 5, 'Coatlán del Río'),
(900, 17, 6, 'Cuautla'),
(901, 17, 7, 'Cuernavaca'),
(902, 17, 8, 'Emiliano Zapata'),
(903, 17, 9, 'Huitzilac'),
(904, 17, 10, 'Jantetelco'),
(905, 17, 11, 'Jiutepec'),
(906, 17, 12, 'Jojutla'),
(907, 17, 13, 'Jonacatepec'),
(908, 17, 14, 'Mazatepec'),
(909, 17, 15, 'Miacatlán'),
(910, 17, 16, 'Ocuituco'),
(911, 17, 17, 'Puente de Ixtla'),
(912, 17, 18, 'Temixco'),
(913, 17, 19, 'Tepalcingo'),
(914, 17, 20, 'Tepoztlán'),
(915, 17, 21, 'Tetecala'),
(916, 17, 22, 'Tetela del Volcán'),
(917, 17, 23, 'Tlalnepantla'),
(918, 17, 24, 'Tlaltizapán de Zapata'),
(919, 17, 25, 'Tlaquiltenango'),
(920, 17, 26, 'Tlayacapan'),
(921, 17, 27, 'Totolapan'),
(922, 17, 28, 'Xochitepec'),
(923, 17, 29, 'Yautepec'),
(924, 17, 30, 'Yecapixtla'),
(925, 17, 31, 'Zacatepec'),
(926, 17, 32, 'Zacualpan de Amilpas'),
(927, 17, 33, 'Temoac'),
(928, 18, 1, 'Acaponeta'),
(929, 18, 2, 'Ahuacatlán'),
(930, 18, 3, 'Amatlán de Cañas'),
(931, 18, 4, 'Compostela'),
(932, 18, 5, 'Huajicori'),
(933, 18, 6, 'Ixtlán del Río'),
(934, 18, 7, 'Jala'),
(935, 18, 8, 'Xalisco'),
(936, 18, 9, 'Del Nayar'),
(937, 18, 10, 'Rosamorada'),
(938, 18, 11, 'Ruíz'),
(939, 18, 12, 'San Blas'),
(940, 18, 13, 'San Pedro Lagunillas'),
(941, 18, 14, 'Santa María del Oro'),
(942, 18, 15, 'Santiago Ixcuintla'),
(943, 18, 16, 'Tecuala'),
(944, 18, 17, 'Tepic'),
(945, 18, 18, 'Tuxpan'),
(946, 18, 19, 'La Yesca'),
(947, 18, 20, 'Bahía de Banderas'),
(948, 19, 1, 'Abasolo'),
(949, 19, 2, 'Agualeguas'),
(950, 19, 3, 'Los Aldamas'),
(951, 19, 4, 'Allende'),
(952, 19, 5, 'Anáhuac'),
(953, 19, 6, 'Apodaca'),
(954, 19, 7, 'Aramberri'),
(955, 19, 8, 'Bustamante'),
(956, 19, 9, 'Cadereyta Jiménez'),
(957, 19, 10, 'El Carmen'),
(958, 19, 11, 'Cerralvo'),
(959, 19, 12, 'Ciénega de Flores'),
(960, 19, 13, 'China'),
(961, 19, 14, 'Doctor Arroyo'),
(962, 19, 15, 'Doctor Coss'),
(963, 19, 16, 'Doctor González'),
(964, 19, 17, 'Galeana'),
(965, 19, 18, 'García'),
(966, 19, 19, 'San Pedro Garza García'),
(967, 19, 20, 'General Bravo'),
(968, 19, 21, 'General Escobedo'),
(969, 19, 22, 'General Terán'),
(970, 19, 23, 'General Treviño'),
(971, 19, 24, 'General Zaragoza'),
(972, 19, 25, 'General Zuazua'),
(973, 19, 26, 'Guadalupe'),
(974, 19, 27, 'Los Herreras'),
(975, 19, 28, 'Higueras'),
(976, 19, 29, 'Hualahuises'),
(977, 19, 30, 'Iturbide'),
(978, 19, 31, 'Juárez'),
(979, 19, 32, 'Lampazos de Naranjo'),
(980, 19, 33, 'Linares'),
(981, 19, 34, 'Marín'),
(982, 19, 35, 'Melchor Ocampo'),
(983, 19, 36, 'Mier y Noriega'),
(984, 19, 37, 'Mina'),
(985, 19, 38, 'Montemorelos'),
(986, 19, 39, 'Monterrey'),
(987, 19, 40, 'Parás'),
(988, 19, 41, 'Pesquería'),
(989, 19, 42, 'Los Ramones'),
(990, 19, 43, 'Rayones'),
(991, 19, 44, 'Sabinas Hidalgo'),
(992, 19, 45, 'Salinas Victoria'),
(993, 19, 46, 'San Nicolás de los Garza'),
(994, 19, 47, 'Hidalgo'),
(995, 19, 48, 'Santa Catarina'),
(996, 19, 49, 'Santiago'),
(997, 19, 50, 'Vallecillo'),
(998, 19, 51, 'Villaldama'),
(999, 20, 1, 'Abejones'),
(1000, 20, 2, 'Acatlán de Pérez Figueroa'),
(1001, 20, 3, 'Asunción Cacalotepec'),
(1002, 20, 4, 'Asunción Cuyotepeji'),
(1003, 20, 5, 'Asunción Ixtaltepec'),
(1004, 20, 6, 'Asunción Nochixtlán'),
(1005, 20, 7, 'Asunción Ocotlán'),
(1006, 20, 8, 'Asunción Tlacolulita'),
(1007, 20, 9, 'Ayotzintepec'),
(1008, 20, 10, 'El Barrio de la Soledad'),
(1009, 20, 11, 'Calihualá'),
(1010, 20, 12, 'Candelaria Loxicha'),
(1011, 20, 13, 'Ciénega de Zimatlán'),
(1012, 20, 14, 'Ciudad Ixtepec'),
(1013, 20, 15, 'Coatecas Altas'),
(1014, 20, 16, 'Coicoyán de las Flores'),
(1015, 20, 17, 'La Compañía'),
(1016, 20, 18, 'Concepción Buenavista'),
(1017, 20, 19, 'Concepción Pápalo'),
(1018, 20, 20, 'Constancia del Rosario'),
(1019, 20, 21, 'Cosolapa'),
(1020, 20, 22, 'Cosoltepec'),
(1021, 20, 23, 'Cuilápam de Guerrero'),
(1022, 20, 24, 'Cuyamecalco Villa de Zaragoza'),
(1023, 20, 25, 'Chahuites'),
(1024, 20, 26, 'Chalcatongo de Hidalgo'),
(1025, 20, 27, 'Chiquihuitlán de Benito Juárez'),
(1026, 20, 28, 'Heroica Ciudad de Ejutla de Crespo'),
(1027, 20, 29, 'Eloxochitlán de Flores Magón'),
(1028, 20, 30, 'El Espinal'),
(1029, 20, 31, 'Tamazulápam del Espíritu Santo'),
(1030, 20, 32, 'Fresnillo de Trujano'),
(1031, 20, 33, 'Guadalupe Etla'),
(1032, 20, 34, 'Guadalupe de Ramírez'),
(1033, 20, 35, 'Guelatao de Juárez'),
(1034, 20, 36, 'Guevea de Humboldt'),
(1035, 20, 37, 'Mesones Hidalgo'),
(1036, 20, 38, 'Villa Hidalgo'),
(1037, 20, 39, 'Heroica Ciudad de Huajuapan de León'),
(1038, 20, 40, 'Huautepec'),
(1039, 20, 41, 'Huautla de Jiménez'),
(1040, 20, 42, 'Ixtlán de Juárez'),
(1041, 20, 43, 'Heroica Ciudad de Juchitán de Zaragoza'),
(1042, 20, 44, 'Loma Bonita'),
(1043, 20, 45, 'Magdalena Apasco'),
(1044, 20, 46, 'Magdalena Jaltepec'),
(1045, 20, 47, 'Santa Magdalena Jicotlán'),
(1046, 20, 48, 'Magdalena Mixtepec'),
(1047, 20, 49, 'Magdalena Ocotlán'),
(1048, 20, 50, 'Magdalena Peñasco'),
(1049, 20, 51, 'Magdalena Teitipac'),
(1050, 20, 52, 'Magdalena Tequisistlán'),
(1051, 20, 53, 'Magdalena Tlacotepec'),
(1052, 20, 54, 'Magdalena Zahuatlán'),
(1053, 20, 55, 'Mariscala de Juárez'),
(1054, 20, 56, 'Mártires de Tacubaya'),
(1055, 20, 57, 'Matías Romero Avendaño'),
(1056, 20, 58, 'Mazatlán Villa de Flores'),
(1057, 20, 59, 'Miahuatlán de Porfirio Díaz'),
(1058, 20, 60, 'Mixistlán de la Reforma'),
(1059, 20, 61, 'Monjas'),
(1060, 20, 62, 'Natividad'),
(1061, 20, 63, 'Nazareno Etla'),
(1062, 20, 64, 'Nejapa de Madero'),
(1063, 20, 65, 'Ixpantepec Nieves'),
(1064, 20, 66, 'Santiago Niltepec'),
(1065, 20, 67, 'Oaxaca de Juárez'),
(1066, 20, 68, 'Ocotlán de Morelos'),
(1067, 20, 69, 'La Pe'),
(1068, 20, 70, 'Pinotepa de Don Luis'),
(1069, 20, 71, 'Pluma Hidalgo'),
(1070, 20, 72, 'San José del Progreso'),
(1071, 20, 73, 'Putla Villa de Guerrero'),
(1072, 20, 74, 'Santa Catarina Quioquitani'),
(1073, 20, 75, 'Reforma de Pineda'),
(1074, 20, 76, 'La Reforma'),
(1075, 20, 77, 'Reyes Etla'),
(1076, 20, 78, 'Rojas de Cuauhtémoc'),
(1077, 20, 79, 'Salina Cruz'),
(1078, 20, 80, 'San Agustín Amatengo'),
(1079, 20, 81, 'San Agustín Atenango'),
(1080, 20, 82, 'San Agustín Chayuco'),
(1081, 20, 83, 'San Agustín de las Juntas'),
(1082, 20, 84, 'San Agustín Etla'),
(1083, 20, 85, 'San Agustín Loxicha'),
(1084, 20, 86, 'San Agustín Tlacotepec'),
(1085, 20, 87, 'San Agustín Yatareni'),
(1086, 20, 88, 'San Andrés Cabecera Nueva'),
(1087, 20, 89, 'San Andrés Dinicuiti'),
(1088, 20, 90, 'San Andrés Huaxpaltepec'),
(1089, 20, 91, 'San Andrés Huayápam'),
(1090, 20, 92, 'San Andrés Ixtlahuaca'),
(1091, 20, 93, 'San Andrés Lagunas'),
(1092, 20, 94, 'San Andrés Nuxiño'),
(1093, 20, 95, 'San Andrés Paxtlán'),
(1094, 20, 96, 'San Andrés Sinaxtla'),
(1095, 20, 97, 'San Andrés Solaga'),
(1096, 20, 98, 'San Andrés Teotilálpam'),
(1097, 20, 99, 'San Andrés Tepetlapa'),
(1098, 20, 100, 'San Andrés Yaá'),
(1099, 20, 101, 'San Andrés Zabache'),
(1100, 20, 102, 'San Andrés Zautla'),
(1101, 20, 103, 'San Antonino Castillo Velasco'),
(1102, 20, 104, 'San Antonino el Alto'),
(1103, 20, 105, 'San Antonino Monte Verde'),
(1104, 20, 106, 'San Antonio Acutla'),
(1105, 20, 107, 'San Antonio de la Cal'),
(1106, 20, 108, 'San Antonio Huitepec'),
(1107, 20, 109, 'San Antonio Nanahuatípam'),
(1108, 20, 110, 'San Antonio Sinicahua'),
(1109, 20, 111, 'San Antonio Tepetlapa'),
(1110, 20, 112, 'San Baltazar Chichicápam'),
(1111, 20, 113, 'San Baltazar Loxicha'),
(1112, 20, 114, 'San Baltazar Yatzachi el Bajo'),
(1113, 20, 115, 'San Bartolo Coyotepec'),
(1114, 20, 116, 'San Bartolomé Ayautla'),
(1115, 20, 117, 'San Bartolomé Loxicha'),
(1116, 20, 118, 'San Bartolomé Quialana'),
(1117, 20, 119, 'San Bartolomé Yucuañe'),
(1118, 20, 120, 'San Bartolomé Zoogocho'),
(1119, 20, 121, 'San Bartolo Soyaltepec'),
(1120, 20, 122, 'San Bartolo Yautepec'),
(1121, 20, 123, 'San Bernardo Mixtepec'),
(1122, 20, 124, 'San Blas Atempa'),
(1123, 20, 125, 'San Carlos Yautepec'),
(1124, 20, 126, 'San Cristóbal Amatlán'),
(1125, 20, 127, 'San Cristóbal Amoltepec'),
(1126, 20, 128, 'San Cristóbal Lachirioag'),
(1127, 20, 129, 'San Cristóbal Suchixtlahuaca'),
(1128, 20, 130, 'San Dionisio del Mar'),
(1129, 20, 131, 'San Dionisio Ocotepec'),
(1130, 20, 132, 'San Dionisio Ocotlán'),
(1131, 20, 133, 'San Esteban Atatlahuca'),
(1132, 20, 134, 'San Felipe Jalapa de Díaz'),
(1133, 20, 135, 'San Felipe Tejalápam'),
(1134, 20, 136, 'San Felipe Usila'),
(1135, 20, 137, 'San Francisco Cahuacuá'),
(1136, 20, 138, 'San Francisco Cajonos'),
(1137, 20, 139, 'San Francisco Chapulapa'),
(1138, 20, 140, 'San Francisco Chindúa'),
(1139, 20, 141, 'San Francisco del Mar'),
(1140, 20, 142, 'San Francisco Huehuetlán'),
(1141, 20, 143, 'San Francisco Ixhuatán'),
(1142, 20, 144, 'San Francisco Jaltepetongo'),
(1143, 20, 145, 'San Francisco Lachigoló'),
(1144, 20, 146, 'San Francisco Logueche'),
(1145, 20, 147, 'San Francisco Nuxaño'),
(1146, 20, 148, 'San Francisco Ozolotepec'),
(1147, 20, 149, 'San Francisco Sola'),
(1148, 20, 150, 'San Francisco Telixtlahuaca'),
(1149, 20, 151, 'San Francisco Teopan'),
(1150, 20, 152, 'San Francisco Tlapancingo'),
(1151, 20, 153, 'San Gabriel Mixtepec'),
(1152, 20, 154, 'San Ildefonso Amatlán'),
(1153, 20, 155, 'San Ildefonso Sola'),
(1154, 20, 156, 'San Ildefonso Villa Alta'),
(1155, 20, 157, 'San Jacinto Amilpas'),
(1156, 20, 158, 'San Jacinto Tlacotepec'),
(1157, 20, 159, 'San Jerónimo Coatlán'),
(1158, 20, 160, 'San Jerónimo Silacayoapilla'),
(1159, 20, 161, 'San Jerónimo Sosola'),
(1160, 20, 162, 'San Jerónimo Taviche'),
(1161, 20, 163, 'San Jerónimo Tecóatl'),
(1162, 20, 164, 'San Jorge Nuchita'),
(1163, 20, 165, 'San José Ayuquila'),
(1164, 20, 166, 'San José Chiltepec'),
(1165, 20, 167, 'San José del Peñasco'),
(1166, 20, 168, 'San José Estancia Grande'),
(1167, 20, 169, 'San José Independencia'),
(1168, 20, 170, 'San José Lachiguiri'),
(1169, 20, 171, 'San José Tenango'),
(1170, 20, 172, 'San Juan Achiutla'),
(1171, 20, 173, 'San Juan Atepec'),
(1172, 20, 174, 'Ánimas Trujano'),
(1173, 20, 175, 'San Juan Bautista Atatlahuca'),
(1174, 20, 176, 'San Juan Bautista Coixtlahuaca'),
(1175, 20, 177, 'San Juan Bautista Cuicatlán'),
(1176, 20, 178, 'San Juan Bautista Guelache'),
(1177, 20, 179, 'San Juan Bautista Jayacatlán'),
(1178, 20, 180, 'San Juan Bautista Lo de Soto'),
(1179, 20, 181, 'San Juan Bautista Suchitepec'),
(1180, 20, 182, 'San Juan Bautista Tlacoatzintepec'),
(1181, 20, 183, 'San Juan Bautista Tlachichilco'),
(1182, 20, 184, 'San Juan Bautista Tuxtepec'),
(1183, 20, 185, 'San Juan Cacahuatepec'),
(1184, 20, 186, 'San Juan Cieneguilla'),
(1185, 20, 187, 'San Juan Coatzóspam'),
(1186, 20, 188, 'San Juan Colorado'),
(1187, 20, 189, 'San Juan Comaltepec'),
(1188, 20, 190, 'San Juan Cotzocón'),
(1189, 20, 191, 'San Juan Chicomezúchil'),
(1190, 20, 192, 'San Juan Chilateca'),
(1191, 20, 193, 'San Juan del Estado'),
(1192, 20, 194, 'San Juan del Río'),
(1193, 20, 195, 'San Juan Diuxi'),
(1194, 20, 196, 'San Juan Evangelista Analco'),
(1195, 20, 197, 'San Juan Guelavía'),
(1196, 20, 198, 'San Juan Guichicovi'),
(1197, 20, 199, 'San Juan Ihualtepec'),
(1198, 20, 200, 'San Juan Juquila Mixes'),
(1199, 20, 201, 'San Juan Juquila Vijanos'),
(1200, 20, 202, 'San Juan Lachao'),
(1201, 20, 203, 'San Juan Lachigalla'),
(1202, 20, 204, 'San Juan Lajarcia'),
(1203, 20, 205, 'San Juan Lalana'),
(1204, 20, 206, 'San Juan de los Cués'),
(1205, 20, 207, 'San Juan Mazatlán'),
(1206, 20, 208, 'San Juan Mixtepec'),
(1207, 20, 209, 'San Juan Mixtepec'),
(1208, 20, 210, 'San Juan Ñumí'),
(1209, 20, 211, 'San Juan Ozolotepec'),
(1210, 20, 212, 'San Juan Petlapa'),
(1211, 20, 213, 'San Juan Quiahije'),
(1212, 20, 214, 'San Juan Quiotepec'),
(1213, 20, 215, 'San Juan Sayultepec'),
(1214, 20, 216, 'San Juan Tabaá'),
(1215, 20, 217, 'San Juan Tamazola'),
(1216, 20, 218, 'San Juan Teita'),
(1217, 20, 219, 'San Juan Teitipac'),
(1218, 20, 220, 'San Juan Tepeuxila'),
(1219, 20, 221, 'San Juan Teposcolula'),
(1220, 20, 222, 'San Juan Yaeé'),
(1221, 20, 223, 'San Juan Yatzona'),
(1222, 20, 224, 'San Juan Yucuita'),
(1223, 20, 225, 'San Lorenzo'),
(1224, 20, 226, 'San Lorenzo Albarradas'),
(1225, 20, 227, 'San Lorenzo Cacaotepec'),
(1226, 20, 228, 'San Lorenzo Cuaunecuiltitla'),
(1227, 20, 229, 'San Lorenzo Texmelúcan'),
(1228, 20, 230, 'San Lorenzo Victoria'),
(1229, 20, 231, 'San Lucas Camotlán'),
(1230, 20, 232, 'San Lucas Ojitlán'),
(1231, 20, 233, 'San Lucas Quiaviní'),
(1232, 20, 234, 'San Lucas Zoquiápam'),
(1233, 20, 235, 'San Luis Amatlán'),
(1234, 20, 236, 'San Marcial Ozolotepec'),
(1235, 20, 237, 'San Marcos Arteaga'),
(1236, 20, 238, 'San Martín de los Cansecos'),
(1237, 20, 239, 'San Martín Huamelúlpam'),
(1238, 20, 240, 'San Martín Itunyoso'),
(1239, 20, 241, 'San Martín Lachilá'),
(1240, 20, 242, 'San Martín Peras'),
(1241, 20, 243, 'San Martín Tilcajete'),
(1242, 20, 244, 'San Martín Toxpalan'),
(1243, 20, 245, 'San Martín Zacatepec'),
(1244, 20, 246, 'San Mateo Cajonos'),
(1245, 20, 247, 'Capulálpam de Méndez'),
(1246, 20, 248, 'San Mateo del Mar'),
(1247, 20, 249, 'San Mateo Yoloxochitlán'),
(1248, 20, 250, 'San Mateo Etlatongo'),
(1249, 20, 251, 'San Mateo Nejápam'),
(1250, 20, 252, 'San Mateo Peñasco'),
(1251, 20, 253, 'San Mateo Piñas'),
(1252, 20, 254, 'San Mateo Río Hondo'),
(1253, 20, 255, 'San Mateo Sindihui'),
(1254, 20, 256, 'San Mateo Tlapiltepec'),
(1255, 20, 257, 'San Melchor Betaza'),
(1256, 20, 258, 'San Miguel Achiutla'),
(1257, 20, 259, 'San Miguel Ahuehuetitlán'),
(1258, 20, 260, 'San Miguel Aloápam'),
(1259, 20, 261, 'San Miguel Amatitlán'),
(1260, 20, 262, 'San Miguel Amatlán'),
(1261, 20, 263, 'San Miguel Coatlán'),
(1262, 20, 264, 'San Miguel Chicahua'),
(1263, 20, 265, 'San Miguel Chimalapa'),
(1264, 20, 266, 'San Miguel del Puerto'),
(1265, 20, 267, 'San Miguel del Río'),
(1266, 20, 268, 'San Miguel Ejutla'),
(1267, 20, 269, 'San Miguel el Grande'),
(1268, 20, 270, 'San Miguel Huautla'),
(1269, 20, 271, 'San Miguel Mixtepec'),
(1270, 20, 272, 'San Miguel Panixtlahuaca'),
(1271, 20, 273, 'San Miguel Peras'),
(1272, 20, 274, 'San Miguel Piedras'),
(1273, 20, 275, 'San Miguel Quetzaltepec'),
(1274, 20, 276, 'San Miguel Santa Flor'),
(1275, 20, 277, 'Villa Sola de Vega'),
(1276, 20, 278, 'San Miguel Soyaltepec'),
(1277, 20, 279, 'San Miguel Suchixtepec'),
(1278, 20, 280, 'Villa Talea de Castro'),
(1279, 20, 281, 'San Miguel Tecomatlán'),
(1280, 20, 282, 'San Miguel Tenango'),
(1281, 20, 283, 'San Miguel Tequixtepec'),
(1282, 20, 284, 'San Miguel Tilquiápam'),
(1283, 20, 285, 'San Miguel Tlacamama'),
(1284, 20, 286, 'San Miguel Tlacotepec'),
(1285, 20, 287, 'San Miguel Tulancingo'),
(1286, 20, 288, 'San Miguel Yotao'),
(1287, 20, 289, 'San Nicolás'),
(1288, 20, 290, 'San Nicolás Hidalgo'),
(1289, 20, 291, 'San Pablo Coatlán'),
(1290, 20, 292, 'San Pablo Cuatro Venados'),
(1291, 20, 293, 'San Pablo Etla'),
(1292, 20, 294, 'San Pablo Huitzo'),
(1293, 20, 295, 'San Pablo Huixtepec'),
(1294, 20, 296, 'San Pablo Macuiltianguis'),
(1295, 20, 297, 'San Pablo Tijaltepec'),
(1296, 20, 298, 'San Pablo Villa de Mitla'),
(1297, 20, 299, 'San Pablo Yaganiza'),
(1298, 20, 300, 'San Pedro Amuzgos'),
(1299, 20, 301, 'San Pedro Apóstol'),
(1300, 20, 302, 'San Pedro Atoyac'),
(1301, 20, 303, 'San Pedro Cajonos'),
(1302, 20, 304, 'San Pedro Coxcaltepec Cántaros'),
(1303, 20, 305, 'San Pedro Comitancillo'),
(1304, 20, 306, 'San Pedro el Alto'),
(1305, 20, 307, 'San Pedro Huamelula'),
(1306, 20, 308, 'San Pedro Huilotepec'),
(1307, 20, 309, 'San Pedro Ixcatlán'),
(1308, 20, 310, 'San Pedro Ixtlahuaca'),
(1309, 20, 311, 'San Pedro Jaltepetongo'),
(1310, 20, 312, 'San Pedro Jicayán'),
(1311, 20, 313, 'San Pedro Jocotipac'),
(1312, 20, 314, 'San Pedro Juchatengo'),
(1313, 20, 315, 'San Pedro Mártir'),
(1314, 20, 316, 'San Pedro Mártir Quiechapa'),
(1315, 20, 317, 'San Pedro Mártir Yucuxaco'),
(1316, 20, 318, 'San Pedro Mixtepec'),
(1317, 20, 319, 'San Pedro Mixtepec'),
(1318, 20, 320, 'San Pedro Molinos'),
(1319, 20, 321, 'San Pedro Nopala'),
(1320, 20, 322, 'San Pedro Ocopetatillo'),
(1321, 20, 323, 'San Pedro Ocotepec'),
(1322, 20, 324, 'San Pedro Pochutla'),
(1323, 20, 325, 'San Pedro Quiatoni'),
(1324, 20, 326, 'San Pedro Sochiápam'),
(1325, 20, 327, 'San Pedro Tapanatepec'),
(1326, 20, 328, 'San Pedro Taviche'),
(1327, 20, 329, 'San Pedro Teozacoalco'),
(1328, 20, 330, 'San Pedro Teutila'),
(1329, 20, 331, 'San Pedro Tidaá'),
(1330, 20, 332, 'San Pedro Topiltepec'),
(1331, 20, 333, 'San Pedro Totolápam'),
(1332, 20, 334, 'Villa de Tututepec de Melchor Ocampo'),
(1333, 20, 335, 'San Pedro Yaneri'),
(1334, 20, 336, 'San Pedro Yólox'),
(1335, 20, 337, 'San Pedro y San Pablo Ayutla'),
(1336, 20, 338, 'Villa de Etla'),
(1337, 20, 339, 'San Pedro y San Pablo Teposcolula'),
(1338, 20, 340, 'San Pedro y San Pablo Tequixtepec'),
(1339, 20, 341, 'San Pedro Yucunama'),
(1340, 20, 342, 'San Raymundo Jalpan'),
(1341, 20, 343, 'San Sebastián Abasolo'),
(1342, 20, 344, 'San Sebastián Coatlán'),
(1343, 20, 345, 'San Sebastián Ixcapa'),
(1344, 20, 346, 'San Sebastián Nicananduta'),
(1345, 20, 347, 'San Sebastián Río Hondo'),
(1346, 20, 348, 'San Sebastián Tecomaxtlahuaca'),
(1347, 20, 349, 'San Sebastián Teitipac'),
(1348, 20, 350, 'San Sebastián Tutla'),
(1349, 20, 351, 'San Simón Almolongas'),
(1350, 20, 352, 'San Simón Zahuatlán'),
(1351, 20, 353, 'Santa Ana'),
(1352, 20, 354, 'Santa Ana Ateixtlahuaca'),
(1353, 20, 355, 'Santa Ana Cuauhtémoc'),
(1354, 20, 356, 'Santa Ana del Valle'),
(1355, 20, 357, 'Santa Ana Tavela'),
(1356, 20, 358, 'Santa Ana Tlapacoyan'),
(1357, 20, 359, 'Santa Ana Yareni'),
(1358, 20, 360, 'Santa Ana Zegache'),
(1359, 20, 361, 'Santa Catalina Quierí'),
(1360, 20, 362, 'Santa Catarina Cuixtla'),
(1361, 20, 363, 'Santa Catarina Ixtepeji'),
(1362, 20, 364, 'Santa Catarina Juquila'),
(1363, 20, 365, 'Santa Catarina Lachatao'),
(1364, 20, 366, 'Santa Catarina Loxicha'),
(1365, 20, 367, 'Santa Catarina Mechoacán'),
(1366, 20, 368, 'Santa Catarina Minas'),
(1367, 20, 369, 'Santa Catarina Quiané'),
(1368, 20, 370, 'Santa Catarina Tayata'),
(1369, 20, 371, 'Santa Catarina Ticuá'),
(1370, 20, 372, 'Santa Catarina Yosonotú'),
(1371, 20, 373, 'Santa Catarina Zapoquila'),
(1372, 20, 374, 'Santa Cruz Acatepec'),
(1373, 20, 375, 'Santa Cruz Amilpas'),
(1374, 20, 376, 'Santa Cruz de Bravo'),
(1375, 20, 377, 'Santa Cruz Itundujia'),
(1376, 20, 378, 'Santa Cruz Mixtepec'),
(1377, 20, 379, 'Santa Cruz Nundaco'),
(1378, 20, 380, 'Santa Cruz Papalutla'),
(1379, 20, 381, 'Santa Cruz Tacache de Mina'),
(1380, 20, 382, 'Santa Cruz Tacahua'),
(1381, 20, 383, 'Santa Cruz Tayata'),
(1382, 20, 384, 'Santa Cruz Xitla'),
(1383, 20, 385, 'Santa Cruz Xoxocotlán'),
(1384, 20, 386, 'Santa Cruz Zenzontepec'),
(1385, 20, 387, 'Santa Gertrudis'),
(1386, 20, 388, 'Santa Inés del Monte'),
(1387, 20, 389, 'Santa Inés Yatzeche'),
(1388, 20, 390, 'Santa Lucía del Camino'),
(1389, 20, 391, 'Santa Lucía Miahuatlán'),
(1390, 20, 392, 'Santa Lucía Monteverde'),
(1391, 20, 393, 'Santa Lucía Ocotlán'),
(1392, 20, 394, 'Santa María Alotepec'),
(1393, 20, 395, 'Santa María Apazco'),
(1394, 20, 396, 'Santa María la Asunción'),
(1395, 20, 397, 'Heroica Ciudad de Tlaxiaco'),
(1396, 20, 398, 'Ayoquezco de Aldama'),
(1397, 20, 399, 'Santa María Atzompa'),
(1398, 20, 400, 'Santa María Camotlán'),
(1399, 20, 401, 'Santa María Colotepec'),
(1400, 20, 402, 'Santa María Cortijo'),
(1401, 20, 403, 'Santa María Coyotepec'),
(1402, 20, 404, 'Santa María Chachoápam'),
(1403, 20, 405, 'Villa de Chilapa de Díaz'),
(1404, 20, 406, 'Santa María Chilchotla'),
(1405, 20, 407, 'Santa María Chimalapa'),
(1406, 20, 408, 'Santa María del Rosario'),
(1407, 20, 409, 'Santa María del Tule'),
(1408, 20, 410, 'Santa María Ecatepec'),
(1409, 20, 411, 'Santa María Guelacé'),
(1410, 20, 412, 'Santa María Guienagati'),
(1411, 20, 413, 'Santa María Huatulco'),
(1412, 20, 414, 'Santa María Huazolotitlán'),
(1413, 20, 415, 'Santa María Ipalapa'),
(1414, 20, 416, 'Santa María Ixcatlán'),
(1415, 20, 417, 'Santa María Jacatepec'),
(1416, 20, 418, 'Santa María Jalapa del Marqués'),
(1417, 20, 419, 'Santa María Jaltianguis'),
(1418, 20, 420, 'Santa María Lachixío'),
(1419, 20, 421, 'Santa María Mixtequilla'),
(1420, 20, 422, 'Santa María Nativitas'),
(1421, 20, 423, 'Santa María Nduayaco'),
(1422, 20, 424, 'Santa María Ozolotepec'),
(1423, 20, 425, 'Santa María Pápalo'),
(1424, 20, 426, 'Santa María Peñoles'),
(1425, 20, 427, 'Santa María Petapa'),
(1426, 20, 428, 'Santa María Quiegolani'),
(1427, 20, 429, 'Santa María Sola'),
(1428, 20, 430, 'Santa María Tataltepec'),
(1429, 20, 431, 'Santa María Tecomavaca'),
(1430, 20, 432, 'Santa María Temaxcalapa'),
(1431, 20, 433, 'Santa María Temaxcaltepec'),
(1432, 20, 434, 'Santa María Teopoxco'),
(1433, 20, 435, 'Santa María Tepantlali'),
(1434, 20, 436, 'Santa María Texcatitlán'),
(1435, 20, 437, 'Santa María Tlahuitoltepec'),
(1436, 20, 438, 'Santa María Tlalixtac'),
(1437, 20, 439, 'Santa María Tonameca'),
(1438, 20, 440, 'Santa María Totolapilla'),
(1439, 20, 441, 'Santa María Xadani'),
(1440, 20, 442, 'Santa María Yalina'),
(1441, 20, 443, 'Santa María Yavesía'),
(1442, 20, 444, 'Santa María Yolotepec'),
(1443, 20, 445, 'Santa María Yosoyúa'),
(1444, 20, 446, 'Santa María Yucuhiti'),
(1445, 20, 447, 'Santa María Zacatepec'),
(1446, 20, 448, 'Santa María Zaniza'),
(1447, 20, 449, 'Santa María Zoquitlán'),
(1448, 20, 450, 'Santiago Amoltepec'),
(1449, 20, 451, 'Santiago Apoala'),
(1450, 20, 452, 'Santiago Apóstol'),
(1451, 20, 453, 'Santiago Astata'),
(1452, 20, 454, 'Santiago Atitlán'),
(1453, 20, 455, 'Santiago Ayuquililla'),
(1454, 20, 456, 'Santiago Cacaloxtepec'),
(1455, 20, 457, 'Santiago Camotlán'),
(1456, 20, 458, 'Santiago Comaltepec'),
(1457, 20, 459, 'Santiago Chazumba'),
(1458, 20, 460, 'Santiago Choápam'),
(1459, 20, 461, 'Santiago del Río'),
(1460, 20, 462, 'Santiago Huajolotitlán'),
(1461, 20, 463, 'Santiago Huauclilla'),
(1462, 20, 464, 'Santiago Ihuitlán Plumas'),
(1463, 20, 465, 'Santiago Ixcuintepec'),
(1464, 20, 466, 'Santiago Ixtayutla'),
(1465, 20, 467, 'Santiago Jamiltepec'),
(1466, 20, 468, 'Santiago Jocotepec'),
(1467, 20, 469, 'Santiago Juxtlahuaca'),
(1468, 20, 470, 'Santiago Lachiguiri'),
(1469, 20, 471, 'Santiago Lalopa'),
(1470, 20, 472, 'Santiago Laollaga'),
(1471, 20, 473, 'Santiago Laxopa'),
(1472, 20, 474, 'Santiago Llano Grande'),
(1473, 20, 475, 'Santiago Matatlán'),
(1474, 20, 476, 'Santiago Miltepec'),
(1475, 20, 477, 'Santiago Minas'),
(1476, 20, 478, 'Santiago Nacaltepec'),
(1477, 20, 479, 'Santiago Nejapilla'),
(1478, 20, 480, 'Santiago Nundiche'),
(1479, 20, 481, 'Santiago Nuyoó'),
(1480, 20, 482, 'Santiago Pinotepa Nacional'),
(1481, 20, 483, 'Santiago Suchilquitongo'),
(1482, 20, 484, 'Santiago Tamazola'),
(1483, 20, 485, 'Santiago Tapextla'),
(1484, 20, 486, 'Villa Tejúpam de la Unión'),
(1485, 20, 487, 'Santiago Tenango'),
(1486, 20, 488, 'Santiago Tepetlapa'),
(1487, 20, 489, 'Santiago Tetepec'),
(1488, 20, 490, 'Santiago Texcalcingo'),
(1489, 20, 491, 'Santiago Textitlán'),
(1490, 20, 492, 'Santiago Tilantongo'),
(1491, 20, 493, 'Santiago Tillo'),
(1492, 20, 494, 'Santiago Tlazoyaltepec'),
(1493, 20, 495, 'Santiago Xanica'),
(1494, 20, 496, 'Santiago Xiacuí'),
(1495, 20, 497, 'Santiago Yaitepec'),
(1496, 20, 498, 'Santiago Yaveo'),
(1497, 20, 499, 'Santiago Yolomécatl'),
(1498, 20, 500, 'Santiago Yosondúa'),
(1499, 20, 501, 'Santiago Yucuyachi'),
(1500, 20, 502, 'Santiago Zacatepec'),
(1501, 20, 503, 'Santiago Zoochila'),
(1502, 20, 504, 'Nuevo Zoquiápam'),
(1503, 20, 505, 'Santo Domingo Ingenio'),
(1504, 20, 506, 'Santo Domingo Albarradas'),
(1505, 20, 507, 'Santo Domingo Armenta'),
(1506, 20, 508, 'Santo Domingo Chihuitán'),
(1507, 20, 509, 'Santo Domingo de Morelos'),
(1508, 20, 510, 'Santo Domingo Ixcatlán'),
(1509, 20, 511, 'Santo Domingo Nuxaá'),
(1510, 20, 512, 'Santo Domingo Ozolotepec'),
(1511, 20, 513, 'Santo Domingo Petapa'),
(1512, 20, 514, 'Santo Domingo Roayaga'),
(1513, 20, 515, 'Santo Domingo Tehuantepec'),
(1514, 20, 516, 'Santo Domingo Teojomulco'),
(1515, 20, 517, 'Santo Domingo Tepuxtepec'),
(1516, 20, 518, 'Santo Domingo Tlatayápam'),
(1517, 20, 519, 'Santo Domingo Tomaltepec'),
(1518, 20, 520, 'Santo Domingo Tonalá'),
(1519, 20, 521, 'Santo Domingo Tonaltepec'),
(1520, 20, 522, 'Santo Domingo Xagacía'),
(1521, 20, 523, 'Santo Domingo Yanhuitlán'),
(1522, 20, 524, 'Santo Domingo Yodohino'),
(1523, 20, 525, 'Santo Domingo Zanatepec'),
(1524, 20, 526, 'Santos Reyes Nopala'),
(1525, 20, 527, 'Santos Reyes Pápalo'),
(1526, 20, 528, 'Santos Reyes Tepejillo'),
(1527, 20, 529, 'Santos Reyes Yucuná'),
(1528, 20, 530, 'Santo Tomás Jalieza'),
(1529, 20, 531, 'Santo Tomás Mazaltepec'),
(1530, 20, 532, 'Santo Tomás Ocotepec'),
(1531, 20, 533, 'Santo Tomás Tamazulapan'),
(1532, 20, 534, 'San Vicente Coatlán'),
(1533, 20, 535, 'San Vicente Lachixío'),
(1534, 20, 536, 'San Vicente Nuñú'),
(1535, 20, 537, 'Silacayoápam'),
(1536, 20, 538, 'Sitio de Xitlapehua'),
(1537, 20, 539, 'Soledad Etla'),
(1538, 20, 540, 'Villa de Tamazulápam del Progreso'),
(1539, 20, 541, 'Tanetze de Zaragoza'),
(1540, 20, 542, 'Taniche'),
(1541, 20, 543, 'Tataltepec de Valdés'),
(1542, 20, 544, 'Teococuilco de Marcos Pérez'),
(1543, 20, 545, 'Teotitlán de Flores Magón'),
(1544, 20, 546, 'Teotitlán del Valle'),
(1545, 20, 547, 'Teotongo'),
(1546, 20, 548, 'Tepelmeme Villa de Morelos'),
(1547, 20, 549, 'Heroica Villa Tezoatlán de Segura y Luna, Cuna de la Independencia de Oaxaca'),
(1548, 20, 550, 'San Jerónimo Tlacochahuaya'),
(1549, 20, 551, 'Tlacolula de Matamoros'),
(1550, 20, 552, 'Tlacotepec Plumas'),
(1551, 20, 553, 'Tlalixtac de Cabrera'),
(1552, 20, 554, 'Totontepec Villa de Morelos'),
(1553, 20, 555, 'Trinidad Zaachila'),
(1554, 20, 556, 'La Trinidad Vista Hermosa'),
(1555, 20, 557, 'Unión Hidalgo'),
(1556, 20, 558, 'Valerio Trujano'),
(1557, 20, 559, 'San Juan Bautista Valle Nacional'),
(1558, 20, 560, 'Villa Díaz Ordaz'),
(1559, 20, 561, 'Yaxe'),
(1560, 20, 562, 'Magdalena Yodocono de Porfirio Díaz'),
(1561, 20, 563, 'Yogana'),
(1562, 20, 564, 'Yutanduchi de Guerrero'),
(1563, 20, 565, 'Villa de Zaachila');
INSERT INTO `Municipios` (`id`, `estados_id`, `c_mnpio`, `nombre`) VALUES
(1564, 20, 566, 'San Mateo Yucutindoo'),
(1565, 20, 567, 'Zapotitlán Lagunas'),
(1566, 20, 568, 'Zapotitlán Palmas'),
(1567, 20, 569, 'Santa Inés de Zaragoza'),
(1568, 20, 570, 'Zimatlán de Álvarez'),
(1569, 21, 1, 'Acajete'),
(1570, 21, 2, 'Acateno'),
(1571, 21, 3, 'Acatlán'),
(1572, 21, 4, 'Acatzingo'),
(1573, 21, 5, 'Acteopan'),
(1574, 21, 6, 'Ahuacatlán'),
(1575, 21, 7, 'Ahuatlán'),
(1576, 21, 8, 'Ahuazotepec'),
(1577, 21, 9, 'Ahuehuetitla'),
(1578, 21, 10, 'Ajalpan'),
(1579, 21, 11, 'Albino Zertuche'),
(1580, 21, 12, 'Aljojuca'),
(1581, 21, 13, 'Altepexi'),
(1582, 21, 14, 'Amixtlán'),
(1583, 21, 15, 'Amozoc'),
(1584, 21, 16, 'Aquixtla'),
(1585, 21, 17, 'Atempan'),
(1586, 21, 18, 'Atexcal'),
(1587, 21, 19, 'Atlixco'),
(1588, 21, 20, 'Atoyatempan'),
(1589, 21, 21, 'Atzala'),
(1590, 21, 22, 'Atzitzihuacán'),
(1591, 21, 23, 'Atzitzintla'),
(1592, 21, 24, 'Axutla'),
(1593, 21, 25, 'Ayotoxco de Guerrero'),
(1594, 21, 26, 'Calpan'),
(1595, 21, 27, 'Caltepec'),
(1596, 21, 28, 'Camocuautla'),
(1597, 21, 29, 'Caxhuacan'),
(1598, 21, 30, 'Coatepec'),
(1599, 21, 31, 'Coatzingo'),
(1600, 21, 32, 'Cohetzala'),
(1601, 21, 33, 'Cohuecan'),
(1602, 21, 34, 'Coronango'),
(1603, 21, 35, 'Coxcatlán'),
(1604, 21, 36, 'Coyomeapan'),
(1605, 21, 37, 'Coyotepec'),
(1606, 21, 38, 'Cuapiaxtla de Madero'),
(1607, 21, 39, 'Cuautempan'),
(1608, 21, 40, 'Cuautinchán'),
(1609, 21, 41, 'Cuautlancingo'),
(1610, 21, 42, 'Cuayuca de Andrade'),
(1611, 21, 43, 'Cuetzalan del Progreso'),
(1612, 21, 44, 'Cuyoaco'),
(1613, 21, 45, 'Chalchicomula de Sesma'),
(1614, 21, 46, 'Chapulco'),
(1615, 21, 47, 'Chiautla'),
(1616, 21, 48, 'Chiautzingo'),
(1617, 21, 49, 'Chiconcuautla'),
(1618, 21, 50, 'Chichiquila'),
(1619, 21, 51, 'Chietla'),
(1620, 21, 52, 'Chigmecatitlán'),
(1621, 21, 53, 'Chignahuapan'),
(1622, 21, 54, 'Chignautla'),
(1623, 21, 55, 'Chila'),
(1624, 21, 56, 'Chila de la Sal'),
(1625, 21, 57, 'Honey'),
(1626, 21, 58, 'Chilchotla'),
(1627, 21, 59, 'Chinantla'),
(1628, 21, 60, 'Domingo Arenas'),
(1629, 21, 61, 'Eloxochitlán'),
(1630, 21, 62, 'Epatlán'),
(1631, 21, 63, 'Esperanza'),
(1632, 21, 64, 'Francisco Z. Mena'),
(1633, 21, 65, 'General Felipe Ángeles'),
(1634, 21, 66, 'Guadalupe'),
(1635, 21, 67, 'Guadalupe Victoria'),
(1636, 21, 68, 'Hermenegildo Galeana'),
(1637, 21, 69, 'Huaquechula'),
(1638, 21, 70, 'Huatlatlauca'),
(1639, 21, 71, 'Huauchinango'),
(1640, 21, 72, 'Huehuetla'),
(1641, 21, 73, 'Huehuetlán el Chico'),
(1642, 21, 74, 'Huejotzingo'),
(1643, 21, 75, 'Hueyapan'),
(1644, 21, 76, 'Hueytamalco'),
(1645, 21, 77, 'Hueytlalpan'),
(1646, 21, 78, 'Huitzilan de Serdán'),
(1647, 21, 79, 'Huitziltepec'),
(1648, 21, 80, 'Atlequizayan'),
(1649, 21, 81, 'Ixcamilpa de Guerrero'),
(1650, 21, 82, 'Ixcaquixtla'),
(1651, 21, 83, 'Ixtacamaxtitlán'),
(1652, 21, 84, 'Ixtepec'),
(1653, 21, 85, 'Izúcar de Matamoros'),
(1654, 21, 86, 'Jalpan'),
(1655, 21, 87, 'Jolalpan'),
(1656, 21, 88, 'Jonotla'),
(1657, 21, 89, 'Jopala'),
(1658, 21, 90, 'Juan C. Bonilla'),
(1659, 21, 91, 'Juan Galindo'),
(1660, 21, 92, 'Juan N. Méndez'),
(1661, 21, 93, 'Lafragua'),
(1662, 21, 94, 'Libres'),
(1663, 21, 95, 'La Magdalena Tlatlauquitepec'),
(1664, 21, 96, 'Mazapiltepec de Juárez'),
(1665, 21, 97, 'Mixtla'),
(1666, 21, 98, 'Molcaxac'),
(1667, 21, 99, 'Cañada Morelos'),
(1668, 21, 100, 'Naupan'),
(1669, 21, 101, 'Nauzontla'),
(1670, 21, 102, 'Nealtican'),
(1671, 21, 103, 'Nicolás Bravo'),
(1672, 21, 104, 'Nopalucan'),
(1673, 21, 105, 'Ocotepec'),
(1674, 21, 106, 'Ocoyucan'),
(1675, 21, 107, 'Olintla'),
(1676, 21, 108, 'Oriental'),
(1677, 21, 109, 'Pahuatlán'),
(1678, 21, 110, 'Palmar de Bravo'),
(1679, 21, 111, 'Pantepec'),
(1680, 21, 112, 'Petlalcingo'),
(1681, 21, 113, 'Piaxtla'),
(1682, 21, 114, 'Puebla'),
(1683, 21, 115, 'Quecholac'),
(1684, 21, 116, 'Quimixtlán'),
(1685, 21, 117, 'Rafael Lara Grajales'),
(1686, 21, 118, 'Los Reyes de Juárez'),
(1687, 21, 119, 'San Andrés Cholula'),
(1688, 21, 120, 'San Antonio Cañada'),
(1689, 21, 121, 'San Diego la Mesa Tochimiltzingo'),
(1690, 21, 122, 'San Felipe Teotlalcingo'),
(1691, 21, 123, 'San Felipe Tepatlán'),
(1692, 21, 124, 'San Gabriel Chilac'),
(1693, 21, 125, 'San Gregorio Atzompa'),
(1694, 21, 126, 'San Jerónimo Tecuanipan'),
(1695, 21, 127, 'San Jerónimo Xayacatlán'),
(1696, 21, 128, 'San José Chiapa'),
(1697, 21, 129, 'San José Miahuatlán'),
(1698, 21, 130, 'San Juan Atenco'),
(1699, 21, 131, 'San Juan Atzompa'),
(1700, 21, 132, 'San Martín Texmelucan'),
(1701, 21, 133, 'San Martín Totoltepec'),
(1702, 21, 134, 'San Matías Tlalancaleca'),
(1703, 21, 135, 'San Miguel Ixitlán'),
(1704, 21, 136, 'San Miguel Xoxtla'),
(1705, 21, 137, 'San Nicolás Buenos Aires'),
(1706, 21, 138, 'San Nicolás de los Ranchos'),
(1707, 21, 139, 'San Pablo Anicano'),
(1708, 21, 140, 'San Pedro Cholula'),
(1709, 21, 141, 'San Pedro Yeloixtlahuaca'),
(1710, 21, 142, 'San Salvador el Seco'),
(1711, 21, 143, 'San Salvador el Verde'),
(1712, 21, 144, 'San Salvador Huixcolotla'),
(1713, 21, 145, 'San Sebastián Tlacotepec'),
(1714, 21, 146, 'Santa Catarina Tlaltempan'),
(1715, 21, 147, 'Santa Inés Ahuatempan'),
(1716, 21, 148, 'Santa Isabel Cholula'),
(1717, 21, 149, 'Santiago Miahuatlán'),
(1718, 21, 150, 'Huehuetlán el Grande'),
(1719, 21, 151, 'Santo Tomás Hueyotlipan'),
(1720, 21, 152, 'Soltepec'),
(1721, 21, 153, 'Tecali de Herrera'),
(1722, 21, 154, 'Tecamachalco'),
(1723, 21, 155, 'Tecomatlán'),
(1724, 21, 156, 'Tehuacán'),
(1725, 21, 157, 'Tehuitzingo'),
(1726, 21, 158, 'Tenampulco'),
(1727, 21, 159, 'Teopantlán'),
(1728, 21, 160, 'Teotlalco'),
(1729, 21, 161, 'Tepanco de López'),
(1730, 21, 162, 'Tepango de Rodríguez'),
(1731, 21, 163, 'Tepatlaxco de Hidalgo'),
(1732, 21, 164, 'Tepeaca'),
(1733, 21, 165, 'Tepemaxalco'),
(1734, 21, 166, 'Tepeojuma'),
(1735, 21, 167, 'Tepetzintla'),
(1736, 21, 168, 'Tepexco'),
(1737, 21, 169, 'Tepexi de Rodríguez'),
(1738, 21, 170, 'Tepeyahualco'),
(1739, 21, 171, 'Tepeyahualco de Cuauhtémoc'),
(1740, 21, 172, 'Tetela de Ocampo'),
(1741, 21, 173, 'Teteles de Avila Castillo'),
(1742, 21, 174, 'Teziutlán'),
(1743, 21, 175, 'Tianguismanalco'),
(1744, 21, 176, 'Tilapa'),
(1745, 21, 177, 'Tlacotepec de Benito Juárez'),
(1746, 21, 178, 'Tlacuilotepec'),
(1747, 21, 179, 'Tlachichuca'),
(1748, 21, 180, 'Tlahuapan'),
(1749, 21, 181, 'Tlaltenango'),
(1750, 21, 182, 'Tlanepantla'),
(1751, 21, 183, 'Tlaola'),
(1752, 21, 184, 'Tlapacoya'),
(1753, 21, 185, 'Tlapanalá'),
(1754, 21, 186, 'Tlatlauquitepec'),
(1755, 21, 187, 'Tlaxco'),
(1756, 21, 188, 'Tochimilco'),
(1757, 21, 189, 'Tochtepec'),
(1758, 21, 190, 'Totoltepec de Guerrero'),
(1759, 21, 191, 'Tulcingo'),
(1760, 21, 192, 'Tuzamapan de Galeana'),
(1761, 21, 193, 'Tzicatlacoyan'),
(1762, 21, 194, 'Venustiano Carranza'),
(1763, 21, 195, 'Vicente Guerrero'),
(1764, 21, 196, 'Xayacatlán de Bravo'),
(1765, 21, 197, 'Xicotepec'),
(1766, 21, 198, 'Xicotlán'),
(1767, 21, 199, 'Xiutetelco'),
(1768, 21, 200, 'Xochiapulco'),
(1769, 21, 201, 'Xochiltepec'),
(1770, 21, 202, 'Xochitlán de Vicente Suárez'),
(1771, 21, 203, 'Xochitlán Todos Santos'),
(1772, 21, 204, 'Yaonáhuac'),
(1773, 21, 205, 'Yehualtepec'),
(1774, 21, 206, 'Zacapala'),
(1775, 21, 207, 'Zacapoaxtla'),
(1776, 21, 208, 'Zacatlán'),
(1777, 21, 209, 'Zapotitlán'),
(1778, 21, 210, 'Zapotitlán de Méndez'),
(1779, 21, 211, 'Zaragoza'),
(1780, 21, 212, 'Zautla'),
(1781, 21, 213, 'Zihuateutla'),
(1782, 21, 214, 'Zinacatepec'),
(1783, 21, 215, 'Zongozotla'),
(1784, 21, 216, 'Zoquiapan'),
(1785, 21, 217, 'Zoquitlán'),
(1786, 22, 1, 'Amealco de Bonfil'),
(1787, 22, 2, 'Pinal de Amoles'),
(1788, 22, 3, 'Arroyo Seco'),
(1789, 22, 4, 'Cadereyta de Montes'),
(1790, 22, 5, 'Colón'),
(1791, 22, 6, 'Corregidora'),
(1792, 22, 7, 'Ezequiel Montes'),
(1793, 22, 8, 'Huimilpan'),
(1794, 22, 9, 'Jalpan de Serra'),
(1795, 22, 10, 'Landa de Matamoros'),
(1796, 22, 11, 'El Marqués'),
(1797, 22, 12, 'Pedro Escobedo'),
(1798, 22, 13, 'Peñamiller'),
(1799, 22, 14, 'Querétaro'),
(1800, 22, 15, 'San Joaquín'),
(1801, 22, 16, 'San Juan del Río'),
(1802, 22, 17, 'Tequisquiapan'),
(1803, 22, 18, 'Tolimán'),
(1804, 23, 1, 'Cozumel'),
(1805, 23, 2, 'Felipe Carrillo Puerto'),
(1806, 23, 3, 'Isla Mujeres'),
(1807, 23, 4, 'Othón P. Blanco'),
(1808, 23, 5, 'Benito Juárez'),
(1809, 23, 6, 'José María Morelos'),
(1810, 23, 7, 'Lázaro Cárdenas'),
(1811, 23, 8, 'Solidaridad'),
(1812, 23, 9, 'Tulum'),
(1813, 23, 10, 'Bacalar'),
(1814, 24, 1, 'Ahualulco'),
(1815, 24, 2, 'Alaquines'),
(1816, 24, 3, 'Aquismón'),
(1817, 24, 4, 'Armadillo de los Infante'),
(1818, 24, 5, 'Cárdenas'),
(1819, 24, 6, 'Catorce'),
(1820, 24, 7, 'Cedral'),
(1821, 24, 8, 'Cerritos'),
(1822, 24, 9, 'Cerro de San Pedro'),
(1823, 24, 10, 'Ciudad del Maíz'),
(1824, 24, 11, 'Ciudad Fernández'),
(1825, 24, 12, 'Tancanhuitz'),
(1826, 24, 13, 'Ciudad Valles'),
(1827, 24, 14, 'Coxcatlán'),
(1828, 24, 15, 'Charcas'),
(1829, 24, 16, 'Ebano'),
(1830, 24, 17, 'Guadalcázar'),
(1831, 24, 18, 'Huehuetlán'),
(1832, 24, 19, 'Lagunillas'),
(1833, 24, 20, 'Matehuala'),
(1834, 24, 21, 'Mexquitic de Carmona'),
(1835, 24, 22, 'Moctezuma'),
(1836, 24, 23, 'Rayón'),
(1837, 24, 24, 'Rioverde'),
(1838, 24, 25, 'Salinas'),
(1839, 24, 26, 'San Antonio'),
(1840, 24, 27, 'San Ciro de Acosta'),
(1841, 24, 28, 'San Luis Potosí'),
(1842, 24, 29, 'San Martín Chalchicuautla'),
(1843, 24, 30, 'San Nicolás Tolentino'),
(1844, 24, 31, 'Santa Catarina'),
(1845, 24, 32, 'Santa María del Río'),
(1846, 24, 33, 'Santo Domingo'),
(1847, 24, 34, 'San Vicente Tancuayalab'),
(1848, 24, 35, 'Soledad de Graciano Sánchez'),
(1849, 24, 36, 'Tamasopo'),
(1850, 24, 37, 'Tamazunchale'),
(1851, 24, 38, 'Tampacán'),
(1852, 24, 39, 'Tampamolón Corona'),
(1853, 24, 40, 'Tamuín'),
(1854, 24, 41, 'Tanlajás'),
(1855, 24, 42, 'Tanquián de Escobedo'),
(1856, 24, 43, 'Tierra Nueva'),
(1857, 24, 44, 'Vanegas'),
(1858, 24, 45, 'Venado'),
(1859, 24, 46, 'Villa de Arriaga'),
(1860, 24, 47, 'Villa de Guadalupe'),
(1861, 24, 48, 'Villa de la Paz'),
(1862, 24, 49, 'Villa de Ramos'),
(1863, 24, 50, 'Villa de Reyes'),
(1864, 24, 51, 'Villa Hidalgo'),
(1865, 24, 52, 'Villa Juárez'),
(1866, 24, 53, 'Axtla de Terrazas'),
(1867, 24, 54, 'Xilitla'),
(1868, 24, 55, 'Zaragoza'),
(1869, 24, 56, 'Villa de Arista'),
(1870, 24, 57, 'Matlapa'),
(1871, 24, 58, 'El Naranjo'),
(1872, 25, 1, 'Ahome'),
(1873, 25, 2, 'Angostura'),
(1874, 25, 3, 'Badiraguato'),
(1875, 25, 4, 'Concordia'),
(1876, 25, 5, 'Cosalá'),
(1877, 25, 6, 'Culiacán'),
(1878, 25, 7, 'Choix'),
(1879, 25, 8, 'Elota'),
(1880, 25, 9, 'Escuinapa'),
(1881, 25, 10, 'El Fuerte'),
(1882, 25, 11, 'Guasave'),
(1883, 25, 12, 'Mazatlán'),
(1884, 25, 13, 'Mocorito'),
(1885, 25, 14, 'Rosario'),
(1886, 25, 15, 'Salvador Alvarado'),
(1887, 25, 16, 'San Ignacio'),
(1888, 25, 17, 'Sinaloa'),
(1889, 25, 18, 'Navolato'),
(1890, 26, 1, 'Aconchi'),
(1891, 26, 2, 'Agua Prieta'),
(1892, 26, 3, 'Alamos'),
(1893, 26, 4, 'Altar'),
(1894, 26, 5, 'Arivechi'),
(1895, 26, 6, 'Arizpe'),
(1896, 26, 7, 'Atil'),
(1897, 26, 8, 'Bacadéhuachi'),
(1898, 26, 9, 'Bacanora'),
(1899, 26, 10, 'Bacerac'),
(1900, 26, 11, 'Bacoachi'),
(1901, 26, 12, 'Bácum'),
(1902, 26, 13, 'Banámichi'),
(1903, 26, 14, 'Baviácora'),
(1904, 26, 15, 'Bavispe'),
(1905, 26, 16, 'Benjamín Hill'),
(1906, 26, 17, 'Caborca'),
(1907, 26, 18, 'Cajeme'),
(1908, 26, 19, 'Cananea'),
(1909, 26, 20, 'Carbó'),
(1910, 26, 21, 'La Colorada'),
(1911, 26, 22, 'Cucurpe'),
(1912, 26, 23, 'Cumpas'),
(1913, 26, 24, 'Divisaderos'),
(1914, 26, 25, 'Empalme'),
(1915, 26, 26, 'Etchojoa'),
(1916, 26, 27, 'Fronteras'),
(1917, 26, 28, 'Granados'),
(1918, 26, 29, 'Guaymas'),
(1919, 26, 30, 'Hermosillo'),
(1920, 26, 31, 'Huachinera'),
(1921, 26, 32, 'Huásabas'),
(1922, 26, 33, 'Huatabampo'),
(1923, 26, 34, 'Huépac'),
(1924, 26, 35, 'Imuris'),
(1925, 26, 36, 'Magdalena'),
(1926, 26, 37, 'Mazatán'),
(1927, 26, 38, 'Moctezuma'),
(1928, 26, 39, 'Naco'),
(1929, 26, 40, 'Nácori Chico'),
(1930, 26, 41, 'Nacozari de García'),
(1931, 26, 42, 'Navojoa'),
(1932, 26, 43, 'Nogales'),
(1933, 26, 44, 'Onavas'),
(1934, 26, 45, 'Opodepe'),
(1935, 26, 46, 'Oquitoa'),
(1936, 26, 47, 'Pitiquito'),
(1937, 26, 48, 'Puerto Peñasco'),
(1938, 26, 49, 'Quiriego'),
(1939, 26, 50, 'Rayón'),
(1940, 26, 51, 'Rosario'),
(1941, 26, 52, 'Sahuaripa'),
(1942, 26, 53, 'San Felipe de Jesús'),
(1943, 26, 54, 'San Javier'),
(1944, 26, 55, 'San Luis Río Colorado'),
(1945, 26, 56, 'San Miguel de Horcasitas'),
(1946, 26, 57, 'San Pedro de la Cueva'),
(1947, 26, 58, 'Santa Ana'),
(1948, 26, 59, 'Santa Cruz'),
(1949, 26, 60, 'Sáric'),
(1950, 26, 61, 'Soyopa'),
(1951, 26, 62, 'Suaqui Grande'),
(1952, 26, 63, 'Tepache'),
(1953, 26, 64, 'Trincheras'),
(1954, 26, 65, 'Tubutama'),
(1955, 26, 66, 'Ures'),
(1956, 26, 67, 'Villa Hidalgo'),
(1957, 26, 68, 'Villa Pesqueira'),
(1958, 26, 69, 'Yécora'),
(1959, 26, 70, 'General Plutarco Elías Calles'),
(1960, 26, 71, 'Benito Juárez'),
(1961, 26, 72, 'San Ignacio Río Muerto'),
(1962, 27, 1, 'Balancán'),
(1963, 27, 2, 'Cárdenas'),
(1964, 27, 3, 'Centla'),
(1965, 27, 4, 'Centro'),
(1966, 27, 5, 'Comalcalco'),
(1967, 27, 6, 'Cunduacán'),
(1968, 27, 7, 'Emiliano Zapata'),
(1969, 27, 8, 'Huimanguillo'),
(1970, 27, 9, 'Jalapa'),
(1971, 27, 10, 'Jalpa de Méndez'),
(1972, 27, 11, 'Jonuta'),
(1973, 27, 12, 'Macuspana'),
(1974, 27, 13, 'Nacajuca'),
(1975, 27, 14, 'Paraíso'),
(1976, 27, 15, 'Tacotalpa'),
(1977, 27, 16, 'Teapa'),
(1978, 27, 17, 'Tenosique'),
(1979, 28, 1, 'Abasolo'),
(1980, 28, 2, 'Aldama'),
(1981, 28, 3, 'Altamira'),
(1982, 28, 4, 'Antiguo Morelos'),
(1983, 28, 5, 'Burgos'),
(1984, 28, 6, 'Bustamante'),
(1985, 28, 7, 'Camargo'),
(1986, 28, 8, 'Casas'),
(1987, 28, 9, 'Ciudad Madero'),
(1988, 28, 10, 'Cruillas'),
(1989, 28, 11, 'Gómez Farías'),
(1990, 28, 12, 'González'),
(1991, 28, 13, 'Güémez'),
(1992, 28, 14, 'Guerrero'),
(1993, 28, 15, 'Gustavo Díaz Ordaz'),
(1994, 28, 16, 'Hidalgo'),
(1995, 28, 17, 'Jaumave'),
(1996, 28, 18, 'Jiménez'),
(1997, 28, 19, 'Llera'),
(1998, 28, 20, 'Mainero'),
(1999, 28, 21, 'El Mante'),
(2000, 28, 22, 'Matamoros'),
(2001, 28, 23, 'Méndez'),
(2002, 28, 24, 'Mier'),
(2003, 28, 25, 'Miguel Alemán'),
(2004, 28, 26, 'Miquihuana'),
(2005, 28, 27, 'Nuevo Laredo'),
(2006, 28, 28, 'Nuevo Morelos'),
(2007, 28, 29, 'Ocampo'),
(2008, 28, 30, 'Padilla'),
(2009, 28, 31, 'Palmillas'),
(2010, 28, 32, 'Reynosa'),
(2011, 28, 33, 'Río Bravo'),
(2012, 28, 34, 'San Carlos'),
(2013, 28, 35, 'San Fernando'),
(2014, 28, 36, 'San Nicolás'),
(2015, 28, 37, 'Soto la Marina'),
(2016, 28, 38, 'Tampico'),
(2017, 28, 39, 'Tula'),
(2018, 28, 40, 'Valle Hermoso'),
(2019, 28, 41, 'Victoria'),
(2020, 28, 42, 'Villagrán'),
(2021, 28, 43, 'Xicoténcatl'),
(2022, 29, 1, 'Amaxac de Guerrero'),
(2023, 29, 2, 'Apetatitlán de Antonio Carvajal'),
(2024, 29, 3, 'Atlangatepec'),
(2025, 29, 4, 'Atltzayanca'),
(2026, 29, 5, 'Apizaco'),
(2027, 29, 6, 'Calpulalpan'),
(2028, 29, 7, 'El Carmen Tequexquitla'),
(2029, 29, 8, 'Cuapiaxtla'),
(2030, 29, 9, 'Cuaxomulco'),
(2031, 29, 10, 'Chiautempan'),
(2032, 29, 11, 'Muñoz de Domingo Arenas'),
(2033, 29, 12, 'Españita'),
(2034, 29, 13, 'Huamantla'),
(2035, 29, 14, 'Hueyotlipan'),
(2036, 29, 15, 'Ixtacuixtla de Mariano Matamoros'),
(2037, 29, 16, 'Ixtenco'),
(2038, 29, 17, 'Mazatecochco de José María Morelos'),
(2039, 29, 18, 'Contla de Juan Cuamatzi'),
(2040, 29, 19, 'Tepetitla de Lardizábal'),
(2041, 29, 20, 'Sanctórum de Lázaro Cárdenas'),
(2042, 29, 21, 'Nanacamilpa de Mariano Arista'),
(2043, 29, 22, 'Acuamanala de Miguel Hidalgo'),
(2044, 29, 23, 'Natívitas'),
(2045, 29, 24, 'Panotla'),
(2046, 29, 25, 'San Pablo del Monte'),
(2047, 29, 26, 'Santa Cruz Tlaxcala'),
(2048, 29, 27, 'Tenancingo'),
(2049, 29, 28, 'Teolocholco'),
(2050, 29, 29, 'Tepeyanco'),
(2051, 29, 30, 'Terrenate'),
(2052, 29, 31, 'Tetla de la Solidaridad'),
(2053, 29, 32, 'Tetlatlahuca'),
(2054, 29, 33, 'Tlaxcala'),
(2055, 29, 34, 'Tlaxco'),
(2056, 29, 35, 'Tocatlán'),
(2057, 29, 36, 'Totolac'),
(2058, 29, 37, 'Ziltlaltépec de Trinidad Sánchez Santos'),
(2059, 29, 38, 'Tzompantepec'),
(2060, 29, 39, 'Xaloztoc'),
(2061, 29, 40, 'Xaltocan'),
(2062, 29, 41, 'Papalotla de Xicohténcatl'),
(2063, 29, 42, 'Xicohtzinco'),
(2064, 29, 43, 'Yauhquemehcan'),
(2065, 29, 44, 'Zacatelco'),
(2066, 29, 45, 'Benito Juárez'),
(2067, 29, 46, 'Emiliano Zapata'),
(2068, 29, 47, 'Lázaro Cárdenas'),
(2069, 29, 48, 'La Magdalena Tlaltelulco'),
(2070, 29, 49, 'San Damián Texóloc'),
(2071, 29, 50, 'San Francisco Tetlanohcan'),
(2072, 29, 51, 'San Jerónimo Zacualpan'),
(2073, 29, 52, 'San José Teacalco'),
(2074, 29, 53, 'San Juan Huactzinco'),
(2075, 29, 54, 'San Lorenzo Axocomanitla'),
(2076, 29, 55, 'San Lucas Tecopilco'),
(2077, 29, 56, 'Santa Ana Nopalucan'),
(2078, 29, 57, 'Santa Apolonia Teacalco'),
(2079, 29, 58, 'Santa Catarina Ayometla'),
(2080, 29, 59, 'Santa Cruz Quilehtla'),
(2081, 29, 60, 'Santa Isabel Xiloxoxtla'),
(2082, 30, 1, 'Acajete'),
(2083, 30, 2, 'Acatlán'),
(2084, 30, 3, 'Acayucan'),
(2085, 30, 4, 'Actopan'),
(2086, 30, 5, 'Acula'),
(2087, 30, 6, 'Acultzingo'),
(2088, 30, 7, 'Camarón de Tejeda'),
(2089, 30, 8, 'Alpatláhuac'),
(2090, 30, 9, 'Alto Lucero de Gutiérrez Barrios'),
(2091, 30, 10, 'Altotonga'),
(2092, 30, 11, 'Alvarado'),
(2093, 30, 12, 'Amatitlán'),
(2094, 30, 13, 'Naranjos Amatlán'),
(2095, 30, 14, 'Amatlán de los Reyes'),
(2096, 30, 15, 'Angel R. Cabada'),
(2097, 30, 16, 'La Antigua'),
(2098, 30, 17, 'Apazapan'),
(2099, 30, 18, 'Aquila'),
(2100, 30, 19, 'Astacinga'),
(2101, 30, 20, 'Atlahuilco'),
(2102, 30, 21, 'Atoyac'),
(2103, 30, 22, 'Atzacan'),
(2104, 30, 23, 'Atzalan'),
(2105, 30, 24, 'Tlaltetela'),
(2106, 30, 25, 'Ayahualulco'),
(2107, 30, 26, 'Banderilla'),
(2108, 30, 27, 'Benito Juárez'),
(2109, 30, 28, 'Boca del Río'),
(2110, 30, 29, 'Calcahualco'),
(2111, 30, 30, 'Camerino Z. Mendoza'),
(2112, 30, 31, 'Carrillo Puerto'),
(2113, 30, 32, 'Catemaco'),
(2114, 30, 33, 'Cazones de Herrera'),
(2115, 30, 34, 'Cerro Azul'),
(2116, 30, 35, 'Citlaltépetl'),
(2117, 30, 36, 'Coacoatzintla'),
(2118, 30, 37, 'Coahuitlán'),
(2119, 30, 38, 'Coatepec'),
(2120, 30, 39, 'Coatzacoalcos'),
(2121, 30, 40, 'Coatzintla'),
(2122, 30, 41, 'Coetzala'),
(2123, 30, 42, 'Colipa'),
(2124, 30, 43, 'Comapa'),
(2125, 30, 44, 'Córdoba'),
(2126, 30, 45, 'Cosamaloapan de Carpio'),
(2127, 30, 46, 'Cosautlán de Carvajal'),
(2128, 30, 47, 'Coscomatepec'),
(2129, 30, 48, 'Cosoleacaque'),
(2130, 30, 49, 'Cotaxtla'),
(2131, 30, 50, 'Coxquihui'),
(2132, 30, 51, 'Coyutla'),
(2133, 30, 52, 'Cuichapa'),
(2134, 30, 53, 'Cuitláhuac'),
(2135, 30, 54, 'Chacaltianguis'),
(2136, 30, 55, 'Chalma'),
(2137, 30, 56, 'Chiconamel'),
(2138, 30, 57, 'Chiconquiaco'),
(2139, 30, 58, 'Chicontepec'),
(2140, 30, 59, 'Chinameca'),
(2141, 30, 60, 'Chinampa de Gorostiza'),
(2142, 30, 61, 'Las Choapas'),
(2143, 30, 62, 'Chocamán'),
(2144, 30, 63, 'Chontla'),
(2145, 30, 64, 'Chumatlán'),
(2146, 30, 65, 'Emiliano Zapata'),
(2147, 30, 66, 'Espinal'),
(2148, 30, 67, 'Filomeno Mata'),
(2149, 30, 68, 'Fortín'),
(2150, 30, 69, 'Gutiérrez Zamora'),
(2151, 30, 70, 'Hidalgotitlán'),
(2152, 30, 71, 'Huatusco'),
(2153, 30, 72, 'Huayacocotla'),
(2154, 30, 73, 'Hueyapan de Ocampo'),
(2155, 30, 74, 'Huiloapan de Cuauhtémoc'),
(2156, 30, 75, 'Ignacio de la Llave'),
(2157, 30, 76, 'Ilamatlán'),
(2158, 30, 77, 'Isla'),
(2159, 30, 78, 'Ixcatepec'),
(2160, 30, 79, 'Ixhuacán de los Reyes'),
(2161, 30, 80, 'Ixhuatlán del Café'),
(2162, 30, 81, 'Ixhuatlancillo'),
(2163, 30, 82, 'Ixhuatlán del Sureste'),
(2164, 30, 83, 'Ixhuatlán de Madero'),
(2165, 30, 84, 'Ixmatlahuacan'),
(2166, 30, 85, 'Ixtaczoquitlán'),
(2167, 30, 86, 'Jalacingo'),
(2168, 30, 87, 'Xalapa'),
(2169, 30, 88, 'Jalcomulco'),
(2170, 30, 89, 'Jáltipan'),
(2171, 30, 90, 'Jamapa'),
(2172, 30, 91, 'Jesús Carranza'),
(2173, 30, 92, 'Xico'),
(2174, 30, 93, 'Jilotepec'),
(2175, 30, 94, 'Juan Rodríguez Clara'),
(2176, 30, 95, 'Juchique de Ferrer'),
(2177, 30, 96, 'Landero y Coss'),
(2178, 30, 97, 'Lerdo de Tejada'),
(2179, 30, 98, 'Magdalena'),
(2180, 30, 99, 'Maltrata'),
(2181, 30, 100, 'Manlio Fabio Altamirano'),
(2182, 30, 101, 'Mariano Escobedo'),
(2183, 30, 102, 'Martínez de la Torre'),
(2184, 30, 103, 'Mecatlán'),
(2185, 30, 104, 'Mecayapan'),
(2186, 30, 105, 'Medellín de Bravo'),
(2187, 30, 106, 'Miahuatlán'),
(2188, 30, 107, 'Las Minas'),
(2189, 30, 108, 'Minatitlán'),
(2190, 30, 109, 'Misantla'),
(2191, 30, 110, 'Mixtla de Altamirano'),
(2192, 30, 111, 'Moloacán'),
(2193, 30, 112, 'Naolinco'),
(2194, 30, 113, 'Naranjal'),
(2195, 30, 114, 'Nautla'),
(2196, 30, 115, 'Nogales'),
(2197, 30, 116, 'Oluta'),
(2198, 30, 117, 'Omealca'),
(2199, 30, 118, 'Orizaba'),
(2200, 30, 119, 'Otatitlán'),
(2201, 30, 120, 'Oteapan'),
(2202, 30, 121, 'Ozuluama de Mascareñas'),
(2203, 30, 122, 'Pajapan'),
(2204, 30, 123, 'Pánuco'),
(2205, 30, 124, 'Papantla'),
(2206, 30, 125, 'Paso del Macho'),
(2207, 30, 126, 'Paso de Ovejas'),
(2208, 30, 127, 'La Perla'),
(2209, 30, 128, 'Perote'),
(2210, 30, 129, 'Platón Sánchez'),
(2211, 30, 130, 'Playa Vicente'),
(2212, 30, 131, 'Poza Rica de Hidalgo'),
(2213, 30, 132, 'Las Vigas de Ramírez'),
(2214, 30, 133, 'Pueblo Viejo'),
(2215, 30, 134, 'Puente Nacional'),
(2216, 30, 135, 'Rafael Delgado'),
(2217, 30, 136, 'Rafael Lucio'),
(2218, 30, 137, 'Los Reyes'),
(2219, 30, 138, 'Río Blanco'),
(2220, 30, 139, 'Saltabarranca'),
(2221, 30, 140, 'San Andrés Tenejapan'),
(2222, 30, 141, 'San Andrés Tuxtla'),
(2223, 30, 142, 'San Juan Evangelista'),
(2224, 30, 143, 'Santiago Tuxtla'),
(2225, 30, 144, 'Sayula de Alemán'),
(2226, 30, 145, 'Soconusco'),
(2227, 30, 146, 'Sochiapa'),
(2228, 30, 147, 'Soledad Atzompa'),
(2229, 30, 148, 'Soledad de Doblado'),
(2230, 30, 149, 'Soteapan'),
(2231, 30, 150, 'Tamalín'),
(2232, 30, 151, 'Tamiahua'),
(2233, 30, 152, 'Tampico Alto'),
(2234, 30, 153, 'Tancoco'),
(2235, 30, 154, 'Tantima'),
(2236, 30, 155, 'Tantoyuca'),
(2237, 30, 156, 'Tatatila'),
(2238, 30, 157, 'Castillo de Teayo'),
(2239, 30, 158, 'Tecolutla'),
(2240, 30, 159, 'Tehuipango'),
(2241, 30, 160, 'Álamo Temapache'),
(2242, 30, 161, 'Tempoal'),
(2243, 30, 162, 'Tenampa'),
(2244, 30, 163, 'Tenochtitlán'),
(2245, 30, 164, 'Teocelo'),
(2246, 30, 165, 'Tepatlaxco'),
(2247, 30, 166, 'Tepetlán'),
(2248, 30, 167, 'Tepetzintla'),
(2249, 30, 168, 'Tequila'),
(2250, 30, 169, 'José Azueta'),
(2251, 30, 170, 'Texcatepec'),
(2252, 30, 171, 'Texhuacán'),
(2253, 30, 172, 'Texistepec'),
(2254, 30, 173, 'Tezonapa'),
(2255, 30, 174, 'Tierra Blanca'),
(2256, 30, 175, 'Tihuatlán'),
(2257, 30, 176, 'Tlacojalpan'),
(2258, 30, 177, 'Tlacolulan'),
(2259, 30, 178, 'Tlacotalpan'),
(2260, 30, 179, 'Tlacotepec de Mejía'),
(2261, 30, 180, 'Tlachichilco'),
(2262, 30, 181, 'Tlalixcoyan'),
(2263, 30, 182, 'Tlalnelhuayocan'),
(2264, 30, 183, 'Tlapacoyan'),
(2265, 30, 184, 'Tlaquilpa'),
(2266, 30, 185, 'Tlilapan'),
(2267, 30, 186, 'Tomatlán'),
(2268, 30, 187, 'Tonayán'),
(2269, 30, 188, 'Totutla'),
(2270, 30, 189, 'Tuxpan'),
(2271, 30, 190, 'Tuxtilla'),
(2272, 30, 191, 'Ursulo Galván'),
(2273, 30, 192, 'Vega de Alatorre'),
(2274, 30, 193, 'Veracruz'),
(2275, 30, 194, 'Villa Aldama'),
(2276, 30, 195, 'Xoxocotla'),
(2277, 30, 196, 'Yanga'),
(2278, 30, 197, 'Yecuatla'),
(2279, 30, 198, 'Zacualpan'),
(2280, 30, 199, 'Zaragoza'),
(2281, 30, 200, 'Zentla'),
(2282, 30, 201, 'Zongolica'),
(2283, 30, 202, 'Zontecomatlán de López y Fuentes'),
(2284, 30, 203, 'Zozocolco de Hidalgo'),
(2285, 30, 204, 'Agua Dulce'),
(2286, 30, 205, 'El Higo'),
(2287, 30, 206, 'Nanchital de Lázaro Cárdenas del Río'),
(2288, 30, 207, 'Tres Valles'),
(2289, 30, 208, 'Carlos A. Carrillo'),
(2290, 30, 209, 'Tatahuicapan de Juárez'),
(2291, 30, 210, 'Uxpanapa'),
(2292, 30, 211, 'San Rafael'),
(2293, 30, 212, 'Santiago Sochiapan'),
(2294, 31, 1, 'Abalá'),
(2295, 31, 2, 'Acanceh'),
(2296, 31, 3, 'Akil'),
(2297, 31, 4, 'Baca'),
(2298, 31, 5, 'Bokobá'),
(2299, 31, 6, 'Buctzotz'),
(2300, 31, 7, 'Cacalchén'),
(2301, 31, 8, 'Calotmul'),
(2302, 31, 9, 'Cansahcab'),
(2303, 31, 10, 'Cantamayec'),
(2304, 31, 11, 'Celestún'),
(2305, 31, 12, 'Cenotillo'),
(2306, 31, 13, 'Conkal'),
(2307, 31, 14, 'Cuncunul'),
(2308, 31, 15, 'Cuzamá'),
(2309, 31, 16, 'Chacsinkín'),
(2310, 31, 17, 'Chankom'),
(2311, 31, 18, 'Chapab'),
(2312, 31, 19, 'Chemax'),
(2313, 31, 20, 'Chicxulub Pueblo'),
(2314, 31, 21, 'Chichimilá'),
(2315, 31, 22, 'Chikindzonot'),
(2316, 31, 23, 'Chocholá'),
(2317, 31, 24, 'Chumayel'),
(2318, 31, 25, 'Dzán'),
(2319, 31, 26, 'Dzemul'),
(2320, 31, 27, 'Dzidzantún'),
(2321, 31, 28, 'Dzilam de Bravo'),
(2322, 31, 29, 'Dzilam González'),
(2323, 31, 30, 'Dzitás'),
(2324, 31, 31, 'Dzoncauich'),
(2325, 31, 32, 'Espita'),
(2326, 31, 33, 'Halachó'),
(2327, 31, 34, 'Hocabá'),
(2328, 31, 35, 'Hoctún'),
(2329, 31, 36, 'Homún'),
(2330, 31, 37, 'Huhí'),
(2331, 31, 38, 'Hunucmá'),
(2332, 31, 39, 'Ixil'),
(2333, 31, 40, 'Izamal'),
(2334, 31, 41, 'Kanasín'),
(2335, 31, 42, 'Kantunil'),
(2336, 31, 43, 'Kaua'),
(2337, 31, 44, 'Kinchil'),
(2338, 31, 45, 'Kopomá'),
(2339, 31, 46, 'Mama'),
(2340, 31, 47, 'Maní'),
(2341, 31, 48, 'Maxcanú'),
(2342, 31, 49, 'Mayapán'),
(2343, 31, 50, 'Mérida'),
(2344, 31, 51, 'Mocochá'),
(2345, 31, 52, 'Motul'),
(2346, 31, 53, 'Muna'),
(2347, 31, 54, 'Muxupip'),
(2348, 31, 55, 'Opichén'),
(2349, 31, 56, 'Oxkutzcab'),
(2350, 31, 57, 'Panabá'),
(2351, 31, 58, 'Peto'),
(2352, 31, 59, 'Progreso'),
(2353, 31, 60, 'Quintana Roo'),
(2354, 31, 61, 'Río Lagartos'),
(2355, 31, 62, 'Sacalum'),
(2356, 31, 63, 'Samahil'),
(2357, 31, 64, 'Sanahcat'),
(2358, 31, 65, 'San Felipe'),
(2359, 31, 66, 'Santa Elena'),
(2360, 31, 67, 'Seyé'),
(2361, 31, 68, 'Sinanché'),
(2362, 31, 69, 'Sotuta'),
(2363, 31, 70, 'Sucilá'),
(2364, 31, 71, 'Sudzal'),
(2365, 31, 72, 'Suma'),
(2366, 31, 73, 'Tahdziú'),
(2367, 31, 74, 'Tahmek'),
(2368, 31, 75, 'Teabo'),
(2369, 31, 76, 'Tecoh'),
(2370, 31, 77, 'Tekal de Venegas'),
(2371, 31, 78, 'Tekantó'),
(2372, 31, 79, 'Tekax'),
(2373, 31, 80, 'Tekit'),
(2374, 31, 81, 'Tekom'),
(2375, 31, 82, 'Telchac Pueblo'),
(2376, 31, 83, 'Telchac Puerto'),
(2377, 31, 84, 'Temax'),
(2378, 31, 85, 'Temozón'),
(2379, 31, 86, 'Tepakán'),
(2380, 31, 87, 'Tetiz'),
(2381, 31, 88, 'Teya'),
(2382, 31, 89, 'Ticul'),
(2383, 31, 90, 'Timucuy'),
(2384, 31, 91, 'Tinum'),
(2385, 31, 92, 'Tixcacalcupul'),
(2386, 31, 93, 'Tixkokob'),
(2387, 31, 94, 'Tixmehuac'),
(2388, 31, 95, 'Tixpéhual'),
(2389, 31, 96, 'Tizimín'),
(2390, 31, 97, 'Tunkás'),
(2391, 31, 98, 'Tzucacab'),
(2392, 31, 99, 'Uayma'),
(2393, 31, 100, 'Ucú'),
(2394, 31, 101, 'Umán'),
(2395, 31, 102, 'Valladolid'),
(2396, 31, 103, 'Xocchel'),
(2397, 31, 104, 'Yaxcabá'),
(2398, 31, 105, 'Yaxkukul'),
(2399, 31, 106, 'Yobaín'),
(2400, 32, 1, 'Apozol'),
(2401, 32, 2, 'Apulco'),
(2402, 32, 3, 'Atolinga'),
(2403, 32, 4, 'Benito Juárez'),
(2404, 32, 5, 'Calera'),
(2405, 32, 6, 'Cañitas de Felipe Pescador'),
(2406, 32, 7, 'Concepción del Oro'),
(2407, 32, 8, 'Cuauhtémoc'),
(2408, 32, 9, 'Chalchihuites'),
(2409, 32, 10, 'Fresnillo'),
(2410, 32, 11, 'Trinidad García de la Cadena'),
(2411, 32, 12, 'Genaro Codina'),
(2412, 32, 13, 'General Enrique Estrada'),
(2413, 32, 14, 'General Francisco R. Murguía'),
(2414, 32, 15, 'El Plateado de Joaquín Amaro'),
(2415, 32, 16, 'General Pánfilo Natera'),
(2416, 32, 17, 'Guadalupe'),
(2417, 32, 18, 'Huanusco'),
(2418, 32, 19, 'Jalpa'),
(2419, 32, 20, 'Jerez'),
(2420, 32, 21, 'Jiménez del Teul'),
(2421, 32, 22, 'Juan Aldama'),
(2422, 32, 23, 'Juchipila'),
(2423, 32, 24, 'Loreto'),
(2424, 32, 25, 'Luis Moya'),
(2425, 32, 26, 'Mazapil'),
(2426, 32, 27, 'Melchor Ocampo'),
(2427, 32, 28, 'Mezquital del Oro'),
(2428, 32, 29, 'Miguel Auza'),
(2429, 32, 30, 'Momax'),
(2430, 32, 31, 'Monte Escobedo'),
(2431, 32, 32, 'Morelos'),
(2432, 32, 33, 'Moyahua de Estrada'),
(2433, 32, 34, 'Nochistlán de Mejía'),
(2434, 32, 35, 'Noria de Ángeles'),
(2435, 32, 36, 'Ojocaliente'),
(2436, 32, 37, 'Pánuco'),
(2437, 32, 38, 'Pinos'),
(2438, 32, 39, 'Río Grande'),
(2439, 32, 40, 'Sain Alto'),
(2440, 32, 41, 'El Salvador'),
(2441, 32, 42, 'Sombrerete'),
(2442, 32, 43, 'Susticacán'),
(2443, 32, 44, 'Tabasco'),
(2444, 32, 45, 'Tepechitlán'),
(2445, 32, 46, 'Tepetongo'),
(2446, 32, 47, 'Teúl de González Ortega'),
(2447, 32, 48, 'Tlaltenango de Sánchez Román'),
(2448, 32, 49, 'Valparaíso'),
(2449, 32, 50, 'Vetagrande'),
(2450, 32, 51, 'Villa de Cos'),
(2451, 32, 52, 'Villa García'),
(2452, 32, 53, 'Villa González Ortega'),
(2453, 32, 54, 'Villa Hidalgo'),
(2454, 32, 55, 'Villanueva'),
(2455, 32, 56, 'Zacatecas'),
(2456, 32, 57, 'Trancoso'),
(2457, 32, 58, 'Santa María de la Paz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pollutants`
--

CREATE TABLE `Pollutants` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `units` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Pollutants`
--

INSERT INTO `Pollutants` (`id`, `name`, `code`, `deleted_at`, `units`) VALUES
(1, 'NOx', 'NOX', NULL, 'g/km'),
(2, 'CO2', 'CO2', NULL, 'g/l'),
(3, 'PM2.5', 'PM25', NULL, 'g/km'),
(4, 'PM10', 'PM10', NULL, 'g/km'),
(5, 'Carbono Negro', 'CN', NULL, 'g/km');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PwdRecovery`
--

CREATE TABLE `PwdRecovery` (
  `id` int(11) NOT NULL,
  `elem_id` int(11) DEFAULT NULL,
  `hash` varchar(64) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `used` tinyint(4) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `contacts_id` varchar(45) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Ranges`
--

CREATE TABLE `Ranges` (
  `id` int(11) NOT NULL,
  `field` varchar(45) DEFAULT NULL,
  `green_low` double DEFAULT NULL,
  `green_high` double DEFAULT NULL,
  `yellow_low` double DEFAULT NULL,
  `yelloos_high` double DEFAULT NULL,
  `red_low` double DEFAULT NULL,
  `red_high` double DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Sources`
--

CREATE TABLE `Sources` (
  `id` int(11) NOT NULL,
  `fleet_id` int(11) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `ID_EMPLEADO` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Users`
--

INSERT INTO `Users` (`id`, `email`, `name`, `password`, `deleted_at`, `username`, `status`, `ID_EMPLEADO`) VALUES
(1, 'admin@semarnat.gob.mx', 'Administrador', '$2y$10$8Wp9W19Iq8Yek3i.85nte.vJEl5BJl5u.E3gChEdZuc1FqwWSxK8u', NULL, 'administrator', 100, NULL);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Validations_Values`
--

CREATE TABLE `Validations_Values` (
  `id` int(11) NOT NULL,
  `validations_id` int(11) DEFAULT NULL,
  `vclass_id` int(11) DEFAULT NULL,
  `categories_id` int(11) DEFAULT NULL,
  `min` float DEFAULT NULL,
  `red_low` float DEFAULT NULL,
  `yellow_low` float DEFAULT NULL,
  `yellow_high` float DEFAULT NULL,
  `red_high` float DEFAULT NULL,
  `max` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Validations_Values`
--

INSERT INTO `Validations_Values` (`id`, `validations_id`, `vclass_id`, `categories_id`, `min`, `red_low`, `yellow_low`, `yellow_high`, `red_high`, `max`) VALUES
(1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 3, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 1, 4, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1, 6, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, 7, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, 8, 1, 0, 11239, 29627, 139957, 158347, 804500),
(9, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 1, 2, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 1, 3, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 1, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 1, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 1, 6, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 1, 7, 2, 0, 24948, 42095, 112630, 127607, 804500),
(16, 1, 8, 2, 0, 59435, 84863, 237434, 262862, 804500),
(17, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 1, 2, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 1, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 1, 4, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 1, 5, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 1, 6, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 1, 7, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 1, 8, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 1, 2, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 1, 3, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 1, 4, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 1, 5, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 1, 6, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 1, 7, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 1, 8, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 1, 2, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 1, 3, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 1, 4, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 1, 5, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 1, 6, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 1, 7, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 1, 8, 5, 0, 59428, 76419, 178367, 195358, 804500),
(41, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 1, 2, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 1, 3, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 1, 4, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 1, 5, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 1, 6, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 1, 7, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 1, 8, 6, 0, 58733, 75745, 177822, 194834, 804500),
(49, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 1, 2, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 1, 3, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 1, 4, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 1, 5, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 1, 6, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 1, 7, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 1, 8, 7, 0, 71071, 78299, 162699, 174042, 804500),
(57, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 1, 2, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 1, 3, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 1, 4, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 1, 5, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 1, 6, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 1, 7, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 1, 8, 8, 0, 69367, 83296, 166869, 180799, 804500),
(65, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 1, 2, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 1, 3, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 1, 4, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 1, 5, 9, 0, 4827, 12872, 109584, 127925, 804500),
(70, 1, 6, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 1, 7, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 1, 8, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 1, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 1, 2, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 1, 3, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 1, 4, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 1, 5, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 1, 6, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 1, 7, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(88, 1, 8, 11, 0, 33411, 64125, 169489, 188950, 804500),
(89, 1, 1, 12, 0, 3292, 12455, 85972, 114868, 804500),
(90, 1, 2, 12, 0, 0, 8045, 73551, 86587, 804500),
(91, 1, 3, 12, 0, 2256, 10549, 64474, 82641, 804500),
(92, 1, 4, 12, 0, 492.354, 5583, 64360, 79621, 804500),
(93, 1, 5, 12, 0, 3276, 17588, 83533, 107826, 804500),
(94, 1, 6, 12, 0, 0, 8045, 108704, 126619, 804500),
(95, 1, 7, 12, 0, 10090, 20980, 138197, 164118, 804500),
(96, 1, 8, 12, 0, 19355, 44210, 193350, 218206, 804500),
(97, 1, 1, 13, 0, 8442, 18608, 77129, 105390, 804500),
(98, 1, 2, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(99, 1, 3, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(100, 1, 4, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(101, 1, 5, 13, 0, 9527, 14598, 104585, 115953, 804500),
(102, 1, 6, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(103, 1, 7, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(104, 1, 8, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(105, 1, 1, 14, 0, 15604, 26038, 101414, 146097, 804500),
(106, 1, 2, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(107, 1, 3, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(108, 1, 4, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(109, 1, 5, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 1, 6, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(111, 1, 7, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(112, 1, 8, 14, 0, 37371, 43623, 149407, 225633, 804500),
(113, 2, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(114, 2, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 2, 3, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(116, 2, 4, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 2, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 2, 6, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(119, 2, 7, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(120, 2, 8, 1, 0, 1.96, 2.08, 2.89, 3.02, 4.46),
(121, 2, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(122, 2, 2, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(123, 2, 3, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(124, 2, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 2, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(126, 2, 6, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 2, 7, 2, 0, 2.25, 2.47, 2.89, 3.23, 5.31),
(128, 2, 8, 2, 0, 2, 2.13, 2.93, 3.1, 5.06),
(129, 2, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(130, 2, 2, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(131, 2, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(132, 2, 4, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(133, 2, 5, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(134, 2, 6, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(135, 2, 7, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(136, 2, 8, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(137, 2, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(138, 2, 2, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(139, 2, 3, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(140, 2, 4, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(141, 2, 5, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(142, 2, 6, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(143, 2, 7, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(144, 2, 8, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(145, 2, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(146, 2, 2, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(147, 2, 3, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(148, 2, 4, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(149, 2, 5, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(150, 2, 6, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(151, 2, 7, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(152, 2, 8, 5, 0, 1.91, 2.08, 2.85, 3.02, 4.59),
(153, 2, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(154, 2, 2, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(155, 2, 3, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(156, 2, 4, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(157, 2, 5, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(158, 2, 6, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(159, 2, 7, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(160, 2, 8, 6, 0, 1.87, 2.04, 3.02, 3.19, 4.59),
(161, 2, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(162, 2, 2, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(163, 2, 3, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(164, 2, 4, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(165, 2, 5, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(166, 2, 6, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(167, 2, 7, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(168, 2, 8, 7, 0, 1.79, 2, 2.47, 2.59, 4.21),
(169, 2, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(170, 2, 2, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(171, 2, 3, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(172, 2, 4, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(173, 2, 5, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(174, 2, 6, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(175, 2, 7, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(176, 2, 8, 8, 0, 1.7, 1.91, 2.3, 2.51, 3.95),
(177, 2, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(178, 2, 2, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(179, 2, 3, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(180, 2, 4, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(181, 2, 5, 9, 0, 2.47, 2.64, 3.61, 3.78, 7.65),
(182, 2, 6, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(183, 2, 7, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(184, 2, 8, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(193, 2, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(194, 2, 2, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(195, 2, 3, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(196, 2, 4, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(197, 2, 5, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(198, 2, 6, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(199, 2, 7, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(200, 2, 8, 11, 0, 1.19, 1.79, 2.59, 2.76, 4.29),
(201, 2, 1, 12, 0, 2.93, 3.49, 7.48, 8.46, 14.62),
(202, 2, 2, 12, 0, 1.87, 2.47, 5.91, 6.46, 12.12),
(203, 2, 3, 12, 0, 1.53, 2.85, 4.97, 5.19, 10.37),
(204, 2, 4, 12, 0, 1.02, 1.57, 5.02, 5.61, 9.1),
(205, 2, 5, 12, 0, 2.13, 2.42, 4.29, 4.63, 7.69),
(206, 2, 6, 12, 0, 1.87, 2.21, 4.21, 4.55, 7.18),
(207, 2, 7, 12, 0, 1.83, 2.08, 3.49, 3.74, 5.7),
(208, 2, 8, 12, 0, 1.91, 2.08, 2.98, 3.1, 5.02),
(209, 2, 1, 13, 0, 2.42, 2.93, 6.63, 7.91, 13.22),
(210, 2, 2, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(211, 2, 3, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(212, 2, 4, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(213, 2, 5, 13, 0, 1.28, 2.3, 4.17, 4.51, 7.27),
(214, 2, 6, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(215, 2, 7, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(216, 2, 8, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(217, 2, 1, 14, 0, 4.34, 4.72, 7.61, 9.73, 15.94),
(218, 2, 2, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(219, 2, 3, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(220, 2, 4, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(221, 2, 5, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(222, 2, 6, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(223, 2, 7, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(224, 2, 8, 14, 0, 2.08, 2.3, 2.81, 2.81, 4.34),
(225, 3, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(226, 3, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(227, 3, 3, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(228, 3, 4, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(229, 3, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(230, 3, 6, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(231, 3, 7, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(232, 3, 8, 1, NULL, 5, 7, 40, 50, 99999),
(233, 3, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(234, 3, 2, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(235, 3, 3, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(236, 3, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(237, 3, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(238, 3, 6, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(239, 3, 7, 2, NULL, 1, 5, 35, 41, 99999),
(240, 3, 8, 2, NULL, 1, 5, 25, 29, 99999),
(241, 3, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(242, 3, 2, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(243, 3, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(244, 3, 4, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(245, 3, 5, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(246, 3, 6, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(247, 3, 7, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(248, 3, 8, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(249, 3, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(250, 3, 2, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(251, 3, 3, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(252, 3, 4, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(253, 3, 5, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(254, 3, 6, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(255, 3, 7, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(256, 3, 8, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(257, 3, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(258, 3, 2, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(259, 3, 3, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(260, 3, 4, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(261, 3, 5, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(262, 3, 6, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(263, 3, 7, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(264, 3, 8, 5, NULL, 5, 7, 27, 37, 99999),
(265, 3, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(266, 3, 2, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(267, 3, 3, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(268, 3, 4, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(269, 3, 5, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(270, 3, 6, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(271, 3, 7, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(272, 3, 8, 6, NULL, 20, 36, 50, 50, 99999),
(273, 3, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(274, 3, 2, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(275, 3, 3, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(276, 3, 4, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(277, 3, 5, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(278, 3, 6, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(279, 3, 7, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(280, 3, 8, 7, NULL, 1, 5, 56, 64, 99999),
(281, 3, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(282, 3, 2, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(283, 3, 3, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(284, 3, 4, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(285, 3, 5, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(286, 3, 6, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(287, 3, 7, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(288, 3, 8, 8, NULL, 5, 15, 40, 49, 99999),
(289, 3, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(290, 3, 2, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(291, 3, 3, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(292, 3, 4, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(293, 3, 5, 9, NULL, 1, 5, 40, 50, 99999),
(294, 3, 6, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(295, 3, 7, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(296, 3, 8, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(305, 3, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(306, 3, 2, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(307, 3, 3, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(308, 3, 4, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(309, 3, 5, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(310, 3, 6, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(311, 3, 7, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(312, 3, 8, 11, NULL, 1, 5, 49, 50, 99999),
(313, 3, 1, 12, NULL, 1, 5, 41, 48, 99999),
(314, 3, 2, 12, NULL, 1, 5, 28, 34, 99999),
(315, 3, 3, 12, NULL, 1, 5, 30, 35, 99999),
(316, 3, 4, 12, NULL, 1, 5, 33, 40, 99999),
(317, 3, 5, 12, NULL, 1, 5, 38, 45, 99999),
(318, 3, 6, 12, NULL, 1, 5, 33, 44, 99999),
(319, 3, 7, 12, NULL, 1, 5, 36, 47, 99999),
(320, 3, 8, 12, NULL, 1, 5, 34, 40, 99999),
(321, 3, 1, 13, NULL, 1, 5, 31, 37, 99999),
(322, 3, 2, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(323, 3, 3, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(324, 3, 4, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(325, 3, 5, 13, NULL, 1, 5, 15, 31, 99999),
(326, 3, 6, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(327, 3, 7, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(328, 3, 8, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(329, 3, 1, 14, NULL, 1, 5, 38, 44, 99999),
(330, 3, 2, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(331, 3, 3, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(332, 3, 4, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(333, 3, 5, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(334, 3, 6, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(335, 3, 7, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(336, 3, 8, 14, NULL, 5, 6, 33, 37, 99999),
(449, 5, 1, 1, 0, 150, 225, 365, 9999, 9999),
(450, 5, 2, 1, 0, 150, 225, 365, 9999, 9999),
(451, 5, 3, 1, 0, 150, 225, 365, 9999, 9999),
(452, 5, 4, 1, 0, 150, 225, 365, 9999, 9999),
(453, 5, 5, 1, 0, 150, 225, 365, 9999, 9999),
(454, 5, 6, 1, 0, 150, 225, 365, 9999, 9999),
(455, 5, 7, 1, 0, 150, 225, 365, 9999, 9999),
(456, 5, 8, 1, 0, 197, 253, 365, 9999, 9999),
(457, 5, 1, 2, 0, 150, 225, 365, 9999, 9999),
(458, 5, 2, 2, 0, 150, 225, 365, 9999, 9999),
(459, 5, 3, 2, 0, 150, 225, 365, 9999, 9999),
(460, 5, 4, 2, 0, 150, 225, 365, 9999, 9999),
(461, 5, 5, 2, 0, 150, 225, 365, 9999, 9999),
(462, 5, 6, 2, 0, 150, 225, 365, 9999, 9999),
(463, 5, 7, 2, 0, 150, 225, 365, 9999, 9999),
(464, 5, 8, 2, 0, 197, 253, 365, 9999, 9999),
(465, 5, 1, 3, 0, 150, 225, 365, 9999, 9999),
(466, 5, 2, 3, 0, 150, 225, 365, 9999, 9999),
(467, 5, 3, 3, 0, 150, 225, 365, 9999, 9999),
(468, 5, 4, 3, 0, 150, 225, 365, 9999, 9999),
(469, 5, 5, 3, 0, 150, 225, 365, 9999, 9999),
(470, 5, 6, 3, 0, 150, 225, 365, 9999, 9999),
(471, 5, 7, 3, 0, 150, 225, 365, 9999, 9999),
(472, 5, 8, 3, 0, 197, 253, 365, 9999, 9999),
(473, 5, 1, 4, 0, 150, 225, 365, 9999, 9999),
(474, 5, 2, 4, 0, 150, 225, 365, 9999, 9999),
(475, 5, 3, 4, 0, 150, 225, 365, 9999, 9999),
(476, 5, 4, 4, 0, 150, 225, 365, 9999, 9999),
(477, 5, 5, 4, 0, 150, 225, 365, 9999, 9999),
(478, 5, 6, 4, 0, 150, 225, 365, 9999, 9999),
(479, 5, 7, 4, 0, 150, 225, 365, 9999, 9999),
(480, 5, 8, 4, 0, 197, 253, 365, 9999, 9999),
(481, 5, 1, 5, 0, 150, 225, 365, 9999, 9999),
(482, 5, 2, 5, 0, 150, 225, 365, 9999, 9999),
(483, 5, 3, 5, 0, 150, 225, 365, 9999, 9999),
(484, 5, 4, 5, 0, 150, 225, 365, 9999, 9999),
(485, 5, 5, 5, 0, 150, 225, 365, 9999, 9999),
(486, 5, 6, 5, 0, 150, 225, 365, 9999, 9999),
(487, 5, 7, 5, 0, 150, 225, 365, 9999, 9999),
(488, 5, 8, 5, 0, 197, 253, 365, 9999, 9999),
(489, 5, 1, 6, 0, 150, 225, 365, 9999, 9999),
(490, 5, 2, 6, 0, 150, 225, 365, 9999, 9999),
(491, 5, 3, 6, 0, 150, 225, 365, 9999, 9999),
(492, 5, 4, 6, 0, 150, 225, 365, 9999, 9999),
(493, 5, 5, 6, 0, 150, 225, 365, 9999, 9999),
(494, 5, 6, 6, 0, 150, 225, 365, 9999, 9999),
(495, 5, 7, 6, 0, 150, 225, 365, 9999, 9999),
(496, 5, 8, 6, 0, 197, 253, 365, 9999, 9999),
(497, 5, 1, 7, 0, 150, 225, 365, 9999, 9999),
(498, 5, 2, 7, 0, 150, 225, 365, 9999, 9999),
(499, 5, 3, 7, 0, 150, 225, 365, 9999, 9999),
(500, 5, 4, 7, 0, 150, 225, 365, 9999, 9999),
(501, 5, 5, 7, 0, 150, 225, 365, 9999, 9999),
(502, 5, 6, 7, 0, 150, 225, 365, 9999, 9999),
(503, 5, 7, 7, 0, 150, 225, 365, 9999, 9999),
(504, 5, 8, 7, 0, 197, 253, 365, 9999, 9999),
(505, 5, 1, 8, 0, 150, 225, 365, 9999, 9999),
(506, 5, 2, 8, 0, 150, 225, 365, 9999, 9999),
(507, 5, 3, 8, 0, 150, 225, 365, 9999, 9999),
(508, 5, 4, 8, 0, 150, 225, 365, 9999, 9999),
(509, 5, 5, 8, 0, 150, 225, 365, 9999, 9999),
(510, 5, 6, 8, 0, 150, 225, 365, 9999, 9999),
(511, 5, 7, 8, 0, 150, 225, 365, 9999, 9999),
(512, 5, 8, 8, 0, 197, 253, 365, 9999, 9999),
(513, 5, 1, 9, 0, 150, 225, 365, 9999, 9999),
(514, 5, 2, 9, 0, 150, 225, 365, 9999, 9999),
(515, 5, 3, 9, 0, 150, 225, 365, 9999, 9999),
(516, 5, 4, 9, 0, 150, 225, 365, 9999, 9999),
(517, 5, 5, 9, 0, 150, 225, 365, 9999, 9999),
(518, 5, 6, 9, 0, 150, 225, 365, 9999, 9999),
(519, 5, 7, 9, 0, 150, 225, 365, 9999, 9999),
(520, 5, 8, 9, 0, 197, 253, 365, 9999, 9999),
(529, 5, 1, 11, 0, 142, 200, 315, 9999, 9999),
(530, 5, 2, 11, 0, 142, 200, 315, 9999, 9999),
(531, 5, 3, 11, 0, 142, 200, 315, 9999, 9999),
(532, 5, 4, 11, 0, 142, 200, 315, 9999, 9999),
(533, 5, 5, 11, 0, 142, 200, 315, 9999, 9999),
(534, 5, 6, 11, 0, 142, 200, 315, 9999, 9999),
(535, 5, 7, 11, 0, 142, 200, 315, 9999, 9999),
(536, 5, 8, 11, 0, 197, 253, 365, 9999, 9999),
(537, 5, 1, 12, 0, 150, 225, 365, 9999, 9999),
(538, 5, 2, 12, 0, 150, 225, 365, 9999, 9999),
(539, 5, 3, 12, 0, 150, 225, 365, 9999, 9999),
(540, 5, 4, 12, 0, 150, 225, 365, 9999, 9999),
(541, 5, 5, 12, 0, 150, 225, 365, 9999, 9999),
(542, 5, 6, 12, 0, 150, 225, 365, 9999, 9999),
(543, 5, 7, 12, 0, 150, 225, 365, 9999, 9999),
(544, 5, 8, 12, 0, 197, 253, 365, 9999, 9999),
(545, 5, 1, 13, 0, 142, 200, 315, 9999, 9999),
(546, 5, 2, 13, 0, 142, 200, 315, 9999, 9999),
(547, 5, 3, 13, 0, 142, 200, 315, 9999, 9999),
(548, 5, 4, 13, 0, 142, 200, 315, 9999, 9999),
(549, 5, 5, 13, 0, 142, 200, 315, 9999, 9999),
(550, 5, 6, 13, 0, 142, 200, 315, 9999, 9999),
(551, 5, 7, 13, 0, 142, 200, 315, 9999, 9999),
(552, 5, 8, 13, 0, 197, 253, 365, 9999, 9999),
(553, 5, 1, 14, 0, 150, 225, 365, 9999, 9999),
(554, 5, 2, 14, 0, 150, 225, 365, 9999, 9999),
(555, 5, 3, 14, 0, 150, 225, 365, 9999, 9999),
(556, 5, 4, 14, 0, 150, 225, 365, 9999, 9999),
(557, 5, 5, 14, 0, 150, 225, 365, 9999, 9999),
(558, 5, 6, 14, 0, 150, 225, 365, 9999, 9999),
(559, 5, 7, 14, 0, 150, 225, 365, 9999, 9999),
(560, 5, 8, 14, 0, 197, 253, 365, 9999, 9999),
(561, 6, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(562, 6, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(563, 6, 3, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(564, 6, 4, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(565, 6, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(566, 6, 6, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(567, 6, 7, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(568, 6, 8, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(569, 6, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(570, 6, 2, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(571, 6, 3, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(572, 6, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(573, 6, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(574, 6, 6, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(575, 6, 7, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(576, 6, 8, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(577, 6, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(578, 6, 2, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(579, 6, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(580, 6, 4, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(581, 6, 5, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(582, 6, 6, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(583, 6, 7, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(584, 6, 8, 3, NULL, NULL, NULL, NULL, NULL, NULL),
(585, 6, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(586, 6, 2, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(587, 6, 3, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(588, 6, 4, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(589, 6, 5, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(590, 6, 6, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(591, 6, 7, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(592, 6, 8, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(593, 6, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(594, 6, 2, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(595, 6, 3, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(596, 6, 4, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(597, 6, 5, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(598, 6, 6, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(599, 6, 7, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(600, 6, 8, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(601, 6, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(602, 6, 2, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(603, 6, 3, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(604, 6, 4, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(605, 6, 5, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(606, 6, 6, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(607, 6, 7, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(608, 6, 8, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(609, 6, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(610, 6, 2, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(611, 6, 3, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(612, 6, 4, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(613, 6, 5, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(614, 6, 6, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(615, 6, 7, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(616, 6, 8, 7, NULL, NULL, NULL, NULL, NULL, NULL),
(617, 6, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(618, 6, 2, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(619, 6, 3, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(620, 6, 4, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(621, 6, 5, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(622, 6, 6, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(623, 6, 7, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(624, 6, 8, 8, NULL, NULL, NULL, NULL, NULL, NULL),
(625, 6, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(626, 6, 2, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(627, 6, 3, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(628, 6, 4, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(629, 6, 5, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(630, 6, 6, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(631, 6, 7, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(632, 6, 8, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(641, 6, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(642, 6, 2, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(643, 6, 3, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(644, 6, 4, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(645, 6, 5, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(646, 6, 6, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(647, 6, 7, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(648, 6, 8, 11, NULL, NULL, NULL, NULL, NULL, NULL),
(649, 6, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL),
(650, 6, 2, 12, NULL, NULL, NULL, NULL, NULL, NULL),
(651, 6, 3, 12, NULL, NULL, NULL, NULL, NULL, NULL),
(652, 6, 4, 12, NULL, NULL, NULL, NULL, NULL, NULL),
(653, 6, 5, 12, NULL, NULL, NULL, NULL, NULL, NULL),
(654, 6, 6, 12, NULL, NULL, NULL, NULL, NULL, NULL),
(655, 6, 7, 12, NULL, NULL, NULL, NULL, NULL, NULL),
(656, 6, 8, 12, NULL, NULL, NULL, NULL, NULL, NULL),
(657, 6, 1, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(658, 6, 2, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(659, 6, 3, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(660, 6, 4, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(661, 6, 5, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(662, 6, 6, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(663, 6, 7, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(664, 6, 8, 13, NULL, NULL, NULL, NULL, NULL, NULL),
(665, 6, 1, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(666, 6, 2, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(667, 6, 3, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(668, 6, 4, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(669, 6, 5, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(670, 6, 6, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(671, 6, 7, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(672, 6, 8, 14, NULL, NULL, NULL, NULL, NULL, NULL),
(673, 7, 1, 1, 0, 0, 1, 1.73, 2.81, 99999),
(674, 7, 2, 1, 0, 0, 1, 1.73, 2.81, 99999),
(675, 7, 3, 1, 0, 0, 1, 1.73, 2.81, 99999),
(676, 7, 4, 1, 0, 0, 1, 1.73, 2.81, 99999),
(677, 7, 5, 1, 0, 0, 1, 1.73, 2.81, 99999),
(678, 7, 6, 1, 0, 0, 1, 1.73, 2.81, 99999),
(679, 7, 7, 1, 0, 0, 1, 1.73, 2.81, 99999),
(680, 7, 8, 1, 0, 0, 1, 4.11, 6.1, 99999),
(681, 7, 1, 2, 0, 0, 1, 1.73, 2.81, 99999),
(682, 7, 2, 2, 0, 0, 1, 1.73, 2.81, 99999),
(683, 7, 3, 2, 0, 0, 1, 1.73, 2.81, 99999),
(684, 7, 4, 2, 0, 0, 1, 1.73, 2.81, 99999),
(685, 7, 5, 2, 0, 0, 1, 1.73, 2.81, 99999),
(686, 7, 6, 2, 0, 0, 1, 1.73, 2.81, 99999),
(687, 7, 7, 2, 0, 0, 1, 1.73, 2.81, 99999),
(688, 7, 8, 2, 0, 0, 1, 4.11, 6.1, 99999),
(689, 7, 1, 3, 0, 0, 1, 1.73, 2.81, 99999),
(690, 7, 2, 3, 0, 0, 1, 1.73, 2.81, 99999),
(691, 7, 3, 3, 0, 0, 1, 1.73, 2.81, 99999),
(692, 7, 4, 3, 0, 0, 1, 1.73, 2.81, 99999),
(693, 7, 5, 3, 0, 0, 1, 1.73, 2.81, 99999),
(694, 7, 6, 3, 0, 0, 1, 1.73, 2.81, 99999),
(695, 7, 7, 3, 0, 0, 1, 1.73, 2.81, 99999),
(696, 7, 8, 3, 0, 0, 1, 4.11, 6.1, 99999),
(697, 7, 1, 4, 0, 0, 1, 1.73, 2.81, 99999),
(698, 7, 2, 4, 0, 0, 1, 1.73, 2.81, 99999),
(699, 7, 3, 4, 0, 0, 1, 1.73, 2.81, 99999),
(700, 7, 4, 4, 0, 0, 1, 1.73, 2.81, 99999),
(701, 7, 5, 4, 0, 0, 1, 1.73, 2.81, 99999),
(702, 7, 6, 4, 0, 0, 1, 1.73, 2.81, 99999),
(703, 7, 7, 4, 0, 0, 1, 1.73, 2.81, 99999),
(704, 7, 8, 4, 0, 0, 1, 2.53, 4.18, 99999),
(705, 7, 1, 5, 0, 0, 1, 1.73, 2.81, 99999),
(706, 7, 2, 5, 0, 0, 1, 1.73, 2.81, 99999),
(707, 7, 3, 5, 0, 0, 1, 1.73, 2.81, 99999),
(708, 7, 4, 5, 0, 0, 1, 1.73, 2.81, 99999),
(709, 7, 5, 5, 0, 0, 1, 1.73, 2.81, 99999),
(710, 7, 6, 5, 0, 0, 1, 1.73, 2.81, 99999),
(711, 7, 7, 5, 0, 0, 1, 1.73, 2.81, 99999),
(712, 7, 8, 5, 0, 0, 1, 4.11, 6.1, 99999),
(713, 7, 1, 6, 0, 0, 1, 1.73, 2.81, 99999),
(714, 7, 2, 6, 0, 0, 1, 1.73, 2.81, 99999),
(715, 7, 3, 6, 0, 0, 1, 1.73, 2.81, 99999),
(716, 7, 4, 6, 0, 0, 1, 1.73, 2.81, 99999),
(717, 7, 5, 6, 0, 0, 1, 1.73, 2.81, 99999),
(718, 7, 6, 6, 0, 0, 1, 1.73, 2.81, 99999),
(719, 7, 7, 6, 0, 0, 1, 1.73, 2.81, 99999),
(720, 7, 8, 6, 0, 0, 1, 4.11, 6.1, 99999),
(721, 7, 1, 7, 0, 0, 1, 1.73, 2.81, 99999),
(722, 7, 2, 7, 0, 0, 1, 1.73, 2.81, 99999),
(723, 7, 3, 7, 0, 0, 1, 1.73, 2.81, 99999),
(724, 7, 4, 7, 0, 0, 1, 1.73, 2.81, 99999),
(725, 7, 5, 7, 0, 0, 1, 1.73, 2.81, 99999),
(726, 7, 6, 7, 0, 0, 1, 1.73, 2.81, 99999),
(727, 7, 7, 7, 0, 0, 1, 1.73, 2.81, 99999),
(728, 7, 8, 7, 0, 0, 1, 4.11, 6.1, 99999),
(729, 7, 1, 8, 0, 0, 1, 1.73, 2.81, 99999),
(730, 7, 2, 8, 0, 0, 1, 1.73, 2.81, 99999),
(731, 7, 3, 8, 0, 0, 1, 1.73, 2.81, 99999),
(732, 7, 4, 8, 0, 0, 1, 1.73, 2.81, 99999),
(733, 7, 5, 8, 0, 0, 1, 1.73, 2.81, 99999),
(734, 7, 6, 8, 0, 0, 1, 1.73, 2.81, 99999),
(735, 7, 7, 8, 0, 0, 1, 1.73, 2.81, 99999),
(736, 7, 8, 8, 0, 0, 1, 4.11, 6.1, 99999),
(737, 7, 1, 9, 0, 0, 1, 1.73, 2.81, 99999),
(738, 7, 2, 9, 0, 0, 1, 1.73, 2.81, 99999),
(739, 7, 3, 9, 0, 0, 1, 1.73, 2.81, 99999),
(740, 7, 4, 9, 0, 0, 1, 1.73, 2.81, 99999),
(741, 7, 5, 9, 0, 0, 1, 1.73, 2.81, 99999),
(742, 7, 6, 9, 0, 0, 1, 1.73, 2.81, 99999),
(743, 7, 7, 9, 0, 0, 1, 1.73, 2.81, 99999),
(744, 7, 8, 9, 0, 0, 1, 4.11, 6.1, 99999),
(753, 7, 1, 11, 0, 0, 1, 24, 99999, 99999),
(754, 7, 2, 11, 0, 0, 1, 24, 99999, 99999),
(755, 7, 3, 11, 0, 0, 1, 24, 99999, 99999),
(756, 7, 4, 11, 0, 0, 1, 24, 99999, 99999),
(757, 7, 5, 11, 0, 0, 1, 24, 99999, 99999),
(758, 7, 6, 11, 0, 0, 1, 24, 99999, 99999),
(759, 7, 7, 11, 0, 0, 1, 24, 99999, 99999),
(760, 7, 8, 11, 0, 0, 1, 4.11, 6.1, 99999),
(761, 7, 1, 12, 0, 0, 1, 1.73, 2.81, 99999),
(762, 7, 2, 12, 0, 0, 1, 1.73, 2.81, 99999),
(763, 7, 3, 12, 0, 0, 1, 1.73, 2.81, 99999),
(764, 7, 4, 12, 0, 0, 1, 1.73, 2.81, 99999),
(765, 7, 5, 12, 0, 0, 1, 1.73, 2.81, 99999),
(766, 7, 6, 12, 0, 0, 1, 1.73, 2.81, 99999),
(767, 7, 7, 12, 0, 0, 1, 1.73, 2.81, 99999),
(768, 7, 8, 12, 0, 0, 1, 4.11, 6.1, 99999),
(769, 7, 1, 13, 0, 0, 1, 24, 99999, 99999),
(770, 7, 2, 13, 0, 0, 1, 24, 99999, 99999),
(771, 7, 3, 13, 0, 0, 1, 24, 99999, 99999),
(772, 7, 4, 13, 0, 0, 1, 24, 99999, 99999),
(773, 7, 5, 13, 0, 0, 1, 24, 99999, 99999),
(774, 7, 6, 13, 0, 0, 1, 24, 99999, 99999),
(775, 7, 7, 13, 0, 0, 1, 24, 99999, 99999),
(776, 7, 8, 13, 0, 0, 1, 2.53, 4.18, 99999),
(777, 7, 1, 14, 0, 0, 1, 1.73, 2.81, 99999),
(778, 7, 2, 14, 0, 0, 1, 1.73, 2.81, 99999),
(779, 7, 3, 14, 0, 0, 1, 1.73, 2.81, 99999),
(780, 7, 4, 14, 0, 0, 1, 1.73, 2.81, 99999),
(781, 7, 5, 14, 0, 0, 1, 1.73, 2.81, 99999),
(782, 7, 6, 14, 0, 0, 1, 1.73, 2.81, 99999),
(783, 7, 7, 14, 0, 0, 1, 1.73, 2.81, 99999),
(784, 7, 8, 14, 0, 0, 1, 4.11, 6.1, 99999),
(785, 8, 1, 1, 0, 0, 0, 1.87, 2.81, 99999),
(786, 8, 2, 1, 0, 0, 0, 1.87, 2.81, 99999),
(787, 8, 3, 1, 0, 0, 0, 1.87, 2.81, 99999),
(788, 8, 4, 1, 0, 0, 0, 1.87, 2.81, 99999),
(789, 8, 5, 1, 0, 0, 0, 1.87, 2.81, 99999),
(790, 8, 6, 1, 0, 0, 0, 1.87, 2.81, 99999),
(791, 8, 7, 1, 0, 0, 0, 1.87, 2.81, 99999),
(792, 8, 8, 1, 0, 0, 0, 2.36, 3.6, 99999),
(793, 8, 1, 2, 0, 0, 0, 1.87, 2.81, 99999),
(794, 8, 2, 2, 0, 0, 0, 1.87, 2.81, 99999),
(795, 8, 3, 2, 0, 0, 0, 1.87, 2.81, 99999),
(796, 8, 4, 2, 0, 0, 0, 1.87, 2.81, 99999),
(797, 8, 5, 2, 0, 0, 0, 1.87, 2.81, 99999),
(798, 8, 6, 2, 0, 0, 0, 1.87, 2.81, 99999),
(799, 8, 7, 2, 0, 0, 0, 1.87, 2.81, 99999),
(800, 8, 8, 2, 0, 0, 0, 2.36, 3.6, 99999),
(801, 8, 1, 3, 0, 0, 0, 1.87, 2.81, 99999),
(802, 8, 2, 3, 0, 0, 0, 1.87, 2.81, 99999),
(803, 8, 3, 3, 0, 0, 0, 1.87, 2.81, 99999),
(804, 8, 4, 3, 0, 0, 0, 1.87, 2.81, 99999),
(805, 8, 5, 3, 0, 0, 0, 1.87, 2.81, 99999),
(806, 8, 6, 3, 0, 0, 0, 1.87, 2.81, 99999),
(807, 8, 7, 3, 0, 0, 0, 1.87, 2.81, 99999),
(808, 8, 8, 3, 0, 0, 0, 2.36, 3.6, 99999),
(809, 8, 1, 4, 0, 0, 0, 1.87, 2.81, 99999),
(810, 8, 2, 4, 0, 0, 0, 1.87, 2.81, 99999),
(811, 8, 3, 4, 0, 0, 0, 1.87, 2.81, 99999),
(812, 8, 4, 4, 0, 0, 0, 1.87, 2.81, 99999),
(813, 8, 5, 4, 0, 0, 0, 1.87, 2.81, 99999),
(814, 8, 6, 4, 0, 0, 0, 1.87, 2.81, 99999),
(815, 8, 7, 4, 0, 0, 0, 1.87, 2.81, 99999),
(816, 8, 8, 4, 0, 0, 0, 2.63, 4.15, 99999),
(817, 8, 1, 5, 0, 0, 0, 1.87, 2.81, 99999),
(818, 8, 2, 5, 0, 0, 0, 1.87, 2.81, 99999),
(819, 8, 3, 5, 0, 0, 0, 1.87, 2.81, 99999),
(820, 8, 4, 5, 0, 0, 0, 1.87, 2.81, 99999),
(821, 8, 5, 5, 0, 0, 0, 1.87, 2.81, 99999),
(822, 8, 6, 5, 0, 0, 0, 1.87, 2.81, 99999),
(823, 8, 7, 5, 0, 0, 0, 1.87, 2.81, 99999),
(824, 8, 8, 5, 0, 0, 0, 2.36, 3.6, 99999),
(825, 8, 1, 6, 0, 0, 0, 1.87, 2.81, 99999),
(826, 8, 2, 6, 0, 0, 0, 1.87, 2.81, 99999),
(827, 8, 3, 6, 0, 0, 0, 1.87, 2.81, 99999),
(828, 8, 4, 6, 0, 0, 0, 1.87, 2.81, 99999),
(829, 8, 5, 6, 0, 0, 0, 1.87, 2.81, 99999),
(830, 8, 6, 6, 0, 0, 0, 1.87, 2.81, 99999),
(831, 8, 7, 6, 0, 0, 0, 1.87, 2.81, 99999),
(832, 8, 8, 6, 0, 0, 0, 2.36, 3.6, 99999),
(833, 8, 1, 7, 0, 0, 0, 1.87, 2.81, 99999),
(834, 8, 2, 7, 0, 0, 0, 1.87, 2.81, 99999),
(835, 8, 3, 7, 0, 0, 0, 1.87, 2.81, 99999),
(836, 8, 4, 7, 0, 0, 0, 1.87, 2.81, 99999),
(837, 8, 5, 7, 0, 0, 0, 1.87, 2.81, 99999),
(838, 8, 6, 7, 0, 0, 0, 1.87, 2.81, 99999),
(839, 8, 7, 7, 0, 0, 0, 1.87, 2.81, 99999),
(840, 8, 8, 7, 0, 0, 0, 2.36, 3.6, 99999),
(841, 8, 1, 8, 0, 0, 0, 1.87, 2.81, 99999),
(842, 8, 2, 8, 0, 0, 0, 1.87, 2.81, 99999),
(843, 8, 3, 8, 0, 0, 0, 1.87, 2.81, 99999),
(844, 8, 4, 8, 0, 0, 0, 1.87, 2.81, 99999),
(845, 8, 5, 8, 0, 0, 0, 1.87, 2.81, 99999),
(846, 8, 6, 8, 0, 0, 0, 1.87, 2.81, 99999),
(847, 8, 7, 8, 0, 0, 0, 1.87, 2.81, 99999),
(848, 8, 8, 8, 0, 0, 0, 2.36, 3.6, 99999),
(849, 8, 1, 9, 0, 0, 0, 1.87, 2.81, 99999),
(850, 8, 2, 9, 0, 0, 0, 1.87, 2.81, 99999),
(851, 8, 3, 9, 0, 0, 0, 1.87, 2.81, 99999),
(852, 8, 4, 9, 0, 0, 0, 1.87, 2.81, 99999),
(853, 8, 5, 9, 0, 0, 0, 1.87, 2.81, 99999),
(854, 8, 6, 9, 0, 0, 0, 1.87, 2.81, 99999),
(855, 8, 7, 9, 0, 0, 0, 1.87, 2.81, 99999),
(856, 8, 8, 9, 0, 0, 0, 2.36, 3.6, 99999),
(865, 8, 1, 11, 0, 0, 0, 1.42, 1.99, 99999),
(866, 8, 2, 11, 0, 0, 0, 1.42, 1.99, 99999),
(867, 8, 3, 11, 0, 0, 0, 1.42, 1.99, 99999),
(868, 8, 4, 11, 0, 0, 0, 1.42, 1.99, 99999),
(869, 8, 5, 11, 0, 0, 0, 1.42, 1.99, 99999),
(870, 8, 6, 11, 0, 0, 0, 1.42, 1.99, 99999),
(871, 8, 7, 11, 0, 0, 0, 1.42, 1.99, 99999),
(872, 8, 8, 11, 0, 0, 0, 2.36, 3.6, 99999),
(873, 8, 1, 12, 0, 0, 0, 1.87, 2.81, 99999),
(874, 8, 2, 12, 0, 0, 0, 1.87, 2.81, 99999),
(875, 8, 3, 12, 0, 0, 0, 1.87, 2.81, 99999),
(876, 8, 4, 12, 0, 0, 0, 1.87, 2.81, 99999),
(877, 8, 5, 12, 0, 0, 0, 1.87, 2.81, 99999),
(878, 8, 6, 12, 0, 0, 0, 1.87, 2.81, 99999),
(879, 8, 7, 12, 0, 0, 0, 1.87, 2.81, 99999),
(880, 8, 8, 12, 0, 0, 0, 2.36, 3.6, 99999),
(881, 8, 1, 13, 0, 0, 0, 1.42, 1.99, 99999),
(882, 8, 2, 13, 0, 0, 0, 1.42, 1.99, 99999),
(883, 8, 3, 13, 0, 0, 0, 1.42, 1.99, 99999),
(884, 8, 4, 13, 0, 0, 0, 1.42, 1.99, 99999),
(885, 8, 5, 13, 0, 0, 0, 1.42, 1.99, 99999),
(886, 8, 6, 13, 0, 0, 0, 1.42, 1.99, 99999),
(887, 8, 7, 13, 0, 0, 0, 1.42, 1.99, 99999),
(888, 8, 8, 13, 0, 0, 0, 2.63, 4.15, 99999),
(889, 8, 1, 14, 0, 0, 0, 1.87, 2.81, 99999),
(890, 8, 2, 14, 0, 0, 0, 1.87, 2.81, 99999),
(891, 8, 3, 14, 0, 0, 0, 1.87, 2.81, 99999),
(892, 8, 4, 14, 0, 0, 0, 1.87, 2.81, 99999),
(893, 8, 5, 14, 0, 0, 0, 1.87, 2.81, 99999),
(894, 8, 6, 14, 0, 0, 0, 1.87, 2.81, 99999),
(895, 8, 7, 14, 0, 0, 0, 1.87, 2.81, 99999),
(896, 8, 8, 14, 0, 0, 0, 2.36, 3.6, 99999);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Vclass`
--

CREATE TABLE `Vclass` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `icon` varchar(45) DEFAULT NULL,
  `load_type` tinyint(4) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `weight` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(8, 'Clase 8b', 'c8b', 'class8b.png', 2, NULL, '27 ton y más');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Vclass_Subclass`
--

CREATE TABLE `Vclass_Subclass` (
  `id` int(11) NOT NULL,
  `vclass_id` int(11) DEFAULT NULL,
  `subclass_id` int(11) DEFAULT NULL,
  `family` varchar(45) DEFAULT NULL,
  `boxtype` tinyint(4) DEFAULT NULL,
  `open` tinyint(4) DEFAULT NULL,
  `type` varchar(5) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Brands`
--
ALTER TABLE `Brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_brands_Companies1_idx` (`companies_id`);

--
-- Indices de la tabla `Brands_Fleets`
--
ALTER TABLE `Brands_Fleets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Brands_Fleets_Brands1_idx` (`brands_id`),
  ADD KEY `fk_Brands_Fleets_Fleets1_idx` (`fleets_id`);

--
-- Indices de la tabla `Cache`
--
ALTER TABLE `Cache`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Cache_Fleets1_idx` (`fleets_id`);

--
-- Indices de la tabla `Cache_Users`
--
ALTER TABLE `Cache_Users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Cache_Vclass`
--
ALTER TABLE `Cache_Vclass`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Cache_Fleets1_idx` (`fleets_id`);

--
-- Indices de la tabla `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Companies`
--
ALTER TABLE `Companies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Companies_Emissions`
--
ALTER TABLE `Companies_Emissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Users_Emissions_Companies1_idx` (`companies_id`);

--
-- Indices de la tabla `Contacts`
--
ALTER TABLE `Contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Contacts_Companies_idx` (`companies_id`);

--
-- Indices de la tabla `Drive_Velocities`
--
ALTER TABLE `Drive_Velocities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Drive_Velocities_Vclass1_idx` (`vclass_id`),
  ADD KEY `fk_Drive_Velocities_Fuels1_idx` (`fuels_id`);

--
-- Indices de la tabla `Emissions`
--
ALTER TABLE `Emissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Emissions_Fleets_Fuels1_idx` (`fleets_fuels_id`);

--
-- Indices de la tabla `Emissions_Factors`
--
ALTER TABLE `Emissions_Factors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Emissions_Factors_Pollutants1_idx` (`pollutants_id`),
  ADD KEY `fk_Emissions_Factors_Fuels1_idx` (`fuels_id`),
  ADD KEY `fk_Emissions_Factors_Vclass1_idx` (`vclass_id`);

--
-- Indices de la tabla `Estados`
--
ALTER TABLE `Estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Fleets`
--
ALTER TABLE `Fleets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Fleets_Companies1_idx` (`companies_id`),
  ADD KEY `fk_Fleets_Categories1_idx` (`categories_id`);

--
-- Indices de la tabla `Fleets_Fuels`
--
ALTER TABLE `Fleets_Fuels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniqueFF` (`fuels_id`,`fleets_id`),
  ADD KEY `fk_Fleets_Fuels_Fleets1_idx` (`fleets_id`),
  ADD KEY `fk_Fleets_Fuels_Fuels1_idx` (`fuels_id`);

--
-- Indices de la tabla `Fleets_Fuels_Vclass`
--
ALTER TABLE `Fleets_Fuels_Vclass`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Fleets_Fuels_Vclass_Vclass1_idx` (`vclass_id`),
  ADD KEY `fk_Fleets_Fuels_Vclass_Fleets_Fuels1_idx` (`Fleets_Fuels_id`);

--
-- Indices de la tabla `Fleets_Fuels_Vclass_Travels`
--
ALTER TABLE `Fleets_Fuels_Vclass_Travels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Fleets_Fuels_Vclass_travels_Fleets_Fuels1_idx` (`fleets_fuels_id`),
  ADD KEY `fk_Fleets_Fuels_Vclass_Travels_Fuels1_idx` (`hybrid_type`),
  ADD KEY `fk_Fleets_Fuels_Vclass_Travels_Vclass1_idx` (`vclass_id`);

--
-- Indices de la tabla `Fleet_Fuels_Vclass_Quantity`
--
ALTER TABLE `Fleet_Fuels_Vclass_Quantity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Fleet_Fuels_Vclass_Fleets_Fuels1_idx` (`fleets_fuels_id`),
  ADD KEY `fk_Fleet_Fuels_Vclass_Vclass1_idx` (`vclass_id`);

--
-- Indices de la tabla `Fleet_Fuels_Vclass_Reduction`
--
ALTER TABLE `Fleet_Fuels_Vclass_Reduction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Fleet_Fuels_Vclass_Fleets_Fuels1_idx` (`fleets_fuels_id`),
  ADD KEY `fk_Fleet_Fuels_Vclass_Vclass1_idx` (`vclass_id`);

--
-- Indices de la tabla `Fuels`
--
ALTER TABLE `Fuels`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Municipios`
--
ALTER TABLE `Municipios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_table1_Estados1_idx` (`estados_id`);

--
-- Indices de la tabla `Pollutants`
--
ALTER TABLE `Pollutants`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `PwdRecovery`
--
ALTER TABLE `PwdRecovery`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Ranges`
--
ALTER TABLE `Ranges`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Sources`
--
ALTER TABLE `Sources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Sources_Fleets1_idx` (`fleet_id`);

--
-- Indices de la tabla `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Validations`
--
ALTER TABLE `Validations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `Validations_Values`
--
ALTER TABLE `Validations_Values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Validations_Values_Validations1_idx` (`validations_id`),
  ADD KEY `fk_Validations_Values_Vclass1_idx` (`vclass_id`),
  ADD KEY `fk_Validations_Values_Categories1_idx` (`categories_id`);

--
-- Indices de la tabla `Vclass`
--
ALTER TABLE `Vclass`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de la tabla `Brands`
--
ALTER TABLE `Brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Brands_Fleets`
--
ALTER TABLE `Brands_Fleets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Cache`
--
ALTER TABLE `Cache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Cache_Users`
--
ALTER TABLE `Cache_Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Cache_Vclass`
--
ALTER TABLE `Cache_Vclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Categories`
--
ALTER TABLE `Categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `Comments`
--
ALTER TABLE `Comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Companies`
--
ALTER TABLE `Companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Companies_Emissions`
--
ALTER TABLE `Companies_Emissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Contacts`
--
ALTER TABLE `Contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Drive_Velocities`
--
ALTER TABLE `Drive_Velocities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `Emissions_Factors`
--
ALTER TABLE `Emissions_Factors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Estados`
--
ALTER TABLE `Estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `Fleets`
--
ALTER TABLE `Fleets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Fleets_Fuels`
--
ALTER TABLE `Fleets_Fuels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Fleets_Fuels_Vclass`
--
ALTER TABLE `Fleets_Fuels_Vclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Fleets_Fuels_Vclass_Travels`
--
ALTER TABLE `Fleets_Fuels_Vclass_Travels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Fleet_Fuels_Vclass_Quantity`
--
ALTER TABLE `Fleet_Fuels_Vclass_Quantity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Fleet_Fuels_Vclass_Reduction`
--
ALTER TABLE `Fleet_Fuels_Vclass_Reduction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Fuels`
--
ALTER TABLE `Fuels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `Municipios`
--
ALTER TABLE `Municipios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2458;

--
-- AUTO_INCREMENT de la tabla `Pollutants`
--
ALTER TABLE `Pollutants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `PwdRecovery`
--
ALTER TABLE `PwdRecovery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Ranges`
--
ALTER TABLE `Ranges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Sources`
--
ALTER TABLE `Sources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `Validations`
--
ALTER TABLE `Validations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `Validations_Values`
--
ALTER TABLE `Validations_Values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=897;

--
-- AUTO_INCREMENT de la tabla `Vclass`
--
ALTER TABLE `Vclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `Vclass_Subclass`
--
ALTER TABLE `Vclass_Subclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Brands`
--
ALTER TABLE `Brands`
  ADD CONSTRAINT `fk_brands_Companies1` FOREIGN KEY (`companies_id`) REFERENCES `Companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Brands_Fleets`
--
ALTER TABLE `Brands_Fleets`
  ADD CONSTRAINT `fk_Brands_Fleets_Brands1` FOREIGN KEY (`brands_id`) REFERENCES `Brands` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Brands_Fleets_Fleets1` FOREIGN KEY (`fleets_id`) REFERENCES `Fleets` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Cache`
--
ALTER TABLE `Cache`
  ADD CONSTRAINT `fk_Cache_Fleets1` FOREIGN KEY (`fleets_id`) REFERENCES `Fleets` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Cache_Vclass`
--
ALTER TABLE `Cache_Vclass`
  ADD CONSTRAINT `fk_Cache_Fleets10` FOREIGN KEY (`fleets_id`) REFERENCES `Fleets` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Companies_Emissions`
--
ALTER TABLE `Companies_Emissions`
  ADD CONSTRAINT `fk_Users_Emissions_Companies1` FOREIGN KEY (`companies_id`) REFERENCES `Companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Contacts`
--
ALTER TABLE `Contacts`
  ADD CONSTRAINT `fk_Contacts_Companies` FOREIGN KEY (`companies_id`) REFERENCES `Companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Drive_Velocities`
--
ALTER TABLE `Drive_Velocities`
  ADD CONSTRAINT `fk_Drive_Velocities_Fuels1` FOREIGN KEY (`fuels_id`) REFERENCES `Fuels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Drive_Velocities_Vclass1` FOREIGN KEY (`vclass_id`) REFERENCES `Vclass` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Emissions`
--
ALTER TABLE `Emissions`
  ADD CONSTRAINT `fk_Emissions_Fleets_Fuels1` FOREIGN KEY (`fleets_fuels_id`) REFERENCES `Fleets_Fuels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Emissions_Factors`
--
ALTER TABLE `Emissions_Factors`
  ADD CONSTRAINT `fk_Emissions_Factors_Fuels1` FOREIGN KEY (`fuels_id`) REFERENCES `Fuels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Emissions_Factors_Pollutants1` FOREIGN KEY (`pollutants_id`) REFERENCES `Pollutants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Emissions_Factors_Vclass1` FOREIGN KEY (`vclass_id`) REFERENCES `Vclass` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Fleets`
--
ALTER TABLE `Fleets`
  ADD CONSTRAINT `fk_Fleets_Categories1` FOREIGN KEY (`categories_id`) REFERENCES `Categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Fleets_Companies1` FOREIGN KEY (`companies_id`) REFERENCES `Companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Fleets_Fuels`
--
ALTER TABLE `Fleets_Fuels`
  ADD CONSTRAINT `fk_Fleets_Fuels_Fleets1` FOREIGN KEY (`fleets_id`) REFERENCES `Fleets` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Fleets_Fuels_Fuels1` FOREIGN KEY (`fuels_id`) REFERENCES `Fuels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Fleets_Fuels_Vclass`
--
ALTER TABLE `Fleets_Fuels_Vclass`
  ADD CONSTRAINT `fk_Fleets_Fuels_Vclass_Fleets_Fuels1` FOREIGN KEY (`Fleets_Fuels_id`) REFERENCES `Fleets_Fuels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Fleets_Fuels_Vclass_Vclass1` FOREIGN KEY (`vclass_id`) REFERENCES `Vclass` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Fleets_Fuels_Vclass_Travels`
--
ALTER TABLE `Fleets_Fuels_Vclass_Travels`
  ADD CONSTRAINT `fk_Fleets_Fuels_Vclass_Travels_Fuels1` FOREIGN KEY (`hybrid_type`) REFERENCES `Fuels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Fleets_Fuels_Vclass_Travels_Vclass1` FOREIGN KEY (`vclass_id`) REFERENCES `Vclass` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Fleets_Fuels_Vclass_travels_Fleets_Fuels1` FOREIGN KEY (`fleets_fuels_id`) REFERENCES `Fleets_Fuels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Fleet_Fuels_Vclass_Quantity`
--
ALTER TABLE `Fleet_Fuels_Vclass_Quantity`
  ADD CONSTRAINT `fk_Fleet_Fuels_Vclass_Fleets_Fuels1` FOREIGN KEY (`fleets_fuels_id`) REFERENCES `Fleets_Fuels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Fleet_Fuels_Vclass_Vclass1` FOREIGN KEY (`vclass_id`) REFERENCES `Vclass` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Fleet_Fuels_Vclass_Reduction`
--
ALTER TABLE `Fleet_Fuels_Vclass_Reduction`
  ADD CONSTRAINT `fk_Fleet_Fuels_Vclass_Fleets_Fuels10` FOREIGN KEY (`fleets_fuels_id`) REFERENCES `Fleets_Fuels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Fleet_Fuels_Vclass_Vclass10` FOREIGN KEY (`vclass_id`) REFERENCES `Vclass` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Municipios`
--
ALTER TABLE `Municipios`
  ADD CONSTRAINT `fk_table1_Estados1` FOREIGN KEY (`estados_id`) REFERENCES `Estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Sources`
--
ALTER TABLE `Sources`
  ADD CONSTRAINT `fk_Sources_Fleets1` FOREIGN KEY (`fleet_id`) REFERENCES `Fleets` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Validations_Values`
--
ALTER TABLE `Validations_Values`
  ADD CONSTRAINT `fk_Validations_Values_Categories1` FOREIGN KEY (`categories_id`) REFERENCES `Categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Validations_Values_Validations1` FOREIGN KEY (`validations_id`) REFERENCES `Validations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Validations_Values_Vclass1` FOREIGN KEY (`vclass_id`) REFERENCES `Vclass` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Vclass_Subclass`
--
ALTER TABLE `Vclass_Subclass`
  ADD CONSTRAINT `fk_Vclass_Subclass_Vclass1` FOREIGN KEY (`vclass_id`) REFERENCES `Vclass` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
