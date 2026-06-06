<div class="page-head"><h1><?= e($user['name'] ?? 'Người dùng') ?></h1><a class="btn secondary" href="/users">Quay lại</a></div>
<div class="panel">
  <p><b>Email:</b> <?= e($user['email'] ?? '') ?></p>
  <p><b>Vai trò:</b> <?= e($user['role'] ?? '') ?></p>
  <p><b>Mã GV:</b> <?= e($user['lecturer_code'] ?? '-') ?></p>
  <p><b>Khoa:</b> <?= e($user['department'] ?? '-') ?></p>
  <p><b>Cấp:</b> <?= e($user['level'] ?? '-') ?></p>
</div>
