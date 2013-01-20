<?php
include '../query/connect.php';

$id = intval($_POST[fid]);

$query = "INSERT INTO `d_right` (`name`,`right`) VALUES ('$_POST[name]','$_POST[rights]')";

mysql_query($query);

$out = array('ok'=>NULL,'query'=>$query);

$out['ok'] = mysql_insert_id();

echo json_encode($out);

mysql_close();  
?>
