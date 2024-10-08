<?php
include_once(__DIR__ . '/../Modelo/modeloNegocios.php');


class ControladorNegocios
{
    private $modeloNegocios;
    private $conn;

    public function __construct()
    {
        $servername = 'localhost'; // Cambia esto según tu configuración
        $dbname = 'efimarket';
        $username = 'root'; // Cambia esto según tu configuración
        $password = ''; // Cambia esto según tu configuración


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
                    'salario' => floatval($_POST['salario'])  // Ensure salary is converted to float
                ];

                $resultado = $this->modeloNegocios->actualizarVacante($id_vacante, $datos);

                if ($resultado) {
                    header('Location: ../Vista/usuarios/administracion/vacantes.php?mensaje=actualizado');
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



    public function actualizarNegocio($id_negocio, $nombre_negocio, $descripcion, $direccion, $telefono, $sitio_web, $horario, $logo = null)
    {
        // Primero obtenemos el logo actual si no se subió uno nuevo
        if ($logo === null) {
            $sql = "SELECT logo FROM negocios WHERE id_negocio = ?";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                die("Error al preparar la consulta para obtener el logo existente: " . $this->conn->error);
            }

            $stmt->bind_param("i", $id_negocio);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $logo = $row['logo']; // Usamos el logo existente
            }

            $stmt->close();
        }

