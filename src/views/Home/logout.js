    $(document).ready(function() {
    const logoutBtn = $('#logout-btn')

    logoutBtn.click(function() {
        $.post('/Web_RestAPI/logout', {logoutBtn: true}, (res) => {
            if (res.success) {
                window.location.reload()
            } else {
                console.error(res)
            }
        })
    })
})