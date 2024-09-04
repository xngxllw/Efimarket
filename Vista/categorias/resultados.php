<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda - Efimarket</title>
    <!-- Font Awesome para iconos -->
    <script src="https://kit.fontawesome.com/a44f9ce7b1.js" crossorigin="anonymous"></script>
    <!-- Hojas de estilo personalizadas -->
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="categorias.css">
    <!-- Icono de la página -->
    <link rel="icon" type="image/png" href="../images/carrito.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <!-- Navegación -->
    <nav>
        <a class="hamburger link" href="#" onclick="toggleHamburgerMenu()"><i class="fa-solid fa-bars"></i></a>
        <a class="logo link" href="../index.php"><img width="260" src="../images/letras.png" alt="Efimarket Logo"></a>
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
        </div>
    </nav>

    <!-- Encabezado -->
    <header>
        <h1>Resultados de Búsqueda</h1>
    </header>

    <!-- Contenedor de negocios -->
    <div class="contenedor-negocios">
        <?php
        include_once('../../Controlador/controladorNegocios.php');

        // Inicializar el controlador
        $controlador = new ControladorNegocios();

        // Verificar si se ha proporcionado un término de búsqueda
        $terminoBusqueda = isset($_GET['query']) ? trim($_GET['query']) : '';

        if (empty($terminoBusqueda)) {
            echo "<div class='alert alert-warning text-center my-4'>No se ha proporcionado un término de búsqueda.</div>";
        } else {
            // Obtener negocios según el término de búsqueda
            $negocios = $controlador->buscarNegociosConSugerencias($terminoBusqueda);

            if (!empty($negocios)) {
                echo '<div class="cont-negocios">';
                foreach ($negocios as $negocio) {
                    $descripcion = isset($negocio['descripcion']) ? $negocio['descripcion'] : 'No disponible';
                    $fotos = $controlador->obtenerFotosPorNegocio($negocio['id_negocio']); // Obtener las fotos del negocio

                    echo '<a href="#" class="negocio" data-bs-toggle="modal" data-bs-target="#modalNegocio' . $negocio['id_negocio'] . '">';
                    echo '<img width="150px" height="150px" src="../../uploads/logos/' . htmlspecialchars($negocio['logo']) . '" alt="Logo del negocio">';
                    echo '<h5 class="nombreNegocio">' . htmlspecialchars($negocio['nombre_negocio']) . '</h5>';
                    echo '<div class="categoriaNegocio">' . htmlspecialchars($descripcion) . '</div>';
                    echo '<div class="info-negocio">';
                    echo '<div class="horario"><i class="fa-solid fa-clock"></i><span>' . htmlspecialchars($negocio['horario']) . '</span></div>';
                    echo '<div class="ubicacion"><i class="fa-solid fa-location-dot"></i><span>' . htmlspecialchars($negocio['direccion']) . '</span></div>';
                    echo '<div class="telefono"><i class="fa-solid fa-phone"></i><span>' . htmlspecialchars($negocio['telefono']) . '</span></div>';
                    echo '</div>';
                    echo '</a>';

                    // Ventana modal para mostrar información ampliada
                    echo '<div class="modal fade" id="modalNegocio' . $negocio['id_negocio'] . '" tabindex="-1" aria-labelledby="modalLabel' . $negocio['id_negocio'] . '" aria-hidden="true">';
                    echo '<div class="modal-dialog">';
                    echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                    echo '<h5 class="modal-title" id="modalLabel' . $negocio['id_negocio'] . '">' . htmlspecialchars($negocio['nombre_negocio']) . '</h5>';
                    echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                    echo '<img width="200px" style="border-radius: 10px;" src="../../uploads/logos/' . htmlspecialchars($negocio['logo']) . '" alt="Logo del negocio">';
                    echo '<p><strong>Descripción:</strong> ' . htmlspecialchars($descripcion) . '</p>';
                    echo '<p><strong>Horario:</strong> ' . htmlspecialchars($negocio['horario']) . '</p>';
                    echo '<p><strong>Ubicación:</strong> ' . htmlspecialchars($negocio['direccion']) . '</p>';
                    echo '<p><strong>Teléfono:</strong> ' . htmlspecialchars($negocio['telefono']) . '</p>';
                    if (!empty($negocio['sitio_web'])) {
                        echo '<p><strong>Sitio Web:</strong> <a href="' . htmlspecialchars($negocio['sitio_web']) . '" target="_blank">' . htmlspecialchars($negocio['sitio_web']) . '</a></p>';
                    }

                    // Sección de fotos
                    echo '<p><strong>Fotos:</strong></p>';
                    echo '<div class="cont-productos">';
                    if (!empty($fotos)) {
                        foreach ($fotos as $foto) {
                            echo '<div class="cont-producto">';
                            echo '<img src="../../uploads/productos/' . htmlspecialchars($foto['foto_producto']) . '" alt="Foto del negocio" width="150px">';
                            echo '<h5 class="nombre-producto">' . htmlspecialchars($foto['nombre_producto']) . '</h5>';
                            echo '<h6><strong>$</strong>' . htmlspecialchars($foto['precio']) . '</h6>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No hay fotos disponibles.</p>';
                    }
                    echo '</div>'; // Fin cont-productos

                    echo '</div>'; // Fin modal-body
                    echo '<div class="modal-footer">';
                    echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>';
                    echo '</div>'; // Fin modal-footer
                    echo '</div>'; // Fin modal-content
                    echo '</div>'; // Fin modal-dialog
                    echo '</div>'; // Fin modal
                }
                echo '</div>'; // Fin cont-negocios
            } else {
                echo "<div class='alert alert-info text-center my-4'>No se encontraron resultados para '" . htmlspecialchars($terminoBusqueda) . "'.</div>";
            }
        }
        ?>
    </div>

    <!-- Menú hamburguesa desplegable -->
    <div class="hamburger-dropdown-menu hide" id="hamburgerDropdownMenu">
        <div class="menu-header">
            <img src="../images/carrito.png" alt="Logo" class="menu-logo" onclick="closeMenu()"> <!-- Imagen con evento de clic -->
            <div class="close-icon" onclick="closeMenu()">X</div> <!-- Icono de "X" con evento de clic -->
        </div>
        <hr class="menu-divider">
        <ul class="lista-menu">
            <?php
            if (isset($_SESSION['rol'])) {
                if ($_SESSION['rol'] == 'admin') {
                    echo '<li class="elementos-menu"><a href="../usuarios/administracion/panel.php">Panel de Administrador</a></li>';
                    echo '<li class="elementos-menu"><a href="../usuarios/clientes/perfil.php">Mi Perfil</a></li>';
                } else {
                    echo '<li class="elementos-menu"><a href="../usuarios/clientes/perfil.php">Mi Perfil</a></li>';
                }
                echo '<li class="elementos-menu"><a href="../../Controlador/logout.php">Cerrar Sesión</a></li>';
            } else {
                echo '<li class="elementos-menu"><a href="../registro.php">Regístrate en Efimarket</a></li>';
                echo '<li class="elementos-menu"><a href="../../login.php">Iniciar Sesión</a></li>';
            }
            ?>
            <li class="elementos-menu"><a href="despensa.php">Despensa</a></li>
            <li class="elementos-menu"><a href="panaderia.php">Panaderías</a></li>
            <li class="elementos-menu"><a href="rapidas.php">Comidas Rápidas</a></li>
            <li class="elementos-menu"><a href="servicios.php">Servicios</a></li>
            <li class="elementos-menu"><a href="frutas.php">Frutas y Verduras</a></li>
            <li class="elementos-menu"><a href="mascotas.php">Tienda de Mascotas</a></li>
            <li class="elementos-menu"><a href="carniceria.php">Carnicería</a></li>
            <li class="elementos-menu"><a href="farmacia.php">Salud y Belleza</a></li>
            <li class="elementos-menu"><a href="ropa.php">Tienda de Ropa</a></li>
        </ul>
    </div>

    <!-- Overlay para el menú hamburguesa -->
    <div id="overlay"></div>

    <!-- Scripts -->
    <script src="../js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>