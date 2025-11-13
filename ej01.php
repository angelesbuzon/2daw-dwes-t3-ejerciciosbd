<?php

/**
 * Ejercicio 1: Crear la BD de Tienda de Frutas
 * Crea una base de datos llamada "tienda_frutas" con las siguientes tablas:
 * • categorias (id, nombre, descripción)
 * • productos (id, nombre, categoria_id, precio, stock)
 * • usuarios (id, nombre, email, contraseña)
 * • pedidos (id, usuario_id, fecha, total)
 * Usa PRIMARY KEY, FOREIGN KEY y NOT NULL donde sea necesario
 */

// Conexión a la base de datos
$host = 'db';  // Nombre del servicio en docker-compose
$dbname = 'testdb';
$username = 'alumno';
$password = 'alumno';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conexión correcta a la base de datos";
} catch(PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
}

/* CREATE TABLE categoria (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(30) UNIQUE NOT NULL,
    descripcion VARCHAR(100)
);

CREATE TABLE producto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    categoria_id,
    precio NUMBER(2) NOT NULL,
    stock INTEGER(4),

    FOREIGN KEY (fk_categoria_id) REFERENCES categoria(id)
);

CREATE TABLE usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(100) NOT NULL
);

CREATE TABLE pedido (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    total NOT NULL

    CREATE CON
); */

?>