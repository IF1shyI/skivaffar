const input = document.querySelector(".search-input");

input.addEventListener('input', ()=>{
    const query = input.value.trim();
    let resultsDialog = document.querySelector(".search-results");

    if (query.length > 0){
        fetch(`/skivaffar/mallar/header/search.php?q=${encodeURIComponent(query)}`)
                .then(res => res.text())
                .then(data => {
                    resultsDialog.innerHTML = data;
                    resultsDialog.open = true;
                });
    } else {
        document.querySelector('.search-results').open = false;
    }
})