<?php
// ============================================
// CONEXIÓN A LA BASE DE DATOS
// ============================================
// Usamos PDO, la forma moderna de hablar con MySQL desde PHP.
// La función db() se conecta una sola vez y después reutiliza la conexión.

require_once __DIR__ . '/config.php';

function db() {
    global $db_config;
    static $conexion = null;

    if ($conexion === null) {
        $dsn = "mysql:host={$db_config['host']};dbname={$db_config['nombre']};charset=utf8mb4";
        try {
            $conexion = new PDO($dsn, $db_config['usuario'], $db_config['clave'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // los errores se avisan
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // filas como arrays con nombre
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $ex) {
            http_response_code(500);
            echo '<p style="font-family:sans-serif;padding:20px">'
               . '<strong>No se pudo conectar a la base de datos.</strong><br>'
               . 'Revisá que MySQL esté encendido en XAMPP y que ya hayas ejecutado <code>instalar.php</code>.'
               . '</p>';
            exit;
        }
    }

    return $conexion;
}
