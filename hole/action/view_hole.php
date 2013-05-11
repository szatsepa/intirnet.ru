<?php
//header('Content-type: text/html; charset=utf-8');

$tables_fields = array();

$users_array = array();

$and = '';

$act = array('main'=>0,'dbinfo'=>0,'table'=>0,'customers'=>1);

if(isset($attributes['db_id'])){
    $and = " AND db.`id` = {$attributes['db_id']}";
}

if($act[$attributes['act']] === 0){
        
    $query = "SELECT db.`id`, db.`db_name`, db.`login`, db.`password`, db.`addr`, db.`charset`, db.`inet_name`, db.`inet_address` FROM `db_data` AS db WHERE db.`status` <> 0 $and";    
       
}elseif ($act[$attributes['act']] === 1) {
    
    $query = "SELECT db.`id`, db.`db_name`, db.`login`, db.`password`, db.`addr`, db.`charset`, db.`inet_name`, db.`inet_address`, t.`db_table` AS tablename, t.`id` AS tid FROM `db_data` AS db, `db_tables` AS t WHERE db.`status` <> 0 AND db.`id` = t.`db_id`";
}

$result = mysql_query($query) or die(mysql_errno());

$dbases = '';

$tmp = array();



while ($row = mysql_fetch_assoc($result)){
    
//    echo getDbdata($row)."<br>";
    
    $tmp = get_object_vars(json_decode(getDbdata($row),FALSE));
    
    $fkey = key($tmp);
    
    if(!array_key_exists('tablename', $row)){
        
       $tables_fields[$key] = $tmp[$key];
        
    }else{
        
        $tmpu = get_object_vars($tmp[$fkey]);
        $skey = key($tmpu);
        $users_array[$fkey.'_T_'.$skey]=$tmpu[$skey];
    }
    
    
        
 }

mysql_free_result($result);

function getDbdata($rows){
     //строка с POST данными
    $data = '';

    foreach ($rows as $key => $value){
        $data .= "&$key=$value";
    }
    
   //задаем контекст
    $context = stream_context_create(
    array(
            'http'=>array(
                            'header' => "User-Agent: Brauzer 2/0\r\nConnection: Close\r\n\r\n",
                            'method' => 'POST',
                            'content' => $data                
                         )
        )
    );

    $contents = file_get_contents("http://{$rows['inet_address']}/hole/hole.php", false ,$context);
    
    return $contents;
}
//print_r($users_array);
//echo "<br>";
?>