<?php

// Удаляем cookie


unset($_SESSION['auth']);
unset($_SESSION['id']);
unset($_COOKIE['di']);

session_destroy();

setcookie("di", 'NULL',time()+604800);

//echo "ETO PYZDETS =>> ";
//print_r($_COOKIE);

header ("location:index.php");

?>
