<?php
class ModeloNegocios
{
    private $conn;

    public function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "efimarket";

        // Crear la conexión
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    public function guardarNegocio($id_usuario, $nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $id_categoria)
    {
        $sql = "INSERT INTO negocios (id_usuario, nombre_negocio, descripcion, direccion, telefono, sitio_web, id_categoria)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        // Asociar los parámetros
        $stmt->bind_param("isssssi", $id_usuario, $nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $id_categoria);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Nuevo negocio registrado exitosamente";
            header('Location: negocios.php'); // Redirigir a la lista de negocios
            exit();
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }

        $stmt->close();
        $this->conn->close();
    }
}
