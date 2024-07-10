<?php
class ModeloNegocios
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function guardarNegocio($id_usuario, $nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $id_categoria, $logo, $horario)
    {
        $sql = "INSERT INTO negocios (id_usuario, nombre_negocio, descripcion, direccion, telefono, sitio_web, id_categoria, logo, horario)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        // Asociar los parámetros
        $stmt->bind_param("isssssiss", $id_usuario, $nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $id_categoria, $logo, $horario);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $stmt->close(); // Cerrar la declaración preparada
            return "Nuevo negocio registrado exitosamente";
        } else {
            $error = "Error al ejecutar la consulta: " . $stmt->error;
            $stmt->close(); // Cerrar la declaración preparada
            return $error;
        }
    }
}
