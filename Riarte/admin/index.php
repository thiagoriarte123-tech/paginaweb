<?php
// ============================================
// PANEL DE ADMINISTRACIÓN — lista de productos
// ============================================
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/productos.php';
requiereAdmin('../');

$productos = obtenerProductos();
$clientes  = (int) db()->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'cliente'")->fetchColumn();
$aviso     = tomarAviso();

$titulo  = 'Panel - ' . $sitio['nombre'];
$base    = '../';
$estilos = ['cuenta.css', 'admin.css'];
require __DIR__ . '/../includes/header.php';
?>
    <main class="admin">
        <div class="admin-cabecera">
            <div>
                <span class="admin-etiqueta">Panel de administración</span>
                <h2>Tus tablas</h2>
            </div>
            <a href="producto.php" class="cuenta-btn">+ Agregar tabla</a>
        </div>

<?php if ($aviso): ?>
        <div class="aviso aviso--<?= e($aviso['tipo']) ?>"><?= e($aviso['mensaje']) ?></div>
<?php endif; ?>

        <div class="admin-resumen">
            <div class="admin-dato">
                <span class="admin-dato__numero"><?= count($productos) ?></span>
                <span class="admin-dato__texto">productos</span>
            </div>
            <div class="admin-dato">
                <span class="admin-dato__numero"><?= $clientes ?></span>
                <span class="admin-dato__texto">clientes registrados</span>
            </div>
        </div>

<?php if (empty($productos)): ?>
        <div class="admin-vacio">
            <p>Todavía no cargaste ninguna tabla.</p>
            <a href="producto.php" class="cuenta-btn">Agregar la primera</a>
        </div>
<?php else: ?>
        <div class="admin-tabla-wrap">
            <table class="admin-tabla">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Madera</th>
                        <th>Tipo</th>
                        <th class="num">Precio</th>
                        <th class="acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($productos as $p): ?>
                    <tr>
                        <td><img class="admin-foto" src="<?= e(imagenProducto($p['imagen'], $base)) ?>" alt=""></td>
                        <td class="admin-nombre"><?= e($p['nombre']) ?></td>
                        <td><?= e($maderas[$p['madera']] ?? $p['madera']) ?></td>
                        <td><?= e($tiposTabla[$p['tabla']] ?? $p['tabla']) ?></td>
                        <td class="num">$<?= number_format($p['precio'], 0, ',', '.') ?></td>
                        <td class="acciones">
                            <a href="producto.php?id=<?= $p['id'] ?>" class="admin-btn">Editar</a>
                            <form method="POST" action="borrar.php"
                                  onsubmit="return confirm('¿Borrar esta tabla? No se puede deshacer.');">
                                <?= csrfCampo() ?>
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <button type="submit" class="admin-btn admin-btn--peligro">Borrar</button>
                            </form>
                        </td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
<?php endif; ?>

        <div class="admin-pie">
            <a href="../pages/productos.php" class="cuenta-btn cuenta-btn--secundario">Ver la tienda</a>
            <a href="../pages/cuenta.php" class="cuenta-btn cuenta-btn--secundario">Mi cuenta</a>
            <form method="POST" action="../pages/salir.php">
                <?= csrfCampo() ?>
                <button type="submit" class="cuenta-btn cuenta-btn--secundario">Cerrar sesión</button>
            </form>
        </div>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
