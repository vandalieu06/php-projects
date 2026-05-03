-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: database:3306
-- Tiempo de generación: 17-03-2026 a las 12:02:17
-- Versión del servidor: 8.4.8
-- Versión de PHP: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vehicles2026`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehicles`
--

CREATE TABLE `vehicles` (
  `id_vehicle` int NOT NULL,
  `tipus` varchar(100) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `potencia` int NOT NULL,
  `cilindrada` int NOT NULL,
  `consum` int NOT NULL,
  `numPortes` int DEFAULT NULL,
  `numPlaces` int DEFAULT NULL,
  `tipusCarborant` varchar(50) DEFAULT NULL,
  `pesTara` int DEFAULT NULL,
  `pesCarrega` int DEFAULT NULL,
  `tipusMoto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `vehicles`
--

INSERT INTO `vehicles` (`id_vehicle`, `tipus`, `marca`, `model`, `potencia`, `cilindrada`, `consum`, `numPortes`, `numPlaces`, `tipusCarborant`, `pesTara`, `pesCarrega`, `tipusMoto`) VALUES
(4, 'cotxe', 'dsaoduoidjio', 'idoaisudioaoiu', 19, 129, 93, 3, 3, 'gasolina', NULL, NULL, NULL),
(5, 'cotxe', 'dsaoduoidjio', 'idoaisudioaoiu', 19, 129, 93, 3, 3, 'gasolina', NULL, NULL, NULL),
(6, 'moto', 'jdñasjdñlkjñl', 'ñldjsañljdñlasñld', 112, 12, 13, NULL, 2, NULL, NULL, NULL, 'sadma');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id_vehicle`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id_vehicle` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
