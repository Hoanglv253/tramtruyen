# Trạm Truyện

Website đọc truyện mẫu dùng PHP, MySQL, HTML, CSS và JavaScript.

## Chạy trên máy

1. Cài PHP có extension `pdo_mysql` và MySQL Server. MySQL Workbench dùng để quản lý database.
2. Trong MySQL Workbench, mở và chạy `database/schema.sql` để tạo database `tram_truyen` và dữ liệu mẫu.
3. Nếu cần, đặt biến môi trường `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`. Mặc định là `127.0.0.1`, `tram_truyen`, `root`, mật khẩu trống.
4. Mở terminal tại thư mục này và chạy `php -S localhost:8000`.
5. Truy cập `http://localhost:8000`.

Nếu MySQL chưa được cài hoặc chưa cấu hình, trang chủ vẫn hiển thị truyện mẫu để bạn xem giao diện. Nội dung demo của chương đầu tiên nằm trong `database/schema.sql`.

## Trang hiện có

- `index.php`: trang chủ, tìm kiếm và lọc theo thể loại.
- `story.php?id=1`: chi tiết truyện và danh sách chương.
- `chapter.php?story=1&chapter=1`: trang đọc, chỉnh cỡ chữ và đổi nền.
- `config/database.php`: kết nối PDO; thông tin database có thể cấu hình qua biến môi trường.
