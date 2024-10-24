<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efimarket: Loreto</title>
    <?php
    session_start();
    include '../Controlador/controlador.php';
    // Obtener el plan del usuario
    $logo = 'images/letras.png'; // Logo por defecto
    $iconClass = ''; // Clase por defecto para los íconos
    $carritoIcon = 'images/carrito.png'; // Icono de carrito por defecto
    $mensajeBienvenida = "Bienvenido a nuestra plataforma. ¡Explora negocios en el sector Loreto!";
    if (isset($_SESSION['id_usuario'])) {
        $planUsuario = obtenerPlanUsuario($_SESSION['id_usuario']);

        switch ($planUsuario) {
            case 1:
                $logo = 'images/letras.png';
                break;
            case 2:
                $logo = 'images/efimarketpremium.png';
                break;
            case 3:
                $logo = 'images/efimarketgold.png';
                $iconClass = 'gold'; // Clase dorada para íconos
                $carritoIcon = 'images/carritogold.png'; // Icono dorado para carrito
                $mensajeBienvenida = '¡Bienvenido a Efimarket Ultimate! Empieza a explorar tus beneficios';
                $esUltimate = true;
                break;
            default:
                $logo = 'images/letras.png'; // Logo por defecto en caso de error
                break;
        }
    }
    ?>
    <link rel="icon" type="image/png" href="<?php echo $carritoIcon; ?>">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a44f9ce7b1.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Oswald:wght@200..700&display=swap"
        rel="stylesheet">
</head>

