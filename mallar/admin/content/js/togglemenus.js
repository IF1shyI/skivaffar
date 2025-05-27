// Hitta alla element med klassen "adm-btn" och iterera över dem
document.querySelectorAll(".adm-btn").forEach((element) => {

  // Lägg till en klickhändelse för varje knapp
  element.addEventListener("click", () => {

    // Bygg ett selektornamn baserat på knappens klassnamn
    // Exempel: "album-btn" → "album-content"
    let selector = element.classList[0].replace("-btn", "") + "-content";

    // Iterera över alla innehållssektioner i menyområdet
    document.querySelectorAll(".content-menu").forEach(el => {

      // Om ingen selektor kunde bestämmas, göm alla sektioner
      if (!selector) {
        el.classList.add("hidden");
      }

      // Växla synligheten för rätt innehållssektion
      document.getElementById(selector).classList.toggle("hidden");
    });
  });
});
