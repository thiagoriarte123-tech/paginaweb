<?php
// ============================================
// INSTALADOR — se usa UNA sola vez
// ============================================
// Crea la base de datos, las tablas, carga los productos que ya tenías
// y crea tu usuario administrador.
// Cuando termines, BORRÁ este archivo (o renombralo) por seguridad.

require_once __DIR__ . '/includes/config.php';

// Conexión a MySQL sin elegir base todavía (porque puede que no exista)
function conexionServidor() {
    global $db_config;
    return new PDO(
        "mysql:host={$db_config['host']};charset=utf8mb4",
        $db_config['usuario'],
        $db_config['clave'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
}

$errores   = [];
$datos     = ['nombre' => '', 'email' => ''];
$yaInstalado = false;

try {
    $pdo = conexionServidor();
    $nombreBase = $db_config['nombre'];

    // ¿Ya existe la base con un administrador adentro?
    $existe = $pdo->query("SHOW DATABASES LIKE " . $pdo->quote($nombreBase))->fetch();
    if ($existe) {
        $pdo->exec("USE `$nombreBase`");
        $hayTabla = $pdo->query("SHOW TABLES LIKE 'usuarios'")->fetch();
        if ($hayTabla) {
            $yaInstalado = (bool) $pdo->query("SELECT id FROM usuarios WHERE rol = 'admin' LIMIT 1")->fetch();
        }
    }
} catch (PDOException $ex) {
    $errores['general'] = 'No se pudo conectar a MySQL. Abrí el panel de XAMPP y dale "Start" a MySQL. '
        . '(Detalle: ' . $ex->getMessage() . ')';
}

if (!$yaInstalado && empty($errores) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos['nombre'] = trim($_POST['nombre'] ?? '');
    $datos['email']  = trim($_POST['email'] ?? '');
    $clave  = $_POST['clave'] ?? '';
    $clave2 = $_POST['clave2'] ?? '';

    if ($datos['nombre'] === '') $errores['nombre'] = 'Ingresá un nombre.';
    if (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) $errores['email'] = 'Ingresá un correo válido.';
    if (strlen($clave) < 8) $errores['clave'] = 'La contraseña tiene que tener al menos 8 caracteres.';
    elseif ($clave !== $clave2) $errores['clave2'] = 'Las contraseñas no coinciden.';

    if (empty($errores)) {
        // 1. Crear la base de datos
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$nombreBase` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE `$nombreBase`");

        // 2. Crear las tablas
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS productos (
                id          INT AUTO_INCREMENT PRIMARY KEY,
                nombre      VARCHAR(150) NOT NULL,
                precio      INT UNSIGNED NOT NULL,
                madera      VARCHAR(50)  NOT NULL,
                tabla       VARCHAR(50)  NOT NULL,
                descripcion TEXT         NOT NULL,
                imagen      VARCHAR(255) NOT NULL DEFAULT '',
                creado_en   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS usuarios (
                id         INT AUTO_INCREMENT PRIMARY KEY,
                nombre     VARCHAR(100) NOT NULL,
                email      VARCHAR(150) NOT NULL UNIQUE,
                clave_hash VARCHAR(255) NOT NULL,
                rol        ENUM('cliente', 'admin') NOT NULL DEFAULT 'cliente',
                creado_en  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        // 3. Cargar los productos que estaban en productos.js (solo si la tabla está vacía)
        $cantidad = (int) $pdo->query('SELECT COUNT(*) FROM productos')->fetchColumn();
        if ($cantidad === 0) {
            $iniciales = [
                ['Tabla de asado Guayubira 50x30', 40000, 'guayubira', 'asado', 'images/asado grande guayubira.webp',
                 'Tabla de asado grande ideal para cortar carnes y servir. Hecha de madera de guayubira resistente y duradera. Medidas 50x30 cm.'],
                ['Tabla de asado (chico) Guayubira 40x30', 35000, 'guayubira', 'asado', 'images/asado chico guayubira.webp',
                 'Tabla de asado tamaño mediano perfecta para asados familiares. Madera de guayubira de alta calidad. Medidas 40x30 cm.'],
                ['Tabla de cocina simple Guayubira 40x25', 20000, 'guayubira', 'cocina', 'images/cocina guayubira.webp',
                 'Tabla de cocina versátil para preparación diaria. Madera de guayubira resistente a humedad. Medidas 40x25 cm.'],
                ['Tabla de cocina colgable Guayubira 40x25', 20000, 'guayubira', 'cocina', 'images/cocina guayubira cuelga.webp',
                 'Tabla de cocina con agujero para colgar, ideal para ahorrar espacio. Madera de guayubira premium. Medidas 40x25 cm.'],
                ['Tabla de cocina simple Eucalipto 40x25', 15000, 'eucalipto', 'cocina', '',
                 'Tabla de cocina económica y funcional. Madera de eucalipto tratada. Medidas 40x25 cm.'],
                ['Tabla de cocina colgable Eucalipto 40x25', 15000, 'eucalipto', 'cocina', '',
                 'Tabla de cocina colgable de eucalipto. Perfecta para cocinas pequeñas. Medidas 40x25 cm.'],
                ['Tabla de asado chico Eucalipto 40x30', 20000, 'eucalipto', 'asado', '',
                 'Tabla de asado compacta de eucalipto. Ideal para asados íntimos. Medidas 40x30 cm.'],
                ['Tabla de asado Eucalipto 50x30', 25000, 'eucalipto', 'asado', 'images/asado grande eucalipto.webp',
                 'Tabla de asado grande de eucalipto resistente. Perfecta para cortes grandes de carne. Medidas 50x30 cm.'],
                ['Tabla de picada Eucalipto 50x17', 25000, 'eucalipto', 'picada', 'images/picada eucalipto.webp',
                 'Tabla alargada ideal para picadas y aperitivos. Madera de eucalipto de calidad. Medidas 50x17 cm.'],
                ['Plato de Eucalipto 25x25', 8000, 'eucalipto', 'plato', 'images/plato eucalipto.webp',
                 'Plato de madera cuadrado ideal para servir. Madera de eucalipto tratada. Medidas 25x25 cm.'],
            ];
            $insertar = $pdo->prepare('INSERT INTO productos (nombre, precio, madera, tabla, imagen, descripcion) VALUES (?, ?, ?, ?, ?, ?)');
            foreach ($iniciales as $producto) {
                $insertar->execute($producto);
            }
        }

        // 4. Crear el administrador (la contraseña se guarda encriptada, nunca tal cual)
        $insertar = $pdo->prepare("INSERT INTO usuarios (nombre, email, clave_hash, rol) VALUES (?, ?, ?, 'admin')
                                   ON DUPLICATE KEY UPDATE clave_hash = VALUES(clave_hash), rol = 'admin'");
        $insertar->execute([$datos['nombre'], $datos['email'], password_hash($clave, PASSWORD_DEFAULT)]);

        $yaInstalado = true;
        $recienInstalado = true;
    }
}

$titulo  = 'Instalación - ' . $sitio['nombre'];
$base    = '';
$estilos = ['cuenta.css'];
require __DIR__ . '/includes/header.php';
?>
    <main class="cuenta">
        <section class="cuenta-caja">
<?php if (!empty($recienInstalado)): ?>
            <h2>¡Listo!</h2>
            <div class="aviso aviso--ok">
                Se creó la base de datos, se cargaron tus productos y tu usuario administrador.
            </div>
            <p class="cuenta-texto"><strong>Importante:</strong> borrá el archivo <code>instalar.php</code> de la carpeta del sitio.</p>
            <a href="pages/login.php" class="cuenta-btn">Ir a iniciar sesión</a>

<?php elseif ($yaInstalado): ?>
            <h2>Ya está instalado</h2>
            <p class="cuenta-texto">La base de datos ya tiene un administrador. Por seguridad, borrá el archivo <code>instalar.php</code>.</p>
            <a href="pages/login.php" class="cuenta-btn">Ir a iniciar sesión</a>

<?php else: ?>
            <h2>Instalación</h2>
            <p class="cuenta-texto">Esto crea la base de datos <code><?= e($db_config['nombre']) ?></code>, carga tus productos y crea tu usuario administrador.</p>

<?php if (isset($errores['general'])): ?>
            <div class="aviso aviso--error"><?= e($errores['general']) ?></div>
<?php else: ?>
            <form method="POST" class="cuenta-form" novalidate>
                <div class="campo">
                    <label for="nombre">Tu nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?= e($datos['nombre']) ?>" required>
                    <?php if (isset($errores['nombre'])): ?><span class="campo-error"><?= e($errores['nombre']) ?></span><?php endif; ?>
                </div>
                <div class="campo">
                    <label for="email">Correo (con este vas a entrar)</label>
                    <input type="email" id="email" name="email" value="<?= e($datos['email']) ?>" required>
                    <?php if (isset($errores['email'])): ?><span class="campo-error"><?= e($errores['email']) ?></span><?php endif; ?>
                </div>
                <div class="campo">
                    <label for="clave">Contraseña</label>
                    <input type="password" id="clave" name="clave" required minlength="8" autocomplete="new-password">
                    <?php if (isset($errores['clave'])): ?><span class="campo-error"><?= e($errores['clave']) ?></span><?php endif; ?>
                </div>
                <div class="campo">
                    <label for="clave2">Repetí la contraseña</label>
                    <input type="password" id="clave2" name="clave2" required autocomplete="new-password">
                    <?php if (isset($errores['clave2'])): ?><span class="campo-error"><?= e($errores['clave2']) ?></span><?php endif; ?>
                </div>
                <button type="submit" class="cuenta-btn">Instalar</button>
            </form>
<?php endif; ?>
<?php endif; ?>
        </section>
    </main>

<?php require __DIR__ . '/includes/footer.php'; ?>
