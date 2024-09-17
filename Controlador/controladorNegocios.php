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

        public function insertarResena($id_negocio, $calificacion, $comentario) {
            return $this->modeloNegocios->insertarResena($id_negocio, $calificacion, $comentario);
        }
    }


        