<?php

mysql_close();

$dbname = $attributes[db_name];

mysql_connect("$attributes[db_server]","$attributes[db_login]","$attributes[db_pwd]") or die ("Ошибка - ".  mysql_errno());

mysql_select_db($dbname);

mysql_query ("SET NAMES $attributes[db_charset]");

$qry_fields = mysql_query("SELECT COLUMN_NAME
                            FROM information_schema.COLUMNS
                            WHERE TABLE_SCHEMA = DATABASE()
                            AND TABLE_NAME = '$attributes[db_tablename]'
                            ORDER BY ORDINAL_POSITION");

$fields_name = array();

while ($var = mysql_fetch_row($qry_fields)){
    array_push($fields_name, $var[0]);
}

$where = '';

if(isset($attributes[find]) && $attributes[find]==1){
    $where = "WHERE `$attributes[db_field]` LIKE '%".$attributes[str_find]."%'";
}

$result = mysql_query("SELECT * FROM `$attributes[db_tablename]` $where"); 

$rows = array();

while ($row = mysql_fetch_assoc($result)){
    array_push($rows, $row);
}

mysql_free_result($result);

//print_r($fields_sinonim);

$tmp = array();

$ctmp = array();

foreach ($rows as $value){
    foreach ($value as $key => $var) {
        if($fields_sinonim[$key])$tmp[$fields_sinonim[$key]] = $var;
    }
    
    array_push($ctmp, $tmp);
}

$j_customers = json_encode($ctmp);
?>
