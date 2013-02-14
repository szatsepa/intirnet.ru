<?php 
header('Content-Type: text/html; charset=utf-8'); 
echo '<?xml version="1.0" encoding="utf8"?>'; 

$roles = checkRoles();
$str_role = 0;
if(isset($attributes[r]))$str_role = intval($attributes[r]);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">

<head>
<!--    <meta http-equiv="Last-Modified" value="<?php echo date("r",(time() - 60));?>" />-->
    <meta name='yandex-verification' content='4a8d7fbb2bcbbdce' />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <?php   $title_header = $title;?>
    <title>INTER - salat <?php echo $title_header; ?></title>
    <meta http-equiv="content-language" content="ru" />
    <meta name="robots" content="noindex,nofollow" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="css/reset.css" />  <!-- RESET -->
    <link rel="stylesheet" media="screen,projection" type="text/css" href="css/main.css" /> <!-- MAIN STYLE SHEET -->
   <link rel="stylesheet" media="screen,projection" type="text/css" href="css/2col.css" title="2col" /><!--  DEFAULT: 2 COLUMNS -->
    <link rel="alternate stylesheet" media="screen,projection" type="text/css" href="css/1col.css" title="1col" /> <!--  ALTERNATE: 1 COLUMN -->
    <!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="css/main-ie6.css" /><![endif]--> <!-- MSIE6 -->
    <link rel="stylesheet" media="screen,projection" type="text/css" href="css/style.css" /> <!-- GRAPHIC THEME -->
    <link rel="stylesheet" media="screen,projection" type="text/css" href="css/mystyle.css" /> <!-- WRITE YOUR CSS CODE HERE -->
<!--    <script type="text/javascript" src="js/jquery-1.8b1.js"></script>-->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script type="text/javascript" src=" http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script> 
    <script type="text/javascript" src="js/header.js"></script>
    <script type="text/javascript" src="js/myfunction.js"></script>
    <script type="text/javascript" src="js/main_menu.js"></script>
    <script type="text/javascript" src="js/<?php echo $attributes[act];?>.js"></script>    
</head>
