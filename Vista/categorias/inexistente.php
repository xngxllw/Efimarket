<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efimarket: No encontrado</title>
    <script src="https://kit.fontawesome.com/a44f9ce7b1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="categorias.css">
    <link rel="icon" type="image/png" href="../images/carrito.png">
    <script src="../js/index.js"></script>
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
                        echo '<a href="../usuarios/administracion/panel.html">Panel de Administrador</a>';
                        echo '<a href="../usuarios/clientes/perfil.html">Mi Perfil</a>';
                    } else {
                        echo '<a href="../usuarios/clientes/perfil.html">Mi Perfil</a>';
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
        <h1 style="margin-top: 100px;">No hay resultados para tu búsqueda</h1>
    </header>
    <a style="font-size: 20px; text-align: center;" href="../index.html">Volver</a>
</body>

</html>