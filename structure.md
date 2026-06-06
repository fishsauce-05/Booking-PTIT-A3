Ok, chuyển sang **PHP fullstack render view**.

Cấu trúc nên là:

```txt
.
├── bootstrap/
│   └── app.php                         # Load env, config, Eloquent, router, session
│
├── public/
│   ├── index.php                       # Entry point
│   └── assets/
│       ├── css/
│       │   └── app.css
│       ├── js/
│       │   └── app.js
│       └── images/
│
├── config/
│   ├── app.php
│   ├── database.php
│   └── auth.php
│
├── routes/
│   ├── web.php                         # Route render HTML
│   └── api.php                         # Optional, nếu vẫn muốn vài API nhỏ
│
├── database/
│   ├── migrations/
│   ├── seeders/
│   ├── migrate.php
│   └── seed.php
│
├── src/
│   ├── Core/
│   │   ├── Database.php
│   │   ├── Router.php
│   │   ├── Request.php
│   │   ├── Response.php
│   │   ├── View.php                    # render file PHP trong Views
│   │   ├── Session.php
│   │   ├── Validator.php
│   │   └── Auth.php
│   │
│   ├── Middleware/
│   │   ├── AuthMiddleware.php
│   │   └── RoleMiddleware.php
│   │
│   ├── Models/
│   │   ├── User.php
│   │   ├── Lecturer.php
│   │   ├── Room.php
│   │   ├── Amenity.php
│   │   ├── RoomAmenity.php
│   │   ├── TimeSlot.php
│   │   ├── ClassSchedule.php
│   │   ├── Booking.php
│   │   └── Notification.php
│   │
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── UserController.php
│   │   ├── RoomController.php
│   │   ├── AmenityController.php
│   │   ├── TimeSlotController.php
│   │   ├── ClassScheduleController.php
│   │   ├── BookingController.php
│   │   └── NotificationController.php
│   │
│   ├── Services/
│   │   ├── AuthService.php
│   │   ├── UserService.php
│   │   ├── RoomService.php
│   │   ├── AmenityService.php
│   │   ├── TimeSlotService.php
│   │   ├── ClassScheduleService.php
│   │   ├── BookingService.php
│   │   └── NotificationService.php
│   │
│   ├── Repositories/
│   │   ├── UserRepository.php
│   │   ├── RoomRepository.php
│   │   ├── AmenityRepository.php
│   │   ├── TimeSlotRepository.php
│   │   ├── ClassScheduleRepository.php
│   │   ├── BookingRepository.php
│   │   └── NotificationRepository.php
│   │
│   └── Views/
│       ├── layouts/
│       │   ├── app.php                 # layout sau login
│       │   └── guest.php               # layout login
│       │
│       ├── partials/
│       │   ├── sidebar.php
│       │   ├── navbar.php
│       │   ├── alert.php
│       │   └── pagination.php
│       │
│       ├── auth/
│       │   ├── login.php
│       │   ├── forgot-password.php
│       │   └── change-password.php
│       │
│       ├── dashboard/
│       │   └── index.php
│       │
│       ├── users/
│       │   ├── index.php
│       │   ├── show.php
│       │   └── profile.php
│       │
│       ├── rooms/
│       │   ├── index.php
│       │   ├── show.php
│       │   ├── amenities.php
│       │   └── available.php
│       │
│       ├── amenities/
│       │   ├── index.php
│       │   ├── create.php
│       │   └── edit.php
│       │
│       ├── time-slots/
│       │   ├── index.php
│       │   ├── create.php
│       │   └── edit.php
│       │
│       ├── schedules/
│       │   ├── index.php
│       │   ├── create.php
│       │   ├── edit.php
│       │   └── import.php
│       │
│       ├── bookings/
│       │   ├── index.php               # Admin xem toàn bộ
│       │   ├── my.php                  # Lecturer xem booking của mình
│       │   ├── create.php
│       │   ├── edit.php
│       │   └── show.php
│       │
│       └── notifications/
│           └── index.php
│
├── storage/
│   └── logs/
├── vendor/
├── .env
├── .env.example
├── composer.json
└── README.md
```

