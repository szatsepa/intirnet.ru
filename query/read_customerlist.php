<?php
$sort = intval($attributes[r]);

$customers = _allPersons($sort,$roles);

function _allPersons($sort,$roles){
    
    $where = "WHERE role = '$roles[0]' GROUP BY surname, name, patronymic ORDER BY id";

    if($sort){

        $where = "WHERE role = '".$roles[$sort]."' GROUP BY surname, name, patronymic ORDER BY id";
    
    }
    
    $customers = array();

    $query = "SELECT * FROM `customer` $where";

    $result = mysql_query($query) or die($query);

    if(mysql_numrows($result)!=0){
        while ($var = mysql_fetch_assoc($result)){
            array_push($customers, $var);
        }
    }
    
    mysql_free_result($result);
    
    return $customers;
}
?>
