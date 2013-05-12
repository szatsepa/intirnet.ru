<?php

prepareData(allDB());


function allDB(){
    
    $tmp = array('all' => array());
        
    $query = "SELECT db.`inet_address`, db.`id`, db.`db_name`, db.`login`, db.`password`, db.`addr`, db.`charset`, t.`db_table` AS tablename 
                FROM `db_data` db, `db_tables` t 
                WHERE db.`id` = t.`db_id` AND
                db.`status` <> 0 AND 
                db.`complite` <> 0";
    
    $result = mysql_query($query);
    
    while ($row = mysql_fetch_assoc($result)){
        
        $tmp[$row['db_name'].'_T_'.$row['tablename']] = getSynonym($row);
        
        array_push($tmp['all'], $tmp[$row['db_name'].'_T_'.$row['tablename']]);
    }
    
//    var_dump();
    
    return $tmp['all'];
}

function getSynonym($array){
    
    $tmp = array();

    $query = "SELECT `field_name`, `this_name` 
                FROM `table_fields` 
                WHERE `db_id` = '{$array['id']}' AND 
                      `tablename` = '{$array['tablename']}' AND
                      `this_name` <> ''";

    $result = mysql_query($query);

    while ($row = mysql_fetch_assoc($result)){
        array_push($tmp, array_merge($array,$row));
    }
    
    return $tmp;
}

function prepareData($array){
    
    foreach ($array as $value) {
                
        $db_data = '';
        
        $tmp = $value[0];
        
        $path = $tmp['inet_address'];
        
        for($i=0;$i<2;$i++){
            array_pop($tmp);            
        }
        
        array_shift($tmp);
        
        foreach ($tmp as $key => $var) {
            $db_data .= "&$key=$var";
        }
        
        $fields = '';
        
        foreach ($value as $key => $val) {
            $fields .= "`{$val['this_name']}`,";
        }
        
        $fields = substr($fields, 0, strlen($fields)-1);
            
        $query = "SELECT $fields 
                FROM `customer`";
    
        $result = mysql_query($query);

        while ($row = mysql_fetch_assoc($result)){

            $customer_data = _customerString($row); 
            
            
            
            foreach ($value as $var) {
                
                $customer_data = str_replace($var['this_name'], $var['field_name'], $customer_data);
                
            }

            setDbdata($path, $db_data, $customer_data);
        }
    }
    
    return;
}

function _customerString($array){
    
    $output_str = '';
    
    foreach ($array as $key => $value) {
        if($value != '')$output_str .= "$key:$value;";
    }
    
    return substr($output_str, 0, strlen($output_str)-1);
}

function getDb_Data($db_name){
    
    $query = "SELECT `db_name`, `login`, `password`, `addr`, `charset` FROM `db_data` WHERE `db_name` = '$db_name'";
    
    $result = mysql_query($query);
    
    $row = mysql_fetch_assoc($result);
    
    $data = '';
    
    foreach ($row as $key => $value){
        $data .= "&$key=$value";
    }
    
    return $data;
}

function setDbdata($path,$db_data,$customer){

    $output = $db_data."&customer=".$customer; 
   //задаем контекст
    $context = stream_context_create(
    array(
            'http'=>array(
                            'header' => "User-Agent: Brauzer 2/0\r\nConnection: Close\r\n\r\n",
                            'method' => 'POST',
                            'content' => $output                
                         )
        )
    );

    $contents = file_get_contents("http://{$path}/hole/hole_insert.php", false ,$context);
    
//    var_dump($context);
    echo $contents.'<br>';
    
    return $contents;
}
?>
