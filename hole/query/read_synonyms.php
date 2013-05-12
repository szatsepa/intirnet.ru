<?php
_clearTMP();

$synonyms = readSynonims();

$users = changeFields($users_array, $synonyms);

setTMP($users);

checkCustomers();

function checkCustomers(){
    
    $query = "SELECT c.`id`, t.`surname`, t.`name`, t.`patronymic`, t.`role`, t.`phone`, t.`email`, t.`password` 
                FROM `tmp` t 
                LEFT JOIN `customer` c 
                ON (t.`email`= c.`email`) 
                WHERE c.`id` IS NULL
                AND (t.`role` = 3 OR t.`role` = '')";
    
    $result = mysql_query($query);
    
    while ($row = mysql_fetch_assoc($result)){
        unset($row['id']);
        insertNewCustomers($row);
    }
}

function insertNewCustomers($arr){
    
    $query = "INSERT INTO `customer` ";
    
    $fields = $data = "(";
    
    foreach ($arr as $key => $value) {
        
        $fields .= "`$key`,";
        
        $data .= "'$value',";
    }
    
    $fields = substr($fields, 0, strlen($fields)-1).")";
    
    $data = substr($data, 0, strlen($data)-1).")";
    
    $query .= $fields." VALUES ".$data;
    
    mysql_query($query);
    
    echo mysql_insert_id()."<br>";
    
    return;
}

function changeFields($users,$synonym){
    
    $tmp = array();
    
    foreach ($users as $key => $value) {
        
        $dtmp = explode('_T_', $key);
        
        $tmp[$dtmp[0]][$dtmp[1]] = array();
        
        foreach ($value as $key => $val) {
            
            array_push($tmp[$dtmp[0]][$dtmp[1]], checkFields(get_object_vars($val), $synonym));
        }
    }
    
    return $tmp;
}

function checkFields($uarr,$sarr){
    
    $tmp = array();
    
    foreach ($sarr as $bkey => $bvalue) {
        
        foreach ($bvalue as $tkey => $tvalue) {
            
            foreach ($tvalue as $key => $value) {
                
                foreach ($uarr as $okey => $oval) {
                    
                   $new_key = key($value);
                   
                   if($new_key == $okey){
                       
                       $tmp[$value[$new_key]] = $oval;
                   }                   
                }
                
            }
        }
    }
    return $tmp;
}

function readSynonims(){
    
    $query = "SELECT `db_name` FROM `db_data` WHERE `status` <> 0";

    $result = mysql_query($query);

    $synonyms = array();

    while ($row = mysql_fetch_row($result)){

        $synonyms[$row[0]] = array();

        $rest = mysql_query("SELECT f.`tablename`FROM `table_fields` AS f WHERE f.`this_name` <> '' AND f.`db_id` = (SELECT id FROM `db_data` WHERE `db_name` = '{$row[0]}') GROUP BY f.`tablename`");

        while ($srow = mysql_fetch_assoc($rest)){

            $synonyms[$row[0]][$srow['tablename']] = array();

            $resu = mysql_query("SELECT f.`field_name`, f.`this_name` FROM `table_fields` AS f WHERE f.`this_name` <> '' AND f.`tablename` = '{$srow['tablename']}' AND f.`db_id` = (SELECT id FROM `db_data` WHERE `db_name` = '{$row[0]}')");

            while ($frow = mysql_fetch_assoc($resu)){
                
                array_push($synonyms[$row[0]][$srow['tablename']], array($frow["field_name"]=>$frow['this_name']));
            }
            
            mysql_free_result($resu);
        }
        
        mysql_free_result($rest);
    }
    
    mysql_free_result($result);
    
    return $synonyms;
    
}

function _clearTMP(){
    
    mysql_query("TRUNCATE TABLE `tmp`");
}    

function setTMP($customers){
    
    $step = ceil(count($customers)/1000);
    
    foreach ($customers as $value){
        
        foreach ($value as $val) {
            $query = buildQuery($val);
        }
        
        $aff = insertTmp($query);
    } 
    
    return;
}

function insertTmp($query){
    
    mysql_query($query);
    
    if(mysql_affected_rows()>0){
        return mysql_affected_rows();
    }else{
        return mysql_errno()." => ".$query;
    }    
    
}

function buildQuery($arr){

    $query = "INSERT INTO `tmp` (";

    foreach ($arr[0] as $key => $bvalue) {
        $query .= "`$key`,";
    }
    
    $query = substr($query, 0,  strlen($query)-1).") VALUES "; 
    
    foreach ($arr as $cvalue) {
        $query .= "(";
        foreach ($cvalue as $value) {
            $query .= "'$value',";
        }
        
        $query = substr($query, 0,  strlen($query)-1)."),";
    }

    $query = substr($query, 0,  strlen($query)-1);

    return $query;
}
?>
