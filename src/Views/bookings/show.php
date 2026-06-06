<div class="page-head"><h1>Chi tiết booking</h1><a class="btn secondary" href="<?= auth()->isAdmin() ? '/bookings' : '/bookings/my' ?>">Quay lại</a></div>
<div class="panel">
  <p>
    <b>Người đặt:</b> <?= e($booking['user_name'] ?? '') ?>
  </p>
  <p>
    <b>Phòng:</b> <?= e($booking['room_name'] ?? '') ?> - <?= e($booking['building'] ?? '') ?>
  </p>
  <p>
    <b>Ngày:</b> <?= e($booking['booking_date'] ?? '') ?>
  </p>
  <p>
    <b>Ca:</b> <?= e($booking['slot_name'] ?? '') ?> (<?= e($booking['start_time'] ?? '') ?> - <?= e($booking['end_time'] ?? '') ?>)
  </p>
  <p>
    <b>Trạng thái:</b> <span class="badge <?= e($booking['status'] ?? '') ?>"><?= e($booking['status'] ?? '') ?></span>
  </p>
  <p>
    <b>Ghi chú:</b> <?= e($booking['note'] ?? '-') ?>
  </p>
  <p>
    <b>Lý do từ chối:</b> <?= e($booking['rejection_reason'] ?? '-') ?>
  </p>
</div>
