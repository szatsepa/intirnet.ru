<?php
include '../query/connect.php';

$fields = json_decode($_POST[fields],TRUE);

$db_id = intval($_POST[db_id]);

$tmp = array();

foreach ($fields as $value) {
    $field = trim($value);
    $q_count = "SELECT Count(*) FROM `db_tables` WHERE `db_id` = $db_id AND `db_table` = '$field'";
    $result = mysql_query($q_count);
    $count = mysql_fetch_row($result);
    if($count[0] == 0){
        array_push($tmp, $field);
    }
}

if(count($tmp)>0){
    
    $query = "INSERT INTO `db_tables` (`db_id`, `db_table`) VALUES";

    foreach ($tmp as $value) {
        $field = trim($value);
        $query .= "($db_id,'$field'),";
    }

    $query = substr($query, 0, strlen($query)-1);

    mysql_query($query);
}



echo json_encode(array('out'=>  mysql_insert_id(),'error'=>  mysql_errno(),'cntrl'=>$count[0]));

mysql_close();
?>
