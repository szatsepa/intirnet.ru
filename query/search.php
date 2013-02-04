<?php

include '../query/connect.php';

$out = array();

foreach ($_POST as $key => $value) {
    
    $search_str = substr($value, 1,  strlen($value));
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
