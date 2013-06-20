<?php
class IntirnetDb{
    
    var $complete_DB = array();
    
    function __construct(){
        
        $this->complete_DB = $this->allDB();
    }
    
    function allDB(){
    
        $tmp = array('all' => array());

        $query = "SELECT db.`inet_address`, db.`id`, db.`db_name`, db.`login`, db.`password`, db.`addr`, db.`charset`, t.`db_table` AS tablename 
                    FROM `db_data` db, `db_tables` t 
                    WHERE db.`id` = t.`db_id` AND
                    db.`status` <> 0 AND 
                    db.`complete` <> 0";

        $result = mysql_query($query);

        while ($row = mysql_fetch_assoc($result)){

            $tmp[$row['db_name'].'_T_'.$row['tablename']] = $this->getSynonym($row);

            array_push($tmp['all'], $tmp[$row['db_name'].'_T_'.$row['tablename']]);
        }

        return $tmp['all'];
    }
    
    private function getSynonym($array){
    
        $tmp = array();

        $query = "SELECT f.`field_name`, s.`fieldname` AS synonim
                    FROM `table_fields` f, `synonims` s
                    WHERE f.`db_id` = s.`did` AND 
                    f.`tablename` = s.`tablename` AND 
                    f.`field_name` = s.`synonim` AND 
                    f.`db_id` = {$array['id']} AND 
                    s.`tablename` = '{$array['tablename']}'";

        $result = mysql_query($query);

        while ($row = mysql_fetch_assoc($result)){
            array_push($tmp, array_merge($array,$row));
        }

        return $tmp;
    }
}

class Prepare{
    
    function  __construct(){
        
    }
            
    function prepareData($array){
    
        foreach ($array as $value) {
            
            if(count($value)===0)                break;

            $db_data = '';

            $tmp = $value[0];

            $path = $tmp['inet_address'];
            
            unset($tmp['inet_address']);
            
            unset($tmp ["field_name"]);
            
            unset($tmp["synonim"]);

            foreach ($tmp as $key => $var) {
                $db_data .= "&".trim($key)."=".trim($var);
            }

            $fields = '';

            foreach ($value as $key => $val) {
                $fields .= "`{$val['synonim']}`,";
            }

            $fields = substr($fields, 0, strlen($fields)-1);

            $query = "SELECT $fields 
                    FROM `customer`";

            $result = mysql_query($query);
            
            $tmp_customer = array();

            while ($row = mysql_fetch_assoc($result)){

                foreach ($value as $var) {
                    
                    $tmp_customer[$var['field_name']] = $row[$var['synonim']];
                }
                
                $customer_data = json_encode($tmp_customer);
//
                $out = $this->setDbdata($path, $db_data, $customer_data,NULL);
                
            }
        }

        return;
    }
    
    function addCustomer($array,$customer,$update){
        
        $output = NULL;
        
        $value = array_shift($array);

        $db_data = '';

        $tmp = $value[0];

        $path = $tmp['inet_address'];

        for($i=0;$i<2;$i++){
            array_pop($tmp);            
        }

        array_shift($tmp);

        foreach ($tmp as $key => $var) {
            $db_data .= "&".trim($key)."=".trim($var);
        }

        $fields = '';

        foreach ($value as $key => $val) {
            $fields .= "`{$val['synonim']}`,";
        }

        $fields = substr($fields, 0, strlen($fields)-1);

        $customer_data = $this->_customerString($customer); 



        foreach ($value as $var) {

            $customer_data = str_replace($var['synonim'], $var['field_name'], $customer_data);
        } 

        $tmpc = json_decode($customer_data);

        $ctmp = array();

        foreach ($tmpc as $key => $cd) {
            foreach ($value as $var){
                if($key == $var['field_name']){
                    $ctmp[$key] = $cd;
                }
            }
        }
        
        $_customer = json_encode($ctmp);
        
        if($update == 1){
          $_customer .=  "&upd=1";
        }
        
        $output = $this->setDbdata($path, $db_data, $_customer,NULL);

        return $output;
    
    }
    
    function delCustomer($array,$email){
        
        $output = NULL;
        
        $path = $field = '';
        
        foreach ($array as $value) {
            
            foreach ($value as $var) {
                
                if(array_search('email', $var)){
                    
                    $tmp = $var;
                    
                    $path = array_shift($tmp);
                    
                    array_pop($tmp);
                    
                    array_shift($tmp);
                    
                    $output_str = '';
                    
                    foreach ($tmp as $key => $val) {
                        $output_str .= "&$key=$val";
                    }
                    
                    $output_str .= "&value=".$email;
                    
                    $output = $this->setDbdata($path, $output_str, NULL, 1);
                    
                }
                
            }

        }

        return $output;
    }

    private function _customerString($array){
        
        return json_encode($array);
    }

    private function getDb_Data($db_name){

        $query = "SELECT `db_name`, `login`, `password`, `addr`, `charset` FROM `db_data` WHERE `db_name` = '$db_name'";

        $result = mysql_query($query);

        $row = mysql_fetch_assoc($result);

        $data = '';

        foreach ($row as $key => $value){
            $data .= "&$key=$value";
        }

        return $data;
    }
    
    private function setDbdata($path,$db_data,$customer,$del){
        
//        echo "$customer<br>";     
        if(!$del){
            $output = $db_data."&customer=".$customer;
        } else {
            $output = $db_data."&del=$del";
        }   
       //задаем контекст
        $context = stream_context_create(
        array(
                'http'=>array(
                                'header' => "User-Agent: Brauzer 2/0\r\nConnection: Close\r\n\r\n",
                                'method' => 'POST',
                                'content' => $output                
                             )
            )
        );

        $contents = file_get_contents("http://{$path}/hole/hole_action.php", false ,$context);

        return $contents;
    }
}
?>
