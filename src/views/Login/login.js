
$(document).ready(function () {
    let submitBtn = $("#login-submit-btn")
    //bắt sự kiện click nút đăng nhập
    let rememberMe = $('#remember-me').val()
    console.log(rememberMe)
    submitBtn.click(function (e) {
        // chặn hành vi gửi form mặc định của button
        e.preventDefault()
        let email = $("#email").val()
        let password = $("#password").val()

        console.log(email, password, rememberMe)


        //call api kiểm tra đăng nhập
        $.post(
            `/login`,
            { email, password, rememberMe, submit: true },
            function (res) {
                console.log(res)
                if (!res.success) {
                    $('#messageError-login').text(res.message)
                } else {
                    window.location.href = '/'
                }
            },
            'json'
        )
    })

    $(".txt_field input").keydown(function () {
        $(".warningBox").text("").removeClass("shake-horizontal")
        $(".label-input").removeClass('text-warning')
        $(".txt_field").removeClass('warning')
    })

    
})