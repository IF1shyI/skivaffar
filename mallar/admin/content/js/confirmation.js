document.addEventListener("click", (e)=>{
    if (e.target.matches(".rm-album")){
        document.querySelector(".rm-confirm").open = true
    }
    
    if (e.target.matches(".rm-deny")){
        document.querySelector(".rm-confirm").open = false
    }
})