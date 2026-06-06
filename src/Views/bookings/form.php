<?php $isEdit = !empty($booking); ?>
<div class="page-head"><h1><?= $isEdit ? 'Sửa booking' : 'Tạo booking' ?></h1></div>
<form class="panel" method="post" action="<?= $isEdit ? '/bookings/' . e($booking['booking_id']) : '/bookings' ?>">
  <?= csrf_field() ?><?= $isEdit ? method_field('PUT') : '' ?>
  <div class="grid cols-2">
    <div class="form-row"><label>Phòng</label><select name="room_id"><?php foreach ($rooms as $room): ?><option value="<?= e($room['room_id']) ?>" <?= ($booking['room_id'] ?? '') === $room['room_id'] ? 'selected' : '' ?>><?= e($room['room_name']) ?> - <?= e($room['building']) ?></option><?php endforeach; ?></select></div>
    <div class="form-row"><label>Ca học</label><select name="time_slot_id"><?php foreach ($timeSlots as $slot): ?><option value="<?= e($slot['time_slot_id']) ?>" <?= ($booking['time_slot_id'] ?? '') === $slot['time_slot_id'] ? 'selected' : '' ?>><?= e($slot['slot_name']) ?> (<?= e($slot['start_time']) ?>-<?= e($slot['end_time']) ?>)</option><?php endforeach; ?></select></div>
    <div class="form-row"><label>Ngày đặt</label><input name="booking_date" type="date" value="<?= e($booking['booking_date'] ?? date('Y-m-d')) ?>" required></div>
  </div>
  <div class="form-row"><label>Ghi chú</label><textarea name="note"><?= e($booking['note'] ?? '') ?></textarea></div>
  <div class="form-actions"><button>Lưu</button><a class="btn secondary" href="/bookings/my">Hủy</a></div>
</form>
