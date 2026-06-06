<?php if (!empty($pagination) && $pagination['pages'] > 1): ?>
  <div class="actions">
    <?php for ($i = 1; $i <= $pagination['pages']; $i++): ?>
      <a class="btn secondary" href="?page=<?= $i ?>"><?= $i ?></a>
    <?php endfor; ?>
  </div>
<?php endif; ?>
