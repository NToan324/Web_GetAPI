$(document).ready(function () {
    $('#search-form').submit(function (event) {
        event.preventDefault();
        const searchTerm = $('#search-input').val().trim();

        if (searchTerm === '') {
            alert('Please enter a search term');
            return;
        }

        $.ajax({
            url: `/Web_RestAPI/search/user?name=${encodeURIComponent(searchTerm)}`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#search-container').empty(); // Clear previous search results
                if (data.success) {
                    const users = data.data;
                    if (users.length === 0) {
                        alert('No users found');
                    } else {
                        users.forEach(user => {
                            const row = `
                                <tr class="hover-search">
                                    <td width="10%">
                                        <div class="profile-img-search">
                                            <img src="/Web_RestAPI/storage/posts/${user.avatar}" alt="avatar">
                                        </div>
                                    </td>
                                    <td>
                                        <p class="name-search">${user.name}</p>
                                    </td>
                                    <td width="5%">
                                        <a style="color: gray" href="#" onclick=""><i class="fa-solid fa-x"></i></a>
                                    </td>
                                </tr>
                            `;
                            $('#search-container').append(row);
                        });
                    }
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error searching users:', error);
                alert('An error occurred while searching users');
            }
        });
    });
});