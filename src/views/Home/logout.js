    $(document).ready(function() {
    const logoutBtn = $('#logoutBtn')

    logoutBtn.click(function() {
        $.post('/Web_RestAPI/logout', {logoutBtn: true}, (res) => {
            if (res.success) {
                window.location.href = '/Web_RestAPI/login'
            } else {
                console.error(res)
            }
        })
    })
})