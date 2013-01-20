<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include '../query/connect.php';

$uid = intval($_POST[uid]);

$out = array('ok'=>NULL,'uid'=>$uid);

$query = "UPDATE `d_users` SET `name` = '$_POST[name]',`surname`='$_POST[surname]', `patronimyc`='$_POST[patronimyc]', `doc_type`='$_POST[doc]',`doc_series`='$_POST[series]',`doc_number`='$_POST[num]',`doc_date`='$_POST[ddate]',`doc_agency`='$_POST[agency]',`doc_address`='$_POST[addr]',`inn`='$_POST[inn]', `right`='$_POST[role]' WHERE `id`=$uid";

mysql_query($query);

$out['query'] = $query;

$out['ok'] = mysql_affected_rows();

echo json_encode($out);

mysql_close(); 
?>
