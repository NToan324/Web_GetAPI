function deletePost() {
    const deleteButtons = document.querySelectorAll('.delete-post');
    const confirmDeletePost = document.getElementById('ConfirmDeletePost');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const deleteBtn = document.getElementById('deleteBtn');
    let currentPostBox = null;
    let currentPostId = null;

    deleteButtons.forEach((button) => {
        button.addEventListener('click', function () {
            currentPostBox = button.closest('.post-box');
            currentPostId = currentPostBox.getAttribute('data-id');
            console.log(currentPostId);
            confirmDeletePost.style.visibility = 'visible';
        });
    });

    cancelDeleteBtn.addEventListener('click', function () {
        confirmDeletePost.style.visibility = 'hidden';
    });

    deleteBtn.addEventListener('click', async function () {
        if (currentPostId && currentPostBox) {
            const response = await fetch(`/Web_RestAPI/post?id=${currentPostId}`, {
                method: 'DELETE',
            });
            if (response.ok) {
                currentPostBox.remove();
            } else {
                console.error(response);
            }
            confirmDeletePost.style.visibility = 'hidden';
        }
    });
}

deletePost();
