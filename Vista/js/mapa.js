// Función para inicializar el mapa
function initMap() {
  // Coordenadas para el centro del mapa
  let center = { lat: 6.232603, lng: -75.559151 };

  // Opciones del mapa
  let mapOptions = {
    center: center,
    zoom: 17, // Aumentar el nivel de zoom
  };

  // Crear el mapa en el contenedor con id 'map'
  let map = new google.maps.Map(document.getElementById("map"), mapOptions);

  // Datos de los marcadores
  let locations = [
    {
      position: { lat: 6.233158974942667, lng: -75.55669062061736 },
      title: "Ricuras La Milagrosa",
    },
    {
      position: { lat: 6.2322241517949974, lng: -75.55906485209167 },
      title: "Delicias Loreto",
    },
    {
      position: { lat: 6.230265300019864, lng: -75.55705733669103 },
      title: "Barbershop A. Restrepo",
    },
    {
      position: { lat: 6.229120, lng: -75.559080 },
      title: "Eskuadra Mobiliarios",
    },
    {
      position: { lat: 6.230230, lng: -75.558926},
      title: "Milagrito Café",
    },
    {
      position: { lat: 6.229873, lng: -75.559233},
      title: "Supermercado La 30",
    },
    {
      position: { lat: 6.229433, lng: -75.559471},
      title: "Taller Crazy Mechanics"
    },
    {
      position: {lat: 6.229302, lng: -75.559516},
      title: "Tienda de Carnes Loreto"
    },
    {
      position: {lat: 6.230477, lng: -75.561268},
      title: "La Esquina Canina",
    },
  ];

  // Añadir marcadores con InfoWindows
  locations.forEach(function (location) {
    let marker = new google.maps.Marker({
      position: location.position,
      map: map,
      title: location.title,
    });

    let infoWindowContent = `<div style="padding: 1px 5px; font-size: 14px;">${location.title}</div>`;

    let infoWindow = new google.maps.InfoWindow({
      content: infoWindowContent,
    });

    // Mostrar el InfoWindow por defecto (si se desea mostrar siempre)
    infoWindow.open(map, marker);

    // O abrir el InfoWindow al hacer clic en el marcador
    // marker.addListener('click', function() {
    //   infoWindow.open(map, marker);
    // });
  });
}
