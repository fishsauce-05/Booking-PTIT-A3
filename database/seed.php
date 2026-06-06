<?php

require dirname(__DIR__) . '/bootstrap/app.php';

use App\Core\Database;

$now = date('Y-m-d H:i:s');
$password = password_hash('password', PASSWORD_DEFAULT);

Database::statement('INSERT INTO users (user_id, name, email, password_hash, role, is_active, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', ['u_admin', 'Quản trị viên', 'admin@ptit.edu.vn', $password, 'admin', 1, $now, $now]);
Database::statement('INSERT INTO users (user_id, name, email, password_hash, role, is_active, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', ['u_lecturer', 'Nguyễn Văn Giảng', 'lecturer@ptit.edu.vn', $password, 'lecturer', 1, $now, $now]);
Database::statement('INSERT INTO lecturers (lecturer_id, user_id, lecturer_code, department, level) VALUES (?, ?, ?, ?, ?)', ['l_001', 'u_lecturer', 'GV001', 'Công nghệ thông tin', 'normal']);

foreach ([
    ['r_a101', 'A101', 'A', 1, 80, 'lecture', 1],
    ['r_a202', 'A202', 'A', 2, 45, 'lecture', 1],
    ['r_b301', 'B301 Lab', 'B', 3, 35, 'lab', 1],
    ['r_c101', 'C101 Meeting', 'C', 1, 20, 'meeting', 1],
] as $room) {
    Database::statement('INSERT INTO rooms (room_id, room_name, building, floor, capacity, room_type, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)', $room);
}

foreach ([
    ['a_projector', 'Máy chiếu', 'Projector phục vụ giảng dạy'],
    ['a_mic', 'Micro', 'Micro không dây'],
    ['a_pc', 'Máy tính', 'Máy tính phòng học'],
    ['a_ac', 'Điều hòa', 'Hệ thống điều hòa'],
] as $amenity) {
    Database::statement('INSERT INTO amenities (amenity_id, name, description) VALUES (?, ?, ?)', $amenity);
}

foreach ([
    ['r_a101', 'a_projector', 1, 1, 'available', ''],
    ['r_a101', 'a_mic', 2, 2, 'available', ''],
    ['r_b301', 'a_pc', 35, 32, 'available', '3 máy cần bảo trì'],
    ['r_b301', 'a_ac', 2, 2, 'available', ''],
] as $item) {
    Database::statement('INSERT INTO room_amenities (room_id, amenity_id, quantity, working_quantity, status, note) VALUES (?, ?, ?, ?, ?, ?)', $item);
}

foreach ([
    ['ts_1', 'Ca 1', '07:00', '09:00'],
    ['ts_2', 'Ca 2', '09:15', '11:15'],
    ['ts_3', 'Ca 3', '13:00', '15:00'],
    ['ts_4', 'Ca 4', '15:15', '17:15'],
] as $slot) {
    Database::statement('INSERT INTO time_slots (time_slot_id, slot_name, start_time, end_time) VALUES (?, ?, ?, ?)', $slot);
}

Database::statement(
    'INSERT INTO class_schedules (class_schedule_id, lecturer_id, room_id, time_slot_id, class_name, subject_name, start_date, end_date, weekday, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
    ['cs_001', 'l_001', 'r_a101', 'ts_1', 'D21CQCN01', 'Lập trình Web', date('Y-m-d'), date('Y-m-d', strtotime('+90 days')), 'mon', 'Lịch học kỳ']
);

Database::statement(
    'INSERT INTO bookings (booking_id, user_id, room_id, time_slot_id, booking_date, status, note, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
    ['b_001', 'u_lecturer', 'r_a202', 'ts_2', date('Y-m-d', strtotime('+1 day')), 'pending', 'Họp nhóm nghiên cứu', $now, $now]
);

Database::statement(
    'INSERT INTO notifications (notification_id, user_id, title, message, type, related_type, related_id, is_read, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
    ['n_001', 'u_lecturer', 'Chào mừng', 'Bạn có thể tạo booking phòng học từ menu Booking của tôi.', 'system', 'user', 'u_lecturer', 0, $now]
);

echo "Seeded successfully.\n";
