<?php
$titulo  = '5 errores que arruinan una tabla de madera (y cómo evitarlos) - Tablas El Cóndor';
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
            <span>5 errores que arruinan una tabla de madera (y cómo evitarlos)</span>
        </nav>

        <article class="nota nota--pagina">
                <header class="nota__cabecera">
                    <h2>5 errores que arruinan una tabla de madera (y cómo evitarlos)</h2>
                    <p class="nota__fecha">Publicado el 02/08/2026</p>
                </header>
                <img class="nota__img" src="../../images/catpicada.webp" alt="Tabla de picada lista para servir">

                <p>Una tabla bien cuidada te acompaña décadas. Casi todos los problemas vienen de los mismos cinco hábitos.</p>

                <h3>Lo que conviene evitar</h3>
                <ul class="nota__lista">
                    <li><strong>Usar el lavavajillas:</strong> el calor y la humedad prolongada la deforman y la parten.</li>
                    <li><strong>Dejarla en remojo:</strong> lavala rápido con agua tibia y detergente suave.</li>
                    <li><strong>Secarla acostada:</strong> apoyala de canto para que se seque por todos lados.</li>
                    <li><strong>Ponerla al sol o cerca de la hornalla:</strong> el calor directo la seca y le abre grietas.</li>
                    <li><strong>Olvidarse del aceite:</strong> una madera seca absorbe manchas y se astilla.</li>
                </ul>

                <aside class="nota__tip">
                    <strong>Tip del carpintero</strong>
                    <p>Para sacar olores, frotá la tabla con medio limón y sal gruesa, enjuagá y secá enseguida. Después, una pasada de aceite.</p>
                </aside>

                
                <section class="nota__otras" aria-label="Seguir leyendo">
                    <h3>Seguir leyendo</h3>
                    <ul>
                    <li><a href="tip-aceite.php">Cómo curar tu tabla de madera con aceite antes del primer uso</a></li>
                    <li><a href="tip-maderas.php">Algarrobo, eucalipto o guayubira: qué madera elegir según el uso</a></li>
                    <li><a href="tip-lijado.php">Lijado paso a paso: cómo lograr una superficie suave y pareja</a></li>
                    </ul>
                </section>

                <a class="nota__volver" href="../blog.php">Volver al blog</a>
            </article>

    </main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
