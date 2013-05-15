<?php

$this_db = new IntirnetDb();

$server_query = $_POST['addr'];

$dell_Cu = new Prepare();

$query = "DELETE FROM `customer` WHERE `email` = '{$_POST['email']}'";

mysql_query($query);

$dell_Cu->delCustomer($this_db->allDB(), $_POST['email']);

if(mysql_affected_rows()>0){
    header("location:index.php?$server_query");
}
?>
