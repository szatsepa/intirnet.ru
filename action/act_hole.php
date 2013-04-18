<?php
header('Content-type: text/html; charset=utf-8');

$query = '';

foreach ($_POST as $key => $value){
    $query .= "$key=$value&";
}

$query = substr($query, 0, (strlen($query)-1));

$somepage = file_get_contents("http://{$_POST['db_host']}/hole/hole.php?$query");

echo $somepage;
?>
