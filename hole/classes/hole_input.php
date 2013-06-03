<?php
//header('Content-type: text/html; charset=utf-8');

class Hole {

    var  $donorsData = array();

    var  $donorsUsers = array();
   
    function __construct() {
        
        $this->notComplite();
        
        $this->donorsData = $this->getDBData(NULL);
        
        $this->donorsUsers = $this->getDBComplite();
        
        if($this->_clearTMP()){
            
            $this->_setTMP($this->donorsUsers);
            
            $customers = $this->checkCustomer();
            
            $addcustomers = $this->checkTMP();
            
//            var_dump($customers);
            
            if($customers['count'] > 0){
                foreach ($customers['new'] as $value) {
                    $this->insertNewCustomers ($value);
                }
            }
            
            if($addcustomers['count'] > 0){
                foreach ($addcustomers['new'] as $value) {
                    $this->insertNewCustomers ($value);
                }
            }
            
        }
    }
    
    function getDBData($id){       
        
        $and = '';
        
        if($id){
           $and = " AND db.`id` = {$id}"; 
        }
        
        $query = "SELECT db.`id`, db.`db_name`, db.`login`, db.`password`, db.`addr`, db.`charset`, db.`inet_name`, db.`inet_address` 
                    FROM `db_data` AS db 
                    WHERE db.`status` <> 0 {$and}";           
        
        return $this->_getData($query);
        
    }
    
    private function getDBComplite(){
        
        $query = "SELECT db.`id`, db.`db_name`, db.`login`, db.`password`, db.`addr`, db.`charset`, db.`inet_name`, db.`inet_address`, t.`db_table` AS tablename, t.`id` AS tid 
                    FROM `db_data` AS db, `db_tables` AS t 
                    WHERE db.`status` <> 0 AND
                          db.`id` = t.`db_id` AND 
                          db.`complite` = 1";
        
        return $this->_prepareUsers($this->_getData($query), $this->getSynonims());
    }
    
    private function _getData($query){
        
        $array = array();
        
        $result = mysql_query($query) or die(mysql_errno());

        $dbases = '';

        $tmp = array();

        while ($row = mysql_fetch_assoc($result)){


            $tmp = get_object_vars(json_decode($this->_getHole($row),FALSE));
            
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

            foreach ($value as $key => $val) {

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

        foreach ($rows as $key => $value){
            $data .= "&$key=$value";
        }

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

        $contents = file_get_contents("http://{$rows['inet_address']}/hole/hole.php", false ,$context);

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
    
    
    private function _setTMP($customers){
        
        foreach ($customers as $value){
           
            foreach ($value as $val) {
                
                foreach ($val as $var) {
                      $aff = $this->_insertTmp($this->_buildQuery($var));
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
            if($key == 'password'){
                $values .= "'".md5($value)."',";
            }  else {
                $values .= "'$value',";
            }
            
        }
        
        $fields = substr($fields, 0, strlen($fields)-1);
        
        $values = substr($values, 0, strlen($values)-1);
        
        
        return "INSERT INTO `tmp` ($fields) VALUES ($values)";
    }
    
    private function checkCustomer(){
    
        $query = "SELECT c.`id`, t.`surname`, t.`name`, t.`patronymic`, t.`role`, t.`phone`, t.`email`, t.`password` 
                    FROM `tmp` t 
                    LEFT JOIN `customer` c 
                    ON (t.`email`= c.`email`) 
                    WHERE c.`id` IS NULL
                    GROUP BY t.`email`";

        $result = mysql_query($query);

        $customers = array();

        while ($row = mysql_fetch_assoc($result)){
            unset($row['id']);
            array_push($customers, $row);
        }
        
        return array('count'=>  count($customers),'new'=>$customers);
    }
    
    private function checkTMP(){
        
        $query = "SELECT t.`id` as tmpid, c.`surname`, c.`name`, c.`patronymic`, c.`role`, c.`phone`, c.`email`, c.`password` 
                    FROM `customer` c
                    LEFT JOIN  `tmp` t 
                    ON (c.`email`= t.`email`)
                    WHERE t.`id` IS NULL 
                    GROUP BY t.`email`";
        
        $result = mysql_query($query);

        $customers = array();

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
        
        $result = mysql_query("SELECT COUNT(`id`) FROM `customer` WHERE `email` = {$arr['email']}");
        
        $count = mysql_result($result, 0);
        
        if($count > 0){
            mysql_query($query);
        }        
        
        return;
    }
    private function notComplite(){
        
        $query = "SELECT db.id, db.db_name, t.db_table, f.field_name 
                    FROM `db_data` as db 
                    LEFT JOIN   `db_tables` t ON db.id = t.db_id  
                    LEFT JOIN table_fields f ON t.db_table = f.tablename 
                    WHERE f.field_name IS NULL";
        
        $result = mysql_query($query);
        
        while ($row = mysql_fetch_assoc($result)){
            
            mysql_query("UPDATE `db_data` SET `complite` = 0 WHERE `id` = {$row['id']}");
        }
        
        return;
    }
    
}
?>