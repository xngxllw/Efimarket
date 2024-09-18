<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efimarket - Panel de Administrador</title>
    <link rel="icon" type="image/png" href="../../images/llave.png">
    <link rel="stylesheet" href="admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="sidebar">
        <a href="../../index.php" class="logo">
            <img src="../../images/letras.png" alt="Efimarket Logo">
        </a>
        <ul class="menu">
            <li><a href="panel.php">Inicio</a></li>
            <li><a href="negocios.php">Mis Negocios</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="vacantes.php">Vacantes de Empleo</a></li>
            <li><a href="postulaciones.php">Postulaciones</a></li>

            <li><a href="../clientes/perfil.php">Mi Perfil</a></li>
            <li><a href="planes.php">Planes</a></li>

        </ul>
    </div>
    <div class="main-content">
        <header>
            <h1>Panel de Administrador</h1>
            <a href="../../../Controlador/logout.php">Cerrar sesión</a>
        </header>
        <div class="content">
            <div class="dashboard-buttons">
                <?php if ($_SESSION['rol'] == 'admin') : ?>
                    <a href="crearNegocio.php" class="dashboard-button">Registra un nuevo negocio</a>
                    <a href="misNegocios.php" class="dashboard-button">Ver y editar mis negocios</a>
                <?php else : ?>
                    <p>No tiene permiso para acceder a esta sección.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>