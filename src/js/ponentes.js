(function () {
  const ponentesInput = document.querySelector("#ponentes");
  if (ponentesInput) {
    let ponentes = [];
    let ponentesFiltrados = [];
    const listadoPonentes = document.querySelector("#listado-ponentes");
    const ponenteHidden = document.querySelector('[name="ponente_id"]');

    obtenerPonentes();

    ponentesInput.addEventListener("input", buscarPonente);

    async function obtenerPonentes() {
      const url = `/api/ponentes`;
      const respuesta = await fetch(url);
      const resultado = await respuesta.json();

      formatearPonentes(resultado);
    }

    function formatearPonentes(arrayPonentes = []) {
      ponentes = arrayPonentes.map((ponente) => {
        return {
          nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
          id: ponente.id,
        };
      });
    }

    function buscarPonente(e) {
      // Obtenemos lo que ingresa el usuario caracter por caracter
      const busqueda = e.target.value;
      // Si busqueda tiene mas de tres caracteres empieza a buscar.
      if (busqueda.length > 3) {
        // Creamos la expresion regular ignorando que sean mayusculas o minusculas
        const expresion = new RegExp(busqueda, "i");
        ponentesFiltrados = ponentes.filter((ponente) => {
          if (ponente.nombre.toLowerCase().search(expresion) !== -1) {
            return ponente;
          }
        });
      } else {
        ponentesFiltrados = [];
      }

      mostrarPonentes();
    }

    function mostrarPonentes() {
      // Limpiar el input de busqueda
      // listadoPonentes.innerHTML = "";

      while (listadoPonentes.firstChild) {
        listadoPonentes.removeChild(listadoPonentes.firstChild);
      }

      if (ponentesFiltrados.length > 0) {
        ponentesFiltrados.forEach((ponente) => {
          const ponenteHTML = document.createElement("LI");
          ponenteHTML.classList.add("listado-ponentes__ponente");
          ponenteHTML.textContent = ponente.nombre;
          // definimos un atributo personalizado y almacenamos el id del ponente
          ponenteHTML.dataset.ponenteId = ponente.id;
          ponenteHTML.onclick = seleccionarPonente;
          // Anadir al DOM
          listadoPonentes.appendChild(ponenteHTML);
        });
      } else {
        const noResultados = document.createElement("P");
        noResultados.classList.add("listado-ponentes__no-resultados");
        noResultados.textContent = "No hay resultados para tu búsqueda";

        listadoPonentes.appendChild(noResultados);
      }
    }

    function seleccionarPonente(e) {
      const ponente = e.target;

      // Eliminar la clase previa
      const ponentePrevio = document.querySelector(
        ".listado-ponentes__ponente--seleccionado",
      );
      if (ponentePrevio) {
        ponentePrevio.classList.remove(
          "listado-ponentes__ponente--seleccionado",
        );
      }

      ponente.classList.add("listado-ponentes__ponente--seleccionado");
      // obtenemos el id del ponente seleccionado
      ponenteHidden.value = ponente.dataset.ponenteId;
    }
  }
})();
