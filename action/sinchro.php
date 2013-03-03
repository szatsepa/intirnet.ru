<?php
include '../query/connect.php';

include '../func/cp_to_utf.php';

//извлекаем данние о подключении к базам донорам

$query = "SELECT d.`id`, d.`db_name`, d.`login`,d.`password`,d.`addr` AS server, d.`charset`, d.`inet_name` AS `name`, d.`inet_address` AS `url` FROM `db_data` AS d";

$result = mysql_query($query);

$db = array();

while($row = mysql_fetch_assoc($result)){
    array_push($db, $row);
}

$tmpdb = array();

//выбираем таблицы данными которых будем оперировать

foreach ($db as $value) {
    
//    $tmp = array();
    
    $tmpv = $value;
    
    $tmpv['tables'] = array();
    
    $query = "SELECT t.`db_table` AS `table` FROM `db_tables` AS t WHERE t.`db_id` = ".$value['id'];
    
    $result = mysql_query($query);
    
    while ($row = mysql_fetch_assoc($result)){
        $tmpv['tables'][$row['table']] = array();
    }
    
    array_push($tmpdb, $tmpv);
}

 $tmp=array();
 
// присоединим к именам таблиц, имена полей и их синонимы (в главной базе)
 
for($i=0;$i<count($db);$i++){
    
    foreach ($tmpdb[$i]['tables'] as $key => $value) {
        
        $tmp = array();
        
        
        $query = "SELECT f.`field_name` AS `field`, f.`this_name` AS `sinonim` FROM `table_fields` AS f WHERE f.`tablename` = '{$key}' AND f.`db_id` = '{$db[$i]['id']}'";

        
        $result = mysql_query($query);
        
        while ($row = mysql_fetch_assoc($result)){
            
            array_push($tmpdb[$i]['tables'][$key],array($row['field'] => $row['sinonim']));
            
        }
        
    }
    
    
}

//соберем зарегистрированих пользователей в главной базе таблица `customer`

$customers = array();

$query = "SELECT `name`, `surname`, `patronymic`, `phone`, `email` FROM `customer` WHERE `role` = 3";

$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)){
    array_push($customers, $row);
}

mysql_free_result($result);

//закрываем подключение к главной базе и перебираем все базы доноры 

$tmpq = array();

$check_customer = "";

foreach ($tmpdb as $value) {
    
    mysql_close();
    
//    создаем подключение к базе донору
                    
    mysql_connect($value['server'], $value['login'], $value['password']);
    mysql_select_db($value['db_name']);
    mysql_query ("SET NAMES {$value['charset']}");
    
//    создаем инсерт запрос
    
    
    foreach ($value['tables'] as $key => $tables) {
        
        $check_query = array();
        
        $tablename = $key;
        
        $insert_query = "INSERT INTO `$tablename` ("; 
        
        foreach ($tables as $fields) {
            
            foreach ($fields as $field => $sinonim) {
                
                if($field == 'id' || $field == 'role')                    continue;
                    
                    $check_query[$sinonim] = $field;
                    
                    $insert_query .= "`$field`,";                   

                
                
            } 
            
        }
        
        $insert_query = substr($insert_query, 0, strlen($insert_query)-1).") VALUES ";
        
  //    перебираем всех клиентов базы и проверяем их наличие в базе доноре    
        
        foreach ($customers as $znachenie) {
            
            $C_query = "SELECT Count(*) FROM `$tablename` WHERE ";
            
            foreach ($check_query as $sinonim => $field) {
                if($sinonim == 'role' || $sinonim == 'phone') continue;
                $data = $znachenie[$field];
                if($value['charset']!='utf8'){
                    $data = utf8_to_cp1251($data);
                }
                    $C_query .= " `$field` = '$data' AND";
            }
            
            $C_query = substr($C_query, 0, strlen($C_query)-3);
            
//            array_push($tmpq, array('db'=>$value['db_name'],'query'=>$C_query));
            
            if(checkCustomer($C_query)>0)                continue;
            
            $insert_query .= "(";
            
            foreach ($check_query as $sinonim => $field) {
                $insert_query .= "'{$znachenie[$field]}',";
            }
            
            
            $insert_query = substr($insert_query, 0, strlen($insert_query)-1)."),";
            
            
        }
        
        
        $insert_query = substr($insert_query, 0, strlen($insert_query)-1);
        
        mysql_query($insert_query);
    
        $check_customer .= mysql_insert_id().";";
 
    }
    
}

include '../query/connect.php';

echo json_encode(array('ok'=>1));

mysql_close();

function checkCustomer($query){
    
    $result = mysql_query($query);
    
    return mysql_result($result, 0);
}

?>
