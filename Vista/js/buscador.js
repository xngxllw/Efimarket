const searchContainer = document.querySelector(".search-input-box");
const inputSearch = searchContainer.querySelector("input");
const boxSuggestions = document.querySelector(".container-suggestions");

inputSearch.onkeyup = (e) => {
  let userData = e.target.value.toLowerCase(); // Convertir a minúsculas
  let emptyArray = [];

  if (userData) {
    emptyArray = suggestions.filter((data) => {
      return data.toLowerCase().startsWith(userData); // Convertir a minúsculas
    });

    emptyArray = emptyArray.map((data) => {
      return `<li onclick="select(this)">${data}</li>`; // Add onclick event
    });

    searchContainer.classList.add("active");
    showSuggestions(emptyArray);

    let allList = boxSuggestions.querySelectorAll("li");

    allList.forEach((li) => {
      li.setAttribute("onclick", "select(this)"); // Add onclick event
    });
  } else {
    searchContainer.classList.remove("active");
  }
};

function select(element) {
  let selectUserData = element.textContent.toLowerCase(); // Convertir a minúsculas
  inputSearch.value = selectUserData;

  let searchLink = document.getElementById("linkBusqueda");

  // Redirigir a las páginas locales según las sugerencias
  switch (selectUserData) {
    case "panaderías":
    case "ricuras la milagrosa":
    case "delicias loreto":
    case "pan":
    case "café":
    case "buñuelos":
    case "tinto":
      searchLink.href = "../Vista/categorias/panaderia.php";
      break;
    case "barbershop angel restrepo":
    case "barberia":
    case "barber":
    case "barbero":
    case "corte":
    case "motilado":
      searchLink.href = "../Vista/categorias/servicios.php";
      break;
    case "carniceria":
    case "carnes":
    case "cerdo":
    case "Res":
      searchLink.href = "../Vista/categorias/carniceria.php";
      break;
    case "frutas":
    case "papa":
    case "bananos":
    case "verduras":
    case "mercado":
    case "verduras":
      searchLink.href = "../Vista/categorias/frutas.php";
      break;
    case "mercado":
    case "mercar":
    case "supermercado":
    case "arroz":
    case "panela":
    case "market":
    case "aceite":
    case "grano":
      searchLink.href = "../Vista/categorias/despensa.php";
      break;
    case "cuido":
    case "mascotas":
    case "perro":
    case "gatos":
    case "galleticas":
    case "pañuelos":
    case "collares":
      searchLink.href = "../Vista/categorias/mascotas.php";
      break;
    case "hamburguesas":
    case "comidas":
    case "salchipapas":
    case "fritos":
    case "empanadas":
    case "buñuelos":

    default:
      searchLink.href = `../Vista/categorias/inexistente.php`;
      break;
  }

  searchContainer.classList.remove("active");
}

const showSuggestions = (list) => {
  let listData;

  if (!list.length) {
    listData = `<li>${inputSearch.value}</li>`;
  } else {
    listData = list.join(" ");
  }

  boxSuggestions.innerHTML = listData;
};

let suggestions = [
  "Panaderías",
  "Ricuras La Milagrosa",
  "Delicias Loreto",
  "Barbershop Angel Restrepo",
  "Pan",
  "Café",
  "Carne",
  "Carniceria",
  "Buñuelos",
  "Hamburguesas",
  "Cuido",
  "Carnes",
  "Arroz",
  "Aceite",
  "Gatos",
  "Perros",
  "Fritos",
  "Empanadas",
  "Mercar",
  "Mercado",
  "Tintos",
  "Corte",
  "Motilado",
];
