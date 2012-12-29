<?php
//$query = "SELECT `db_query` FROM `db_data`";
//
//$result = mysql_query($query) or die($query);

$db_tables = array();

//while($var = mysql_fetch_assoc($result)){
//    $tmp = str_word_count($var[db_query], 1);
//    array_push($db_tables, $tmp[2]);
//}

foreach ($db_data as $value){
    
    $tmp = str_word_count($value[db_query], 1);
    
    array_push($db_tables, $tmp[2]);
}

$new_customers = array();

$query = "SELECT c.id, t.name, t.patronymic, t.surname, t.email, t.phone, t.password FROM `tmp_U1` AS t LEFT JOIN `customer` AS c USING(password) WHERE c.password IS NULL";

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
    alert("В стороних базах зарегистрировались новые клиенты!\n\t\t Таблица будет дополнена!")
</script>
<?php

    foreach ($new_customers as $value) {
        
        $query = "INSERT INTO `customer` (surname,name,patronymic,email,phone,password) VALUES ('$value[surname]','$value[name]','$value[patronymic]','$value[email]','$value[phone]','$value[password]')";
        
        mysql_query($query) or die("Помилка ".  mysql_error());
    }
}
?>
