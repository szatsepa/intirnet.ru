<?php
//kласс обрабатываеt входящие данные ресурсов доноров

class Hole {

    var  $donorsData = array();

    var  $donorsUsers = array();
   
    function __construct() {
        
    }
    
    public function Customers(){
        
        $response = FALSE;
        
        $affected = 0;
//        проверяем комлектность таблиц бд запись таблиц и синонимов
        $this->nocomplete();
//        получаем список активных доноров 
        $this->donorsData = $this->getDBData(NULL);
//        получим список клиентов баз доноров
        $this->donorsUsers = $this->getDBcomplete();
//        очистим таблицу тмп
        if($this->_clearTMP()){
//            запишем всех клиентов баз доноров в таблицу тмп
            $this->_setTMP($this->donorsUsers);
//            проверим наличие новых клиентов в базах донорах
            $customers = $this->checkCustomer();
//            проверим не изменились ли данные клиентов в админке нашего ресурса
            $addcustomers = $this->checkTMP();
//            если нечто изменилось добавляем клиентов в таблицу кустомер
            if($customers['count'] > 0){
                foreach ($customers['new'] as $value) {
                   $affected = $this->insertNewCustomers ($value);
                }
            }
            
            if($addcustomers['count'] > 0){
                foreach ($addcustomers['new'] as $value) {
                   $affected = $this->insertNewCustomers ($value);
                }
            }
            
            if($affected > 0) $response = TRUE;
        }
        
        return $response;
    }
    
//    public function _showtables($data){
//        
//        $host = $data['db_host'];
//        
//        $db_name = $data['db_name'];
//        
//        $charset = $data['db_charset'];
//        
//        $server = $data['db_server'];
//        
//        $login = $data['db_login'];
//        
//        $pwd = $data['db_pwd'];
//        
//        $out = array('inet_address'=>$host,'db_name'=>$db_name,'addr'=>$server,'login'=>$login,'password'=>$pwd,'charset'=>$charset);
//        
//        var_dump($out);
//        
//        echo "<br>";
//        
//        return $this->_getHole($out);
//        
//    }
    
    function getDBData($id){       
        
        $and = '';
        
        if($id){
           $and = " AND db.`id` = {$id} ORDER BY db.`id`"; 
        }else{
           $and = " ORDER BY db.`id`"; 
        }
        
        $query = "SELECT db.`id`, db.`db_name`, db.`login`, db.`password`, db.`addr`, db.`charset`, db.`inet_name`, db.`inet_address` 
                    FROM `db_data` AS db 
                    WHERE db.`status` <> 0 {$and}"; 
                    
//        echo "$query";
        
        return $this->_getData($query);
        
    }
    
    private function getDBcomplete(){
        
        $query = "SELECT db.`id`, db.`db_name`, db.`login`, db.`password`, db.`addr`, db.`charset`, db.`inet_name`, db.`inet_address`, t.`db_table` AS tablename, t.`id` AS tid 
                    FROM `db_data` AS db, `db_tables` AS t 
                    WHERE db.`status` <> 0 AND
                          db.`id` = t.`db_id` AND 
                          db.`complete` = 1";
        
        $dU = $this->_prepareUsers($this->_getData($query), $this->getSynonims());
        
        return $dU;
    }
    
    private function _getData($query){
        
        $array = array();
        
        $result = mysql_query($query) or die(mysql_errno());

        $dbases = '';

        $tmp = array();
        
        $flag = NULL;

        while ($row = mysql_fetch_assoc($result)){
                        
            $hole_str = $this->_getHole($row);
            
            if(isset($row['tid'])){
                $flag = 1;
            }
                                
            $tmp = get_object_vars(json_decode($hole_str,FALSE));
            
            if($tmp){

                $fkey = key($tmp);

                if(!array_key_exists('tablename', $row)){

                   $array[$fkey] = $tmp[$fkey];

                }else{

            
                    $tmpu = get_object_vars($tmp[$fkey]);
                    $skey = key($tmpu);
                    $array[$fkey.'_T_'.$skey]=$tmpu[$skey];

                }

            }

         }

        mysql_free_result($result);
        
        return $array;
    }
    
