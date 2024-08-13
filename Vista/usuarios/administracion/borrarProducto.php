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

$controladorNegocios = new ControladorNegocios();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir el ID del producto a borrar
    $id_producto = $_POST['id_producto'];

    // Verificar que el ID del producto sea válido
    if (!isset($id_producto) || empty($id_producto)) {
        $_SESSION['error'] = "ID de producto inválido.";
        header("Location: productos.php");
        exit();
    }

    // Obtener la foto del producto para eliminarla del sistema de archivos
    $producto = $controladorNegocios->obtenerProductoPorId($id_producto);
    if ($producto) {
        $nombreArchivo = $producto['foto_producto'];
        $rutaArchivo = "../../../uploads/productos/" . $nombreArchivo;

        // Eliminar el producto de la base de datos
        $productoEliminado = $controladorNegocios->eliminarProducto($id_producto);

        if ($productoEliminado) {
            // Eliminar la foto del sistema de archivos
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }

            $_SESSION['mensaje'] = "Producto eliminado exitosamente.";
            header("Location: productos.php");
            exit();
        } else {
            $_SESSION['error'] = "Error al eliminar el producto. Intente nuevamente.";
            header("Location: productos.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Producto no encontrado.";
        header("Location: productos.php");
        exit();
    }
} else {
    // Redirigir si se accede al script directamente
    header("Location: productos.php");
    exit();
}
