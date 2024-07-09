<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../Modelo/modelo.php';

    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $modelo = new Modelo();

    $usuario = $modelo->verificarCredenciales($correo, $contrasena);

    if ($usuario) {
        session_start();
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['rol'] = $usuario['rol'];

        if ($_SESSION['rol'] == 'admin') {
            header('Location: ../Vista/usuarios/administracion/panel.php');
        } else {
            header('Location: ../Vista/usuarios/clientes/perfil.php');
        }
        exit();
    } else {
        echo "Correo o contraseña incorrectos. Por favor, intenta nuevamente.";
    }
}
