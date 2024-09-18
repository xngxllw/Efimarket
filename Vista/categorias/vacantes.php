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
                <div class="header">Acciones</div> <!-- Nueva columna para acciones -->
                <?php if (empty($vacantes)) : ?>
                    <div class="campo" colspan="8">No tienes vacantes creadas. <a href="crearVacante.php">Crear una nueva vacante</a></div>
                <?php else : ?>
                    <?php foreach ($vacantes as $vacante) : ?>
                        <div class="campo"><?php echo htmlspecialchars($vacante['nombre_negocio']); ?></div>
                        <div class="campo"><?php echo htmlspecialchars($vacante['ocupacion']); ?></div>
                        <div class="campo"><?php echo htmlspecialchars($vacante['descripcion']); ?></div>
                        <div class="campo"><?php echo htmlspecialchars($vacante['requisitos']); ?></div>
                        <div class="campo"><?php echo htmlspecialchars($vacante['horario']); ?></div>
                        <div class="campo"><?php echo htmlspecialchars($vacante['salario']); ?></div>
                        <div class="campo"><?php echo htmlspecialchars($vacante['fecha']); ?></div>
                        <div class="campo">
                            <!-- Botón de Editar -->
                            <button class="btn btn-primary" data-toggle="modal" data-target="#editModal<?php echo htmlspecialchars($vacante['id_vacante']); ?>">Editar</button>
                            <!-- Formulario de Borrar -->
                            <form action="borrarVacante.php" method="post" style="display:inline; width:30px; height:30px">
                                <input type="hidden" name="id_vacante" value="<?php echo htmlspecialchars($vacante['id_vacante']); ?>">
                                <button type="submit" class="btn btn-danger">Borrar</button>
                            </form>
                        </div>

                        <!-- Modal para Editar -->
                        <div class="modal fade" id="editModal<?php echo htmlspecialchars($vacante['id_vacante']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar Vacante</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="actualizarVacante.php" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_vacante" value="<?php echo htmlspecialchars($vacante['id_vacante']); ?>">
                                            <div class="form-group">
                                                <label for="ocupacion">Ocupación</label>
                                                <input type="text" class="form-control" id="ocupacion" name="ocupacion" value="<?php echo htmlspecialchars($vacante['ocupacion']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion">Descripción</label>
                                                <textarea class="form-control" id="descripcion" name="descripcion" required><?php echo htmlspecialchars($vacante['descripcion']); ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="requisitos">Requisitos</label>
                                                <textarea class="form-control" id="requisitos" name="requisitos" required><?php echo htmlspecialchars($vacante['requisitos']); ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="horario">Horario</label>
                                                <input type="text" class="form-control" id="horario" name="horario" value="<?php echo htmlspecialchars($vacante['horario']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="salario">Salario</label>
                                                <input type="text" class="form-control" id="salario" name="salario" value="<?php echo htmlspecialchars($vacante['salario']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="fecha">Fecha</label>
                                                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo htmlspecialchars($vacante['fecha']); ?>" required>
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
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>