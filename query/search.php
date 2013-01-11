<?php

include '../query/connect.php';

$out = array();

foreach ($_POST as $key => $value) {
    if($value){
        $query = "SELECT * FROM customer WHERE `$key` LIKE '%$value%'";

        $result = mysql_query($query);
        
        while ($var = mysql_fetch_assoc($result)){
            array_push($out, $var);
        }
    }
}

$tmp = array_unique($out);

echo json_encode($tmp); 

mysql_close();
?>
