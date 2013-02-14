<div><div id="back_form">
<?php

mysql_close();

$data_T = json_decode($attributes[db_data],TRUE);

$user_data = json_decode($attributes[us_data],TRUE);

mysql_connect("$data_T[db_server]","$data_T[db_login]","$data_T[db_pwd]") or die (mysql_errno());

mysql_select_db($data_T[db_name]);

mysql_query ("SET NAMES $data_T[db_charset]");

$set = '';

foreach ($user_data as $key => $value) {
    
    $set .= "`".$key."` = '".$value."',";
    
}

$set = substr($set, 0,(strlen($set)-1));

$query = "UPDATE `$data_T[db_tablename]` SET $set WHERE `id` = '$attributes[uid]'";

mysql_query($query) or die(mysql_errno());

if(mysql_affected_rows()>0){
?>
<script type="text/javascript">
    $(document).ready(function(){
        var str_form = "<form id='back_table' action='index.php?act=table' method='post'></form>";
        var str_input = "<input type='hidden' name='db_name' value='<?php echo $data_T[db_name];?>'>";
        str_input += "<input type='hidden' name='db_server' value='<?php echo $data_T[db_server];?>'>";
        str_input += "<input type='hidden' name='db_tablename' value='<?php echo $data_T[db_tablename];?>'>";
        str_input += "<input type='hidden' name='db_login' value='<?php echo $data_T[db_login];?>'>";
        str_input += "<input type='hidden' name='db_pwd' value='<?php echo $data_T[db_pwd];?>'>";
        str_input += "<input type='hidden' name='db_charset' value='<?php echo $data_T[db_charset];?>'>";
        $("#back_form").append(str_form);
        $("#back_table").append(str_input).submit();
        
    });
    
</script>
<?php
}
?>