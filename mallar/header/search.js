// Hämta sökfältet från DOM: element med klassen "search-input"
const input = document.querySelector(".search-input");

// Lägg till eventlyssnare för 'input'-händelsen (när användaren skriver)
input.addEventListener('input', () => {
    // Läs in användarens inmatade söksträng och ta bort mellanslag i början och slutet
    const query = input.value.trim();
    
    // Hämta dialogelementet där sökresultaten ska visas
    let resultsDialog = document.querySelector(".search-results");

    // Om söksträngen inte är tom
    if (query.length > 0){
        // Skicka en fetch-förfrågan till servern med sökparametern (query), 
        // med korrekt URL-encoding för specialtecken
        fetch(`/skivaffar/mallar/header/search.php?q=${encodeURIComponent(query)}`)
            .then(res => res.text())    // Hämta svar som text (HTML)
            .then(data => {
                // Sätt dialogens innehåll till serverns svar (t.ex. förslag)
                resultsDialog.innerHTML = data;
                // Öppna dialogrutan så att resultaten visas
                resultsDialog.open = true;
            });
    } else {
        // Om sökfältet är tomt, stäng dialogrutan med sökresultaten
        document.querySelector('.search-results').open = false;
    }
});
