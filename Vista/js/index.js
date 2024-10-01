function toggleMenu() {
  let dropdownMenu = document.getElementById("dropdownMenu");
  dropdownMenu.style.display === "none"
    ? (dropdownMenu.style.display = "block")
    : (dropdownMenu.style.display = "none");
}

function toggleHamburgerMenu() {
  let menu = document.getElementById("hamburgerDropdownMenu");
  menu.classList.toggle("show");

  // Obtener el div overlay
  let overlay = document.getElementById("overlay");

  // Cambiar la propiedad display del overlay
  overlay.style.display = menu.classList.contains("show") ? "block" : "none";
}

function closeMenu() {
  let menu = document.getElementById("hamburgerDropdownMenu");
  menu.classList.remove("show");

  // Obtener el div overlay
  let overlay = document.getElementById("overlay");

  // Ocultar el overlay al cerrar el menú
  overlay.style.display = "none";
}

function toggleEdit(field) {
  let textElement = document.getElementById(field + "Text");
  let inputElement = document.getElementById(field + "Input");
  let updateButton = document.getElementById("updateButton");

  if (
    inputElement.style.display === "none" ||
    inputElement.classList.contains("hidden")
  ) {
    inputElement.classList.remove("hidden");
    textElement.classList.add("hidden");
    updateButton.classList.remove("hidden");
  } else {
    inputElement.classList.add("hidden");
    textElement.classList.remove("hidden");
    if (document.querySelectorAll(".campo input:not(.hidden)").length === 0) {
      updateButton.classList.add("hidden");
    }
  }
}

function togglePasswordVisibility() {
  let passwordInput = document.getElementById("contrasena");
  let toggleIcon = document
    .getElementById("togglePassword")
    .getElementsByTagName("i")[0];

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    toggleIcon.classList.remove("fa-eye-slash");
    toggleIcon.classList.add("fa-eye");
  } else {
    passwordInput.type = "password";
    toggleIcon.classList.remove("fa-eye");
    toggleIcon.classList.add("fa-eye-slash");
  }
}
document.addEventListener("DOMContentLoaded", function () {
  const negocios = document.querySelectorAll(".negocio");
  const modal = document.getElementById("negocioModal");
  const span = document.getElementsByClassName("close-button")[0];

  negocios.forEach((negocio) => {
    negocio.addEventListener("click", function (e) {
      e.preventDefault();
      const idNegocio = this.getAttribute("data-id");
      fetch(
        `../../Controlador/obtenerDetallesNegocio.php?id_negocio=${idNegocio}`
      )
        .then((response) => response.json())
        .then((data) => {
          document.getElementById("modalNombre").innerText =
            data.nombre_negocio;
          document.getElementById("modalDescripcion").innerText =
            data.descripcion;
          document.getElementById("modalDireccion").innerText = data.direccion;
          document.getElementById("modalTelefono").innerText = data.telefono;
          document.getElementById("modalSitioWeb").innerText = data.sitio_web;
          document.getElementById("modalHorario").innerText = data.horario;

          const vacantesDiv = document.getElementById("modalVacantes");
          vacantesDiv.innerHTML = "<h3>Vacantes:</h3>";
          if (data.vacantes.length > 0) {
            data.vacantes.forEach((vacante) => {
              vacantesDiv.innerHTML += `<p>${vacante.ocupacion}: ${vacante.descripcion}</p>`;
            });
          } else {
            vacantesDiv.innerHTML += "<p>No hay vacantes disponibles.</p>";
          }

          modal.style.display = "block";
        });
    });
  });

  span.onclick = function () {
    modal.style.display = "none";
  };

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };
});
let currentPosition = 0; // Posición actual
const maxPosition = 5; // Máximo de categorías visibles
const categoryWidth = 150; // Ancho estimado de cada categoría

function moveLeft() {
  const container = document.querySelector(".categoria-container");
  currentPosition = Math.min(currentPosition + 1, 0); // No permite que vaya más a la izquierda
  container.style.transform = `translateX(${
    currentPosition * categoryWidth
  }px)`;
}

function moveRight() {
  const container = document.querySelector(".categoria-container");
  currentPosition = Math.max(
    currentPosition - 1,
    -(document.querySelectorAll(".categoria").length - maxPosition)
  ); // No permite que vaya más a la derecha
  container.style.transform = `translateX(${
    currentPosition * categoryWidth
  }px)`;
}
