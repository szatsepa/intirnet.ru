<?php
//header('Content-type: text/html; charset=utf-8');
$and = '';

if(isset($attributes['db_id'])){
    $and = " AND id = {$attributes['db_id']}";
}

$query = "SELECT * FROM `db_data` WHERE `status` <> 0 $and";

$result = mysql_query($query) or die(mysql_errno());

$dbases = '';

while ($row = mysql_fetch_assoc($result)){
    
    $dbases .= getDbdata($row);
}

mysql_free_result($result);


function getDbdata($rows){
     //строка с POST данными
    $data = '';

    foreach ($rows as $key => $value){
        $data .= "&$key=$value";
    }

   //задаем контекст
    $context = stream_context_create(
    array(
            'http'=>array(
                            'header' => "User-Agent: Brauzer 2/0\r\nConnection: Close\r\n\r\n",
                            'method' => 'POST',
                            'content' => $data                
                         )
        )
    );

    $contents = file_get_contents("http://{$rows['inet_address']}/hole/hole.php", false ,$context);
    
    return $contents;
}

$tables_fields = get_object_vars(json_decode($dbases));

?>