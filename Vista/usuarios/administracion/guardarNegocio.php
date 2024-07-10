<?php
session_start();
require_once '../../../Controlador/controladorNegocios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $nombre = $_POST['nombre_negocio'];
    $descripcion = $_POST['descripcion'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $sitio = $_POST['sitio'];
    $horario = $_POST['horario'];
    $categoria = $_POST['categoria'];
    $id_usuario = $_SESSION['id_usuario'];

    // Manejo de subida de imagen
    $target_dir = "../../../uploads/logos/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    $target_file = $target_dir . basename($_FILES["logo"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["logo"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            $logo = basename($_FILES["logo"]["name"]);
        } else {
            echo "Error subiendo el archivo.";
            exit;
        }
    } else {
        echo "El archivo no es una imagen.";
        exit;
    }

    // Instanciar el controlador y llamar a guardarNegocio
    $controlador = new ControladorNegocios();
    $resultado = $controlador->guardarNegocio($id_usuario, $nombre, $descripcion, $direccion, $telefono, $sitio, $categoria, $logo, $horario);

    // Manejar el resultado de la operación
    if ($resultado === "Nuevo negocio registrado exitosamente") {
        header('Location: negocios.php');
        exit();
    } else {
        echo $resultado; // Mostrar mensaje de error si ocurre algún problema
    }
} else {
    echo "Debe iniciar sesión para acceder a esta sección.";
}
