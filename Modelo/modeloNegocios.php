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

        $stmt->bind_param("isssssiss", $id_usuario, $nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $id_categoria, $logo, $horario);

        if ($stmt->execute()) {
            $stmt->close();
            return "Nuevo negocio registrado exitosamente";
        } else {
            $error = "Error al ejecutar la consulta: " . $stmt->error;
            $stmt->close();
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

        if ($stmt->execute()) {
            $stmt->close();
            return "Negocio actualizado exitosamente";
        } else {
            $error = "Error al ejecutar la consulta: " . $stmt->error;
            $stmt->close();
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
            $stmt->close();
            return "Negocio eliminado exitosamente";
        } else {
            $error = "Error al ejecutar la consulta: " . $stmt->error;
            $stmt->close();
            return $error;
        }
    }

    public function obtenerNegocioPorId($id_negocio)
    {
        $sql = "SELECT id_negocio, nombre_negocio, descripcion, direccion, telefono, sitio_web, horario, logo FROM negocios WHERE id_negocio = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id_negocio);
        $stmt->execute();
        $result = $stmt->get_result();
        $negocio = $result->fetch_assoc();
        $stmt->close();
        return $negocio;
    }

    public function contarProductosPorNegocio($id_negocio)
    {
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

    public function agregarProducto($id_negocio, $nombre_producto, $foto_producto)
    {
        $sql = "INSERT INTO productos (id_negocio, nombre_producto, foto_producto) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("iss", $id_negocio, $nombre_producto, $foto_producto);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function actualizarProducto($id_producto, $id_negocio, $nombre_producto, $foto_producto = null)
    {
        $sql = "UPDATE productos SET id_negocio = ?, nombre_producto = ?";

        if ($foto_producto !== null) {
            $sql .= ", foto_producto = ?";
        }

        $sql .= " WHERE id_producto = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        if ($foto_producto !== null) {
            $stmt->bind_param("issi", $id_negocio, $nombre_producto, $foto_producto, $id_producto);
        } else {
            $stmt->bind_param("ssi", $id_negocio, $nombre_producto, $id_producto);
        }

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function obtenerProductosPorUsuario($id_usuario)
    {
        $sql = "SELECT p.id_producto, p.nombre_producto, p.foto_producto, p.id_negocio, p.precio, n.nombre_negocio
                FROM productos p
                INNER JOIN negocios n ON p.id_negocio = n.id_negocio
                WHERE n.id_usuario = ?";
        
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }
    
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $productos = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $productos;
    }

    // Nueva función para buscar negocios por nombre
    public function buscarNegociosPorNombre($nombre)
    {
        $sql = "SELECT * FROM negocios WHERE nombre_negocio LIKE ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $nombre = '%' . $nombre . '%'; // Para hacer la búsqueda más flexible
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        $negocios = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $negocios;
    }
    public function buscarNegociosConSugerencias($termino)
{
    $termino = '%' . $termino . '%';
    $sql = "SELECT id_negocio, nombre_negocio FROM negocios WHERE nombre_negocio LIKE ?";

    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $this->conn->error);
    }

    $stmt->bind_param("s", $termino);
    $stmt->execute();
    $result = $stmt->get_result();
    $sugerencias = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $sugerencias;
}

}
?>
