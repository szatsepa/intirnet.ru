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

include 'fn/cp_to_utf.php';
include 'query/connect.php'; 
include ("query/checkauth.php"); 
include 'view/header.php'; 

switch ($attributes[act]){
    
    case 'main':
//        include 'query/check_bases_add_tmp.php';
//        include 'action/clear_add_customer.php';
//        include 'query/read_customerlist.php'; 
        include 'view/main.php'; 
        include 'view/main_menu.php';
//        include 'view/customers.php';
//        include 'query/connect_1.php'; 
//        на время сделаем переадресацию на далее
        header("location:index.php?act=res");
        break;
    
    case 'srch':
        include 'view/main.php';
        include 'view/main_menu.php';
        include 'view/search.php';
        break;
    
    case 'res':
        include 'query/res_data.php'; 
        include 'view/main.php';
        include 'view/main_menu.php';
        include 'view/res_data.php';
        break;
    
    case 'adm':
        include 'query/users.php';
        include 'view/main.php';
        include 'view/main_menu.php';
        include 'view/administration.php';
        break;
    
    case 'update' :
        include 'action/update_customer.php';
        break;
    
    case 'delete':
        include 'action/delete_customer.php';
        break;
    
    case 'add':
        include 'action/add_customer.php';
        break;
    
    case 'dbinfo':
        include 'view/main.php'; 
        include 'view/main_menu.php';
        include 'query/connect_1.php';
        include 'view/tablelist.php';
//        print_r($attributes);
        break;
    
    case 'table':
        include 'view/main.php'; 
        include 'view/main_menu.php';
        include 'query/read_table.php';
        include 'view/view_table.php';
//        print_r($attributes);
        break;
    
    case 'edata':
        include 'query/update_table.php';
        break;
    
    case 'info':
        phpinfo();
        break;
    
    case 'logout':
        include 'action/logout.php';
        break;
    
    default :
        include 'view/authentication.php'; 
}

//echo "C => ";
//print_r($_COOKIE);
//echo "<br>S => ";
//print_r($_SERVER);
//echo "<br>A => ";
//print_r($attributes);

include 'view/footer.php';

mysql_close(); 
?>