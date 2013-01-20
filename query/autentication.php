<?php
if(!isset($_SESSION)){  

    session_start();  
}

include 'connect.php';

$login = $_POST[login];

$password = $_POST[password];

$out = array('uid'=>NULL);

$query = "SELECT id FROM d_users WHERE login = '$login' AND password = '$password'";

$result = mysql_query($query);

$row = mysql_fetch_assoc($result);

$_SESSION[auth] = 'yes';

$_SESSION[id] = $out['uid'] = $row[id];
    
    
    
if(!$row){
    $query = "SELECT id FROM d_admin WHERE login = '$login' AND password = '$password'";
    
    $result = mysql_query($query);

    if($result){
        
        $row = mysql_fetch_row($result);

        $_SESSION[id] = $out['uid'] = $row[0];

        $_SESSION[auth] = 'yes';

    }
}

$out['query'] = $query;

echo json_encode($out); 

mysql_close();
?>
