<?php

include '../query/connect.php';

$query = "UPDATE `db_data` SET db_name = '$_POST[db_name]', `login` = '$_POST[login]', `password` = '$_POST[password]', `addr` = '$_POST[addr]', `charset` = '$_POST[charset]', `db_query` = '$_POST[db_query]' WHERE id = $_POST[id]";

mysql_query($query);

$out = array('query'=>$query,'aff'=>mysql_affected_rows());

if($out['aff'] > 0){
    $out['ok'] = $_POST;
}

echo json_encode($out);

mysql_close();
?>
