let editwindow = document.querySelector(".edt-info")

// ARTISTER
document.querySelectorAll(".artist-btn").forEach((button) =>{
    button.addEventListener("click", ()=>{
        console.log(button.classList[1])
        fetch("/skivaffar/funktioner/getData/getartist.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `artist=${encodeURIComponent(button.classList[1])}`
        })
        .then(res => res.text())
        .then(html => {
            const dialogcontent = document.querySelector(".edt-info .dialog-content");
            dialogcontent.innerHTML += html;
            editwindow.showModal();
            const btn = document.querySelector(".edt-info .close");
            btn.addEventListener("click",()=>{
                editwindow.close();
                dialogcontent.removeChild(btn);
                dialogcontent.innerHTML = "";
                dialogcontent.appendChild(btn);
            })
        })
        .catch(err => {
            console.error("Fel vid anrop:", err);
        });
    })
})

//ALBUM
document.querySelectorAll(".album-btn").forEach((button) =>{
    button.addEventListener("click", ()=>{
        fetch("/skivaffar/funktioner/getData/getalbum.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `artist=${encodeURIComponent(button.dataset.artist)}&album=${encodeURIComponent(button.dataset.album)}`
        })
        .then(res => res.text())
        .then(html => {
            const dialogcontent = document.querySelector(".edt-info .dialog-content");
            dialogcontent.innerHTML += html;
            editwindow.showModal();
            const btn = document.querySelector(".edt-info .close");
            btn.addEventListener("click",()=>{
                editwindow.close();
                dialogcontent.removeChild(btn);
                dialogcontent.innerHTML = "";
                dialogcontent.appendChild(btn);
            })
        })
        .catch(err => {
            console.error("Fel vid anrop:", err);
        });
    })
})
