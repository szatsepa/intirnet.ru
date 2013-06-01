<?php
include '../query/connect.php';

$output = array('query'=>'');

$output['fields'] = $_POST['fields'];

$count_fields = 0;

foreach ($_POST['fields'] as $key => $value) {
    
    
    
    if($value !== '0'){
        
        $query = "UPDATE `table_fields` SET `this_name` = '{$value}' WHERE `db_id` = '{$_POST['db_id']}' AND `tablename` = '{$_POST['tablename']}' AND `field_name` = '$key'";
    
        mysql_query($query) or die($output['error'] = mysql_errno());
        
        $count_fields += mysql_affected_rows();
    }
}

$output['query'] = $count_fields;

mysql_query("UPDATE `db_data` SET `complite` = 1 WHERE `id` = {$_POST['db_id']}");

echo json_encode($output);

mysql_close();
?>
