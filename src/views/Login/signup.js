
$(document).ready(function () {
    let submitBtn = $("#signup-submit-btn")
    //bắt sự kiện click nút đăng nhập
    submitBtn.click(function (e) {
        // chặn hành vi gửi form mặc định của button
        e.preventDefault()
        let email = $("#signup-email").val()
        let password = $("#signup-password").val()
        let name = $("#signup-name").val()

        // TODO: Validate user input
        /* 
            Kiểm tra input đầu vào của người dùng có hợp lệ không, không thì báo lỗi luôn
        */

        // Call api đăng kí
        $.post(`/signUp`, { name, email, password, submit: true }, function (res) {
            console.log(res)
            if (!res.success) { // Sign up failed
                //* res.message là thông báo lỗi
                // TODO: error when sign up, show error here
                /* 
                    Khi đăng kí lỗi thì hiển thị thông báo lỗi ở đây, lỗi lấy trong message ra
                */
                console.log(res.messagge)
            } else { // Sign up successfully
                // window.location.href = '/'
                // * res.data là object chứa name, email, password
                // TODO: back to login form with sign up data
                /* 
                    Chổ này đagnw nhập thành cônng nè, đem data quay về tragn login
                */

                console.log(res)
            }
        }, "json");
    })

    $(".txt_field input").keydown(function () {
        $(".warningBox").text("").removeClass("shake-horizontal")
        $(".label-input").removeClass('text-warning')
        $(".txt_field").removeClass('warning')
    })

    
})