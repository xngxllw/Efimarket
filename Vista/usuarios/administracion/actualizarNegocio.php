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

    // Inicializar la variable del logo
    $logo_nombre = null;

    // Manejar la subida del logo si se seleccionó uno nuevo
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $logo = $_FILES['logo'];
        $logo_nombre = $logo['name'];
        $logo_tmp = $logo['tmp_name'];
        $logo_ruta = "../../../uploads/logos/$logo_nombre";

        // Mover el archivo a la ruta deseada
        if (move_uploaded_file($logo_tmp, $logo_ruta)) {
            // El logo se ha subido correctamente
        } else {
            die("Error al subir el archivo de logo.");
        }
    }

    // Actualizar el negocio con o sin un nuevo logo
    $controladorNegocios->actualizarNegocio($id_negocio, $nombre, $descripcion, $direccion, $telefono, $sitio_web, $horario, $logo_nombre);

    // Redirigir a la página de negocios
    header("Location: negocios.php");
    exit();
}
