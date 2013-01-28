<?php
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


$odb_tables = get_Base();

$persons_on_tmp = personsForTMP($odb_tables);

_insertToTmp($persons_on_tmp);

function personsForTMP($odb_tables){
    mysql_close();

    $persons_on_tmp = array();

    // получаем список таблиц в бд если есть таблицы customer or users забиваем в массив

    foreach ($odb_tables as $value) {

        mysql_connect("$value[addr]","$value[login]","$value[password]") or die ("Ошибка 1");

        mysql_select_db($value[db_name]);

        mysql_query ("SET NAMES $value[charset]");

        $table_list = mysql_query("SHOW TABLES");

        while($var = mysql_fetch_assoc($table_list)){
            if(($var['Tables_in_'.$value[db_name]]) === 'customer' OR ($var['Tables_in_'.$value[db_name]]) === 'users'){

                $tablename =   $var['Tables_in_'.$value[db_name]];

                $tmp = array_merge($persons_on_tmp, _personsData($tablename,$value,$value[charset]));

                $persons_on_tmp = $tmp;

            }
        }

    mysql_close();

    }


    include '../query/connect.php';
    
    return $persons_on_tmp;
}

function get_Base(){
    
    $query = "SELECT `id` AS db_id, `db_name`, `login`, `password`, `addr`, `charset` FROM `db_data`";

    $result = mysql_query($query) or die($query);

    $odb_tables = array();

    while($var = mysql_fetch_assoc($result)){
        array_push($odb_tables, $var);
    }

    mysql_free_result($result);
    
    return $odb_tables;
}

function _personsData($tablename,$array,$charset){
    
    unset($array[id]);
    
    $array[tablename] = $tablename;
    
    $tmp = array();
    
    $result = mysql_query("SELECT * FROM `$tablename`");
    
    while($var = mysql_fetch_assoc($result)){
        
        unset($var[user_id]);
        
        $tmp_arr = array_merge(_uniKeyEmail($var), $array);

        $tmp_arr[role] = _getRole($tmp_arr[role]);
        
        $tmp_arr[charset] = $charset;
        
        array_push($tmp, $tmp_arr);
    }
    return $tmp;
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
        if($value[charset] == 'cp1251'){
            $name = cp1251_to_utf8($name);
            $patronymic = cp1251_to_utf8($patronymic);
            $surname = cp1251_to_utf8($surname);
            $role = cp1251_to_utf8($role);
        }
        
        echo "$value[db_id]/$value[tablename]/$value[charset] =>> $surname $name $patronymic: $role;<br>";
        
       $query .= "('$value[user_id]','$surname','$name','$patronymic','$value[email]','$value[phone]',$value[db_id],'$value[tablename]','$role'),";
    
        
        
     }
     
     $query = substr($query,0,(strlen($query)-1));
     
     mysql_query($query) or die($query);
     
     if(count($arr != mysql_insert_id()))$message = NULL;
     
    return $message;
}

?>
