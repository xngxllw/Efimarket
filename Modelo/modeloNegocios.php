<?php
class ModeloNegocios
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli('localhost', 'root', '', 'efimarket');
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
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
    public function insertarResena($id_negocio, $id_usuario, $calificacion, $comentario)
    {
        $sql = "INSERT INTO reseñas (id_negocio, id_usuario, calificacion, comentario) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $this->conn->error);
        }

        $stmt->bind_param("iiis", $id_negocio, $id_usuario, $calificacion, $comentario); // iiis: entero, entero, entero, string
        $stmt->execute();

        if ($stmt->error) {
            die('Error al ejecutar la consulta: ' . $stmt->error);
        }

        // Aquí es donde actualizamos el XP del usuario
        $sql_xp = "UPDATE usuarios SET xp = xp + 30 WHERE id_usuario = ?";
        $stmt_xp = $this->conn->prepare($sql_xp);

        if ($stmt_xp === false) {
            die('Error en la preparación de la consulta de XP: ' . $this->conn->error);
        }

        $stmt_xp->bind_param("i", $id_usuario);
        $stmt_xp->execute();

        if ($stmt_xp->error) {
            die('Error al ejecutar la consulta de XP: ' . $stmt_xp->error);
        }

        $stmt->close();
        $stmt_xp->close();
    }

    public function sumarXP($id_usuario, $xp)
    {
        $sql = "UPDATE usuarios SET xp = xp + ? WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $this->conn->error);
        }

        $stmt->bind_param("ii", $xp, $id_usuario);
        $stmt->execute();

        if ($stmt->error) {
            die('Error al ejecutar la consulta: ' . $stmt->error);
        }

        $stmt->close();
    }

    public function obtenerVacantesPorNegocio($id_negocio)
    {
        $sql = "SELECT * FROM vacantes WHERE id_negocio = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id_negocio);
        $stmt->execute();
        $result = $stmt->get_result();
        $vacantes = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $vacantes;
    }
    public function agregarPostulacion($id_usuario, $id_negocio, $nombres, $apellidos, $edad, $tipo_documento, $documento_identidad, $celular, $correo_electronico, $acepta_terminos)
    {
        $stmt = $this->conn->prepare("INSERT INTO postulaciones (id_usuario, id_negocio, nombres, apellidos, edad, tipo_documento, documento_identidad, celular, correo_electronico, acepta_terminos) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iississssi", $id_usuario, $id_negocio, $nombres, $apellidos, $edad, $tipo_documento, $documento_identidad, $celular, $correo_electronico, $acepta_terminos);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function getPostulacionesPorUsuario($id_usuario)
    {
        $sql = "SELECT p.*, n.nombre_negocio
                FROM postulaciones p
                INNER JOIN negocios n ON p.id_negocio = n.id_negocio
                WHERE p.id_usuario = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $postulaciones = [];
        while ($fila = $resultado->fetch_assoc()) {
            $postulaciones[] = $fila;
        }

        $stmt->close();
        return $postulaciones;
    }

    // Método para obtener el nombre del negocio por ID
    public function obtenerNombreNegocioPorId($id_negocio)
    {
        $sql = "SELECT nombre_negocio FROM negocios WHERE id_negocio = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id_negocio);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $nombre_negocio = $resultado->fetch_assoc();
        $stmt->close();

        return $nombre_negocio ? $nombre_negocio['nombre_negocio'] : null;
    }
    public function getNombreNegocioPorId($id_negocio)
    {
        $sql = "SELECT nombre_negocio FROM negocios WHERE id_negocio = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id_negocio);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $nombre_negocio = $resultado->fetch_assoc();
        $stmt->close();

        return $nombre_negocio ? $nombre_negocio['nombre_negocio'] : null;
    }
    public function actualizarVacante($id_vacante, $datos)
    {
        $query = "UPDATE vacantes SET ocupacion = ?, descripcion = ?, requisitos = ?, horario = ?, salario = ? WHERE id_vacante = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            error_log("Error al preparar la consulta: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param(
            "ssssdi",
            $datos['ocupacion'],
            $datos['descripcion'],
            $datos['requisitos'],
            $datos['horario'],
            $datos['salario'],
            $id_vacante
        );

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }


    public function agregarResena($id_negocio, $id_usuario, $calificacion, $comentario)
    {
        $fecha = date('Y-m-d H:i:s');
        $sql = "INSERT INTO reseñas (id_negocio, id_usuario, calificacion, comentario, fecha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("iiiss", $id_negocio, $id_usuario, $calificacion, $comentario, $fecha);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
    public function borrarVacante($id_vacante)
    {
        $query = "DELETE FROM vacantes WHERE id_vacante = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id_vacante);

        return $stmt->execute();
    }
    public function contarNegociosPorUsuario($id_usuario)
    {
        $query = "SELECT COUNT(*) AS total FROM negocios WHERE id_usuario = ?";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        // Vincular el parámetro
        $stmt->bind_param("i", $id_usuario); // 'i' para integer

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result(); // Usar get_result() para obtener el conjunto de resultados

        // Retornar el conteo de negocios
        $row = $result->fetch_assoc(); // Obtener la fila
        return $row['total']; // Retornar el total
    }
    public function contarVacantesPorNegocio($id_negocio)
    {
        $query = "SELECT COUNT(*) AS total FROM vacantes WHERE id_negocio = ?";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Verificar si se preparó correctamente
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        // Vincular el parámetro
        $stmt->bind_param("i", $id_negocio);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result(); // Obtener el resultado de la consulta

        // Retornar el conteo de vacantes
        $row = $result->fetch_assoc(); // Obtener el resultado en un arreglo asociativo
        return $row['total'];
    }
}
