
-- BASE DE DADES

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de dades: `esportDaw`
--
CREATE DATABASE IF NOT EXISTS `esportDaw` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
USE `esportDaw`;

-- --------------------------------------------------------

--
-- Estructura de la taula `Equip`
--

DROP TABLE IF EXISTS `Equip`;
CREATE TABLE `Equip` (
  `codiE` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `poblacio` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `numSocis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `Jugador`
--

DROP TABLE IF EXISTS `Jugador`;
CREATE TABLE `Jugador` (
  `codiJ` int(11) NOT NULL,
  `nom` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `cognoms` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `demarcacio` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `codiE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `Equip`
--
ALTER TABLE `Equip`
  ADD PRIMARY KEY (`codiE`);

--
-- Índexs per a la taula `Jugador`
--
ALTER TABLE `Jugador`
  ADD PRIMARY KEY (`codiJ`),
  ADD KEY `equip` (`codiE`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `Equip`
--
ALTER TABLE `Equip`
  MODIFY `codiE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `Jugador`
--
ALTER TABLE `Jugador`
  MODIFY `codiJ` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restriccions per a les taules bolcades
--

--
-- Restriccions per a la taula `Jugador`
--
ALTER TABLE `Jugador`
  ADD CONSTRAINT `equip` FOREIGN KEY (`codiE`) REFERENCES `Equip` (`codiE`) ON DELETE CASCADE ON UPDATE CASCADE;
