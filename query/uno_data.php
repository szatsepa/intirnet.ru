<?php

include 'connect.php';

$query = "SELECT * FROM db_data WHERE id = $_POST[id]";

$result = mysql_query($query);

$out = NULL;

$out = mysql_fetch_assoc($result);

echo json_encode($out);

mysql_close();
?>
