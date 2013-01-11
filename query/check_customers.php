<?php
$db_tables = array();

$db_sort = array('0'=>'','1'=>'ORDER BY `name`','2'=>'ORDER BY `surname`','3'=>'ORDER BY `role`','4'=>'ORDER BY `creation_time`');

$sort = '';

foreach ($db_data as $value){
    
    $tmp = str_word_count($value[db_query], 1);
    
    array_push($db_tables, $tmp[2]);
}

$new_customers = array();

$query = "SELECT c.id, t.name, t.patronymic, t.surname, t.role, t.email, t.phone, t.password, t.db_data_id FROM `tmp_U1` AS t LEFT JOIN `customer` AS c USING(password) WHERE c.password IS NULL";

$result = mysql_query($query) or die($query);

if($result){
    while($var = mysql_fetch_assoc($result)){

        array_push($new_customers, $var);
    }
}


 mysql_free_result($result);
 

if(count($new_customers)){
    ?>
<script type="text/javascript">
    alert("В сторонних базах зарегистрировались новые клиенты!\n\t\t Таблица будет дополнена!")
</script>
<?php

    foreach ($new_customers as $value) {
        
        $query = "INSERT INTO `customer` (role,surname,name,patronymic,email,phone,password,db_data_id) VALUES ('$value[role]','$value[surname]','$value[name]','$value[patronymic]','$value[email]','$value[phone]','$value[password]',$value[db_data_id])";
        
        mysql_query($query) or die("Помилка ".  mysql_error());
    }
}

$customers = array();

if(isset($attributes[sort])){
    $sort = $db_sort[intval($attributes[sort])];
}

$query = "SELECT * FROM `customer` $sort";

$result = mysql_query($query) or die($query);

if(mysql_numrows($result)!=0){
    while ($var = mysql_fetch_assoc($result)){
        array_push($customers, $var);
    }
}

mysql_free_result($result);
?>
