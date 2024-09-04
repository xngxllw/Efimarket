<?php
include_once('../../Controlador/controladorNegocios.php');

// Inicializar el controlador
$controlador = new ControladorNegocios();

// Verificar si se ha proporcionado un término de búsqueda
$terminoBusqueda = isset($_GET['query']) ? $_GET['query'] : '';

if (empty($terminoBusqueda)) {
    echo "No se ha proporcionado un término de búsqueda.";
} else {
    // Obtener negocios según el término de búsqueda
    $negocios = $controlador->buscarNegociosConSugerencias($terminoBusqueda);
    
    if (!empty($negocios)) {
        foreach ($negocios as $negocio) {
            echo "<h2>" . htmlspecialchars($negocio['nombre_negocio']) . "</h2>";
            echo "<p>" . htmlspecialchars($negocio['descripcion']) . "</p>";
            echo "<p>Dirección: " . htmlspecialchars($negocio['direccion']) . "</p>";
            echo "<p>Teléfono: " . htmlspecialchars($negocio['telefono']) . "</p>";
            echo "<p>Sitio Web: " . htmlspecialchars($negocio['sitio_web']) . "</p>";
            echo "<p>Horario: " . htmlspecialchars($negocio['horario']) . "</p>";
            echo "<img src='" . htmlspecialchars($negocio['logo']) . "' alt='Logo'>";
        }
    } else {
        echo "No se encontraron resultados para '$terminoBusqueda'.";
    }
}
?>
