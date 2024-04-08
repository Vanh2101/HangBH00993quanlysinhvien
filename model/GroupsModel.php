<?php
require_once "database/database.php";

function updateGroupsById(
    $departmentId,
    $termId,
    $name,
    $slug,
    $studentNumber,
    $status,
    $id
){
    $checkUpdate = false;
    $db = connectionDb();
    $sql = "UPDATE `groups` SET `department_id` = :departmentId, `term_id` = :termId, `name` = :nameGroup, `slug` = :slug, `student_numbers` = :studentNumber `status` = :statusGroup, `updated_at` = :updated_at WHERE `id` = :id AND `deleted_at` IS NULL";
    $updateTime = date('Y-m-d H:i:s');
    $stmt = $db->prepare($sql);
    if($stmt){
        $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_STR);
        $stmt->bindParam(':termId', $termId, PDO::PARAM_STR);
        $stmt->bindParam(':nameGroup', $name, PDO::PARAM_STR);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindParam(':studentNumber', $studentNumber, PDO::PARAM_STR);
        $stmt->bindParam(':statusGroup', $status, PDO::PARAM_INT);
        $stmt->bindParam(':updated_at', $updateTime, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            $checkUpdate = true;
        }
    }
    disconnectDb($db);
    return $checkUpdate;
}

function getDetailGroupsById($id = 0){
    $sql = "SELECT * FROM `groups` WHERE `id` = :id AND `deleted_at` IS NULL";
    $db = connectionDb();
    $data = [];
    $stmt = $db->prepare($sql);
    if($stmt){
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectDb($db);
    return $data;
}

function deleteGroupsById($id = 0){
    $sql = "UPDATE `groups` SET `deleted_at` = :deleted_at WHERE `id` = :id";
    $db = connectionDb();
    $checkDelete = false;
    $deleteTime = date("Y-m-d H:i:s");
    $stmt = $db->prepare($sql);
    if($stmt){
        $stmt->bindParam(':deleted_at', $deleteTime, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            $checkDelete = true;
        }
    }
    disconnectDb($db);
    return $checkDelete;
}

function getAllDataGroups($keyword = null){
    $db   = connectionDb();
    $key  = "%{$keyword}%";
    $sql  = "SELECT * FROM `groups` WHERE (`name` LIKE :nameGroup) AND `deleted_at` IS NULL";
    $stmt = $db->prepare($sql);
    $data = [];
    if($stmt){
        $stmt->bindParam(':nameGroup', $key, PDO::PARAM_STR);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectDb($db);
    return $data;
}

function getAllDataGroupsByPage($keyword = null, $start = 0, $limit = 2){
    $key = "%{$keyword}%";
    $sql = "SELECT * FROM `groups` WHERE (`name` LIKE :nameGroup) AND `deleted_at` IS NULL  LIMIT :startData, :limitData";
    $db = connectionDb();
    $stmt = $db->prepare($sql);
    $data = [];
    if($stmt){
        $stmt->bindParam(':nameCourse', $key, PDO::PARAM_STR);
        $stmt->bindParam(':startData', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limitData', $limit, PDO::PARAM_INT);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectDb($db);
    return $data;
}

function insertGroups( $departmentId, $termId, $name, $slug, $studentNumber, $status){
    // viet cau lenh sql insert vao bang course
    $sqlInsert = "INSERT INTO `groups`(`department_id`, `term_id`, `name`, `slug`, `student_numbers` , `status`, `created_at`) VALUES (:departmentId, :termId, :nameGroup, :slug, :studentNumber :statusGroup, :createdAt)";
    $checkInsert = false;
    $db = connectionDb();
    $stmt = $db->prepare($sqlInsert);
    $currentDate = date('Y-m-d H:i:s');
    if($stmt){
        $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_STR);
        $stmt->bindParam(':termId', $termId, PDO::PARAM_STR);
        $stmt->bindParam(':nameGroup', $name, PDO::PARAM_STR);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindParam(':studentNumber', $studentNumber, PDO::PARAM_STR);
        $stmt->bindParam(':statusGroup', $status, PDO::PARAM_INT);
        $stmt->bindParam(':createdAt', $currentDate, PDO::PARAM_STR);
        if($stmt->execute()){
            $checkInsert = true;
        }
    }
    disconnectDb($db); // ngat ket noi toi database
    // tra ve true insert thanh cong va nguoc lai
    return $checkInsert;
}