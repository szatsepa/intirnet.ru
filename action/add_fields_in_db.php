<?php
include '../query/connect.php';

$fields = json_decode($_POST[str_json],TRUE);

$db_id = intval($_POST[db_id]);

$tablename = trim($_POST[tablename]);

$tmp = array();

if(count($fields)==0)exit ();

foreach ($fields as $key => $value) {
    
    $field = trim($value);
    
    $base_name = trim($key);
    
    $q_count = "SELECT Count(*) FROM `table_fields` WHERE `db_id` = $db_id AND `field_name` = '$field' AND `this_name` = '$base_name' AND `tablename` = '$tablename'";
    
    $result = mysql_query($q_count);
    
    $count = mysql_fetch_row($result);
    
    if($count[0] == 0){
        $tmp[$base_name] = $field;
    }
}

if(count($tmp)>0){
    
    $query = "INSERT INTO `table_fields` (`db_id`, `field_name`, `this_name`,`tablename`) VALUES";

    foreach ($tmp as $key => $value) {
        
        $query .= "($db_id,'$value','$key','$tablename'),";
    }

    $query = substr($query, 0, strlen($query)-1);

    mysql_query($query);
}



echo json_encode(array('out'=> mysql_affected_rows(),'error'=>  mysql_errno(),'cntrl'=>$q_count));

mysql_close();
?>
