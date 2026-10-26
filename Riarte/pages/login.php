<?php
require_once __DIR__ . '/../includes/auth.php';

// Si ya inició sesión, no tiene sentido mostrarle el login
if (usuarioActual()) {
    header('Location: ' . (esAdmin() ? '../admin/index.php' : 'cuenta.php'));
    exit;
}

$email = '';
$error = '';

// Límite simple de intentos: después de 5 errores, esperar 5 minutos
$intentos  = $_SESSION['login_intentos'] ?? 0;
$bloqueado = $intentos >= 5 && time() - ($_SESSION['login_ultimo'] ?? 0) < 300;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $clave = $_POST['clave'] ?? '';

    if (!csrfValido()) {
        $error = 'La página estuvo abierta mucho tiempo. Probá de nuevo.';
    } elseif ($bloqueado) {
        $error = 'Demasiados intentos. Esperá unos minutos y volvé a probar.';
    } else {
        $consulta = db()->prepare('SELECT id, clave_hash, rol FROM usuarios WHERE email = ?');
        $consulta->execute([$email]);
        $usuario = $consulta->fetch();

        // password_verify compara la contraseña escrita con la guardada encriptada
        if ($usuario && password_verify($clave, $usuario['clave_hash'])) {
            unset($_SESSION['login_intentos'], $_SESSION['login_ultimo']);
            iniciarSesion($usuario['id']);
            header('Location: ' . ($usuario['rol'] === 'admin' ? '../admin/index.php' : 'cuenta.php'));
            exit;
        }

        // Mismo mensaje si falla el mail o la contraseña: así no se revela qué cuentas existen
        $_SESSION['login_intentos'] = $intentos + 1;
        $_SESSION['login_ultimo']   = time();
        $error = 'El correo o la contraseña no son correctos.';
    }
}

$aviso = tomarAviso();

$titulo  = 'Ingresar - ' . $sitio['nombre'];
$base    = '../';
$estilos = ['cuenta.css'];
require __DIR__ . '/../includes/header.php';
?>
    <main class="cuenta">
        <section class="cuenta-caja">
            <h2>Ingresar</h2>
            <p class="cuenta-texto">Entrá con tu correo y contraseña.</p>

<?php if ($aviso): ?>
            <div class="aviso aviso--<?= e($aviso['tipo']) ?>"><?= e($aviso['mensaje']) ?></div>
<?php endif; ?>
<?php if ($error): ?>
            <div class="aviso aviso--error"><?= e($error) ?></div>
<?php endif; ?>

            <form method="POST" class="cuenta-form">
                <?= csrfCampo() ?>
                <div class="campo">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="<?= e($email) ?>" required autocomplete="email" autofocus>
                </div>
                <div class="campo">
                    <label for="clave">Contraseña</label>
                    <input type="password" id="clave" name="clave" required autocomplete="current-password">
                </div>
                <button type="submit" class="cuenta-btn">Ingresar</button>
            </form>

            <p class="cuenta-pie">¿No tenés cuenta? <a href="registro.php">Creá una acá</a></p>
        </section>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
