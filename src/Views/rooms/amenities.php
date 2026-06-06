<div class="page-head"><h1>Tiện ích: <?= e($room['room_name'] ?? '') ?></h1></div>
<form class="panel" method="post" action="/rooms/<?= e($room['room_id']) ?>/amenities">
  <?= csrf_field() ?>
  <table><tr><th>Chọn</th><th>Số lượng</th><th>Hoạt động</th><th>Trạng thái</th><th>Ghi chú</th></tr>
  <?php foreach ($amenities as $amenity): $current = null; foreach ($roomAmenities as $ra) { if ($ra['amenity_id'] === $amenity['amenity_id']) $current = $ra; } ?>
    <tr><td><label class="checkbox"><input type="checkbox" name="amenity_id[]" value="<?= e($amenity['amenity_id']) ?>" <?= $current ? 'checked' : '' ?>><?= e($amenity['name']) ?></label></td><td><input name="quantity[]" type="number" value="<?= e($current['quantity'] ?? 1) ?>"></td><td><input name="working_quantity[]" type="number" value="<?= e($current['working_quantity'] ?? 1) ?>"></td><td><select name="status[]"><option value="available">available</option><option value="broken">broken</option><option value="maintenance">maintenance</option></select></td><td><input name="note[]" value="<?= e($current['note'] ?? '') ?>"></td></tr>
  <?php endforeach; ?>
  </table>
  <div class="form-actions"><button>Lưu</button><a class="btn secondary" href="/rooms/<?= e($room['room_id']) ?>">Hủy</a></div>
</form>
