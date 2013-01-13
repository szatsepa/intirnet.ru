<?php
/*
 * created by V Chikoff
 */

// Массив всех тегов
$cloud = array();

foreach($customers as $value) { 
      
	$tags       = $value["role"];
    
    $taglist = explode(",", $value["role"]);
    
    foreach ($taglist as $tag) {
        $tag = trim($tag);
        
        // Пропускаем пустые значения
        if ($tag == '') continue;
        
        if (array_key_exists($tag,$cloud )) {
            // Учтем, сколько раз тег встречается
            $cloud[$tag] = $cloud[$tag] + 1;
        } else {
            $cloud[$tag] =  1;
        }
        
    }
}

// Часто встречающиеся теги будут выводиться первыми
arsort($cloud);


?>
<span><?php 

foreach ($cloud as $key => $value) {
    
    echo "<a id='$key' class='bigger'>".$key."</a>&nbsp; ";
    
}


?></span>
