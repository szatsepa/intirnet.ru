<?php
include '../query/connect.php';

$query = "SELECT * FROM customer WHERE id = $_POST[uid]";

$result = mysql_query($query);

$out = mysql_fetch_assoc($result);

echo json_encode($out);

mysql_close();
?>
