const input = document.querySelector(".search-input");

input.addEventListener('input', ()=>{
    const query = input.value.trim();

    if (query.length > 0){
        fetch(`search.php?q=${encodeURIComponent(query)}`)
                .then(res => res.text())
                .then(data => {
                    resultsDialog.innerHTML = data;
                    resultsDialog.open = true;
                });
    } else {
        document.querySelector('.search-results').open = false;
    }
})