CREATE TABLE IF NOT EXISTS persona (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  cognoms TEXT,
  email TEXT UNIQUE NOT NULL,
  telefon TEXT
);

-- Inserción de 5 usuarios de prueba
INSERT INTO persona (name, cognoms, email, telefon) VALUES
('Ana', 'García López', 'ana.garcia@example.com', '600111222'),
('Pedro', 'Martínez Ruiz', 'pedro.martinez@example.com', '600333444'),
('María', 'Sánchez Pérez', 'maria.sanchez@example.com', '600555666'),
('Javier', 'Fernández Gil', 'javier.fernandez@example.com', '600777888'),
('Laura', 'Díaz Moreno', 'laura.diaz@example.com', '600999000');
