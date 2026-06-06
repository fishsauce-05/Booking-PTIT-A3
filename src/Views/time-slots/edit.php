<div class="page-head">
    <h1>Sửa ca học</h1>
</div>

<form
    class="panel"
    method="post"
    action="/time-slots/<?= e($slot['time_slot_id']) ?>"
>
    <?= csrf_field() ?>
    <?= method_field('PUT') ?>

    <div class="grid cols-2">

        <div class="form-row">
            <label>Tên ca</label>

            <input
                name="slot_name"
                value="<?= e($slot['slot_name']) ?>"
                required
            >
        </div>

        <div></div>

        <div class="form-row">
            <label>Bắt đầu</label>

            <input
                name="start_time"
                type="time"
                value="<?= e($slot['start_time']) ?>"
                required
            >
        </div>

        <div class="form-row">
            <label>Kết thúc</label>

            <input
                name="end_time"
                type="time"
                value="<?= e($slot['end_time']) ?>"
                required
            >
        </div>

    </div>

    <button>
        Lưu
    </button>
</form>