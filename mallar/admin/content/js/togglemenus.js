document.querySelectorAll(".adm-btn").forEach((element) =>{
  element.addEventListener("click",()=>{
    let selector = element.classList[0].replace("-btn", "") + "-content"
    document.querySelectorAll(".content-menu").forEach(el =>{
      if (!selector){
        el.classList.add("hidden");
      }
      document.getElementById(selector).classList.toggle("hidden");
    })
  })
})