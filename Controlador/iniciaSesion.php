<?php
// iniciaSesion.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../Modelo/modelo.php';

    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Instanciar el modelo
    $modelo = new Modelo();

    // Verificar las credenciales del usuario al iniciar sesión
    $usuario = $modelo->verificarCredenciales($correo, $contrasena);

    if ($usuario) {
        // Usuario autenticado correctamente
        session_start();

        $_SESSION['rol'] = $usuario['rol'];

        // Redirigir según el rol
        if ($_SESSION['rol'] == 'admin') {
            header('Location: ../Vista/usuarios/administracion/panel.html');
        } else {
            header('Location: ../Vista/usuarios/clientes/perfil.html');
        }
    } else {
        // Credenciales incorrectas
        echo "Correo o contraseña incorrectos. Por favor, intenta nuevamente.";
    }
}
