function deletePost() {
    const deleteButtons = document.querySelectorAll('.delete-post')
    deleteButtons.forEach((button) => {
        button.addEventListener('click', async function () {
            const postBox = button.closest('.post-box')
            const postId = postBox.getAttribute('data-id')
            console.log(postId)
            const response = await fetch(`/Web_RestAPI/post?id=${postId}`, {
                method: 'DELETE',
            })
            if (response.ok) {
                postBox.remove()
            }
        })
    })
}
