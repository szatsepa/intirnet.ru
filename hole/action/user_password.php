<?php
include '../config.php'; include '../query/connect.php';

$email = $_POST[email];

$out = array('ok' => NULL);

$query = "SELECT pwd, name, surname FROM users WHERE email = '$email'";

$result = mysql_query($query);

$num_rows = mysql_numrows($result);

if($num_rows != 0){
    
    $row = mysql_fetch_assoc($result);
    
    $message ="Здравствуйте $row[surname] $row[name]!  Ваш индивидуальный ключ - $row[pwd].\n C уважением. Администрация intirnet.ru. \n";              

    $headers = 'From: administrator@'. $_SERVER[SERVER_NAME]. "\r\n";

    $headers  .= 'MIME-Version: 1.0' . "\r\n";

    $headers .= 'Content-type: text/plain; charset=utf-8' . "\r\n";

    $out['ok'] = mail($email,"Ключ доступа к $_SERVER[SERVER_NAME]",$message, $headers);

//    $out['message'] = "$email,$message, $headers";
    
    $out[psw] = $row[pwd];
}

echo json_encode($out);

mysql_close();
?>
