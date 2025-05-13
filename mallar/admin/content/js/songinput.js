document.querySelector(".add-song").addEventListener("click",()=>{
    let songlist = document.querySelector(".songlist");
    let num = Number(songlist.lastElementChild.classList[0].replace("song",""))

    let songcon = document.createElement("div");
    songcon.classList.add("song"+(num+1))
    songlist.appendChild(songcon);

    let songtxt = document.createElement("p");
    songtxt.textContent = "Låt "+(num+1)+":";

    songcon.appendChild(songtxt);

    let label = document.createElement("label");
    label.textContent = "Namn:";

    songcon.appendChild(label);

    let input = document.createElement("input");
    input.type = "text";
    input.name = "songs[]";

    label.appendChild(input);
})