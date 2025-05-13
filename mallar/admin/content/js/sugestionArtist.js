const input = document.querySelector(".artist-suggestion-inp");

input.addEventListener('input', ()=>{
    const query = input.value.trim();
    let resultsDialog = document.querySelector(".sug-box");

    if (query.length > 0){
        fetch(`/skivaffar/mallar/admin/content/search/artist.php?q=${encodeURIComponent(query)}`)
                .then(res => res.text())
                .then(data => {
                    resultsDialog.innerHTML = data;
                    resultsDialog.open = true;
                    
                    document.querySelector(".artist-suggestion").style.marginBottom = "5rem";

                    const items = document.querySelectorAll(".sug-item");

                    if (items.length === 0) {
                        console.log("Inga .sug-item-element hittades.");
                    }
    
                    items.forEach((item) => {
                        item.addEventListener("click", () => {
                            let name = item.textContent;
                            input.value = name.trim().replace(/\s+/g, " ");
                            resultsDialog.open = false;
                            document.querySelector(".artist-suggestion").style.marginBottom = "1rem";
                        });
                    });
                });

    } else {
        document.querySelector('.sug-box').open = false;
    }
})