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
            <li><a href="vacantes.php">Vacantes de Empleo</a></li>
            <li><a href="../clientes/perfil.php">Mi Perfil</a></li>
        </ul>
    </div>
    <div class="mensaje-alternativo">
        <p>Este contenido no puede visualizarse en pantallas menores a 920px.</p>
        <a href="panel.php">Volver al panel</a>
    </div>
    <div class="main-content tablaDeNegocios">
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
                <div class="header">Acciones</div>
                <?php if (isset($negocios) && !empty($negocios)) : ?>
                    <?php foreach ($negocios as $negocio) : ?>
                        <div class="campo"><?php echo isset($negocio['nombre_negocio']) ? htmlspecialchars($negocio['nombre_negocio']) : 'N/A'; ?></div>
                        <div class="campo"><?php echo isset($negocio['descripcion']) ? htmlspecialchars($negocio['descripcion']) : 'N/A'; ?></div>
                        <div class="campo"><?php echo isset($negocio['direccion']) ? htmlspecialchars($negocio['direccion']) : 'N/A'; ?></div>
                        <div class="campo"><?php echo isset($negocio['telefono']) ? htmlspecialchars($negocio['telefono']) : 'N/A'; ?></div>
                        <div class="campo">
                            <a href="<?php echo isset($negocio['sitio_web']) ? (strpos($negocio['sitio_web'], 'http') === 0 ? htmlspecialchars($negocio['sitio_web']) : 'https://' . htmlspecialchars($negocio['sitio_web'])) : '#'; ?>" target="_blank">
                                <?php echo isset($negocio['sitio_web']) ? htmlspecialchars($negocio['sitio_web']) : 'N/A'; ?>
                            </a>
                        </div>
                        <div class="campo">
                            <?php if (isset($negocio['logo']) && !empty($negocio['logo'])) : ?>
                                <img src="../../../uploads/logos/<?php echo htmlspecialchars($negocio['logo']); ?>" alt="Logo del negocio" style="max-width: 100px; max-height: 100px;">
                            <?php else : ?>
                                Sin logo
                            <?php endif; ?>
                        </div>
                        <div class="campo"><?php echo isset($negocio['horario']) ? htmlspecialchars($negocio['horario']) : 'N/A'; ?></div>
                        <div class="campo">
                            <button class="boton-editar" data-toggle="modal" data-target="#editModal<?php echo htmlspecialchars($negocio['id_negocio']); ?>">Editar</button>
                            <form action="borrarNegocio.php" method="post" class="borrar-cont"">
                                <input type="hidden" name="id_negocio" value="<?php echo htmlspecialchars($negocio['id_negocio']); ?>">
                                <button type="submit" class="boton-borrar">Borrar</button>
                            </form>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal<?php echo htmlspecialchars($negocio['id_negocio']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar Negocio</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="actualizarNegocio.php" method="post" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_negocio" value="<?php echo htmlspecialchars($negocio['id_negocio']); ?>">
                                            <div class="form-group">
                                                <label for="nombre">Nombre</label>
                                                <input class="form-editar" type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($negocio['nombre_negocio']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion">Descripción</label>
                                                <textarea class="form-editar" id="descripcion" name="descripcion" required><?php echo htmlspecialchars($negocio['descripcion']); ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="direccion">Dirección</label>
                                                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($negocio['direccion']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="telefono">Teléfono</label>
                                                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($negocio['telefono']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="sitio_web">Sitio Web</label>
                                                <input type="text" class="form-control" id="sitio_web" name="sitio_web" value="<?php echo htmlspecialchars($negocio['sitio_web']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="logo">Logo</label>
                                                <input type="file" class="form-control" id="logo" name="logo">
                                            </div>
                                            <div class="form-group">
                                                <label for="horario">Horario</label>
                                                <input type="text" class="form-control" id="horario" name="horario" value="<?php echo htmlspecialchars($negocio['horario']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="campo" colspan="8">No hay negocios registrados</div>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