    private function _prepareUsers($users,$synonym){
    
        $tmp = array();

        foreach ($users as $key => $value) {

            $dtmp = explode('_T_', $key);

            $tmp[$dtmp[0]][$dtmp[1]] = array();

            foreach ($value as $val) {

                array_push($tmp[$dtmp[0]][$dtmp[1]], $this->checkFields(get_object_vars($val), $synonym));
            }
        }
        
        return $tmp;
    }
    
    private function checkFields($uarr,$sarr){
    
        $tmp = array();

        foreach ($sarr as $bkey => $bvalue) {

            foreach ($bvalue as $tkey => $tvalue) {

                foreach ($tvalue as $key => $value) {

                    foreach ($uarr as $okey => $oval) {

                       $new_key = key($value);

                       if($new_key == $okey){

                           $tmp[$value[$new_key]] = $oval;
                       }                   
                    }

                }
            }
        }
        return $tmp;
    }

    private function _getHole($rows){
        
        $data = '';
        
        $path = $rows['inet_address'];
        
        unset($rows['inet_address']);

        foreach ($rows as $key => $value){
            $data .= "&$key=$value";
        }
//        echo "$data<br>";
       //задаем контекст
        $context = stream_context_create(
        array(
                'http'=>array(
                                'header' => "User-Agent: Brauzer 2/0\r\nConnection: Close\r\n\r\n",
                                'method' => 'POST',
                                'content' => $data                
                             )
            )
        );

        $contents = file_get_contents("http://$path/hole/hole.php", false ,$context);

        return $contents;
    }
    
    private function _clearTMP(){
    
        return mysql_query("TRUNCATE TABLE `tmp`");
        
    }
    
    private function getSynonims(){

        $query = "SELECT `db_name` FROM `db_data` WHERE `status` <> 0";

        $result = mysql_query($query);

        $synonyms = array();

        while ($row = mysql_fetch_row($result)){

            $synonyms[$row[0]] = array();

            $rest = mysql_query("SELECT f.`tablename` FROM `table_fields` AS f WHERE f.`db_id` = (SELECT id FROM `db_data` WHERE `db_name` = '{$row[0]}') GROUP BY f.`tablename`");

            while ($srow = mysql_fetch_assoc($rest)){

                $synonyms[$row[0]][$srow['tablename']] = array();
                
                $qru = "SELECT f.`field_name` AS synonim, 
                               s.`fieldname` AS field 
                         FROM `table_fields` AS f 
                         LEFT JOIN synonims AS s 
                         ON f.`field_name` = s.synonim 
                         WHERE  f.`tablename` = '{$srow['tablename']}' AND 
                                f.`db_id` = (SELECT id FROM `db_data` WHERE `db_name` = '{$row[0]}') AND 
                                s.`fieldname` IS NOT NULL";
                                
                $resu = mysql_query($qru);
                
                while ($frow = mysql_fetch_assoc($resu)){

                    array_push($synonyms[$row[0]][$srow['tablename']], array($frow["synonim"]=>$frow['field']));
                }

                mysql_free_result($resu);
            }

            mysql_free_result($rest);
        }

        mysql_free_result($result);

        return $synonyms;

    }
    
    
    private function _setTMP($customers){
        
        foreach ($customers as $key => $value){
            foreach ($value as $val) {
                foreach ($val as $var) {
                    $tmp = $var;
                    $tmp['dbn']=$key;
                      $aff = $this->_insertTmp($this->_buildQuery($tmp));
                }
            }
            
            
        } 

        return;
    }

    private function _insertTmp($query){
        
        mysql_query($query);
        
        return;

    }

    private function _buildQuery($arr){

        $fields = $values ='';
        
        foreach ($arr as $key => $value) {
            $fields .= "`$key`,";
            
            $values .= "'$value',";          
            
        }
        
        $fields = substr($fields, 0, strlen($fields)-1);
        
        $values = substr($values, 0, strlen($values)-1);
        
        return "INSERT INTO `tmp` ($fields) VALUES ($values)";
    }
    
