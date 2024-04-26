$(document).ready(function () {
    let submitBtn = $('#login-submit-btn')
    
    submitBtn.click(function (e) {
        console.log('clicked')
        // chặn hành vi gửi form mặc định của button
        e.preventDefault()
        let rememberMe = $('#remember-me').is(':checked')
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
        $.ajax({
            url: '/login',
            method: 'POST',
            dataType: 'json',
            data: { email, password, rememberMe, submit: true },
            success: function(res) {
                console.log(res.success);
                if (res.success) {
                    window.location.href = '/';
                } else {
                    $('#messageError-login').text(res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
        
    })
})

function validateEmail(email) {
    var re =
        /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    return re.test(email.toLowerCase())
}
