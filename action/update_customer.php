<?php
$server_query = $_POST[addr];

$uid = intval($_POST[uid]);

$new_customer = $_POST;

$query = "SELECT * FROM `customer` WHERE `id` = $uid";

$result = mysql_query($query);

$old_customer = mysql_fetch_assoc($result);

$query = "SELECT `id` FROM `customer` WHERE `name`= '$old_customer[name]' AND `patronymic` = '$old_customer[patronymic]' AND `surname` = '$old_customer[surname]' AND `email` = '$old_customer[email]' AND `phone` = '$old_customer[phone]'";

$result = mysql_query($query);

$need_ch_array = array();

while ($var = mysql_fetch_assoc($result)){
    
    $chng_cu = changeLocal($var,$new_customer);

    $chng_cu[db] = getDB($chng_cu[db_data_id],$chng_cu[tablename]);
    
    array_push($need_ch_array, $chng_cu);
}

 mysql_close(); 

foreach ($need_ch_array as $value) {
    _updateDDB($chng_cu[id],$new_customer,$value[db]);
}

if(!mysql_fetch_assoc($result)){
    
    header("location:index.php?$server_query");
}

function changeLocal($arg, $new){
    
    $res = mysql_query("SELECT * FROM `customer` WHERE `id` = $arg[id]");
    
    $change_customer = mysql_fetch_assoc($res);
    
    $em_key = 'e_mail';
    
    if($new_customer[email])$em_key = 'email';
    
    $query = "UPDATE `customer` SET name = '$new[name]', patronymic = '$new[patronymic]', surname = '$new[surname]' WHERE id = $change_customer[id]";
    
//    echo $query.'<br>';
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
function _updateDDB($uid, $new, $base){
    
       $charset = $base[charset];
//            
        $link = mysql_connect("$base[addr]","$base[login]","$base[password]")  or die("Could not connect: " . mysql_error());
        
        echo "$base[addr],$base[login],$base[password]<br>";

        mysql_select_db($base[db_name])  or die("Could not select db: " . mysql_error());

        mysql_query ("SET NAMES $charset");
        
            
        if($charset=='cp1251'){
                $new[name] = utf8_to_cp1251($new[name]);
                $new[surname] = utf8_to_cp1251($new[surname]);
                $new[patronymic] = utf8_to_cp1251($new[patronymic]);
                $new[role] =  utf8_to_cp1251($new[role]);
            }

        $qry = "UPDATE `$base[tablename]` SET `name` = '$new[name]', `patronymic` = '$new[patronymic]', `surname` = '$new[surname]' WHERE `id` = $uid";
       
        echo "$base[db_name]<br>$qry<br>";
        $res = mysql_query($qry)  or die("Could not query: " . mysql_error()); 
        
        if($res)echo mysql_affected_rows()."<br>";
    
    return 1;
}

?>
