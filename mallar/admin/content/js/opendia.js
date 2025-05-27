// Gå igenom alla knappar på sidan
document.querySelectorAll("button").forEach((element) => {
    try {
      // Kontrollera om första klassnamnet börjar med "new-"
      if (element.classList[0].split("-")[0] == "new") {
        
        // Lägg till klick-händelse för att öppna rätt dialog
        element.addEventListener("click", () => {
          document.querySelectorAll("dialog").forEach((dialog) => {
            
            // Matcha dialogens klass (ex: "dlg-info") med knappens suffix (ex: "new-info")
            if (dialog.classList[0].split("-")[1] === element.classList[0].split("-")[1]) {
              dialog.open = true; // Öppna motsvarande dialogruta
            }
          });
        });
      }
    } catch (error) {
      // Logga fel
      console.error(error)
    }
  });
  
  // Lägg till stäng-funktionalitet för alla element med klassen "close"
  document.querySelectorAll(".close").forEach((button) => {
    button.addEventListener("click", () => {
      // Stäng dialogrutan (förutsätter att .close är inuti dialogens struktur)
      button.closest("dialog").open = false;
    });
  });
  