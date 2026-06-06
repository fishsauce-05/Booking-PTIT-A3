<div class="page-head"><h1>Đổi mật khẩu</h1></div>
<form class="panel" method="post" action="/change-password">
  <?= csrf_field() ?>
  <div class="form-row"><label>Mật khẩu mới</label><input name="password" type="password" required></div>
  <div class="form-row"><label>Xác nhận mật khẩu</label><input name="password_confirmation" type="password" required></div>
  <button>Cập nhật</button>
</form>
