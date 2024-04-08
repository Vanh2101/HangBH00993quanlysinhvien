<?php 
// truy van du lieu
require 'database/database.php';

// viet ham kiem tra dang nhap cua nguoi dung
// kiem tra tai khoan dang nhap co ton tai trong database khong?
function checkLoginUser($username, $password){
    // $username va $password : du lieu ma nguoi dung nhap tu form login
    $db = connectionDb(); // co duoc ket noi toi database
    // viet cau lenh sql truy van

    $sql = "SELECT a.*, u.`full_name`, u.`email`, u.`phone` FROM `accounts` AS a INNER JOIN `users` AS u ON a.user_id = u.id WHERE `username` = :user AND `password` = :pass AND a.`status` = 1 LIMIT 1";

    $statement = $db->prepare($sql); // kiem tra cau lenh sql

    $dataUser = []; // mang rong chua thong tin nguoi dung
    if($statement){
        // kiem tra tham so truyen vao sql
        $statement->bindParam(':user', $username, PDO::PARAM_STR);
        $statement->bindParam(':pass', $password, PDO::PARAM_STR);
        // thuc thi cau lenh sql
        if($statement->execute()){
            // kiem tra xem truy van sql co du lieu tra ve hay ko?
            if($statement->rowCount() > 0){
                // co du lieu trong db, lay du lieu do ra
                $dataUser = $statement->fetch(PDO::FETCH_ASSOC);
            }
        }
    }
    disconnectDb($db); // dong ket noi db
    return $dataUser; // tra ve du lieu chua thong tin nguoi dung
}