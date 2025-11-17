<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo PHP + MariaDB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        h1 {
            color: #333;
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
        .error {
            color: #dc3545;
            font-weight: bold;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
        .info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>🚀 Entorno PHP + MariaDB</h1>
        
        <?php
        // Información de PHP
        echo "<h2>📦 Versión de PHP</h2>";
        echo "<p class='info'>PHP " . phpversion() . "</p>";
        
        // Conexión a la base de datos
        echo "<h2>🔌 Conexión a MariaDB</h2>";
        
        $host = 'db';  // Nombre del servicio en docker-compose
        $dbname = 'testdb';
        $username = 'alumno';
        $password = 'alumno';
        
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            echo "<p class='success'>✅ Conexión exitosa a la base de datos</p>";
            
            /*
            // Obtener versión de MariaDB
            $version = $pdo->query('SELECT VERSION()')->fetchColumn();
            echo "<p class='info'>MariaDB versión: $version</p>";
            
            // Crear tabla de ejemplo si no existe
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS usuarios (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(100) NOT NULL,
                    email VARCHAR(100) NOT NULL,
                    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
            ");
            
            // Insertar datos de ejemplo si la tabla está vacía
            $count = $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
            if ($count == 0) {
                $pdo->exec("
                    INSERT INTO usuarios (nombre, email) VALUES 
                    ('Juan Pérez', 'juan@ejemplo.com'),
                    ('María García', 'maria@ejemplo.com'),
                    ('Carlos López', 'carlos@ejemplo.com')
                ");
                echo "<p class='success'>✅ Datos de ejemplo insertados</p>";
            }
            
            // Mostrar usuarios
            echo "<h2>👥 Usuarios en la base de datos</h2>";
            $stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id");
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($usuarios) > 0) {
                echo "<table style='width: 100%; border-collapse: collapse;'>";
                echo "<tr style='background: #f4f4f4;'>";
                echo "<th style='padding: 10px; border: 1px solid #ddd;'>ID</th>";
                echo "<th style='padding: 10px; border: 1px solid #ddd;'>Nombre</th>";
                echo "<th style='padding: 10px; border: 1px solid #ddd;'>Email</th>";
                echo "<th style='padding: 10px; border: 1px solid #ddd;'>Fecha Registro</th>";
                echo "</tr>";
                
                foreach ($usuarios as $usuario) {
                    echo "<tr>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$usuario['id']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$usuario['nombre']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$usuario['email']}</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ddd;'>{$usuario['fecha_registro']}</td>";
                    echo "</tr>";
                }
                
                echo "</table>";
            }

            */
            
        } catch(PDOException $e) {
            echo "<p class='error'>❌ Error de conexión: " . $e->getMessage() . "</p>";
            echo "<div class='info'>";
            echo "<strong>Verifica que:</strong><br>";
            echo "- Los contenedores estén corriendo: <code>docker compose -f docker-compose-alumnos.yml ps</code><br>";
            echo "- El servicio de base de datos esté disponible<br>";
            echo "- Las credenciales sean correctas";
            echo "</div>";
        }
        ?>

        <!-- INICIO DE EJERCICIOS  -->
        
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

        echo "<h2>Ejercicio 1</h2>";

        try {
            $pdo->exec("
                CREATE TABLE categoria (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    nombre VARCHAR(30) UNIQUE NOT NULL,
                    descripcion VARCHAR(100)
                )
            ");

            echo "<p>✅ Tabla categoria creada en ejercicio 1</p>";
        } catch(PDOException $e) {
            echo "<p>❌ Error al crear tabla categoria: " . $e->getMessage() . "</p>";
        }

        try {
            $pdo->exec("
                CREATE TABLE producto (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    nombre VARCHAR(100) NOT NULL,
                    categoria_id INT,
                    precio DECIMAL(4,2) NOT NULL,
                    stock INT(4),

                    CONSTRAINT fk_categoria_id FOREIGN KEY (categoria_id) REFERENCES categoria(id)
                )
            ");

            echo "<p>✅ Tabla producto creada</p>";
        } catch(PDOException $e) {
            echo "<p>❌ Error al crear tabla producto: " . $e->getMessage() . "</p>";
        }

        try {
            $pdo->exec("
                CREATE TABLE usuario (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    nombre VARCHAR(50) NOT NULL,
                    email VARCHAR(100) UNIQUE NOT NULL,
                    contrasena VARCHAR(100) NOT NULL
                )
            ");

            echo "<p>✅ Tabla usuario creada</p>";
        } catch(PDOException $e) {
            echo "<p>❌ Error al crear tabla usuario: " . $e->getMessage() . "</p>";
        }

        try {
            $pdo->exec("
                CREATE TABLE pedido (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    usuario_id INT NOT NULL,
                    fecha DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
                    total DECIMAL(4,2) NOT NULL,

                    CONSTRAINT fk_usuario_id FOREIGN KEY (usuario_id) REFERENCES usuario(id)
                );
            ");

            echo "<p>✅ Tabla pedido creada</p>";
        } catch(PDOException $e) {
            echo "<p>❌ Error al crear tabla pedido: " . $e->getMessage() . "</p>";
        }

        ?>

        


        <!-- FIN DE EJERCICIOS -->

        <h2>🔗 Enlaces Útiles</h2>
        <div class="info">
            <p><strong>phpMyAdmin:</strong> <a href="http://localhost:8081" target="_blank">http://localhost:8081</a></p>
            <p><strong>Credenciales BD:</strong></p>
            <ul>
                <li>Usuario: <code>alumno</code></li>
                <li>Contraseña: <code>alumno</code></li>
                <li>Base de datos: <code>testdb</code></li>
            </ul>
        </div>
    </div>
</body>
</html>
