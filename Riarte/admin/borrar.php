<?php
// Borra un producto. Solo acepta el botón "Borrar" del panel (POST con código CSRF).
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/productos.php';
requiereAdmin('../');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrfValido()) {
    $id = (int) ($_POST['id'] ?? 0);
    $producto = obtenerProducto($id);

    if ($producto) {
        borrarProducto($id);
        avisar('Se borró «' . $producto['nombre'] . '».');
    }
}

header('Location: index.php');
exit;
