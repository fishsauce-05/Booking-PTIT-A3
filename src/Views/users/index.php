<div class="page-head"><h1>Người dùng</h1><a class="btn" href="/users/create">Thêm người dùng</a></div>
<table><tr><th>Tên</th><th>Email</th><th>Vai trò</th><th>Trạng thái</th><th></th></tr>
<?php foreach ($users as $user): ?>
  <tr>
    <td><?= e($user['name']) ?></td><td><?= e($user['email']) ?></td><td><?= e($user['role']) ?></td><td><?= $user['is_active'] ? 'Hoạt động' : 'Khóa' ?></td>
    <td class="actions"><a class="btn secondary" href="/users/<?= e($user['user_id']) ?>">Xem</a><a class="btn secondary" href="/users/<?= e($user['user_id']) ?>/edit">Sửa</a></td>
  </tr>
<?php endforeach; ?>
</table>
