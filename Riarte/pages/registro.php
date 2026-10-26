<?php
require_once __DIR__ . '/../includes/auth.php';

if (usuarioActual()) {
    header('Location: cuenta.php');
    exit;
}

$datos   = ['nombre' => '', 'email' => ''];
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos['nombre'] = trim($_POST['nombre'] ?? '');
    $datos['email']  = trim($_POST['email'] ?? '');
    $clave  = $_POST['clave'] ?? '';
    $clave2 = $_POST['clave2'] ?? '';

    if (!csrfValido()) {
        $errores['general'] = 'La página estuvo abierta mucho tiempo. Probá de nuevo.';
    }
    if ($datos['nombre'] === '' || mb_strlen($datos['nombre']) > 100) {
        $errores['nombre'] = 'Ingresá tu nombre.';
    }
    if (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'Ingresá un correo válido.';
    }
    if (strlen($clave) < 8) {
        $errores['clave'] = 'La contraseña tiene que tener al menos 8 caracteres.';
    } elseif ($clave !== $clave2) {
        $errores['clave2'] = 'Las contraseñas no coinciden.';
    }

    // ¿Ya hay alguien con ese correo?
    if (empty($errores)) {
        $consulta = db()->prepare('SELECT id FROM usuarios WHERE email = ?');
        $consulta->execute([$datos['email']]);
        if ($consulta->fetch()) {
            $errores['email'] = 'Ya existe una cuenta con ese correo. ¿Querés iniciar sesión?';
        }
    }

    if (empty($errores)) {
        $insertar = db()->prepare("INSERT INTO usuarios (nombre, email, clave_hash, rol) VALUES (?, ?, ?, 'cliente')");
        $insertar->execute([$datos['nombre'], $datos['email'], password_hash($clave, PASSWORD_DEFAULT)]);

        iniciarSesion((int) db()->lastInsertId());
        avisar('¡Bienvenido/a! Tu cuenta se creó correctamente.');
        header('Location: cuenta.php');
        exit;
    }
}

$titulo  = 'Crear cuenta - ' . $sitio['nombre'];
$base    = '../';
$estilos = ['cuenta.css'];
require __DIR__ . '/../includes/header.php';
?>
    <main class="cuenta">
        <section class="cuenta-caja">
            <h2>Crear cuenta</h2>
            <p class="cuenta-texto">Registrate para guardar tus datos y comprar más rápido.</p>

<?php if (isset($errores['general'])): ?>
            <div class="aviso aviso--error"><?= e($errores['general']) ?></div>
<?php endif; ?>

            <form method="POST" class="cuenta-form" novalidate>
                <?= csrfCampo() ?>
                <div class="campo">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?= e($datos['nombre']) ?>" required autocomplete="name">
                    <?php if (isset($errores['nombre'])): ?><span class="campo-error"><?= e($errores['nombre']) ?></span><?php endif; ?>
                </div>
                <div class="campo">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="<?= e($datos['email']) ?>" required autocomplete="email">
                    <?php if (isset($errores['email'])): ?><span class="campo-error"><?= e($errores['email']) ?></span><?php endif; ?>
                </div>
                <div class="campo">
                    <label for="clave">Contraseña</label>
                    <input type="password" id="clave" name="clave" required minlength="8" autocomplete="new-password">
                    <span class="campo-ayuda">Mínimo 8 caracteres.</span>
                    <?php if (isset($errores['clave'])): ?><span class="campo-error"><?= e($errores['clave']) ?></span><?php endif; ?>
                </div>
                <div class="campo">
                    <label for="clave2">Repetí la contraseña</label>
                    <input type="password" id="clave2" name="clave2" required autocomplete="new-password">
                    <?php if (isset($errores['clave2'])): ?><span class="campo-error"><?= e($errores['clave2']) ?></span><?php endif; ?>
                </div>
                <button type="submit" class="cuenta-btn">Crear cuenta</button>
            </form>

            <p class="cuenta-pie">¿Ya tenés cuenta? <a href="login.php">Ingresá acá</a></p>
        </section>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
