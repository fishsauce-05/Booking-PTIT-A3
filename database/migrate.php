<?php

require dirname(__DIR__) . '/bootstrap/app.php';

use App\Core\Database;

$pdo = Database::pdo();

// Tắt kiểm tra FK để DROP không bị lỗi phụ thuộc
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

foreach (['notifications','bookings','class_schedules','room_amenities','amenities','time_slots','rooms','lecturers','users'] as $table) {
    $pdo->exec("DROP TABLE IF EXISTS `{$table}`");
}

$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

// ── users ──────────────────────────────────────────────────────────────────
$pdo->exec("
CREATE TABLE `users` (
  `user_id`       VARCHAR(50)  NOT NULL,
  `name`          VARCHAR(255) NOT NULL,
  `email`         VARCHAR(100) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role`          ENUM('admin','lecturer') NOT NULL,
  `is_active`     TINYINT(1)   NOT NULL DEFAULT 1,
  `created_at`    TIMESTAMP    NULL DEFAULT NULL,
  `updated_at`    TIMESTAMP    NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

// ── lecturers ───────────────────────────────────────────────────────────────
$pdo->exec("
CREATE TABLE `lecturers` (
  `lecturer_id`   VARCHAR(50) NOT NULL,
  `user_id`       VARCHAR(50) NOT NULL,
  `lecturer_code` VARCHAR(15) NOT NULL,
  `department`    VARCHAR(255) DEFAULT NULL,
  `level`         ENUM('normal','vip') NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`lecturer_id`),
  UNIQUE KEY `lecturers_user_id_unique` (`user_id`),
  UNIQUE KEY `lecturers_code_unique` (`lecturer_code`),
  CONSTRAINT `fk_lecturer_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

// ── rooms ───────────────────────────────────────────────────────────────────
$pdo->exec("
CREATE TABLE `rooms` (
  `room_id`   VARCHAR(50) NOT NULL,
  `room_name` VARCHAR(50) NOT NULL,
  `building`  VARCHAR(50) NOT NULL,
  `floor`     TINYINT     NOT NULL,
  `capacity`  SMALLINT    NOT NULL,
  `room_type` ENUM('lecture','lab','meeting') NOT NULL,
  `is_active` TINYINT(1)  NOT NULL DEFAULT 1,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

// ── amenities ───────────────────────────────────────────────────────────────
$pdo->exec("
CREATE TABLE `amenities` (
  `amenity_id`  VARCHAR(50)  NOT NULL,
  `name`        VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`amenity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

// ── room_amenities ──────────────────────────────────────────────────────────
$pdo->exec("
CREATE TABLE `room_amenities` (
  `room_id`          VARCHAR(50) NOT NULL,
  `amenity_id`       VARCHAR(50) NOT NULL,
  `quantity`         TINYINT     NOT NULL DEFAULT 1,
  `working_quantity` TINYINT     NOT NULL DEFAULT 1,
  `status`           ENUM('available','broken','maintenance') NOT NULL DEFAULT 'available',
  `note`             VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`room_id`, `amenity_id`),
  CONSTRAINT `fk_ra_room`
    FOREIGN KEY (`room_id`)    REFERENCES `rooms`     (`room_id`)    ON DELETE CASCADE,
  CONSTRAINT `fk_ra_amenity`
    FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`amenity_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

// ── time_slots ──────────────────────────────────────────────────────────────
$pdo->exec("
CREATE TABLE `time_slots` (
  `time_slot_id` VARCHAR(50)  NOT NULL,
  `slot_name`    VARCHAR(255) NOT NULL,
  `start_time`   TIME         NOT NULL,
  `end_time`     TIME         NOT NULL,
  PRIMARY KEY (`time_slot_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

// ── class_schedules ─────────────────────────────────────────────────────────
$pdo->exec("
CREATE TABLE `class_schedules` (
  `class_schedule_id` VARCHAR(50)  NOT NULL,
  `lecturer_id`       VARCHAR(50)  NOT NULL,
  `room_id`           VARCHAR(50)  NOT NULL,
  `time_slot_id`      VARCHAR(50)  NOT NULL,
  `class_name`        VARCHAR(50)  NOT NULL,
  `subject_name`      VARCHAR(255) NOT NULL,
  `start_date`        DATE         NOT NULL,
  `end_date`          DATE         NOT NULL,
  `weekday`           ENUM('mon','tue','wed','thu','fri','sat','sun') NOT NULL,
  `notes`             VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`class_schedule_id`),
  CONSTRAINT `fk_cs_lecturer`
    FOREIGN KEY (`lecturer_id`)  REFERENCES `lecturers`  (`lecturer_id`)  ON DELETE CASCADE,
  CONSTRAINT `fk_cs_room`
    FOREIGN KEY (`room_id`)      REFERENCES `rooms`      (`room_id`)      ON DELETE CASCADE,
  CONSTRAINT `fk_cs_timeslot`
    FOREIGN KEY (`time_slot_id`) REFERENCES `time_slots` (`time_slot_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

// ── bookings ────────────────────────────────────────────────────────────────
$pdo->exec("
CREATE TABLE `bookings` (
  `booking_id`       VARCHAR(50) NOT NULL,
  `user_id`          VARCHAR(50) NOT NULL,
  `room_id`          VARCHAR(50) NOT NULL,
  `time_slot_id`     VARCHAR(50) NOT NULL,
  `booking_date`     DATE        NOT NULL,
  `status`           ENUM('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `note`             VARCHAR(255) DEFAULT NULL,
  `rejection_reason` VARCHAR(255) DEFAULT NULL,
  `approved_by`      VARCHAR(50)  DEFAULT NULL,
  `approved_at`      TIMESTAMP    NULL DEFAULT NULL,
  `created_at`       TIMESTAMP    NULL DEFAULT NULL,
  `updated_at`       TIMESTAMP    NULL DEFAULT NULL,
  PRIMARY KEY (`booking_id`),
  CONSTRAINT `fk_b_user`
    FOREIGN KEY (`user_id`)      REFERENCES `users`      (`user_id`)      ON DELETE CASCADE,
  CONSTRAINT `fk_b_room`
    FOREIGN KEY (`room_id`)      REFERENCES `rooms`      (`room_id`)      ON DELETE CASCADE,
  CONSTRAINT `fk_b_timeslot`
    FOREIGN KEY (`time_slot_id`) REFERENCES `time_slots` (`time_slot_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_b_approver`
    FOREIGN KEY (`approved_by`)  REFERENCES `users`      (`user_id`)      ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

// ── notifications ────────────────────────────────────────────────────────────
$pdo->exec("
CREATE TABLE `notifications` (
  `notification_id` VARCHAR(50)  NOT NULL,
  `user_id`         VARCHAR(50)  NOT NULL,
  `title`           VARCHAR(255) NOT NULL,
  `message`         VARCHAR(500) NOT NULL,
  `type`            ENUM('booking_approved','booking_rejected','system') NOT NULL,
  `related_type`    ENUM('booking','room','schedule','user') DEFAULT NULL,
  `related_id`      VARCHAR(50)  DEFAULT NULL,
  `is_read`         TINYINT(1)   NOT NULL DEFAULT 0,
  `created_at`      TIMESTAMP    NULL DEFAULT NULL,
  `read_at`         TIMESTAMP    NULL DEFAULT NULL,
  PRIMARY KEY (`notification_id`),
  CONSTRAINT `fk_n_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

echo "Migrated successfully.\n";
