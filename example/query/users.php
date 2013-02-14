<?php
$query = "SELECT * FROM `users`";

$result = mysql_query($query) or die($query);

$users = array();

while ($var = mysql_fetch_assoc($result)){
    array_push($users, $var);
}

mysql_free_result($result);
?>
