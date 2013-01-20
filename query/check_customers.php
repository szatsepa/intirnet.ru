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
    $GLOBALS['cu'] = count($new_customers);
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
        
        $cu = _isWho(array('uid'=>$value[user_id],'db'=>$value[db_data_id],'tablename'=>$value[tablename]));
        
        $cu[role_name] = $value[role];
        
        $cu[db_data_id] = $value[db_data_id];
        
        $query = "INSERT INTO `customer` (user_id,role,surname,name,patronymic,email,phone,tablename,db_data_id) VALUES ($value[user_id],'$value[role]','$value[surname]','$value[name]','$value[patronymic]','$value[email]','$value[phone]','$value[tablename]',$value[db_data_id])";
        
        mysql_query($query) or die("Помилка ".  mysql_error());
        
//         _addToBases($cu, $db);
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
    
    
    if($customer[role_name] == 'Заказчик'){
       $need_tables = 'customer'; 
    }else{
       $need_tables = 'users'; 
    }
   
   ksort($customer);
   
   $new_customers = array();
    
    foreach ($db as $val) {
      
        if($customer[db_data_id] != $val[db_id]){
        
            mysql_close();
            mysql_connect($val[addr], $val[login], $val[password]);
            mysql_select_db($val[db_name]);
            mysql_query ("SET NAMES $val[charset]");

                
            if(mysql_table_seek($need_tables, $val[db_name])){

                $result = mysql_query("SHOW COLUMNS FROM $need_tables");
                $tmp = array();
                while ($fn = mysql_fetch_assoc($result)){

                    array_push($tmp, $fn[Field]);
                }
                sort($tmp);

                $customer[table] = $need_tables;
                
                if($need_tables == 'users')$customer[role] = getRoleID($customer[role_name]);
                
                unset($customer[role_name]);
                unset($customer[user_id]);
                $normo_customer = adaptingFields($customer, $tmp,$val[db_id]);
                
                array_push($new_customers, $normo_customer);
                
//                _insert($normo_customer,$need_tables);
                
                

            } 
        }
    }
        include '../query/connect.php';
        
//        foreach ($new_customers as $value) {
//             if(_insert($value, 'customer') > 0)$GLOBALS[cu]-1;
//                if($GLOBALS[cu] == 0){
//                    
//                                         ?>
<!--<script type="text/javascript">
    document.location.href = "index.php?act=main";
</script>-->
//<?php
//
//          }
        
//    }

}

function _insert($customer, $tablename){
    $str_filds = '';
    $str_values = "";
    $where = '';
    foreach ($customer as $key => $value) {
        $str_filds .= "$key,";
        $str_values .= "'$value',";
        if($key == 'pwd' OR $key == 'secret_key'){
            $where = "$key = '$value'";
        }
    }
    
    $result = mysql_query("SELECT Count(id) FROM $tablename WHERE $where");
    
    $row = mysql_fetch_row($result);
    
    if($row[0] == 0){
         $str_filds = substr($str_filds, 0, strlen($str_filds)-1);
    $str_values = substr($str_values, 0, strlen($str_values)-1);
    $query = "INSERT INTO `$tablename` ($str_filds) VALUES ($str_values)";
    mysql_query($query);
    }
    
   
    
    return mysql_insert_id();
}

function adaptingFields($customer,$fields,$db_id){
//    echo "<br>USER ->>      ";
//    print_r($customer);
    $equal = array();
    $out_customer = array('db_id'=>$db_id);

    foreach ($fields as $value) {
        if($customer[$value]){
            $out_customer[$value]=$customer[$value];
        }

        foreach ($customer as $key => $var) {
            if(ereg("mail", $value) && ereg("mail", $key)){
                $out_customer[$value]=$var;
            }
        }
   }
   
    unset($out_customer[role_name]);
    unset($out_customer[db_id]);
    unset($out_customer[id]);
    
    return $out_customer;
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
