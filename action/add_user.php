<?php

include '../query/connect.php';

$query = "INSERT INTO `users` (pwd,name,patronymic,surname,phone,phone2,fax,email,postcode,address,comments,tags) VALUES ('$_POST[pwd]','$_POST[name]','$_POST[patronymic]','$_POST[surname]','$_POST[phone]','$_POST[phone2]','$_POST[fax]','$_POST[email]','$_POST[postcode]','$_POST[address]','$_POST[comments]','$_POST[tags]')";

mysql_query($query);

$out = array('ok'=>NULL, 'query'=>$query,'customer'=>$_POST);

$aff = mysql_affected_rows();

if($aff > 0)$out['ok'] = $aff;

echo json_encode($out);

mysql_close();
?>