(function () {
  const horas = document.querySelector("#horas");

  if (horas) {
    // Objeto en memoria
    let busqueda = {
      categoria_id: "",
      dia: "",
    };

    const categoria = document.querySelector("#categoria");
    const dias = document.querySelectorAll('[name="dia"]');
    const inputHiddenDia = document.querySelector('[name="dia_id"]');
    const inputHiddenHora = document.querySelector('[name="hora_id"]');

    categoria.addEventListener("change", terminoBusqueda);
    dias.forEach((dia) => {
      dia.addEventListener("change", terminoBusqueda);
    });

    function terminoBusqueda(e) {
      busqueda[e.target.name] = e.target.value;

      // Reiniciamos los campos ocultos y el selector de horas
      inputHiddenHora.value = "";
      inputHiddenDia.value = "";
      // Deshabilitar la hora previa si hay un nuevo clic
      const horaPrevia = document.querySelector(".horas__hora--seleccionada");
      if (horaPrevia) {
        horaPrevia.classList.remove("horas__hora--seleccionada");
      }
      // Evaluamos si los valores del objeto estan vacios.
      if (Object.values(busqueda).includes("")) {
        return;
      }
      buscarEventos();
    }

    // Función asincrona para consultar la API
    async function buscarEventos() {
      // Aplicamos destructuring
      const { categoria_id, dia } = busqueda;
      const url = `/api/eventos-horario?categoria_id=${categoria_id}&dia_id=${dia}`;
      const resultado = await fetch(url);
      const eventos = await resultado.json();

      obtenerHorasDisponibles(eventos);
    }

    function obtenerHorasDisponibles(eventos) {
      // Reiniciar las horas
      // Obtenemos todos los elementos del <ul> de horas en un NodeList
      const listadoHoras = document.querySelectorAll("#horas li");
      listadoHoras.forEach((li) =>
        li.classList.add("horas__hora--deshabilitada"),
      );
      // Comprobar eventos ya tomados y quitar la clase de deshabilitado
      // Obtenemos en un arreglo las horas id de todos los eventos disponibles.
      const horasTomadas = eventos.map((evento) => evento.hora_id);
      // Convertimos un Nodelist a un array
      const listadoHorasArray = Array.from(listadoHoras);
      // Filtramos el arreglo para que devuelva los elementos que no se hayab tomado en las hora tomadas
      const resultado = listadoHorasArray.filter(
        (li) => !horasTomadas.includes(li.dataset.horaId),
      );
      // Recorremos el arreglo y eliminamos la clase
      resultado.forEach((li) =>
        li.classList.remove("horas__hora--deshabilitada"),
      );
      // Obtenemos todas las horas excepto las ue tiene la clase horas__hora--deshabilitada.
      const horasDisponibles = document.querySelectorAll(
        "#horas li:not(.horas__hora--deshabilitada)",
      );
      // Recorrmos el arreglo de horas y les agregamos un evento
      horasDisponibles.forEach((horaDisponible) => {
        horaDisponible.addEventListener("click", seleccionarhora);
      });
    }

    function seleccionarhora(e) {
      // Deshabilitar la hora previa si hay un nuevo clic
      const horaPrevia = document.querySelector(".horas__hora--seleccionada");
      if (horaPrevia) {
        horaPrevia.classList.remove("horas__hora--seleccionada");
      }
      // Agregar clase de seleccionado cuando se le de clic a una hora
      e.target.classList.add("horas__hora--seleccionada");
      // Se almacena el id de la hora seleccionada en el input oculto.
      inputHiddenHora.value = e.target.dataset.horaId;

      // Llenar el campo oculto de dia
      inputHiddenDia.value = document.querySelector(
        '[name="dia"]:checked',
      ).value;
    }
  }
})();
