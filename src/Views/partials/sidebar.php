<aside class="sidebar">
  <div class="brand"><?= e(config('app.name')) ?></div>
  <a class="<?= route_is('/dashboard') ? 'active' : '' ?>" href="/dashboard">Dashboard</a>
  <a class="<?= route_is('/rooms') ? 'active' : '' ?>" href="/rooms">Phòng</a>
  <a class="<?= route_is('/rooms/available') ? 'active' : '' ?>" href="/rooms/available">Phòng trống</a>
  <?php if (!auth()->isAdmin()): ?>
    <a class="<?= route_is('/bookings/my') ? 'active' : '' ?>" href="/bookings/my">Booking của tôi</a>
  <?php endif; ?>
  <?php if (auth()->isAdmin()): ?>
    <a href="/bookings">Duyệt booking</a>
    <a href="/users">Người dùng</a>
    <a href="/amenities">Tiện ích</a>
    <a href="/time-slots">Ca học</a>
    <a href="/schedules">Lịch lớp</a>
  <?php endif; ?>
  <a href="/notifications">Thông báo</a>
  <a href="/profile">Hồ sơ</a>
</aside>
