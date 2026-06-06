<div class="page-head">
  <h1>Booking của tôi</h1>
  <a class="btn" href="/bookings/create">Tạo booking</a>
</div>
<table>
  <tr>
    <th>Phòng</th>
    <th>Ngày</th>
    <th>Ca</th>
    <th>Trạng thái</th>
    <th>Ghi chú</th>
    <th></th>
  </tr>
  <?php foreach ($bookings as $b): ?>
    <tr>
      <td><?= e($b['room_name']) ?></td>
      <td><?= e($b['booking_date']) ?></td>
      <td><?= e($b['slot_name']) ?></td>
      <td><span class="badge <?= e($b['status']) ?>"><?= e($b['status']) ?></span></td>
      <td><?= e($b['note']) ?></td>
      <td class="actions">
        <a class="btn secondary" href="/bookings/<?= e($b['booking_id']) ?>">Xem</a>
        <?php if ($b['status'] === 'pending'): ?>
          <a class="btn secondary" href="/bookings/<?= e($b['booking_id']) ?>/edit">Sửa</a>
          <form class="inline" method="post" action="/bookings/<?= e($b['booking_id']) ?>/cancel">
            <?= csrf_field() ?>
            <button class="danger" data-confirm="Hủy booking này?">Hủy</button>
          </form>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
