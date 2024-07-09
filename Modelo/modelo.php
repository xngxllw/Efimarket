<?php
// modelo.php

class Modelo
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new mysqli('localhost', 'root', '', 'efimarket');
        if ($this->conexion->connect_error) {
            die("Conexión fallida: " . $this->conexion->connect_error);
        }
    }

    // Función para registrar un nuevo usuario
    public function registrarUsuario($nombre, $correo, $contrasena, $rol)
    {
        // Preparar la consulta para insertar un nuevo usuario
        $stmt = $this->conexion->prepare("INSERT INTO usuarios (nombre, correo, contrasena, rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $correo, $contrasena, $rol);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true; // Registro exitoso
        } else {
            return false; // Error al registrar
        }
    }


    // Función para verificar las credenciales del usuario al iniciar sesión
    public function verificarCredenciales($correo, $contrasena)
    {
        // Preparar la consulta para obtener usuario por correo y contraseña
        $stmt = $this->conexion->prepare("SELECT id_usuario, correo, rol FROM usuarios WHERE correo = ? AND contrasena = ?");
        $stmt->bind_param("ss", $correo, $contrasena);
        $stmt->execute();
        $stmt->bind_result($idUsuario, $dbCorreo, $rol);
        $stmt->fetch();
        $stmt->close();

        // Verificar si se encontró un usuario
        if ($idUsuario) {
            return ['id_usuario' => $idUsuario, 'correo' => $dbCorreo, 'rol' => $rol];
        } else {
            return null;
        }
    }

    public function __destruct()
    {
        $this->conexion->close();
    }
}
