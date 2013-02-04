<?php

include '../query/connect.php';

include '../func/cp_to_utf.php';

$uid = intval($_POST[id]);

$new_customer = $_POST;

$result = mysql_query("SELECT * FROM `customer` WHERE `id` = $uid");

$old_customer = mysql_fetch_assoc($result);

$query = "SELECT `id` FROM `customer` WHERE `name`= '$old_customer[name]' AND `patronymic` = '$old_customer[patronymic]' AND `surname` = '$old_customer[surname]' AND `email` = '$old_customer[email]' AND `phone` = '$old_customer[phone]'";

$result = mysql_query($query);

while ($var = mysql_fetch_assoc($result)){
    
    $em_key = 'e_mail';
    
    if($new_customer[email])$em_key = 'email';
    
    $query = "UPDATE `customer` SET name = '$new_customer[name]', patronymic = '$new_customer[patronymic]', surname = '$new_customer[surname]', phone = '$new_customer[phone]', email = '$new_customer[$em_key]' WHERE id = $var[id]";
                
    mysql_query($query);
}

//$qry = _updateDonors($old_customer,$new_customer, getDB());


$out = array('ok'=>  0, 'query'=>$qry,'act'=>'update','customer'=>$old_customer);
//
//$aff = mysql_affected_rows();
//
//if($aff > 0)$out['ok'] = $aff;

echo json_encode($out);

function getDB(){
    $db_array = array();

    $result = mysql_query("SELECT * FROM `db_data`");

    while ($var = mysql_fetch_assoc($result)){
        array_push($db_array, $var);
    }
    
    return $db_array;
}


function mysql_table_seek($tablename, $dbname){
    
    $rslt = mysql_query("SHOW TABLES FROM `{$dbname}` LIKE '" . mysql_real_escape_string(addCslashes($tablename, "\\%_")) . "';");

    return mysql_num_rows($rslt) > 0;
}

function mysql_fields_seek($tablename, $field){
    
    $out = NULL;

    $rslt = mysql_query("SELECT COUNT(`$field`) FROM `$tablename`");
    
    if($rslt)$out = mysql_num_rows($rslt);

    return  $out;
}
function _updateDonors($old, $new, $bases){
    
   mysql_close();   
    
    foreach ($bases as $var) {
        
          

        $em_key = 'e_mail';
        if (!mysql_fields_seek('customer', $em_key)){
            $em_key = 'email';
        }

        $email = $new[email];
        if($new[e_mail])$email = $new[e_mail];
        $old_email = $old[email];
        if($old[e_mail])$email = $old[e_mail];
        
            
        if($charset=='cp1251'){
                $new[name] = utf8_to_cp1251($new[name]);
                $new[surname] = utf8_to_cp1251($new[surname]);
                $new[patronymic] = utf8_to_cp1251($new[patronymic]);
                $new[role] =  utf8_to_cp1251($new[role]);
            }

        $qry = "UPDATE `customer` SET name = '$new[name]', patronymic = '$new[patronymic]', surname = '$new[surname]', e_mail = '$email', phone = '$new[phone]' WHERE `name`= '$old[name]' AND `patronymic` = '$old[patronymic]' AND `surname` = '$old[surname]' AND `e_mail` = '$old[email]' AND `phone` = '$old[phone]'";
        
        $qry_u = "UPDATE `users` SET name = '$new[name]', patronymic = '$new[patronymic]', surname = '$new[surname]', $em_key = '$email', phone = '$new[phone]' WHERE `name`= '$old[name]' AND `patronymic` = '$old[patronymic]' AND `surname` = '$old[surname]' AND `email` = '$old[email]' AND `phone` = '$old[phone]'";

        $charset = $var[charset]; 
            
        $link = mysql_connect('193.124.133.29:3306/tmp/mysqld.sock',$var[login],$var[password]);

        mysql_select_db($var[db_name],$link);

        mysql_query ("SET NAMES $charset");
        
//        mysql_query($qry);
////
////        
////
////        mysql_query($qry);
        
        mysql_close();

    }
            
   
    
    return $qry_u;
}

?>
