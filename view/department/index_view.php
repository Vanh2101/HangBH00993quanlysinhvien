<?php
if (!defined('ROOT_PATH')) {
    die('Can not access');
}
$titlePage = "Btec - Department";
$state = trim($_GET['state'] ?? null);
?>
<?php require 'view/partials/header_view.php'; ?>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Department
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
        <a class="btn btn-primary btn-sm" href="index.php?c=department&m=add"> Add Department</a>

        <div class="row mt-3">
            <div class="col-sm-12 col-md-6">
                <input type="text" id="keyword" value="<?= htmlentities($keyword); ?>" />
                <button id="btnSearchDepartment" class="btn btn-primary btn-sm">Search</button>
                <a class="btn btn-info btn-sm" href="index.php?c=department"> Back to lists</a>
            </div>
        </div>
        
        <?php if($state === 'success'): ?>
            <div class="my-3 text-success text-center">
                Action Successfully !
            </div>
        <?php endif; ?>
        <table class="table table-bordered table-striped my-3">
            <thead class="table-primary">
                <th>ID</th>
                <th>Name</th>
                <th>Logo</th>
                <th>Leader</th>
                <th>Date</th>
                <th>Status</th>
                <th colspan="2" class="text-center" width="10%">Action</th>
            </thead>
            <tbody>
                <?php foreach($departments as $key => $item): ?>
                    <tr>
                        <td><?= $item['id']; ?></td>
                        <td><?= $item['name']; ?></td>
                        <td width="10%">
                            <img
                                style="width: 100%; height: 100%;"
                                class="img-fluid"
                                alt="<?= $item['name'] ?>"
                                src="public/uploads/images/<?= $item['logo']; ?>"
                            />
                        </td>
                        <td><?= $item['leader']; ?></td>
                        <td><?= date('d-m-Y', strtotime($item['date_beginning'])); ?></td>
                        <td><?= $item['status'] == 1 ? 'Active' : 'Deactive'; ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="index.php?c=department&m=edit&id=<?= $item['id']; ?>"> Edit</a>
                        </td>
                        <td>
                            <a class="btn btn-danger btn-sm" href="index.php?c=department&m=delete&id=<?= $item['id']; ?>"> Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?= $htmlPage; ?>
    </div>
</div>

<?php require 'view/partials/footer_view.php'; ?>
<script>
    let btnSearch = document.getElementById('btnSearchDepartment');
    btnSearch.addEventListener('click', function(){
        let txtKeyword = document.getElementById('keyword');
        let keyword = txtKeyword.value.trim();
        if(keyword != ''){
            window.location.href = "index.php?c=department&search="+keyword;
        } else {
            alert('Enter keyword, please');
        }
    });
</script>