function toggleMenu() {
  var dropdownMenu = document.getElementById("dropdownMenu");
  dropdownMenu.style.display === "none"
    ? (dropdownMenu.style.display = "block")
    : (dropdownMenu.style.display = "none");
}

function toggleHamburgerMenu() {
  var menu = document.getElementById("hamburgerDropdownMenu");
  var overlay = document.getElementById("overlay");
  menu.classList.toggle("show");
  overlay.style.display = overlay.style.display === "block" ? "none" : "block";
}

function closeMenu() {
  var menu = document.getElementById("hamburgerDropdownMenu");
  var overlay = document.getElementById("overlay");

  menu.classList.remove("show");
  overlay.style.display = "none"; // Asegúrate de ocultar la capa de oscuridad aquí
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
