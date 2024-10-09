<?php
require_once '../Modelo/modelo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['tipo_usuario'];

    $rol_db = ($rol == 'administrador') ? 'admin' : 'cliente';

    $modelo = new Modelo();
    $id_usuario = $modelo->registrarUsuario($nombre, $correo, $contrasena, $rol_db);

    if ($id_usuario) {
        session_start();
        session_unset(); // Destruir cualquier sesión existente
        session_regenerate_id(true); // Regenerar ID de sesión por seguridad
        $_SESSION['id_usuario'] = $id_usuario;
        $_SESSION['rol'] = $rol_db;

        if ($rol_db == 'admin') {
            header('Location: ../Vista/usuarios/administracion/panel.php');
        } else {
            header('Location: ../Vista/usuarios/clientes/perfil.php');
        }
    } else {
        echo "Error en el registro. Por favor, intenta nuevamente.";
    }
}
