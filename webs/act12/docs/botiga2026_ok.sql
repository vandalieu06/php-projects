-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Temps de generació: 05-02-2025 a les 11:02:58
-- Versió del servidor: 8.0.26-0ubuntu0.20.04.2
-- Versió de PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `botiga2026`
--
CREATE database botiga2026;
use botiga2026;
-- --------------------------------------------------------

--
-- Estructura de la taula `comanda`
--

CREATE TABLE `comanda` (
  `codiComanda` int NOT NULL,
  `codiCompra` int NOT NULL,
  `codiProducte` int NOT NULL,
  `quantitat` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de la taula `compra`
--

CREATE TABLE `compra` (
  `codiCompra` int NOT NULL,
  `data` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `codiUsuari` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de la taula `producte`
--

CREATE TABLE `producte` (
  `codiProducte` int NOT NULL,
  `nom` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `descripcio` text CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `preu` int NOT NULL,
  `stock` int DEFAULT NULL,
  `tipusImatge` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `dadesImatge` longblob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de la taula `usuari`
--

CREATE TABLE `usuari` (
  `codiUsuari` int NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `nom` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `cognoms` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `comanda`
--
ALTER TABLE `comanda`
  ADD PRIMARY KEY (`codiComanda`),
  ADD KEY `fk_compra` (`codiCompra`),
  ADD KEY `fk_producte` (`codiProducte`);

--
-- Índexs per a la taula `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`codiCompra`),
  ADD KEY `fk_usuari` (`codiUsuari`);

--
-- Índexs per a la taula `producte`
--
ALTER TABLE `producte`
  ADD PRIMARY KEY (`codiProducte`);

--
-- Índexs per a la taula `usuari`
--
ALTER TABLE `usuari`
  ADD PRIMARY KEY (`codiUsuari`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `comanda`
--
ALTER TABLE `comanda`
  MODIFY `codiComanda` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `compra`
--
ALTER TABLE `compra`
  MODIFY `codiCompra` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la taula `producte`
--
ALTER TABLE `producte`
  MODIFY `codiProducte` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la taula `usuari`
--
ALTER TABLE `usuari`
  MODIFY `codiUsuari` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restriccions per a les taules bolcades
--

--
-- Restriccions per a la taula `comanda`
--
ALTER TABLE `comanda`
  ADD CONSTRAINT `fk_compra` FOREIGN KEY (`codiCompra`) REFERENCES `compra` (`codiCompra`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_producte` FOREIGN KEY (`codiProducte`) REFERENCES `producte` (`codiProducte`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restriccions per a la taula `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_usuari` FOREIGN KEY (`codiUsuari`) REFERENCES `usuari` (`codiUsuari`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
