-- Temps de generació: 09-02-2026 a les 10:32:11
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
-- Base de dades: `gndaw2026`
--
CREATE DATABASE IF NOT EXISTS `gn2daw2026` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `gn2daw2026`;

-- --------------------------------------------------------

--
-- Estructura de la taula `noticia`
--

DROP TABLE IF EXISTS `noticia`;
CREATE TABLE `noticia` (
  `codiNoticia` int NOT NULL,
  `titol` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `cos` varchar(250) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `autor` varchar(25) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `codiSeccio` int NOT NULL,
  `data` date DEFAULT NULL,
  `imatge` longblob,
  `tipus` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


--
-- Estructura de la taula `seccio`
--

DROP TABLE IF EXISTS `seccio`;
CREATE TABLE `seccio` (
  `codiSeccio` int NOT NULL,
  `seccio` varchar(25) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Bolcament de dades per a la taula `seccio`
--

INSERT INTO `seccio` (`codiSeccio`, `seccio`) VALUES
(1, 'Nacional'),
(2, 'Internacional'),
(3, 'Politica'),
(4, 'Esports'),
(5, 'Opinio');

-- --------------------------------------------------------

--
-- Estructura de la taula `usuari`
--

DROP TABLE IF EXISTS `usuari`;
CREATE TABLE `usuari` (
  `codiUsuari` int NOT NULL,
  `nom` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `hash` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `tipus` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`codiNoticia`),
  ADD KEY `codiSeccio` (`codiSeccio`);

--
-- Índexs per a la taula `seccio`
--
ALTER TABLE `seccio`
  ADD PRIMARY KEY (`codiSeccio`);

--
-- Índexs per a la taula `usuari`
--
ALTER TABLE `usuari`
  ADD PRIMARY KEY (`codiUsuari`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `noticia`
--
ALTER TABLE `noticia`
  MODIFY `codiNoticia` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT per la taula `seccio`
--
ALTER TABLE `seccio`
  MODIFY `codiSeccio` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restriccions per a les taules bolcades
--

--
-- Restriccions per a la taula `noticia`
--
ALTER TABLE `noticia`
  ADD CONSTRAINT `codiseccio_fk` FOREIGN KEY (`codiSeccio`) REFERENCES `seccio` (`codiSeccio`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
