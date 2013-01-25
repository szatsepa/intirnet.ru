<?php

function checkBases(){
    mysql_query("DROP TABLE IF EXISTS `tmp`");

    $query = "CREATE TABLE IF NOT EXISTS `tmp` (
            `id` int(11) NOT NULL auto_increment,
            `user_id`  int(11) NOT NULL,
            `name` varchar(255) character set utf8 collate utf8_bin NOT NULL,
            `surname` varchar(255) character set utf8 collate utf8_bin NOT NULL,
            `patronymic` varchar(255) character set utf8 collate utf8_bin NOT NULL,
            `role` varchar(255) character set utf8 collate utf8_bin NOT NULL,
            `phone` varchar(255) character set utf8 collate utf8_bin NOT NULL,
            `email` varchar(255) character set utf8 collate utf8_bin NOT NULL,
            `tablename` varchar(255) character set utf8 collate utf8_bin NOT NULL,
            `db_data_id`  int(11) NOT NULL,
            PRIMARY KEY  (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

    $result = mysql_query($query) or die($query);

    $query = "SELECT `id` AS db_id, `db_name`, `login`, `password`, `addr`, `charset` FROM `db_data`";

    $result = mysql_query($query) or die($query);

    $odb_tables = array();

    while($var = mysql_fetch_assoc($result)){
        array_push($odb_tables, $var);
    }

    mysql_free_result($result);

    mysql_close();

    $persons_on_tmp = array();

    // получаем список таблиц в бд если есть таблицы customer or users забиваем в массив

    foreach ($odb_tables as $value) {

        mysql_connect("$value[addr]","$value[login]","$value[password]") or die ("Ошибка 1");

        mysql_select_db($value[db_name]);

        mysql_query ("SET NAMES $value[charset]");

        $table_list = mysql_query("SHOW TABLES");

        while($var = mysql_fetch_assoc($table_list)){
            if(($var['Tables_in_'.$value[db_name]]) === 'customer' OR ($var['Tables_in_'.$value[db_name]]) === 'users'){

                $tablename =   $var['Tables_in_'.$value[db_name]];

                $tmp = array_merge($persons_on_tmp, _personsData($tablename,$value));

                $persons_on_tmp = $tmp;

            }
        }

    mysql_close();

    }


    include '../query/connect.php';
}
?>
