# Tablas El Cóndor — versión PHP

## Cómo verla en tu compu

PHP necesita un servidor: **abrir el archivo con doble clic o con Live Server de VS Code no funciona** (vas a ver el código en vez de la página).

**Opción A — XAMPP**
1. Instalá XAMPP y abrí el panel. Dale **Start** a Apache.
2. Copiá la carpeta `Riarte` dentro de `C:\xampp\htdocs\`.
3. Entrá a `http://localhost/Riarte/` en el navegador.

**Opción B — con PHP instalado**
1. Abrí una terminal dentro de la carpeta `Riarte`.
2. Ejecutá `php -S localhost:8000`
3. Entrá a `http://localhost:8000/`

## Cómo está organizada

```
Riarte/
├── includes/
│   ├── config.php   ← datos del negocio (WhatsApp, mail, redes) y el menú
│   ├── header.php   ← <head>, logo, menú, carrito y barra de promos
│   └── footer.php   ← pie de página y scripts
├── index.php
└── pages/
    ├── productos.php, blog.php, contacto.php, carrito.php, checkout.php
    └── tips/ (las 4 notas del blog)
```

Cada página arranca con unas pocas variables y "incluye" las partes comunes:

```php
<?php
$titulo  = 'Tablas El Cóndor - Blog';   // texto de la pestaña
$base    = '../';                        // cuántas carpetas subir hasta la raíz
$estilos = ['blog.css'];                 // CSS propios de esta página
$scripts = ['blog.js'];                  // JS propios de esta página
$actual  = 'pages/blog.php';             // qué link del menú resaltar
require __DIR__ . '/../includes/header.php';
?>
    ...contenido de la página...
<?php require __DIR__ . '/../includes/footer.php'; ?>
```

`$base` es `''` en `index.php`, `'../'` en `pages/` y `'../../'` en `pages/tips/`.

## Para agregar una página nueva

Copiá cualquier página de la misma carpeta, cambiá las variables de arriba y el contenido del `<main>`. El menú, el pie y la barra de promos aparecen solos.

Para agregar un link al menú, sumalo al array `$menu` en `includes/config.php`.

## Formulario de contacto

`pages/contacto.php` valida los datos y manda un mail con la función `mail()` de PHP.

- Cambiá `email_contacto` en `includes/config.php` por el correo real.
- En tu compu (XAMPP) el mail no sale porque no hay servidor de correo configurado: vas a ver el aviso de error, es normal.
- En un hosting con PHP (Hostinger, DonWeb, Ferozo, etc.) `mail()` suele funcionar directo.
