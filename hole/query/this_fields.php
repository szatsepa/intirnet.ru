<?php
if(isset($attributes['tid']) and !$attributes['tid']){
    header("location:index.php?act=main");
}

class FieldSelect {
    
    var $fields;

    function FieldSelect() {
        
        $this->fields = $this->getFields();
    }
    
    function getSelect($id){
        
        $str_out = "<select class='common' id='$id'>";
        
        $str_out .= "<option value='0'>Выберите синоним</option>";
        
        foreach ($this->fields as $value) {
            $str_out .= "<option value='$value'>$value</option>";
        }
        
        $str_out .= "</select>";
        
        return $str_out;
        
    }
    
    private function getFields(){
        
        $query = "SHOW COLUMNS FROM `".DBNAME."`.`customer`";
        
        $result = mysql_query($query);

        $fieldlist = array();

        while ($row = mysql_fetch_row($result)){
            array_push($fieldlist, $row[0]);
        }

        mysql_free_result($result);
        
        array_shift($fieldlist);
        
        rsort($fieldlist);
        
        return $fieldlist;
    }
    
    public function getFieldsOfTable($tid, $did){
        
        $query = "SELECT `db_table` FROM `db_tables` WHERE `id` = $tid";

        $result = mysql_query($query) or die(mysql_errno());

        $table = mysql_result($result, 0);

        mysql_free_result($result);

        $query = "SELECT * FROM `table_fields` AS f WHERE f.tablename = (SELECT `db_table` FROM `db_tables` WHERE `id` = $tid) AND f.db_id = $did ORDER BY f.field_name";

        $result = mysql_query($query) or die(mysql_errno());

        $tablefields = array();

        while ($row = mysql_fetch_assoc($result)){
            array_push($tablefields, $row);
        }

        mysql_free_result($result);

        array_shift($tablefields);
        
        return $tablefields;
        
    }

}

?>
