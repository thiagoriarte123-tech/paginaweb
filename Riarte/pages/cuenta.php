<?php
require_once __DIR__ . '/../includes/auth.php';
requiereLogin('../');

$usuario = usuarioActual();
$errores = [];
$accion  = $_POST['accion'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfValido()) {
        $errores['general'] = 'La página estuvo abierta mucho tiempo. Probá de nuevo.';
    }

    // --- Cambiar el nombre ---
    elseif ($accion === 'datos') {
        $nombre = trim($_POST['nombre'] ?? '');
        if ($nombre === '' || mb_strlen($nombre) > 100) {
            $errores['nombre'] = 'Ingresá tu nombre.';
        } else {
            db()->prepare('UPDATE usuarios SET nombre = ? WHERE id = ?')->execute([$nombre, $usuario['id']]);
            avisar('Guardamos tus datos.');
            header('Location: cuenta.php');
            exit;
        }
    }

    // --- Cambiar la contraseña ---
    elseif ($accion === 'clave') {
        $actual = $_POST['clave_actual'] ?? '';
        $nueva  = $_POST['clave_nueva'] ?? '';
        $nueva2 = $_POST['clave_nueva2'] ?? '';

        $consulta = db()->prepare('SELECT clave_hash FROM usuarios WHERE id = ?');
        $consulta->execute([$usuario['id']]);
        $hash = $consulta->fetchColumn();

        if (!password_verify($actual, $hash)) {
            $errores['clave_actual'] = 'La contraseña actual no es correcta.';
        } elseif (strlen($nueva) < 8) {
            $errores['clave_nueva'] = 'La contraseña nueva tiene que tener al menos 8 caracteres.';
        } elseif ($nueva !== $nueva2) {
            $errores['clave_nueva2'] = 'Las contraseñas no coinciden.';
        } else {
            db()->prepare('UPDATE usuarios SET clave_hash = ? WHERE id = ?')
                ->execute([password_hash($nueva, PASSWORD_DEFAULT), $usuario['id']]);
            avisar('Cambiaste tu contraseña.');
            header('Location: cuenta.php');
            exit;
        }
    }
}

$aviso = tomarAviso();

$titulo  = 'Mi cuenta - ' . $sitio['nombre'];
$base    = '../';
$estilos = ['cuenta.css'];
require __DIR__ . '/../includes/header.php';
?>
    <main class="cuenta">
        <section class="cuenta-caja cuenta-caja--ancha">
            <h2>Hola, <?= e($usuario['nombre']) ?></h2>
            <p class="cuenta-texto">Desde acá podés ver y cambiar los datos de tu cuenta.</p>

<?php if ($aviso): ?>
            <div class="aviso aviso--<?= e($aviso['tipo']) ?>"><?= e($aviso['mensaje']) ?></div>
<?php endif; ?>
<?php if (isset($errores['general'])): ?>
            <div class="aviso aviso--error"><?= e($errores['general']) ?></div>
<?php endif; ?>

            <dl class="cuenta-datos">
                <dt>Correo</dt>
                <dd><?= e($usuario['email']) ?></dd>
                <dt>Cliente desde</dt>
                <dd><?= date('d/m/Y', strtotime($usuario['creado_en'])) ?></dd>
<?php if ($usuario['rol'] === 'admin'): ?>
                <dt>Tipo de cuenta</dt>
                <dd>Administrador</dd>
<?php endif; ?>
            </dl>

            <h3>Tus datos</h3>
            <form method="POST" class="cuenta-form">
                <?= csrfCampo() ?>
                <input type="hidden" name="accion" value="datos">
                <div class="campo">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?= e($_POST['nombre'] ?? $usuario['nombre']) ?>" required>
                    <?php if (isset($errores['nombre'])): ?><span class="campo-error"><?= e($errores['nombre']) ?></span><?php endif; ?>
                </div>
                <div>
                    <button type="submit" class="cuenta-btn">Guardar</button>
                </div>
            </form>

            <h3>Cambiar contraseña</h3>
            <form method="POST" class="cuenta-form">
                <?= csrfCampo() ?>
                <input type="hidden" name="accion" value="clave">
                <div class="campo">
                    <label for="clave_actual">Contraseña actual</label>
                    <input type="password" id="clave_actual" name="clave_actual" required autocomplete="current-password">
                    <?php if (isset($errores['clave_actual'])): ?><span class="campo-error"><?= e($errores['clave_actual']) ?></span><?php endif; ?>
                </div>
                <div class="campo">
                    <label for="clave_nueva">Contraseña nueva</label>
                    <input type="password" id="clave_nueva" name="clave_nueva" required minlength="8" autocomplete="new-password">
                    <?php if (isset($errores['clave_nueva'])): ?><span class="campo-error"><?= e($errores['clave_nueva']) ?></span><?php endif; ?>
                </div>
                <div class="campo">
                    <label for="clave_nueva2">Repetí la contraseña nueva</label>
                    <input type="password" id="clave_nueva2" name="clave_nueva2" required autocomplete="new-password">
                    <?php if (isset($errores['clave_nueva2'])): ?><span class="campo-error"><?= e($errores['clave_nueva2']) ?></span><?php endif; ?>
                </div>
                <div>
                    <button type="submit" class="cuenta-btn">Cambiar contraseña</button>
                </div>
            </form>

            <div class="cuenta-acciones">
<?php if ($usuario['rol'] === 'admin'): ?>
                <a href="../admin/index.php" class="cuenta-btn">Ir al panel</a>
<?php endif; ?>
                <form method="POST" action="salir.php">
                    <?= csrfCampo() ?>
                    <button type="submit" class="cuenta-btn cuenta-btn--secundario">Cerrar sesión</button>
                </form>
            </div>
        </section>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