        // Actualizamos los datos, asegurándonos de que el logo esté antes del horario
        $sql = "UPDATE negocios 
            SET nombre_negocio = ?, descripcion = ?, direccion = ?, telefono = ?, sitio_web = ?, logo = ?, horario = ? 
            WHERE id_negocio = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error al preparar la consulta de actualización: " . $this->conn->error);
        }

        // Asegúrate de que los parámetros están en el orden correcto
        $stmt->bind_param("sssssssi", $nombre_negocio, $descripcion, $direccion, $telefono, $sitio_web, $logo, $horario, $id_negocio);
        $resultado = $stmt->execute();
        $stmt->close();

        return $resultado;
    }
    public function obtenerNegocioPorId($id_negocio)
    {
        // Preparar la consulta para obtener los detalles del negocio por su ID
        $sql = "SELECT * FROM negocios WHERE id_negocio = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_negocio);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $resultado = $stmt->get_result();

        // Verificar si se encontró un negocio con el ID dado
        if ($resultado->num_rows > 0) {
            // Retornar el negocio como un array asociativo
            return $resultado->fetch_assoc();
        } else {
            // Si no se encontró el negocio, retornar null
            return null;
        }
    }

    public function obtenerPlanUsuario($id_usuario)
    {
        // Consulta para obtener el plan del usuario
        $query = "SELECT plan FROM usuarios WHERE id_usuario = ?";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Vincular el parámetro
        $stmt->bind_param("i", $id_usuario); // 'i' para integer

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result(); // Usar get_result() para obtener el conjunto de resultados

        // Verificar si se obtuvo un resultado
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc(); // Obtener la fila
            return $row['plan']; // Retornar el plan
        }

        // Retornar null si no se encontró el plan
        return null;
    }

    public function eliminarNegocio($id_negocio)
    {
        // Primero, obtener los detalles del negocio (incluido el logo)
        $negocio = $this->obtenerNegocioPorId($id_negocio);

        if (!$negocio) {
            return false; // El negocio no existe
        }

        // Si el negocio tiene un logo, eliminar el archivo del servidor
        $logo = $negocio['logo'];
        if ($logo && file_exists("../../../uploads/logos/$logo")) {
            unlink("../../../uploads/logos/$logo");
        }

        // Preparar la consulta para eliminar el negocio de la base de datos
        $sql = "DELETE FROM negocios WHERE id_negocio = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_negocio);

        // Ejecutar la consulta y devolver el resultado
        if ($stmt->execute()) {
            return true; // Negocio eliminado con éxito
        } else {
            return false; // Error al eliminar el negocio
        }
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
    public function actualizarProducto($id_producto, $id_negocio, $nombre_producto, $precio, $foto_producto = null)
    {
        // First, get the current product data
        $current_product = $this->obtenerProductoPorId($id_producto);

        $sql = "UPDATE productos SET id_negocio = ?, nombre_producto = ?, precio = ?";
        $params = [$id_negocio, $nombre_producto, $precio];
        $types = "isi";

        if ($foto_producto !== null && $foto_producto !== '') {
            $sql .= ", foto_producto = ?";
            $params[] = $foto_producto;
            $types .= "s";
        } else {
            // Keep the existing photo
            $foto_producto = $current_product['foto_producto'];
        }

        $sql .= " WHERE id_producto = ?";
        $params[] = $id_producto;
        $types .= "i";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
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
    public function obtenerProductoPorId($id_producto)
    {
        $query = "SELECT * FROM productos WHERE id_producto = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
    public function eliminarProducto($id_producto)
    {
        $query = "DELETE FROM productos WHERE id_producto = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id_producto);
        return $stmt->execute();
    }
    public function agregarResena($id_negocio, $id_usuario, $calificacion, $comentario)
    {
        // Validar los datos
        $id_negocio = filter_var($id_negocio, FILTER_VALIDATE_INT);
        $id_usuario = filter_var($id_usuario, FILTER_VALIDATE_INT);
        $calificacion = filter_var($calificacion, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 5]]);
        $comentario = filter_var($comentario); // Sanitizar el comentario

        // Comprobar si las variables son válidas
        if ($id_negocio === false || $id_usuario === false || $calificacion === false) {
            return false; // O manejar el error según sea necesario
        }

        // Llamar a la función del modelo para agregar la reseña
        $resenaAgregada = $this->modeloNegocios->agregarResena($id_negocio, $id_usuario, $calificacion, $comentario);

        // Si la reseña se agregó correctamente, aumentar la XP del usuario
        if ($resenaAgregada) {
            $this->modeloNegocios->sumarXP($id_usuario, 30); // Aumentar 30 XP
        }

        return $resenaAgregada; // Devolver el resultado
    }

    public function procesarPostulacion()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'postular') {
            session_start();
            if (!isset($_SESSION['id_usuario'])) {
                header('Location: ../login.php');
                exit;
            }

            $id_usuario = $_SESSION['id_usuario'];
            $id_negocio = filter_input(INPUT_POST, 'id_negocio', FILTER_VALIDATE_INT);

            if ($id_negocio === false || $id_negocio === null) {
                $_SESSION['mensaje'] = "Error: ID de negocio inválido.";
                header("Location: ../Vista/index.php");
                exit;
            }

            $nombres = filter_input(INPUT_POST, 'nombres');
            $apellidos = filter_input(INPUT_POST, 'apellidos');
            $edad = filter_input(INPUT_POST, 'edad', FILTER_VALIDATE_INT);
            $tipo_documento = filter_input(INPUT_POST, 'tipo_documento');
            $documento_identidad = filter_input(INPUT_POST, 'documento_identidad');
            $celular = filter_input(INPUT_POST, 'celular');
            $correo_electronico = filter_input(INPUT_POST, 'correo_electronico', FILTER_VALIDATE_EMAIL);
            $acepta_terminos = isset($_POST['acepta_terminos']) ? 1 : 0;

            if (!$nombres || !$apellidos || !$edad || !$tipo_documento || !$documento_identidad || !$celular || !$correo_electronico) {
                $_SESSION['mensaje'] = "Error: Todos los campos son obligatorios.";
                header("Location: ../Vista/categorias/vacantes.php?id_negocio=" . $id_negocio);
                exit;
            }

            $resultado = $this->modeloNegocios->agregarPostulacion(
                $id_usuario,
                $id_negocio,
                $nombres,
                $apellidos,
                $edad,
                $tipo_documento,
                $documento_identidad,
                $celular,
                $correo_electronico,
                $acepta_terminos
            );

            if ($resultado) {
                $_SESSION['mensaje'] = "Postulación enviada con éxito.";
            } else {
                $_SESSION['mensaje'] = "Error al enviar la postulación.";
            }

            header("Location: ../Vista/categorias/vacantes.php?id_negocio=" . $id_negocio);
            exit;
        }
    }
    public function contarNegociosPorUsuario($id_usuario)
    {
        // Crear una instancia del modelo de negocios
        $modelo = new ModeloNegocios();

        // Llamar al método del modelo que cuenta los negocios
        return $modelo->contarNegociosPorUsuario($id_usuario);
    }
    public function contarVacantesPorNegocio($id_negocio)
    {
        // Asegúrate de que tienes acceso al modelo
        $modelo = new ModeloNegocios();

        // Llama al método del modelo que contará las vacantes por negocio
        return $modelo->contarVacantesPorNegocio($id_negocio);
    }
}
$controlador = new ControladorNegocios();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'agregar_resena':
            if (isset($_POST['id_negocio']) && isset($_POST['id_usuario']) && isset($_POST['calificacion'])) {
                $id_negocio = $_POST['id_negocio'];
                $id_usuario = $_POST['id_usuario']; // Obtén el id del usuario
                $calificacion = $_POST['calificacion'];
                $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : '';

                if ($controlador->agregarResena($id_negocio, $id_usuario, $calificacion, $comentario)) {
                    header('Location: ../Vista/index.php?mensaje=resena_agregada');
                } else {
                    header('Location: ../Vista/index.php?mensaje=error_al_agregar_resena');
                }
                exit();
            } else {
                header('Location: ../Vista/index.php?mensaje=datos_incompletos');
                exit();
            }
            break;
        case 'postular':
            $controlador->procesarPostulacion();
            break;
    }
}





if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    switch ($accion) {
        case 'borrar_vacante':
            $id_vacante = isset($_POST['id_vacante']) ? $_POST['id_vacante'] : null;
            if ($id_vacante) {
                $modelo = new ModeloNegocios();
                $resultado = $modelo->borrarVacante($id_vacante);

                if ($resultado) {
                    // Redirigir a la página de vacantes con un mensaje de éxito
                    header('Location: ../Vista/usuarios/administracion/vacantes.php?mensaje=vacante_borrada');
                } else {
                    // Redirigir con un mensaje de error
                    header('Location: ../Vista/usuarios/administracion/vacantes.php?error=error_borrar');
                }
            }
            break;

            // Aquí irían otros casos como actualizar_vacante o crear_vacante.
    }
}
