<?php
// Controlador: registro.php

require_once '../Modelo/modelo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['tipo_usuario'];

    // Validar el rol
    if ($rol == 'administrador') {
        $rol_db = 'admin';
    } else {
        $rol_db = 'cliente';
    }

    // Insertar el usuario en la base de datos
    $modelo = new Modelo();
    $resultado = $modelo->registrarUsuario($nombre, $correo, $contrasena, $rol_db);

    if ($resultado) {
        // Redirigir según el rol
        if ($rol_db == 'admin') {
            header('Location: ../Vista/usuarios/administracion/panel.html');
        } else {
            header('Location: ../Vista/usuarios/clientes/perfil.html');
        }
    } else {
        echo "Error en el registro. Por favor, intenta nuevamente.";
    }
}
