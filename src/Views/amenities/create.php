<div class="page-head"><h1>Thêm tiện ích</h1></div>
<form class="panel" method="post" action="/amenities"><?= csrf_field() ?><div class="form-row"><label>Tên</label><input name="name" required></div><div class="form-row"><label>Mô tả</label><textarea name="description"></textarea></div><button>Lưu</button></form>
