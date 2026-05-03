CREATE DATABASE DAW;
USE DAW;

CREATE TABLE Persona (
    id INT PRIMARY KEY,
    nom VARCHAR(50),
    cognoms VARCHAR(50),
    email VARCHAR(50),
    telefon VARCHAR(20)
);

INSERT INTO Persona VALUES (1, 'Joan', 'Garcia', 'joan@email.com', '600111222');