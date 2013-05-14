<?php
$this_db = new IntirnetDb();

$server_query = $_POST['addr'];

$customer = $_POST;

unset($customer['addr']);

$add_customer = new Prepare();

$responce = $add_customer->addCustomer($this_db->allDB(), $customer, NULL);

if($responce > 0){
    header("location:index.php?$server_query");
}else{
    header("location:index.php?$server_query&adderror=1");
}

?>
