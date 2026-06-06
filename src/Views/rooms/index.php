<div class="page-head">
  <h1>Phòng</h1>
  <?php if (auth()->isAdmin()): ?>
    <a class="btn" href="/rooms/create">Thêm phòng</a>
  <?php endif; ?>
</div>
<table>
  <tr>
    <th>Tên</th>
    <th>Tòa</th>
    <th>Tầng</th>
    <th>Sức chứa</th>
    <th>Loại</th>
    <th></th>
  </tr>
  <?php foreach ($rooms as $room): ?>
    <tr>
      <td><?= e($room['room_name']) ?></td>
      <td><?= e($room['building']) ?></td>
      <td><?= e($room['floor']) ?></td>
      <td><?= e($room['capacity']) ?></td>
      <td><?= e($room['room_type']) ?></td>
      <td class="actions">
        <a class="btn secondary" href="/rooms/<?= e($room['room_id']) ?>">Xem</a>
        <?php if (auth()->isAdmin()): ?>
          <a class="btn secondary" href="/rooms/<?= e($room['room_id']) ?>/edit">Sửa</a>
          <a class="btn secondary" href="/rooms/<?= e($room['room_id']) ?>/amenities">Tiện ích</a>
          <form class="inline" method="post" action="/rooms/<?= e($room['room_id']) ?>">
            <?= csrf_field() ?>
            <?= method_field('DELETE') ?>
            <button class="danger" data-confirm="Xóa phòng này?">Xóa</button>
          </form>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
