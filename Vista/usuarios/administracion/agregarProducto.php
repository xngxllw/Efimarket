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
    // Recibir los datos del formulario
    $id_negocio = $_POST['nombre_negocio'];
    $nombre_producto = $_POST['nombre_producto'];
    $precio = $_POST['precio'];
    $foto_producto = $_FILES['foto_producto'];
    $id_usuario = $_SESSION['id_usuario']; // Tomamos el id_usuario de la sesión

    // Verificar el plan del usuario
    $plan_usuario = $controladorNegocios->obtenerPlanUsuario($id_usuario); // Obtener el plan del usuario
    // Definir límites de productos por plan
    switch ($plan_usuario) {
        case 1: // Básico
            $limite_productos = 5;
            break;
        case 2: // Premium
            $limite_productos = 15;
            break;
        case 3: // Ultimate
            $limite_productos = 25;
            break;
        default:
            $_SESSION['error'] = "Plan no válido.";
            header("Location: productos.php");
            exit();
    }

    // Contar productos existentes en el negocio
    $productos_count = $controladorNegocios->contarProductosPorNegocio($id_negocio); // Debes implementar este método

    // Verificar si se alcanza el límite de productos
    if ($productos_count >= $limite_productos) {
        if ($plan_usuario == 3) { // Ultimate
            $_SESSION['error'] = "Límite de productos alcanzado. No puede agregar más productos.";
            header("Location: productos.php");
            exit();
        } else {
            header("Location: planes.php"); // Redirigir a planes.php
            exit();
        }
    }

    // Verificar que se subió la foto correctamente
    if ($foto_producto['error'] === UPLOAD_ERR_OK) {
        // Definir la ruta donde se guardará la imagen
        $nombreArchivo = basename($foto_producto['name']);
        $rutaDestino = "../../../uploads/productos/" . $nombreArchivo;

        // Mover el archivo subido a la ruta destino
        if (move_uploaded_file($foto_producto['tmp_name'], $rutaDestino)) {
            // Llamar al método del controlador para agregar el producto
            $productoAgregado = $controladorNegocios->agregarProducto($id_negocio, $nombre_producto, $nombreArchivo, $precio, $id_usuario);

            if ($productoAgregado) {
                // Redirigir a la página de productos con un mensaje de éxito
                $_SESSION['mensaje'] = "Producto agregado exitosamente.";
                header("Location: productos.php");
                exit();
            } else {
                // Mostrar un mensaje de error si no se pudo agregar el producto
                $_SESSION['error'] = "Error al agregar el producto. Intente nuevamente.";
                header("Location: productos.php");
                exit();
            }
        } else {
            // Mostrar un mensaje de error si no se pudo mover el archivo
            $_SESSION['error'] = "Error al subir la imagen del producto.";
            header("Location: productos.php");
            exit();
        }
    } else {
        // Mostrar un mensaje de error si no se subió ninguna imagen
        $_SESSION['error'] = "Debe seleccionar una imagen para el producto.";
        header("Location: productos.php");
        exit();
    }
} else {
    // Redirigir si se accede al script directamente
    header("Location: productos.php");
    exit();
}
