<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión en Efimarket</title>
    <link rel="icon" type="image/png" href="images/carrito.png">
    <link rel="stylesheet" href="form.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a44f9ce7b1.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
        <a class="hamburger link" href="#" onclick="toggleHamburgerMenu()"><i class="fa-solid fa-bars"></i></a>
        <a class="logo link" href="index.php"><img width="260" src="images/letras.png" alt=""></a>
        <div class="user-icon" onclick="toggleMenu()">
            <i class="fas fa-user-circle"></i>
            <div class="dropdown-menu" id="dropdownMenu">
                <?php
                session_start();
                if (isset($_SESSION['rol'])) {
                    if ($_SESSION['rol'] == 'admin') {
                        echo '<a href="../Vista/usuarios/administracion/panel.php">Panel de Administrador</a>';
                        echo '<a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a>';
                    } else {
                        echo '<a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a>';
                    }
                    echo '<a href="../controlador/logout.php">Cerrar Sesión</a>';
                } else {
                    echo '<a href="index.php">Volver a la página principal</a>';
                    echo '<a href="registro.php">Registrarse</a>';
                }
                ?>
            </div>
        </div>
    </nav>
    <br>
    <div class="hamburger-dropdown-menu hide" id="hamburgerDropdownMenu">
        <div class="menu-header">
            <img src="images/carrito.png" alt="Logo" class="menu-logo" onclick="closeMenu()"> <!-- Imagen con evento de clic -->
            <div class="close-icon" onclick="closeMenu()">X</div> <!-- Icono de "X" con evento de clic -->
        </div>
        <hr class="menu-divider">
        <ul class="lista-menu">
            <?php
            if (isset($_SESSION['rol'])) {
                if ($_SESSION['rol'] == 'admin') {
                    echo '<li class="elementos-menu"><a href="usuarios/administracion/panel.php">Panel de Administrador</a></li>';
                    echo '<li class="elementos-menu"><a href="usuarios/clientes/perfil.php">Mi Perfil</a></li>';
                } else {
                    echo '<li class="elementos-menu"><a href="usuarios/clientes/perfil.php">Mi Perfil</a></li>';
                }
                echo '<li class="elementos-menu"><a href="../controlador/logout.php">Cerrar Sesión</a></li>';
            } else {
                echo '<li class="elementos-menu"><a href="registro.php">Regístrate en Efimarket</a></li>';
            }
            ?>
            <li class="elementos-menu"><a href="categorias/despensa.php">Despensa</a></li>
            <li class="elementos-menu"><a href="categorias/panaderia.php">Panaderías</a></li>
            <li class="elementos-menu"><a href="categorias/rapidas.php">Comidas Rápidas</a></li>
            <li class="elementos-menu"><a href="categorias/servicios.php">Servicios</a></li>
            <li class="elementos-menu"><a href="categorias/farmacia.php">Farmacia</a></li>
            <li class="elementos-menu"><a href="categorias/carniceria.php">Carnicos</a></li>
            <li class="elementos-menu"><a href="categorias/mascotas.php">Mascotas</a></li>
            <li class="elementos-menu"><a href="categorias/ropa.php">Ropa y Accesorios</a></li>
            <li class="elementos-menu"><a href="categorias/frutas.php">Frutas</a></li>
        </ul>
    </div>
    <div id="overlay"></div>
    <div class="container">
        <div class="card">
            <div class="card-image">
                <h2 class="card-heading">
                    Bienvenido de vuelta
                    <small>Inicia Sesión en Efimarket</small>
                </h2>
            </div>
            <form action="../Controlador/iniciaSesion.php" method="post" class="card-form">
                <input maxlength="50" type="hidden" name="accion" value="iniciar_sesion">
                <div class="input">
                    <input maxlength="50" type="text" id="correo" name="correo" class="input-field" required />
                    <label for="correo" class="input-label">Correo</label>
                </div>
                <div class="input">
                    <input maxlength="25" type="password" class="input-field" id="contrasena" name="contrasena" required />
                    <label for="contrasena" class="input-label">Ingresa tu Contraseña</label>
                    <span id="togglePassword" class="password-toggle" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye-slash"></i>
                    </span>
                </div>

                <div class="action">
                    <button type="submit" class="action-button">Continúa</button>
                </div>
            </form>
            <div class="card-info">
                <p>¿Aún no tienes una cuenta en Efimarket? <a href="registro.php">¡Registrate!</a></p>
            </div>
        </div>
    </div>
    <script src="js/buscador.js"></script>
    <script src="js/sugerencias.js"></script>
    <script src="js/index.js"></script>
</body>

</html>