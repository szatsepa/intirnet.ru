<?php
include 'connect.php';

$id = intval($_POST[iface]);

$query = "SELECT * FROM d_right WHERE id = $id";

$out = array('query'=>$query);

$result = mysql_query($query);

$out['ok'] = mysql_fetch_assoc($result);

echo json_encode($out);

mysql_close();
?>
