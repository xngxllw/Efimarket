<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efimarket: Loreto</title>
    <link rel="icon" type="image/png" href="../../images/carrito.png">
    <link rel="stylesheet" href="../../style.css">
    <script src="https://kit.fontawesome.com/a44f9ce7b1.js" crossorigin="anonymous"></script>
    <script src="../../js/buscador.js"></script>
    <script src="../../js/index.js"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdMhWjoJMe-J1QWIZW_37reKryLe-_sLc&callback=initMap">
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="admin.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Oswald:wght@200..700&display=swap"
        rel="stylesheet">
</link>
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
                        echo '<a href="../Vista/usuarios/administracion/panel.php">Panel de Administrador</a>';
                        echo '<a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a>';
                    } else {
                        echo '<a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a>';
                    }
                    echo '<a href="../controlador/logout.php">Cerrar Sesión</a>';
                } else {
                    echo '<a href="login.php">Iniciar Sesión</a>';
                    echo '<a href="registro.php">Registrarse</a>';
                }
                ?>
            </div>
        </div>
    </nav>

    <?php
    if (isset($_SESSION['id_usuario'])) {
        $userId = $_SESSION['id_usuario'];
        $plan = obtenerPlanUsuario($userId);

        // Determinar el nombre del plan
        $planNombre = '';
        switch ($plan) {
            case 1:
                $planNombre = 'Básico';
                break;
            case 2:
                $planNombre = 'Premium';
                break;
            case 3:
                $planNombre = 'Ultimate';
                break;
            default:
                $planNombre = 'Sin Plan';
                break;
        }
    ?>
    <h2 style="margin: 100px 0 0 60px">Plan Actual: <?php echo $planNombre; ?></h2>
    <?php
    }
    ?>

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
                    echo '<li class="elementos-menu"><a href="planes.php">Planes</a></li>';
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
    <div class="plans">
        <!-- Plan Básico para Clientes -->
        <div class="plan">
            <div class="plan-header">
                <h2>Plan Cliente Básico</h2>
            </div>
            <ul>
                <li>Acceso a todos los negocios registrados</li>
                <li>Acceso a reseñas y comparaciones de negocios</li>
                <li>Acceso a productos de cada negocio</li>
                <li>Postularse a vacantes de empleo</li>
            </ul>
        </div>

        <!-- Plan Cliente Premium -->
        <div class="plan">
            <div class="plan-header">
                <h2>Plan Cliente Premium - $19.999</h2>
            </div>
            <ul>
                <li>Acceso a todos los negocios registrados</li>
                <li>Acceso a reseñas y comparaciones de negocios</li>
                <li>Acceso a productos de cada negocio</li>
                <li>Soporte técnico prioritario</li>
                <li>Prioridad en postulaciones de empleo</li>
                <li>Prioridad al reseñar</li>
                <li>Un cupón de descuento en negocios seleccionados</li>
            </ul>
            <a style="margin-top:33px;" href="../administracion/pagarpremium.php" class="planbutton">Contratar Plan Premium</a>
        </div>

        <!-- Plan Cliente Ultimate -->
        <div class="plan">
            <div class="plan-header">
                <h2>Plan Cliente Ultimate - $29.999</h2>
            </div>
            <ul>
                <li>Acceso a todos los negocios registrados</li>
                <li>Acceso a reseñas y comparaciones de negocios</li>
                <li>Acceso a productos de cada negocio</li>
                <li>Soporte técnico prioritario</li>
                <li>Prioridad en postulaciones de empleo</li>
                <li>Prioridad al reseñar</li>
                <li>Dos cupones de descuento en negocios seleccionados</li>
                <li>Acceso exclusivo a eventos y promociones</li>
                <li>Asesoramiento personalizado</li>
            </ul>
            <a style="margin-top:33px;" href="../administracion/pagarultimate.php" class="planbutton">Contratar Plan Ultimate</a>
        </div>
    </div>
</body>

</html>
