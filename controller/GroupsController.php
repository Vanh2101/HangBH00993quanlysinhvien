<?php
require 'model/DepartmentModel.php';
require 'model/CoursesModel.php';
require 'model/GroupsModel.php';

// m = ten cua ham nam trong file controller trong thu muc controller 
$m = trim($_GET['m'] ?? 'index'); // ham mac dinh trong controller ten la index
$m = strtolower($m); // viet thuong tat ca ten ham

switch($m){
    case 'index':
        index();
        break;
    case 'add':
        Add();
        break;
    case 'handle-add':
        handleAdd();
        break;
    case 'delete':
        handleDelete();
        break;
    case 'edit':
        edit();
        break;
    case 'handle-edit':
        handleEdit();
        break;
    default:
        index();
        break;
}

function handleEdit(){
    if(isset($_POST['btnSave'])) {
        $id = trim($_GET['id'] ?? null);
        $id = is_numeric($id) ? $id : 0;
        $info = getDetailGroupsById($id); // goi ten ham trong model

        $name = trim($_POST['name'] ?? null);
        $name = strip_tags($name);

        $departmentId = trim($_POST['department_id'] ?? null);
        $departmentId = strip_tags($departmentId);

        $status = trim($_POST['status'] ?? null);
        $status = $status === '0' || $status === '1' ? $status : 0;

        // kiem tra thong tin
        $_SESSION['error_update_courses'] = [];
        if(empty($name)){
            $_SESSION['error_update_courses']['name'] = 'Enter name of course, please';
        } else {
            $_SESSION['error_update_courses']['name'] = null;
        }
        if(empty($departmentId)){
            $_SESSION['error_update_courses']['department_id'] = 'Enter name of department, please';
        } else {
            $_SESSION['error_update_courses']['department_id'] = null;
        }
        $flagCheckingError = false;
        foreach($_SESSION['error_update_courses'] as $error){
            if(!empty($error)){
                $flagCheckingError = true;
                break;
            }
        }
        if(!$flagCheckingError){
            // khong co loi - insert du lieu vao database
            if(isset($_SESSION['error_update_courses'])){
                unset($_SESSION['error_update_courses']);
            }
            $slug = slug_string($name);
            $update = updateCoursesById(
                $name,
                $slug,
                $departmentId,
                $status,
                $id
            );
            if($update){
                // update thanh cong
                header("Location:index.php?c=courses&state=success");
            } else {
                header("Location:index.php?c=courses&m=edit&id={$id}&state=error");
            }
        } else {
            // co loi - quay lai form
            header("Location:index.php?c=courses&m=edit&id={$id}&state=failure");
        }
    }
}

function edit(){
    $departments = getAllDataDepartments();// goi du lieu cho phan choose trong department model
      // phai dang nhap moi duoc su dung chuc nang nay.
      if(!isLoginUser()){
        header("Location:index.php");
        exit();
    }
    $id = trim($_GET['id'] ?? null);
    $id = is_numeric($id) ? $id : 0; // is_numeric : kiem tra co phai la so hay ko ?
    $info = getDetailCoursesById($id); // goi ham trong model
    if(!empty($info)){
        $departments = getAllDataDepartments();// goi du lieu cho phan choose trong department model
        // co du lieu trong database
        // hien thi giao dien - thong tin chi tiet du lieu
        require 'view/courses/edit_view.php';
    } else {
        $departments = getAllDataDepartments();// goi du lieu cho phan choose trong department model
        // khong co du lieu trong database
        // thong bao 1 giao dien loi
        require 'view/error_view.php';
    }
}

function handleDelete(){
    // phai dang nhap moi duoc su dung chuc nang nay.
    if(!isLoginUser()){
        header("Location:index.php");
        exit();
    }
    $id = trim($_GET['id'] ?? null);
    $id = is_numeric($id) ? $id : 0;
    $delete = deleteCoursesById($id); // goi ten ham trong model
    if($delete){
        // xoa thanh cong
        header("Location:index.php?c=courses&state_del=success");
    } else {
        // xoa that bai
        header("Location:index.php?c=courses&state_del=failure");
    }
}

function handleAdd(){
    if(isset($_POST['btnSave'])){
        $name = trim($_POST['name'] ?? null);
        $name = strip_tags($name);

        $departmentId = trim($_POST['department_id'] ?? null);
        $departmentId = strip_tags($departmentId);

        $status = trim($_POST['status'] ?? null);
        $status = $status === '0' || $status === '1' ? $status : 0;

        // kiem tra thong tin
        $_SESSION['error_add_courses'] = [];
        if(empty($name)){
            $_SESSION['error_add_courses']['name'] = 'Enter name of Course, please';
        } else {
            $_SESSION['error_add_courses']['name'] = null;
        }
        if(empty($departmentId)){
            $_SESSION['error_add_courses']['department_id'] = 'Choose name of Department, please';
        } else {
            $_SESSION['error_add_courses']['department_id'] = null;
        }
        $flagCheckingError = false;
        foreach($_SESSION['error_add_courses'] as $error){
            if(!empty($error)){
                $flagCheckingError = true;
                break;
            }
        }

        // tien hanh check lai 
        if(!$flagCheckingError){
            // tien hanh insert vao database
            $slug = slug_string($name);
            $insert = insertCourses($name, $slug, $departmentId, $status);
            if($insert){
                header("Location:index.php?c=courses&state=success");
            } else {
                header("Location:index.php?c=courses&m=add&state=error");
            }
        } else {
            // thong bao loi cho nguoi dung biet
            header("Location:index.php?c=courses&m=add&state=fail");
        }
    }
}

function Add() {
    $departments = getAllDataDepartments();// goi du lieu cho phan choose trong department model
    require 'view/courses/add_view.php';
}
function index(){
    // phai dang nhap moi duoc su dung chuc nang nay.
    if(!isLoginUser()){
        header("Location:index.php");
        exit();
    }
    $keyword = trim($_GET['search'] ?? null);
    $keyword = strip_tags($keyword);
    $page = trim($_GET['page'] ?? null);
    $page = (is_numeric($page) && $page > 0) ? $page : 1;
    $linkPage = createLink([
        'c' => 'courses',
        'm' => 'index',
        'page' => '{page}',
        'search' => $keyword
    ]);
    $totalItems = getAllDataCourses($keyword); // goi ten ham trong model
    $totalItems = count($totalItems);
    // courses
    $panigate = pagigate($linkPage, $totalItems, $page, $keyword, 2);
    $start = $panigate['start'] ?? 0;
    $courses = getAllDataCoursesByPage($keyword, $start, 2);
    $htmlPage = $panigate['pagination'] ?? null;
    require 'view/courses/index_view.php';
}
