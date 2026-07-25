if (document.querySelector("#mapa")) {
  // Definimos la latitud
  const lat = 34.0403207;
  // Definimos la longitud
  const log = -118.2695624;
  // Definimos el zoom
  const zoom = 16;

  const map = L.map("mapa").setView([lat, log], zoom);

  L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
      '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
  }).addTo(map);

  L.marker([lat, log])
    .addTo(map)
    .bindPopup(
      `
       <h2 class="mapa__heading">DevWebCamp</h2> 
       <p class="mapa__texto">Centro de Convenciones de los Ángeles</p>

    `,
    )
    .openPopup();
}
