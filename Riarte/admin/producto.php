<?php
// ============================================
// PANEL — agregar o editar una tabla
// ============================================
// producto.php        → formulario vacío para una tabla nueva
// producto.php?id=3   → formulario con los datos de la tabla 3 para editarla

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/productos.php';
requiereAdmin('../');

$id       = isset($_GET['id']) ? (int) $_GET['id'] : null;
$producto = $id ? obtenerProducto($id) : null;

if ($id && !$producto) {
    avisar('Esa tabla no existe (quizás ya se borró).', 'error');
    header('Location: index.php');
    exit;
}

$esNuevo = $producto === null;
$datos   = $producto ?? [
    'nombre' => '', 'precio' => '', 'madera' => '', 'tabla' => '', 'descripcion' => '', 'imagen' => '',
];
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos['nombre']      = trim($_POST['nombre'] ?? '');
    $datos['precio']      = preg_replace('/\D/', '', $_POST['precio'] ?? ''); // "40.000" → "40000"
    $datos['madera']      = $_POST['madera'] ?? '';
    $datos['tabla']       = $_POST['tabla'] ?? '';
    $datos['descripcion'] = trim($_POST['descripcion'] ?? '');

    if (!csrfValido()) {
        $errores['general'] = 'La página estuvo abierta mucho tiempo. Probá de nuevo.';
    }
    if ($datos['nombre'] === '' || mb_strlen($datos['nombre']) > 150) {
        $errores['nombre'] = 'Escribí un nombre (hasta 150 letras).';
    }
    if ($datos['precio'] === '' || (int) $datos['precio'] <= 0) {
        $errores['precio'] = 'Escribí un precio mayor a cero.';
    }
    if (!isset($maderas[$datos['madera']])) {
        $errores['madera'] = 'Elegí una madera.';
    }
    if (!isset($tiposTabla[$datos['tabla']])) {
        $errores['tabla'] = 'Elegí un tipo de tabla.';
    }
    if ($datos['descripcion'] === '') {
        $errores['descripcion'] = 'Escribí una descripción corta.';
    }

    // La foto se sube solo si el resto está bien, así no quedan fotos sueltas
    if (empty($errores)) {
        [$fotoNueva, $errorFoto] = subirFoto($_FILES['foto'] ?? null);
        if ($errorFoto) {
            $errores['foto'] = $errorFoto;
        }
    }

    if (empty($errores)) {
        $fotoVieja = $datos['imagen'];
        if ($fotoNueva) {
            $datos['imagen'] = $fotoNueva;
        } elseif (!empty($_POST['quitar_foto'])) {
            $datos['imagen'] = '';
        }

        $datos['precio'] = (int) $datos['precio'];
        guardarProducto($datos, $esNuevo ? null : $id);

        // Si la foto cambió, borramos la anterior (solo si la habíamos subido desde el panel)
        if ($fotoVieja !== $datos['imagen']) {
            borrarFotoSubida($fotoVieja);
        }

        avisar($esNuevo ? '¡Tabla agregada!' : 'Cambios guardados.');
        header('Location: index.php');
        exit;
    }
}

$titulo  = ($esNuevo ? 'Agregar tabla' : 'Editar tabla') . ' - ' . $sitio['nombre'];
$base    = '../';
$estilos = ['cuenta.css', 'admin.css'];
$scripts = ['admin.js'];
require __DIR__ . '/../includes/header.php';

// Pequeña ayuda para no repetir el bloque de error en cada campo
function errorDe($campo, $errores) {
    return isset($errores[$campo]) ? '<span class="campo-error">' . e($errores[$campo]) . '</span>' : '';
}
?>
    <main class="admin">
        <div class="admin-cabecera">
            <div>
                <a href="index.php" class="admin-volver">← Volver al panel</a>
                <h2><?= $esNuevo ? 'Agregar tabla' : 'Editar tabla' ?></h2>
            </div>
        </div>

<?php if (!empty($errores)): ?>
        <div class="aviso aviso--error"><?= e($errores['general'] ?? 'Revisá los campos marcados.') ?></div>
<?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="admin-form" novalidate>
            <?= csrfCampo() ?>

            <div class="admin-form__datos cuenta-form">
                <div class="campo">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?= e($datos['nombre']) ?>"
                           placeholder="Tabla de asado Guayubira 50x30" maxlength="150" required>
                    <?= errorDe('nombre', $errores) ?>
                </div>

                <div class="admin-form__fila">
                    <div class="campo">
                        <label for="precio">Precio ($)</label>
                        <input type="text" inputmode="numeric" id="precio" name="precio"
                               value="<?= e($datos['precio']) ?>" placeholder="25000" required>
                        <?= errorDe('precio', $errores) ?>
                    </div>
                    <div class="campo">
                        <label for="madera">Madera</label>
                        <select id="madera" name="madera" required>
                            <option value="">Elegí…</option>
<?php foreach ($maderas as $valor => $texto): ?>
                            <option value="<?= $valor ?>"<?= $datos['madera'] === $valor ? ' selected' : '' ?>><?= $texto ?></option>
<?php endforeach; ?>
                        </select>
                        <?= errorDe('madera', $errores) ?>
                    </div>
                    <div class="campo">
                        <label for="tabla">Tipo</label>
                        <select id="tabla" name="tabla" required>
                            <option value="">Elegí…</option>
<?php foreach ($tiposTabla as $valor => $texto): ?>
                            <option value="<?= $valor ?>"<?= $datos['tabla'] === $valor ? ' selected' : '' ?>><?= $texto ?></option>
<?php endforeach; ?>
                        </select>
                        <?= errorDe('tabla', $errores) ?>
                    </div>
                </div>

                <div class="campo">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="5" required
                              placeholder="Contá para qué sirve, qué la hace especial y sus medidas."><?= e($datos['descripcion']) ?></textarea>
                    <?= errorDe('descripcion', $errores) ?>
                </div>
            </div>

            <div class="admin-form__foto">
                <span class="admin-form__label">Foto</span>
                <img id="vista-previa" class="admin-vista-previa"
                     src="<?= e(imagenProducto($datos['imagen'], $base)) ?>" alt="Vista previa de la foto">
                <label class="admin-subir">
                    <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/webp">
                    <?= $datos['imagen'] ? 'Cambiar foto' : 'Elegir foto' ?>
                </label>
                <span class="campo-ayuda">JPG, PNG o WEBP, hasta 5 MB.</span>
                <?= errorDe('foto', $errores) ?>
<?php if (!$esNuevo && $datos['imagen'] !== ''): ?>
                <label class="admin-check">
                    <input type="checkbox" name="quitar_foto" value="1"> Quitar la foto actual
                </label>
<?php endif; ?>
            </div>

            <div class="admin-form__botones">
                <button type="submit" class="cuenta-btn"><?= $esNuevo ? 'Agregar tabla' : 'Guardar cambios' ?></button>
                <a href="index.php" class="cuenta-btn cuenta-btn--secundario">Cancelar</a>
            </div>
        </form>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
