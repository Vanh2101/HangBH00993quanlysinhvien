<?php
if (!defined('ROOT_PATH')) {
    die('Can not access');
}
$titlePage = "BTEC - Courses";
$state = trim($_GET['state'] ?? null);
?>
<?php require 'view/partials/header_view.php'; ?>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Courses
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
        <a class="btn btn-primary btn-lg" href="index.php?c=courses&m=add">Add new Courses</a>
        <div class="row mt-3">
            <div class="col-sm-12 col-md-6">
                <form method="get" action="index.php">
                    <input type="hidden" name="c" value="courses">
                    <input type="text" name="product_search" id="product_search"
                        value="<?= htmlentities($keyword ?? ''); ?>" placeholder="Search" />
                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    <a class="btn btn-info btn-sm" href="index.php?c=courses">Back to lists</a>
                </form>
            </div>
        </div>
        <?php if ($state === 'success') : ?>
        <div class="my-3 text-success text-center">Action Successfully!</div>
        <?php endif; ?>

        <table class="table table-bordered table-striped my-3">
            <thead class="table-primary">
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Status</th>
                <th colspan="2" class="text-center" width="10%">Action</th>
            </thead>
            <tbody>
                <?php foreach ($courses ?? [] as $key => $item) : ?>
                <tr>
                    <td><?= $item['id']; ?></td>
                    <td><?= $item['name']; ?></td>
                    <td><?= isset($departmentNames[$item['department_id']]) ? $departmentNames[$item['department_id']] : 'Unknown'; ?></td>
                    
                    <td><?= $item['status'] == 1 ? 'Studying' : 'Complete'; ?></td>
                    <td>
                        <a class="btn btn-primary btn-sm"
                            href="index.php?c=courses&m=edit&id=<?= $item['id']; ?>">Edit</a>
                    </td>
                    <td>
                        <a class="btn btn-danger btn-sm"
                            href="index.php?c=courses&m=delete&id=<?= $item['id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?=$htmlPage; ?>
    </div>
</div>

<?php require 'view/partials/footer_view.php'; ?>