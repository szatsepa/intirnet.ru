<?php
function query_user ($arg) {
    $query = "SELECT u.id,
                     u.role,
                     u.surname,
                     u.name,
                     u.patronymic,
                     u.email,
                     u.phone,
                     u.pwd 
              FROM users u   
              WHERE u.id=$arg";

$qry_user = mysql_query($query) or die($query);

return  mysql_fetch_assoc($qry_user);
}
?>