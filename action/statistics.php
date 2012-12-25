<?php
/*
 * To change this template, choose Tools |19/3/2012
 */
if(!isset($_SESSION)){

    session_start();    
}

include '../query/connect.php';

$out = array('ok' => NULL);

$ip=$_SERVER['REMOTE_ADDR'];

$resolution = $_POST[screen];

$agent = $_SERVER["HTTP_USER_AGENT"];

$query = "INSERT INTO statistics 
                        (ip,
                        resolution,
                        agent)
                VALUES ('$ip',
                        '$resolution',
                        '$agent')";

if(!isset($_SESSION[rem]) or $_SESSION[rem] != 1){
    
    mysql_query($query);

    $ins = mysql_insert_id();

    $_SESSION[rem] = 1;

    $out['ok'] = $ins;
    
    $out["ses"] = $_SESSION[rem];
}


echo json_encode($out);

mysql_close();
?>
