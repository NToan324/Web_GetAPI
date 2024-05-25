document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const form = document.querySelector('form');
    const searchResults = document.getElementById('search-results');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
    });

    searchInput.addEventListener('input', function () {
        let value = searchInput.value;
        console.log(value)

        fetch(`/Web_RestAPI/search?name=${value}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
            .then((res) => {
                return res.json()
            })
            .then((data) => {
                console.log(data)
                searchResults.innerHTML = ''; // clear previous search results
                data.data.forEach(user => {
                    const resultDiv = document.createElement('div');
                    const avatarImg = document.createElement('img');
                    avatarImg.src = "/Web_RestAPI/storage/users/" + user.avatar;
                    const nameP = document.createElement('p');
                    nameP.textContent = user.name;
                    resultDiv.appendChild(avatarImg);
                    resultDiv.appendChild(nameP);
                    searchResults.appendChild(resultDiv);
                });
            })
    })
})