    private function checkCustomer(){
    
        $query = "SELECT c.`id`, t.`login`, t.`email`, t.`password`,t.`firstname`, t.`lastname` 
                    FROM `tmp` t 
                    LEFT JOIN `customer` c 
                    ON (t.`email`= c.`email`) 
                    WHERE c.`id` IS NULL AND t.`email` <> ''
                    GROUP BY t.`email`";

        $result = mysql_query($query);

        $customers = array();
        
        if(!$result){
            return NULL;
        } 
        
        while ($row = mysql_fetch_assoc($result)){
            unset($row['id']);
            array_push($customers, $row);
        }

        return array('count'=>  count($customers),'new'=>$customers);
    }
    
    private function checkTMP(){
        
        $query = "SELECT t.`id` as tmpid, c.`login`, c.`email`, c.`password`,t.`firstname`, t.`lastname` 
                    FROM `customer` c
                    LEFT JOIN  `tmp` t 
                    ON (c.`email`= t.`email`)
                    WHERE t.`id` IS NULL AND t.`email` <> ''
                    GROUP BY t.`email`";
        
        $result = mysql_query($query);

        $customers = array();
        
        if(!$result){
            return NULL;
        }

        while ($row = mysql_fetch_assoc($result)){
            unset($row['id']);
            array_push($customers, $row);
        }
        
        return array('count'=>  count($customers),'new'=>$customers);
    }

    private function insertNewCustomers($arr){
    
        $query = "INSERT INTO `customer` ";

        $fields = $data = "(";

        foreach ($arr as $key => $value) {

            $fields .= "`$key`,";

            $data .= "'$value',";
        }

        $fields = substr($fields, 0, strlen($fields)-1).")";

        $data = substr($data, 0, strlen($data)-1).")";

        $query .= $fields." VALUES ".$data;
        
        $count = 0;
        
        $result = mysql_query("SELECT COUNT(`id`) FROM `customer` WHERE `email` = {$arr['email']}");
        
        if($result) $count = mysql_result($result, 0);
        
        if($count === 0){
            mysql_query($query);
            
        }        
        
        return mysql_affected_rows();
    }
    
    private function nocomplete(){
        
        mysql_query("UPDATE `db_data` SET `complete` = 0");
        
        $query = "SELECT id FROM db_data WHERE status = 1";
        
        $result = mysql_query($query);
                
        while ($row = mysql_fetch_assoc($result)){
            
            $nu_sho = $this->isTables($row['id']);
            
//            echo "$nu_sho<br>";
           
           if($nu_sho !== 0){
               
//               echo "UPDATE `db_data` SET `complete` = 1 WHERE `id` = {$row['id']}<br>";
               
               mysql_query("UPDATE `db_data` SET `complete` = 1 WHERE `id` = {$row['id']}");
           }
           
        }
        
        return;
    }
    
    private function isTables($id){
        
        $out = 0;
        
        $query = "SELECT db_table FROM db_tables WHERE db_id = $id";
        
        $result = mysql_query($query);
        
        $rows = mysql_numrows($result);
        
        $n = 0;
        
        while ($row = mysql_fetch_assoc($result)){
            
           if($this->isFields($id, $row['db_table'])) $n++;
        }
        
        if($rows == $n){
            
            $out = 1;
        }
        
        return $out;
    }
    
    private function isFields($did,$table){
        
        $output = NULL;
        
        $query = "SELECT f.db_id FROM table_fields f LEFT JOIN synonims s ON f.field_name = s.synonim 
                            WHERE f.db_id = $did 
                                 AND f.db_id = s.did 
                                 AND f.tablename = '$table'
                                 AND f.tablename = s.tablename
                                 GROUP BY f.db_id";
        
        $result = mysql_query($query);
        
        while ($row = mysql_fetch_assoc($result)){
            
            $output = $row['db_id'];
        }
//        echo "$query<br>$did -> $table -> $output<br>";
        return $output;
    }
}
?>