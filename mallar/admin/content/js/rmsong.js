document.addEventListener("click", (e)=>{
    if (e.target.matches(".rm-song")){
        console.log("hej");
        e.preventDefault();
        e.stopPropagation();
        document.querySelector(`.song${e.target.dataset.songnum}`).remove();

        let i = 1
        document.querySelectorAll(".song-num").forEach((song)=>{
            song.textContent = "Låt " + i +":";

            i++
        })
    }
})