<?php
$titulo  = 'Tablas El Cóndor - Blog';
$base    = '../';
$estilos = ['blog.css'];
$scripts = ['blog.js'];
$actual  = 'pages/blog.php';
require __DIR__ . '/../includes/header.php';
?>
    <main class="blog">

        <!-- CABECERA DEL BLOG -->
        <section class="blog-cabecera">
            <nav class="blog-migas" aria-label="Ruta de navegación">
                <a href="../index.php">Inicio</a>
                <span>›</span>
                <span>Blog</span>
            </nav>
            <h1>Tips del carpintero</h1>
            <p class="blog-intro">
                Lo que aprendemos trabajando la madera todos los días en Tucumán:
                cómo cuidarla, elegirla y trabajarla para que tus tablas duren toda la vida.
            </p>
        </section>

        <!-- LISTADO DE NOTAS -->
        <section class="blog-grid" aria-label="Notas del blog">

            <article class="blog-card">
                <a class="blog-card__img" href="tips/tip-aceite.php">
                    <img src="../images/catcoc.webp" alt="Tabla de cocina de madera maciza" loading="lazy">
                </a>
                <h2><a href="tips/tip-aceite.php">Cómo curar tu tabla de madera con aceite antes del primer uso</a></h2>
                <p class="blog-card__fecha">Publicado el 12/09/2026</p>
                <p class="blog-card__resumen">Un buen curado la protege de manchas y grietas. Te explicamos qué aceite usar y cada cuánto repetirlo.</p>
                <a class="blog-card__leer" href="tips/tip-aceite.php">Leer más</a>
            </article>

            <article class="blog-card">
                <a class="blog-card__img" href="tips/tip-maderas.php">
                    <img src="../images/catasado.webp" alt="Tablas de asado de distintas maderas" loading="lazy">
                </a>
                <h2><a href="tips/tip-maderas.php">Algarrobo, eucalipto o guayubira: qué madera elegir según el uso</a></h2>
                <p class="blog-card__fecha">Publicado el 28/08/2026</p>
                <p class="blog-card__resumen">Cada madera tiene su carácter. Conocé las diferencias para elegir la que mejor acompaña tu cocina.</p>
                <a class="blog-card__leer" href="tips/tip-maderas.php">Leer más</a>
            </article>

            <article class="blog-card">
                <a class="blog-card__img" href="tips/tip-lijado.php">
                    <img src="../images/IMG-20260521-WA0013.webp" alt="Detalle de una tabla de madera lijada" loading="lazy">
                </a>
                <h2><a href="tips/tip-lijado.php">Lijado paso a paso: cómo lograr una superficie suave y pareja</a></h2>
                <p class="blog-card__fecha">Publicado el 15/08/2026</p>
                <p class="blog-card__resumen">La diferencia entre una tabla común y una de taller está en el lijado. Los granos y el orden correcto.</p>
                <a class="blog-card__leer" href="tips/tip-lijado.php">Leer más</a>
            </article>

            <article class="blog-card">
                <a class="blog-card__img" href="tips/tip-cuidado.php">
                    <img src="../images/catpicada.webp" alt="Tabla de picada lista para servir" loading="lazy">
                </a>
                <h2><a href="tips/tip-cuidado.php">5 errores que arruinan una tabla de madera (y cómo evitarlos)</a></h2>
                <p class="blog-card__fecha">Publicado el 02/08/2026</p>
                <p class="blog-card__resumen">Lavavajillas, remojo, sol directo: los hábitos que más rápido deforman la madera.</p>
                <a class="blog-card__leer" href="tips/tip-cuidado.php">Leer más</a>
            </article>

        </section>

    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
