$(document).ready(function () {
    const loginBtn = $('#login')
    const submitBtn = $('#signup-submit-btn')
    const signupError = $('#messageError-signup')

    // Catch user submit sign up form event
    submitBtn.click(function (e) {
        // Prevent form submit event
        e.preventDefault()
        const name = $('#signup-name').val()
        const email = $('#signup-email').val()
        const password = $('#signup-password').val()

        if (!name) {
            signupError.text('Name is required')
            return
        }

        if (!email) {
            signupError.text('Email is required')
            return
        }

        if (!validateEmail(email)) {
            signupError.text('Email is invalid')
            return
        }

        if (!password) {
            signupError.text('Password is required')
            return
        }

        if (password.length < 6) {
            signupError.text('Password must be at least 6 characters')
            return
        }

        signupError.text('')

        // Call api đăng kí tài khoản
        $.post(
            `/Web_RestAPI/signUp`,
            { name, email, password, submit: true },
            function (res) {
                console.log(res)
                if (!res.success) {
                    // Sign up failed
                    signupError.text(res.message)
                    console.log(res.message)
                } else {
                    // Sign up successfully
                    // Back to login form and show sign up success message
                    loginBtn.click()
                    $('#email').val(email)
                    $('#password').val(password)
                    $('#messageError-login').text(
                        'Sign up successfully, please login'
                    )
                    $('#signup-name').val('')
                    $('#signup-email').val('')
                    $('#signup-password').val('')
                    $('#messageError-signup').text('')

                    console.log(res)
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
