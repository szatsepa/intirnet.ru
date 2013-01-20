<?php
include '../query/connect.php';

$id = intval($_POST[fid]);

$query = "UPDATE `d_right` SET `name` = '$_POST[name]', `right` = '$_POST[rights]' WHERE id = $id";

mysql_query($query);

$out = array('ok'=>NULL,'id'=>$id);

$out['ok'] = mysql_affected_rows();

echo json_encode($out);

mysql_close();
?>
