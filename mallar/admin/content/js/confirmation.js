document.addEventListener("click", (e)=>{
    if (e.target.matches(".rm-album")){
        document.querySelector(".rm-confirm").open = true
    }
    
    if (e.target.matches(".rm-deny")){
        document.querySelector(".rm-confirm").open = false
    }

    if (e.target.matches(".rm-accept")) {
        const button = document.querySelector(".rm-accept");
        const album = button.dataset.album;
        const artist = button.dataset.artist


        if (album){
            fetch("/skivaffar/funktioner/alterdb/rmalbum.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `album=${encodeURIComponent(album)}`
            })
            .then(res => res.text()) // <-- tolka som text
            .then(text => {
                console.log("Svar från servern:", text); // <-- skriv ut i konsolen
        
                // Stäng dialogen
                document.querySelector(".edt-info").open = false;
                location.reload();
            })
            .catch(err => {
                console.error("Fel vid anrop:", err);
            });
        }

        if (artist){
            fetch("/skivaffar/funktioner/alterdb/rmartist.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `artist=${encodeURIComponent(artist)}`
            })
            .then(res => res.text()) // <-- tolka som text
            .then(text => {
                console.log("Svar från servern:", text); // <-- skriv ut i konsolen
        
                // Stäng dialogen
                document.querySelector(".edt-info").open = false;
                location.reload();
            })
            .catch(err => {
                console.error("Fel vid anrop:", err);
            });
        }
    }
    
})