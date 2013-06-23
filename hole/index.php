<?php 
// created by arcady.1254@gmail.com

include 'config.php';

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

$_HOLE = new Hole();

$inserted = $_HOLE->Customers();

////var_dump($_HOLE->donorsData);
//
//$donorslist = new IntirnetDb();

//var_dump($donorslist->db_donors);

//$outputlist = new Prepare();

include 'main/header.php';

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
        
        include 'query/read_customerlist.php';
        include 'main/main.php'; 
        include 'main/main_menu.php';
        include 'main/customerlist.php';        
        break;
    
    case 'check':
        include 'classes/check_resurses.php';
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
//echo "<br>0eee7950a085d46a42e14b1e05513d23<br>";
////print_r($attributes);
//echo md5("pinokio");
//pinokio

include 'main/footer.php';

mysql_close(); 
?>