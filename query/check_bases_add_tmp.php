<?php

_clearTMP();

$bases_here = _new_base_here(_base_here());

$how_many_new_db = count($bases_here[added]);

if($how_many_new_db != 0)_action_with_new_base($bases_here[added]);

$have_base_here = $bases_here[all];

$list_of_customers = lookingAll($have_base_here);

_insertToTmp($list_of_customers);


function _action_with_new_base($arr){
//    To Do пожее прописать действия и события при добавлении новой бази в соотв таблицу
    
//    echo "The table adds a new record!";
}

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

    $persons_on_tmp = array();

    // получаем список таблиц в бд если есть таблицы customer or users забиваем в массив

    foreach ($odb_tables as $value) {

        mysql_connect("$value[addr]","$value[login]","$value[password]") or die ("Ошибка 1");

        mysql_select_db($value[db_name]);

        mysql_query ("SET NAMES $value[charset]");
        
//        echo "===================$value[db_name]=======================<br>";
        
        $tmp = array_merge($persons_on_tmp, _personsData('users',$value));
        
        if(mysql_table_seek('customer', $value[db_name])){
            $tmp = array_merge($persons_on_tmp, _personsData('customer',$value));
        }
        
        $persons_on_tmp = $tmp;

        mysql_close();

    }


    include '../query/connect.php';
    
    return $persons_on_tmp;
}

function _personsData($tablename,$array){
    
    unset($array[id]);
    
    $charset = $array[charset];
    
    $array[tablename] = $tablename;
    
    $tmp = array();
    
    $result = mysql_query("SELECT * FROM `$tablename`");
    
    while($var = mysql_fetch_assoc($result)){
        
        unset($var[user_id]);
        
        if($charset == 'cp1251'){
            $var[name] = cp1251_to_utf8($var[name]);
            $var[patronymic] = cp1251_to_utf8($var[patronymic]);
            $var[surname] = cp1251_to_utf8($var[surname]);
        }
        
        $tmp_arr = array_merge(_uniKeyEmail($var), $array);

        $tmp_arr[role] = _getRole($tmp_arr[role]);
        
        if($charset == 'cp1251'){
           $tmp_arr[role] = cp1251_to_utf8($tmp_arr[role]); 
        }
        
        $tmp_arr[charset] = $charset;
//        echo "    $tablename//$tmp_arr[charset] =>> $tmp_arr[name] $tmp_arr[patronymic] $tmp_arr[surname];($tmp_arr[role])<br>";
        array_push($tmp, $tmp_arr);
    }
//    echo "<br>";
//    print_r($tmp_arr);
        
    return $tmp;
}

function mysql_table_seek($tablename, $dbname){
    
    $rslt = mysql_query("SHOW TABLES FROM `{$dbname}` LIKE '" . mysql_real_escape_string(addCslashes($tablename, "\\%_")) . "';");

    return mysql_num_rows($rslt) > 0;
} 

function _uniKeyEmail($arr){
    $tmp = array();
    foreach ($arr as $key => $value) {
        
        if($key != 'e_mail' && $key != 'id'){
           $tmp[$key] = $value; 
        }else if($key == 'e_mail'){
           $tmp[email] = $value; 
        }else if($key == 'id'){
           $tmp[user_id] = $value; 
        }
    }
    return _uniKeyPWD($tmp);
}

function _uniKeyPWD($arr){
    $tmp = array();
    foreach ($arr as $key => $value) {
        
        if($key != 'secret_key' && $key != 'pwd'){
           $tmp[$key] = $value; 
        }else if($key == 'secret_key'){
           $tmp[user_password] = $value; 
        }else if($key == 'pwd'){
            $tmp[user_password] = $value;
        }
    }
    unset($tmp[password]);
    unset($tmp[login]);
    unset($tmp[pwd]);
    
    return $tmp;
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
    
    $message = 1;
    
    sort($arr);
    
    reset($arr);
    
    $query = "INSERT INTO `tmp` (user_id,surname,name,patronymic,email,phone,db_data_id,tablename,role) VALUES ";
    
    foreach ($arr as $value) {
        
        $name = $value[name];
        $patronymic = $value[patronymic];
        $surname = $value[surname];
        $role = $value[role];
        
//        echo "$value[db_id]/$value[tablename]/$value[charset] =>> $surname $name $patronymic: $role;<br>";
        
       $query .= "('$value[user_id]','$surname','$name','$patronymic','$value[email]','$value[phone]',$value[db_id],'$value[tablename]','$role'),";
    
        
        
     }
     
     $query = substr($query,0,(strlen($query)-1));
     
     mysql_query($query) or die($query);
     
     if(count($arr != mysql_insert_id()))$message = NULL;
     
    return $message;
}

function _clearTMP(){
    
    mysql_query("CREATE TABLE IF NOT EXISTS `tmp` (
        `id` int(11) NOT NULL auto_increment,
        `user_id`  int(11) NOT NULL,
        `name` varchar(255) character set utf8 collate utf8_bin NOT NULL,
        `surname` varchar(255) character set utf8 collate utf8_bin NOT NULL,
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
