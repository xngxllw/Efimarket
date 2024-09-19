<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.php");
    exit();
}

// Incluir los archivos necesarios
require_once '../../../Controlador/controladorNegocios.php';
require_once '../../../Modelo/modeloNegocios.php';

// Crear una instancia del controlador de negocios
$controladorNegocios = new ControladorNegocios();

// Obtener el ID de usuario actual
$id_usuario = $_SESSION['id_usuario'];

// Obtener las postulaciones asociadas al usuario actual
$postulaciones = $controladorNegocios->obtenerPostulacionesPorUsuario($id_usuario);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efimarket - Postulaciones</title>
    <link rel="icon" type="image/png" href="../../images/llave.png">
    <link rel="stylesheet" href="admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
    <div class="mensaje-alternativo">
        <p>Este contenido no puede visualizarse en pantallas menores a 920px.</p>
        <a href="panel.php">Volver al panel</a>
    </div>
    <div class="main-content tablaDePostulaciones">
        <header>
            <h1>Postulaciones a mis vacantes de empleo</h1>
            <a href="../../../Controlador/logout.php">Cerrar sesión</a>
        </header>
        <div class="content">
            <div class="tablaPostulaciones">
                <div class="header">Nombre</div>
                <div class="header">Apellidos</div>
                <div class="header">Edad</div>
                <div class="header">Tipo de Documento</div>
                <div class="header">Documento de Identidad</div>
                <div class="header">Celular</div>
                <div class="header">Correo Electrónico</div>
                <div class="header">Nombre del Negocio</div>

                <?php if (isset($postulaciones) && !empty($postulaciones)) : ?>
                    <?php foreach ($postulaciones as $postulacion) : ?>
                        <div class="campo">
                            <?php echo isset($postulacion['nombres']) ? htmlspecialchars($postulacion['nombres']) : 'N/A'; ?>
                        </div>
                        <div class="campo">
                            <?php echo isset($postulacion['apellidos']) ? htmlspecialchars($postulacion['apellidos']) : 'N/A'; ?>
                        </div>
                        <div class="campo">
                            <?php echo isset($postulacion['edad']) ? htmlspecialchars($postulacion['edad']) : 'N/A'; ?>
                        </div>
                        <div class="campo">
                            <?php echo isset($postulacion['tipo_documento']) ? htmlspecialchars($postulacion['tipo_documento']) : 'N/A'; ?>
                        </div>
                        <div class="campo">
                            <?php echo isset($postulacion['documento_identidad']) ? htmlspecialchars($postulacion['documento_identidad']) : 'N/A'; ?>
                        </div>
                        <div class="campo">
                            <?php echo isset($postulacion['celular']) ? htmlspecialchars($postulacion['celular']) : 'N/A'; ?>
                        </div>
                        <div class="campo">
                            <?php echo isset($postulacion['correo_electronico']) ? htmlspecialchars($postulacion['correo_electronico']) : 'N/A'; ?>
                        </div>
                        <div class="campo">
                            <?php
                            // Obtener el nombre del negocio asociado a la postulación
                            $nombre_negocio = $controladorNegocios->obtenerNombreNegocioPorId($postulacion['id_negocio']);
                            echo $nombre_negocio ? htmlspecialchars($nombre_negocio) : 'N/A';
                            ?>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="campo" colspan="8">No hay postulaciones registradas</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>