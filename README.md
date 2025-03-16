# The-New-Style-Shop

## Índice
1. [Objetivos a conseguir](#objetivos-a-conseguir)
2. [Enlace a nuestra página web](#enlace-a-nuestra-página-web)
3. [Usuarios y contraseñas de nuestra web](#usuarios-y-contraseñas-de-nuestra-web)
4. [Ejecución automática de Docker Compose](#ejecución-automática-de-docker-compose)
5. [Crear tabla de productos](#crear-tabla-de-productos)
6. [Crear tabla de usuarios](#crear-tabla-de-usuarios)
7. [Insertar usuarios](#insertar-usuarios)

## Objetivos a conseguir
Con este proyecto, lo que queremos es aprender a desarrollar una página web en PHP. Sobre todo, aprenderemos a comprender cómo funciona el desarrollo de páginas web y el trabajo que hay detrás de cada una de ellas.

## Enlace a nuestra página web
Este sería el enlace desde un nombre de dominio:

[http://thenewstyle.zapto.org/](http://thenewstyle.zapto.org/)

Aquí está la dirección IP de la página web, ya que hemos probado desde diferentes sitios acceder desde el nombre de dominio y ha dado fallo:

[http://44.217.124.83/](http://44.217.124.83/)

## Usuarios y contraseñas de nuestra web
- **Usuario administrador:** `admin`
  - **Contraseña:** `admin`
- **Usuario común:** `godino`
  - **Contraseña:** `1234`

## Ejecución automática de Docker Compose
Para ello, he usado el comando `crontab -e` en el terminal.
Una vez dentro del fichero, he añadido la siguiente línea para que, cada vez que encendamos la máquina, se arranquen los contenedores Docker de forma automática:

```sh
@reboot sleep 10 && cd /home/ubuntu/entornophp && sudo docker-compose up -d
```

## Crear tabla de productos
```sql
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
```

## Crear tabla de usuarios
```sql
CREATE TABLE usuario (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(20) DEFAULT 'usuario',
    PRIMARY KEY (id)
);
```

## Insertar usuarios
```sql
INSERT INTO usuario (id, username, password, rol) VALUES
(1, 'godino', '1234', 'usuario'),
(3, 'admin', 'admin', 'admin')
ON DUPLICATE KEY UPDATE
username = VALUES(username),
password = VALUES(password),
rol = VALUES(rol);
