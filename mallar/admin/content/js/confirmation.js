// Lyssna på alla klick på sidan
document.addEventListener("click", (e) => {

    // Om användaren klickar på en "ta bort album"-knapp (element med klassen .rm-album)
    if (e.target.matches(".rm-album")) {
        // Visa bekräftelsedialogen
        document.querySelector(".rm-confirm").open = true;
    }

    // Om användaren klickar på "nej"-knappen i bekräftelsedialogen
    if (e.target.matches(".rm-deny")) {
        // Stäng bekräftelsedialogen
        document.querySelector(".rm-confirm").open = false;
    }

    // Om användaren klickar på "ja"/"bekräfta"-knappen för att radera
    if (e.target.matches(".rm-accept")) {

        // Hämta knappen och dess dataset-attribut (album och artist)
        const button = document.querySelector(".rm-accept");
        const album = button.dataset.album;
        const artist = button.dataset.artist;

        // Om ett album ska tas bort
        if (album) {
            fetch("/skivaffar/funktioner/alterdb/rmalbum.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                // Skicka albumnamnet i POST-body, URL-kodad
                body: `album=${encodeURIComponent(album)}`
            })
            .then(res => res.text()) // Tolka svaret som vanlig text
            .then(text => {
                console.log("Svar från servern:", text); // Logga svaret i konsolen

                // Stäng eventuell informationsdialog och ladda om sidan
                document.querySelector(".edt-info").open = false;
                location.reload();
            })
            .catch(err => {
                console.error("Fel vid anrop:", err); // Logga eventuella fel
            });
        }

        // Om en artist ska tas bort
        if (artist) {
            fetch("/skivaffar/funktioner/alterdb/rmartist.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                // Skicka artistnamnet i POST-body, URL-kodad
                body: `artist=${encodeURIComponent(artist)}`
            })
            .then(res => res.text()) // Tolka svaret som vanlig text
            .then(text => {
                console.log("Svar från servern:", text); // Logga svaret i konsolen

                // Stäng eventuell informationsdialog och ladda om sidan
                document.querySelector(".edt-info").open = false;
                location.reload();
            })
            .catch(err => {
                console.error("Fel vid anrop:", err); // Logga eventuella fel
            });
        }
    }
});
