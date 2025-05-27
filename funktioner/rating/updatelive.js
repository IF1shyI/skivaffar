// Händelselyssnare för muspekare som rör sig över dokumentet
document.addEventListener("mouseover", (e) => {
    // Kontrollera om muspekaren är över ett betygsstjärneelement
    if (e.target.classList.contains("rating-star")) {

        // Nollställ alla stjärnor till tom bild
        document.querySelectorAll(".rating-star").forEach((star) => {
            star.src = "../../public/bilder/stars/empty.svg";

            // Fyll i stjärnor upp till och med den som muspekaren är över
            if (star.classList[1] <= e.target.classList[1]) {
                star.src = "../../public/bilder/stars/full.svg";
            }
        });
    }
});

// Händelselyssnare för klick på dokumentet
document.addEventListener("click", (e) => {
    // Kontrollera om klicket var på en betygsstjärna
    if (e.target.classList.contains("rating-star")) {
        const starElement = e.target;

        // Hämta betygsvärdet genom att tolka klassnamnet som ett tal (index + 1)
        const rating = Number(starElement.classList[1]) + 1;

        // Hämta albumnamn från förälderelementets data-attribut
        const albumname = starElement.parentElement.dataset.album?.trim();

        // Om inget albumnamn finns, logga ett fel och avbryt
        if (!albumname) {
            console.error("❌ Inget albumnamn hittades i data-album-attributet.");
            return;
        }

        // Logga vad som skickas
        console.log("✅ Skickar betyg:", rating, "för album:", albumname);

        // Skicka POST-förfrågan till servern med betyg och albumnamn
        fetch("/skivaffar/funktioner/rating/sendrating.php", { 
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `rating=${encodeURIComponent(rating)}&albumname=${albumname}`
        })
        .then(res => res.json()) // Tolka svaret som JSON
        .then(data => {
            if (data.success) {
                console.log("✅ Betyget sparades!");
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
