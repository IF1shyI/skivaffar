// Huvuddialogen för redigering av artist- eller albuminformation
let editwindow = document.querySelector(".edt-info");

// ===========================
// HANTERA REDIGERING AV ARTISTER
// ===========================

document.querySelectorAll(".artist-btn").forEach((button) => {
    button.addEventListener("click", () => {

        // Debug: skriv ut vilket artist-ID som skickas
        console.log(button.dataset.artist);

        // Skicka POST-anrop till PHP-skript som hämtar artistinformation
        fetch("/skivaffar/funktioner/getData/getartist.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `artist=${encodeURIComponent(button.dataset.artist)}`
        })
        .then(res => res.text()) // Tolka svaret som HTML-text
        .then(html => {
            const dialogcontent = document.querySelector(".edt-info .dialog-content");

            // Lägg till den mottagna HTML:n i dialogrutan
            dialogcontent.innerHTML += html;

            // Öppna redigeringsdialogen som modal
            editwindow.showModal();

            // Lägg till stäng-knappens funktionalitet
            const btn = document.querySelector(".edt-info .close");
            btn.addEventListener("click", () => {
                editwindow.close();

                // Rensa innehållet i dialogen och återställ stängknappen
                dialogcontent.removeChild(btn);      // ta bort knappen
                dialogcontent.innerHTML = "";        // töm innehållet
                dialogcontent.appendChild(btn);      // lägg tillbaka knappen
            });
        })
        .catch(err => {
            console.error("Fel vid anrop:", err); // Hantera fel i fetch
        });
    });
});


// ===========================
// HANTERA REDIGERING AV ALBUM
// ===========================

document.querySelectorAll(".album-btn").forEach((button) => {
    button.addEventListener("click", () => {

        // Skicka POST-anrop med artist- och albumnamn
        fetch("/skivaffar/funktioner/getData/getalbum.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `artist=${encodeURIComponent(button.dataset.artist)}&album=${encodeURIComponent(button.dataset.album)}`
        })
        .then(res => res.text()) // Tolka svaret som HTML-text
        .then(html => {
            const dialogcontent = document.querySelector(".edt-info .dialog-content");

            // Lägg till HTML-innehållet i dialogen
            dialogcontent.innerHTML += html;

            // Visa dialogrutan
            editwindow.showModal();

            // Stäng-funktionalitet för dialogen
            const btn = document.querySelector(".edt-info .close");
            btn.addEventListener("click", () => {
                editwindow.close();

                // Rensa dialoginnehållet och återställ stängknappen
                dialogcontent.removeChild(btn);
                dialogcontent.innerHTML = "";
                dialogcontent.appendChild(btn);
            });
        })
        .catch(err => {
            console.error("Fel vid anrop:", err); // Fångar nätverks-/serverfel
        });
    });
});
