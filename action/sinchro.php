<?php
include '../query/connect.php';

$query = "SELECT d.`id`, d.`db_name`, d.`login`,d.`password`,d.`addr` AS server, d.`charset`, d.`inet_name` AS `name`, d.`inet_address` AS `url` FROM `db_data` AS d";

$result = mysql_query($query);

$db = array();

while($row = mysql_fetch_assoc($result)){
    array_push($db, $row);
}

$tmpdb = array();

foreach ($db as $value) {
    
    $tmp = array();
    
    $tmpv = $value;
    
    $tmpv['tables'] = array();
    
    $query = "SELECT t.`db_table` AS `table`, t.`db_id` FROM `db_tables` AS t WHERE t.`db_id` = ".$value['id'];
    
    $result = mysql_query($query);
    
    while ($row = mysql_fetch_assoc($result)){
        $tmpv['tables'][$row['table']] = array('db_id'=>$row['db_id']);
    }
    
    array_push($tmpdb, $tmpv);
}

 $tmp=array();
 
for($i=0;$i<count($db);$i++){
    
    foreach ($tmpdb[$i]['tables'] as $key => $value) {
        
        $tmp = array();
        
        
        $query = "SELECT f.`field_name` AS `field`, f.`this_name` AS `sinonim` FROM `table_fields` AS f WHERE f.`tablename` = '{$key}' AND f.`db_id` = '{$value['db_id']}'";

        
        $result = mysql_query($query);
        
        while ($row = mysql_fetch_assoc($result)){
            
            array_push($tmpdb[$i]['tables'][$key],array($row['field'] => $row['sinonim']));
            
        }
        
    }
    
    
}

$customers = array();

$result = mysql_query("SELECT `name`,`patronymic`,`surname`,`email` FROM `customer`");

while ($row = mysql_fetch_assoc($result)){
    array_push($customers, $row);
}

$out = '<span id="log"><ul class="box">';

foreach ($tmpdb as $value) {
    foreach ($value as $key => $value) {
        
        if(!is_array($value)){
            $out .= '<li>'.$key.' =>> '.$value.'; |  ';
        }else{
           
                    foreach ($value as $kk => $varue) { 
                        $out .= '<ul>';
                        if(!is_array($varue)){
                            $out .= '<li> 1 '.$kk.' =>> '.$varue.'; || </li> ';
                        }else{
                            $out .= '<li> 1 '.$kk.'; || </li> ';
                            foreach ($varue as $kkk => $varuu) {
                                if(!is_array($varuu)){
                                    $out .= '<li> 2 '.$kkk.' =>> '.$varuu.'; ||| </li> ';
                                }else{
                                    $out .='<ul class="box">';
                                    foreach ($varuu as $ku => $var) {
                                        $out .= '<li> 3 '.$ku.'; ||| </li> ';
                                    }
                                    $out .='</ul>';
                                }
                                
                            }
                        }
                        $out .= '</ul>';
                    }
                
            } 
$out .= '</li>';
        }

    }
    
//}
//$.each(data, function(index){
//                    $.each(this, function(index){
//                        if(index != 'tables'){
//                            $("#tab02").append("<span id='log'><p>"+index+" =>> "+this+"</p></span>");
//                        }else{
//                           $.each(this,function(index){
//                               $.each(this,function(){
//                                   if(typeof(this)=='number'){
//                                       $("#tab02").append("<span id='log'><p>  2 - "+index+" =>> "+this+"</p></span>");
//                                   }else{
//                                       $.each(this,function(index){
//                                           $("#tab02").append("<span id='log'><p>  2 - "+index+" =>> "+this+"</p></span>");
//                                       });
//                                   }
//                                   
//                               });                               
//                           }) ;
//                        }
//                        
//                    });
//
//                });

//echo json_encode($tmpdb);

$out .= '</ul></span>';

echo $out;

mysql_close();

class Bases{
    var $bases = array();
    
    function Bases(){
        
    }
    
    }
?>
