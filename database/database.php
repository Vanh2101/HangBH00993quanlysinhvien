<?php
// ket noi csdl
// su dung thu vien PDO de lam viec voi database(MySQL)

// ham ket noi toi database
function connectionDb(){
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=student_manager1a;charset=utf8', 'minhhang', '123456789');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh; // tra ve bien ket noi.
    } catch (PDOException $e) {
        // attempt to retry the connection after some timeout for example
        echo "Can not connect to database";
        print_r($e);
        die();
    }
}
// ham ngat ket noi toi database
function disconnectDb($connection){
    $connection = null;
}