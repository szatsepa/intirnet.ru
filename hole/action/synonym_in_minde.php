<?php
 header('Content-Type: text/html; charset=utf-8');

include 'connect.php';

$output = array('query'=>'');

$output['fields'] = $_POST;

$count_fields = 0;

foreach ($_POST['fields'] as $key => $value) {

     $query1 = "UPDATE `synonims` SET `synonim` = '$value' WHERE `did` = '{$_POST['db_id']}' AND `tablename` = '{$_POST['tablename']}' AND `fieldname` = '{$key}'";  
         
     mysql_query($query1);
     
     if(mysql_affected_rows()== 0){
         
         if(isset($_POST['edit'])){   }else{ }

                $query = "INSERT INTO `synonims` (`did`, `tablename`, `fieldname`, `synonim`) VALUES ({$_POST['db_id']},'{$_POST['tablename']}','{$key}','{$value}')";
             
        
               if($value !== '0') mysql_query($query);

                $count_fields += mysql_affected_rows();

                if(mysql_affected_rows()==0) $output['error'] = mysql_errno();
             }
}

$output['string'] = $query1;

$output['query'] = $count_fields;

echo json_encode($output);

mysql_close();
?>
