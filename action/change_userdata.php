<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *.val(),ddate:$("#d_date").val(),agency:$("#d_agency").val(),:$("#d_addr").val(),inn:$("#d_inn").val()}); 
 */
include '../query/connect.php';

$uid = intval($_POST[uid]);

$query = "UPDATE `d_users` 
             SET `name`='$_POST[name]',
                 `surname`='$_POST[surname]', 
                 `patronimyc`='$_POST[patronimyc]',
                 `doc_type`='$_POST[doc]',
                 `doc_series`='$_POST[series]',
                 `doc_number`='$_POST[num]',
                 `doc_date`='$_POST[ddate]',
                 `doc_agency`='$_POST[agency]',
                 `doc_address`='$_POST[addr]',
                 `inn`='$_POST[inn]'
           WHERE `id`=$uid";

$out = array('ok'=>NULL,'query'=>$query);

mysql_query($query);

$out['aff'] = mysql_affected_rows();

if($out['aff'] > 0){
    
    unset($_SESSION[user]);
    
    $out['ok']="Даные в таблице изменены";
    
    $result = mysql_query("SELECT * FROM d_users WHERE id = $uid"); 

    $row = mysql_fetch_assoc($result);
    
    $_SESSION[user] = $row;
    
    }

echo json_encode($out);

mysql_close();
?>
