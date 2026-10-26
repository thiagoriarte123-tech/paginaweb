<?php
// ============================================
// FUNCIONES DE PRODUCTOS
// ============================================
// Todo lo que lee o escribe productos en la base de datos pasa por acá.

require_once __DIR__ . '/db.php';

// Carpeta donde se guardan las fotos que se suben desde el panel
const CARPETA_FOTOS = 'images/productos/';

function obtenerProductos() {
    return db()->query('SELECT * FROM productos ORDER BY id')->fetchAll();
}

function obtenerProducto($id) {
    $consulta = db()->prepare('SELECT * FROM productos WHERE id = ?');
    $consulta->execute([$id]);
    return $consulta->fetch() ?: null;
}

function guardarProducto($datos, $id = null) {
    $valores = [
        $datos['nombre'], $datos['precio'], $datos['madera'],
        $datos['tabla'], $datos['descripcion'], $datos['imagen'],
    ];

    if ($id === null) {
        $sql = 'INSERT INTO productos (nombre, precio, madera, tabla, descripcion, imagen) VALUES (?, ?, ?, ?, ?, ?)';
    } else {
        $sql = 'UPDATE productos SET nombre = ?, precio = ?, madera = ?, tabla = ?, descripcion = ?, imagen = ? WHERE id = ?';
        $valores[] = $id;
    }

    db()->prepare($sql)->execute($valores);
    return $id ?? (int) db()->lastInsertId();
}

function borrarProducto($id) {
    $producto = obtenerProducto($id);
    if (!$producto) {
        return;
    }
    db()->prepare('DELETE FROM productos WHERE id = ?')->execute([$id]);
    borrarFotoSubida($producto['imagen']);
}

// Ruta de la imagen lista para usar en la página.
// Si el producto no tiene foto (o el archivo no existe), muestra el logo.
function imagenProducto($ruta, $base) {
    $raiz = dirname(__DIR__) . '/';
    if ($ruta === '' || !is_file($raiz . $ruta)) {
        $ruta = 'images/logo.webp';
    }
    return $base . $ruta;
}

// Borra una foto solo si la subimos nosotros desde el panel
// (las fotos originales de la carpeta images/ no se tocan).
function borrarFotoSubida($ruta) {
    if (strpos($ruta, CARPETA_FOTOS) === 0) {
        $archivo = dirname(__DIR__) . '/' . $ruta;
        if (is_file($archivo)) {
            unlink($archivo);
        }
    }
}

// Recibe la foto del formulario, la revisa y la guarda.
// Devuelve [ruta, error]. Si no se eligió ninguna foto, devuelve [null, null].
function subirFoto($archivo) {
    if (!isset($archivo) || $archivo['error'] === UPLOAD_ERR_NO_FILE) {
        return [null, null];
    }
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return [null, 'No se pudo subir la foto. Probá con un archivo más liviano.'];
    }
    if ($archivo['size'] > 5 * 1024 * 1024) {
        return [null, 'La foto no puede pesar más de 5 MB.'];
    }

    // Revisamos el contenido real del archivo, no solo su nombre
    $tiposPermitidos = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $tipo = (new finfo(FILEINFO_MIME_TYPE))->file($archivo['tmp_name']);
    if (!isset($tiposPermitidos[$tipo]) || !getimagesize($archivo['tmp_name'])) {
        return [null, 'La foto tiene que ser JPG, PNG o WEBP.'];
    }

    // Nombre aleatorio para que no se pisen fotos con el mismo nombre
    $nombre = bin2hex(random_bytes(8)) . '.' . $tiposPermitidos[$tipo];
    $carpeta = dirname(__DIR__) . '/' . CARPETA_FOTOS;
    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0755, true);
    }
    if (!move_uploaded_file($archivo['tmp_name'], $carpeta . $nombre)) {
        return [null, 'No se pudo guardar la foto en el servidor.'];
    }

    return [CARPETA_FOTOS . $nombre, null];
}
