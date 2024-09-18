// Función para alternar la visibilidad del menú desplegable del usuario
function toggleMenu() {
  let dropdownMenu = document.getElementById("dropdownMenu");
  if (dropdownMenu) {
    dropdownMenu.style.display =
      dropdownMenu.style.display === "none" || dropdownMenu.style.display === ""
        ? "block"
        : "none";
  }
}

// Función para alternar el menú hamburguesa
function toggleHamburgerMenu() {
  let menu = document.getElementById("hamburgerDropdownMenu");
  let overlay = document.getElementById("overlay");

  if (menu && overlay) {
    menu.classList.toggle("show");
    overlay.style.display = menu.classList.contains("show") ? "block" : "none";
  }
}

// Función para cerrar el menú hamburguesa
function closeMenu() {
  let menu = document.getElementById("hamburgerDropdownMenu");
  let overlay = document.getElementById("overlay");

  if (menu && overlay) {
    menu.classList.remove("show");
    overlay.style.display = "none";
  }
}

// Manejo del desplazamiento arrastrando el contenedor de negocios
document.addEventListener("DOMContentLoaded", function () {
  const contenedorNegocios = document.querySelector(".cont-negocios");
  if (contenedorNegocios) {
    let inicioX = 0;
    let desplazamientoInicial = 0;
    let estaArrastrando = false;

    contenedorNegocios.addEventListener("mousedown", (e) => {
      estaArrastrando = true;
      inicioX = e.pageX;
      desplazamientoInicial = contenedorNegocios.scrollLeft;
      contenedorNegocios.classList.add("agarrando");
      e.preventDefault();

      document.addEventListener("mousemove", onMouseMove);
      document.addEventListener("mouseup", onMouseUp);
    });

    function onMouseMove(e) {
      if (!estaArrastrando) return;
      const desplazamientoX = e.pageX - inicioX;
      contenedorNegocios.scrollLeft = desplazamientoInicial - desplazamientoX;
    }

    function onMouseUp() {
      estaArrastrando = false;
      contenedorNegocios.classList.remove("agarrando");
      document.removeEventListener("mousemove", onMouseMove);
      document.removeEventListener("mouseup", onMouseUp);
    }
  }
});

// Manejo del desplazamiento arrastrando el contenedor de categorías
document.addEventListener("DOMContentLoaded", function () {
  const contenedorCategorias = document.querySelector(".categorias");
  if (contenedorCategorias) {
    let inicioX = 0;
    let desplazamientoInicial = 0;
    let estaArrastrando = false;

    contenedorCategorias.addEventListener("mousedown", (e) => {
      estaArrastrando = true;
      inicioX = e.pageX;
      desplazamientoInicial = contenedorCategorias.scrollLeft;
      contenedorCategorias.classList.add("agarrando");
      e.preventDefault();

      document.addEventListener("mousemove", onMouseMove);
      document.addEventListener("mouseup", onMouseUp);
    });

    function onMouseMove(e) {
      if (!estaArrastrando) return;
      const desplazamientoX = e.pageX - inicioX;
      contenedorCategorias.scrollLeft = desplazamientoInicial - desplazamientoX;
    }

    function onMouseUp() {
      estaArrastrando = false;
      contenedorCategorias.classList.remove("agarrando");
      document.removeEventListener("mousemove", onMouseMove);
      document.removeEventListener("mouseup", onMouseUp);
    }
  }
});

// Función para alternar la visibilidad del campo de edición
function toggleEdit(field) {
  let textElement = document.getElementById(field + "Text");
  let inputElement = document.getElementById(field + "Input");
  let updateButton = document.getElementById("updateButton");

  if (textElement && inputElement && updateButton) {
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
}

// Función para alternar la visibilidad de la contraseña
function togglePasswordVisibility() {
  let passwordInput = document.getElementById("contrasena");
  let toggleIcon = document
    .getElementById("togglePassword")
    ?.getElementsByTagName("i")[0];

  if (passwordInput && toggleIcon) {
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
}

// Manejo del modal de negocio
document.addEventListener("DOMContentLoaded", function () {
  const negocios = document.querySelectorAll(".negocio");
  const modal = document.getElementById("negocioModal");
  const span = document.getElementsByClassName("close-button")[0];

  if (modal && span) {
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
            document.getElementById("modalDireccion").innerText =
              data.direccion;
            document.getElementById("modalTelefono").innerText = data.telefono;
            document.getElementById("modalSitioWeb").innerText = data.sitio_web;
            document.getElementById("modalHorario").innerText = data.horario;

            const vacantesDiv = document.getElementById("modalVacantes");
            if (vacantesDiv) {
              vacantesDiv.innerHTML = "<h3>Vacantes:</h3>";
              if (data.vacantes.length > 0) {
                data.vacantes.forEach((vacante) => {
                  vacantesDiv.innerHTML += `<p>${vacante.ocupacion}: ${vacante.descripcion}</p>`;
                });
              } else {
                vacantesDiv.innerHTML += "<p>No hay vacantes disponibles.</p>";
              }
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
  }
});
