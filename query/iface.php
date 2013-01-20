<?php
$query = "SELECT * FROM d_right";

$result = mysql_query($query);

$ifases = array();

while ($var = mysql_fetch_assoc($result)){
    array_push($ifases, $var);
}

mysql_free_result($result);

?>
