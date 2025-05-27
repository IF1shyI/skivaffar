// Lyssnar på klickhändelser i hela dokumentet
document.addEventListener("click", (e) => {

    // Om användaren klickar på en knapp med klassen "add-song"
    if (e.target.matches(".add-song")) {

        // Referens till knappen som klickades
        let btn = e.target;

        // Låtslistan är föregående syskon till knappen
        let songlist = btn.previousElementSibling;

        // Hämta sista låtelementet i listan
        let last = songlist.lastElementChild;

        // Extrahera numret från den sista låtens klass, annars starta från 0
        let num = last ? Number(last.classList[0].replace("song", "")) : 0;

        // Skapa en ny div för låten och ge den en unik klass
        let songcon = document.createElement("div");
        songcon.classList.add("song" + (num + 1));
        songlist.appendChild(songcon);

        // Skapa ett textstycke som visar låtnummer
        let songtxt = document.createElement("p");
        songtxt.textContent = "Låt " + (num + 1) + ":";

        // Lägg till texten i låtens container
        songcon.appendChild(songtxt);

        // Skapa en etikett för låtens namn
        let label = document.createElement("label");
        label.textContent = "Namn:";

        // Skapa ett textfält för låtnamn
        let input = document.createElement("input");
        input.type = "text";
        input.name = "songs[]"; // Fältet skickas som en array i formuläret

        // Lägg till textfältet i etiketten
        label.appendChild(input);

        // Lägg till etiketten i låtens container
        songcon.appendChild(label);

        // Skapa en knapp för att ta bort låten
        let rmbtn = document.createElement("button");
        rmbtn.classList.add("rm-song");
        rmbtn.type = "button";
        rmbtn.dataset.songnum = num + 1;
        rmbtn.textContent = "Ta bort";

        // Lägg till ta bort-knappen i etiketten
        label.appendChild(rmbtn);
    }
});
