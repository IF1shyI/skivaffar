// Lyssnar på alla klick på dokumentet
document.addEventListener("click", (e) => {
    
    // Om klicket sker på ett element med klassen .rm-song (ta bort låt)
    if (e.target.matches(".rm-song")) {

        e.preventDefault();      // Förhindra eventuell standardbeteende (t.ex. länk)
        e.stopPropagation();     // Stoppa vidare bubbla av händelsen

        // Ta bort motsvarande låtelement baserat på data-attribut
        const songElement = document.querySelector(`.song${e.target.dataset.songnum}`);
        if (songElement) songElement.remove();

        // Uppdatera numreringen för kvarvarande låtar
        let i = 1;
        document.querySelectorAll(".song-num").forEach((song) => {
            song.textContent = "Låt " + i + ":"; // Ändra t.ex. till "Låt 1:", "Låt 2:", osv.
            i++;
        });
    }
});
