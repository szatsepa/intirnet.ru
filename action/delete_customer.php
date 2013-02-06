<?php
$server_query = $_POST[addr];

$uid = intval($_POST[uid]);

$query = "SELECT * FROM `customer` WHERE `id` = $uid";

$result = mysql_query($query);

$old_customer = mysql_fetch_assoc($result);

$query = "SELECT `id` FROM `customer` WHERE `name`= '$old_customer[name]' AND `patronymic` = '$old_customer[patronymic]' AND `surname` = '$old_customer[surname]' AND `email` = '$old_customer[email]' AND `phone` = '$old_customer[phone]'";

$result = mysql_query($query);

$need_ch_array = array();

while ($var = mysql_fetch_assoc($result)){
    
    $chng_cu = deleteLocal($var[id]);

    $chng_cu[db] = getDB($chng_cu[db_data_id],$chng_cu[tablename]);
    
    array_push($need_ch_array, $chng_cu);
}

 mysql_close();
 
 $mm = 1;
 
foreach ($need_ch_array as $value) {
    
    $mm = $mm*(_deleteInDB($value));
}

if($mm){
    
    header("location:index.php?$server_query");
}

function _deleteInDB($customer){
    
        $base = $customer[db];
        
        $uid = $customer[user_id];
    
        $charset = $base[charset];
            
        $link = mysql_connect("$base[addr]","$base[login]","$base[password]")  or die("Could not connect: " . mysql_error());

        mysql_select_db($base[db_name])  or die("Could not select db: " . mysql_error());

        mysql_query ("SET NAMES $charset");
        
            
        if($charset=='cp1251'){
                $new[name] = utf8_to_cp1251($new[name]);
                $new[surname] = utf8_to_cp1251($new[surname]);
                $new[patronymic] = utf8_to_cp1251($new[patronymic]);
                $new[role] =  utf8_to_cp1251($new[role]);
            }
            
        $qry = "UPDATE `$base[tablename]` SET `status` = 0 WHERE `id` = $uid";

        $res = mysql_query($qry)  or die("Could not query: " . mysql_error()); 
        
//        echo "$qry<br> => AFFECTED ".mysql_affected_rows()."<br>";
//    
    return mysql_affected_rows();
}

function deleteLocal($arg){
    
    $res = mysql_query("SELECT * FROM `customer` WHERE `id` = $arg");
    
    $change_customer = mysql_fetch_assoc($res);
    
    $query = "DELETE FROM `customer` WHERE id = $change_customer[id]";

    mysql_query($query);
    
    return $change_customer;
}


function getDB($arg, $tablename){
    
    $result = mysql_query("SELECT * FROM `db_data` WHERE id = $arg");

    $var = mysql_fetch_assoc($result);
    
    $var[tablename]=$tablename;
    
    return $var;
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
?>
