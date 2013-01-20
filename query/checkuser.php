<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_SESSION[auth]) && $_SESSION[auth]=='yes'){
    
    $u_array = array();
    
    $result = mysql_query("SELECT * FROM d_users WHERE id = $_SESSION[id]");
    
    $u_array = mysql_fetch_assoc($result);

//    $_SESSION[user] = $row;
}
?>
