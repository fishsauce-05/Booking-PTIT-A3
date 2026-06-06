<div class="page-head">
    <h1>Sửa tiện ích</h1>
</div>

<form
    class="panel"
    method="post"
    action="/amenities/<?= e($amenity['amenity_id']) ?>"
>
    <?= csrf_field() ?>
    <?= method_field('PUT') ?>

    <div class="form-row">
        <label>Tên</label>

        <input
            name="name"
            value="<?= e($amenity['name']) ?>"
            required
        >
    </div>

    <div class="form-row">
        <label>Mô tả</label>

        <textarea name="description"><?= e($amenity['description']) ?></textarea>
    </div>

    <button>
        Lưu
    </button>
</form>