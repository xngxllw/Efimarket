<?php
session_start(); // Asegúrate de que esta línea esté al principio y no se llame más de una vez

// Habilitar la visualización de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si la sesión está configurada correctamente
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'admin') {
    header('Location: ../../login.php');
    exit();
}

require_once '../../../Modelo/modelo.php'; // Asegúrate de que la ruta sea correcta
require_once '../../../Controlador/controladorNegocios.php';

$modelo = new Modelo();
$controladorNegocios = new ControladorNegocios(); // Asegúrate de crear una instancia del controlador
$id_usuario = $_SESSION['id_usuario'];

// Obtener los negocios asociados al usuario
$negocios = $modelo->obtenerNegociosPorUsuario($id_usuario);

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_negocio = $_POST['id_negocio'];
    $ocupacion = $_POST['ocupacion'];
    $descripcion = $_POST['descripcion'];
    $requisitos = $_POST['requisitos'];
    $horario = $_POST['horario'];
    $salario = $_POST['salario'];

    // Verificar el plan del usuario
    $plan_usuario = $controladorNegocios->obtenerPlanUsuario($id_usuario); // Obtener el plan del usuario
    // Definir límites de vacantes por plan
    switch ($plan_usuario) {
        case 1: // Básico
            $limite_vacantes = 3;
            break;
        case 2: // Premium
            $limite_vacantes = 10;
            break;
        case 3: // Ultimate
            $limite_vacantes = 20;
            break;
        default:
            $error = "Plan no válido.";
            break;
    }

    // Contar vacantes existentes en el negocio
    $vacantes_count = $controladorNegocios->contarVacantesPorNegocio($id_negocio); // Debes implementar este método

    // Verificar si se alcanza el límite de vacantes
    if ($vacantes_count >= $limite_vacantes) {
        if ($plan_usuario == 3) { // Ultimate
            $error = "Límite de vacantes alcanzado. No puede agregar más vacantes.";
        } else {
            header("Location: planes.php"); // Redirigir a planes.php
            exit();
        }
    } else {
        // Intentar crear la vacante y manejar errores
        if ($modelo->crearVacante($id_negocio, $ocupacion, $descripcion, $requisitos, $horario, $salario)) {
            header('Location: vacantes.php');
            exit();
        } else {
            $error = "Error al crear la vacante. Por favor, intenta nuevamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Vacante - Efimarket</title>
    <link rel="stylesheet" href="admin.css">

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
    <div class="container">
        <h2>Crear Vacante</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="crearVacante.php" method="POST">
            <div class="input">
                <label for="id_negocio">Negocio:</label>
                <select id="id_negocio" name="id_negocio" required>
                    <?php foreach ($negocios as $negocio) {
                        echo "<option value='{$negocio['id_negocio']}'>{$negocio['nombre_negocio']}</option>";
                    } ?>
                </select>
            </div>
            <div class="input">
                <label for="ocupacion">Ocupación:</label>
                <input placeholder="Ocupacion que buscas" type="text" id="ocupacion" name="ocupacion" required>
            </div>
            <div class="input">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" placeholder="Añade una pequeña descripcion del puesto que buscas" required></textarea>
            </div>
            <div class="input">
                <label for="requisitos">Requisitos:</label>
                <textarea id="requisitos" name="requisitos" placeholder="Escribe los requisitos para el puesto (Por ejemplo: Tener un curso certificado en barismo)" required></textarea>
            </div>
            <div class="input">
                <label for="horario">Horario:</label>
                <input type="text" id="horario" name="horario" placeholder="Horario en el cual necesitas el trabajador" required>
            </div>
            <div class="input">
                <label for="salario">Salario:</label>
                <input type="text" id="salario" name="salario" placeholder="Salario para el puesto" required>
            </div>
            <div class="action">
                <button type="submit" class="btn btn-primary">Crear Vacante</button>
            </div>
        </form>
    </div>
</body>

</html>