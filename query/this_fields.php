<?php

$qry_fields = mysql_query("SELECT COLUMN_NAME
                            FROM information_schema.COLUMNS
                            WHERE TABLE_SCHEMA = DATABASE()
                            AND TABLE_NAME = 'customer'
                            ORDER BY ORDINAL_POSITION");

$this_fields = array();

while ($var = mysql_fetch_row($qry_fields)){
    array_push($this_fields, $var[0]);
}

class TableFields{
    
    var $table;
    var $fields = array();
    
    function TableFields($tablename){
        $this->table = $tablename;
    }
    
    function getData(){
        $table = $this->table;
        $result = mysql_query("SELECT * FROM `$table`");
        $tmp = array();
        while ($row = mysql_fetch_assoc($result)){
            array_push($tmp, $row);
        }
        return $tmp;
    }
    
    function isTables($tablename){
        
        mysql_close();
        
        include '../query/connect.php';
        
        $result = mysql_query("SELECT Count(*) FROM `table_fields` WHERE `tablename` = '$tablename'");
        
        $row = mysql_fetch_row($result);
        
        return $row[0];
    }
}

$f_table = new TableFields("table_fields");

?>
