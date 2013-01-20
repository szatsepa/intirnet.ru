<?php
//$differences = array();
//
//$query = "SELECT t.* FROM `tmp_U1` AS t LEFT JOIN `customer` AS c USING(id) WHERE t.`name`<>c.`name` OR t.`surname`<>c.`surname` OR t.`patronymic`<>c.`patronymic` OR t.`password` <> c.`password` OR t.`phone`<> c.`phone` OR t.`email`<>c.`email` OR t.`address`<> c.`address`";
//
//$result = mysql_query($query) or die($query);
//
//if(mysql_numrows($result)!=0){
//    while ($var = mysql_fetch_assoc($result)){
//        array_push($differences, $var);
//    }
//}
//
//mysql_free_result($result);
//
//
//
//$add_rows = 0;
//
//if(isset($attributes[chng]) && $attributes[chng] == 1){
//    foreach ($differences as $value) {
//        $query = "UPDATE customer SET name = '$value[name]', surname = '$value[surname]', patronymic = '$value[patronymic]', password = '$value[password]', phone = '$value[phone]',email = '$value[email]', address = '$value[address]' WHERE id = $value[id]";
//        
//        mysql_query($query) or die($query);
//        
//        if(mysql_affected_rows()!=0){
//            $add_rows++;
//        }
//    }
//    
//    unset($differences);
//    unset($attributes[chng]);
//}
?>