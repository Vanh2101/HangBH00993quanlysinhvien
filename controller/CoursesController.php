<?php
// import model
require 'model/CoursesModel.php';
require 'model/DepartmentModel.php';
$m = trim($_GET['m'] ?? 'index'); //ham mac dinh trong controller ten la index
$m = strtolower($m); //viet thuowng tat ca ten ham

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
    case 'handle-edit':
        handleEdit();
        break;
    case 'edit':
        edit();
        break;
    case 'delete':
        delete();
        break;
    default:
        index();
        break;
}
function edit()
{
    if (!isLoginUser()) {
        header("Location:index.php");
        exit();
    }
    $course_id = $_GET['id'] ?? null;
    if (!$course_id || !is_numeric($course_id)) {
        header("Location:index.php?c=courses");
        exit();
    }
    $course = getDetailCourseById($course_id);
    if (!$course) {
        header("Location:index.php?c=courses");
        exit();
    }

    $departments = getAllDataDepartments();
    require 'view/courses/edit_view.php';
}

function handleEdit()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['btnSave'])) {
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $department_id = $_POST['department_id'] ?? '';
            $status = $_POST['status'] ?? '';

            $result = updateCourseById($name, $department_id, $status, $id);

            if ($result) {
                header("Location:index.php?c=courses&state=success");
                exit();
            } else {
                // Handle error message here
            }
        }
    }
}


function delete()
{
    $id = $_GET['id'] ?? null;
    if ($id) {
        $result = deleteCourseById($id);
        if ($result) {
            header("Location:index.php?c=courses&state=success");
            exit();
        } else {
            
        }
    }
}
function Add(){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $department_id = $_POST['department_id'];
        $status = $_POST['status'];
        
        if (empty($name) || empty($department_id) || empty($status)) {
            echo "Vui lòng nhập đầy đủ thông tin!";
            return;
        }        
        $success = addNewCourse($name, $department_id, $status);
        if ($success) {
            echo "Thêm khóa học thành công!";
        } else {
            echo "Có lỗi xảy ra khi thêm khóa học!";
        }
    } else {
        $departments = getAllDataDepartments();
        require 'view/courses/add_view.php';
    }
}


function index() {
    if(!isLoginUser()){
        header("Location:index.php");
        exit();
    }
    $keyword = trim($_GET['product_search'] ?? ''); 
    $keyword= strip_tags($keyword);
    $page = trim($_GET['page'] ?? null);
    $page =(is_numeric($page) && $page > 0) ? $page :1;
    $linkPage = createLink([
        'c' => 'courses',
        'm' => 'index',
        'page' => '{page}',
        'search' => $keyword
    ]);   
    $totalItems =getAllCourses($keyword); // goi ten ham trong model
    $totalItems = count($totalItems);
    $courses = []; 
    if (!empty($keyword)) {  
        $courses = searchCoursesByProduct($keyword);
    } else { 
        $courses = getAllCoursesFromDB();
    }
    $departments = getAllDataDepartments();

    $departmentNames = [];
    foreach ($departments as $department) {
        $departmentNames[$department['id']] = $department['name'];
    }
    $panigate = pagigate($linkPage, $totalItems, $page, $keyword, 3);
    $start = $panigate ['start'] ?? 0;
    $courses =getAllCoursesByPage($keyword, $start, 3);
    $htmlPage = $panigate['pagination'] ?? null;

    require 'view/courses/index_view.php';
}

function handleAdd()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // kiểm tra thông tin
        $_SESSION['error_add_courses'] = [];
        $name = $_POST['name'] ?? '';
        $department_id = $_POST['department_id'] ?? '';
        $status = $_POST['status'] ?? '';

        if (empty($name)) {
            $_SESSION['error_add_courses']['name'] = 'Enter name of courses, please';
        } else {
            $_SESSION['error_add_courses']['name'] = null;
        }

        if (empty($department_id)) {
            $_SESSION['error_add_courses']['department_id'] = 'Choose a department, please';
        } else {
            $_SESSION['error_add_courses']['department_id'] = null;
        }
        

        // kiểm tra lỗi
        $flagCheckingError = false;
        foreach ($_SESSION['error_add_courses'] as $error) {
            if (!empty($error)) {
                $flagCheckingError = true;
                break;
            }
        }

        if (!$flagCheckingError && isset($_POST['btnSave'])) {
            $result = addNewCourse($name, $department_id, $status);

            if ($result) {
                header("Location:index.php?c=courses&state=success");
                exit();
            } else {
                header("Location:index.php?c=courses&m=add&state=error");
                exit();
            }
        } else {
            header("Location:index.php?c=courses&m=add&state=fail");
            exit();
        }
    }
}