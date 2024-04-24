$(document).ready(function () {
    let loginBtn = $('#login')
    let submitBtn = $('#signup-submit-btn')
    //bắt sự kiện click nút đăng nhập
    submitBtn.click(function (e) {
        // chặn hành vi gửi form mặc định của button
        e.preventDefault()
        let name = $('#signup-name').val()
        let email = $('#signup-email').val()
        let password = $('#signup-password').val()

        let emailLogin = $('#email').val()
        let passwordLogin = $('#password').val()

        if (!name) {
            $('#messageError').text('Name is required')
            return
        }

        if (!email) {
            $('#messageError').text('Email is required')
            return
        }

        if (!validateEmail(email)) {
            $('#messageError').text('Email is invalid')
            return
        }

        if (!password) {
            $('#messageError').text('Password is required')
            return
        }

        if (password.length < 6) {
            $('#messageError').text('Password must be at least 6 characters')
            return
        }

        $('#messageError').text('') 

        // Call api đăng kí tài khoản
        $.post(
            `/signup`,
            {name, email, password, submit: true},
            function (res) {
                console.log(res)

                if (!res.success) {
                    // Sign up failed
                    //* res.message là thông báo lỗi
                    // TODO: error when sign up, show error here
                    /* 
                    Khi đăng kí lỗi thì hiển thị thông báo lỗi ở đây, lỗi lấy trong message ra
                     */
                    console.log(res.message)
                } else {
                    // Sign up successfully
                    // window.location.href = '/'
                    // * res.data là object chứa name, email, password
                    // TODO: back to login form with sign up data
                    /* 
                    Chổ này đăng nhập thành công nè, đem data quay về trang login
                    */

                    console.log(res)
                }
            },
            'json'
        )

        loginBtn.click() // Chuyển về form đăng nhập
        $('#email').val(email)
        $('#password').val(password)
        $('#messageError-login').text('Register successfully, please login')
    })
})

function validateEmail(email) {
    var re =
        /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    return re.test(email.toLowerCase())
}
