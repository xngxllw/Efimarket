    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Efimarket: Despensa</title>
        <script src="https://kit.fontawesome.com/a44f9ce7b1.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="categorias.css">
        <link rel="icon" type="image/png" href="../images/carrito.png">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
                        echo '<a href="../../Controlador/logout.php">Cerrar Sesión</a>';
                    } else {
                        echo '<a href="../login.php">Iniciar Sesión</a>';
                        echo '<a href="../registro.php">Registrarse</a>';
                    }
                    ?>
                </div>
            </div>  
        </nav>
        <header>
            <h1>Encuentra tu despensa en el sector Loreto</h1>
        </header>
        <div class="contenedor-negocios">
            <?php
            require_once '../../Controlador/controladorNegocios.php';
            $controladorNegocios = new ControladorNegocios();
            $negocios = $controladorNegocios->obtenerNegociosPorCategoria(1); // Cambia el número según la categoría correcta para despensas

            if (empty($negocios)) {
                echo '<p align="center" class="no-negocios">No hay negocios disponibles en esta categoría.</p>';
            } else {
                echo '<div class="cont-negocios">';
                foreach ($negocios as $negocio) {
                    echo '<a href="#" class="negocio" data-toggle="modal" data-target="#businessModal" data-id="' . htmlspecialchars($negocio['id_negocio']) . '">';
                    echo '<img src="../../uploads/logos/' . $negocio['logo'] . '" alt="">';
                    echo '<h3 class="nombreNegocio">' . htmlspecialchars($negocio['nombre_negocio']) . '</h3>';
                    echo '<div class="categoriaNegocio">' . htmlspecialchars($negocio['descripcion']) . '</div>';
                    echo '<div class="info-negocio">';
                    echo '<div class="horario"><i class="fa-solid fa-clock"></i><span>' . htmlspecialchars($negocio['horario']) . '</span></div>';
                    echo '<div class="ubicacion"><i class="fa-solid fa-location-dot"></i><span>' . htmlspecialchars($negocio['direccion']) . '</span></div>';
                    echo '<div class="ubicacion"><i class="fa-solid fa-phone"></i><span>' . htmlspecialchars($negocio['telefono']) . '</span></div>';
                    echo '</div>';
                    echo '</a>';
                }
                echo '</div>';
            }
            ?>
        </div>
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
                    echo '<li class="elementos-menu"><a href="../login.php">Iniciar Sesión</a></li>';
                }
                ?>
                <li class="elementos-menu"><a href="despensa.php">Despensa</a></li>
                <li class="elementos-menu"><a href="panaderia.php">Panaderías</a></li>
                <li class="elementos-menu"><a href="rapidas.php">Comidas Rápidas</a></li>
                <li class="elementos-menu"><a href="servicios.php">Servicios</a></li>
                <li class="elementos-menu"><a href="mascotas.php">Tienda de Mascotas</a></li>
                <li class="elementos-menu"><a href="carniceria.php">Carniceria</a></li>
                <li class="elementos-menu"><a href="farmacia.php">Farmacias</a></li>
                <li class="elementos-menu"><a href="ropa.php">Tienda de ropa</a></li>
                <li class="elementos-menu"><a href="frutas.php">Frutas y verduras</a></li>
            </ul>
        </div>
        <div id="overlay"></div> <!--para oscurecer la pagina cuando aparezca el menu hamburguesa-->

        <!-- Modal -->
        <div class="modal fade" id="businessModal" tabindex="-1" role="dialog" aria-labelledby="businessModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="businessModalLabel">Detalles del Negocio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        if (isset($_GET['id_negocio'])) {
                            $id_negocio = $_GET['id_negocio'];
                            $controladorNegocios = new ControladorNegocios();
                            $negocio = $controladorNegocios->obtenerNegocioPorId($id_negocio);

                            if ($negocio) {
                                echo '<div style="text-align: center;">';
                                echo '<img src="../../uploads/logos/' . htmlspecialchars($negocio['logo']) . '" alt="Logo del negocio" style="max-width: 200px; max-height: 200px;">';
                                echo '</div>';
                                echo '<h3>' . htmlspecialchars($negocio['nombre_negocio']) . '</h3>';
                                echo '<p><strong>Descripción:</strong> ' . htmlspecialchars($negocio['descripcion']) . '</p>';
                                echo '<p><strong>Dirección:</strong> ' . htmlspecialchars($negocio['direccion']) . '</p>';
                                echo '<p><strong>Teléfono:</strong> ' . htmlspecialchars($negocio['telefono']) . '</p>';
                                echo '<p><strong>Sitio Web:</strong> <a href="' . (strpos($negocio['sitio_web'], 'http') === 0 ? htmlspecialchars($negocio['sitio_web']) : 'https://' . htmlspecialchars($negocio['sitio_web'])) . '" target="_blank">' . htmlspecialchars($negocio['sitio_web']) . '</a></p>';
                                echo '<p><strong>Horario:</strong> ' . htmlspecialchars($negocio['horario']) . '</p>';
                            } else {
                                echo '<p>No se encontró el negocio.</p>';
                            }
                        } else {
                            echo '<p>No se ha proporcionado un ID de negocio.</p>';
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="../js/index.js"></script>
    </body>

    </html>
