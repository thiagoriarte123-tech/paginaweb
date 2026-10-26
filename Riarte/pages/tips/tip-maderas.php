<?php
$titulo  = 'Algarrobo, eucalipto o guayubira: qué madera elegir según el uso - Tablas El Cóndor';
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
            <span>Algarrobo, eucalipto o guayubira: qué madera elegir según el uso</span>
        </nav>

        <article class="nota nota--pagina">
                <header class="nota__cabecera">
                    <h2>Algarrobo, eucalipto o guayubira: qué madera elegir según el uso</h2>
                    <p class="nota__fecha">Publicado el 28/08/2026</p>
                </header>
                <img class="nota__img" src="../../images/catasado.webp" alt="Tablas de asado de distintas maderas">

                <p>No hay una madera mejor que otra: hay una madera mejor para cada uso. Estas son las que más trabajamos en el taller.</p>

                <h3>Las tres maderas</h3>
                <ul class="nota__lista">
                    <li><strong>Algarrobo:</strong> dura, densa y de tono rojizo. Aguanta muy bien el corte y el paso del tiempo. Ideal para tablas de asado y de trabajo intenso.</li>
                    <li><strong>Eucalipto:</strong> clara, de veta marcada y más accesible. Muy versátil, perfecta para la cocina de todos los días.</li>
                    <li><strong>Guayubira:</strong> de color profundo y vetas elegantes. Muy buena para picadas y para regalar.</li>
                </ul>

                <aside class="nota__tip">
                    <strong>Tip del carpintero</strong>
                    <p>Si vas a cortar carne todos los fines de semana, elegí una madera dura y con canaleta para los jugos. Si la tabla es sobre todo para servir, la estética pesa más que la dureza.</p>
                </aside>

                
                <section class="nota__otras" aria-label="Seguir leyendo">
                    <h3>Seguir leyendo</h3>
                    <ul>
                    <li><a href="tip-aceite.php">Cómo curar tu tabla de madera con aceite antes del primer uso</a></li>
                    <li><a href="tip-lijado.php">Lijado paso a paso: cómo lograr una superficie suave y pareja</a></li>
                    <li><a href="tip-cuidado.php">5 errores que arruinan una tabla de madera (y cómo evitarlos)</a></li>
                    </ul>
                </section>

                <a class="nota__volver" href="../blog.php">Volver al blog</a>
            </article>

    </main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
