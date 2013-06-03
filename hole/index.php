<?php 
// created by arcady.1254@gmail.com

if(!isset($_SESSION)){

    session_start();    
}

if(!isset($attributes) || !is_array($attributes)) {
	$attributes = array();
	$attributes = array_merge($_GET,$_POST); 
}
if(isset($attributes['ch']) && $attributes['ch']){
    // Yстановим куку (неделя) для аутентификации
	 setcookie("di", $_SESSION['id'], time()+(604800));
} 
if(isset($_COOKIE['di']) && $_COOKIE['di'] != 'NULL'){
    $_SESSION['id'] = $_COOKIE['di'];
}
include 'query/connect.php';
include 'func/cp2utf.php';
include 'classes/hole_input.php';
include 'classes/hole_output.php';
include 'query/user.php';
include 'action/checkauth.php'; 
include 'main/header.php';

$_HOLE = new Hole();

switch ($attributes['act']){
    
    case 'main':
        include 'query/res_data.php';
        include 'main/main.php';       
        include 'main/main_menu.php';         
        include 'main/res_data.php';
        break;
    
    case 'dbinfo':
        include 'query/us_table.php';
        include 'main/main.php'; 
        include 'main/main_menu.php';
        include 'main/tablelist.php';
        break;
    
    case 'table':
        include 'query/us_table.php';
        include 'query/this_fields.php';
        include 'main/main.php'; 
        include 'main/main_menu.php';
        include 'main/fields_list.php';
        break;
    
    case 'customers':
        include 'action/action_hole.php';
        include 'query/read_customerlist.php';
        include 'main/main.php'; 
        include 'main/main_menu.php';
        include 'main/customerlist.php';        
        break;
    
    case 'check':
        include 'action/check_resurses.php';
        include 'main/main.php'; 
        include 'main/main_menu.php';       
        break;
    case 'add':
        include 'action/add_customer.php';
        break;
    
    case 'update':
        include 'action/update_customer.php';
        break;
    
    case 'del':
        include 'action/delete_customer.php';
        break;
    
    case 'adm':
        include 'query/users.php';
        include 'main/main.php';
        include 'main/main_menu.php';
        include 'main/administration.php';
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
////print_r($is_tables);
//echo "<br>A => ";
//print_r($attributes);
//echo md5("admin");->21232f297a57a5a743894a0e4a801fc3 
/*
//19e282746b45066892214118ee66eaf3*/

include 'main/footer.php';

mysql_close(); 
?>