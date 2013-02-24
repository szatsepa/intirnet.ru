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
    
    var $table = "table_fields";
    var $fields = array();
    
    function TableFields(){
        
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
    
    function isTables($tablename, $db_id){
        
        mysql_close();
        
        include '../query/connect.php';
        
        $result = mysql_query("SELECT Count(*) FROM `table_fields` WHERE `tablename` = '$tablename' AND `db_id` = '$db_id'");

        return mysql_result($result, 0, 0);
    }
    
    function getFieldsinDB($tablename, $db_id){
        
        mysql_close();
        
        include '../query/connect.php';
        
        $tmp = array();
        
        $result = mysql_query("SELECT `field_name`,`this_name` FROM `table_fields` WHERE `tablename` = '$tablename' AND `db_id` = '$db_id' ORDER BY `id`");
        
//        echo "SELECT `field_name`,`this_name` FROM `table_fields` WHERE `tablename` = '$tablename' AND `db_id` = '$db_id'  <br>";

        while ($var = mysql_fetch_assoc($result)){
            $tmp[$var['this_name']] = $var['field_name'];
        }
        
        return $tmp;
    }
}

$f_table = new TableFields();

$count_f = $f_table->isTables($attributes['db_tablename'], $attributes['db_id']);

 $fields_sinonim = $f_table->getFieldsinDB($attributes['db_tablename'], $attributes['db_id']) ;

?>
