<?php
// Iniciar sesión (si no se ha iniciado)
session_start();
require_once '../../../Controlador/controladorNegocios.php';
require_once '../../../Modelo/modeloNegocios.php';

// Verificar si el ID de usuario está definido en la sesión
if (isset($_SESSION['id_usuario'])) {
    $nombre_negocio = $_POST['nombre_negocio'];
    $descripcion = $_POST['descripcion'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $sitio_web = $_POST['sitio'];
    $id_categoria = $_POST['categoria'];

    // Obtener el ID del usuario de la sesión activa
    $id_usuario = $_SESSION['id_usuario'];

    // Instanciar el controlador y guardar el negocio
    $controlador = new ControladorNegocios();
    $resultado = $controlador->guardarNegocio($id_usuario, $nombre_negocio, $descripcion, $direccion, $telefono, $sitio_web, $id_categoria);

    // Verificar si se guardó el negocio correctamente
    if ($resultado) {
        echo "Negocio guardado correctamente.";
    } else {
        echo "Error al guardar el negocio.";
    }
} else {
    // Manejar el caso en el que el ID del usuario no está definido en la sesión
    // Por ejemplo, redireccionar al usuario a la página de inicio de sesión
    echo "Error: sesión no iniciada.";
}
