<?php

mysql_close();

$dbname = $attributes[db_name];

//echo "$attributes[db_server]","$attributes[db_login]","$attributes[db_pwd]<br>";

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

//print_r($fields_name);
//
//echo "<br>";

$result = mysql_query("SELECT * FROM `$attributes[db_tablename]");

$rows = array();

while ($row = mysql_fetch_assoc($result)){
    array_push($rows, $row);
}

mysql_free_result($result);

//print_r($rows);
?>
