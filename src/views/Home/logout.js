$(document).ready(function() {
    const logoutBtn = $('#logout-btn')
    console.log(logoutBtnj)

    logoutBtn.click(function() {
        $.post('/logout', {logoutBtn: true}), (res) => {
            if (res.success) {
                console.log(res)
            } else {
                console.error(res)
            }
        }
    })
})