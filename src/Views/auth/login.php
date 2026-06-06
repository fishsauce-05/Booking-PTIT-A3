<style>
  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

  body.guest {
    width: 100vw;
    height: 100vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    font-family: Roboto, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    font-size: 1rem;
    color: #212529;
    line-height: 1.5;
    padding: 0;
    background: #fff;
    place-items: unset;
    background-image: none;
  }

  /* ── Main wrapper ── */
  .main-content {
    flex: 1;
    display: flex;
    width: 100%;
    overflow: hidden;
  }

  /* ── Cột trái: 75%, chỉ ảnh nền ── */
  .left-col {
    flex: 0 0 75%;
    background-image: url('https://qldt.ptit.edu.vn/assets/images/AQ1.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }

  /* ── Cột phải: 25%, flex-column ── */
  .right-col {
    flex: 0 0 25%;
    max-width: 25%;
    display: flex;
    flex-direction: column;
    margin: 0;
    padding: 0;
    position: relative;
    overflow-y: auto;
  }

  /* Inner wrapper — căn giữa logo + card */
  .rc-inner {
    display: flex;
    flex-direction: column;
    flex: 1;
    align-items: center;
    padding: 3rem 0 0;   /* pt-5 */
    background-color: transparent;
  }

  /* Logo */
  .rc-logo {
    display: block;
    max-width: 200px;
    width: 100%;
    border: none;
    outline: none;
    padding: 1.5rem 0;   /* py-4 */
  }

  /* Card */
  .card {
    width: 100%;
    background-color: #fff;
    border: 1px solid rgba(0, 0, 0, .125);
    border-radius: .25rem;
    padding: 0;
    margin: 0;
  }

  .card-body {
    padding: .5rem;   /* p-2 */
    text-align: center;
  }

  /* ── Alert ── */
  .lp-alert {
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 13px;
    margin-bottom: 8px;
    text-align: left;
  }

  .lp-alert.error   { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
  .lp-alert.success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }

  /* ── Input group (Bootstrap v4 clone) ── */
  .inp-group {
    display: flex;
    align-items: stretch;
    width: 100%;
    margin-bottom: .25rem;   /* mb-1 */
  }

  .inp-addon {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #e9ecef;
    border: 1px solid #ced4da;
    white-space: nowrap;
  }

  /* Icon bên trái */
  .inp-addon-left {
    border-right: none;
    border-radius: .25rem 0 0 .25rem;
  }

  /* Eye button bên phải (40px) */
  .inp-addon-right {
    border-left: none;
    border-radius: 0 .25rem .25rem 0;
    width: 40px;
    cursor: pointer;
    background: none;
    border-top: 1px solid #ced4da;
    border-right: 1px solid #ced4da;
    border-bottom: 1px solid #ced4da;
    transition: background-color .15s;
  }

  .inp-addon-right:hover { background-color: #dee2e6; }

  /* Input field */
  .inp-ctrl {
    flex: 1;
    min-width: 0;
    padding: .375rem .75rem !important;
    font-size: 1rem !important;
    line-height: 1.5 !important;
    color: #495057 !important;
    background-color: #fff !important;
    border: 1px solid #ced4da !important;
    border-radius: 0 !important;
    outline: none !important;
    box-shadow: none !important;
    width: auto !important;
    margin: 0 !important;
    height: auto !important;
  }

  /* Input cuối hàng (email — không có addon phải) */
  .inp-ctrl-last {
    border-radius: 0 .25rem .25rem 0 !important;
  }

  /* ── Quên mật khẩu ── */
  .forgot-wrap {
    text-align: right;
    padding: .25rem 0;  /* py-1 */
  }

  .forgot-link {
    color: #ad171c;
    font-style: italic;
    font-size: .875rem;
    text-decoration: none;
    cursor: pointer;
    padding-right: 0;
    padding-top: .25rem;
    padding-bottom: .25rem;
    display: inline-block;
  }

  .forgot-link:hover { text-decoration: underline; }

  /* ── Buttons ── */
  .btn-block {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    width: 100%;
    padding: .375rem .75rem;
    border: none;
    border-radius: .25rem;
    font-size: 1rem;
    line-height: 1.5;
    font-weight: 400;
    cursor: pointer;
    color: #fff;
    text-decoration: none;
    transition: filter .15s;
  }

  .btn-block:hover { filter: brightness(1.1); }

  .btn-primary { background-color: #ad171c; }
  .btn-ms      { background-color: #0078D4; }

  .my-2  { margin-top: .5rem; margin-bottom: .5rem; }
  .mb-1  { margin-bottom: .25rem; }

  /* Bell icon màu riêng — giữ nguyên như bản gốc */
  .notifi-bell { color: rgb(223, 45, 45); }

  /* ── Footer ── */
  .login-footer {
    flex-shrink: 0;
    width: 100%;
    height: 40px;
    line-height: 40px;
    background: #ad171c;
    text-align: center;
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
  }

  /* ── Responsive ── */
  @media (max-width: 768px) {
    .left-col  { display: none; }
    .right-col { flex: 1; max-width: 100%; }
  }
</style>

<div class="main-content">

  <!-- Cột trái: ảnh nền, không màu -->
  <div class="left-col"></div>

  <!-- Cột phải: 25%, clone bản gốc PTIT -->
  <div class="right-col">
    <div class="rc-inner">

      <!-- Title -->
      <div style="text-align:center; padding: 0 1rem 0.5rem;">
        <div style="font-size:1.1rem; font-weight:700; color:#ad171c; line-height:1.4;">
          HỆ THỐNG ĐẶT PHÒNG
        </div>
        <div style="font-size:0.85rem; color:#555; margin-top:2px;">
          Tòa nhà A3 – Học viện Công nghệ Bưu chính Viễn thông
        </div>
      </div>

      <!-- Logo -->
      <img class="rc-logo"
           src="data:image/webp;base64,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"
           alt="PTIT Logo">

      <!-- Card bao quanh form — giống hệt bản gốc -->
      <div class="card">
        <div class="card-body">

          <!-- Alert -->
          <?php if ($msg = \App\Core\Session::flash('error')): ?>
            <div class="lp-alert error"><?= e($msg) ?></div>
          <?php endif; ?>
          <?php if ($msg = \App\Core\Session::flash('success')): ?>
            <div class="lp-alert success"><?= e($msg) ?></div>
          <?php endif; ?>

          <form action="/login" method="POST" autocomplete="on">
            <?= csrf_field() ?>

            <!-- Input: Email (icon trái + input) -->
            <div class="inp-group mb-1">
              <span class="inp-addon inp-addon-left">
                <i class="fa fa-user"></i>
              </span>
              <input type="text" name="email" class="inp-ctrl inp-ctrl-last"
                     value="admin@ptit.edu.vn"
                     autocomplete="off" required autofocus>
            </div>

            <!-- Input: Password (icon trái + input + eye phải) -->
            <div class="inp-group" style="padding-top: .5rem;">
              <span class="inp-addon inp-addon-left">
                <i class="fa fa-lock"></i>
              </span>
              <input type="password" name="password" id="lp-pwd" class="inp-ctrl"
                     autocomplete="current-password" required>
              <button type="button" class="inp-addon inp-addon-right" onclick="togglePwd()">
                <i class="fa fa-eye-slash" id="lp-eye"></i>
              </button>
            </div>

            <!-- Quên mật khẩu -->
            <div class="forgot-wrap">
              <a href="/forgot-password" class="forgot-link">Quên mật khẩu </a>
            </div>

            <!-- Nút Đăng nhập -->
            <button type="submit" class="btn-block btn-primary my-2">
              <i class="fas fa-sign-in-alt"></i> Đăng nhập
            </button>

            <!-- Nút Microsoft 365 -->
            <button type="button" class="btn-block btn-ms mb-1">
              <span>Đăng nhập với Microsoft office 365</span>
            </button>

            <!-- Nút Thông báo -->
            <a href="/notifications" class="btn-block btn-primary mb-1">
              <i class="fa-solid fa-bell notifi-bell"></i> Xem thông báo - tin tức
            </a>

          </form>
        </div>
      </div><!-- /.card -->

    </div><!-- /.rc-inner -->
  </div><!-- /.right-col -->

</div><!-- /.main-content -->

<!-- Footer -->
<footer class="login-footer">
  HỌC VIỆN CÔNG NGHỆ BƯU CHÍNH VIỄN THÔNG
</footer>

<script>
function togglePwd() {
  var input = document.getElementById('lp-pwd');
  var icon  = document.getElementById('lp-eye');
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.replace('fa-eye-slash', 'fa-eye');
  } else {
    input.type = 'password';
    icon.classList.replace('fa-eye', 'fa-eye-slash');
  }
}
</script>
