<?php
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8";

$attributes = $_POST;

//SELECT `db_name`, `login`, `password`, `addr`, `charset`, `inet_name`, `inet_address` FROM `db_data` WHERE 1

mysql_connect($attributes['addr'],$attributes['login'],$attributes['password']);

mysql_select_db($attributes['db_name']);

mysql_query ("SET NAMES {$attributes['charset']}");

$out = mysql_errno();

if (mysql_errno() <> 0) exit("ERROR ".$out);

$response = NULL;

if($attributes['users']){
    
    $response = _getUsers();
}

echo $response;

function _getUsers(){
    
    $tmp = array();
    
    $query = "SELECT `login`, `password`, `email`  FROM `cms_users` WHERE `group_id`=1";
    
    $result = mysql_query($query);
    
    if(!$result){
        $tmp[0] = "NO DATA";
    }else{
        while ($row = mysql_fetch_assoc($result)){
            array_push($tmp, $row);
        }
    }
    
    return json_encode($tmp);
}
?>
