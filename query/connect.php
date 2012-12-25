<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$link = mysql_connect("localhost:/tmp/mysqld.sock","vvz","vvzsecret1975") or die ("Ошибка 1");
mysql_select_db("vvz_intirnet");
mysql_query ("SET NAMES utf8");
$document_root = $_SERVER["DOCUMENT_ROOT"];
$host          = $_SERVER["HTTP_HOST"];

$out = mysql_errno();

//echo $out;

if (mysql_errno() <> 0) exit("Ошибка ".$out);
?>
