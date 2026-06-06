<div class="page-head">
    <h1>Duyệt booking</h1>
</div>

<table>
    <tr>
        <th>Người đặt</th>
        <th>Phòng</th>
        <th>Ngày</th>
        <th>Ca</th>
        <th>Trạng thái</th>
        <th>Ghi chú</th>
        <th></th>
    </tr>

    <?php foreach ($bookings as $b): ?>

        <tr>
            <td>
                <?= e($b['user_name']) ?>
            </td>

            <td>
                <?= e($b['room_name']) ?>
            </td>

            <td>
                <?= e($b['booking_date']) ?>
            </td>

            <td>
                <?= e($b['slot_name']) ?>
            </td>

            <td>
                <span class="badge <?= e($b['status']) ?>">
                    <?= e($b['status']) ?>
                </span>
            </td>

            <td>
                <?= e($b['note']) ?>
            </td>

            <td class="actions">
                <a
                    class="btn secondary"
                    href="/bookings/<?= e($b['booking_id']) ?>"
                >
                    Xem
                </a>

                <?php if ($b['status'] === 'pending'): ?>

                    <form
                        class="inline"
                        method="post"
                        action="/bookings/<?= e($b['booking_id']) ?>/approve"
                    >
                        <?= csrf_field() ?>

                        <button class="ok">
                            Duyệt
                        </button>
                    </form>

                    <form
                        class="inline"
                        method="post"
                        action="/bookings/<?= e($b['booking_id']) ?>/reject"
                    >
                        <?= csrf_field() ?>

                        <input
                            name="rejection_reason"
                            placeholder="Lý do từ chối"
                        >

                        <button class="danger">
                            Từ chối
                        </button>
                    </form>

                <?php endif; ?>
            </td>
        </tr>

    <?php endforeach; ?>
</table>