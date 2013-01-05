<?php

include '../query/connect.php';

$query = "INSERT INTO `db_data` (`db_name`,`login`,`password`,`addr`,`charset`,`db_query`) VALUES ('$_POST[db_name]','$_POST[login]','$_POST[password]','$_POST[addr]','$_POST[charset]','$_POST[db_query]')";

mysql_query($query);

$out = array('query'=>$query,'ins'=>  mysql_insert_id());

if($out['ins'] > 0){
    $out['ok'] = $_POST;
}

echo json_encode($out);

mysql_close();
?>
