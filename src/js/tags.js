(function () {
  const tagsInput = document.querySelector("#tags_input");

  if (tagsInput) {
    const tagsDiv = document.querySelector("#tags");
    const tagsInputHidden = document.querySelector('[name="tags"]');

    let tags = [];

    // Recuperar del inpu oculto
    if (tagsInputHidden.value !== "") {
      tags = tagsInputHidden.value.split(",");
      mostrarTags();
    }
    // escuchar los cambios en el input
    tagsInput.addEventListener("keypress", guardarTag);

    function guardarTag(e) {
      // Verificamos si se dio clic en la coma
      if (e.keyCode === 44) {
        // Evaluamos si tiene uno o varios espacios vacios o tiene menos de un caracter no lo agregara al arreglo
        if (e.target.value.trim() === "" || e.target.value < 1) {
          return;
        }
        // Evitamos que se escriba la coma al momento de darle clic
        e.preventDefault();
        // añadimos lo que tenga el input al arreglo tags
        tags = [...tags, e.target.value.trim()];
        // Limpiamos el input
        tagsInput.value = "";
        // Mostramos los tags
        mostrarTags();
      }
    }

    function mostrarTags() {
      tagsDiv.textContent = "";
      tags.forEach((tag) => {
        const etiqueta = document.createElement("LI");
        etiqueta.classList.add("formulario__tag");
        etiqueta.textContent = tag;
        etiqueta.ondblclick = eliminarTag;
        tagsDiv.appendChild(etiqueta);
      });
      actualizarInputHidden();
    }

    // Funcion para eliminar el tag
    function eliminarTag(e) {
      // Eliminamos del HTML el tag
      e.target.remove();
      // Filtramos el arreglo para que me actualice el arreglo del tag eliminado
      tags = tags.filter((tag) => tag !== e.target.textContent);
      // Llamamos al método actualizarInputHidden para actualizar el input de tipo hidden con los tags actuales
      actualizarInputHidden();
    }

    // Funcion que nos ayudara a eliminar o agregar tags
    function actualizarInputHidden() {
      tagsInputHidden.value = tags.toString();
    }
  }
})();
