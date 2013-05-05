<?php

$query = "SELECT * FROM db_data WHERE status <> 0";

$result = mysql_query($query) or die($query);

$res_data = array();

if(mysql_numrows($result)>0){
    while ($var = mysql_fetch_assoc($result)){
        array_push($res_data, $var);
    }
}
mysql_free_result($result);
?>
