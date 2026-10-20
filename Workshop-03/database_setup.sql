CREATE TABLE IF NOT EXISTS carreras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    codigo_curso VARCHAR(20) NOT NULL UNIQUE,
    carrera_id INT NOT NULL,
    creditos TINYINT UNSIGNED NOT NULL,
    descripcion TEXT NOT NULL,
    CONSTRAINT fk_cursos_carreras
        FOREIGN KEY (carrera_id)
        REFERENCES carreras(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

INSERT IGNORE INTO carreras (nombre) VALUES
('Ingeniería en Sistemas'),
('Administración de Empresas'),
('Contabilidad'),
('Gestión Empresarial');
