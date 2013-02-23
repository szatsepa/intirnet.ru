<?php
include '../query/connect.php';

$query = "SELECT d.`id`, d.`db_name`, d.`login`,d.`password`,d.`addr` AS server, d.`charset`, d.`inet_name` AS `name`, d.`inet_address` AS `url` FROM `db_data` AS d";

$result = mysql_query($query);

$db = array();

while($row = mysql_fetch_assoc($result)){
    array_push($db, $row);
}

//FROM ON d.`id` = t.`db_id` LEFT JOIN ON t.`db_table` = f.`tablename`

$tmpdb = array();

foreach ($db as $value) {
    
    $tmp = array();
    
    $tmpv = $value;
    
    $query = "SELECT t.`db_table` AS `table` FROM `db_tables` AS t WHERE t.`db_id` = ".$value['id'];
    
    $result = mysql_query($query);
    
    while ($row = mysql_fetch_assoc($result)){
        array_push($tmp, $row);
    }
    
    $tmpv['tables'] = $tmp;
    
    array_push($tmpdb, $tmpv);
}

$db = $tmpdb;

reset($db);

while (count($tmpdb)>0){
    array_pop($tmpdb);
}

for($i=0;$i<count($db);$i++){
    
    $tmpdb[$i]=$db[$i];
    
    $tmpdb[$i]['fields'] = array();
    
    foreach ($db[$i]['tables'] as $key => $value) {
        
//        $tmpdb[$i]['fields'][$value['table']]=array();
        
        $query = "SELECT f.`field_name` AS `field`, f.`this_name` AS `sinonim` FROM `table_fields` AS f WHERE f.`tablename` = '{$value['table']}'";
        
        $result = mysql_query($query);
        
        while ($row = mysql_fetch_assoc($result)){
//           $tmpdb[$i]['fields'][$value['table']],$row ;
        }
        
        
    }
    
    
}

//foreach ($db as $key => $value) {
//    
//    $tmp = array();
//    
//    $tmpv = $value;
//    
//    if($key == 'tables'){
//        foreach ($value as $kluch => $var) {
//            
//            
//            
////            foreach ($var as $tablename) {
////                $tmpf = array(); }
//            
//                ;
//           
//            
//            
////            $result = mysql_query($query);
////            
////            while ($row = mysql_fetch_assoc($result)){
////                array_push($tmpf, $row);
////            }          
//        }
//        
//    }
//    
//    array_push($tmpdb, $tmpv);
//}
echo json_encode($tmpdb);

mysql_close();

?>
