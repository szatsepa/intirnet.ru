<?php
$is_tables = _using_tables(intval($attributes['db_id']));

function _using_tables($did){
    $query = "SELECT * FROM `db_tables` WHERE `db_id`= $did";

    $result = mysql_query($query);

    $is_tables = array();

    while ($var = mysql_fetch_assoc($result)){
        $is_tables[$var['id']] = $var['db_table'];
    }

    mysql_free_result($result);
    
    return $is_tables;
}

 
?>
