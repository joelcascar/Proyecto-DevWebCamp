// importamos JS
import Swiper, { FreeMode } from "swiper";
import { Navigation } from "swiper";
// importamos CSS
import "swiper/css";
import "swiper/css/navigation";

document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelector(".slider")) {
    const opciones = {
      slidesPerView: 1, // es el número de imagenes por vista
      spaceBetween: 15, // es la cantidad de separación de cada slide en px.
      freeMode: true, // va a habilitar el desplazamiento libre como scroll
      // establecemos navegación
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      // es como un mediaquery
      breakpoints: {
        // cantidad de pixeles
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        },
        1200: {
          slidesPerView: 4,
        },
      },
      // loop: true,
    };
    Swiper.use([Navigation]);
    new Swiper(".slider", opciones);
  }
});
