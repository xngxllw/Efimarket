<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Resto de tu código de controlador.php...
// Configuración de la conexión a la base de datos
$host = 'localhost'; // Cambia esto según tu configuración
$dbname = 'efimarket';
$username = 'root'; // Cambia esto según tu configuración
$password = ''; // Cambia esto según tu configuración

// Crear una nueva conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("No se pudo conectar a la base de datos: " . $e->getMessage());
}

function obtenerPlanUsuario($id_usuario)
{
    global $pdo;
    $sql = "SELECT plan FROM usuarios WHERE id_usuario = :id_usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_usuario' => $id_usuario]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado ? $resultado['plan'] : null;
}
// Verificar si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger datos del formulario
    $correo = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    // Preparar la consulta para insertar los datos
    $sql = "INSERT INTO contacto (correo, mensaje) VALUES (:correo, :mensaje)";
    $stmt = $pdo->prepare($sql);

    // Ejecutar la consulta con los datos del formulario
    $resultado = $stmt->execute([
        ':correo' => $correo,
        ':mensaje' => $mensaje
    ]);

    // Verificar si la inserción fue exitosa
    if ($resultado) {
        // Redirigir a la página de confirmación o mostrar un mensaje de éxito
        header("Location: ../Vista/index.php?contacto=success");
        exit();
    } else {
        echo "Error al enviar el mensaje.";
    }
}
