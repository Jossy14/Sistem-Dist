-- Active: 1726805863124@@127.0.0.1@3306@bd_crud

CREATE DATABASE bd_crud;

use bd_crud;

CREATE TABLE Categorias (
    codigo INT PRIMARY KEY NOT NULL,
    nombreCategoria VARCHAR(100) NOT NULL,
    descripcion TEXT,
    fechaCreacion DATE NOT NULL,
    estado BOOLEAN DEFAULT TRUE,
    id_padre INT,
    imagen VARCHAR(255),
    orden INT
)ENGINE = INNODB;

CREATE TABLE Usuarios (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
)ENGINE = INNODB;

ALTER TABLE Categorias
ADD CONSTRAINT fk_id_padre FOREIGN KEY (id_padre) REFERENCES Usuarios(id);

