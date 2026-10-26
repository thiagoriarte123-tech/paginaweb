<?php
// ============================================
// ENCABEZADO COMÚN — se incluye en todas las páginas
// ============================================
// Antes de incluir este archivo, cada página define:
//   $titulo   → el texto de la pestaña del navegador
//   $base     → cuántas carpetas hay que "subir" para llegar a la raíz
//               ("" en index.php, "../" en pages/, "../../" en pages/tips/)
//   $estilos  → lista de hojas CSS propias de esa página (opcional)
//   $actual   → archivo del menú que se marca como página actual (opcional)

require_once __DIR__ . '/config.php';

$titulo  = $titulo  ?? $sitio['nombre'];
$base    = $base    ?? '';
$estilos = $estilos ?? [];
$actual  = $actual  ?? '';

// Estos CSS los usan todas las páginas; después se suman los de cada una.
$estilosComunes = ['estilos.css', 'header.css', 'navegador.css'];
$todosLosEstilos = array_merge($estilosComunes, $estilos, ['footer.css']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($titulo) ?></title>
<?php foreach ($todosLosEstilos as $css): ?>
    <link rel="stylesheet" href="<?= $base ?>css/<?= $css ?>">
<?php endforeach; ?>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <header class="navbar">
        <a href="<?= $base ?>index.php">
            <img src="<?= $base ?>images/logo.webp" alt="Logo" class="logo-img">
        </a>

        <nav class="navegador">
            <ul>
<?php foreach ($menu as $texto => $archivo): ?>
                <li><a href="<?= $base . $archivo ?>"<?= $archivo === $actual ? ' class="activo" aria-current="page"' : '' ?>><?= $texto ?></a></li>
<?php endforeach; ?>
            </ul>
        </nav>

        <a href="<?= $base ?>pages/carrito.php" class="carrito-link">
            <img src="<?= $base ?>images/carlog.webp" alt="Carrito" class="carrito-img">
            <span class="carrito-contador" id="carrito-contador"></span>
        </a>
    </header>

    <div class="barra-promo">
        <div class="barra-promo-track">
<?php
// La barra se escribe dos veces para que la animación sea continua.
$promos = ['Diseños únicos', 'Envíos a todo el país', 'Hechas a mano', 'Personalizá tus productos'];
for ($i = 0; $i < 2; $i++): ?>
            <div class="barra-promo-grupo">
<?php foreach ($promos as $promo): ?>
                <span><?= $promo ?></span>
<?php endforeach; ?>
            </div>
<?php endfor; ?>
        </div>
    </div>

