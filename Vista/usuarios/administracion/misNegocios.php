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
        <nav>
            <a class="hamburger link" href="#" onclick="toggleHamburgerMenu()"><i class="fa-solid fa-bars"></i></a>
            <a class="logo link" href="../../index.php"><img width="260" src="../../images/letras.png" alt=""></a>
            <div class="user-icon" onclick="toggleMenu()">
                <i class="fas fa-user-circle"></i>
                <div class="dropdown-menu" id="dropdownMenu">
                    <?php
                    session_start();
                    include('../../../Controlador/controlador.php');

                    if (isset($_SESSION['rol'])) {
                        if ($_SESSION['rol'] == 'admin') {
                            echo '<a href="panel.php">Panel de Administrador</a>';
                            echo '<a href="../clientes/perfil.php">Mi Perfil</a>';
                        } else {
                            echo '<a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a>';
                        }
                        echo '<a href="../../../Controlador/logout.php">Cerrar Sesión</a>';
                    } else {
                        echo '<a href="login.php">Iniciar Sesión</a>';
                        echo '<a href="registro.php">Registrarse</a>';
                    }
                    ?>
                </div>
            </div>
        </nav>



    <div class="hamburger-dropdown-menu h   ide" id="hamburgerDropdownMenu">
        <div class="menu-header">
            <img src="../../images/carrito.png" alt="Logo" class="menu-logo" onclick="closeMenu()">
            <div class="close-icon" onclick="closeMenu()">X</div>
        </div>
        <hr class="menu-divider">
        <ul class="lista-menu">
            <?php
            if (isset($_SESSION['rol'])) {
                if ($_SESSION['rol'] == 'admin') {
                    echo '<li class="elementos-menu"><a href="panel.php">Panel de Administrador</a></li>';
                    echo '<li class="elementos-menu"><a href="../clientes/perfil.php">Mi Perfil</a></li>';
                    echo '<li class="elementos-menu"><a href="planes.php">Planes</a></li>';
                } else {
                    echo '<li class="elementos-menu"><a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a></li>';
                }
                echo '<li class="elementos-menu"><a href="../../../Controlador/logout.php">Cerrar Sesión</a></li>';
            } else {
                echo '<li class="elementos-menu"><a href="../../registro.php">Regístrate en Efimarket</a></li>';
                echo '<li class="elementos-menu"><a href="../../login.php">Iniciar Sesión</a></li>';
            }
            ?>
            <li class="elementos-menu"><a href="../../categorias/despensa.php">Despensa</a></li>
            <li class="elementos-menu"><a href="../../categorias/panaderia.php">Panaderías</a></li>
            <li class="elementos-menu"><a href="../../categorias/rapidas.php">Comidas Rápidas</a></li>
            <li class="elementos-menu"><a href="../../categorias/servicios.php">Servicios</a></li>
            <li class="elementos-menu"><a href="../../categorias/farmacia.php">Farmacia</a></li>
            <li class="elementos-menu"><a href="../../categorias/carniceria.php">Carnicerías</a></li>
            <li class="elementos-menu"><a href="../../categorias/mascotas.php">Mascotas</a></li>
            <li class="elementos-menu"><a href="../../categorias/ropa.php">Ropa y Accesorios</a></li>
            <li class="elementos-menu"><a href="../../categorias/frutas.php">Frutas</a></li>
        </ul>
    </div>
    <div id="overlay"></div>
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

    <div class="main-content tablaDeNegocios">
        <header>
            <h1>Mis Negocios</h1>
            <a href="../../../Controlador/logout.php">Cerrar sesión</a>
        </header>
        <div class="content">
            <div class="tablaNegocios">
                <div class="header-row">
                    <div class="header">Logo</div>
                    <div class="header">Nombre</div>
                    <div class="header">Descripcion</div>
                    <div class="header">Direccion</div>
                    <div class="header">Telefono</div>
                    <div class="header">Sitio Web</div>
                    <div class="header">Horario</div>
                    <div class="header">Acciones</div>
                </div>
                <?php if (isset($negocios) && !empty($negocios)) : ?>
                    <?php foreach ($negocios as $negocio) : ?>
                        <div class="negocio-row">
                            <div class="campo logo">
                                <?php if (isset($negocio['logo']) && !empty($negocio['logo'])) : ?>
                                    <img src="../../../uploads/logos/<?php echo htmlspecialchars($negocio['logo']); ?>"
                                        alt="Logo del negocio" style="max-width: 100px; max-height: 100px;">
                                <?php else : ?>
                                    Sin logo
                                <?php endif; ?>
                            </div>
                            <div class="campo nombre">
                                <?php echo isset($negocio['nombre_negocio']) ? htmlspecialchars($negocio['nombre_negocio']) : 'N/A'; ?>
                            </div>
                            <div class="campo descripcion mobile-hidden">
                                <?php echo isset($negocio['descripcion']) ? htmlspecialchars($negocio['descripcion']) : 'N/A'; ?>
                            </div>
                            <div class="campo direccion mobile-hidden">
                                <?php echo isset($negocio['direccion']) ? htmlspecialchars($negocio['direccion']) : 'N/A'; ?>
                            </div>
                            <div class="campo telefono mobile-hidden">
                                <?php echo isset($negocio['telefono']) ? htmlspecialchars($negocio['telefono']) : 'N/A'; ?>
                            </div>
                            <div class="campo sitio-web mobile-hidden">
                                <a href="<?php echo isset($negocio['sitio_web']) ? (strpos($negocio['sitio_web'], 'http') === 0 ? htmlspecialchars($negocio['sitio_web']) : 'https://' . htmlspecialchars($negocio['sitio_web'])) : '#'; ?>"
                                    target="_blank">
                                    <?php echo isset($negocio['sitio_web']) ? htmlspecialchars($negocio['sitio_web']) : 'N/A'; ?>
                                </a>
                            </div>
                            <div class="campo horario mobile-hidden">
                                <?php echo isset($negocio['horario']) ? htmlspecialchars($negocio['horario']) : 'N/A'; ?>
                            </div>
                            <div class="campo acciones">
                                <button class="boton-editar" data-toggle="modal"
                                    data-target="#editModal<?php echo htmlspecialchars($negocio['id_negocio']); ?>">Editar</button>
                                <form action="borrarNegocio.php" method="post" class="borrar-cont">
                                    <input type="hidden" name="id_negocio"
                                        value="<?php echo htmlspecialchars($negocio['id_negocio']); ?>">
                                    <button type="submit" class="boton-borrar">Borrar</button>
                                </form>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="editModal<?php echo htmlspecialchars($negocio['id_negocio']); ?>"
                            tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <input type="hidden" name="id_negocio"
                                                value="<?php echo htmlspecialchars($negocio['id_negocio']); ?>">
                                            <div class="form-group">
                                                <label for="nombre">Nombre</label>
                                                <input class="form-editar" type="text" class="form-control" id="nombre"
                                                    name="nombre"
                                                    value="<?php echo htmlspecialchars($negocio['nombre_negocio']); ?>"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion">Descripción</label>
                                                <textarea class="form-editar" id="descripcion" name="descripcion"
                                                    required><?php echo htmlspecialchars($negocio['descripcion']); ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="direccion">Dirección</label>
                                                <input type="text" class="form-control" id="direccion" name="direccion"
                                                    value="<?php echo htmlspecialchars($negocio['direccion']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="telefono">Teléfono</label>
                                                <input type="text" class="form-control" id="telefono" name="telefono"
                                                    value="<?php echo htmlspecialchars($negocio['telefono']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="sitio_web">Sitio Web</label>
                                                <input type="text" class="form-control" id="sitio_web" name="sitio_web"
                                                    value="<?php echo htmlspecialchars($negocio['sitio_web']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="logo">Logo</label>
                                                <input type="file" class="form-control" id="logo" name="logo">
                                            </div>
                                            <div class="form-group">
                                                <label for="horario">Horario</label>
                                                <input type="text" class="form-control" id="horario" name="horario"
                                                    value="<?php echo htmlspecialchars($negocio['horario']); ?>" required>
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