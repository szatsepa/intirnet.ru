<?php

include '../query/connect.php';

$query = "INSERT INTO `customer` (name, patronymic,surname, phone,phone2,fax,email, postcode, address,comments,tags,role ) VALUES ('$_POST[name]','$_POST[patronymic]','$_POST[surname]','$_POST[phone]','$_POST[phone2]','$_POST[fax]','$_POST[email]','$_POST[postcode]','$_POST[address]','$_POST[comments]','$_POST[tags]','$_POST[role]')";

mysql_query($query);

$ins = mysql_insert_id();

$_POST[id] = $ins;


$out = array('ok'=>NULL, 'query'=>$query,'customer'=>$_POST,'act'=>'add');

if($ins > 0)$out['ok'] = $ins;

echo json_encode($out);

mysql_close();
?>
