<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../../../index.php");
    exit();
}

// Incluir los archivos necesarios
require_once '../../../Controlador/controladorNegocios.php';
require_once '../../../Modelo/modeloNegocios.php';

// Crear una instancia del controlador de negocios
$controladorNegocios = new ControladorNegocios();

// Obtener el ID del negocio a eliminar
$id_negocio = isset($_POST['id_negocio']) ? intval($_POST['id_negocio']) : 0;

// Verificar si el ID del negocio es válido
if ($id_negocio > 0) {
    // Eliminar el negocio
    $resultado = $controladorNegocios->eliminarNegocio($id_negocio);

    if ($resultado) {
        // Redirigir de nuevo a la página de negocios con un mensaje de éxito
        header("Location: misNegocios.php?mensaje=negocio_eliminado");
    } else {
        // Redirigir de nuevo a la página de negocios con un mensaje de error
        header("Location: misNegocios.php?mensaje=error_eliminar");
    }
} else {
    // Redirigir de nuevo a la página de negocios con un mensaje de error
    header("Location: misNegocios.php?mensaje=id_invalido");
}
exit();
