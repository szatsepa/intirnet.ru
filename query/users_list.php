<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$query = "SELECT u.id, u.name, u.patronimyc, u.surname, r.name AS `right`,  u.activity FROM d_users AS u, d_right AS r WHERE r.id = u.right AND u.activity = 1";

$result = mysql_query($query);

$users_list = array();

while($var = mysql_fetch_assoc($result)){
    array_push($users_list, $var);
}

mysql_free_result($result);
?>
