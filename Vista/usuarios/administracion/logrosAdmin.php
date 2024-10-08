<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efimarket: Logros</title>
    <link rel="icon" type="image/png" href="../../images/carrito.png">
    <link rel="stylesheet" href="../../style.css">
    <script src="https://kit.fontawesome.com/a44f9ce7b1.js" crossorigin="anonymous"></script>
    <script src="../../js/buscador.js"></script>
    <script src="../../js/index.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@100;400;700&family=Montserrat:wght@100;900&display=swap"
        rel="stylesheet">
</head>

<body>
    <nav>
        <a class="hamburger link" href="#" onclick="toggleHamburgerMenu()"><i class="fa-solid fa-bars"></i></a>
        <a class="logo link" href="../../index.php"><img width="260" src="../../images/letras.png" alt=""></a>
        <div class="user-icon" onclick="toggleMenu()">
            <i class="fas fa-user-circle"></i>
            <div class="dropdown-menu" id="dropdownMenu">
                <?php
                session_start();
                include('../../../Controlador/controlador.php');

                if (isset($_SESSION['rol'])) {
                    if ($_SESSION['rol'] == 'admin') {
                        echo '<a href="panel.php">Panel de Administrador</a>';
                        echo '<a href="../clientes/perfil.php">Mi Perfil</a>';
                    } else {
                        echo '<a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a>';
                    }
                    echo '<a href="../../../Controlador/logout.php">Cerrar Sesión</a>';
                } else {
                    echo '<a href="login.php">Iniciar Sesión</a>';
                    echo '<a href="registro.php">Registrarse</a>';
                }
                ?>
            </div>
        </div>
    </nav>

    <div class="hamburger-dropdown-menu hide" id="hamburgerDropdownMenu">
        <div class="menu-header">
            <img src="../../images/carrito.png" alt="Logo" class="menu-logo" onclick="closeMenu()">
            <div class="close-icon" onclick="closeMenu()">X</div>
        </div>
        <hr class="menu-divider">
        <ul class="lista-menu">
            <?php
            if (isset($_SESSION['rol'])) {
                if ($_SESSION['rol'] == 'admin') {
                    echo '<li class="elementos-menu"><a href="panel.php">Panel de Administrador</a></li>';
                    echo '<li class="elementos-menu"><a href="../clientes/perfil.php">Mi Perfil</a></li>';
                } else {
                    echo '<li class="elementos-menu"><a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a></li>';
                }
                echo '<li class="elementos-menu"><a href="../../../Controlador/logout.php">Cerrar Sesión</a></li>';
            } else {
                echo '<li class="elementos-menu"><a href="../../registro.php">Regístrate en Efimarket</a></li>';
                echo '<li class="elementos-menu"><a href="../../login.php">Iniciar Sesión</a></li>';
            }
            ?>
            <li class="elementos-menu"><a href="../../categorias/despensa.php">Despensa</a></li>
            <li class="elementos-menu"><a href="../../categorias/panaderia.php">Panaderías</a></li>
            <li class="elementos-menu"><a href="../../categorias/rapidas.php">Comidas Rápidas</a></li>
            <li class="elementos-menu"><a href="../../categorias/servicios.php">Servicios</a></li>
            <li class="elementos-menu"><a href="../../categorias/farmacia.php">Farmacia</a></li>
            <li class="elementos-menu"><a href="../../categorias/carniceria.php">Carnicerías</a></li>
            <li class="elementos-menu"><a href="../../categorias/mascotas.php">Mascotas</a></li>
            <li class="elementos-menu"><a href="../../categorias/ropa.php">Ropa y Accesorios</a></li>
            <li class="elementos-menu"><a href="../../categorias/frutas.php">Frutas</a></li>
        </ul>
    </div>

    <div id="overlay"></div>

    <div class="logros-container">
        <h1>Logros de Usuario</h1>
        <div class="logro">
            <h3>Reseñar 3 Negocios</h3>
            <p>50 EXP</p>
        </div>

        <div class="logro">
            <h3>Agregar 5 productos</h3>
            <p>100 EXP</p>
        </div>

        <div class="logro">
            <h3>Gestionar 2 negocios</h3>
            <p>150 EXP</p>
        </div>

        <div class="logro">
            <h3>Postularse a 3 vacantes</h3>
            <p>75 EXP</p>
        </div>

        <div class="logro">
            <h3>Comentar 10 veces en negocios</h3>
            <p>200 EXP</p>
        </div>

        <div class="logro">
            <h3>Actualizar productos en un negocio</h3>
            <p>50 EXP</p>
        </div>

        <div class="logro">
            <h3>Desbloquear 5 logros</h3>
            <p>300 EXP</p>
        </div>
    </div>

</body>

</html>
