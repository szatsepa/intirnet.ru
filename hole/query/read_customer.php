<?php
include '../config.php'; include '../query/connect.php';

$query = "SELECT * FROM customer AS c WHERE c.id = '{$_POST['uid']}'";

$result = mysql_query($query);

$row = mysql_fetch_assoc($result);

mysql_free_result($result);

mysql_close();

echo json_encode($row);

?>
