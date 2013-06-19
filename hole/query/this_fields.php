<?php
if(isset($attributes['tid']) and !$attributes['tid']){
    header("location:index.php?act=main");
}

class FieldSelect {
    
    var $fields;
    
    function __construct() {
        
    }
    public function fieldSelect($tid, $did) {
        
        $this->fields = $this->getFields($tid, $did);
        
        return $this->fields;
    }
    
    public function getSinonim($tid,$did,$field,$id){
        
//        if($field == 'id')            return NULL;
        
        $output = $synonim = '';              
        
        $query = "SELECT f.`field_name` AS `synonim` 
                    FROM `db_data` db, `db_tables` t, `table_fields` f, `synonims` s   
                    WHERE db.`complete` = 1 AND 
                          db.`id` = $did AND 
                          db.`id` = t.`db_id` AND 
                          t.`db_table` = f.`tablename` AND 
                          f.`tablename` = (SELECT `db_table` FROM `db_tables` WHERE `id` = $tid) AND 
                          f.`field_name` = s.`synonim` AND 
                          s.`fieldname` = '$field'  AND 
                          f.`tablename` = s.`tablename`";
       
        $result = mysql_query($query);
        
        $synonim = mysql_fetch_assoc($result);
        
        if(!$synonim){
            $output = "<tr><td>{$field}</td><td>{$this->getSelect($id)}</td><td></td></tr>";
        }else{
            $output = "<tr style='background-color:#afffaf'><td>{$field}</td><td>{$synonim['synonim']}</td><td><a id='e_{$field}' class='ico-edit' title='Редактировать'></a></td></tr>";
        }
        
        return $output;
    }

    public function getSelect($id){
        
        $str_out = "<select class='common' id='$id'>";
        
        $str_out .= "<option value='0'>Выберите синоним</option>";
        
        foreach ($this->fields as $value) {
            $str_out .= "<option value='$value'>$value</option>";
        }
        
        $str_out .= "</select>";
        
        return $str_out;
        
    }
    
    private function getFields($tid, $did){
        
//        $query = "SHOW COLUMNS FROM `".DBNAME."`.`customer`";
        
        $query = "SELECT * FROM `table_fields` AS f WHERE f.tablename = (SELECT `db_table` FROM `db_tables` WHERE `id` = $tid) AND f.db_id = $did ORDER BY f.field_name";
        
        $result = mysql_query($query);

        $fieldlist = array();
        
        if(!$result)            return NULL;

        while ($row = mysql_fetch_assoc($result)){
            array_push($fieldlist,$row['field_name']);
        }

        mysql_free_result($result);
        
//        rsort($fieldlist);
        
        return $fieldlist;
    }
    
    public function getFieldsOfTable($tid, $did){
        
        $query = "SELECT `db_table` FROM `db_tables` WHERE `id` = $tid";

        $result = mysql_query($query) or die(mysql_errno());

        $table = mysql_result($result, 0);

        mysql_free_result($result);

//        $query = "SELECT * FROM `table_fields` AS f WHERE f.tablename = (SELECT `db_table` FROM `db_tables` WHERE `id` = $tid) AND f.db_id = $did ORDER BY f.field_name";
        
        $query = "SHOW COLUMNS FROM `".DBNAME."`.`customer`";

        $result = mysql_query($query) or die(mysql_errno());

        $tablefields = array();
        
        if(!$result)            return NULL;

        while ($row = mysql_fetch_row($result)){
            array_push($tablefields, $row[0]);
        }

        mysql_free_result($result);
        
        return $tablefields;
        
    }

}

?>
