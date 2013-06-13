<?php

class Sinchronisation {

    function __construct() {
        
    }
    
    public function getData($tablename) {
        
        $query = "SELECT * FROM $tablename";
        
        $result = mysql_query($query) or die("ERROR ".mysql_errno());
        
        $tmp = array();
        
        while ($row = mysql_fetch_assoc($result)){
            array_push($tmp, $row);
        }
        
        return $tmp;
    }

}
?>
