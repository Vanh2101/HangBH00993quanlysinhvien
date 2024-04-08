<?php
if (!defined('ROOT_PATH')) {
    die('Can not access');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Management student Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="public/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="public/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="public/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="public/assets/images/favicon.ico" />
</head>

<body>
    <?php
        $state = trim($_GET['state'] ?? null);
    ?>
    <div class="container-scroller">
        <!-- partial -->
        <div class="container-fluid">
            <!-- partial -->
            <div class="main-panel" style="min-height:100vh !important; width:100% !important;">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 offset-md-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title text-center mb-3">Login</h4>

                                    <?php if($state === 'error'): ?>
                                        <p class="text-center text-danger card-title"> Account invalid </p>
                                    <?php endif; ?>

                                    <form class="forms-sample" action="index.php?c=login&m=handle" method="post">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                                        </div>
                                        <button type="submit" class="btn btn-gradient-primary me-2" name="btnLogin">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    <div class="container-fluid d-flex justify-content-between">
                        <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © SE06205 2024</span>
                        <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"> Copyright © <a href="https://btec.fpt.edu.vn/" target="_blank">Btec</a> from FPT.com.vn</span>
                    </div>
                </footer>
                <!-- content-wrapper ends -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="public/assets/vendors/js/vendor.bundle.base.js"></script>
</body>

</html>