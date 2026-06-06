# PTIT Booking

Ứng dụng đặt phòng học viết bằng pure PHP theo mô hình MVC server-rendered.

## Chạy nhanh

```bash
composer dump-autoload
php database/migrate.php
php database/seed.php
php -S 127.0.0.1:8000 -t public
```

Tài khoản mẫu:

- Admin: `admin@ptit.edu.vn` / `password`
- Giảng viên: `lecturer@ptit.edu.vn` / `password`

## Chức năng

- Đăng nhập, đăng xuất, đổi mật khẩu, quên mật khẩu dạng demo.
- Dashboard theo vai trò.
- Admin quản lý users, rooms, amenities, time slots, class schedules, bookings, notifications.
- Lecturer xem phòng trống, tạo booking, xem booking của mình, hủy booking đang chờ.
- Duyệt/từ chối booking, tự tạo thông báo cho giảng viên.
- Giao diện render bằng PHP view, không cần JWT.
# Booking-PTIT-A3
