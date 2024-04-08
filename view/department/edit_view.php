<?php
if (!defined('ROOT_PATH')) {
    die('Can not access');
}
$titlePage = "Btec - Update Department";
$errorUpdate  = $_SESSION['error_update_department'] ?? null;
?>
<?php require 'view/partials/header_view.php'; ?>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Update Department
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
        <a class="btn btn-primary" href="index.php?c=department&m=index"> List Departments</a>
        <div class="card mt-3">
            <div class="card-header bg-primary">
                <h5 class="card-title text-white"> Update Department</h5>
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data" method="post" action="index.php?c=department&m=handle-edit&id=<?= $info['id']; ?>">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group mb-3">
                                <label>Name</label>
                                <input class="form-control" type="text" name="name" value="<?= $info['name']; ?>" />
                                <?php if(!empty($errorUpdate['name'])): ?>
                                    <span class="text-danger"><?= $errorUpdate['name']; ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="form-group mb-3">
                                <label>Name's Leader</label>
                                <input class="form-control" type="text" name="leader" value="<?= $info['leader']; ?>" />
                                <?php if(!empty($errorUpdate['leader'])): ?>
                                    <span class="text-danger"><?= $errorUpdate['leader']; ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="form-group mb-3">
                                <label> Logo </label>
                                <input type="file" class="form-control" name="logo" />
                                <?php if(!empty($errorUpdate['logo'])): ?>
                                    <span class="text-danger"><?= $errorUpdate['logo']; ?></span>
                                <?php endif; ?>
                                <br/>
                                <img
                                    width="50%"
                                    class="img-fluid"
                                    alt="<?= $info['name']; ?>"
                                    src="public/uploads/images/<?= $info['logo']; ?>"
                                />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group mb-3">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option
                                        value="1"
                                        <?= $info['status'] == 1 ? 'selected' : null; ?>
                                    > Active</option>
                                    <option
                                        value="0"
                                        <?= $info['status'] == 0 ? 'selected' : null; ?>
                                    > Deactive</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label>Beginning Date</label>
                                <input 
                                    value="<?= $info['date_beginning']; ?>"
                                    type="date"
                                    class="form-control"
                                    name="beginning_date"
                                />
                            </div>
                            <button class="btn btn-primary" type="submit" name="btnSave">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require 'view/partials/footer_view.php'; ?>