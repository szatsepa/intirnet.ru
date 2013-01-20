<?php

<<<<<<< HEAD
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
=======
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include '../query/connect.php';

$uid = intval($_POST[uid]);

$u_array = array();
    
$result = mysql_query("SELECT u.name, u.patronimyc, u.surname, u.doc_type, u.doc_series, u.doc_number, u.doc_date, u.doc_agency, u.doc_address, u.inn, u.right, r.name AS role, r.right AS all_right FROM d_users AS u, d_right AS r WHERE u.id = $uid AND u.right = r.id");

$u_array = mysql_fetch_assoc($result);

echo json_encode($u_array);

mysql_close();
?>
>>>>>>> branch 'master' of https://github.com/szatsepa/dimon_app.git
