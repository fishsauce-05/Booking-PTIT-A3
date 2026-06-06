<?php $isEdit = !empty($room); ?>
<div class="page-head"><h1><?= $isEdit ? 'Sửa phòng' : 'Thêm phòng' ?></h1></div>
<form class="panel" method="post" action="<?= $isEdit ? '/rooms/' . e($room['room_id']) : '/rooms' ?>">
  <?= csrf_field() ?><?= $isEdit ? method_field('PUT') : '' ?>
  <div class="grid cols-2">
    <div class="form-row"><label>Tên phòng</label><input name="room_name" value="<?= e($room['room_name'] ?? '') ?>" required></div>
    <div class="form-row"><label>Tòa</label><input name="building" value="<?= e($room['building'] ?? '') ?>" required></div>
    <div class="form-row"><label>Tầng</label><input name="floor" type="number" value="<?= e($room['floor'] ?? 1) ?>" required></div>
    <div class="form-row"><label>Sức chứa</label><input name="capacity" type="number" value="<?= e($room['capacity'] ?? 40) ?>" required></div>
    <div class="form-row"><label>Loại</label><select name="room_type"><option value="lecture">Lecture</option><option value="lab" <?= ($room['room_type'] ?? '') === 'lab' ? 'selected' : '' ?>>Lab</option><option value="meeting" <?= ($room['room_type'] ?? '') === 'meeting' ? 'selected' : '' ?>>Meeting</option></select></div>
    <div class="form-row checkbox"><input name="is_active" type="checkbox" <?= ($room['is_active'] ?? 1) ? 'checked' : '' ?>><label>Đang sử dụng</label></div>
  </div>
  <div class="form-actions"><button>Lưu</button><a class="btn secondary" href="/rooms">Hủy</a></div>
</form>
