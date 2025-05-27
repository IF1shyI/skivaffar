// Hämta referens till inputfältet för artistförslag
const input = document.querySelector(".artist-suggestion-inp");

// Lägg till en eventlyssnare som triggas varje gång användaren skriver i fältet
input.addEventListener('input', () => {

    // Trimma användarens inmatning
    const query = input.value.trim();

    // Referens till dialogen som visar förslag
    let resultsDialog = document.querySelector(".sug-box");

    // Om det finns minst ett tecken i sökfältet
    if (query.length > 0) {

        // Skicka sökfrågan till servern via fetch
        fetch(`/skivaffar/mallar/admin/content/search/artist.php?q=${encodeURIComponent(query)}`)
            .then(res => res.text())         // Tolkning av svaret som text
            .then(data => {
                // Placera det mottagna HTML-innehållet i dialogen
                resultsDialog.innerHTML = data;

                // Visa dialogen med förslag
                resultsDialog.open = true;

                // Justera marginalen under inmatningsfältet när förslag visas
                document.querySelector(".artist-suggestion").style.marginBottom = "5rem";

                // Hämta alla klickbara förslag i listan
                const items = document.querySelectorAll(".sug-item");

                // Logga till konsolen om inga förslag hittades
                if (items.length === 0) {
                    console.log("Inga .sug-item-element hittades.");
                }

                // Lägg till klickhändelse för varje förslag
                items.forEach((item) => {
                    item.addEventListener("click", () => {

                        // Extrahera artistens namn och sätt det som inputvärde
                        let name = item.textContent;
                        input.value = name.trim().replace(/\s+/g, " ");

                        // Stäng dialogrutan med förslag
                        resultsDialog.open = false;

                        // Återställ marginalen när förslagsrutan försvinner
                        document.querySelector(".artist-suggestion").style.marginBottom = "1rem";
                    });
                });
            });

    } else {
        // Om fältet är tomt, stäng förslagsrutan
        document.querySelector('.sug-box').open = false;
    }
});
