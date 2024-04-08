<?php
if (!defined('ROOT_PATH')) {
    die('Can not access');
}
$modulePage = trim($_GET['c'] ?? null);
$modulePage = strtolower($modulePage);
?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="public/assets/images/faces/face1.jpg" alt="profile">
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">
                        <?= getSessionUsername(); ?>
                    </span>
                    <!-- <span class="text-secondary text-small">Project Manager</span> -->
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item <?= $modulePage === 'dashboard' ? 'active' : null; ?> ">
            <a class="nav-link" href="index.php?c=dashboard">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item <?= $modulePage === 'department' ? 'active' : null; ?>">
            <a class="nav-link" href="index.php?c=department">
                <span class="menu-title">Departments</span>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
        </li>
        <li class="nav-item <?= $modulePage === 'courses' ? 'active' : null; ?> ">
            <a class="nav-link" href="index.php?c=courses">
                <span class="menu-title">Courses</span>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
        </li>
        <li class="nav-item <?= $modulePage === 'group' ? 'active' : null; ?> ">
            <a class="nav-link" href="index.php?c=group">
                <span class="menu-title">Class rooms</span>
                <i class="mdi mdi-chart-bar menu-icon"></i>
            </a>
        </li>
        <li class="nav-item <?= $modulePage === 'account' ? 'active' : null; ?> ">
            <a class="nav-link" href="index.php?c=account">
                <span class="menu-title">Accounts</span>
                <i class="mdi mdi-table-large menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
                <span class="menu-title">Users</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-medical-bag menu-icon"></i>
            </a>
            <div class="collapse" id="general-pages">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="#"> Students </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"> Teachers </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"> Admin </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>