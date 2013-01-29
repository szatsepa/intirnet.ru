<?php
if(unnecessaryCustomers())clearCustomer();

$have_new_customers = checkNewCustomers($have_base_here);

if(count($have_new_customers)>0){
    
    $real_customers = realytiData($have_new_customers);//выбираем данные из реальных таблиц в базах родителях
    
    $already_added = insertToBases($real_customers);
    
    $list_of_customers = lookingAll($have_base_here);

    _insertToTmp($list_of_customers);
    
    insertToThis(checkNewCustomers($have_base_here));
       
}

function insertToBases($arr){
    //загружаем новых пользователей в иные базы
    $cnt = 0;
    $already_added = array();
    $tmp = array();
    
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
                    
                    if($value[men][role] == 3 OR !$value[men][role])$role = 1;
                    
    //            поочередно подключаемся к базам
                    mysql_close();
                    mysql_connect($var[addr], $var[login], $var[password]);
                    mysql_select_db($var[db_name]);
                    mysql_query ("SET NAMES $var[charset]");
    //                    проверяем есть ли таблица в базе
                    $istable = mysql_table_seek('customer', $var[db_name]);
    //                    по результатам формируем запрос 
                    $str = "INSERT INTO `users` (role,name,patronymic,surname,phone,email,pwd) VALUES (3,'$name','$patronymic','$surname','$phone','$email','$pwd')";
                    $check_pwd = "SELECT COUNT(pwd) FROM `users` WHERE `pwd` = '$pwd'";
                    $result = mysql_query($check_pwd);
                    $row = mysql_fetch_row($result);
    //                    проверяем есть ли чел с таким паролем в бд если нету и роль ЗАКАЗЧИК  тогда добавляем запись в таблицу
                    if($row[0] == 0 && $role == 1){
                        mysql_query($str);
                        if(mysql_insert_id()>0)$cnt++;
                        $tmp = $value[men];
                        $tmp[db_id] = $var[id];
                        $tmp[db_name] = $var[db_name];
                        $tmp[tablename] = "users";
                        array_push($already_added, $tmp);
                    }
                    if($istable == 1){
                        $str = "INSERT INTO `customer` (name,patronymic,surname,phone,e_mail,secret_key) VALUES ('$name','$patronymic','$surname','$phone','$email','$pwd')";
                        $check_pwd = "SELECT COUNT(secret_key) FROM `customer` WHERE `secret_key` = '$pwd'";
                        
                        $result = mysql_query($check_pwd);
                        $row = mysql_fetch_row($result);
                        
                        if($row[0] == 0){
                            mysql_query($str);
                            if(mysql_insert_id()>0)$cnt++;
                            $tmp = $value[men];
                            $tmp[db_id] = $var[id];
                            $tmp[db_name] = $var[db_name];
                            $tmp[tablename] = "customer";
                            array_push($already_added, $tmp);
                        }

                    }
                }
            }
    }
    include '../query/connect.php'; 
    return $already_added;
}

function realytiData($arr){
    //выбираем данные из реальных таблиц в базах родителях
    $tmp = array();
    foreach ($arr as $value) {
        
        $user = _isWhoRealyti($value);
        
        if($user){
            array_push($tmp, $user);
            }
            
    }
    return $tmp;
}

function _isWhoRealyti($men){ 
    
    $tmp = array();
    $result = mysql_query("SELECT * FROM `db_data` WHERE id = $men[db_data_id]");
    $db = mysql_fetch_assoc($result);
    
    $tmp[men] = array();
    
    mysql_close();
    
    mysql_connect($db[addr], $db[login], $db[password]);
    mysql_select_db($db[db_name]);
    mysql_query ("SET NAMES $db[charset]");
    
    $result = mysql_query("SELECT * FROM `$men[tablename]` WHERE id = $men[user_id]");
        
    $tmp[men] = mysql_fetch_assoc($result);
    
    $name = $tmp[men][name];
    $patronymic = $tmp[men][patronymic];
    $surname = $tmp[men][surname];
    
    if($db[charset]=='cp1251'){
        $name = cp1251_to_utf8($name);
        $patronymic = cp1251_to_utf8($patronymic);
        $surname = cp1251_to_utf8($surname); 
    }
    
    $tmp[men][name] = $name;
    
    $tmp[men][patronymic] = $patronymic;
    
    $tmp[men][surname] = $surname;
    
    $tmp[d_base] = $men[db_data];
    
    $tmp[tablename] = $men[tablename];
    
    if($tmp[men][role] != 3 && $men[tablename] == 'users')$tmp = NULL;

    mysql_close();
    
    include '../query/connect.php';
    
    return ($tmp);
}

function insertToThis($arr){
    //    добавим новых пользователей в таблицу оных
 
    if(count($arr)>0){
        
        $str_data = 'INSERT INTO `customer` (user_id,role,surname,name,patronymic,email,phone,tablename,db_data_id) VALUES ';
        
        foreach ($arr as $value) {
            
            $str_data .= "($value[user_id],'$value[role]','$value[surname]','$value[name]','$value[patronymic]','$value[email]','$value[phone]','$value[tablename]',$value[db_data_id]),";
        }

        $str_data = substr($str_data, 0,  (strlen($str_data)-1));
        
        mysql_query($str_data);
    }
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

function checkNewCustomers($db){
    //появились ли в бд новые клиенты
    
    $tmp_array = array();

    $query = "SELECT t.user_id, t.name, t.patronymic, t.surname, t.role, t.email, t.phone, t.tablename, t.db_data_id FROM `tmp` AS t LEFT JOIN `customer` AS c USING(id) WHERE c.id IS NULL";

    $result = mysql_query($query) or die($query." -> ".  mysql_error());

    if($result){
        while($var = mysql_fetch_assoc($result)){
            
            $var['db_data'] = selectBases($var[db_id], $db);//выбираем ресурсы кроме того где уже зареганый

            array_push($tmp_array, $var);
        }
    }

    mysql_free_result($result);
    
    return array_unique($tmp_array);
}

function unnecessaryCustomers(){
    
    $query = "SELECT COUNT(c.id) FROM `customer` AS c LEFT JOIN `tmp` AS t USING(id) WHERE t.id IS NULL";
    
    $result = mysql_query($query);
    
    $row = mysql_fetch_row($result);
    
    return $row[0];
}

function clearCustomer(){
    // как если вдруг в бдонорах окажется пользователей меньше чем базаовой то перезапишем всех вновь
    
    mysql_query("TRUNCATE TABLE `customer`");
    
    $result = mysql_query("SELECT * FROM `tmp`");
    
    $tmp_arr = array();
    
    while ($var = mysql_fetch_assoc($result)){
        array_push($tmp_arr, $var);
    }
    $str_data = 'INSERT INTO `customer` (user_id,role,surname,name,patronymic,email,phone,tablename,db_data_id) VALUES ';
    foreach ($tmp_arr as $value) {
        $str_data .= "($value[user_id],'$value[role]','$value[surname]','$value[name]','$value[patronymic]','$value[email]','$value[phone]','$value[tablename]',$value[db_data_id]),";
    }
    
    $str_data = substr($str_data, 0,  (strlen($str_data)-1));
    
    mysql_query($str_data);
    
    return mysql_insert_id();
}
?>
