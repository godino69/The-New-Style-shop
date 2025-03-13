# The-New-Style-shop
## Crear tabla de productos
CREATE TABLE productos (
    id INT(11) NOT NULL AUTO_INCREMENT,
    imagen VARCHAR(255),
    nombre_producto VARCHAR(255),
    descripcion_producto VARCHAR(255),
    descripcion_completa TEXT,
    precio DECIMAL(10,2),
    cantidad INT(11),
    PRIMARY KEY (id)
);
## Crear tabla de usuarios
CREATE TABLE usuario (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(20) DEFAULT 'usuario',
    PRIMARY KEY (id)
);
## Insertar usuarios
INSERT INTO usuario (id, username, password, rol) VALUES
(1, 'godino', '1234', 'usuario'),
(3, 'admin', 'admin', 'admin')
ON DUPLICATE KEY UPDATE
username = VALUES(username),
password = VALUES(password),
rol = VALUES(rol);
