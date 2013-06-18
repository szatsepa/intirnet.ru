<?php
$sinchronisation = new Sinchronisation();

$tmp_data = $sinchronisation->getData("tmp");

$customer_data = $sinchronisation->getData("customer");

//var_dump($customer_data);

foreach ($customer_data as $value){
    $count = 0;
    foreach ($tmp_data as $tmp_val){
        if($value['email'] == $tmp_val['email'] and ($value['name'] != $tmp_val['name'] or $value['patronymic'] != $tmp_val['patronymic'] or $value['surname'] != $tmp_val['surname'] or $value['phone'] != $tmp_val['phone'])){
            
            echo "{$value['email']}   {$value['name']}  {$value['patronymic']}  {$value['surname']}  {$value['phone']} <br>";
            echo "{$tmp_val['email']} {$tmp_val['name']} {$tmp_val['patronymic']} {$tmp_val['surname']} {$tmp_val['phone']}<br>";
        }
    }
    
    echo "<br>";
}
?>
