<?php
$this_db = new IntirnetDb();

$server_query = $_POST['addr'];

$customer = $_POST;

unset($customer['addr']);

var_dump($customer);
echo "<br>";
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

//echo "<br>$query";

$add_customer = new Prepare();

$response = $add_customer->addCustomer($this_db->allDB(), $customer, 1);

echo "$response<br>";

//if($response > 0){
//    header("location:index.php?$server_query");
//}else{
//    header("location:index.php?$server_query&adderror=1");
//}
?>
