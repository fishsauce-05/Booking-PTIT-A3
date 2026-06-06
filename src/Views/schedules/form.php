<?php
$isEdit = !empty($schedule);
$weekdays = [
  'mon' => 'Thứ 2',
  'tue' => 'Thứ 3',
  'wed' => 'Thứ 4',
  'thu' => 'Thứ 5',
  'fri' => 'Thứ 6',
  'sat' => 'Thứ 7',
  'sun' => 'Chủ nhật',
];
?>
<div class="page-head"><h1><?= $isEdit ? 'Sửa lịch lớp' : 'Thêm lịch lớp' ?></h1></div>
<form class="panel" method="post" action="<?= $isEdit ? '/schedules/' . e($schedule['class_schedule_id']) : '/schedules' ?>">
  <?= csrf_field() ?><?= $isEdit ? method_field('PUT') : '' ?>
  <div class="grid cols-2">
    <div class="form-row"><label>Giảng viên</label><select name="lecturer_id"><?php foreach ($lecturers as $l): ?><option value="<?= e($l['lecturer_id']) ?>" <?= ($schedule['lecturer_id'] ?? '') === $l['lecturer_id'] ? 'selected' : '' ?>><?= e($l['name']) ?> - <?= e($l['lecturer_code']) ?></option><?php endforeach; ?></select></div>
    <div class="form-row"><label>Phòng</label><select name="room_id"><?php foreach ($rooms as $r): ?><option value="<?= e($r['room_id']) ?>" <?= ($schedule['room_id'] ?? '') === $r['room_id'] ? 'selected' : '' ?>><?= e($r['room_name']) ?></option><?php endforeach; ?></select></div>
    <div class="form-row"><label>Ca học</label><select name="time_slot_id"><?php foreach ($timeSlots as $ts): ?><option value="<?= e($ts['time_slot_id']) ?>" <?= ($schedule['time_slot_id'] ?? '') === $ts['time_slot_id'] ? 'selected' : '' ?>><?= e($ts['slot_name']) ?></option><?php endforeach; ?></select></div>
    <div class="form-row"><label>Thứ</label><select name="weekday"><?php foreach ($weekdays as $value => $label): ?><option value="<?= e($value) ?>" <?= ($schedule['weekday'] ?? '') === $value ? 'selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?></select></div>
    <div class="form-row"><label>Lớp</label><input name="class_name" value="<?= e($schedule['class_name'] ?? '') ?>" required></div>
    <div class="form-row"><label>Môn học</label><input name="subject_name" value="<?= e($schedule['subject_name'] ?? '') ?>" required></div>
    <div class="form-row"><label>Ngày bắt đầu</label><input name="start_date" type="date" value="<?= e($schedule['start_date'] ?? date('Y-m-d')) ?>" required></div>
    <div class="form-row"><label>Ngày kết thúc</label><input name="end_date" type="date" value="<?= e($schedule['end_date'] ?? date('Y-m-d')) ?>" required></div>
  </div>
  <div class="form-row"><label>Ghi chú</label><textarea name="notes"><?= e($schedule['notes'] ?? '') ?></textarea></div>
  <button>Lưu</button>
</form>
