<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Efimarket - Panel de Administrador</title>
  <link rel="icon" type="image/png" href="../../images/llave.png">
  <link rel="stylesheet" href="admin.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body>
  <div class="sidebar">
    <a href="../../index.php" class="logo">
      <img src="../../images/letras.png" alt="Efimarket Logo">
    </a>
    <ul class="menu">
      <li><a href="panel.php">Inicio</a></li>
      <li><a href="negocios.php">Mis Negocios</a></li>
      <li><a href="vacantes.php">Vacantes de Empleo</a></li>
      <li><a href="../clientes/perfil.php">Mi Perfil</a></li>

    </ul>
  </div>
  <div class="main-content">
    <header>
      <h1>Mis Negocios</h1>
      <a href="../controlador/logout.php">Cerrar sesión</a>
    </header>
    <div class="container">
      <?php if (isset($_SESSION['id_usuario']) && $_SESSION['rol'] == 'admin') : ?>
        <h1>Registrar Nuevo Negocio</h1>
        <form action="guardarNegocio.php" method="POST" enctype="multipart/form-data">
          <label for="logo">Logo del Negocio:</label>
          <input type="file" id="logo" name="logo" accept="image/*" required><br><br>

          <label for="nombre_negocio">Nombre del Negocio:</label>
          <input type="text" id="nombre_negocio" name="nombre_negocio" required><br><br>

          <label for="descripcion">Descripción:</label>
          <textarea id="descripcion" name="descripcion" placeholder="Escribe una pequeña descripcion del negocio (Por ejemplo: Tienda de Ropa)" required></textarea><br><br>

          <label for="direccion">Dirección:</label>
          <input type="text" id="direccion" name="direccion" required><br><br>

          <label for="telefono">Teléfono:</label>
          <input type="text" id="telefono" name="telefono" required><br><br>

          <label for="sitio">Sitio Web:</label>
          <input type="text" id="sitio" name="sitio"><br><br>

          <label for="horario">Horario:</label>
          <input type="text" id="horario" name="horario" required><br><br>

          <label for="categoria">Categoría:</label>
          <select id="categoria" name="categoria" required>
            <option value="">Seleccione una categoría</option>
            <option value="1">Despensa</option>
            <option value="2">Panadería</option>
            <option value="3">C. Rápidas</option>
            <option value="4">Servicios</option>
            <option value="5">Farmacia</option>
            <option value="6">Cárnicos</option>
            <option value="7">Mascotas</option>
            <option value="8">Ropa</option>
          </select><br><br>

          <button type="submit" class="boton-subir">Registrar</button>
        </form>
      <?php else : ?>
        <p>Debe iniciar sesión para acceder a esta sección.</p>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>