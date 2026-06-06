<?php
$isEdit = !empty($user);
$canEditName = !$isEdit || (($user['user_id'] ?? '') === auth()->id());
?>
<div class="page-head"><h1><?= $isEdit ? 'Sửa người dùng' : 'Thêm người dùng' ?></h1></div>
<form class="panel" method="post" action="<?= $isEdit ? '/users/' . e($user['user_id']) : '/users' ?>">
  <?= csrf_field() ?><?= $isEdit ? method_field('PUT') : '' ?>
  <div class="grid cols-2">
    <div class="form-row"><label>Tên</label><input name="name" value="<?= e($user['name'] ?? '') ?>" <?= $canEditName ? 'required' : 'readonly' ?>></div>
    <div class="form-row"><label>Email</label><input name="email" type="email" value="<?= e($user['email'] ?? '') ?>" required></div>
    <div class="form-row"><label>Mật khẩu</label><input name="password" type="password" placeholder="<?= $isEdit ? 'Để trống nếu không đổi' : 'Mặc định: password' ?>"></div>
    <div class="form-row"><label>Vai trò</label><select name="role"><option value="admin" <?= ($user['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option><option value="lecturer" <?= ($user['role'] ?? 'lecturer') === 'lecturer' ? 'selected' : '' ?>>Lecturer</option></select></div>
    <div class="form-row"><label>Mã giảng viên</label><input name="lecturer_code" value="<?= e($user['lecturer_code'] ?? '') ?>"></div>
    <div class="form-row"><label>Khoa/Bộ môn</label><input name="department" value="<?= e($user['department'] ?? '') ?>"></div>
    <div class="form-row checkbox"><input name="is_active" type="checkbox" <?= ($user['is_active'] ?? 1) ? 'checked' : '' ?>><label>Đang hoạt động</label></div>
  </div>
  <div class="form-actions"><button>Lưu</button><a class="btn secondary" href="/users">Hủy</a></div>
</form>
