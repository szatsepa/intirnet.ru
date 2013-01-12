<?php
/*
 * created by vlad Chikoff
 */

$bukvar     = array('А','Б','В','Г','Д','Е','Ж','З','И','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Э','Ю','Я');
$bukvar_act = array();
	
// Обнулим массив, нет имен с такой буквой
foreach ($bukvar as $key) {

	$bukvar_act[$key] = 0;

}
$a_str = '';
foreach ($customers as $value) {    
    
        $user_letter = strtoupper($value[surname]);

        $user_letter = substr($user_letter, 0,2);

		// Учитываем только русские буквы 
        if (in_array($user_letter,$bukvar)){
		
            $bukvar_act[$user_letter] = 1;
        
		}
}

foreach ($bukvar_act as $key => $value) {
	if ($value == 1) {
		echo "<a href='index.php?act=main&amp;buk=$key".$url_add."'>$key</a>&nbsp; ";
	} else {
		echo $key."&nbsp; ";
	}
}

?>
