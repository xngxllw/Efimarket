<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "u311904283_angelrestrepo", "efimarketTeam2024Colombia123*AZR", "u311904283_efimarket");

// Verificar conexión
if ($conexion->connect_error) {
  die("Error en la conexión: " . $conexion->connect_error);
}

// Obtener datos del usuario de la sesión
$id_usuario = $_SESSION['id_usuario'] ?? ''; // Verifica si $_SESSION['id_usuario'] está definido
$nombre = '';
$correo = '';

if (!empty($id_usuario)) {
  // Consulta para obtener el nombre y correo del usuario
  $sql = "SELECT nombre, correo FROM usuarios WHERE id_usuario = $id_usuario";
  $result = $conexion->query($sql);

  // Verificar si se encontraron resultados
  if ($result && $result->num_rows > 0) {
    // Mostrar los datos del usuario
    $row = $result->fetch_assoc();
    $nombre = $row["nombre"];
    $correo = $row["correo"];
  } else {
    echo "No se encontraron resultados.";
  }
} else {
  echo "Usuario no autenticado.";
}

// Procesar actualización del perfil si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Procesar formulario
  $nombre_nuevo = $conexion->real_escape_string($_POST['nombre']);
  $correo_nuevo = $conexion->real_escape_string($_POST['correo']);
  $contrasena_nueva = $conexion->real_escape_string($_POST['contrasena']);

  $sql = "UPDATE usuarios SET nombre = '$nombre_nuevo', correo = '$correo_nuevo'";
  if (!empty($contrasena_nueva)) {
    $sql .= ", contrasena = '$contrasena_nueva'";
  }
  $sql .= " WHERE id_usuario = $id_usuario";

  if ($conexion->query($sql) === TRUE) {
    // Actualizar variables para reflejar los cambios
    $nombre = $nombre_nuevo;
    $correo = $correo_nuevo;
  } else {
    echo "Error al actualizar el perfil: " . $conexion->error;
  }
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
  <title>Efimarket - Editar Perfil</title>
  <link rel="icon" type="image/png" href="../../images/usuario.png">
  <link rel="stylesheet" href="estilosPerfil.css">
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
  <div class="sidebar">
    <a href="../../index.php" class="logo">
      <img src="../../images/letras.png" alt="Efimarket Logo">
    </a>
    <ul class="menu">
      <?php
      if (isset($_SESSION['rol'])) {
        if ($_SESSION['rol'] == 'admin') {
          echo '<a href=".../../../administracion/panel.php">Panel de Administrador</a>';
          echo '<a href="rangos.php">Rangos</a>';
          echo '<a href="../administracion/planes.php">Planes</a></a>';
        } else {
          echo '<li><a href="planesClientes.php">Planes</a></li>';
          echo '<a href="rangos.php">Rangos</a>';
        }
        echo '<a href="../../../Controlador/logout.php">Cerrar Sesión</a>';
      } else {
        echo '<a href="login.php">Iniciar Sesión</a>';
        echo '<a href="registro.php">Registrarse</a>';
      }
      ?>
    </ul>
  </div>
  <div class="main-content">
    <header>
      <h1>Editar perfil</h1>
      <a href="../../../Controlador/logout.php">Cerrar sesión</a>
    </header>
    <div class="content">
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="campo">
          <label for="nombre">Nombre:</label>
          <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>">
        </div>
        <div class="campo">
          <label for="correo">Correo:</label>
          <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($correo); ?>">
        </div>
        <div class="campo">
          <label for="contrasena">Contraseña:</label>
          <input type="password" id="contrasena" name="contrasena" placeholder="********">
        </div>
        <button type="submit">Actualizar Perfil</button>
      </form>
    </div>
  </div>
</body>

</html>