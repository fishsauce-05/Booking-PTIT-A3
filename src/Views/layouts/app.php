<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title ?? config('app.name')) ?></title>
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
  <div class="app">
    <?php require base_path('src/Views/partials/sidebar.php'); ?>
    <div class="main">
      <?php require base_path('src/Views/partials/navbar.php'); ?>
      <main class="content">
        <?php require base_path('src/Views/partials/alert.php'); ?>
        <?= $content ?>
      </main>
    </div>
  </div>
  <script src="/assets/js/app.js"></script>
</body>
</html>
