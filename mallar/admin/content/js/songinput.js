document.addEventListener("click", (e) => {
    if (e.target.matches(".add-song")) {
        let btn = e.target;
        let songlist = btn.previousElementSibling;
        let last = songlist.lastElementChild;
        let num = last ? Number(last.classList[0].replace("song", "")) : 0;

        let songcon = document.createElement("div");
        songcon.classList.add("song" + (num + 1));
        songlist.appendChild(songcon);

        let songtxt = document.createElement("p");
        songtxt.textContent = "Låt " + (num + 1) + ":";

        songcon.appendChild(songtxt);

        let label = document.createElement("label");
        label.textContent = "Namn:";

        let input = document.createElement("input");
        input.type = "text";
        input.name = "songs[]";

        label.appendChild(input);
        songcon.appendChild(label);
    }
});