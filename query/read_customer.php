<?php
include '../query/connect.php';

$query = "SELECT c.user_id, c.tablename,db.db_name, db.login, db.password, db.addr AS path, db.charset  FROM customer AS c, db_data AS db WHERE c.id = '$_POST[uid]' AND c.db_data_id = db.id";

$result = mysql_query($query);

$data_link = mysql_fetch_assoc($result);

mysql_close();

mysql_connect("$data_link[path]","$data_link[login]","$data_link[password]") or die ("Ошибка 1");
    
mysql_select_db($data_link[db_name]);

mysql_query ("SET NAMES $data_link[charset]");

$result = mysql_query("SELECT * FROM $data_link[tablename] WHERE id = $data_link[user_id]");

$out = mysql_fetch_assoc($result);

if(isset($out[role])){
    
    $role = mysql_query("SELECT name FROM roles WHERE id = $out[role]");
    
    $row = mysql_fetch_row($role);
    
    $role_name = $row[0];
    
    $out[role] = $role_name;
}else{
    $out[role] = "Заказчик";
}

mysql_free_result($result);

mysql_close();

echo json_encode(_uniKeyEmail($out));

function _uniKeyEmail($arr){
    $tmp = array();
    foreach ($arr as $key => $value) {
        
        if($key != 'e_mail'){
           $tmp[$key] = $value; 
        }else if($key == 'e_mail'){
           $tmp[email] = $value; 
        }
    }
    unset($tmp[creation]);
    return $tmp;
}

function _uniKeyPWD($arr){
    $tmp = array();
    foreach ($arr as $key => $value) {
        
        if($key != 'secret_key' && $key != 'pwd'){
           $tmp[$key] = $value; 
        }else if($key == 'secret_key'){
           $tmp[password] = $value; 
        }else if($key == 'pwd'){
            $tmp[password] = $value;
        }
    }
    unset($tmp[secret_key]);
    unset($arr[login]);
    unset($arr[pwd]);
    unset($arr[cod]);
    unset($arr[pin]);
    unset($arr[creation]);
    unset($arr[expiration]);
    
    return $arr;
}

?>