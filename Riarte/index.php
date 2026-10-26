<?php
$titulo  = 'Tablas El Cóndor - Inicio';
$base    = '';
$estilos = ['index.css'];
$scripts = [];
$actual  = 'index.php';
require __DIR__ . '/includes/header.php';
?>
    <main>
         <section class="hero">
            <div class="hero-overlay"></div>
            <div class="hero-content">
              <h1>Tablas el condor</h1>
                <p>DISEÑOS UNICOS PARA MOMENTOS MEMORABLES</p> 
                <a href="pages/productos.php" class="btn">Ver catalogo</a>
            </div>

        </section>

        <section class="coleccion">
            <div class="contenedor">
                <div class="coleccion-header">
                    <div>
                        <span class="subtitulo">Obra Artesanal</span>
                        <h2>PRODUCTOS DESTACADOS</h2>
                    </div>
                    <a href="pages/productos.php" class="explorar">Explorar todo</a>
                </div>

                <div class="grid-productos">
                    <a class="producto-link" href="pages/productos.php?tabla=asado">
                        <article class="producto">
                            <img src="images/catasado.webp" alt="Tablas de asado">
                            <h3>Tablas de Asado</h3>
                        </article>
                    </a>

                    <a class="producto-link" href="pages/productos.php?tabla=cocina">
                        <article class="producto">
                            <img src="images/catcoc.webp" alt="Tablas de cocina">
                            <h3>Tablas de Cocina</h3>
                        </article>
                    </a>

                    <a class="producto-link" href="pages/productos.php?tabla=picada">
                        <article class="producto">
                            <img src="images/catpicada.webp" alt="Tablas de picada">
                            <h3>Tablas de Picada</h3>
                        </article>
                    </a>
                </div>
            </div>
        </section>

    </main>

<?php require __DIR__ . '/includes/footer.php'; ?>
