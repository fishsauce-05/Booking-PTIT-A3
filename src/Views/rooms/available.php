<div class="page-head"><h1>Phòng trống</h1></div>
<form class="panel" method="get" action="/rooms/available">
  <div class="grid cols-2"><div class="form-row"><label>Ngày</label><input name="date" type="date" value="<?= e($date) ?>"></div><div class="form-row"><label>Ca học</label><select name="time_slot_id"><?php foreach ($timeSlots as $ts): ?><option value="<?= e($ts['time_slot_id']) ?>" <?= $slot === $ts['time_slot_id'] ? 'selected' : '' ?>><?= e($ts['slot_name']) ?> (<?= e($ts['start_time']) ?>-<?= e($ts['end_time']) ?>)</option><?php endforeach; ?></select></div></div>
  <button>Tìm phòng</button>
</form>
<table><tr><th>Phòng</th><th>Tòa</th><th>Tầng</th><th>Sức chứa</th><th>Loại</th></tr><?php foreach ($rooms as $room): ?><tr><td><?= e($room['room_name']) ?></td><td><?= e($room['building']) ?></td><td><?= e($room['floor']) ?></td><td><?= e($room['capacity']) ?></td><td><?= e($room['room_type']) ?></td></tr><?php endforeach; ?></table>
