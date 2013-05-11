<?php
//_clearTMP();

$synonyms = readSynonims();

$users = changeFields($users_array, $synonyms);

function changeFields($users,$synonym){
    
    $tmp = array();
    
    foreach ($users as $key => $value) {
        
        $dtmp = explode('_T_', $key);
        
        $tmp[$dtmp[0]][$dtmp[1]] = array();
        
        foreach ($value as $key => $val) {
            
            array_push($tmp[$dtmp[0]][$dtmp[1]], checkFields(get_object_vars($val), $synonym));
//             checkFields(get_object_vars($val), $synonym);
        }
    }
    
    return $tmp;
}

function checkFields($uarr,$sarr){
    
    $tmp = array();
    
    foreach ($sarr as $bkey => $bvalue) {
        
        foreach ($bvalue as $tkey => $tvalue) {
            
            foreach ($tvalue as $key => $value) {
                
                foreach ($uarr as $okey => $oval) {
                    
                   $new_key = key($value);
                   
                   if($new_key == $okey){
                       
                       $tmp[$new_key] = $oval;
                   }                   
                }
                
            }
        }
    }
    return $tmp;
}

function readSynonims(){
    
    $query = "SELECT `db_name` FROM `db_data` WHERE `status` <> 0";

    $result = mysql_query($query);

    $synonyms = array();

    while ($row = mysql_fetch_row($result)){

        $synonyms[$row[0]] = array();

        $rest = mysql_query("SELECT f.`tablename`FROM `table_fields` AS f WHERE f.`this_name` <> '' AND f.`db_id` = (SELECT id FROM `db_data` WHERE `db_name` = '{$row[0]}') GROUP BY f.`tablename`");

        while ($srow = mysql_fetch_assoc($rest)){

            $synonyms[$row[0]][$srow['tablename']] = array();

            $resu = mysql_query("SELECT f.`field_name`, f.`this_name` FROM `table_fields` AS f WHERE f.`this_name` <> '' AND f.`tablename` = '{$srow['tablename']}' AND f.`db_id` = (SELECT id FROM `db_data` WHERE `db_name` = '{$row[0]}')");

            while ($frow = mysql_fetch_assoc($resu)){
                
                array_push($synonyms[$row[0]][$srow['tablename']], array($frow["field_name"]=>$frow['this_name']));
            }
            
            mysql_free_result($resu);
        }
        
        mysql_free_result($rest);
    }
    
    mysql_free_result($result);
    
    return $synonyms;
    
}

function _clearTMP(){
//    
//    mysql_query("CREATE TABLE IF NOT EXISTS `tmp` (
//        `id` int(11) NOT NULL auto_increment,
//        `user_id`  int(11) NOT NULL,
//        `surname` varchar(255) character set utf8 collate utf8_bin NOT NULL,
//        `name` varchar(255) character set utf8 collate utf8_bin NOT NULL,        
//        `patronymic` varchar(255) character set utf8 collate utf8_bin NOT NULL,
//        `role` varchar(255) character set utf8 collate utf8_bin NOT NULL,
//        `phone` varchar(255) character set utf8 collate utf8_bin NOT NULL,
//        `email` varchar(255) character set utf8 collate utf8_bin NOT NULL,
//        `tablename` varchar(255) character set utf8 collate utf8_bin NOT NULL,
//        `db_data_id`  int(11) NOT NULL,
//        PRIMARY KEY  (`id`)
//        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");


    mysql_query("TRUNCATE TABLE `tmp`");
}    

var_dump($users);
?>
