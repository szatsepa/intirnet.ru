<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$right = NULL;

if(isset($attributes[act])){
    
    $us_rights = _userRight($_SESSION[id]);

    foreach ($us_rights[rights] as $value) {

        if($attributes[act] == $value)$right = 1;

    }

}

if($right === NULL && isset($attributes[act])){
    header("location:index.php?entry=0");
}

function _userRight($uid){
    
    $out = array();
    
    if(isset($uid) && $uid){
        
        $query = "SELECT r.name AS who, r.right FROM d_users AS u, d_right AS r WHERE u.right = r.id AND u.id = $uid";
    
        $result = mysql_query($query);

        $user_right = mysql_fetch_assoc($result);

        mysql_free_result($result);

        $cases = explode(':', $user_right[right]);

        $out[who]=$user_right[who];
        
        $out[rights]=$cases;
        
    }else{
        
        unset($_SESSION[auth]);
        unset($_SESSION[user]);
        unset($_SESSION[id]);
        unset($_SESSION[right]);
        session_destroy();
        
        $out[who]="гость";
        
        $out[rights]=array('main');
        
    }
    
    
    
    return $out;
}
?>
