<?php
include '../query/connect.php';

$query = "SELECT db.id  
            FROM `db_data` AS db 
            LEFT JOIN `db_tables` AS dbt ON (db.`id` = dbt.`db_id`) 
            LEFT JOIN `table_fields` AS tf ON (dbt.`db_table` = tf.`tablename`) 
            WHERE tf.`this_name` <> '' GROUP BY db.id";

$result = mysql_query($query);

while ($row = mysql_fetch_row($result)){
    
    $query = "UPDATE `db_data` SET `complite` = 1 WHERE `id` = {$row[0]}";
    
    mysql_query($query);
}

echo mysql_affected_rows();

mysql_close();
?>
