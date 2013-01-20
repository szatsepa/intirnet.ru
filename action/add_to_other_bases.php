<?php
mysql_connect("$_POST[addr]","$_POST[login]","$_POST[password]");
    
mysql_select_db($_POST[db_name]);

mysql_query ("SET NAMES $_POST[charset]");

//$out = array();

$tablename = mysql_table_seek('customer',$_POST[db_name]);

$email = 'email';

$pwd = 'pwd';

$secret_key = secret_key();

if($tablename == 'customer'){
    $email = 'e_mail';
    $pwd = 'secret_key';
    }

$query = "INSERT INTO `$tablename` (name, patronymic,surname, phone, $email, $pwd) VALUES ('$_POST[name]','$_POST[patronymic]','$_POST[surname]','$_POST[phone]','$_POST[email]','$secret_key')";

mysql_query($query);

$uid = mysql_insert_id();

$customer = array('uid'=>$uid,'name'=>$_POST[name],'patronymic'=>$_POST[patronymic],'surname'=>$_POST[surname],'phone'=>$_POST[phone],'email'=>$_POST[email],'password'=>$secret_key);

echo json_encode($customer);

mysql_close();

function mysql_table_seek($tablename, $dbname)
{
    $table_list = mysql_query("SHOW TABLES FROM `".$dbname."`");
    while ($row = mysql_fetch_row($table_list)) {
        if ($tablename==$row[0]) {
            return 'customer';
        }
    }
    return 'users';
} 

function secret_key(){
    
    $bukoff_arr = array('a','s','d','f','g','h','j','k','l','q','w','e','r','t','y','u','i','o','p','z','x','c','v','b','n','m','Z','X','C','V','B','N','M','A','S','D','F','G','H','J','K','L','Q','W','E','R','T','Y','U','I','O','P');

    $string = '';

    $numr = rand(0, 51);

    for($i = 0;$i<4;$i++){

                $num = rand(0, 51);

                $string .= $bukoff_arr[$num];

            }

    $key = $string.'_'.date("ymdh");
    
    return $key;
}
?>
