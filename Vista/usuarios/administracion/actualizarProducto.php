<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
    exit();
}

// Incluir los archivos necesarios
require_once '../../../Controlador/controladorNegocios.php';
require_once '../../../Modelo/modeloNegocios.php';

// Crear una instancia del controlador de negocios
$controladorNegocios = new ControladorNegocios();

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $id_producto = $_POST['id_producto'];
    $id_negocio = $_POST['id_negocio'];
    $nombre_producto = $_POST['nombre_producto'];
    $foto_producto = $_FILES['foto_producto'];

    // Obtener el nombre del archivo antiguo
    $producto_actual = $controladorNegocios->obtenerProductoPorId($id_producto);
    $nombre_archivo_antiguo = $producto_actual['foto_producto'];

    // Verificar si se subió una nueva foto
    if ($foto_producto['error'] === UPLOAD_ERR_OK) {
        // Definir la ruta donde se guardará la nueva imagen
        $nombreArchivo = basename($foto_producto['name']);
        $rutaDestino = "../../../uploads/productos/" . $nombreArchivo;

        // Mover el archivo subido a la ruta destino
        if (move_uploaded_file($foto_producto['tmp_name'], $rutaDestino)) {
            // Actualizar producto con nueva foto
            $controladorNegocios->actualizarProducto($id_producto, $id_negocio, $nombre_producto, $nombreArchivo);
            // Eliminar el archivo antiguo si se subió uno nuevo
            if (file_exists("../../../uploads/productos/" . $nombre_archivo_antiguo)) {
                unlink("../../../uploads/productos/" . $nombre_archivo_antiguo);
            }
        } else {
            $_SESSION['error'] = "Error al subir la imagen del producto.";
            header("Location: productos.php");
            exit();
        }
    } else {
        // Actualizar producto sin cambiar la foto
        $controladorNegocios->actualizarProducto($id_producto, $id_negocio, $nombre_producto, $nombre_archivo_antiguo);
    }

    // Redirigir a la página de productos con un mensaje de éxito
    $_SESSION['mensaje'] = "Producto actualizado exitosamente.";
    header("Location: productos.php");
    exit();
} else {
    // Redirigir si se accede al script directamente
    header("Location: productos.php");
    exit();
}
?>
