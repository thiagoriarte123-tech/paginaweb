<?php
$titulo  = 'Cómo curar tu tabla de madera con aceite antes del primer uso - Tablas El Cóndor';
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
            <span>Cómo curar tu tabla de madera con aceite antes del primer uso</span>
        </nav>

        <article class="nota nota--pagina">
                <header class="nota__cabecera">
                    <h2>Cómo curar tu tabla de madera con aceite antes del primer uso</h2>
                    <p class="nota__fecha">Publicado el 12/09/2026</p>
                </header>
                <img class="nota__img" src="../../images/catcoc.webp" alt="Tabla de cocina de madera maciza">

                <p>La madera sin tratar es como una esponja: absorbe jugos, grasa y olores. El curado con aceite mineral de grado alimenticio llena esos poros y la deja lista para trabajar. Es el paso que más alarga la vida de una tabla.</p>

                <h3>Cómo hacerlo</h3>
                <ol class="nota__pasos">
                    <li>Limpiá la tabla con un paño seco para sacar el polvo.</li>
                    <li>Volcá una cucharada de aceite mineral y esparcilo en todas las caras y los bordes.</li>
                    <li>Dejala reposar entre 4 y 6 horas, o toda la noche.</li>
                    <li>Retirá el excedente con un trapo limpio y seco.</li>
                </ol>

                <aside class="nota__tip">
                    <strong>Tip del carpintero</strong>
                    <p>Evitá el aceite de oliva o de girasol: se ponen rancios con el tiempo y dejan mal olor. Repetí el curado una vez al mes los primeros meses, y después cuando notes la madera opaca o seca.</p>
                </aside>

                
                <section class="nota__otras" aria-label="Seguir leyendo">
                    <h3>Seguir leyendo</h3>
                    <ul>
                    <li><a href="tip-maderas.php">Algarrobo, eucalipto o guayubira: qué madera elegir según el uso</a></li>
                    <li><a href="tip-lijado.php">Lijado paso a paso: cómo lograr una superficie suave y pareja</a></li>
                    <li><a href="tip-cuidado.php">5 errores que arruinan una tabla de madera (y cómo evitarlos)</a></li>
                    </ul>
                </section>

                <a class="nota__volver" href="../blog.php">Volver al blog</a>
            </article>

    </main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
