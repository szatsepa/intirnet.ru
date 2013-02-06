<?php
$server_query = $_POST[addr];

$new_customer = $_POST;

//print_r($new_customer);
//
//echo "<br>";

$tablename = array('customer','users');

$db_list = allDB();

$mm = 1;

$all_db = array();

foreach ($tablename as $value) {
    foreach ($db_list as $db) {
        $uno_db = $db;
        $uno_db[tablename] = $value;
        array_push($all_db, $uno_db);
    }    
}



foreach ($all_db as $value){
    
    $mm = $mm*(_addDDB($new_customer, $value));
}


//if($mm){}
    
    mysql_query("TRUNCATE TABLE `customer`");
    
    header("location:index.php?$server_query");

function allDB(){
    
    $tmp = array();
    
    $query = "SELECT `db_data_id` AS db_id FROM `customer` GROUP BY `db_data_id`";
    
    $result = mysql_query($query);
    
    while ($var = mysql_fetch_row($result)){
        array_push($tmp, $var);
    }
    
    return $tmp;
}
function getDB($arg){
    
    $result = mysql_query("SELECT * FROM `db_data` WHERE id = $arg");

    $var = mysql_fetch_assoc($result);
    
    $var[tablename]=$tablename;
    
    return $var;
}

function _addDDB($new, $db){
    
        $base = getDB($db[0]);
        
        $base[tablename] = $db[tablename];
    
//        $response = 0;
    
        $charset = $base[charset];
        
        mysql_close();
            
        $link = mysql_connect("$base[addr]","$base[login]","$base[password]")  or die("Could not connect: " . mysql_error());

        mysql_select_db($base[db_name])  or die("Could not select db: " . mysql_error());

        mysql_query ("SET NAMES $charset");
        
        if(mysql_table_seek($base[tablename], $base[db_name])){
            
            if($charset=='cp1251'){
                $new[name] = utf8_to_cp1251($new[name]);
                $new[surname] = utf8_to_cp1251($new[surname]);
                $new[patronymic] = utf8_to_cp1251($new[patronymic]);
            }

            if(mysql_fields_seek($base[tablename], 'e_mail')){
                $mail_c = 'e_mail';
            }else{
                $mail_c = 'email';
            }

            if(mysql_fields_seek($base[tablename], 'secret_key')){
                $password = 'secret_key';
            }else{
                $password = 'pwd';
            } 

            $pwd = getPassword();

            if($base[tablename] == 'customer'){
                $qry = "INSERT INTO `customer` (`name`,`patronymic`,`surname`,`$mail_c`,`phone`, `$password`) VALUES ('$new[name]','$new[patronymic]','$new[surname]','$new[email]','$new[phone]','$pwd')";
            }
            if($base[tablename] == 'users'){
                $qry = "INSERT INTO `users` (`role`,`name`,`patronymic`,`surname`,`$mail_c`,`phone`, `$password`) VALUES (3,'$new[name]','$new[patronymic]','$new[surname]','$new[email]','$new[phone]','$pwd')";
            }           

            $res = mysql_query($qry);
            
            echo "$qry<br>";

            if($res){
                $response = mysql_insert_id();
            }
        
        }
        
        include '../query/connect.php';
        
     return $response;
}

function getPassword(){
    
    $bukoff_arr = array('a','s','d','f','g','h','j','k','l','q','w','e','r','t','y','u','i','o','p','z','x','c','v','b','n','m','Z','X','C','V','B','N','M','A','S','D','F','G','H','J','K','L','Q','W','E','R','T','Y','U','I','O','P');

    $string = '';

    $numr = rand(0, 51);
    
    $str_date = date("Hdmy");

    for($i = 0;$i<4;$i++){

            $num = rand(0, 51);

            $string .= $bukoff_arr[$num];

	}
        
        return "$string-$str_date";
}

function mysql_fields_seek($tablename, $field){
    
    $out = NULL;

    $rslt = mysql_query("SELECT COUNT(`$field`) FROM `$tablename`");
    
    if($rslt)$out = mysql_num_rows($rslt);

    return  $out;
}


function mysql_table_seek($tablename, $dbname){
    
    $rslt = mysql_query("SHOW TABLES FROM `{$dbname}` LIKE '" . mysql_real_escape_string(addCslashes($tablename, "\\%_")) . "';");
    
//    echo "SHOW TABLES FROM `{$dbname}` LIKE '" . mysql_real_escape_string(addCslashes($tablename, "\\%_")) . "';";

    return mysql_num_rows($rslt) > 0;
}
?>
