<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "efimarket");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Obtener datos del usuario de la sesión
$id_usuario = $_SESSION['id_usuario'] ?? ''; // Verifica si $_SESSION['id_usuario'] está definido
$xp = 0;
$rango = '';
$xp_actual = 0;
$xp_siguiente = 0;
$porcentaje = 0;
$imagen_rango = '';

// Función para calcular el rango, XP y asignar la imagen
function calcularRango($xp)
{
    if ($xp >= 0 && $xp < 1000) {
        return ['Bronce ', 0, 1000, 'img/bronce.png'];
    } elseif ($xp >= 1000 && $xp < 2000) {
        return ['Plata', 1000, 2000, 'img/plata.png'];
    } elseif ($xp >= 2000 && $xp < 3000) {
        return ['Oro', 2000, 3000, 'img/oro.png'];
    } elseif ($xp >= 3000 && $xp < 4500) {
        return ['Platino', 3000, 4500, 'img/platino.png'];
    } elseif ($xp >= 4500 && $xp < 7200) {
        return ['Diamante', 4500, 7200, 'img/diamante.png'];
    } elseif ($xp >= 7200 && $xp < 8500) {
        return ['Zafiro I', 7200, 8500, 'img/zafirouno.png'];
    } elseif ($xp >= 8500 && $xp < 10000) {
        return ['Zafiro II', 8500, 10000, 'img/zafirodos.png'];
    } else {
        return ['Zafiro III', 10000, 15000, 'img/zafirotres.png'];
    }
}

if (!empty($id_usuario)) {
    // Consulta para obtener la XP del usuario
    $sql = "SELECT xp FROM usuarios WHERE id_usuario = $id_usuario";
    $result = $conexion->query($sql);

    // Verificar si se encontraron resultados
    if ($result && $result->num_rows > 0) {
        // Obtener los datos de XP
        $row = $result->fetch_assoc();
        $xp = $row["xp"];
        list($rango, $xp_actual, $xp_siguiente, $imagen_rango) = calcularRango($xp);
        $porcentaje = (($xp - $xp_actual) / ($xp_siguiente - $xp_actual)) * 100;
    } else {
        echo "No se encontraron resultados.";
    }
} else {
    echo "Usuario no autenticado.";
}

// Cerrar conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efimarket - Mi Rango</title>
    <link rel="icon" type="image/png" href="../../images/usuario.png">
    <!-- Incluir Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilosPerfil.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="sidebar">
        <a href="../../index.php" class="logo">
            <img src="../../images/letras.png" alt="Efimarket Logo">
        </a>
        <ul class="menu">
            <li><a href="perfil.php">Mi perfil</a></li>
            <li><a href="rangos.php">Rangos</a></li>
            <li><a href="planesClientes.php">Planes</a></li>
        </ul>
    </div>
    <div class="main-content">
        <header>
            <h1>Mi Rango</h1>
            <a href="../../../Controlador/logout.php">Cerrar sesión</a>
        </header>
        <div class="content">
            <!-- Mostrar la imagen del rango -->
            <div class="campo">
                <img src="<?php echo htmlspecialchars($imagen_rango); ?>" alt="Imagen de Rango" class="img-fluid mb-3"
                    style="max-width: 150px;">
            </div>
            <div class="campo">
                <!-- Mostrar el título del rango -->
                <h2><?php echo htmlspecialchars($rango); ?></h2>
            </div>
            <div class="campo">
                <label for="xp">XP Actual:</label>
                <p><?php echo htmlspecialchars($xp); ?> / <?php echo htmlspecialchars($xp_siguiente); ?> XP</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $porcentaje; ?>%;"
                        aria-valuenow="<?php echo $porcentaje; ?>" aria-valuemin="0" aria-valuemax="100">
                        <?php echo round($porcentaje, 2); ?>%
                    </div>
                </div>
            </div>
            <!-- Botón para abrir el modal -->
            <div class="campo mt-4">
                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#xpModal">¿Cómo consigo
                    experiencia?</a>
            </div>
        </div>
    </div>

    <!-- Modal de Bootstrap -->
    <div class="modal fade" id="xpModal" tabindex="-1" role="dialog" aria-labelledby="xpModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="xpModalLabel">¿Cómo consigo experiencia?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>La XP se obtiene de las siguientes maneras:</p>
                    <ul>
                        <li>Calificaciones: 3 estrellas - 100 XP, 4 estrellas - 150 XP, 5 estrellas - 300 XP</li>
                        <li>Por logros especiales en la plataforma</li>
                        <li>Por dar empleo a otros usuarios (Si eres administrador)</li>
                        <li>Por subir todas las fotos requeridas de tu negocio</li>
                        <li>Por alcanzar el máximo de negocios subidos permitidos en tu plan</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>