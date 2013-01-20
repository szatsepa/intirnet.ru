<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include '../query/connect.php';

$uid = intval($_POST[uid]);

$query = "UPDATE `d_users` SET `login`='$_POST[log]', `password`='$_POST[psw]' WHERE `id` = $uid";

mysql_query($query);

$out = array('ok'=>0,'query'=>$query);

$af = mysql_affected_rows();

if($af!=0)$out['ok'] = "В таблице произведены замены пароля и логина";

echo json_encode($out);

mysql_close();
?>
