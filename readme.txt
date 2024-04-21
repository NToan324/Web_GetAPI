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
    