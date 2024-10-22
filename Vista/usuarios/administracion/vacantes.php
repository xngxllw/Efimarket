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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../../images/llave.png">

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
    <div class="content">
    <h2>Mis Vacantes</h2>

    <!-- Botón para añadir vacante -->
    <div class="vacantesGrid">
        <div class="header negocio">Negocio</div>
        <div class="header ocupacion">Ocupación</div>
        <div class="header descripcion">Descripción</div>
        <div class="header requisitos">Requisitos</div>
        <div class="header horario">Horario</div>
        <div class="header salario">Salario</div>
        <div class="header fecha">Fecha</div>
        <div class="header acciones">Acciones</div>

        <?php if (empty($vacantes)) : ?>
            <div class="campo" colspan="8">No tienes vacantes creadas.</div>
        <?php else : ?>
            <?php foreach ($vacantes as $vacante) : ?>
                <div class="campo negocio"><?php echo htmlspecialchars($vacante['nombre_negocio']); ?></div>
                <div class="campo ocupacion"><?php echo htmlspecialchars($vacante['ocupacion']); ?></div>
                <div class="campo descripcion"><?php echo htmlspecialchars($vacante['descripcion']); ?></div>
                <div class="campo requisitos"><?php echo htmlspecialchars($vacante['requisitos']); ?></div>
                <div class="campo horario"><?php echo htmlspecialchars($vacante['horario']); ?></div>
                <div class="campo salario"><?php echo htmlspecialchars($vacante['salario']); ?></div>
                <div class="campo fecha"><?php echo htmlspecialchars($vacante['fecha']); ?></div>
                <div class="campo acciones">
                    <div class="cont-accionesVacantes">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#editModal<?php echo htmlspecialchars($vacante['id_vacante']); ?>">Editar</button>
                        <form action="../../../Controlador/controladorNegocios.php" method="post" style="display:inline;">
                            <input type="hidden" name="accion" value="borrar_vacante">
                            <input type="hidden" name="id_vacante" value="<?php echo htmlspecialchars($vacante['id_vacante']); ?>">
                            <button type="submit" class="btn btn-danger">Borrar</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <a style="margin-top:30px" href="crearVacante.php" class="btn btn-primary">Añadir Vacante</a>
</div>


    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>