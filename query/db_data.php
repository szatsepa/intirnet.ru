<?php
$query = "CREATE TABLE IF NOT EXISTS `tmp_U$_SESSION[id]` (
        `id` int(11) NOT NULL auto_increment,
        `name` varchar(255) character set utf8 collate utf8_bin NOT NULL,
        `surname` varchar(255) character set utf8 collate utf8_bin NOT NULL,
        `patronymic` varchar(255) character set utf8 collate utf8_bin NOT NULL,
        `login` varchar(255) character set utf8 collate utf8_bin NOT NULL,
        `password` varchar(255) character set utf8 collate utf8_bin NOT NULL,
        `phone` varchar(255) character set utf8 collate utf8_bin NOT NULL,
        `email` varchar(255) character set utf8 collate utf8_bin NOT NULL,
        `address` text character set utf8 collate utf8_bin NOT NULL,
        `db_data_id`  int(11) NOT NULL,
        PRIMARY KEY  (`id`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$result = mysql_query($query) or die($query);

if($result){
    $query = "TRUNCATE TABLE `tmp_U$_SESSION[id]`";
    $result = mysql_query($query) or die($query);
}

$query = "SELECT * FROM `db_data`";

$result = mysql_query($query) or die($query);

$db_data = array();

while($var = mysql_fetch_assoc($result)){
    array_push($db_data, $var);
}

mysql_free_result($result);

mysql_close();

$all_users = array();

foreach ($db_data as $value) {
    $link = mysql_connect("$value[addr]","$value[login]","$value[password]") or die ("Ошибка 1");
    mysql_select_db($value[db_name]);
    mysql_query ("SET NAMES $value[charset]");
    
    $query = str_replace('"', '', $value[db_query]);
    
    $result = mysql_query($query) or die("ERROR ".  mysql_error());

    if($result){
        while($var = mysql_fetch_assoc($result)){
            $var[db_data_id] = $value[id];
            array_push($all_users, $var);
        }
    }

    
    mysql_close();
    
}

include 'query/connect.php';

if(count($all_users) > 0){

    
}

foreach ($all_users as $value) {
    $email = '';
    if($value[e_mail]){
        $email = $value[e_mail];
    }else{
        $email = $value[email];
    }
    $pwd = '';
    if($value[pwd]){
        $pwd = $value[pwd];
    }else{
        $pwd = $value[secret_key]; 
    }
    
    $query = "INSERT INTO `tmp_U$_SESSION[id]` (surname,name,patronymic,email,phone,address,password,db_data_id) VALUES ('$value[surname]','$value[name]','$value[patronymic]','$email','$value[phone]','$value[shipping_address]','$pwd',$value[db_data_id])";
    
    
    mysql_query($query);
}
?>
