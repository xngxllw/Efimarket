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

    // Verificar el plan del usuario
    $controlador = new ControladorNegocios();
    $plan_usuario = $controlador->obtenerPlanUsuario($id_usuario); // Obtener el plan del usuario

    // Comprobar si el plan se obtuvo correctamente
    if ($plan_usuario === null) {
        echo "El plan del usuario no está definido o no se pudo encontrar.";
        exit;
    }

    // Obtener el conteo de negocios del usuario
    $negocios_count = $controlador->contarNegociosPorUsuario($id_usuario);

    // Definir límites por plan
    switch ($plan_usuario) {
        case '1':
            $limite_negocios = 3;
            break;
        case '2':
            $limite_negocios = 7;
            break;
        case '3':
            $limite_negocios = 10;
            break;
        default:
            echo "Plan no válido.";
            exit;
    }

    // Verificar si se alcanza el límite de negocios
    if ($plan_usuario == '3' && $negocios_count >= $limite_negocios) {
        echo "Límite de negocios alcanzado. No puede registrar más negocios.";
        exit; // Detener la ejecución
    } elseif ($negocios_count >= $limite_negocios) {
        header('Location: planes.php'); // Redirigir a planes.php
        exit;
    }

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
