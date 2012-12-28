<?php
// Проверка аутентификации


if (isset($_SESSION['auth']) and !isset($attributes[out])) {   
    // To do переделать пользователя в объект (ООП)
    $user = query_user($_SESSION['id']);
   
	
} else if(isset ($attributes[act])){
    
    unset($attributes[act]);
    header("location:index.php");

}

?>

