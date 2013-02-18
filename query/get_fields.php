<?php
include 'connect.php';

$tablename = trim($_POST[tablename]);

$query = "SELECT `this_name`, `field_name` FROM `table_fields` WHERE `tablename` = '$tablename'";

$result = mysql_query($query);

$tmp = array();

while ($var = mysql_fetch_assoc($result)){
    
    $tmpo = array("$var[this_name]"=>"$var[field_name]");
    
    array_push($tmp, $tmpo);
}

mysql_free_result($result);

echo json_encode($tmp);

mysql_close();
?>
