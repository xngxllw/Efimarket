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

    public function guardarNegocio($id_usuario, $nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $id_categoria, $horario, $logo)
    {
        return $this->modeloNegocios->guardarNegocio($id_usuario, $nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $id_categoria, $horario, $logo);
    }

    public function obtenerNegociosPorUsuario($id_usuario)
    {
        $sql = "SELECT id_negocio, nombre_negocio, descripcion, direccion, telefono, sitio_web, horario, logo FROM negocios WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($sql);

        // Verificar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

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

    public function obtenerNegociosPorCategoria($id_categoria)
    {
        $sql = "SELECT id_negocio, nombre_negocio, descripcion, direccion, telefono, sitio_web, horario, logo FROM negocios WHERE id_categoria = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        $result = $stmt->get_result();
        $negocios = [];
        while ($row = $result->fetch_assoc()) {
            $negocios[] = $row;
        }
        $stmt->close();
        return $negocios;
    }

    public function actualizarNegocio($id_negocio, $nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $logo, $horario)
    {
        return $this->modeloNegocios->actualizarNegocio($id_negocio, $nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $logo, $horario);
    }

    public function eliminarNegocio($id_negocio)
    {
        return $this->modeloNegocios->eliminarNegocio($id_negocio);
    }
    
    public function obtenerNegocioPorId($id_negocio)
    {
        return $this->modeloNegocios->obtenerNegocioPorId($id_negocio);
    }
    public function agregarProducto($id_negocio, $nombre_producto, $foto_producto) {
        $numeroDeProductos = $this->modeloNegocios->contarProductosPorNegocio($id_negocio);

        if ($numeroDeProductos >= 5) {
            return false; // No se puede agregar más productos
        }

        // Agregar el producto si el número es menor que 5
        return $this->modeloNegocios->agregarProducto($id_negocio, $nombre_producto, $foto_producto);
    }
    
    public function obtenerProductos() {
        $query = "SELECT p.id_producto, p.id_negocio, p.nombre_producto, p.foto_producto, n.nombre_negocio 
                  FROM productos p 
                  INNER JOIN negocios n ON p.id_negocio = n.id_negocio";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $productos = [];
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
            return $productos;
        } else {
            return [];
        }
    }

    // Función para obtener un producto por su ID
    public function obtenerProductoPorId($id_producto) {
        $query = "SELECT * FROM productos WHERE id_producto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // Función para actualizar un producto
    public function actualizarProducto($id_producto, $id_negocio, $nombre_producto, $foto_producto) {
        $query = "UPDATE productos SET id_negocio = ?, nombre_producto = ?, foto_producto = ? WHERE id_producto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("issi", $id_negocio, $nombre_producto, $foto_producto, $id_producto);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Función para eliminar un producto
    public function eliminarProducto($id_producto) {
        $query = "DELETE FROM productos WHERE id_producto = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_producto);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
}}
?>