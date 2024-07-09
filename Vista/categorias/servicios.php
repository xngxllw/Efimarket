<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efimarket: Servicios</title>
    <script src="https://kit.fontawesome.com/a44f9ce7b1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="categorias.css">
    <link rel="icon" type="image/png" href="../images/carrito.png">
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
        <h1>Servicios esenciales en Loreto!</h1>
    </header>
    <h2 class="subtitulo">Para tu cuidado y estética personal</h2>
    <div class="contenedor-negocios">
        <div class="cont-negocios">
            <a href="#" class="negocio">
                <img src="img/barbershopangel.jpg" alt="">
                <h3 class="nombreNegocio">Barbershop A. Restrepo</h3>
                <div class="categoriaNegocio">Barbería</div>
                <div class="info-negocio">
                    <div class="horario"><i class="fa-solid fa-clock"></i><span>Sabados y Domingos</span></div>
                    <div class="ubicacion"><i class="fa-solid fa-location-dot"></i><span>Antares</span></div>
                </div>
                <a href="#" class="negocio">
                <img src="img/crazymechanics.jpg" alt="">
                <h3 class="nombreNegocio">Crazy Mechanics</h3>
                <div class="categoriaNegocio">Taller de Motos</div>
                <div class="info-negocio">
                    <div class="horario"><i class="fa-solid fa-clock"></i><span>8:00am a 7:00pm</span></div>
                    <div class="ubicacion"><i class="fa-solid fa-location-dot"></i><span>Cra 30 #32 17</span></div>
                </div>
            </a>

        </div>
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
            <li class="elementos-menu"><a href="categorias/fruver.php">Despensa</a></li>
            <li class="elementos-menu"><a href="categorias/panaderia.php">Panaderías</a></li>
            <li class="elementos-menu"><a href="categorias/rapidas.php">Comidas Rápidas</a></li>
            <li class="elementos-menu"><a href="categorias/servicios.php">Servicios</a></li>
            <li class="elementos-menu"><a href="mascotas.php">Tienda de Mascotas</a></li>
            <li class="elementos-menu"><a href="carniceria.php">Carniceria</a></li>
            <li class="elementos-menu"><a href="farmacia.php">Farmacias</a></li>
            <li class="elementos-menu"><a href="ropa.php">Tienda de ropa</a></li>
            <li class="elementos-menu"><a href="frutas.php">Frutas y verduras</a></li>
        </ul>
    </div>
    <div id="overlay"></div> <!--para oscurecer la pagina cuando aparezca el menu hamburguesa-->
    <script src="../js/index.js"></script>
</body>

</html>