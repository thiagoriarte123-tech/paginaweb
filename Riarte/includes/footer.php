<?php
// ============================================
// PIE DE PÁGINA COMÚN — se incluye en todas las páginas
// ============================================
// Usa las variables que ya definió header.php ($base, $sitio, $menu).
// Opcional: $scripts → lista de JS propios de la página (se cargan antes de script.js)

$scripts = $scripts ?? [];
?>

    <footer>
        <p>&copy; <?= date('Y') ?> <?= e($sitio['nombre']) ?></p>

        <div class="footer-grid">
            <div class="footer-brand">
                <h4>Condorito</h4>
                <p><?= e($sitio['eslogan']) ?></p>
            </div>

            <div>
                <h5>Explorar</h5>
                <ul>
<?php foreach ($menu as $texto => $archivo): ?>
                    <li><a href="<?= $base . $archivo ?>"><?= $texto ?></a></li>
<?php endforeach; ?>
                </ul>
            </div>

            <div>
                <h5>Seguinos</h5>
                <ul>
                    <li><a href="<?= e($sitio['instagram']) ?>" target="_blank" rel="noopener"><img src="<?= $base ?>images/instagram.webp" alt="Instagram" class="instagram-logo"></a></li>
                    <li><a href="<?= e($sitio['facebook']) ?>" target="_blank" rel="noopener"><img src="<?= $base ?>images/facebook.webp" alt="Facebook" class="facebook-logo"></a></li>
                    <li><a href="https://wa.me/<?= e($sitio['whatsapp']) ?>" target="_blank" rel="noopener"><img src="<?= $base ?>images/whatsapp.webp" alt="WhatsApp" class="whatsapp-logo"></a></li>
                </ul>
            </div>
        </div>
    </footer>

<?php foreach ($scripts as $js): ?>
    <script src="<?= $base ?>js/<?= $js ?>"></script>
<?php endforeach; ?>
    <script src="<?= $base ?>js/script.js"></script>
</body>
</html>
