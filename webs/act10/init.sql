CREATE DATABASE IF NOT EXISTS gndaw2026 DEFAULT CHARACTER SET latin1 COLLATE latin1_spanish_ci;
USE gndaw2026;

DROP TABLE IF EXISTS noticia;
CREATE TABLE IF NOT EXISTS noticia (
  codiNoticia int(11) NOT NULL AUTO_INCREMENT,
  titol varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  cos varchar(250) COLLATE latin1_spanish_ci NOT NULL,
  autor varchar(25) COLLATE latin1_spanish_ci NOT NULL,
  codiSeccio int(11) NOT NULL,
  data date DEFAULT NULL,
  imatge longblob,
  tipus varchar(20) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (codiNoticia),
  KEY codiSeccio (codiSeccio)
)

ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

DROP TABLE IF EXISTS seccio;
CREATE TABLE IF NOT EXISTS seccio (
  codiSeccio int(11) NOT NULL AUTO_INCREMENT,
  seccio varchar(25) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (codiSeccio)
)

ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
INSERT INTO seccio VALUES
  (1, 'Nacional'),
  (2, 'Internacional'),
  (3, 'Politica'),
  (4, 'Esports'),
  (5, 'Opinio');

ALTER TABLE noticia ADD CONSTRAINT codiseccio_fk FOREIGN KEY (codiSeccio) REFERENCES seccio (codiSeccio) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;
