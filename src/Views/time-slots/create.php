<div class="page-head">
    <h1>Thêm ca học</h1>
</div>

<form
    class="panel"
    method="post"
    action="/time-slots"
>
    <?= csrf_field() ?>

    <div class="grid cols-2">

        <div class="form-row">
            <label>Tên ca</label>

            <input
                name="slot_name"
                required
            >
        </div>

        <div></div>

        <div class="form-row">
            <label>Bắt đầu</label>

            <input
                name="start_time"
                type="time"
                required
            >
        </div>

        <div class="form-row">
            <label>Kết thúc</label>

            <input
                name="end_time"
                type="time"
                required
            >
        </div>

    </div>

    <button>
        Lưu
    </button>
</form>