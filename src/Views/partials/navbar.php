<header class="navbar">
  <strong><?= e($title ?? 'PTIT Booking') ?></strong>
  <div class="actions">
    <span class="muted"><?= e(auth()->user()['name'] ?? '') ?></span>
    <form class="inline" method="post" action="/logout"><?= csrf_field() ?><button class="secondary">Đăng xuất</button></form>
  </div>
</header>
