<?php
$titulo  = 'Tablas El Cóndor - Productos';
$base    = '../';
$estilos = ['productos.css'];
$scripts = ['productos.js'];
$actual  = 'pages/productos.php';
require __DIR__ . '/../includes/header.php';
?>
    <main>
        <div class="productos-layout">

            <!-- SIDEBAR DE FILTROS -->
            <aside class="filtros-sidebar">
                <h3 class="filtros-titulo">Filtros</h3>

                <!-- Precio -->
                <div class="filtro-grupo">
                    <h4 class="filtro-grupo__titulo">Precio</h4>
                    <div class="filtro-precio">
                        <span class="filtro-precio__signo">$</span>
                        <input type="number" id="precio-min" class="filtro-precio__input" placeholder="Mínimo" min="0" step="1">
                        <span>—</span>
                        <span class="filtro-precio__signo">$</span>
                        <input type="number" id="precio-max" class="filtro-precio__input" placeholder="Máximo" min="0" step="1">
                    </div>
                </div>

                <!-- Tipo de madera -->
                <div class="filtro-grupo">
                    <h4 class="filtro-grupo__titulo">Tipo de madera</h4>
                    <label><input type="radio" name="madera" value="roble"> Roble</label>
                    <label><input type="radio" name="madera" value="guayubira"> Guayubira</label>
                    <label><input type="radio" name="madera" value="eucalipto"> Eucalipto</label>
                </div>

                <!-- Tipo de tabla -->
                <div class="filtro-grupo">
                    <h4 class="filtro-grupo__titulo">Tipo de tabla</h4>
                    <label><input type="radio" name="tabla" value="asado"> Asado</label>
                    <label><input type="radio" name="tabla" value="cocina"> Cocina</label>
                    <label><input type="radio" name="tabla" value="picada"> Picada</label>
                    <label><input type="radio" name="tabla" value="plato"> Plato</label>
                </div>

                <!-- Botones -->
                <div class="filtro-botones">
                    <button class="btn-aplicar">Aplicar</button>
                    <button class="btn-reset">Restablecer</button>
                </div>

            </aside>

            <!-- GRILLA DE PRODUCTOS -->
            <div class="productos-grilla">
            </div>

        </div>
    </main>


    <!-- MODAL DE DETALLES DEL PRODUCTO -->
    <div id="producto-modal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div class="modal-body">
                <div class="modal-imagen">
                    <img id="modal-img" src="" alt="">
                </div>
                <div class="modal-info">
                    <h2 id="modal-titulo"></h2>
                    <p id="modal-precio" class="modal-precio"></p>
                    <p id="modal-descripcion" class="modal-descripcion"></p>
                    <div class="modal-detalles">
                        <p><strong>Madera:</strong> <span id="modal-madera"></span></p>
                        <p><strong>Tipo:</strong> <span id="modal-tipo"></span></p>
                    </div>
                    <button id="modal-agregar-carrito" class="btn-agregar-carrito">Agregar al Carrito</button>
                </div>
            </div>
        </div>
    </div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
