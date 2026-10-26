<?php
// ============================================
// SESIONES E INICIO DE SESIÓN
// ============================================
// Una "sesión" es la forma en que PHP recuerda quién sos entre una página y otra.
// Cuando iniciás sesión, guardamos tu id en $_SESSION y el navegador recibe
// una cookie que lo identifica.

require_once __DIR__ . '/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,      // JavaScript no puede leer la cookie
        'samesite' => 'Lax',     // la cookie no viaja en formularios de otros sitios
        'secure'   => !empty($_SERVER['HTTPS']),
    ]);
    session_start();
}

// Devuelve el usuario logueado (id, nombre, email, rol) o null si no hay nadie.
function usuarioActual() {
    static $usuario = false;

    if ($usuario === false) {
        $usuario = null;
        if (!empty($_SESSION['usuario_id'])) {
            $consulta = db()->prepare('SELECT id, nombre, email, rol, creado_en FROM usuarios WHERE id = ?');
            $consulta->execute([$_SESSION['usuario_id']]);
            $usuario = $consulta->fetch() ?: null;
        }
    }

    return $usuario;
}

function esAdmin() {
    $usuario = usuarioActual();
    return $usuario && $usuario['rol'] === 'admin';
}

// Guarda al usuario en la sesión. Regeneramos el id de sesión por seguridad.
function iniciarSesion($idUsuario) {
    session_regenerate_id(true);
    $_SESSION['usuario_id'] = $idUsuario;
}

function cerrarSesion() {
    $_SESSION = [];
    session_regenerate_id(true);
}

// Si no hay nadie logueado, manda a la página de login.
// $base es la misma variable que usan las páginas ("../", etc.)
function requiereLogin($base) {
    if (!usuarioActual()) {
        header('Location: ' . $base . 'pages/login.php');
        exit;
    }
}

// Solo deja pasar a administradores.
function requiereAdmin($base) {
    requiereLogin($base);
    if (!esAdmin()) {
        http_response_code(403);
        header('Location: ' . $base . 'pages/cuenta.php');
        exit;
    }
}

// ============================================
// PROTECCIÓN CSRF
// ============================================
// Cada formulario lleva un código secreto. Así nos aseguramos de que
// el formulario lo mandó alguien desde NUESTRA página y no otro sitio.

function csrfToken() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

// Imprime el campo oculto para poner dentro de cada <form>
function csrfCampo() {
    return '<input type="hidden" name="csrf" value="' . csrfToken() . '">';
}

function csrfValido() {
    return isset($_POST['csrf']) && hash_equals(csrfToken(), $_POST['csrf']);
}

// Para mostrar un aviso una sola vez después de redirigir ("¡Producto guardado!")
function avisar($mensaje, $tipo = 'ok') {
    $_SESSION['aviso'] = ['mensaje' => $mensaje, 'tipo' => $tipo];
}

function tomarAviso() {
    $aviso = $_SESSION['aviso'] ?? null;
    unset($_SESSION['aviso']);
    return $aviso;
}
