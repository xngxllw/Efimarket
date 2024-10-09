<?php
// modelo.php

class Modelo
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli('localhost', 'root', '', 'efimarket');

        // Verificar si hay un error en la conexión
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }


    // Función para registrar un nuevo usuario
    public function registrarUsuario($nombre, $correo, $contrasena, $rol)
    {
        // Preparar la consulta para insertar un nuevo usuario
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, correo, contrasena, rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $correo, $contrasena, $rol);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return $this->conn->insert_id; // Devolver el ID del nuevo usuario
        } else {
            return false; // Error al registrar
        }
    }

    // Función para verificar las credenciales del usuario al iniciar sesión
    public function verificarCredenciales($correo, $contrasena)
    {
        // Preparar la consulta para obtener usuario por correo y contraseña
        $stmt = $this->conn->prepare("SELECT id_usuario, correo, rol FROM usuarios WHERE correo = ? AND contrasena = ?");
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

    // Función para obtener los datos de un usuario por su ID
    public function obtenerUsuarioPorId($id_usuario)
    {
        $stmt = $this->conn->prepare("SELECT nombre, correo, rol FROM usuarios WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->bind_result($nombre, $correo, $rol);
        $stmt->fetch();
        $stmt->close();

        if ($nombre) {
            return ['nombre' => $nombre, 'correo' => $correo, 'rol' => $rol];
        } else {
            return null;
        }
    }

    // Función para obtener los negocios por categoría
    public function obtenerNegociosPorCategoria($id_categoria)
    {
        $stmt = $this->conn->prepare("SELECT * FROM negocios WHERE id_categoria = ?");
        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        $result = $stmt->get_result();
        $negocios = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $negocios;
    }
    public function obtenerNegociosPorUsuario($id_usuario)
    {
        $stmt = $this->conn->prepare("SELECT id_negocio, nombre_negocio FROM negocios WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function crearVacante($id_negocio, $ocupacion, $descripcion, $requisitos, $horario, $salario)
    {
        $stmt = $this->conn->prepare("INSERT INTO vacantes (id_negocio, ocupacion, descripcion, requisitos, horario, salario) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $id_negocio, $ocupacion, $descripcion, $requisitos, $horario, $salario);
        return $stmt->execute();
    }

    public function obtenerVacantesPorNegocio($id_usuario)
    {
        $stmt = $this->conn->prepare("
        SELECT v.id_vacante, v.ocupacion, v.descripcion, v.requisitos, v.horario, v.salario, v.fecha, n.nombre_negocio
        FROM vacantes v
        JOIN negocios n ON v.id_negocio = n.id_negocio
        WHERE n.id_usuario = ?
    ");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $vacantes = [];
        while ($row = $result->fetch_assoc()) {
            $vacantes[] = $row;
        }
        $stmt->close();
        return $vacantes;
    }




    public function guardarContacto($email, $mensaje)
    {
        $stmt = $this->conn->prepare("INSERT INTO Contacto (email, mensaje) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $mensaje);

        return $stmt->execute(); // Devuelve true si la inserción fue exitosa, false si hubo un error
    }

    public function __destruct()
    {
        $this->conn->close();
    }
    public function agregarPostulacion($id_negocio, $nombres, $apellidos, $edad, $tipo_documento, $documento_identidad, $celular, $correo_electronico, $acepta_terminos)
    {
        $sql = "INSERT INTO postulaciones (id_negocio, nombres, apellidos, edad, tipo_documento, documento_identidad, celular, correo_electronico, acepta_terminos)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ississssi", $id_negocio, $nombres, $apellidos, $edad, $tipo_documento, $documento_identidad, $celular, $correo_electronico, $acepta_terminos);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
