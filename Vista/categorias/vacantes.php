<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efimarket: Vacantes</title>
    <script src="https://kit.fontawesome.com/a44f9ce7b1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="categorias.css">
    <link rel="icon" type="image/png" href="../images/carrito.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <nav>
        <a class="hamburger link" href="#" onclick="toggleHamburgerMenu()"><i class="fa-solid fa-bars"></i></a>
        <a class="logo link" href="../index.php"><img width="260" src="../images/letras.png" alt=""></a>
        <div class="user-icon" onclick="toggleMenu()">
            <i class="fas fa-user-circle"></i>
            <div class="dropdown-menu" id="dropdownMenu">
                <?php
                session_start();
                if (isset($_SESSION['rol'])) {
                    if ($_SESSION['rol'] == 'admin') {
                        echo '<a href="../usuarios/administracion/panel.php">Panel de Administrador</a>';
                        echo '<a href="../usuarios/clientes/perfil.php">Mi Perfil</a>';
                    } else {
                        echo '<a href="../usuarios/clientes/perfil.php">Mi Perfil</a>';
                    }
                    echo '<a href="../../../Controlador/logout.php">Cerrar Sesión</a>';
                } else {
                    echo '<a href="../login.php">Iniciar Sesión</a>';
                    echo '<a href="../registro.php">Registrarse</a>';
                }
                ?>
            </div>
        </div>
    </nav>

    <?php
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: ../login.php");
        exit();
    }

    require_once '../../Controlador/controladorNegocios.php';
    $controladorNegocios = new ControladorNegocios();

    if (isset($_GET['id_negocio'])) {
        $id_negocio = $_GET['id_negocio'];
        $vacantes = $controladorNegocios->obtenerVacantesPorNegocio($id_negocio);

        if (!empty($vacantes)) {
            echo '<div class="tablaDeVacantes">';
            echo '<div class="vacantesGrid">';
            echo '<div class="header">Nombre del Negocio</div>';
            echo '<div class="header">Descripción</div>';
            echo '<div class="header">Requisitos</div>';
            echo '<div class="header">Salario</div>';
            echo '<div class="header">Acciones</div>';

            foreach ($vacantes as $vacante) {
                echo '<div class="campo">' . htmlspecialchars($vacante['nombre_negocio']) . '</div>';
                echo '<div class="campo">' . htmlspecialchars($vacante['descripcion']) . '</div>';
                echo '<div class="campo">' . htmlspecialchars($vacante['requisitos']) . '</div>';
                echo '<div class="campo">' . htmlspecialchars($vacante['salario']) . '</div>';
                echo '<div class="campo"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#postularModal">Postularse</button></div>';
            }

            echo '</div>'; // .vacantesGrid
            echo '</div>'; // .tablaDeVacantes
        } else {
            echo '<p style="margin-top:100px; text-align:center">No hay vacantes disponibles para este negocio.</p>';
        }
    }
    ?>

    <!-- Modal para Postulación -->
    <div class="modal fade" id="postularModal" tabindex="-1" aria-labelledby="postularModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postularModalLabel">Formulario de Postulación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../Controlador/controladorNegocios.php" method="POST">
                        <input type="hidden" name="action" value="postular">
                        <input type="hidden" name="id_negocio" value="<?php echo htmlspecialchars($id_negocio); ?>">

                        <div class="mb-3">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" required>
                        </div>

                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        </div>

                        <div class="mb-3">
                            <label for="edad" class="form-label">Edad</label>
                            <input type="number" class="form-control" id="edad" name="edad" required>
                        </div>

                        <div class="mb-3">
                            <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                            <select class="form-select" id="tipo_documento" name="tipo_documento" required>
                                <option value="c.c">C.C.</option>
                                <option value="t.i">T.I.</option>
                                <option value="c.e">C.E.</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="documento_identidad" class="form-label">Documento de Identidad</label>
                            <input type="text" class="form-control" id="documento_identidad" name="documento_identidad" required>
                        </div>

                        <div class="mb-3">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="text" class="form-control" id="celular" name="celular" required>
                        </div>

                        <div class="mb-3">
                            <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="acepta_terminos" name="acepta_terminos" required>
                            <label class="form-check-label" for="acepta_terminos">Acepto los términos y condiciones</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="hamburger-dropdown-menu hide" id="hamburgerDropdownMenu">
        <div class="menu-header">
            <img src="../images/carrito.png" alt="Logo" class="menu-logo" onclick="closeMenu()">
            <div class="close-icon" onclick="closeMenu()">X</div>
        </div>
        <hr class="menu-divider">
        <ul class="lista-menu">
            <?php
            if (isset($_SESSION['rol'])) {
                if ($_SESSION['rol'] == 'admin') {
                    echo '<li class="elementos-menu"><a href="../usuarios/administracion/panel.php">Panel de Administrador</a></li>';
                }
                echo '<li class="elementos-menu"><a href="../usuarios/clientes/perfil.php">Mi Perfil</a></li>';
                echo '<li class="elementos-menu"><a href="../../../Controlador/logout.php">Cerrar Sesión</a></li>';
            } else {
                echo '<li class="elementos-menu"><a href="../login.php">Iniciar Sesión</a></li>';
                echo '<li class="elementos-menu"><a href="../registro.php">Registrarse</a></li>';
            }
            ?>
        </ul>
    </div>

    <div id="overlay"></div> <!--para oscurecer la pagina cuando aparezca el menu hamburguesa-->

    <script src="../js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>