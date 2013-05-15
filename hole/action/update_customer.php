<?php
$this_db = new IntirnetDb();

$server_query = $_POST['addr'];

$customer = $_POST;

unset($customer['addr']);

$dell_Cu = new Prepare();

$where = '';

$set = "";

foreach ($customer as $key => $value) {
    
    if(strstr($key, "mail")){
        
        $where .= " `$key` = '". $value."' AND";
    }
            
    $set .= "`$key` = '$value',";        
    
}

$set = substr($set, 0, strlen($set)-1);

$where = substr($where, 0, strlen($where)-3);

$query = "UPDATE `customer` SET {$set} WHERE ".$where;

mysql_query($query);

$dell_Cu->delCustomer($this_db->allDB(), $_POST['email']);

if(mysql_affected_rows()>0){
    header("location:index.php?$server_query");
}
?>
