<?php

use App\Models\Category;
use App\Libraries\MyClass;

$id = $_REQUEST['id'];
$category = Category::find($id);
if ($category == null) {
  MyClass::set_flash('message', ['msg' => 'Lỗi trang 404', 'type' => 'danger']);
  header("location:index.php?option=category");
}
$list = Category::where('status', '!=', 0)
  ->orderBy('created_at', 'DESC')
  ->get();
$parent_id_html = '';
foreach ($list as $parent_id) {
  $parent_id_html .= "<option value='$parent_id->parent_id'>$parent_id->name</option>";
}

?>

<?php require_once "../views/backend/header.php"; ?>
<!-- CONTENT -->
<form action="index.php?option=category&cat=process" method="post" enctype="multipart/form-data">
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="d-inline">Cập nhật danh mục</h1>
          </div>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header text-right">
          <a href="index.php?option=category" class="btn btn-sm btn-info">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
            Về danh sách
          </a>
          <button class="btn btn-sm btn-success" type="submit" name="CAPNHAT">
            <i class="fa fa-save" aria-hidden="true"></i>
            Lưu
          </button>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <input type="hidden" name="id" value="<?= $category->id; ?>">
                <label>Tên danh mục (*)</label>
                <input type="text" value="<?= $category->name; ?>" name="name" class="form-control">
              </div>
              <div class="mb-3">
                <label>Slug</label>
                <input type="text" value="<?= $category->slug; ?>" name="slug" class="form-control">
              </div>
              <div class="mb-3">
                <label>Mô tả</label>
                <textarea name="description" class="form-control"><?= $category->description; ?></textarea>
              </div>
              <div class="mb-3">
                <label>Danh mục cha (*)</label>
                <select name="parent_id" class="form-control">
                  <option value="0">None</option>
                  <?= $parent_id_html; ?>
                </select>
              </div>
              <div class="mb-3">
                <label>Hình đại diện</label>
                <input type="file" name="image" class="form-control">
              </div>
              <div class="mb-3">
                <label>Trạng thái</label>
                <select name="status" class="form-control">
                  <option value="1" <?= ($category->status == 1) ? 'selected' : ''; ?>>Xuất bản</option>
                  <option value="2" <?= ($category->status == 2) ? 'selected' : ''; ?>>Chưa xuất bản</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</form>
<!-- END CONTENT-->
<?php require_once "../views/backend/footer.php"; ?>