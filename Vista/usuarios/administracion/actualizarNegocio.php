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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_negocio = $_POST['id_negocio'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $sitio_web = $_POST['sitio_web'];
    $horario = $_POST['horario'];

    // Manejar la subida del logo
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $logo = $_FILES['logo'];
        $logo_nombre = $logo['name'];
        $logo_tmp = $logo['tmp_name'];
        $logo_ruta = "../../../uploads/logos/$logo_nombre";

        // Mover el archivo a la ruta deseada
        if (move_uploaded_file($logo_tmp, $logo_ruta)) {
            // Actualizar el negocio con el nuevo logo
            $controladorNegocios->actualizarNegocio($id_negocio, $nombre, $descripcion, $direccion, $telefono, $sitio_web, $logo_nombre, $horario);
        }
    } else {
        // Actualizar el negocio sin cambiar el logo
        $controladorNegocios->actualizarNegocio($id_negocio, $nombre, $descripcion, $direccion, $telefono, $sitio_web, null, $horario);
    }

    // Redirigir a la página de negocios
    header("Location: negocios.php");
    exit();
}
?>
