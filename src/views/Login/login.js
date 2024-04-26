$(document).ready(function () {
    let submitBtn = $('#login-submit-btn')
    let rememberMe = $('#remember-me').is(':checked')

    submitBtn.click(function (e) {
        // chặn hành vi gửi form mặc định của button
        e.preventDefault()
        let email = $('#email').val()
        let password = $('#password').val()

        if (!email) {
            $('#messageError-login').text('Email is required')
            return
        }

        if (!validateEmail(email)) {
            $('#messageError-login').text('Email is invalid')
            return
        }

        if (!password) {
            $('#messageError-login').text('Password is required')
            return
        }

        if (password.length < 6) {
            $('#messageError-login').text(
                'Password must be at least 6 characters'
            )
            return
        }

        $('#messageError-login').text('')

        //call api kiểm tra đăng nhập
        $.post(
            `/login`,
            { email, password, rememberMe, submit: true },
            function (res) {
                if (res.success) {
                    window.location.href = '/'
                } else {
                    $('#messageError-login').text(res.message)
                }
            },
            'json'
        )
    })
})

function validateEmail(email) {
    var re =
        /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    return re.test(email.toLowerCase())
}
