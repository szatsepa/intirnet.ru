<?php 
header('Content-Type: text/html; charset=utf-8'); 
echo '<?xml version="1.0" encoding="utf8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">

<head>
    <meta http-equiv="Last-Modified" value="<?php echo date("r",(time() - 60));?>" />
    <meta name='yandex-verification' content='4a8d7fbb2bcbbdce' />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <?php   $title_header = $title;?>
    <title>INTER - salat <?php echo $title_header; ?></title>
    <script type="text/javascript" src="js/jquery-1.8b1.js"></script>
</head>

<body>
    
    <div>
        <p style="text-align: center">WELLCOME DEAR FRIENDS!!! Начали</p>
    </div>
    <input type="hidden" id="rem" value="<?php echo $_SESSION[rem];?>"/>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        
        var rem = $("#rem").val();
        var rem_obj = {screen:screen.width + " X "+screen.height};
        
        if(rem == undefined || !rem){
            $.ajax({
                url:"action/statistics.php",
                type:'post',
                dataType:'json',
                data:rem_obj,
                success:function(data){
                    console.log(data);
                    if(data['ok'] != "NULL"){
                        $("#rem").val('1');
                        rem = 1;
                    }
                },
                error:function(data){
                    console.log(data['responseText']);
                }
            });
        }
    });
</script>