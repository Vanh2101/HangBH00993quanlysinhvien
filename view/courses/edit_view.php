<?php
if (!defined('ROOT_PATH')) {
    die('Can not access');
}
$titlePage ="BTEC - Update Courses";
?>
<?php require 'view/partials/header_view.php'; ?>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Update Courses
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
            </li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <a class="btn btn-primary btn-lg" href="index.php?c=courses">List Courses</a>
        <div class="card mt-3">
            <div class="card-header bg-primary">
                <h5 class="card-title text-white mb-0">Update Courses</h5>
            </div>
            <div class="card-body">
                <form method="post" action="index.php?c=courses&m=handle-edit">
                    <input type="hidden" name="id" value="<?= $course['id']; ?>">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group mb-3">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="<?= $course['name']; ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label>Department</label>
                                <select class="form-control" name="department_id">
                                    <option value="">--Choose--</option>
                                    <?php foreach($departments as $item):?>
                                    <option value="<?= $item['id']; ?>"
                                        <?= ($item['id'] == $course['department_id']) ? 'selected' : ''; ?>>
                                        <?= $item['name']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group mb-3">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="1" <?= ($course['status'] == 1) ? 'selected' : ''; ?>> Active
                                    </option>
                                    <option value="0" <?= ($course['status'] == 0) ? 'selected' : ''; ?>> Deactive
                                    </option>
                                </select>
                            </div>
                            <button class="btn btn-primary" name="btnSave"> Save </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php require 'view/partials/footer_view.php'; ?>