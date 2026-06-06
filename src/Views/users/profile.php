<div class="page-head"><h1>Hồ sơ</h1><a class="btn" href="/change-password">Đổi mật khẩu</a></div>
<div class="panel">
  <p><b>Tên:</b> <?= e($user['name'] ?? '') ?></p>
  <p><b>Email:</b> <?= e($user['email'] ?? '') ?></p>
  <p><b>Vai trò:</b> <?= e($user['role'] ?? '') ?></p>
  <p><b>Mã giảng viên:</b> <?= e($user['lecturer_code'] ?? '-') ?></p>
  <p><b>Khoa:</b> <?= e($user['department'] ?? '-') ?></p>
</div>
