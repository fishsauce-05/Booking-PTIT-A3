<?php if ($message = \App\Core\Session::flash('success')): ?>
  <div class="alert success"><?= e($message) ?></div>
<?php endif; ?>
<?php if ($message = \App\Core\Session::flash('error')): ?>
  <div class="alert error"><?= e($message) ?></div>
<?php endif; ?>
