<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include '../query/connect.php';

$uid = intval($_POST[uid]);

$out = array('ok'=>NULL,'uid'=>$uid);

$result = mysql_query("UPDATE d_users SET activity = 0 WHERE id = $uid");

$out['ok'] = mysql_affected_rows();

echo json_encode($out);

mysql_close(); 
?>
