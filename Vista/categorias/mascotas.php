<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efimarket: Mascotas</title>
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
    <div class="navigation-message">
        <p>Encuentra todo para tu mascota.</p>
    </div>
    <div class="contenedor-negocios">
        <?php
        require_once '../../Controlador/controladorNegocios.php';
        $controladorNegocios = new ControladorNegocios();
        $negocios = $controladorNegocios->obtenerNegociosPorCategoria(7);

        if (empty($negocios)) {
            echo '<p class="no-negocios" style="text-align: center;">No hay negocios disponibles en esta categoría.</p>';
        } else {
            echo '<div class="cont-negocios">';
            foreach ($negocios as $negocio) {
                $descripcion = isset($negocio['descripcion']) ? $negocio['descripcion'] : 'No disponible';
                $fotos = $controladorNegocios->obtenerFotosPorNegocio($negocio['id_negocio']);

                echo '<a href="#" class="negocio" data-bs-toggle="modal" data-bs-target="#modalNegocio' . $negocio['id_negocio'] . '">';
                echo '<img width="150px" height="150px" src="../../uploads/logos/' . $negocio['logo'] . '" alt="Logo del negocio">';
                echo '<div class="nombre-cat">';
                echo '<h5 class="nombreNegocio">' . htmlspecialchars($negocio['nombre_negocio']) . '</h5>';
                echo '<div class="categoriaNegocio">' . htmlspecialchars($negocio['descripcion']) . '</div>';
                echo '</div>';
                echo '<div class="info-negocio">';
                echo '<div class="horario"><i class="fa-solid fa-clock"></i><span>' . htmlspecialchars($negocio['horario']) . '</span></div>';
                echo '<div class="ubicacion"><i class="fa-solid fa-location-dot"></i><span>' . htmlspecialchars($negocio['direccion']) . '</span></div>';
                echo '<div class="telefono"><i class="fa-solid fa-phone"></i><span>' . htmlspecialchars($negocio['telefono']) . '</span></div>';
                echo '</div>';
                echo '</a>';

                echo '<div class="modal fade" id="modalNegocio' . $negocio['id_negocio'] . '" tabindex="-1" aria-labelledby="modalLabel' . $negocio['id_negocio'] . '" aria-hidden="true">';
                echo '<div class="modal-dialog">';
                echo '<div class="modal-content">';
                echo '<div class="modal-header">';
                echo '<h5 class="modal-title" id="modalLabel' . $negocio['id_negocio'] . '">' . htmlspecialchars($negocio['nombre_negocio']) . '</h5>';
                echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                echo '</div>';
                echo '<div class="modal-body">';
                echo '<img width="200px" style="border-radius: 10px;" src="../../uploads/logos/' . $negocio['logo'] . '" alt="Logo del negocio">';
                echo '<p><strong>Descripción:</strong> ' . htmlspecialchars($descripcion) . '</p>';
                echo '<p><strong>Horario:</strong> ' . htmlspecialchars($negocio['horario']) . '</p>';
                echo '<p><strong>Ubicación:</strong> ' . htmlspecialchars($negocio['direccion']) . '</p>';
                echo '<p><strong>Teléfono:</strong> ' . htmlspecialchars($negocio['telefono']) . '</p>';
                echo '<p><strong>Fotos:</strong></p>';
                echo '<div class="cont-productos">';
                if (!empty($fotos)) {
                    foreach ($fotos as $foto) {
                        echo '<div class="cont-producto"> <img src="../../uploads/productos/' . $foto['foto_producto'] . '" alt="Foto del negocio" width="150px">';
                        echo '<h5 class="nombre-producto">' . $foto['nombre_producto'] . '</h5>';
                        echo '<h6><strong>$</strong>' . $foto['precio'] . '</h6> </div>';
                    }
                } else {
                    echo '<p>No hay fotos disponibles.</p>';
                }
                echo '</div>';

                echo '<div class="acciones-section d-flex justify-content-between">';

                if (isset($_SESSION['id_usuario'])) {
                    // La sesión está iniciada, mostrar el botón de reseña
                    echo '<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalResena' . $negocio['id_negocio'] . '">Reseñar</button>';
                } else {
                    // La sesión no está iniciada, redirigir a login al intentar reseñar
                    echo '<button class="btn btn-primary" onclick="window.location.href=\'../login.php\'">Reseñar</button>';
                }

                echo '<a href="vacantes.php?id_negocio=' . $negocio['id_negocio'] . '" class="btn btn-primary">Ver Vacantes</a>';
                echo '</div>';
                echo '</div>';
                echo '<div class="modal-footer">';
                echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

                // Modal para la reseña

                echo '<div class="modal fade" id="modalResena' . $negocio['id_negocio'] . '" tabindex="-1" aria-labelledby="modalResenaLabel' . $negocio['id_negocio'] . '" aria-hidden="true">';
                echo '<div class="modal-dialog">';
                echo '<div class="modal-content">';
                echo '<div class="modal-header">';
                echo '<h5 class="modal-title" id="modalResenaLabel' . $negocio['id_negocio'] . '">Reseñar ' . htmlspecialchars($negocio['nombre_negocio']) . '</h5>';
                echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                echo '</div>';
                echo '<div class="modal-body">';
                echo '<form action="../../Controlador/controladorNegocios.php" method="POST">';
                echo '<input type="hidden" name="action" value="agregar_resena">';
                echo '<input type="hidden" name="id_negocio" value="' . $negocio['id_negocio'] . '">';
                echo '<input type="hidden" name="id_usuario" value="' . htmlspecialchars($_SESSION['id_usuario']) . '">'; // Escapar el ID de usuario para mayor seguridad
                echo '<div class="form-group">';
                echo '<label for="calificacion">Calificación:</label>';
                echo '<select name="calificacion" id="calificacion' . $negocio['id_negocio'] . '" class="form-select" required>';
                for ($i = 1; $i <= 5; $i++) {
                    echo '<option value="' . $i . '">' . $i . ' estrella(s)</option>';
                }
                echo '</select>';
                echo '</div>';
                echo '<div class="form-group">';
                echo '<label for="comentario">Comentario (opcional):</label>';
                echo '<textarea name="comentario" id="comentario' . $negocio['id_negocio'] . '" class="form-control" rows="3"></textarea>';
                echo '</div>';
                echo '<button type="submit" class="btn btn-success mt-3">Enviar reseña</button>';
                echo '</form>';

                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
    </div>

    <div class="hamburger-dropdown-menu hide" id="hamburgerDropdownMenu">
        <div class="menu-header">
            <img src="../images/carrito.png" alt="Logo" class="menu-logo" onclick="closeMenu()"> <!-- Imagen con evento de clic -->
            <div class="close-icon" onclick="closeMenu()">X</div> <!-- Icono de "X" con evento de clic -->
        </div>
        <hr class="menu-divider">
        <ul class="lista-menu">
            <?php
            if (isset($_SESSION['rol'])) {
                if ($_SESSION['rol'] == 'admin') {
                    echo '<li class="elementos-menu"><a href="../usuarios/administracion/panel.php">Panel de Administrador</a></li>';
                    echo '<li class="elementos-menu"><a href="../usuarios/clientes/perfil.php">Mi Perfil</a></li>';
                } else {
                    echo '<li class="elementos-menu"><a href="../usuarios/clientes/perfil.php">Mi Perfil</a></li>';
                }
                echo '<li class="elementos-menu"><a href="../../Controlador/logout.php">Cerrar Sesión</a></li>';
            } else {
                echo '<li class="elementos-menu"><a href="../registro.php">Regístrate en Efimarket</a></li>';
                echo '<li class="elementos-menu"><a href="../../login.php">Iniciar Sesión</a></li>';
            }
            ?>
            <li class="elementos-menu"><a href="despensa.php">Despensa</a></li>
            <li class="elementos-menu"><a href="panaderia.php">Panaderías</a></li>
            <li class="elementos-menu"><a href="rapidas.php">Comidas Rápidas</a></li>
            <li class="elementos-menu"><a href="servicios.php">Servicios</a></li>
            <li class="elementos-menu"><a href="farmacia.php">Salud y Belleza</a></li>
            <li class="elementos-menu"><a href="carniceria.php">Carnicerías</a></li>
            <li class="elementos-menu"><a href="mascotas.php">Mascotas</a></li>
            <li class="elementos-menu"><a href="ropa.php">Ropa y Accesorios</a></li>
            <li class="elementos-menu"><a href="frutas.php">Frutas y Verduras</a></li>
        </ul>
    </div>
    <div id="overlay"></div> <!--para oscurecer la pagina cuando aparezca el menu hamburguesa-->
    <script src="../js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>