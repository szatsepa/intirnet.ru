<?php
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8";

$attributes = $_POST;

mysql_connect($attributes['addr'],$attributes['login'],$attributes['password']);

mysql_select_db($attributes['db_name']);

mysql_query ("SET NAMES {$attributes['charset']}");

$out = mysql_errno();

if (mysql_errno() <> 0) exit("ERROR ".$out);

$response = NULL;

if(!isset($attributes['tablename'])){
    $response = getDBStructure();
}elseif (isset ($attributes['tablename'])) {
    $response = getDBUsers();
}

echo $response;

function getDBUsers(){
    
    $tmp = array("{$attributes['db_name']}"=>array("{$attributes['tablename']}"=>array()));
    
    $query = "SELECT COUNT(*) FROM {$attributes['tablename']}"; 
    
    $result = mysql_query($query);
    
    $count = mysql_result($result, 0);
    
    $step = ceil($count/1000);
    
    for($i=0;$i<$step;$i++){
        
        $start = ($i*1000);
        
        $query = "SELECT * FROM {$attributes['tablename']} LIMIT {$start}, 1000";
        
        $result = mysql_query($query);
        
        $numrow = 0;
        
        while ($row = mysql_fetch_assoc($result)){
            
             array_push($tmp["{$attributes['db_name']}"]["{$attributes['tablename']}"], $row);
             
        }
    }
    
    return json_encode($tmp);
    
}


function getDBStructure(){
    
    $query = " SHOW TABLES FROM {$attributes['db_name']} WHERE Tables_in_{$attributes['db_name']} LIKE '%user%' OR  Tables_in_{$attributes['db_name']} LIKE '%custom%'";

    $result = mysql_query($query);

    $response = '{"'.$attributes['db_name'].'":{';

    while ($row = mysql_fetch_row($result)){

        $num_rows = 0;

        $response .= '"'.$row[0].'":[';

        $us_query = "SHOW COLUMNS FROM `{$row[0]}`";

        $us_result = mysql_query($us_query);

        while ($us_row = mysql_fetch_row($us_result)){

            if($attributes['charset'] == 'cp1251'){
               $response .= '"'.  changeCharset($us_row[0], NULL); 
            }else{
               $response .= '"'.$us_row[0];
            }


            $response .= '",';

            $num_rows++;
        }
        $response = substr($response, 0, strlen($response)-1);
        $response .= '],';

        mysql_free_result($us_result);
        
        
    }

    $response = substr($response, 0, strlen($response)-1);

    $response .= '}}';

    mysql_free_result($result);
    
    return $response;
}

function changeCharset ($txt, $utf)  {
    $in_arr = array (
        chr(208), chr(192), chr(193), chr(194),
        chr(195), chr(196), chr(197), chr(168),
        chr(198), chr(199), chr(200), chr(201),
        chr(202), chr(203), chr(204), chr(205),
        chr(206), chr(207), chr(209), chr(210),
        chr(211), chr(212), chr(213), chr(214),
        chr(215), chr(216), chr(217), chr(218),
        chr(219), chr(220), chr(221), chr(222),
        chr(223), chr(224), chr(225), chr(226),
        chr(227), chr(228), chr(229), chr(184),
        chr(230), chr(231), chr(232), chr(233),
        chr(234), chr(235), chr(236), chr(237),
        chr(238), chr(239), chr(240), chr(241),
        chr(242), chr(243), chr(244), chr(245),
        chr(246), chr(247), chr(248), chr(249),
        chr(250), chr(251), chr(252), chr(253),
        chr(254), chr(255)
    );  
 
    $out_arr = array (
        chr(208).chr(160), chr(208).chr(144), chr(208).chr(145),
        chr(208).chr(146), chr(208).chr(147), chr(208).chr(148),
        chr(208).chr(149), chr(208).chr(129), chr(208).chr(150),
        chr(208).chr(151), chr(208).chr(152), chr(208).chr(153),
        chr(208).chr(154), chr(208).chr(155), chr(208).chr(156),
        chr(208).chr(157), chr(208).chr(158), chr(208).chr(159),
        chr(208).chr(161), chr(208).chr(162), chr(208).chr(163),
        chr(208).chr(164), chr(208).chr(165), chr(208).chr(166),
        chr(208).chr(167), chr(208).chr(168), chr(208).chr(169),
        chr(208).chr(170), chr(208).chr(171), chr(208).chr(172),
        chr(208).chr(173), chr(208).chr(174), chr(208).chr(175),
        chr(208).chr(176), chr(208).chr(177), chr(208).chr(178),
        chr(208).chr(179), chr(208).chr(180), chr(208).chr(181),
        chr(209).chr(145), chr(208).chr(182), chr(208).chr(183),
        chr(208).chr(184), chr(208).chr(185), chr(208).chr(186),
        chr(208).chr(187), chr(208).chr(188), chr(208).chr(189),
        chr(208).chr(190), chr(208).chr(191), chr(209).chr(128),
        chr(209).chr(129), chr(209).chr(130), chr(209).chr(131),
        chr(209).chr(132), chr(209).chr(133), chr(209).chr(134),
        chr(209).chr(135), chr(209).chr(136), chr(209).chr(137),
        chr(209).chr(138), chr(209).chr(139), chr(209).chr(140),
        chr(209).chr(141), chr(209).chr(142), chr(209).chr(143)
    );  
  if(!$utf){
      $txt = str_replace($in_arr,$out_arr,$txt);
  }else{
      $txt = str_replace($out_arr,$in_arr,$txt);
  }
    
    return $txt;
}
?>