<body>
    <nav>
        <a class="hamburger link <?php echo $iconClass; ?>" href="#" onclick="toggleHamburgerMenu()">
            <i class="fa-solid fa-bars <?php echo $iconClass; ?> gold-filter"></i>
        </a>
        <a class="logo link" href="index.php">
            <img width="260" src="<?php echo $logo; ?>" alt="Logo">
        </a>
        <div class="user-icon <?php echo $iconClass; ?>" onclick="toggleMenu()">
            <i class="fas fa-user-circle <?php echo $iconClass; ?> gold-filter"></i>
            <div class="dropdown-menu" id="dropdownMenu">
                <?php
                if (isset($_SESSION['rol'])) {
                    if ($_SESSION['rol'] == 'admin') {
                        echo '<a href="../Vista/usuarios/administracion/panel.php">Panel de Administrador</a>';
                        echo '<a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a>';
                    } else {
                        echo '<a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a>';
                    }
                    echo '<a href="../Controlador/logout.php">Cerrar Sesión</a>';
                } else {
                    echo '<a href="login.php">Iniciar Sesión</a>';
                    echo '<a href="registro.php">Registrarse</a>';
                }
                ?>
            </div>
        </div>
    </nav>

    <!-- Mensaje debajo de la barra de navegación -->
    <div class="navigation-message <?php echo $esUltimate ? 'ultimate' : ''; ?>">
        <?php if ($mensajeBienvenida): ?>
            <p><?php echo $mensajeBienvenida; ?></p>
        <?php endif; ?>
    </div>

    <div class="hamburger-dropdown-menu hide" id="hamburgerDropdownMenu">
        <div class="menu-header">
            <img src="images/carrito.png" alt="Logo" class="menu-logo" onclick="closeMenu()">
            <div class="close-icon" onclick="closeMenu()">X</div>
        </div>
        <hr class="menu-divider">
        <ul class="lista-menu">
            <?php
            if (isset($_SESSION['rol'])) {
                if ($_SESSION['rol'] == 'admin') {
                    echo '<li class="elementos-menu"><a href="../Vista/usuarios/administracion/panel.php">Panel de Administrador</a></li>';
                    echo '<li class="elementos-menu"><a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a></li>';
                    echo '<li class="elementos-menu"><a href="../Vista/usuarios/administracion/planes.php">Planes</a></li>';
                } else {
                    echo '<li class="elementos-menu"><a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a></li>';
                }
                echo '<li class="elementos-menu"><a href="../Controlador/logout.php">Cerrar Sesión</a></li>';
            } else {
                echo '<li class="elementos-menu"><a href="registro.php">Regístrate en Efimarket</a></li>';
                echo '<li class="elementos-menu"><a href="login.php">Iniciar Sesión</a></li>';
                echo '<li class="elementos-menu"><a href="../Vista/usuarios/clientes/planesClientes.php">Planes</a></li>';
            }
            ?>
            <li class="elementos-menu"><a href="categorias/despensa.php">Despensa</a></li>
            <li class="elementos-menu"><a href="categorias/panaderia.php">Panaderías</a></li>
            <li class="elementos-menu"><a href="categorias/rapidas.php">Comidas Rápidas</a></li>
            <li class="elementos-menu"><a href="categorias/servicios.php">Servicios</a></li>
            <li class="elementos-menu"><a href="categorias/farmacia.php">Salud y Belleza</a></li>
            <li class="elementos-menu"><a href="categorias/carniceria.php">Carnicerías</a></li>
            <li class="elementos-menu"><a href="categorias/mascotas.php">Mascotas</a></li>
            <li class="elementos-menu"><a href="categorias/ropa.php">Ropa y Accesorios</a></li>
            <li class="elementos-menu"><a href="categorias/frutas.php">Frutas y Verduras</a></li>
        </ul>
    </div>

    <div id="overlay"></div>


    <div class="contenedor-busq">
        <div class="search-input-box">
            <form action="categorias/resultados.php" method="GET">
                <input cl type="text" name="query" placeholder="¿Qué buscas hoy?" required />
                <button style="display: none;" type="submit">
                    <i class="fa-solid fa-magnifying-glass icon"></i>
                </button>
            </form>
        </div>

    </div>


    <div class="slide">
        <div class="slide-inner">
            <input class="slide-open" type="radio" id="slide-1" name="slide" aria-hidden="true" hidden=""
                checked="checked">
            <div class="slide-item">
                <img src="images/panaderiaAvila.jpg" alt="">
            </div>
            <input class="slide-open" type="radio" id="slide-2" name="slide" aria-hidden="true" hidden="">
            <div class="slide-item">
                <img src="images/esquinaCanina.jpg">
            </div>
            <input class="slide-open" type="radio" id="slide-3" name="slide" aria-hidden="true" hidden="">
            <div class="slide-item">
                <img src="images/milagrito.jpg">
            </div>
            <label for="slide-3" class="slide-control prev control-1">‹</label>
            <label for="slide-2" class="slide-control next control-1">›</label>
            <label for="slide-1" class="slide-control prev control-2">‹</label>
            <label for="slide-3" class="slide-control next control-2">›</label>
            <label for="slide-2" class="slide-control prev control-3">‹</label>
            <label for="slide-1" class="slide-control next control-3">›</label>
            <ol class="slide-indicador">
                <li>
                    <label for="slide-1" class="slide-circulo">•</label>
                </li>
                <li>
                    <label for="slide-2" class="slide-circulo">•</label>
                </li>
                <li>
                    <label for="slide-3" class="slide-circulo">•</label>
                </li>
            </ol>
        </div>
    </div>
    <br><br>
    <h2 class="titulos">Categorías principales</h2>
    <div class="categorias">
        <button class="nav-button left" onclick="moveLeft()">&#60;</button>
        <div class="categoria-container">
            <div class="categoria">
                <a href="categorias/despensa.php"><img src="images/despensa.jpg" alt=""></a>
                <p>Despensa</p>
            </div>
            <div class="categoria">
                <a href="categorias/panaderia.php"><img src="images/panaderia.jpg" alt=""></a>
                <p>Panadería y Cafetería</p>
            </div>
            <div class="categoria">
                <a href="categorias/rapidas.php"><img src="images/rapidas.jpg" alt=""></a>
                <p>Comidas Rápidas</p>
            </div>
            <div class="categoria">
                <a href="categorias/servicios.php"><img src="images/servicios.jpg" alt=""></a>
                <p>Servicios</p>
            </div>
            <div class="categoria">
                <a href="categorias/farmacia.php"><img src="images/farmacia.jpeg" alt=""></a>
                <p>Salud y Belleza</p>
            </div>
            <div class="categoria">
                <a href="categorias/carniceria.php"><img src="images/carniceria.jpeg" alt=""></a>
                <p>Carnicerías</p>
            </div>
            <div class="categoria">
                <a href="categorias/mascotas.php"><img src="images/mascotas.jpeg" alt=""></a>
                <p>Mascotas</p>
            </div>
            <div class="categoria">
                <a href="categorias/ropa.php"><img src="images/ropa.jpeg" alt=""></a>
                <p>Ropa y Accesorios</p>
            </div>
            <div class="categoria">
                <a href="categorias/frutas.php"><img src="images/frutas.jpg" alt=""></a>
                <p>Frutas y Verduras</p>
            </div>
        </div>
        <button class="nav-button right" onclick="moveRight()">&#62;</button>
    </div>

    <h2 style="text-align: center">No logras ubicarte? Te ayudamos:</h2>
    <div id="map"></div>
    <script src="js/buscador.js"></script>
    <script src="js/sugerencias.js"></script>
    <script src="js/index.js"></script>
    <script src="js/mapa.js"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdMhWjoJMe-J1QWIZW_37reKryLe-_sLc&callback=initMap">
    </script>
</body>
<footer>
    <div class="footer-content">
        <div class="footer-section about">
            <h2>Sobre Nosotros</h2>
            <p>Somos un grupo de estudiantes de desarrollo de software que buscan contribuir a la comunidad a través de
                soluciones tecnológicas.</p>
            <div class="contact">
                <span><i class="fas fa-envelope"></i> efimarket@gmail.com</span>
            </div>
            <div class="social">
                <a href="https://instagram.com/efimarket" target="_blank"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <div class="footer-section links">
            <h2>Enlaces útiles</h2>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="https://wa.me/573196516362"><i class="fab fa-whatsapp"></i>Contacto</a></li>
                <li><a href="../Documentos/TerminosYCondicionesEfimarket.pdf"><i class="fa-solid fa-gavel"></i>Términos y Condiciones</a></li>
                <li><a href="../Documentos/TratamientoDeDatosEfimarket.pdf"><i class="fa-solid fa-gavel"></i>Política de Tratamiento de Datos</a></li>
            </ul>
        </div>

        <div class="footer-section contact-form">
            <h2>Contacto</h2>
            <form action="../Controlador/controlador.php" method="POST">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>

                <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" required></textarea>

                <button class="btn btn-primary" type="submit">Enviar</button>
            </form>
        </div>
    </div>

    <div class="footer-bottom">
        &copy; 2024 DIGITAL AZ S.A | Todos los derechos reservados <br>
    </div>
</footer>

</html>