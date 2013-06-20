<?php
include 'connect.php';

$table = trim($_POST['table']);

$dbi = intval($_POST['dbi']);

$query = "INSERT INTO `db_tables` (`db_id`,`db_table`) VALUES ($dbi, '$table')";

mysql_query($query);

$query = "INSERT INTO `table_fields` (`db_id`, `tablename`, `field_name`) VALUES ";

$output['fields'] = array();

$str_fields = '';

foreach ($_POST['fields'] as $value) {
    $tmp = trim($value);
    array_push($output['fields'], $tmp);
    $str_fields .= "($dbi, '$table','$tmp'),";
}

$query .= substr($str_fields, 0, strlen($str_fields)-1);

mysql_query($query);

$output = array('table'=>$table, 'tid'=>  mysql_insert_id(),'query'=>$query,'rows'=>  mysql_affected_rows());

echo json_encode($output);


mysql_close();
?>
