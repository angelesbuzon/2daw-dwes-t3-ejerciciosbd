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
                    nombre VARCHAR(100) UNIQUE NOT NULL,
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


        /**
         * Ejercicio 2: Insertar datos iniciales
         * Inserta al menos 3 categorías (Cítricos, Frutas Rojas, Tropicales)
         * y 10 productos diferentes con sus precios y stock.
         */

        echo "<h2>Ejercicio 2</h2>";

        try {
            $pdo->exec("
                INSERT INTO categoria(nombre, descripcion) VALUES
                    ('Cítricos', 'Limoneras o con mucha vitamina C'),
                    ('Frutas rojas', 'Lo son incluso si eres daltónico'),
                    ('Tropicales', 'De allende los mares');
            ");

            echo "<p>✅ Categorías insertadas</p>";
        } catch (PDOException $e) {
            echo "<p>❌ Error al insertar categorías: " . $e->getMessage() . "</p>";
        }

        try {
            $pdo->exec("
                INSERT INTO producto(nombre, categoria_id, precio, stock) VALUES
                    ('Plátano', 3, 1.2, 50),
                    ('Mango', 3, 2, 10),
                    ('Aguacate', 3, 3.2, 20),
                    ('Limón de Murcia', 1, 0.9, 20),
                    ('Mandarina', 1, 1.3, 15),
                    ('Naranja de zumo', 1, 1.6, 5),
                    ('Naranja de mesa', 1, 1.35, 60),
                    ('Fresón', 2, 3.5, 8),
                    ('Arándano', 2, 4, 23),
                    ('Grosella', 2, 3.8, 80);
            ");

            /*nombre VARCHAR(100) NOT NULL,
                    categoria_id INT,
                    precio DECIMAL(4,2) NOT NULL,
                    stock INT(4),*/

            echo "<p>✅ Productos insertados</p>";
        } catch (PDOException $e) {
            echo "<p>❌ Error al insertar productos: " . $e->getMessage() . "</p>";
        }

        /**
         * Ejercicio 3: Consultas SELECT básicas
         * Escribe consultas PHP para:
         *  a) Obtener todos los productos ordenados por precio (menor a mayor)
         *  b) Obtener productos de una categoría específica
         *  c) Obtener productos con stock menor a 20
         *  d) Contar cuántos productos hay en total
         * 💡 Usa prepared statements con parámetros
         */

        echo "<h2>Ejercicio 3</h2>";

        try {
            echo "<h3>Productos ordenados por precio</h3>";

            $stmt = $pdo->query("SELECT * FROM producto ORDER BY precio");
            $productosOrdenadosPorPrecio = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<ul>";
            foreach ($productosOrdenadosPorPrecio as $p) {
                echo "<li>{$p['nombre']} ({$p['precio']} €)</li>";
            }
            echo "</ul>";
        } catch (PDOException $e) {
            echo "<p>❌ Error al hacer la consulta: " . $e->getMessage() . "</p>";
        }

        try {
            echo "<h3>Productos de cierta categoría</h3>";
            $categoriaID = 3;

            $stmt = $pdo->query("SELECT * FROM categoria WHERE id = $categoriaID");
            $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
            $categoriaNombre = $categoria['nombre'];

            $stmt = $pdo->query("SELECT * FROM producto WHERE categoria_id = $categoriaID");
            $productosDeCategoria = $stmt->fetchALL(PDO::FETCH_ASSOC);

            echo "<p>Productos de la categoría <strong>{$categoria['nombre']}</strong>:</p>";
            echo "<ul>";
            foreach ($productosDeCategoria as $p) {
                echo "<li>{$p['nombre']}</li>";
            }
            echo "</ul>";
        } catch (PDOException $e) {
            echo "<p>❌ Error al hacer la consulta: " . $e->getMessage() . "</p>";
        }


        try {
            echo "<h3>Productos con stock menor a 20</h3>";

            $stmt = $pdo->query("SELECT * FROM producto WHERE stock < 20");
            $productosPocoStock = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<ul>";
            foreach ($productosPocoStock as $p) {
                echo "<li>{$p['nombre']}</li>";
            }
            echo "</ul>";
        } catch (PDOException $e) {
            echo "<p>❌ Error al hacer la consulta: " . $e->getMessage() . "</p>";
        }

        try {
            echo "<h3>Conteo de productos</h3>";

            // Hay que especificar 'AS lo que sea' para poder obtener el número concreto en vez de todo el array asociativo que devuelve fetch())
            $stmt = $pdo->query("SELECT COUNT(*) AS total FROM producto");
            $total = $stmt->fetch(PDO::FETCH_ASSOC);

            echo "<p>Total de productos en la base de datos: " . $total['total'] . "</p>";
        } catch (PDOException $e) {
            echo "<p>❌ Error al hacer la consulta: " . $e->getMessage() . "</p>";
        }


        /**
         * Ejercicio 4: JOIN - Productos con categoría
         * Escribe una consulta que obtenga el nombre del producto, su precio y el nombre de su categoría.
         * Usa INNER JOIN.
         * Luego, ordena los resultados por categoría y dentro de cada categoría por precio.
         * 💡 SELECT p.nombre, p.precio, c.nombre FROM productos p INNER JOIN categorias c...
         */

        echo "<h2>Ejercicio 4</h2>";
        echo "<p>Lista de productos:</p>";

        try {
            $stmt = $pdo->query("
                SELECT p.nombre, p.precio, c.nombre as categoria 
                FROM producto p 
                INNER JOIN categoria c ON p.categoria_id = c.id 
                ORDER BY c.nombre, p.precio
            ");

            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<ul>";
            foreach ($productos as $p) {
                echo "<li>" . $p['nombre'] . " | "
                    . $p['categoria'] . " | "
                    . $p['precio'] . " EUR</li>";
            }
            echo "</ul>";


        } catch (PDOException $e) {
            echo "<p>❌ Error: " . $e->getMessage() . "</p>";
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
            <p><strong>Iniciar Docker:</strong> <code>sudo docker compose -f docker-compose-alumnos.yml up -d</code></p>
        </div>
    </div>
</body>
</html>
