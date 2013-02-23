<?php
$charset = $_POST['db_charset'];

header("Content-Type: text/html; charset=$charset");

include '../query/connect.php';

$db_id = intval($_POST['db_id']);

$tablename = $_POST['tablename'];

$cdata = json_decode($_POST['cdata'],TRUE);

$ctmp = array();

foreach ($cdata as $value) {
    $query = "SELECT COUNT(*) FROM `customer` WHERE ";
    $where = '';
    foreach ($value as $key => $var) {
        $where .= "`$key` = '$var' AND ";
    }
    $where = substr($where, 0, strlen($where)-5);
    $query .= $where;
    
    $result = mysql_query($query);
    
    $count = mysql_result($result, 0);
    
    if($count == 0){
        
        $value['db_data_id'] = $db_id;
        
        $value['tablename'] = $tablename;
        
        array_push($ctmp, $value);
    }
}

$query = "INSERT INTO `customer`";

foreach ($ctmp as $var) {
    $keys = "(";
    
    $values .= "(";

    foreach ($var as $key => $value) {
        $keys .= '`'.$key.'`,';
        $values .= "'".$value."',";
    }
    $keys = substr($keys, 0,  strlen($keys)-1);
    $values = substr($values, 0,  strlen($values)-1);
    $keys .= ")";
    $values .= "),";
    
    $str = $keys." VALUES ".$values;
    
}

$str = substr($str, 0,  strlen($str)-1);

$query .= $str;

mysql_query($query);

echo json_encode(array('query'=> mysql_affected_rows()));

mysql_close();
?>
