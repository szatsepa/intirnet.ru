<?php
include '../query/connect.php';
include '../func/cp_to_utf.php';

mysql_query("TRUNCATE TABLE `sinchro_tmp`");

$bases = getBases();

$get_cu = getCustomers($bases);

$cntrl_cu = insertToSinchro($get_cu);

$difference = _verification($cntrl_cu);

$need_chenges = _selectChanges($difference);

$update_donors = _updateDonors($need_chenges,$bases);

echo json_encode($update_donors); 

//echo "$difference";

function _verification($arr){
    
    $tmp = array();
    
    foreach ($arr as $value) {
        
        $query = "SELECT COUNT(*) FROM `customer` WHERE `name` = '$value[name]' AND `surname` = '$value[surname]' AND `patronymic` = '$value[patronymic]' AND `email` = '$value[email]' AND `phone` = '$value[phone]' AND `role` = '$value[role]'";
        
        $result = mysql_query($query);
        
        $row = mysql_fetch_row($result);
        
        $value[check] = $row[0];
        
        if(!$row[0]){
            array_push($tmp, $value);       
          }
        
    }
//    
    return $tmp;
}

function _selectChanges($arr){
    
    $bmp = array();
    
    foreach ($arr as $value) {
        
        $tmp = array();
        
        
        $new_name = $value[name];
        $new_surname = $value[surname];
        $new_patronymic = $value[patronymic];
        $new_email = $value[email];
        $new_phone = $value[phone];
        $new_role = $value[role];
    
        $query = "SELECT id FROM `sinchro_tmp` WHERE `name` = '$new_name' AND `surname` = '$new_surname' AND `patronymic` = '$new_patronymic' AND `email` = '$new_email' AND `phone` = '$new_phone' AND `role` = '$new_role'";
            
        $result = mysql_query($query);
        
        $row = mysql_fetch_row($result);
        
        $id_query = "SELECT * FROM `customer` WHERE id = $row[0]";
        
        $res = mysql_query($id_query);
        
        $var = mysql_fetch_assoc($res);
        
        $index_query = "SELECT id FROM `customer` WHERE `name` = '$var[name]' AND `surname` = '$var[surname]' AND `patronymic` = '$var[patronymic]' AND `email` = '$var[email]' AND `phone` = '$var[phone]' AND `role` = '$var[role]'";
        
        $persons_list_qry = mysql_query($index_query);
       
        while($customerlist = mysql_fetch_assoc($persons_list_qry)){
            
            $customerlist[name] = $new_name;
            $customerlist[patronymic] = $new_patronymic;
            $customerlist[surname] = $new_surname;
            $customerlist['email'] = $var[email];
            $customerlist[phone] = $new_phone;
            $customerlist[role] = $new_role;
             mysql_query("UPDATE `customer` SET `name` = '$new_name', `surname` = '$new_surname', `patronymic` = '$new_patronymic', `email` = '$customerlist[email]', `phone` = '$new_phone', `role` = '$new_role' WHERE id = $customerlist[id]");
//            $customerlist[query] = $id_query;
            
            $qry_customer = mysql_query("SELECT * FROM `customer` WHERE `id` = $customerlist[id]");
        
            array_push($bmp, mysql_fetch_assoc($qry_customer));                      
        }
   
    }
   
    return $bmp;
}

function _updateDonors($arr, $bases){
    
    $tmp = array();
    
    mysql_close();
    
    foreach ($arr as $var) {
        
        $charset = $bases[$var[db_data_id]][charset];
            
            mysql_connect($bases[$var[db_data_id]][addr],$bases[$var[db_data_id]][login],$bases[$var[db_data_id]][password]);
    
            mysql_select_db($bases[$var[db_data_id]][db_name]);

            mysql_query ("SET NAMES $charset");

//                $var[role] = $row[0];
//                $var[database] = $value[db_name];
                $var[db_data_id] = $bases[$var[db_data_id]][db_name];
                $em_key = 'e_mail';
                if (!mysql_fields_seek($var[tablename], $em_key)){
                    $em_key = 'email';
                }
                if($charset=='cp1251'){
                        $var[name] = utf8_to_cp1251($var[name]);
                        $var[surname] = utf8_to_cp1251($var[surname]);
                        $var[patronymic] = utf8_to_cp1251($var[patronymic]);
                        $var[role] =  utf8_to_cp1251($var[role]);
                    }
                    
                     $query = "UPDATE `$var[tablename]` SET name = '$var[name]', patronymic = '$var[patronymic]', surname = '$var[surname]', $em_key = '$var[email]', phone = '$var[phone]' WHERE id = $var[user_id]";
                     
                     mysql_query($query);
                     
                     $var[query] = $query;
                     
                array_push($tmp, $var);
//            }

            mysql_close();
            
        
    }
    
    include '../query/connect.php';
    
    return $tmp;
}

function insertToSinchro($arr){
    
//    array_reverse($arr);
    
    $query = "INSERT INTO `sinchro_tmp` (`user_id`,`role`,`surname`,`name`,`patronymic`,`email`,`phone`,`tablename`,`db_data_id`) VALUES ";
    
    $out_arr = array();
        
    foreach ($arr as $value) {
        
        ksort($value);
        
        unset($value[password]);
        
        array_push($out_arr, $value);
        
        $query .= "($value[user_id],'$value[role]','$value[surname]','$value[name]','$value[patronymic]','$value[email]','$value[phone]','$value[tablename]','$value[db_id]'),";
    }
    
    $query = substr($query, 0,  strlen($query)-1);
    
    mysql_query($query);
    

        
   return $out_arr;  
}

function getBases(){
    
    $dbase = array();

    $result = mysql_query("SELECT * FROM db_data ORDER BY id");

    while ($var = mysql_fetch_assoc($result)){
        
        $dbase[$var[id]] = $var;
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
        
        if(mysql_table_seek('customer', $value[db_name])){
            
            $result = mysql_query("SELECT * FROM `customer`");
            
            while ($var = mysql_fetch_assoc($result)){
                $var[tablename] = 'customer';
                $var[db_id] = $value[id];
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
        
        $result = mysql_query("SELECT * FROM `users`");
           
        while ($var = mysql_fetch_assoc($result)){
            $var[db_id] = $value[id];
            $var[tablename] = 'users';
            $res = mysql_query("SELECT `name` FROM `roles` WHERE `id` = $var[role]");
            $row = mysql_fetch_row($res);
            $var[role] = $row[0];
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
    
    $all = array();
    
    foreach ($persons as $value) {
        $email = $value[email];
        if($value[e_mail])$email = $value[e_mail];
        $password = $value[pwd];
        if($value[secret_key])$password = $value[secret_key];
        $tmp = array('database'=>$value[database],'charset'=> $value[charset],'role'=>$value[role],'tablename'=>$value[tablename],'db_id'=>$value[db_id],'user_id'=>$value[id],'surname'=>$value[surname],'name'=>$value[name],'patronymic'=>$value[patronymic],'phone'=>$value[phone],'email'=>$email,'password'=>$password);
        array_push($all, $tmp);
    }
    
    include '../query/connect.php';
    
    array_reverse($all);
    
    return $all; 
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
