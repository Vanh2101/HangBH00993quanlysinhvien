<?php 

if(!function_exists('slug_string')){
    function slug_string($title){
        $replacement = '-';
        $map = array();
        $quotedReplacement = preg_quote($replacement, '/');
        $default = array(
            '/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|å/' => 'a',
            '/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|ë/' => 'e',
            '/ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ|î/' => 'i',
            '/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|ø/' => 'o',
            '/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|ů|û/' => 'u',
            '/ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ/' => 'y',
            '/đ|Đ/' => 'd',
            '/ç/' => 'c',
            '/ñ/' => 'n',
            '/ä|æ/' => 'ae',
            '/ö/' => 'oe',
            '/ü/' => 'ue',
            '/Ä/' => 'Ae',
            '/Ü/' => 'Ue',
            '/Ö/' => 'Oe',
            '/ß/' => 'ss',
            '/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
            '/\\s+/' => $replacement,
            sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
        );
        //Some URL was encode, decode first
        $title = urldecode($title);
        $map = array_merge($map, $default);
        return strtolower(preg_replace(array_keys($map), array_values($map), $title));
    }
}

function getSessionUsername(){
    $username = $_SESSION['username'] ?? null;
    return $username;
}
function getSessionEmail(){
    $email = $_SESSION['email'] ?? null;
    return $email;
}
function getSessionIdUser(){
    $id = $_SESSION['idUser'] ?? null;
    return $id;
}
function getSessionRoleIdUser(){
    $roleId = $_SESSION['roleId'] ?? null;
    return $roleId;
}
function getSessionIdAccount(){
    $accountId = $_SESSION['idAccount'] ?? null;
    return $accountId;
}

if(!function_exists('createLink')){
    function createLink($data = []){

        $strLinkPage = '';
        foreach($data as $key => $value){
            $strLinkPage .= empty($strLinkPage) ? "?{$key}={$value}":
            "&{$key}={$value}";
        }
        return ROOT_PATH . $strLinkPage;
        //index.php?c=department&m=index&page=1&search=
        //index.php?c=courses&m=index&page=1&search=
    }
}

// ham phan trang trong du lieu
if(!function_exists('pagigate')){
    function pagigate($link, $totalItem, $page = 1, $keyword = '', $limit = 2){
        //$link : linh phan trang o ben tren ham createLink ho tro 
        // $totalItem : tong so du lieu trong database
        // $page : so trang
        // $keyword : tu khoa tim kiem
        // $limit : gioi han bao nhieu du lieu tren 1 trang
        // can tinh tong so trang 
        $totalPage = ceil($totalItem/$limit); 
        // ceil : lam trong so len 
        // kiem tra lai tham so $page
        if($page < 1 || $totalPage == 0 ){
            $page = 1;
        } elseif($page > $totalPage){
            $page = $totalPage;
        }
        $start = ($totalPage == 0) ? 0 : (($page -1) * $limit);
        // trong mysql co tu khoa LIMIT start, rows
        // start : bat dua lay du lieu tu dong so bao nhieu (luon luon dong dau tien bat dau tu so 0)
        // rows : muon lay ra bao nhieu du lieu
        // LIMIT 3, 10
        $start = ($page - 1) * $limit; //$limit = rows : tong so du lieu co trong trang
        // xay dung template HTML phan trang bang bootstrap
        $htmlPage = '';
        $htmlPage .= '<nav>';
        $htmlPage .= '<ul class="pagination">';
        // xu li hien thi nut pervious : quay ve trang truoc do 
        if($page > 1){
            $htmlPage .= '<li class="page-item">';
            $htmlPage .= '<a href="'.str_replace('{page}', $page-1, $link).'" class="page-link">Previous</a>';
            $htmlPage .= '</li>';
        }
        // xu ly cac trang o giua 
        for($i = 1; $i <= $totalPage; $i++){
            if($i == $page){
                // bao hieu cho nguoi dung biet ho dang o trang nao 
                $htmlPage .= '<li class="page-item active" aria-current="page">';
                $htmlPage .= '<a class="page-link">'.$page.'</a>';
                $htmlPage .= '</li>';
            }else{
                // nhung trang khac
                $htmlPage .= '<li class="page-item">';
                $htmlPage .= '<a class="page-link" href="'.str_replace('{page}', $i, $link).'">'.$i.'</a>';
                $htmlPage .= '</li>';
            }
        }
        // xu li cho button next : bam sang trang tiep theo 
        if($page < $totalPage){
            $htmlPage .= '<li class="page-item">';
            $htmlPage .= '<a href="'.str_replace('{page}', $page+1, $link).'" class="page-link">Next</a>';
            $htmlPage .= '</li>';
        }
        $htmlPage .= '</ul>';
        $htmlPage .= '</nav>';

        return [
            'start' => $start,
            'pagination' => $htmlPage
        ];
    }
}