<?php
if(!isset($_SESSION)){

    session_start();    
}

include '../query/connect.php';

$out = array('ok'=>NULL,'check'=>$_POST['minde']);

$code = md5($_POST['code']);

$query = "SELECT id 
    FROM users
    WHERE pwd='$code'";

$qry_userauth = mysql_query($query) or die($query);

$num_rows = mysql_num_rows($qry_userauth);

if ($num_rows == 1) {
    $id = mysql_result($qry_userauth,0);
    
        $_SESSION['auth'] = 1;
	$_SESSION['id']   = $id;
	$out['ok']        = 1;
}


$out['ok'] = 1;

echo json_encode($out);

mysql_close();
?>
