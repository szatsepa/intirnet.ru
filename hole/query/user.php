<?php
function query_user ($arg) {
    $query = "SELECT u.role,
                     u.surname,
                     u.name,
                     u.email,
                     u.pwd 
              FROM users u   
              WHERE u.id=$arg";

$qry_user = mysql_query($query) or die($query);

$tmp = mysql_fetch_assoc($qry_user);

return $tmp;
}
?>