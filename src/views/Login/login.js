
$(document).ready(function () {
    let submitBtn = $("#login-submit-btn")
    //bắt sự kiện click nút đăng nhập
    submitBtn.click(function (e) {
        // chặn hành vi gửi form mặc định của button
        e.preventDefault()
        let email = $("#email").val()
        let password = $("#password").val()

        // TODO: validate user input and show error

        //call api kiểm tra đăng nhập
        $.post(`/login`, { email, password, submit: true }, function (data) {
            console.log(data)
            if (!data.success) {
                //không thành công thì hiện lỗi
                $(".warningBox").text(data.message).addClass("shake-horizontal")
                $(".txt_field").addClass('warning')
                $(".label-input").addClass('text-warning')
            } else {
                window.location.href = '/'
            }
        }, "json");
    })

    $(".txt_field input").keydown(function () {
        $(".warningBox").text("").removeClass("shake-horizontal")
        $(".label-input").removeClass('text-warning')
        $(".txt_field").removeClass('warning')
    })

    
})