src/ chứa source code của cả bài
asset/ chứa các data cần thiết (ví dụ ảnh)
vendor/ thư mục chứa thư viện
.env -> biến môi trường
temp/ -> để mấy cái không biết có cần dùng hay không, không cần thì sau này xoá.


--- src ---
controllers, models, db, routes -> của BE
views  -> từ FE đổi tên thành -> của FE
composer.* -> thư mục này của thư viện

--- Running project ---
1. Clone project về

2. Tạo database 'social_media' trong phpMyAdmin.

3. Chạy copy file src/db/db.sql và chạy trong phpMyAdmin tạo các bảng và data.
** Không cần để ý hai folder migrations với seeders trong db đâu. FILE 'db.sql' LÀ ĐỦ **

4. Khi chạy code, tên miền gốc phải nằm trong src,
    Tức là: localhost:PORT/path/to/src là tên miền gốc
    Ví dụ src nằm trong web_restapi thì domain là localhost:PORT/web_restapi/src
    Để dùng api thì gọi domain/"đường dẫn của api"


--- API RESPONESE --- 
api response theo chuẩn định dạng JSON (chưa biết thì google coi khoảng 3p)

success:
{
    "success": true,        // trạng thái có thành công hay không
    "message": "message if success",      // thông điệp khi thành công
    "data": data từ cái request             // ví dụ nếu request đăng kí thì data là dữ liệu từ cái form đăng kí
}

failed:
{
    "success": false,
    "message": thông điệp khi không thành công
}


    