<?php
include '../query/connect.php';

$query = "SELECT * FROM `users` WHERE id = $_POST[uid]";

$result = mysql_query($query) or die($query);

$out = array();

$out = mysql_fetch_assoc($result);

echo json_encode($out);

mysql_free_result($result);

mysql_close();
?>
