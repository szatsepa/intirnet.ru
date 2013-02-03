<?php

include '../query/connect.php';

include '../func/cp_to_utf.php';

$uid = intval($_POST[id]);

$result = mysql_query("SELECT * FROM `customer` WHERE `id` = $uid");

$old_customer = mysql_fetch_assoc($result);

$query = "SELECT `id` FROM `customer` WHERE `name`= '$old_customer[name]' AND `patronymic` = '$old_customer[patronymic]' AND `surname` = '$old_customer[surname]' AND `email` = '$old_customer[email]' AND `phone` = '$old_customer[phone]'";

$result = mysql_query($query);

while ($var = mysql_fetch_assoc($result)){
    
    $em_key = 'e_mail';
    
    if($_POST[email])$em_key = 'email';
    
    $query = "UPDATE `customer` SET name = '$_POST[name]', patronymic = '$_POST[patronymic]', surname = '$_POST[surname]', phone = '$_POST[phone]', email = '$_POST[$em_key]' WHERE id = $var[id]";
                
    mysql_query($query);
}

$db_array = array();

$result = mysql_query("SELECT * FROM `db_data`");

while ($var = mysql_fetch_assoc($result)){
    array_push($db_array, $var);
}

mysql_close();

$qry = '';

foreach ($db_array as $var) {
        
        $charset = $var[charset];
            
        mysql_connect($var[addr],$var[login],$var[password]);

        mysql_select_db($var[db_name]);

        mysql_query ("SET NAMES $charset");

        $em_key = 'e_mail';
        if (!mysql_fields_seek('customer', $em_key)){
            $em_key = 'email';
        }

        $email = $_POST[email];
        if($_POST[e_mail])$email = $_POST[e_mail];
        $old_email = $old_customer[email];
        if($old_customer[e_mail])$email = $old_customer[e_mail];
        
            
        if($charset=='cp1251'){
                $_POST[name] = utf8_to_cp1251($_POST[name]);
                $_POST[surname] = utf8_to_cp1251($_POST[surname]);
                $_POST[patronymic] = utf8_to_cp1251($_POST[patronymic]);
                $_POST[role] =  utf8_to_cp1251($_POST[role]);
            }
            

        $qry = "UPDATE `customer` SET name = '$_POST[name]', patronymic = '$_POST[patronymic]', surname = '$_POST[surname]', e_mail = '$email', phone = '$_POST[phone]' WHERE `name`= '$old_customer[name]' AND `patronymic` = '$old_customer[patronymic]' AND `surname` = '$old_customer[surname]' AND `e_mail` = '$old_customer[email]' AND `phone` = '$old_customer[phone]'";

//        mysql_query($qry);
//
//        $qry = "UPDATE `users` SET name = '$_POST[name]', patronymic = '$_POST[patronymic]', surname = '$_POST[surname]', $em_key = '$email', phone = '$_POST[phone]' WHERE `name`= '$old_customer[name]' AND `patronymic` = '$old_customer[patronymic]' AND `surname` = '$old_customer[surname]' AND `email` = '$old_customer[email]' AND `phone` = '$old_customer[phone]'";
//
//        mysql_query($qry);

        mysql_close();
}

$out = array('ok'=>  $db_array, 'query'=>$qry,'act'=>'update','customer'=>$old_customer);
//
//$aff = mysql_affected_rows();
//
//if($aff > 0)$out['ok'] = $aff;

echo json_encode($out);
 


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
?>
