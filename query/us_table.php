<?php

$db_id = intval($attributes[db_id]);

$query = "SELECT * FROM `db_tables` WHERE `db_id`=$db_id";

$result = mysql_query($query);

$is_tables = array();

while ($var = mysql_fetch_assoc($result)){
    $is_tables[$var[id]] = $var[db_table];
}

mysql_free_result($result); 
?>
