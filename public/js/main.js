// public/js/main.js

if ("serviceWorker" in navigator) {
  window.addEventListener("load", () => {
    navigator.serviceWorker
      .register(
        "https://geochasqui.com/sistema_geo/public/js/service-worker.js"
      )
      .then((registration) => {
        console.log("MAIN -- Service Worker registrado con éxito:", registration);
      })
      .catch((error) => {
        console.log("Fallo al registrar el Service Worker:", error);
      });
  });
}
