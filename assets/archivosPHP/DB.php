<?php
    include '.env.php';

    class DB {
        /* Crear la cadena de conexión */
        public static function conn() {
            try {
                $conn = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BD, USUARIO, PASSWORD);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            }catch(PDOException $e) {
                echo "HA FALLADO LA CONEXIÓN: " . $e->getMessage();
            }
        }
    }
?>