# Hướng dẫn cài đặt và chạy project

## Yêu cầu hệ thống

-   XAMPP (bao gồm Apache và MySQL) bản mới nhất
-   PHP bản mới nhất
-   Composer

## Các bước cài đặt

### 1. Tải và cài đặt XAMPP

-   Tải XAMPP từ trang chủ: [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
-   Cài đặt XAMPP và khởi động Apache và MySQL trong Control Panel của XAMPP.

### 2. Tải và cài đặt Composer

-   Tải Composer từ trang chủ: [https://getcomposer.org/](https://getcomposer.org/)
-   Cài đặt Composer theo hướng dẫn trên trang chủ.

### 3. Clone project từ GitHub

-   Mở terminal (Command Prompt hoặc Git Bash) và chạy lệnh sau để clone project:

    `git clone <URL của repository>`

-   Di chuyển vào thư mục project:

    `cd <tên thư mục của project>`

### 4. Cài đặt các gói PHP bằng Composer

-   Trong thư mục project, chạy lệnh sau để cài đặt các gói PHP cần thiết:

    `composer install`

### 5. Cấu hình Apache và MySQL

-   Đảm bảo Apache và MySQL đang chạy trong Control Panel của XAMPP.
-   Copy toàn bộ thư mục project vào thư mục `htdocs` của XAMPP. Ví dụ:

    `cp -r <tên thư mục của project> /path/to/xampp/htdocs/`

    (Thay thế `/path/to/xampp/htdocs/` bằng đường dẫn thực tế tới thư mục `htdocs` của bạn)

### 6. Tạo database trong phpMyAdmin

-   Mở trình duyệt web và truy cập vào `http://localhost/phpmyadmin`.
-   Tìm đến file `db.sql` trong `src/database/` để import dữ liệu.
-   **Cách 1**
    1.  Tạo một database mới tên `social_media`
    2.  Sao chép code từ file `db.sql` và dán vào tab `SQL`
    3.  Nhấn `Go` để import dữ liệu
-   **Cách 2**
    1. Chọn tab `Import`.
    2. Nhấn `Choose File` và chọn file `db.sql` trong thư mục project.
    3. Nhấn `Go` để import dữ liệu.

### 7. Chạy project

-   Mở trình duyệt web và truy cập vào `http://localhost/<tên thư mục của project>`.
