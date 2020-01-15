create database blog
DEFAULT CHARACTER SET utf8;

use blog;

CREATE TABLE usuarios (
	id INT NOT NULL UNIQUE AUTO_INCREMENT,
	nombre VARCHAR(150) NOT NULL,
	email VARCHAR(255) NOT NULL,
	password VARCHAR(255) not null,
	fecha_registro DATETIME NOT NULL,
	activo TINYINT NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE entradas(
        id INT NOT NULL UNIQUE AUTO_INCREMENT,
        autor_id INT NOT NULL,
        url VARCHAR(255) NOT NULL UNIQUE,
        titulo VARCHAR(255) NOT NULL UNIQUE,
        texto TEXT CHARACTER SET utf8 NOT NULL,
        fecha DATETIME NOT NULL,
        activa TINYINT NOT NULL,
        PRIMARY KEY(id),
        FOREIGN KEY(autor_id)
            REFERENCES usuarios(id)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
);

CREATE TABLE comentarios(
        id INT NOT NULL UNIQUE AUTO_INCREMENT,
        autor_id INT NOT NULL,
        entrada_id INT NOT NULL,
        titulo VARCHAR(255) NOT NULL,
        texto TEXT CHARACTER SET utf8 NOT NULL,
        fecha DATETIME NOT NULL,
        PRIMARY KEY(id),
        FOREIGN KEY(autor_id)
            REFERENCES usuarios(id)
            ON UPDATE CASCADE
            ON DELETE RESTRICT,
        FOREIGN KEY(entrada_id)
            REFERENCES entradas(id)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
);

CREATE TABLE recuperacion_clave(
        id INT NOT NULL UNIQUE AUTO_INCREMENT,
        usuario_id INT NOT NULL,
        url_secreta VARCHAR(255) NOT NULL,
        fecha DATETIME NOT NULL,
        PRIMARY KEY(id),
        FOREIGN KEY(usuario_id)
        REFERENCES usuarios(id)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
);
