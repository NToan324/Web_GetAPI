$(document).ready(function () {
    let submitBtn = $('#login-submit-btn')
    //bắt sự kiện click nút đăng nhập
    submitBtn.click(function (e) {
        // chặn hành vi gửi form mặc định của button
        e.preventDefault()
        let email = $('#email').val()
        let password = $('#password').val()

        // TODO: validate user input and show error

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
            { email, password, submit: true },
            function (data) {
                console.log(data)
                if (!data.success) {
                    //không thành công thì hiện lỗi
                    $('#messageError-login').text(data.message)
                } else {
                    window.location.href = '/'
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
