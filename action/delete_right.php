<?php

include '../query/connect.php';

$id = intval($_POST[iface]);

$query = "DELETE FROM d_right WHERE id = $id";

mysql_query($query);

$out = array('ok'=>NULL,'id'=>$id);

$out['ok'] = mysql_affected_rows();

echo json_encode($out);

mysql_close();
?>
