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

        public function contarProductosPorNegocio($id_negocio)
        {
            $query = "SELECT COUNT(*) as total FROM productos WHERE id_negocio = ?";
            $stmt = $this->conn->prepare($query);

            if (!$stmt) {
                die("Error al preparar la consulta: " . $this->conn->error);
            }

            $stmt->bind_param("i", $id_negocio);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result['total'];
        }

        public function agregarProducto($id_negocio, $nombre_producto, $nombreArchivo, $precio, $id_usuario)
        {
            $query = "INSERT INTO productos (id_negocio, nombre_producto, foto_producto, precio, id_usuario) VALUES (?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($query);

            if (!$stmt) {
                die("Error al preparar la consulta: " . $this->conn->error);
            }

            $stmt->bind_param("issdi", $id_negocio, $nombre_producto, $nombreArchivo, $precio, $id_usuario);
            return $stmt->execute();
        }

        public function obtenerProductos()
        {
            $query = "SELECT p.id_producto, p.id_negocio, p.nombre_producto, p.precio, p.foto_producto, n.nombre_negocio 
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

        public function actualizarProducto($id_producto, $id_negocio, $nombre_producto, $precio, $foto_producto = null)
        {
            if ($foto_producto === null) {
                $query = "UPDATE productos SET id_negocio = ?, nombre_producto = ?, precio = ? WHERE id_producto = ?";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param("isi", $id_negocio, $nombre_producto, $precio, $id_producto);
            } else {
                $query = "UPDATE productos SET id_negocio = ?, nombre_producto = ?, precio = ?, foto_producto = ? WHERE id_producto = ?";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param("isisi", $id_negocio, $nombre_producto, $precio, $foto_producto, $id_producto);
            }

            if (!$stmt) {
                die("Error al preparar la consulta: " . $this->conn->error);
            }

            return $stmt->execute();
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

        public function obtenerFotosPorNegocio($id_negocio)
        {
            $sql = "SELECT foto_producto , nombre_producto, precio FROM productos WHERE id_negocio = ?";
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
        public function buscarNegociosConSugerencias($termino)
        {
            $terminoBusqueda = "%" . $termino . "%";
            $sql = "SELECT id_negocio, nombre_negocio, descripcion, direccion, telefono, sitio_web, horario, logo FROM negocios WHERE nombre_negocio LIKE ? OR descripcion LIKE ?";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                die("Error al preparar la consulta: " . $this->conn->error);
            }

            $stmt->bind_param("ss", $terminoBusqueda, $terminoBusqueda);
            $stmt->execute();
            $result = $stmt->get_result();
            $negocios = [];

            while ($row = $result->fetch_assoc()) {
                $negocios[] = $row;
            }

            $stmt->close();
            return $negocios;
        }

        public function insertarResena($id_negocio, $calificacion, $comentario)
        {
            return $this->modeloNegocios->insertarResena($id_negocio, $calificacion, $comentario);
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

            return $vacantes;
        }
        public function procesarPostulacion()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'postular') {
                session_start();
                if (!isset($_SESSION['id_usuario'])) {
                    header("Location: ../login.php");
                    exit();
                }

                $id_usuario = $_SESSION['id_usuario'];
                $id_negocio = $_POST['id_negocio'];
                $nombres = $_POST['nombres'];
                $apellidos = $_POST['apellidos'];
                $edad = $_POST['edad'];
                $tipo_documento = $_POST['tipo_documento'];
                $documento_identidad = $_POST['documento_identidad'];
                $celular = $_POST['celular'];
                $correo_electronico = $_POST['correo_electronico'];
                $acepta_terminos = isset($_POST['acepta_terminos']) ? 1 : 0;

                $resultado = $this->modeloNegocios->insertarPostulacion($id_usuario, $id_negocio, $nombres, $apellidos, $edad, $tipo_documento, $documento_identidad, $celular, $correo_electronico, $acepta_terminos);

                if ($resultado) {
                    header("Location: ../Vista/categorias/panaderia.php");
                    exit();
                } else {
                    echo "Error al enviar la postulación.";
                }
            }
        }

        public function obtenerPostulacionesPorUsuario($id_usuario)
        {
            return $this->modeloNegocios->getPostulacionesPorUsuario($id_usuario);
        }

        public function obtenerNombreNegocioPorId($id_negocio)
        {
            return $this->modeloNegocios->getNombreNegocioPorId($id_negocio);
        }
        public function borrarVacante($id_vacante)
        {
            $query = "DELETE FROM vacantes WHERE id_vacante = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('i', $id_vacante);
            return $stmt->execute();
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
                        header('Location: ../../Vista/usuarios/administracion/vacantes.php');
                    } else {
                        header('Location: ../Vista/admin/vacantes.php?mensaje=error');
                    }
                    exit();
                } else {
                    header('Location: ../Vista/admin/vacantes.php?mensaje=falta_id');
                    exit();
                }
            }
        }

        // ... (otros métodos de la clase)
    }

    // Fuera de la clase, al final del archivo
    $controlador = new ControladorNegocios();

    // Determinar qué acción realizar basado en el parámetro 'accion'
    if (isset($_POST['accion'])) {
        switch ($_POST['accion']) {
            case 'actualizar_vacante':
                $controlador->procesarActualizacionVacante();
                break;
            case 'postular':
                $controlador->procesarPostulacion();
            case 'borrar_vacante':
                if (isset($_POST['id_vacante'])) {
                    $id_vacante = $_POST['id_vacante'];
                    $controlador->borrarVacante($id_vacante);
                }
                break;
                // Agrega más casos según sea necesario
        }
    }

    // Si no se ha realizado ninguna acción, redirigir a la página principa
    exit();
    $controlador = new ControladorNegocios();
    $controlador->procesarPostulacion();
    $controlador->procesarActualizacionVacante(); // Añade esta línea
    ?>