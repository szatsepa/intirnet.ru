<?php 
// created by arcady.1254@gmail.com

if(!isset($_SESSION)){

    session_start();    
}

if(!isset($attributes) || !is_array($attributes)) {
	$attributes = array();
	$attributes = array_merge($_GET,$_POST); 
}
if(isset($attributes[ch]) && $attributes[ch]){
    // Yстановим куку (неделя) для аутентификации
	 setcookie("di", $_SESSION['id'], time()+(604800));
} 
if(isset($_COOKIE[di]) && $_COOKIE['di'] != 'NULL'){
    $_SESSION['id'] = $_COOKIE['di'];
}

include 'func/cp_to_utf.php';
include 'query/connect.php';   
include 'query/user.php';
include 'action/checkauth.php'; 
//include 'query/check_bases_add_tmp.php';
//include 'action/clear_add_customer.php';
//include 'query/read_customerlist.php'; 
include 'main/header.php';

switch ($attributes['act']){
    
    case 'main':
        include 'action/view_hole.php';
        include 'main/main.php'; 
        include 'main/main_menu.php';
        echo "$dbases<br>";
        $db_arr = json_decode($dbases);
//        var_dump($db_arr);
        print_r($db_arr);
        break;
        
    case 'info':
        phpinfo();
        break;
    
    case 'logout':
        include 'action/logout.php';
        break;
    
    default :
        include 'main/authentication.php'; 
}

//echo "C => ";
//print_r($_COOKIE);
//echo "<br>S => ";
//print_r($_SERVER);
//echo "<br>A => ";
//print_r($attributes);

include 'main/footer.php';

mysql_close(); 
?>