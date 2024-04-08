<?php

if(!function_exists('uploadFile')){
    function uploadFile($file, $pathFile, $arrType = ['image/png', 'image/jpg', 'image/jpeg'], $size = 3*1024*1024){
        if(empty($file) || empty($pathFile)){
            return null;
        }
        $nameFile = $file['name'];
        $tmpFile  = $file['tmp_name'];
        $typeFile = $file['type'];
        $sizeFile = $file['size'];
        $errorFile = $file['error'];
        if(in_array($typeFile, $arrType) && $sizeFile <= $size && $errorFile == 0){
            $upload = move_uploaded_file($tmpFile, $pathFile . $nameFile);
            if($upload){
                return $nameFile;
            }
        }
        return null;
    }
}