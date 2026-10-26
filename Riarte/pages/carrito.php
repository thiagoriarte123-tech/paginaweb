<?php
$titulo  = 'Tablas El Cóndor - Carrito';
$base    = '../';
$estilos = ['carrito.css'];
$scripts = ['carrito.js'];
$actual  = '';
require __DIR__ . '/../includes/header.php';
?>
    <main>
        <section class="carrito-hero">
            <h2>Tu carrito</h2>
        </section>

        <div class="carrito-layout">

            <!-- LISTA DE PRODUCTOS -->
            <div class="carrito-items">
                <div class="carrito-vacio" id="carrito-vacio">
                    <p>Tu carrito está vacío.</p>
                    <a href="productos.php" class="btn-ver-productos">Ver productos</a>
                </div>

                <!-- Los productos se van a insertar acá con JS -->
                <div id="lista-productos"></div>
            </div>

            <!-- RESUMEN DE COMPRA -->
            <aside class="carrito-resumen">
                <h3 class="resumen-titulo">Resumen de compra</h3>

                <div class="resumen-fila">
                    <span>Producto</span>
                    <span id="resumen-subtotal">$0</span>
                </div>

                <div class="resumen-divisor"></div>

                <div class="resumen-fila resumen-total">
                    <span>Total</span>
                    <span id="resumen-total">$0</span>
                </div>

                <button class="btn-comprar" id="btn-finalizar">Finalizar compra</button>
            </aside>

        </div>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
