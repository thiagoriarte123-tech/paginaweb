<?php
$titulo  = 'Lijado paso a paso: cómo lograr una superficie suave y pareja - Tablas El Cóndor';
$base    = '../../';
$estilos = ['blog.css'];
$scripts = ['blog.js'];
$actual  = 'pages/blog.php';
require __DIR__ . '/../../includes/header.php';
?>
    <main class="blog">

        <nav class="blog-migas" aria-label="Ruta de navegación">
            <a href="../../index.php">Inicio</a>
            <span>.</span>
            <a href="../blog.php">Blog</a>
            <span>.</span>
            <span>Lijado paso a paso: cómo lograr una superficie suave y pareja</span>
        </nav>

        <article class="nota nota--pagina">
                <header class="nota__cabecera">
                    <h2>Lijado paso a paso: cómo lograr una superficie suave y pareja</h2>
                    <p class="nota__fecha">Publicado el 15/08/2026</p>
                </header>
                <img class="nota__img" src="../../images/IMG-20260521-WA0013.webp" alt="Detalle de una tabla de madera lijada">

                <p>Un buen lijado se siente antes de verse. La clave es no saltear granos y respetar siempre la dirección de la veta.</p>

                <h3>El orden correcto</h3>
                <ol class="nota__pasos">
                    <li>Empezá con grano 80 para emparejar la superficie y borrar marcas de la herramienta.</li>
                    <li>Pasá a grano 120 para quitar las rayas del paso anterior.</li>
                    <li>Terminá con grano 220 hasta que la madera quede suave al tacto.</li>
                    <li>Sacá el polvo con un paño apenas húmedo antes de aceitar.</li>
                </ol>

                <aside class="nota__tip">
                    <strong>Tip del carpintero</strong>
                    <p>Pasá un trapo mojado por la madera antes del último lijado. Se levanta la fibra, y al lijarla de nuevo el acabado queda mucho más fino y dura más.</p>
                </aside>

                
                <section class="nota__otras" aria-label="Seguir leyendo">
                    <h3>Seguir leyendo</h3>
                    <ul>
                    <li><a href="tip-aceite.php">Cómo curar tu tabla de madera con aceite antes del primer uso</a></li>
                    <li><a href="tip-maderas.php">Algarrobo, eucalipto o guayubira: qué madera elegir según el uso</a></li>
                    <li><a href="tip-cuidado.php">5 errores que arruinan una tabla de madera (y cómo evitarlos)</a></li>
                    </ul>
                </section>

                <a class="nota__volver" href="../blog.php">Volver al blog</a>
            </article>

    </main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
