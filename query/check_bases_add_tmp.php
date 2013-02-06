<?php

_clearTMP();

$bases_here = _new_base_here(_base_here());

if(count($bases_here[added])){
    
    mysql_query("TRUNCATE TABLE `customer`");
    
}

$have_base_here = $bases_here[all];

$list_of_customers = lookingAll($have_base_here);

reset($have_base_here);

_insertToTmp($list_of_customers);

function _base_here(){
    
    $result = mysql_query("SELECT `db_data_id` AS db_id
                             FROM `customer`
                         GROUP BY `db_data_id`");
    
    $tmp = array();
    
    while ($var = mysql_fetch_row($result)){
        array_push($tmp, $var[0]);
    }
    
    return $tmp;
}

function _new_base_here($arr){
    
    $tmp = array();
    
    $tmpb = array();
    
    $result = mysql_query("SELECT  `id` AS db_id, `db_name`, `login`, `password`, `addr`, `charset` 
                             FROM `db_data`");
    
    while ($var = mysql_fetch_assoc($result)){
        array_push($tmp, $var);
    }
    
    foreach ($tmp as $value) {
        $value[flag] = 0;
        foreach ($arr as $var){
            if($value[db_id] == $var[db_id])$value[flag] = 1;
        }
        array_push($tmpb, $value);
    }
    
    foreach ($tmpb as $key => $value) {
        if($value[flag]==1)unset ($tmpb[$key]);
    }
    
    return array('added'=>$tmpb,'all'=>$tmp);
    
}

function lookingAll($odb_tables){
    
    mysql_close();

    $persons = array();

    foreach ($odb_tables as $value) {

        mysql_connect("$value[addr]","$value[login]","$value[password]") or die ("Ошибка 1");

        mysql_select_db($value[db_name]);

        mysql_query ("SET NAMES $value[charset]");
        
        if(mysql_table_seek('customer', $value[db_name])){
            
            $result = mysql_query("SELECT * FROM `customer` WHERE `status` <> 0");
            
            if($result){
                while ($var = mysql_fetch_assoc($result)){
                    $var[tablename] = 'customer';
                    $var[db_id] = $value[db_id];
                    $var[role] = 'Заказчик';
                    $var[database] = $value[db_name];
                    $var[charset] = $value[charset];
                    if($value[charset]=='cp1251'){
                        $var[name] = cp1251_to_utf8($var[name]);
                        $var[surname] = cp1251_to_utf8($var[surname]);
                        $var[patronymic] = cp1251_to_utf8($var[patronymic]);
                    }
                    array_push($persons, $var);
                }
            }
        }
        
        $result = mysql_query("SELECT * FROM `users` WHERE `status` <> 0");
           
        while ($var = mysql_fetch_assoc($result)){
            $var[db_id] = $value[db_id];
            $var[tablename] = 'users';
            $var[role] = _getRole($var[role]);
            $var[database] = $value[db_name];
            $var[charset] = $value[charset];
            if($value[charset]=='cp1251'){
                    $var[name] = iconv('cp1251', 'utf8', $var[name]);
                    $var[surname] = iconv('cp1251', 'utf8', $var[surname]);
                    $var[patronymic] = iconv('cp1251', 'utf8', $var[patronymic]);
                    $var[role] = iconv('cp1251', 'utf8', $var[role]);
                }
            array_push($persons, $var);
        }

        mysql_close();

    }
    
    include '../query/connect.php';
    
    return $persons;
}

function mysql_table_seek($tablename, $dbname){
    
    $rslt = mysql_query("SHOW TABLES FROM `{$dbname}` LIKE '" . mysql_real_escape_string(addCslashes($tablename, "\\%_")) . "';");

    return mysql_num_rows($rslt) > 0;
} 

function _getRole($id_role){
    
    $role = 'Заказчик';
    
    $id = intval($id_role);
    
    if($id){
            $result = mysql_query("SELECT name FROM `roles` WHERE `id` = $id");
            $row = mysql_fetch_row($result);
            $role = $row[0];
     }
    return $role;
}

function _insertToTmp($arr){
    
    mysql_query("TRUNCATE TABLE `tmp`");
    
    $message = 1;
    
//    sort($arr);
    
    reset($arr);
    
    $query = "INSERT INTO `tmp` (user_id,surname,name,patronymic,email,phone,db_data_id,tablename,role) VALUES ";
    
    foreach ($arr as $value) {
        
        $name = $value[name];
        $patronymic = $value[patronymic];
        $surname = $value[surname];
        $role = $value[role];
        $email = $value[email];
        if($value[e_mail])$email = $value[e_mail];
        
        $query .= "('$value[id]','$surname','$name','$patronymic','$email','$value[phone]','$value[db_id]','$value[tablename]','$role'),";
    
     }
     
     $query = substr($query,0,(strlen($query)-1));
     
     mysql_query($query) or die($query);
     
//     echo $query."<br>";
     
     if(count($arr != mysql_insert_id()))$message = NULL;
     
    return $message;
}

function _clearTMP(){
    
    mysql_query("CREATE TABLE IF NOT EXISTS `tmp` (
        `id` int(11) NOT NULL auto_increment,
        `user_id`  int(11) NOT NULL,
        `surname` varchar(255) character set utf8 collate utf8_bin NOT NULL,
        `name` varchar(255) character set utf8 collate utf8_bin NOT NULL,        
        `patronymic` varchar(255) character set utf8 collate utf8_bin NOT NULL,
        `role` varchar(255) character set utf8 collate utf8_bin NOT NULL,
        `phone` varchar(255) character set utf8 collate utf8_bin NOT NULL,
        `email` varchar(255) character set utf8 collate utf8_bin NOT NULL,
        `tablename` varchar(255) character set utf8 collate utf8_bin NOT NULL,
        `db_data_id`  int(11) NOT NULL,
        PRIMARY KEY  (`id`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");


    mysql_query("TRUNCATE TABLE `tmp`");
}
?>
