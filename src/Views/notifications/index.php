<div class="page-head"><h1>Thông báo</h1></div>
<table><tr><th>Tiêu đề</th><th>Nội dung</th><th>Loại</th><th>Thời gian</th><th>Trạng thái</th><th></th></tr>
<?php foreach ($notifications as $n): ?>
  <tr><td><?= e($n['title']) ?></td><td><?= e($n['message']) ?></td><td><?= e($n['type']) ?></td><td><?= e($n['created_at']) ?></td><td><?= $n['is_read'] ? 'Đã đọc' : 'Chưa đọc' ?></td><td><?php if (!$n['is_read']): ?><form method="post" action="/notifications/<?= e($n['notification_id']) ?>/read"><?= csrf_field() ?><button class="secondary">Đã đọc</button></form><?php endif; ?></td></tr>
<?php endforeach; ?>
</table>
