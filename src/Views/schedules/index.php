<?php
$weekdays = [
  'mon' => 'Thứ 2',
  'tue' => 'Thứ 3',
  'wed' => 'Thứ 4',
  'thu' => 'Thứ 5',
  'fri' => 'Thứ 6',
  'sat' => 'Thứ 7',
  'sun' => 'Chủ nhật',
];
?>
<div class="page-head">
    <h1>Lịch lớp</h1>

    <div class="actions">
        <a
            class="btn secondary"
            href="/schedules/import"
        >
            Import
        </a>

        <a
            class="btn"
            href="/schedules/create"
        >
            Thêm lịch
        </a>
    </div>
</div>

<table>
    <tr>
        <th>Lớp</th>
        <th>Môn</th>
        <th>GV</th>
        <th>Phòng</th>
        <th>Ca</th>
        <th>Thời gian</th>
        <th></th>
    </tr>

    <?php foreach ($schedules as $s): ?>

        <tr>
            <td>
                <?= e($s['class_name']) ?>
            </td>

            <td>
                <?= e($s['subject_name']) ?>
            </td>

            <td>
                <?= e($s['lecturer_name']) ?>
            </td>

            <td>
                <?= e($s['room_name']) ?>
            </td>

            <td>
                <?= e($s['slot_name']) ?>
            </td>

            <td>
                <?= e($weekdays[$s['weekday']] ?? $s['weekday']) ?>,
                <?= e($s['start_date']) ?> - <?= e($s['end_date']) ?>
            </td>

            <td class="actions">
                <a
                    class="btn secondary"
                    href="/schedules/<?= e($s['class_schedule_id']) ?>/edit"
                >
                    Sửa
                </a>

                <form
                    class="inline"
                    method="post"
                    action="/schedules/<?= e($s['class_schedule_id']) ?>"
                >
                    <?= csrf_field() ?>
                    <?= method_field('DELETE') ?>

                    <button
                        class="danger"
                        data-confirm="Xóa lịch?"
                    >
                        Xóa
                    </button>
                </form>
            </td>
        </tr>

    <?php endforeach; ?>
</table>