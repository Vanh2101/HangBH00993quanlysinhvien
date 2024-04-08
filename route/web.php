<?php 
// localhost/management-student/index.php?c=login&m=index
// c = ten cua controller nam trong thu muc controller
$c = trim($_GET['c'] ?? 'login'); // controller mac dinh la login
$c = ucfirst($c); // viet hoa chu cai dau

switch($c){
    case 'Login':
        require "controller/LoginController.php";
        break;
    case 'Dashboard':
        require "controller/DashoadController.php";
        break;
    case 'Department':
        require "controller/DepartmentControlller.php";
        break;
    case 'Courses':
        require 'controller/CoursesController.php';
        break;
    case 'Groups':
        require 'controller/GroupsController.php';
        break;
    default:
        require "controller/LoginController.php";
        break;
}