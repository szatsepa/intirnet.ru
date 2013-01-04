<?php 
// created by arcady.1254@gmail.com

if(!isset($_SESSION)){

    session_start();    
}

if(!isset($attributes) || !is_array($attributes)) {
	$attributes = array();
	$attributes = array_merge($_GET,$_POST,$_COOKIE); 
}
if(isset($attributes[ch]) && $attributes[ch]){
    // Yстановим куку (неделя) для аутентификации
	 setcookie("di", $_SESSION[id], time()+(680400*2));
} 
if(isset($attributes[di])){
    $_SESSION[id] = $attributes[di];
}

include 'query/connect.php';   
include ("query/user.php");
include ("action/checkauth.php"); 
include 'main/header.php';

switch ($attributes[act]){
    
    case 'main':
        include 'query/db_data.php';
        include 'query/check_customers.php';
        include 'main/main.php';
        include 'main/customers.php';
        break;
    
    case 'logout':
        include 'action/logout.php';
        break;
    
    default :
        include 'main/authentication.php'; 
}
//print_r($_SESSION);
include 'main/footer.php';

mysql_close();
?>