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
        _insertNewPersons($new_customers);
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

function _insertNewPersons($arr){
    
    foreach ($arr as $value) {
        
        $query = "INSERT INTO `customer` (user_id,role,surname,name,patronymic,email,phone,tablename,db_data_id) VALUES ($value[user_id],'$value[role]','$value[surname]','$value[name]','$value[patronymic]','$value[email]','$value[phone]','$value[tablename]',$value[db_data_id])";
        
        mysql_query($query) or die("Помилка ".  mysql_error());
    }
    
    return NULL;
}
?>
