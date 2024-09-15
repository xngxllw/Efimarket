<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'admin') {
    header('Location: ../../login.php');
    exit();
}
require_once '../../../Modelo/modelo.php';
$modelo = new Modelo();
$vacantes = $modelo->obtenerVacantesPorNegocio($_SESSION['id_usuario']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacantes - Efimarket</title>
    <link rel="stylesheet" href="admin.css">
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
            <li><a href="../clientes/perfil.php">Mi Perfil</a></li>
            <li><a href="planes.php">Planes</a></li>


        </ul>
    </div>
    <div class="main-content">
        <header>
            <h1>Mis Vacantes</h1>
            <a href="../../../Controlador/logout.php">Cerrar sesión</a>
        </header>
        <div class="content">
            <div class="vacantesGrid">
                <div class="header">Negocio</div>
                <div class="header">Ocupación</div>
                <div class="header">Descripción</div>
                <div class="header">Requisitos</div>
                <div class="header">Horario</div>
                <div class="header">Salario</div>
                <div class="header">Fecha</div>
                <?php if (empty($vacantes)) : ?>
                <div class="campo" colspan="7">No tienes vacantes creadas. <a href="crearVacante.php">Crear una nueva
                        vacante</a></div>
                <?php else : ?>
                <?php foreach ($vacantes as $vacante) : ?>
                <div class="campo"><?php echo htmlspecialchars($vacante['nombre_negocio']); ?></div>
                <div class="campo"><?php echo htmlspecialchars($vacante['ocupacion']); ?></div>
                <div class="campo"><?php echo htmlspecialchars($vacante['descripcion']); ?></div>
                <div class="campo"><?php echo htmlspecialchars($vacante['requisitos']); ?></div>
                <div class="campo"><?php echo htmlspecialchars($vacante['horario']); ?></div>
                <div class="campo"><?php echo htmlspecialchars($vacante['salario']); ?></div>
                <div class="campo"><?php echo htmlspecialchars($vacante['fecha']); ?></div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>