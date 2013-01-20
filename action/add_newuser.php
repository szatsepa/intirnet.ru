<?php

/*
 * doc:$("#d_doc").val(),series:$("#d_series").val(),num:$("#d_num").val(),ddate:$("#d_date").val(),agency:$("#d_agency").val(),addr:$("#d_addr").val(),inn:$("#d_inn").val()
 */
include '../query/connect.php';

$uid = intval($_POST[uid]);

$out = array('ok'=>NULL,'uid'=>$uid);

mysql_query("INSERT INTO `d_users` (`name`, `surname`, `patronimyc`, `doc_type`, `doc_series`, `doc_number`, `doc_date`, `doc_agency`, `doc_address`, `inn`, `right`)
                  VALUES ('$_POST[name]','$_POST[surname]','$_POST[patronimyc]','$_POST[doc]','$_POST[series]','$_POST[num]','$_POST[ddate]','$_POST[agency]','$_POST[addr]','$_POST[inn]',1)");

$out['ok'] = mysql_insert_id();

echo json_encode($out);

mysql_close();
?>
