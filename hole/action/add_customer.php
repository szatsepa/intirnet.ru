<?php
$this_db = new IntirnetDb();

//$db = $this_db->allDB();

$server_query = $_POST['addr'];

$customer = $_POST;

unset($customer['addr']);

$add_customer = new Prepare();

$responce = $add_customer->addCustomer($this_db->allDB(), $customer);

echo "$responce";

//if($responce > 0){
//    header("location:index.php?$server_query");
//}else{
//    header("location:index.php?$server_query&adderror=1");
//}

?>
