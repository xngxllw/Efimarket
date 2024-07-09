<?php
include_once(__DIR__ . '/../Modelo/modeloNegocios.php');
class ControladorNegocios
{
    private $modeloNegocios;
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

        $this->modeloNegocios = new ModeloNegocios($this->conn);
    }

    public function guardarNegocio($nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $id_categoria, $id_usuario)
    {
        return $this->modeloNegocios->guardarNegocio($nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $id_categoria, $id_usuario);
    }

    public function obtenerNegociosPorUsuario($id_usuario)
    {
        $sql = "SELECT nombre_negocio, descripcion, direccion, telefono, sitio_web FROM negocios WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $negocios = [];
        while ($row = $result->fetch_assoc()) {
            $negocios[] = $row;
        }
        $stmt->close();
        return $negocios;
    }
}
