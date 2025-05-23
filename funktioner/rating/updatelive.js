document.addEventListener("mouseover",(e)=>{
    if (e.target.classList.contains("rating-star")) {
        
        document.querySelectorAll(".rating-star").forEach((star)=>{
            star.src = "../../public/bilder/stars/empty.svg"
            if (star.classList[1] <= e.target.classList[1]){
                star.src = "../../public/bilder/stars/full.svg"
            }
        })
    }
})

document.addEventListener("click", (e) => {
    if (e.target.classList.contains("rating-star")) {
        const starElement = e.target;
        const rating = Number(starElement.classList[1]) + 1;

        // Hämta albumnamn via data-attribut
        const albumname = starElement.parentElement.dataset.album?.trim();

        if (!albumname) {
            console.error("❌ Inget albumnamn hittades i data-album-attributet.");
            return;
        }

        console.log("✅ Skickar betyg:", rating, "för album:", albumname);

        fetch("/skivaffar/funktioner/rating/sendrating.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `rating=${encodeURIComponent(rating)}&albumname=${encodeURIComponent(albumname)}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("✅ Betyget sparades!");
            } else {
                console.error("❌ Svarsfel:", data.error);
                alert("Fel vid betygssparning: " + data.error);
            }
        })
        .catch(err => {
            console.error("❌ Fetch-fel:", err);
            alert("Nätverksfel vid betygsskick.");
        });
    }
});
