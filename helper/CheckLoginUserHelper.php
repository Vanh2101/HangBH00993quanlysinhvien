<?php
if (!function_exists('isLoginUser')) {
    function isLoginUser() {
        $idUser = getSessionIdUser();
        $username = getSessionUsername();
        if(empty($idUser) || empty($username)) {
            return false;
        }
        return true;
    }
}