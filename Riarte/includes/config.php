<?php
// ============================================
// CONFIGURACIÓN GENERAL — Tablas El Cóndor
// ============================================
// Los datos que se repiten en todo el sitio viven acá.
// Si cambia el WhatsApp o el mail, se cambia en un solo lugar.

$sitio = [
    'nombre'    => 'Tablas El Cóndor',
    'eslogan'   => 'De la naturaleza a tu mesada.',
    'instagram' => 'https://www.instagram.com/tablaselcondor?igsh=Z2ZkdjkxanBiOWhl',
    'facebook'  => 'https://www.facebook.com/share/19QZ3HHV6k/',

    // WhatsApp en formato internacional, sin "+" ni espacios:
    // 54 (Argentina) + 9 (celular) + número sin el 15.
    'whatsapp'  => '5491130005522',

    // A este correo llegan los mensajes del formulario de contacto.
    // ¡Cambialo por el mail real del negocio!
    'email_contacto' => 'tu-correo@ejemplo.com',
];

// Links del menú: texto => archivo (relativo a la carpeta raíz del sitio)
$menu = [
    'Inicio'    => 'index.php',
    'Productos' => 'pages/productos.php',
    'Blog'      => 'pages/blog.php',
    'Contacto'  => 'pages/contacto.php',
];

// Función de ayuda para mostrar texto de forma segura en el HTML.
// Evita que alguien meta código raro (por ejemplo, en el formulario).
function e($texto) {
    return htmlspecialchars($texto ?? '', ENT_QUOTES, 'UTF-8');
}
