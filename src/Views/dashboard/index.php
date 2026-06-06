<div class="page-head"><h1>Dashboard</h1><a class="btn" href="/bookings/create">Tạo booking</a></div>
<div class="grid cols-4">
  <div class="stat"><span class="muted">Phòng</span><b><?= e($stats['rooms']) ?></b></div>
  <div class="stat"><span class="muted">Booking</span><b><?= e($stats['bookings']) ?></b></div>
  <div class="stat"><span class="muted">Chờ duyệt</span><b><?= e($stats['pending']) ?></b></div>
  <div class="stat"><span class="muted">Người dùng</span><b><?= e($stats['users']) ?></b></div>
</div>
<div class="panel">
  <h2>Booking gần đây</h2>
  <table><tr><th>Người đặt</th><th>Phòng</th><th>Ngày</th><th>Ca</th><th>Trạng thái</th></tr>
    <?php foreach ($recent as $booking): ?>
      <tr><td><?= e($booking['user_name']) ?></td><td><?= e($booking['room_name']) ?></td><td><?= e($booking['booking_date']) ?></td><td><?= e($booking['slot_name']) ?></td><td><span class="badge <?= e($booking['status']) ?>"><?= e($booking['status']) ?></span></td></tr>
    <?php endforeach; ?>
  </table>
</div>
