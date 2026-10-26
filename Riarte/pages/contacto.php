<?php
require_once __DIR__ . '/../includes/config.php';

// ============================================
// PROCESAR EL FORMULARIO
// ============================================
// Este bloque solo se ejecuta cuando alguien aprieta "Enviar mensaje".
// Va antes de cualquier HTML porque puede redirigir la página.

$datos   = ['nombre' => '', 'email' => '', 'telefono' => '', 'mensaje' => ''];
$errores = [];
$enviado = isset($_GET['enviado']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Leer lo que escribió la persona (trim saca espacios al principio y al final)
    foreach ($datos as $campo => $valor) {
        $datos[$campo] = trim($_POST[$campo] ?? '');
    }

    // Campo trampa anti-spam: es invisible, así que una persona nunca lo completa.
    // Si viene con algo, casi seguro es un robot: hacemos como que salió bien.
    if (!empty($_POST['sitio_web'])) {
        header('Location: contacto.php?enviado=1');
        exit;
    }

    // 2. Validar
    if ($datos['nombre'] === '') {
        $errores['nombre'] = 'Ingresá tu nombre.';
    }
    if (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'Ingresá un correo válido.';
    }
    if (!preg_match('/^[0-9 +()-]{8,20}$/', $datos['telefono'])) {
        $errores['telefono'] = 'Ingresá un teléfono válido (solo números, espacios o guiones).';
    }
    if (mb_strlen($datos['mensaje']) < 10) {
        $errores['mensaje'] = 'El mensaje tiene que tener al menos 10 caracteres.';
    }

    // 3. Si está todo bien, mandar el mail
    if (empty($errores)) {
        $asunto = 'Nueva consulta desde la web - ' . $datos['nombre'];

        $cuerpo  = "Nombre: {$datos['nombre']}\n";
        $cuerpo .= "Correo: {$datos['email']}\n";
        $cuerpo .= "Teléfono: {$datos['telefono']}\n\n";
        $cuerpo .= "Mensaje:\n{$datos['mensaje']}\n";

        // Quitamos saltos de línea del mail para que nadie pueda inyectar encabezados
        $emailLimpio = str_replace(["\r", "\n"], '', $datos['email']);
        $cabeceras  = "Reply-To: {$emailLimpio}\r\n";
        $cabeceras .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $salioBien = @mail(
            $sitio['email_contacto'],
            '=?UTF-8?B?' . base64_encode($asunto) . '?=',
            $cuerpo,
            $cabeceras
        );

        if ($salioBien) {
            // Redirigimos para que al recargar la página no se mande el mail de nuevo
            header('Location: contacto.php?enviado=1');
            exit;
        }

        $errores['general'] = 'No pudimos enviar tu mensaje en este momento. '
            . 'Probá de nuevo más tarde o escribinos por WhatsApp.';
    }
}

// ============================================
// MOSTRAR LA PÁGINA
// ============================================
$titulo  = 'Tablas El Cóndor - Contacto';
$base    = '../';
$estilos = ['contacto.css'];
$scripts = [];
$actual  = 'pages/contacto.php';
require __DIR__ . '/../includes/header.php';
?>
    <main>
        <section class="contacto-hero">
            <h2>Contacto</h2>
            <p>Completá el formulario y nos comunicamos a la brevedad.</p>
        </section>

        <section class="contacto-form-wrapper">
<?php if ($enviado): ?>
            <div class="contacto-aviso contacto-aviso--ok">
                <p><strong>¡Gracias por escribirnos!</strong></p>
                <p>Recibimos tu mensaje y te respondemos a la brevedad.</p>
                <a href="contacto.php" class="contacto-btn">Enviar otro mensaje</a>
            </div>
<?php else: ?>
            <form class="contacto-form" action="contacto.php" method="POST" novalidate>

<?php if (!empty($errores)): ?>
                <div class="contacto-aviso contacto-aviso--error">
                    <?= isset($errores['general']) ? e($errores['general']) : 'Revisá los campos marcados.' ?>
                </div>
<?php endif; ?>

                <div class="form-group">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Juan Pérez" required
                           value="<?= e($datos['nombre']) ?>">
<?php if (isset($errores['nombre'])): ?>
                    <span class="form-error"><?= e($errores['nombre']) ?></span>
<?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" placeholder="juan@mail.com" required
                           value="<?= e($datos['email']) ?>">
<?php if (isset($errores['email'])): ?>
                    <span class="form-error"><?= e($errores['email']) ?></span>
<?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="telefono">Número de teléfono</label>
                    <input type="tel" autocomplete="tel" id="telefono" name="telefono" placeholder="11-9999-9999" required
                           value="<?= e($datos['telefono']) ?>">
<?php if (isset($errores['telefono'])): ?>
                    <span class="form-error"><?= e($errores['telefono']) ?></span>
<?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea id="mensaje" name="mensaje" rows="6" placeholder="Escribí tu consulta acá..." required><?= e($datos['mensaje']) ?></textarea>
<?php if (isset($errores['mensaje'])): ?>
                    <span class="form-error"><?= e($errores['mensaje']) ?></span>
<?php endif; ?>
                </div>

                <!-- Campo trampa anti-spam: oculto para las personas -->
                <div class="campo-trampa" aria-hidden="true">
                    <label for="sitio_web">No completar</label>
                    <input type="text" id="sitio_web" name="sitio_web" tabindex="-1" autocomplete="off">
                </div>

                <button type="submit" class="contacto-btn">Enviar mensaje</button>
            </form>
<?php endif; ?>
        </section>

    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
