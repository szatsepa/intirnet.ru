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
	 setcookie("di", $_SESSION[id], time()+(604800));
} 
if(isset($_COOKIE[di]) && $_COOKIE[di] != 'NULL'){
    $_SESSION[id] = $_COOKIE[di];
}

include '../query/connect.php';   
include ("../query/user.php");
include ("../action/checkauth.php"); 
include '../main/header.php';

switch ($attributes[act]){
    
    case 'main':
        include '../query/db_data.php';
        include '../query/check_customers.php';
        include '../main/main.php';
        include '../main/main_menu.php';
//        include '../main/filter.php';
        include '../main/customers.php';
        break;
    
    case 'srch':
        include '../main/main.php';
        include '../main/main_menu.php';
        include '../main/search.php';
        break;
    
    case 'res':
        include '../query/res_data.php';
        include '../main/main.php';
        include '../main/main_menu.php';
        include '../main/res_data.php';
        break;
    
    case 'adm':
        include '../query/users.php';
        include '../main/main.php';
        include '../main/main_menu.php';
        include '../main/administration.php';
        break;
    
    
    
    case 'logout':
        include '../action/logout.php';
        break;
    
    default :
        include '../main/authentication.php'; 
}

//echo "C => ";
//print_r($_COOKIE);
//echo "<br>S => ";
//print_r($_SESSION);
//echo "<br>A => ";
//print_r($attributes);

include '../main/footer.php';

mysql_close(); 
?>