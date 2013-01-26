<?php
//header('Content-Type: text/html; charset=utf-8'); 

include '../query/connect.php';



$cntrl_cu = insertToSinchro(getCustomers(getBases()));

echo json_encode($cntrl_cu);

function insertToSinchro($arr){
    
    mysql_query("TRUNCATE TABLE `sinchro_tmp`");
    
    $query = "INSERT INTO `sinchro_tmp` (`user_id`,`role`,`surname`,`name`,`patronymic`,`email`,`phone`,`tablename`,`db_data_id`) VALUES ";
    foreach ($arr as $value) {
        
        $query .= "($value[user_id],'$value[role]','$value[surname]','$value[name]','$value[patronymic]','$value[email]','$value[phone]','$value[tablename]','$value[db_id]'),";
    }
    
    $query = substr($query, 0,  strlen($query)-1);
    
    mysql_query($query);
        
   return $arr;  
}

function getBases(){
    
    $dbase = array();

    $result = mysql_query("SELECT * FROM db_data");

    while ($var = mysql_fetch_assoc($result)){
        array_push($dbase, $var);
    }
    
    return $dbase;
}

function getCustomers($array){
    
    mysql_close();
    
    $persons = array();
    
    foreach ($array as $value) {
        mysql_connect("$value[addr]","$value[login]","$value[password]");
    
        mysql_select_db($value[db_name]);

        mysql_query ("SET NAMES $value[charset]");
        
        $result = mysql_query("SELECT * FROM `users`");
            
        while ($var = mysql_fetch_assoc($result)){
            $var[db_id] = $value[id];
            $var[tablename] = 'users';
            $result = mysql_query("SELECT `name` FROM `roles` WHERE `id` = $var[role]");
            $row = mysql_fetch_row($result);
            $var[role] = $row[0];
            array_push($persons, $var);
        }
        
        if(mysql_table_seek('customer', $value[db_name])){
            
            $result = mysql_query("SELECT * FROM `customer`");
            
            while ($var = mysql_fetch_assoc($result)){
                $var[tablename] = 'customer';
                $var[db_id] = $value[id];
                $var[role] = 'Заказчик';
                array_push($persons, $var);
            }
        }
        
        mysql_close();
    }
    
    $all = array();
    
    foreach ($persons as $key => $value) {
        $email = $value[email];
        if($value[e_mail])$email = $value[e_mail];
        $password = $value[pwd];
        if($value[secret_key])$password = $value[secret_key];
        $tmp = array('role'=>$value[role],'tablename'=>$value[tablename],'db_id'=>$value[db_id],'user_id'=>$value[id],'surname'=>$value[surname],'name'=>$value[name],'patronymic'=>$value[patronymic],'phone'=>$value[phone],'email'=>$email,'password'=>$password);
        array_push($all, $tmp);
    }
    
    include '../query/connect.php';
    
    return $all;
 
}
function mysql_table_seek($tablename, $dbname)
{
    $rslt = mysql_query("SHOW TABLES FROM `{$dbname}` LIKE '" . mysql_real_escape_string(addCslashes($tablename, "\\%_")) . "';");

    return mysql_num_rows($rslt) > 0;
} 
?>
