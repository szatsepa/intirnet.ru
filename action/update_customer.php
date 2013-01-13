<?php

include '../query/connect.php';

$query = "UPDATE `customer` SET name = '$_POST[name]', patronymic = '$_POST[patronymic]',surname = '$_POST[surname]', phone = '$_POST[phone]',phone2 = '$_POST[phone2]',fax = '$_POST[fax]',email = '$_POST[email]', postcode = '$_POST[postcode]', address = '$_POST[address]',comments = '$_POST[comments]',tags='$_POST[tags]' WHERE id = $_POST[uid]";

mysql_query($query);

$out = array('ok'=>NULL, 'query'=>$query,'customer'=>$_POST,'act'=>'update');

$aff = mysql_affected_rows();

if($aff > 0)$out['ok'] = $aff;

echo json_encode($out);

mysql_close();
?>
