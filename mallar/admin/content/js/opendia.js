document.querySelectorAll("button").forEach((element) => {
  try {
    if(element.classList[0].split("-")[0]=="new"){
        element.addEventListener("click",()=>{
            document.querySelectorAll("dialog").forEach((dialog)=>{
                if (dialog.classList[0].split("-")[1] == element.classList[0].split("-")[1]){
                    dialog.open = true;
                }
            })
        })
    }
  } catch (error) {
  }
});


document.querySelectorAll(".close").forEach((button) =>{
    button.addEventListener("click", ()=>{
        button.parentElement.parentElement.open = false;
    })
})