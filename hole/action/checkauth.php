<?php
// Проверка аутентификации


if (isset($_SESSION['id']) and $attributes['act'] != 'logout') {   
    // To do переделать пользователя в объект (ООП)
    $user = query_user($_SESSION['id']);
    $_SESSION['auth'] = 1;
}

if(!isset($_SESSION['id']) and isset($attributes['act'])){
    
    unset($attributes['act']);
    header("location:index.php");

}

if(isset($_SESSION['id']) and !isset($attributes['act'])){
    
//    unset($attributes[act]);
    header("location:index.php?act=main");

}
?>

