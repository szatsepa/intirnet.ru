<?php
$tmp_array = array();

$new_customers = array();

$query = "SELECT t.user_id, t.name, t.patronymic, t.surname, t.role, t.email, t.phone, t.tablename, t.db_data_id FROM `tmp` AS t LEFT JOIN `customer` AS c USING(id) WHERE c.id IS NULL";

$result = mysql_query($query) or die($query." -> ".  mysql_error());

if($result){
    while($var = mysql_fetch_assoc($result)){

        array_push($tmp_array, $var);
    }
}

$new_customers = array_unique($tmp_array);

mysql_free_result($result);
 

if(count($new_customers)){
    ?>
<script type="text/javascript">
    alert("В сторонних базах зарегистрировались новые клиенты!\n\t\t Таблица будет дополнена!")
</script>
<?php
        _insertNewPersons($new_customers, $odb_tables);
}

$customers = _allPersons(NULL);

function _allPersons($sort){
    
    $customers = array();

    $query = "SELECT * FROM `customer` $sort";

    $result = mysql_query($query) or die($query);

    if(mysql_numrows($result)!=0){
        while ($var = mysql_fetch_assoc($result)){
            array_push($customers, $var);
        }
    }

    mysql_free_result($result);
    
    return $customers;
}

function _insertNewPersons($arr, $db){
    
    foreach ($arr as $value) {
        
        _addToBases(_isWho(array('uid'=>$value[user_id],'db'=>$value[db_data_id],'tablename'=>$value[tablename])), $db);
        
//        $query = "INSERT INTO `customer` (user_id,role,surname,name,patronymic,email,phone,tablename,db_data_id) VALUES ($value[user_id],'$value[role]','$value[surname]','$value[name]','$value[patronymic]','$value[email]','$value[phone]','$value[tablename]',$value[db_data_id])";
//        
//        mysql_query($query) or die("Помилка ".  mysql_error());
    }
    
    return NULL;
}

function _isWho($men){
    
    $result = mysql_query("SELECT * FROM `db_data` WHERE id = $men[db]");
    $db = mysql_fetch_assoc($result);
    
    mysql_close();
    mysql_connect($db[addr], $db[login], $db[password]);
    mysql_select_db($db[db_name]);
    mysql_query ("SET NAMES $db[charset]");
    
    $result = mysql_query("SELECT * FROM `$men[tablename]` WHERE id = $men[uid]");
    
    mysql_close();
    
    include '../query/connect.php';
    
    return mysql_fetch_assoc($result);
}

function _addToBases($customer, $db){
    
   $need_tables = array('customer'=>array(),'users'=>array());
   
   ksort($customer);
    
    foreach ($db as $val) {
        
        if($customer [db_data_id] != $val[db_id]){
        
            mysql_close();
            mysql_connect($val[addr], $val[login], $val[password]);
            mysql_select_db($val[db_name]);
            mysql_query ("SET NAMES $val[charset]");
            
            foreach ($need_tables as  $key => $value) {
                
                if(mysql_table_seek($key, $val[db_name])){
                        $need_tables[$key][$val[db_name]]=array();
                        
                        $result = mysql_query("SHOW COLUMNS FROM $key");
                        $tmp = array();
                        while ($fn = mysql_fetch_assoc($result)){
                            
                            array_push($tmp, $fn[Field]);
                        }
                        sort($tmp);
                        $need_tables[$key][$val[db_name]] = $tmp;
                        adaptingFields($customer, $tmp,$val[db_id]);
                       
                }
            }
        }
    }
        include '../query/connect.php';

}

function adaptingFields($customer,$fields,$db_id){
    echo "<br>USER ->>      ";
    print_r($customer);
    $equal = array();
    $out_customer = array('db_id'=>$db_id);
    foreach ($fields as $value) {
        foreach ($customer as $key => $var) {
            if($key == $value)$out_customer[$value]=$var;
//            if(ereg("mail", $value)){
//                $out_customer[$value]=$var;
//            }
//            if($value == 'role' && $key == 'role'){
//                $out_customer[$value] = getRoleID($var);
//            }
            if($value == 'id')unset ($out_customer[$value]);
//            if($value == 'pwd')
        }
    }  
    echo "<br>adapting =>> ";
    print_r($out_customer);
    echo "<br>:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::<br>";
}

function getRoleID($name){
    $result = mysql_query("SELECT id FROM roles WHERE name = '$name'");
    $row = mysql_fetch_row($result);
    return $row[0];
}

function mysql_table_seek($tablename, $dbname)
{
    $rslt = mysql_query("SHOW TABLES FROM `{$dbname}` LIKE '" . mysql_real_escape_string(addCslashes($tablename, "\\%_")) . "';");

    return mysql_num_rows($rslt) > 0;
}
?>
