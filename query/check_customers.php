<?php
$new_customers = checkNewCustomers($odb_tables);

if(count($new_customers)){
//    $GLOBALS['cu'] = count($new_customers);

    $real_customers = realytiData($new_customers);//выбираем данные из реальных таблиц в базах родителях

    $inserted = insertToBases($real_customers);
    
    insertToThis(checkNewCustomers($odb_tables));

}

$customers = _allPersons(NULL);

function insertToThis($arr){
    
    foreach ($arr as $value) {
        $query = "INSERT INTO `customer` (user_id,role,surname,name,patronymic,email,phone,tablename,db_data_id) VALUES ($value[user_id],'$value[role]','$value[surname]','$value[name]','$value[patronymic]','$value[email]','$value[phone]','$value[tablename]',$value[db_data_id])";
        
        mysql_query($query) or die("Помилка ".  mysql_error());
    }
        
}

function insertToBases($arr){
    $cnt = 0;
    
    foreach ($arr as $value) {
            if(count($value[d_base])){
                 foreach ($value[d_base] as $var){
                     
                    $name = $value[men][name];
                    $patronymic = $value[men][patronymic];
                    $surname = $value[men][surname];
                    $phone = $value[men][phone];
                    if($value[men][e_mail]){
                        $email = $value[men][e_mail];
                    }else{
                        $email = $value[men][email];
                    }
                    if($value[men][secret_key]){
                        $pwd = $value[men][secret_key];
                    }else{
                        $pwd = $value[men][pwd];
                    }
                    
                    $role = $value[men][role];
//                    echo "$role;  ";
            
                    mysql_close();
                    mysql_connect($var[addr], $var[login], $var[password]);
                    mysql_select_db($var[db_name]);
                    mysql_query ("SET NAMES $var[charset]");
                    $istable = mysql_table_seek('customer', $var[db_name]);
//                    echo "CU ->>> $istable in ".$var[db_name]."<br>";
                    if($istable == 1){
                        $str = "INSERT INTO `customer` (name,patronymic,surname,phone,e_mail,secret_key) VALUES ('$name','$patronymic','$surname','$phone','$email','$pwd')";
                        $check_pwd = "SELECT COUNT(secret_key) FROM `customer` WHERE `secret_key` = '$pwd'";
                    }else{
                        $str = "INSERT INTO `users` (role,name,patronymic,surname,phone,email,pwd) VALUES (3,'$name','$patronymic','$surname','$phone','$email','$pwd')";
                        $check_pwd = "SELECT COUNT(pwd) FROM `users` WHERE `pwd` = '$pwd'";
                    }
                    $result = mysql_query($check_pwd);
                    $row = mysql_fetch_row($result);
//                    echo $row[0]." => count of password<br>";
                    if($row[0] == 0 && $role == 3){
//                        echo "$str<br>";
                        mysql_query($str);
                        if(mysql_insert_id()>0)$cnt++;
                    }
                }
            }
    }
    include '../query/connect.php'; 
    return '<script type="text/javascript">document.location.href = "index.php?act=main";</script>';
}

function _allPersons($sort){
    
    $customers = array();

    $query = "SELECT * FROM `customer` $sort";

    $result = mysql_query($query) or die($query);

    if(mysql_numrows($result)!=0){
        while ($var = mysql_fetch_assoc($result)){
            array_push($customers, $var);
        }
    }

    mysql_free_result($result);
    
    return $customers;
}

function checkNewCustomers($db){
    //появились ли в бд новые клиенты
    
    $tmp_array = array();

    $query = "SELECT t.user_id, t.name, t.patronymic, t.surname, t.role, t.email, t.phone, t.tablename, t.db_data_id FROM `tmp` AS t LEFT JOIN `customer` AS c USING(id) WHERE c.id IS NULL";

    $result = mysql_query($query) or die($query." -> ".  mysql_error());

    if($result){
        while($var = mysql_fetch_assoc($result)){
            
            $var['db_data'] = selectBases($var[db_data_id], $db);//выбираем ресурсы кроме того где уже зареганый

            array_push($tmp_array, $var);
        }
    }

    mysql_free_result($result);
    
    return array_unique($tmp_array);
}

function selectBases($dbid, $db){
 //выбираем ресурсы кроме того где уже зареганый   
    $tmp = array();
    
    foreach ($db as $value) {
        if($value[db_id] != $dbid){
            array_push($tmp, $value);
        }
    }
    return $tmp; 
}

function realytiData($arr){
    //выбираем данные из реальных таблиц в базах родителях
    $tmp = array();
    foreach ($arr as $value) {
        array_push($tmp, _isWhoRealyti($value));
    }
    return $tmp;
}

function _isWhoRealyti($men){
//    print_r($men);
    $tmp = array();
    $result = mysql_query("SELECT * FROM `db_data` WHERE id = $men[db_data_id]");
    $db = mysql_fetch_assoc($result);
  
    
    mysql_close();
    
    mysql_connect($db[addr], $db[login], $db[password]);
    mysql_select_db($db[db_name]);
    mysql_query ("SET NAMES $db[charset]");
    
    $result = mysql_query("SELECT * FROM `$men[tablename]` WHERE id = $men[user_id]");
    
    mysql_close();
    
    $tmp[men] = mysql_fetch_assoc($result);
    
    $tmp[d_base] = $men[db_data];
    
    if($tmp[men][role] != 3 && $men[tablename] == 'users')unset ($tmp);
    
    include '../query/connect.php';
    
    return ($tmp);
}

function mysql_table_seek($tablename, $dbname)
{
    $rslt = mysql_query("SHOW TABLES FROM `{$dbname}` LIKE '" . mysql_real_escape_string(addCslashes($tablename, "\\%_")) . "';");

    return mysql_num_rows($rslt) > 0;
}
?>
