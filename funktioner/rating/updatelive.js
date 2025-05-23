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

document.addEventListener("click",(e)=>{
    if (e.target.classList.contains("rating-star")){
        const rating = Number(e.target.classList[1]) + 1;
        console.log(rating)
    }
})