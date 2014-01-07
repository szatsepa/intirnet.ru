<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//echo DBHOST." ".LOGIN." ".PASSWORD." ".DBNAME;
mysql_connect(DBHOST,LOGIN,PASSWORD) or die ("Ошибка 1");
mysql_select_db(DBNAME);
mysql_query ("SET NAMES utf8");
$document_root = $_SERVER["DOCUMENT_ROOT"];
$host          = $_SERVER["HTTP_HOST"];

$out = mysql_errno();

if (mysql_errno() <> 0) exit("Ошибка ".$out);

?>

