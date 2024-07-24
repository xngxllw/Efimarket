<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efimarket: Loreto</title>
    <link rel="icon" type="image/png" href="images/carrito.png">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a44f9ce7b1.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
        <a class="hamburger link" href="#" onclick="toggleHamburgerMenu()"><i class="fa-solid fa-bars"></i></a>
        <a class="logo link" href="index.php"><img width="260" src="images/letras.png" alt=""></a>
        <div class="user-icon" onclick="toggleMenu()">
            <i class="fas fa-user-circle"></i>
            <div class="dropdown-menu" id="dropdownMenu">
                <?php
                session_start();
                if (isset($_SESSION['rol'])) {
                    if ($_SESSION['rol'] == 'admin') {
                        echo '<a href="../Vista/usuarios/administracion/panel.php">Panel de Administrador</a>';
                        echo '<a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a>';
                    } else {
                        echo '<a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a>';
                    }
                    echo '<a href="../controlador/logout.php">Cerrar Sesión</a>';
                } else {
                    echo '<a href="login.php">Iniciar Sesión</a>';
                    echo '<a href="registro.php">Registrarse</a>';
                }
                ?>
            </div>
        </div>
    </nav>
    <br>
    <div class="hamburger-dropdown-menu hide" id="hamburgerDropdownMenu">
        <div class="menu-header">
            <img src="images/carrito.png" alt="Logo" class="menu-logo" onclick="closeMenu()">
            <div class="close-icon" onclick="closeMenu()">X</div>
        </div>
        <hr class="menu-divider">
        <ul class="lista-menu">
            <?php
            if (isset($_SESSION['rol'])) {
                if ($_SESSION['rol'] == 'admin') {
                    echo '<li class="elementos-menu"><a href="../Vista/usuarios/administracion/panel.php">Panel de Administrador</a></li>';
                    echo '<li class="elementos-menu"><a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a></li>';
                } else {
                    echo '<li class="elementos-menu"><a href="../Vista/usuarios/clientes/perfil.php">Mi Perfil</a></li>';
                }
                echo '<li class="elementos-menu"><a href="../controlador/logout.php">Cerrar Sesión</a></li>';
            } else {
                echo '<li class="elementos-menu"><a href="registro.php">Regístrate en Efimarket</a></li>';
                echo '<li class="elementos-menu"><a href="login.php">Iniciar Sesión</a></li>';
            }
            ?>
            <li class="elementos-menu"><a href="categorias/despensa.php">Despensa</a></li>
            <li class="elementos-menu"><a href="categorias/panaderia.php">Panaderías</a></li>
            <li class="elementos-menu"><a href="categorias/rapidas.php">Comidas Rápidas</a></li>
            <li class="elementos-menu"><a href="categorias/servicios.php">Servicios</a></li>
            <li class="elementos-menu"><a href="categorias/farmacia.php">Farmacia</a></li>
            <li class="elementos-menu"><a href="categorias/carniceria.php">Carnicerías</a></li>
            <li class="elementos-menu"><a href="categorias/mascotas.php">Mascotas</a></li>
            <li class="elementos-menu"><a href="categorias/ropa.php">Ropa y Accesorios</a></li>
            <li class="elementos-menu"><a href="categorias/frutas.php">Frutas</a></li>
        </ul>
    </div>
    <div id="overlay"></div>

    <div style="margin-top: 50px;" class="contenedor-busq">
        <div class="search-input-box">
            <input type="text" placeholder="¿Qué buscas hoy?" />
            <a id="linkBusqueda" href="#">
                <i class="fa-solid fa-magnifying-glass icon"> </i>
            </a>
            <ul class="container-suggestions">
                <li>sugerencia 1</li>
                <li>sugerencia 2</li>
                <li>sugerencia 3</li>
            </ul>
        </div>
    </div>

    <div class="slide">
        <div class="slide-inner">
            <input class="slide-open" type="radio" id="slide-1" name="slide" aria-hidden="true" hidden="" checked="checked">
            <div class="slide-item">
                <img src="images/panaderiaAvila.png" alt="">
            </div>
            <input class="slide-open" type="radio" id="slide-2" name="slide" aria-hidden="true" hidden="">
            <div class="slide-item">
                <img src="images/panaderia Delicias.jpeg">
            </div>
            <input class="slide-open" type="radio" id="slide-3" name="slide" aria-hidden="true" hidden="">
            <div class="slide-item">
                <img src="images/milagrito.jpg">
            </div>
            <label for="slide-3" class="slide-control prev control-1">‹</label>
            <label for="slide-2" class="slide-control next control-1">›</label>
            <label for="slide-1" class="slide-control prev control-2">‹</label>
            <label for="slide-3" class="slide-control next control-2">›</label>
            <label for="slide-2" class="slide-control prev control-3">‹</label>
            <label for="slide-1" class="slide-control next control-3">›</label>
            <ol class="slide-indicador">
                <li>
                    <label for="slide-1" class="slide-circulo">•</label>
                </li>
                <li>
                    <label for="slide-2" class="slide-circulo">•</label>
                </li>
                <li>
                    <label for="slide-3" class="slide-circulo">•</label>
                </li>
            </ol>
        </div>
    </div>
    <br><br>
    <h2 class="titulos">Categorías principales</h2>
    <div class="categorias">
        <div class="categoria">
            <a href="categorias/despensa.php"><img src="images/despensa.jpg" alt=""></a>
            <p>Despensa</p>
        </div>
        <div class="categoria">
            <a href="categorias/panaderia.php"><img src="images/panaderia.jpg" alt=""></a>
            <p>Panadería y Cafetería</p>
        </div>
        <div class="categoria">
            <a href="categorias/rapidas.php"><img src="images/rapidas.jpg" alt=""></a>
            <p>Comidas Rápidas</p>
        </div>
        <div class="categoria">
            <a href="categorias/servicios.php"><img src="images/servicios.jpg" alt=""></a>
            <p>Servicios</p>
        </div>
        <div class="categoria">
            <a href="categorias/farmacia.php"><img src="images/farmacia.jpeg" alt=""></a>
            <p>Farmacia</p>
        </div>
        <div class="categoria">
            <a href="categorias/carniceria.php"><img src="images/carniceria.jpeg" alt=""></a>
            <p>Carnicerías</p>
        </div>
        <div class="categoria">
            <a href="categorias/mascotas.php"><img src="images/mascotas.jpeg" alt=""></a>
            <p>Mascotas</p>
        </div>
        <div class="categoria">
            <a href="categorias/ropa.php"><img src="images/ropa.jpeg" alt=""></a>
            <p>Ropa y Accesorios</p>
        </div>
        <div class="categoria">
            <a href="categorias/frutas.php"><img src="images/frutas.jpg" alt=""></a>
            <p>Frutas y Verduras</p>
        </div>
    </div>
    <!-- <h2 class="titulos">Los combos más apetecidos:</h2>
    <div class="ofertas">
        <a href=""><img class="oferta" src="images/combo1.jpg" alt="Imagen 1"></a>
        <a href=""><img class="oferta" src="images/combo2.jpg" alt="Imagen 2"></a>
        <a href=""><img class="oferta" src="images/combo3.jpg" alt="Imagen 3"></a>
    </div> -->
    <h2 style="text-align: center">No logras ubicarte? Te ayudamos:</h2>
    <div id="map"></div>
    <script src="js/buscador.js"></script>
    <script src="js/sugerencias.js"></script>
    <script src="js/index.js"></script>
    <script src="js/mapa.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdMhWjoJMe-J1QWIZW_37reKryLe-_sLc&callback=initMap">
    </script>
</body>
<!-- <footer>
        <div class="footer-content">
            <div class="footer-section about">
                <h2>Sobre Nosotros</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis commodo orci sed nibh ullamcorper
                    ullamcorper.</p>
                <div class="contact">
                    <span><i class="fas fa-phone"></i> 3196516362</span>
                    <span><i class="fas fa-envelope"></i> efimarket@gmail.com</span>
                </div>
                <div class="social">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="footer-section links">
                <h2>Enlaces útiles</h2>
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Servicios</a></li>
                    <li><a href="#">Productos</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>

            <div class="footer-section contact-form">
                <h2>Contacto</h2>
                <form action="#">
                    <input type="email" name="email" class="text-input contact-input" placeholder="Tu correo electrónico...">
                    <textarea name="message" class="text-input contact-input" placeholder="Tu mensaje..."></textarea>
                    <button type="submit" class="btn btn-big contact-btn">
                        <i class="fas fa-envelope"></i>
                        Enviar
                    </button>
                </form>
            </div>
        </div>

        <div class="footer-bottom">
            &copy; 2024 Efimarket | Todos los derechos reservados
        </div>
    </footer> -->

</html>