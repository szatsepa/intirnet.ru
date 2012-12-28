<?php

// Удаляем cookie
setcookie("di", $attributes[auth], time()-1200);

unset($_SESSION['auth']);
unset($_SESSION['id']);

session_destroy();

header ("location:index.php?out=1");

?>
