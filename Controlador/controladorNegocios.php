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

    public function obtenerNegociosPorCategoria($id_categoria)
    {
        $sql = "SELECT id_negocio, nombre_negocio, descripcion, direccion, telefono, sitio_web, horario, logo FROM negocios WHERE id_categoria = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        $result = $stmt->get_result();
        $negocios = [];
        while ($row = $result->fetch_assoc()) {
            $negocios[] = $row;
        }
        $stmt->close();

        // Depuración
        error_log("Consulta SQL: " . $sql);
        error_log("ID de categoría: " . $id_categoria);
        error_log("Número de negocios encontrados: " . count($negocios));

        return $negocios;
    }

    public function obtenerFotosPorNegocio($id_negocio)
    {
        $sql = "SELECT foto_producto, nombre_producto, precio FROM productos WHERE id_negocio = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id_negocio);
        $stmt->execute();
        $result = $stmt->get_result();

        $fotos = [];
        while ($fila = $result->fetch_assoc()) {
            $fotos[] = $fila;
        }

        $stmt->close();
        return $fotos;
    }

    public function obtenerVacantesPorNegocio($id_negocio)
    {
        $sql = "SELECT vacantes.*, negocios.nombre_negocio AS nombre_negocio
                FROM vacantes
                JOIN negocios ON vacantes.id_negocio = negocios.id_negocio
                WHERE vacantes.id_negocio = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id_negocio);
        $stmt->execute();
        $result = $stmt->get_result();
        $vacantes = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        // Depuración
        error_log("Consulta SQL para vacantes: " . $sql);
        error_log("ID de negocio: " . $id_negocio);
        error_log("Número de vacantes encontradas: " . count($vacantes));

        return $vacantes;
    }

    public function procesarActualizacionVacante()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'actualizar_vacante') {
            if (isset($_POST['id_vacante'])) {
                $id_vacante = $_POST['id_vacante'];
                $datos = [
                    'ocupacion' => $_POST['ocupacion'],
                    'descripcion' => $_POST['descripcion'],
                    'requisitos' => $_POST['requisitos'],
                    'horario' => $_POST['horario'],
                    'salario' => $_POST['salario']
                ];

                if ($this->modeloNegocios->actualizarVacante($id_vacante, $datos)) {
                    header('Location: ../Vista/usuarios/administracion/vacantes.php');
                } else {
                    header('Location: ../Vista/usuarios/administracion/vacantes.php?mensaje=error');
                }
                exit();
            } else {
                header('Location: ../Vista/usuarios/administracion/vacantes.php?mensaje=falta_id');
                exit();
            }
        }
    }

    public function obtenerNegociosPorUsuario($id_usuario)
    {
        $sql = "SELECT id_negocio, nombre_negocio, descripcion, direccion, telefono, sitio_web, horario, logo FROM negocios WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($sql);

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

    public function obtenerPostulacionesPorUsuario($id_usuario)
    {
        return $this->modeloNegocios->getPostulacionesPorUsuario($id_usuario);
    }

    public function obtenerNombreNegocioPorId($id_negocio)
    {
        return $this->modeloNegocios->getNombreNegocioPorId($id_negocio);
    }
    public function buscarNegociosConSugerencias($termino)
    {
        $termino = '%' . $termino . '%';
        $sql = "SELECT id_negocio, nombre_negocio, descripcion, horario, direccion, telefono, logo 
            FROM negocios 
            WHERE nombre_negocio LIKE ? OR descripcion LIKE ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        // Usa el mismo término de búsqueda para ambas columnas
        $stmt->bind_param("ss", $termino, $termino);
        $stmt->execute();
        $result = $stmt->get_result();
        $sugerencias = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $sugerencias;
    }
    public function obtenerProductosPorUsuario($id_usuario)
    {
        $modeloNegocios = new ModeloNegocios($this->conn);
        return $modeloNegocios->obtenerProductosPorUsuario($id_usuario);
    }
    public function buscarNegociosPorNombre($nombre_negocio)
    {
        $query = "SELECT * FROM negocios WHERE nombre_negocio LIKE ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $likeNombre = '%' . $nombre_negocio . '%';
        $stmt->bind_param("s", $likeNombre);
        $stmt->execute();
        $result = $stmt->get_result();

        $negocios = [];
        while ($row = $result->fetch_assoc()) {
            $negocios[] = $row;
        }

        $stmt->close();
        return $negocios;
    }
    public function guardarNegocio($id_usuario, $nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $id_categoria, $horario, $logo)
    {
        return $this->modeloNegocios->guardarNegocio($id_usuario, $nombre_negocio, $descripcion, $direccion, $telefono, $sitio, $id_categoria, $horario, $logo);
    }
    public function buscarProductosPorNombre($nombre_producto)
    {
        $query = "SELECT * FROM productos WHERE nombre_producto LIKE ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $likeNombre = '%' . $nombre_producto . '%';
        $stmt->bind_param("s", $likeNombre);
        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }

        $stmt->close();
        return $productos;
    }

    public function procesarPostulacion()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'postular') {
            session_start();
            if (!isset($_SESSION['id_usuario'])) {
                header("Location: ../Vista/login.php");
                exit();
            }

            // Sanitización de entradas
            $id_usuario = $_SESSION['id_usuario'];
            $id_negocio = isset($_POST['id_negocio']) ? $_POST['id_negocio'] : null;
            $nombres = isset($_POST['nombres']) ? $_POST['nombres'] : null;
            $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : null;
            $edad = isset($_POST['edad']) ? $_POST['edad'] : null;
            $tipo_documento = isset($_POST['tipo_documento']) ? $_POST['tipo_documento'] : null;
            $documento_identidad = isset($_POST['documento_identidad']) ? $_POST['documento_identidad'] : null;
            $celular = isset($_POST['celular']) ? $_POST['celular'] : null;
            $correo_electronico = isset($_POST['correo_electronico']) ? $_POST['correo_electronico'] : null;
            $acepta_terminos = isset($_POST['acepta_terminos']) ? 1 : 0;

            $resultado = $this->modeloNegocios->insertarPostulacion($id_usuario, $id_negocio, $nombres, $apellidos, $edad, $tipo_documento, $documento_identidad, $celular, $correo_electronico, $acepta_terminos);

            if ($resultado) {
                header("Location: ../Vista/index.php?mensaje=postulacion_exitosa");
            } else {
                header("Location: ../Vista/index.php?mensaje=error_postulacion");
            }
            exit();
        }
    }
}

// Procesar la solicitud
$controlador = new ControladorNegocios();

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'postular':
            $controlador->procesarPostulacion();
            break;
            // Otros casos...
    }
}
