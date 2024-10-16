<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda - Efimarket</title>
    <script src="https://kit.fontawesome.com/a44f9ce7b1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="categorias.css">
    <link rel="icon" type="image/png" href="../images/carrito.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <nav>
        <a class="hamburger link" href="#" onclick="toggleHamburgerMenu()"><i class="fa-solid fa-bars"></i></a>
        <a class="logo link" href="../index.php"><img width="260" src="../images/letras.png" alt=""></a>
        <div class="user-icon" onclick="toggleMenu()">
            <i class="fas fa-user-circle"></i>
            <div class="dropdown-menu" id="dropdownMenu">
                <?php
                session_start();
                if (isset($_SESSION['rol'])) {
                    if ($_SESSION['rol'] == 'admin') {
                        echo '<a href="../usuarios/administracion/panel.php">Panel de Administrador</a>';
                        echo '<a href="../usuarios/clientes/perfil.php">Mi Perfil</a>';
                    } else {
                        echo '<a href="../usuarios/clientes/perfil.php">Mi Perfil</a>';
                    }
                    echo '<a href="../../../Controlador/logout.php">Cerrar Sesión</a>';
                } else {
                    echo '<a href="../login.php">Iniciar Sesión</a>';
                    echo '<a href="../registro.php">Registrarse</a>';
                }
                ?>
            </div>
    </nav>

    <div class="navigation-message">
        <p>Resultados de tu búsqueda</p>
    </div>

    <div class="contenedor-negocios">
        <?php
        include_once('../../Controlador/controladorNegocios.php');

        $controlador = new ControladorNegocios(); // Usa la variable $controlador aquí
        $terminoBusqueda = isset($_GET['query']) ? trim($_GET['query']) : '';

        if (empty($terminoBusqueda)) {
            echo "<div class='alert alert-warning text-center my-4'>No se ha proporcionado un término de búsqueda.</div>";
        } else {
            $negocios = $controlador->buscarNegociosConSugerencias($terminoBusqueda);
        }

        if (!empty($negocios)) {
            echo '<div class="cont-negocios">';
            foreach ($negocios as $negocio) {
                $nombreNegocio = isset($negocio['nombre_negocio']) ? htmlspecialchars($negocio['nombre_negocio']) : 'Nombre no disponible';
                $descripcion = isset($negocio['descripcion']) ? htmlspecialchars($negocio['descripcion']) : 'Descripción no disponible';
                $horario = isset($negocio['horario']) ? htmlspecialchars($negocio['horario']) : 'Horario no disponible';
                $direccion = isset($negocio['direccion']) ? htmlspecialchars($negocio['direccion']) : 'Dirección no disponible';
                $telefono = isset($negocio['telefono']) ? htmlspecialchars($negocio['telefono']) : 'Teléfono no disponible';
                $logo = isset($negocio['logo']) ? $negocio['logo'] : 'default-logo.png';
                $idNegocio = isset($negocio['id_negocio']) ? $negocio['id_negocio'] : 0;

                $fotos = $controlador->obtenerFotosPorNegocio($idNegocio); // Usa $controlador aquí

                echo '<a href="#" class="negocio" data-bs-toggle="modal" data-bs-target="#modalNegocio' . $idNegocio . '">';
                echo '<img width="150px" height="150px" src="../../uploads/logos/' . $logo . '" alt="Logo del negocio">';
                echo '<div class="nombre-cat">';

                echo '<h5 class="nombreNegocio">' . $nombreNegocio . '</h5>';
                echo '<div class="categoriaNegocio">' . $descripcion . '</div>';
                echo '</div>';
                echo '<div class="info-negocio">';
                echo '<div class="horario"><i class="fa-solid fa-clock"></i><span>' . $horario . '</span></div>';
                echo '<div class="ubicacion"><i class="fa-solid fa-location-dot"></i><span>' . $direccion . '</span></div>';
                echo '<div class="telefono"><i class="fa-solid fa-phone"></i><span>' . $telefono . '</span></div>';
                echo '</div>';
                echo '</a>';

                echo '<div class="modal fade" id="modalNegocio' . $idNegocio . '" tabindex="-1" aria-labelledby="modalLabel' . $idNegocio . '" aria-hidden="true">';
                echo '<div class="modal-dialog">';
                echo '<div class="modal-content">';
                echo '<div class="modal-header">';
                echo '<h5 class="modal-title" id="modalLabel' . $idNegocio . '">' . $nombreNegocio . '</h5>';
                echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                echo '</div>';
                echo '<div class="modal-body">';
                echo '<img width="200px" style="border-radius: 10px;" src="../../uploads/logos/' . $logo . '" alt="Logo del negocio">';
                echo '<p><strong>Descripción:</strong> ' . $descripcion . '</p>';
                echo '<p><strong>Horario:</strong> ' . $horario . '</p>';
                echo '<p><strong>Ubicación:</strong> ' . $direccion . '</p>';
                echo '<p><strong>Teléfono:</strong> ' . $telefono . '</p>';

                echo '<p><strong>Fotos:</strong></p>';
                echo '<div class="cont-productos">';
                if (!empty($fotos)) {
                    foreach ($fotos as $foto) {
                        $fotoProducto = isset($foto['foto_producto']) ? $foto['foto_producto'] : 'default-product.png';
                        $nombreProducto = isset($foto['nombre_producto']) ? htmlspecialchars($foto['nombre_producto']) : 'Nombre no disponible';
                        $precio = isset($foto['precio']) ? htmlspecialchars($foto['precio']) : 'Precio no disponible';

                        echo '<div class="cont-producto"> <img src="../../uploads/productos/' . $fotoProducto . '" alt="Foto del negocio" width="150px">';
                        echo '<h5 class="nombre-producto">' . $nombreProducto . '</h5>';
                        echo '<h6><strong>$</strong>' . $precio . '</h6> </div>';
                    }
                } else {
                    echo '<p>No hay fotos disponibles.</p>';
                }
                echo '</div>';

                echo '<div class="acciones-section d-flex justify-content-between">';
                echo '<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalResena' . $idNegocio . '">Reseñar</button>';
                echo '<a href="vacantes.php?id_negocio=' . $idNegocio . '" class="btn btn-secondary">Ver Vacantes</a>';
                echo '</div>';
                echo '</div>';
                echo '<div class="modal-footer">';
                echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

                // Modal para la reseña
                echo '<div class="modal fade" id="modalResena' . $idNegocio . '" tabindex="-1" aria-labelledby="modalResenaLabel' . $idNegocio . '" aria-hidden="true">';
                echo '<div class="modal-dialog">';
                echo '<div class="modal-content">';
                echo '<div class="modal-header">';
                echo '<h5 class="modal-title" id="modalResenaLabel' . $idNegocio . '">Reseñar ' . $nombreNegocio . '</h5>';
                echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                echo '</div>';
                echo '<div class="modal-body">';
                echo '<form action="../../Controlador/controladorNegocios.php" method="POST">';
                echo '<input type="hidden" name="action" value="agregar_resena">';
                echo '<input type="hidden" name="id_negocio" value="' . $idNegocio . '">';
                echo '<div class="mb-3">';
                echo '<label for="calificacion" class="form-label">Calificación</label>';
                echo '<select class="form-select" name="calificacion" required>';
                echo '<option value="">Selecciona una calificación</option>';
                for ($i = 1; $i <= 5; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }
                echo '</select>';
                echo '</div>';
                echo '<div class="mb-3">';
                echo '<label for="comentario" class="form-label">Comentario (opcional)</label>';
                echo '<textarea class="form-control" name="comentario" rows="3"></textarea>';
                echo '</div>';
                echo '</div>';
                echo '<div class="modal-footer">';
                echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>';
                echo '<button type="submit" class="btn btn-primary">Enviar Reseña</button>';
                echo '</div>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>'; // fin de cont-negocios
        } else {
            echo "<div class='alert alert-warning text-center my-4'>No se encontraron negocios para la búsqueda.</div>";
        }
        ?>
    </div>
    <div id="overlay"></div> <!--para oscurecer la pagina cuando aparezca el menu hamburguesa-->
    <script src="../js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>