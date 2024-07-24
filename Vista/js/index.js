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

document.addEventListener("DOMContentLoaded", function () {
  const contenedorNegocios = document.querySelector(".cont-negocios");
  let inicioX = 0;
  let desplazamientoInicial = 0;
  let estaArrastrando = false;

  contenedorNegocios.addEventListener("mousedown", (e) => {
    if (!contenedorNegocios) return;
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
});

document.addEventListener("DOMContentLoaded", function () {
  const contenedorNegocios = document.querySelector(".categorias");
  let inicioX = 0;
  let desplazamientoInicial = 0;
  let estaArrastrando = false;

  contenedorNegocios.addEventListener("mousedown", (e) => {
    if (!contenedorNegocios) return;
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
});

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
