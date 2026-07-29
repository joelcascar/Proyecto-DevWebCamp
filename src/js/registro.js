import Swal from "sweetalert2";
(function () {
  let eventos = [];
  const resumen = document.querySelector("#registro-resumen");

  if (resumen) {
    const eventosBoton = document.querySelectorAll(".evento__agregar");
    eventosBoton.forEach((boton) =>
      boton.addEventListener("click", seleccionarEvento),
    );

    const formularioRegistro = document.querySelector("#registro");
    formularioRegistro.addEventListener("submit", submitFormulario);

    mostrarEventos();

    function seleccionarEvento(e) {
      if (eventos.length < 5) {
        // deshabilitar el evento
        e.target.disabled = true;
        eventos = [
          ...eventos,
          {
            id: e.target.dataset.id,
            titulo: e.target.parentElement
              .querySelector(".evento__nombre")
              .textContent.trim(),
          },
        ];
        mostrarEventos();
      } else {
        Swal.fire({
          title: "Error",
          text: "Máximo 5 eventos por registro",
          icon: "error",
          confirmButtonText: "ok",
        });
      }
    }

    function mostrarEventos() {
      // Limpiar el HTML
      limpiarEventos();
      if (eventos.length > 0) {
        eventos.forEach((evento) => {
          const eventoDOM = document.createElement("DIV");
          eventoDOM.classList.add("registro__evento");
          const titulo = document.createElement("H3");
          titulo.classList.add("registro__nombre");
          titulo.textContent = evento.titulo;

          // Boton para eliminar evento del registro
          const botonEliminar = document.createElement("BUTTON");
          botonEliminar.classList.add("registro__eliminar");
          botonEliminar.innerHTML = `<i class="fa-solid fa-trash"></i>`;
          botonEliminar.onclick = function () {
            eliminarEvento(evento.id);
          };
          // renderizar en HTML
          eventoDOM.appendChild(titulo);
          eventoDOM.appendChild(botonEliminar);
          resumen.appendChild(eventoDOM);
        });
      } else {
        const noRegistros = document.createElement("P");
        noRegistros.textContent =
          "No hay eventos, añade hasta cinco del lado izquierdo ";
        noRegistros.classList.add("registro__texto");
        resumen.appendChild(noRegistros);
      }
    }

    function eliminarEvento(id) {
      eventos = eventos.filter((evento) => evento.id !== id);
      // Seleccionamos el boton para habilitar el boton deshabilitado
      const botonAgregar = document.querySelector(`[data-id="${id}"]`);
      botonAgregar.disabled = false;
      mostrarEventos();
    }

    function limpiarEventos() {
      while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
      }
    }

    async function submitFormulario(e) {
      e.preventDefault();
      // Obtener el regalo
      const regaloId = document.querySelector("#regalo").value;

      // Obtener los id de los eventos
      const eventosId = eventos.map((evento) => evento.id);

      // Validación
      if (eventosId.length === 0) {
        Swal.fire({
          title: "Error",
          text: "Elige al menos un evento",
          icon: "error",
          confirmButtonText: "ok",
        });
        return;
      }

      if (regaloId === "") {
        Swal.fire({
          title: "Error",
          text: "Elige un regalo",
          icon: "error",
          confirmButtonText: "ok",
        });
        return;
      }

      // objeto de formData
      const datos = new FormData();
      datos.append("eventos", eventosId);
      datos.append("regalo_id", regaloId);

      const url = "/finalizar-registro/conferencias";
      const respuesta = await fetch(url, {
        method: "POST",
        body: datos,
      });
      const resultado = await respuesta.json();
      console.log(resultado);
      if (resultado.resultado) {
        Swal.fire({
          title: "Registro exitoso",
          text: "Tus conferencias se han almacenado y tu registro fue exitoso, te esperamos en DevWebCamp",
          icon: "success",
        }).then(() => (location.href = `/boleto?id=${resultado.token}`));
      } else {
        Swal.fire({
          title: "Error",
          text: "Hubo un error",
          icon: "error",
          confirmButtonText: "ok",
        }).then(() => window.location.reload());
      }
    }
  }
})();
