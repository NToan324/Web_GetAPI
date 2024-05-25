function deletePost() {
    const deleteButtons = document.querySelectorAll('.delete-post')
    deleteButtons.forEach((button) => {
        button.addEventListener('click', async function () {
            const postBox = button.closest('.post-box')
            const postId = postBox.getAttribute('data-id')
            const response = await fetch(`/Web_RestAPI/post?id=${postId}`, {
                method: 'DELETE',
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                },
            })
            if (response.ok) {
                postBox.remove()
            }
        })
    })
}
