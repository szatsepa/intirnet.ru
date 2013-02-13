<?php
$data_T = json_decode($attributes[db_data],TRUE);

$user_data = json_decode($attributes[us_data],TRUE);

$set = '';

foreach ($user_data as $key => $value) {
    
    $set .= "`".$key."` = '".$value."',";
    
}



$set = substr($set, 0,(strlen($set)-1));

$query = "UPDATE `$data_T[db_tablename]` SET $set WHERE `id` = '$attributes[uid]'";


echo "<br>$query<br>";

?>
