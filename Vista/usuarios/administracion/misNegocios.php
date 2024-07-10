<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    // Si el usuario no está autenticado, redirigirlo a la página de inicio de sesión
    header("Location: ../../index.php");
    exit();
}

// Incluir los archivos necesarios
require_once '../../../Controlador/controladorNegocios.php';

// Crear una instancia del controlador de negocios
$controladorNegocios = new ControladorNegocios();

// Obtener el ID de usuario actual
$id_usuario = $_SESSION['id_usuario'];

// Obtener los negocios asociados al usuario actual
$negocios = $controladorNegocios->obtenerNegociosPorUsuario($id_usuario);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efimarket - Mis Negocios</title>
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
            <li><a href="negocios.php">Negocios</a></li>
            <li><a href="inventario.php">Inventario</a></li>
            <li><a href="confi.php">Configuración</a></li>
        </ul>
    </div>
    <div class="main-content">
        <header>
            <h1>Mis Negocios</h1>
            <a href="../../../Controlador/logout.php">Cerrar sesión</a>
        </header>
        <div class="content">
            <div class="tablaNegocios">
                <div class="header">Nombre</div>
                <div class="header">Descripcion</div>
                <div class="header">Direccion</div>
                <div class="header">Telefono</div>
                <div class="header">Sitio Web</div>
                <div class="header">Logo</div>
                <div class="header">Horario</div>
                <?php if (isset($negocios) && !empty($negocios)) : ?>
                    <?php foreach ($negocios as $negocio) : ?>
                        <div class="campo"><?php echo $negocio['nombre_negocio']; ?></div>
                        <div class="campo"><?php echo $negocio['descripcion']; ?></div>
                        <div class="campo"><?php echo $negocio['direccion']; ?></div>
                        <div class="campo"><?php echo $negocio['telefono']; ?></div>
                        <div class="campo">
                            <a href="<?php echo strpos($negocio['sitio_web'], 'http') === 0 ? htmlspecialchars($negocio['sitio_web']) : 'https://' . htmlspecialchars($negocio['sitio_web']); ?>" target="_blank">
                                <?php echo htmlspecialchars($negocio['sitio_web']); ?>
                            </a>
                        </div>
                        <div class="campo">
                            <?php if (!empty($negocio['logo'])) : ?>
                                <img src="../../../uploads/logos/<?php echo htmlspecialchars($negocio['logo']); ?>" alt="Logo del negocio" style="max-width: 100px; max-height: 100px;">
                            <?php else : ?>
                                Sin logo
                            <?php endif; ?>
                        </div>
                        <div class="campo"><?php echo $negocio['horario']; ?></div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="campo" colspan="7">No hay negocios registrados</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>