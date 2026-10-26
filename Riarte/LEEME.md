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

## Primera vez: instalar la base de datos

1. En el panel de XAMPP, dale **Start** a **Apache** y también a **MySQL**.
2. Entrá a `http://localhost/Riarte/instalar.php`.
3. Completá tu nombre, correo y una contraseña. Ese va a ser tu usuario **administrador**.
4. Tocá **Instalar**. Se crea la base `tablas_condor`, se cargan las 10 tablas que tenías y tu usuario.
5. **Borrá el archivo `instalar.php`** de la carpeta. Ya no se necesita y es mejor que nadie más lo vea.

Para ver la base por dentro: `http://localhost/phpmyadmin`.

## Panel de administración

Entrá a **Ingresar** (arriba a la derecha) con tu usuario administrador y vas a ir al panel, donde podés:

- **Agregar** una tabla nueva con su foto.
- **Editar** nombre, precio, madera, tipo, descripción o foto.
- **Borrar** una tabla.

Los cambios aparecen en la página de Productos al instante, sin tocar código.
Las fotos que subís se guardan en `images/productos/`.

## Cuentas de clientes

Los clientes pueden **crear su cuenta** desde Ingresar → "Creá una acá". Desde **Mi cuenta** pueden cambiar su nombre y su contraseña, y cerrar sesión. Las contraseñas se guardan encriptadas: ni vos podés verlas.

## Cómo está organizada

```
Riarte/
├── includes/
│   ├── config.php     ← datos del negocio, datos de la base, maderas y tipos, menú
│   ├── db.php         ← conexión a MySQL
│   ├── auth.php       ← sesiones, login y protección de formularios
│   ├── productos.php  ← leer, guardar y borrar productos; subir fotos
│   ├── header.php     ← <head>, logo, menú, Ingresar/Mi cuenta, carrito y promos
│   └── footer.php     ← pie de página y scripts
├── admin/             ← panel (solo administradores)
│   ├── index.php      ← lista de tablas
│   ├── producto.php   ← agregar / editar
│   └── borrar.php
├── instalar.php       ← se usa una vez y se borra
├── index.php
└── pages/
    ├── productos.php, blog.php, contacto.php, carrito.php, checkout.php
    ├── login.php, registro.php, cuenta.php, salir.php
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

## Para agregar una madera o un tipo de tabla nuevo

Sumalo en `$maderas` o `$tiposTabla` dentro de `includes/config.php`. Aparece solo en los filtros de la tienda y en el panel.

## Cuando lo subas a un hosting

El hosting te da cuatro datos de MySQL (servidor, nombre de la base, usuario y contraseña). Ponelos en `$db_config` dentro de `includes/config.php` y ejecutá `instalar.php` una vez allá.
