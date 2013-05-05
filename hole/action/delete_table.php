<?php
include '../query/connect.php';

$table = trim($_POST['table']);

$dbi = intval($_POST['dbi']);

$query = "DELETE `table_fields`, `db_tables` FROM `table_fields`, `db_tables` 
    WHERE `table_fields`.`tablename` = `db_tables`.`db_table` 
    AND `db_tables`.`db_table` = '$table'
        AND `db_tables`.`db_id` = $dbi";

mysql_query($query);

echo json_encode(array('query'=>$query, 'rows'=> mysql_affected_rows()));

mysql_close();
?>
