<?php
header('Content-type: text/html; charset=utf-8');

$query = '';

foreach ($_POST as $key => $value){
    $query .= "$key=$value&";
}

//строка с POST данными
$data = substr($query, 0, (strlen($query)-1));
//
//$somepage = file_get_contents("http://{$_POST['db_host']}/hole/hole.php?$query");
//
//echo $somepage;

/*
*POST запрос при помощи file_get_contents
*автор: nc_soft
*29.08.07
*/
 
/*задать необходимые заголовки можно в массиве http, для примера посланы 2 заголовка
User-Agent и Connection
*/
 
//строка с POST данными
//$data='a=1&b=2';
 
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
 
$contents = file_get_contents("http://{$_POST['db_host']}/hole/hole.php", false ,$context);

echo $contents;
?>