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
$productos = $controladorNegocios->obtenerProductosPorUsuario   ($_SESSION['id_usuario']); // Obtener productos del usuario actual
$negocios = $controladorNegocios->obtenerNegociosPorUsuario($_SESSION['id_usuario']); // Obtener negocios del usuario actual
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="icon" type="image/png" href="../../images/carrito.png">
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
            <li><a href="../clientes/perfil.php">Mi Perfil</a></li>
        </ul>
    </div>
    <div class="mensaje-alternativo">
        <p>Este contenido no puede visualizarse en pantallas menores a 920px.</p>
        <a href="panel.php">Volver al panel</a>
    </div>
    <div class="main-content tablaDeProductos">
        <header>
            <h1>Gestión de Productos</h1>
            <a href="../../../Controlador/logout.php">Cerrar sesión</a>
        </header>
        <div class="content">
            <div class="tablaProductos">
                <div class="header">Negocio</div>
                <div class="header">Producto</div>
                <div class="header">Foto</div>
                <div class="header">Precio</div>
                <div class="header">Acciones</div>

                <?php if (isset($productos) && !empty($productos)) : ?>
                    <?php foreach ($productos as $producto) : ?>
                        <div class="campo"><?php echo htmlspecialchars($producto['nombre_negocio']); ?></div>
                        <div class="campo"><?php echo htmlspecialchars($producto['nombre_producto']); ?></div>
                        <div class="campo">
                            <img src="../../../uploads/productos/<?php echo htmlspecialchars($producto['foto_producto']); ?>" alt="Producto" style="max-width: 100px; max-height: 100px;">
                        </div>
                        <div class="campo"><?php echo htmlspecialchars(number_format($producto['precio'], 2)); ?> COP</div>
                        <div class="campo">
                            <button class="boton-editar" data-toggle="modal" data-target="#editModal<?php echo htmlspecialchars($producto['id_producto']); ?>">Editar</button>
                            <form action="borrarProducto.php" method="post" class="borrar-cont">
                                <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($producto['id_producto']); ?>">
                                <button type="submit" class="boton-borrar">Borrar</button>
                            </form>
                        </div>

                        <!-- Modal de Edición -->
                        <div class="modal fade" id="editModal<?php echo htmlspecialchars($producto['id_producto']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="actualizarProducto.php" method="post" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($producto['id_producto']); ?>">
                                            <input type="hidden" name="id_negocio" value="<?php echo htmlspecialchars($producto['id_negocio']); ?>"> <!-- Asegúrate de incluir este campo -->
                                            <div class="form-group">
                                                <label for="nombre_producto">Nombre del Producto</label>
                                                <input class="form-editar form-control" type="text" id="nombre_producto" name="nombre_producto" value="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="precio">Precio</label>
                                                <input class="form-editar form-control" type="number" step="0.01" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="foto_producto">Foto del Producto</label>
                                                <input type="file" class="form-control" id="foto_producto" name="foto_producto">
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
                    <div class="campo" colspan="5">No hay productos registrados</div>
                <?php endif; ?>
            </div>
            <button style="margin-top: 30px;" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addProductModal">Agregar Producto</button>
        </div>

        <!-- Modal para Agregar Producto -->
        <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductLabel">Agregar Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="guardarProducto.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="id_negocio">Selecciona el negocio</label>
                                <select class="form-editar form-control" id="id_negocio" name="id_negocio" required>
                                    <?php if (isset($negocios) && !empty($negocios)) : ?>
                                        <?php foreach ($negocios as $negocio) : ?>
                                            <option value="<?php echo htmlspecialchars($negocio['id_negocio']); ?>"><?php echo htmlspecialchars($negocio['nombre_negocio']); ?></option>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <option value="">No tienes negocios registrados</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nombre_producto">Nombre del Producto</label>
                                <input class="form-editar form-control" type="text" id="nombre_producto" name="nombre_producto" required>
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input class="form-editar form-control" type="number" step="0.01" id="precio" name="precio" required>
                            </div>
                            <div class="form-group">
                                <label for="foto_producto">Foto del Producto</label>
                                <input type="file" class="form-control" id="foto_producto" name="foto_producto" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Agregar Producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
