<?php
// Cierra la sesión. Solo acepta el botón "Cerrar sesión" (POST con código CSRF),
// así otro sitio no puede desloguearte con un simple link.
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrfValido()) {
    cerrarSesion();
    avisar('Cerraste sesión. ¡Hasta pronto!');
    header('Location: login.php');
    exit;
}

header('Location: cuenta.php');
exit;
