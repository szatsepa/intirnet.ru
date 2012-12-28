<?php 
// created by arcady.1254@gmail.com

if(!isset($_SESSION)){

    session_start();    
}

if(!isset($attributes) || !is_array($attributes)) {
	$attributes = array();
	$attributes = array_merge($_GET,$_POST,$_COOKIE); 
}

print_r($_SESSION);

include 'query/connect.php';   
include ("query/user.php");
include ("action/checkauth.php"); 
include 'main/header.php';

switch ($attributes[act]){
    
    case 'main':
        include 'main/main.php';
        break;
    
    case 'logout':
        include 'action/logout.php';
        break;
    
    default :
        include 'main/authentication.php'; 
}

include 'main/footer.php';

mysql_close();
?>