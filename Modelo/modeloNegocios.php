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

    public function actualizarNegocio($id_negocio, $nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $logo, $horario)
    {
        $sql = "UPDATE negocios SET nombre_negocio = ?, descripcion = ?, direccion = ?, telefono = ?, sitio_web = ?, horario = ?";

        if ($logo !== null) {
            $sql .= ", logo = ?";
        }

        $sql .= " WHERE id_negocio = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        if ($logo !== null) {
            $stmt->bind_param("sssssssi", $nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $horario, $logo, $id_negocio);
        } else {
            $stmt->bind_param("ssssssi", $nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $horario, $id_negocio);
        }

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $stmt->close(); // Cerrar la declaración preparada
            return "Negocio actualizado exitosamente";
        } else {
            $error = "Error al ejecutar la consulta: " . $stmt->error;
            $stmt->close(); // Cerrar la declaración preparada
            return $error;
        }
    }

    public function eliminarNegocio($id_negocio)
    {
        $sql = "DELETE FROM negocios WHERE id_negocio = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }
        $stmt->bind_param("i", $id_negocio);
        if ($stmt->execute()) {
            $stmt->close(); // Cerrar la declaración preparada
            return "Negocio eliminado exitosamente";
        } else {
            $error = "Error al ejecutar la consulta: " . $stmt->error;
            $stmt->close(); // Cerrar la declaración preparada
            return $error;
        }
    }
    public function obtenerNegocioPorId($id_negocio)
    {
        $sql = "SELECT id_negocio, nombre_negocio, descripcion, direccion, telefono, sitio_web, horario, logo FROM negocios WHERE id_negocio = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_negocio);
        $stmt->execute();
        $result = $stmt->get_result();
        $negocio = $result->fetch_assoc();
        $stmt->close();
        return $negocio;
    }
    public function contarProductosPorNegocio($id_negocio) {
        $sql = "SELECT COUNT(*) AS cantidad FROM productos WHERE id_negocio = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }
        $stmt->bind_param("i", $id_negocio);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $resultado['cantidad'];
    }
    public function agregarProducto($id_negocio, $nombre_producto, $foto_producto) {
        $sql = "INSERT INTO productos (id_negocio, nombre_producto, foto_producto) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }
    
        $stmt->bind_param("sss", $id_negocio, $nombre_producto, $foto_producto);
    
        if ($stmt->execute()) {
            $stmt->close(); // Cerrar la declaración preparada
            return true; // Producto agregado exitosamente
        } else {
            $stmt->close(); // Cerrar la declaración preparada
            return false; // Error al agregar el producto
        }
        
    }public function actualizarProducto($id_producto, $id_negocio, $nombre_producto, $foto_producto = null) {
        // Crear la consulta de actualización
        $query = "UPDATE productos SET id_negocio = ?, nombre_producto = ?";
    
        // Solo agregar la parte de la foto si se proporciona una nueva foto
        if ($foto_producto !== null) {
            $query .= ", foto_producto = ?";
        }
    
        $query .= " WHERE id_producto = ?";
    
        $stmt = $this->conn->prepare($query);
    
        // Preparar los parámetros
        if ($foto_producto !== null) {
            $stmt->bind_param("issi", $id_negocio, $nombre_producto, $foto_producto, $id_producto);
        } else {
            $stmt->bind_param("ssi", $id_negocio, $nombre_producto, $id_producto);
        }
    
        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    

}
?>