Luồng xử lý:

```txt
GET /rooms
-> RoomController@index()
-> RoomService->listRooms()
-> View::render('rooms/index', data)
```

```txt
POST /bookings
-> BookingController@store()
-> BookingService->createBooking()
-> redirect('/bookings/my')
```

Với hướng này thì **không cần JWT nữa**. Dùng:

```txt
PHP Session
```

Auth sẽ là:

```txt
$_SESSION['user_id']
$_SESSION['role']
```

Package cần:

```bash
composer require illuminate/database vlucas/phpdotenv nikic/fast-route
```

ERD:
@startuml
hide circle
skinparam linetype ortho

entity "users" as users {
  * user_id : varchar(50) <<PK>>
  --
  name : nvarchar(255)
  email : varchar(100) <<unique>>
  password_hash : varchar(255)
  role : enum(admin, lecturer)
  is_active : tinyint(1)
  created_at : timestamp
  updated_at : timestamp
}

entity "lecturers" as lecturers {
  * lecturer_id : varchar(50) <<PK>>
  --
  user_id : varchar(50) <<FK, unique>>
  lecturer_code : varchar(15) <<unique>>
  department : nvarchar(255)
  level : enum(normal, vip)
}

entity "rooms" as rooms {
  * room_id : varchar(50) <<PK>>
  --
  room_name : varchar(50)
  building : varchar(50)
  floor : tinyint
  capacity : smallint
  room_type : enum(lecture, lab, meeting)
  is_active : tinyint(1)
}

entity "amenities" as amenities {
  * amenity_id : varchar(50) <<PK>>
  --
  name : nvarchar(255)
  description : nvarchar(255)
}

entity "room_amenities" as room_amenities {
  * room_id : varchar(50) <<PK, FK>>
  * amenity_id : varchar(50) <<PK, FK>>
  --
  quantity : tinyint
  working_quantity : tinyint
  status : enum(available, broken, maintenance)
  note : nvarchar(255)
}

entity "time_slots" as time_slots {
  * time_slot_id : varchar(50) <<PK>>
  --
  slot_name : nvarchar(255)
  start_time : time
  end_time : time
}

entity "class_schedules" as class_schedules {
  * class_schedule_id : varchar(50) <<PK>>
  --
  lecturer_id : varchar(50) <<FK>>
  room_id : varchar(50) <<FK>>
  time_slot_id : varchar(50) <<FK>>
  class_name : varchar(50)
  subject_name : nvarchar(255)
  start_date : date
  end_date : date
  weekday : enum(mon,tue,wed,thu,fri,sat,sun)
  notes : nvarchar(255)
}

entity "bookings" as bookings {
  * booking_id : varchar(50) <<PK>>
  --
  user_id : varchar(50) <<FK>>
  room_id : varchar(50) <<FK>>
  time_slot_id : varchar(50) <<FK>>
  booking_date : date
  status : enum(pending, approved, rejected, cancelled)
  note : nvarchar(255)
  rejection_reason : nvarchar(255)
  approved_by : varchar(50) <<FK>>
  approved_at : timestamp
  created_at : timestamp
  updated_at : timestamp
}

entity "notifications" as notifications {
  * notification_id : varchar(50) <<PK>>
  --
  user_id : varchar(50) <<FK>>
  title : nvarchar(255)
  message : nvarchar(500)
  type : enum(booking_approved, booking_rejected, system)
  related_type : enum(booking, room, schedule, user)
  related_id : varchar(50)
  is_read : tinyint(1)
  created_at : timestamp
  read_at : timestamp
}

users ||--o| lecturers : "có profile"
users ||--o{ bookings : "tạo"
users ||--o{ bookings : "duyệt"
users ||--o{ notifications : "nhận"

lecturers ||--o{ class_schedules : "phụ trách"

rooms ||--o{ class_schedules : "có lịch"
rooms ||--o{ bookings : "được đặt"
rooms ||--o{ room_amenities : "có"

amenities ||--o{ room_amenities : "được gán"

time_slots ||--o{ class_schedules : "áp dụng"
time_slots ||--o{ bookings : "áp dụng"

@enduml
