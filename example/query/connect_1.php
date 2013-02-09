<?php

mysql_close();

$dbname = $attributes[db_name];

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
mysql_connect("$attributes[db_server]","$attributes[db_login]","$attributes[db_pwd]") or die ("Ошибка 1 ".  mysql_errno());
mysql_select_db($dbname);
//mysql_query ("SET NAMES $attributes[db_charset]");

//$out = mysql_errno();

if (mysql_errno() <> 0) exit("Ошибка ".mysql_errno());

$result = mysql_list_tables($dbname);

// $result = mysql_query("SHOW TABLES FROM `$dbname` WHERE `Tables_in_gb_autotriton` LIKE '%user%' OR  `Tables_in_gb_autotriton` LIKE '%customer%'");
    
    if (!$result) {
        print "DB Error, could not list tables<br>"; 
        print 'MySQL Error: ' . mysql_errno();
        exit;
    }else{
        $tables = array();
        while ($row = mysql_fetch_row($result)) {
//            print "Table: $row[0]<br>";
            array_push($tables, $row);
        }
    }
    

    mysql_free_result($result);
?>

