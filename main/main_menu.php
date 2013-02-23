<?php
include '../action/check_differences.php';

$qstring = $_SERVER[QUERY_STRING];

$qstring = "index.php?".str_replace('&chng=1', "", $qstring)."&chng=1";

if(count($differences)!=0){
?>
<script type="text/javascript">
    if(confirm("В базах донорах имеются измененые данные!\n\t\tИзменить данные?")){
        document.location = "<?php echo $qstring;?>";
    }
</script>
<?php
}
if($add_rows > 0){
//    unset($differences);
?>
<script type="text/javascript">
    alert("Изменено <?php echo $add_rows;?> строк");
</script>
<?php
}
if($_SESSION[auth] == 1) { 
$roles_active    = "";
$users_active    = "";
$kabagent_active = "";
if ($attributes[act] == "main") $roles_active = 'id="submenu-active"';
if ($attributes[act] == "res") $users_active = 'id="submenu-active"';
if ($attributes[act] == "adm" ) $kabagent_active = 'id="submenu-active"';
if ($attributes[act] == "srch") $objects_active = 'id="submenu-active"';
?>
<!-- Columns -->
	<div id="cols" class="box"><!-- Aside (Left Column) -->
<!--            <input type="hidden" id="rem" value="<?php echo $_SESSION[rem];?>"/>-->
		<div id="aside" class="box">

                    <div class="padding box">

<!--				 Logo (Max. width = 200px) -->
                            <p id="logo"><a href="#"><img src="../images/logo.gif" alt="Our logo" title="Visit Site" /></a></p>
                    </div>	
<!-- /padding -->
            <ul class="box">				
                
                <li <?php echo $users_active;?>>
                    <a href="index.php?act=res">Ресурсы и базы</a>
                    <?php
                    if(isset($res_data) && count($res_data) > 0){
//                       print_r($res_data); 
                        ?>
                    
                        <ul id="bases">
                        <?php 
                        
                        foreach ($res_data as  $value) { ?>
                            <li>
                           
                            <form action='index.php?act=dbinfo' method='post'>
                            <a class="base_link"><?php echo$value[inet_name];?></a>
                            <input type='hidden' name='db_id' value='<?php echo $value[id]; ?>'>
                            <input type='hidden' name='db_server' value='<?php echo $value[addr]; ?>'>
                            <input type='hidden' name='db_login' value='<?php echo $value[login]; ?>'>
                            <input type='hidden' name='db_pwd' value='<?php echo $value[password]; ?>'>
                            <input type='hidden' name='db_name' value='<?php echo $value[db_name]; ?>'>
                            <input type='hidden' name='db_charset' value='<?php echo $value[charset]; ?>'>
                            </form></li>
                            <?php
                        }
//                        
                        ?>
                    </ul>
                   <?php }
                    
                    ?>
                </li>  
                
                
                <li <?php echo $roles_active;?>>
                    <a href="index.php?act=main">Клиенты ресурсов</a>
                    <?php
                    if($attributes[act] == 'main'){
                    ?>
                    <ul id="products">
                        <?php 
                        
                        foreach ($roles as $key => $value) {
                            echo '<li><a href="index.php?act=main&r='.$key.'">'.$value.'</a></li>';
                        }
//                        
                        ?>
                    </ul>
                    <?php
                    }
                    ?>
                </li>
                
				
                <li <?php echo $kabagent_active;?>>
                    <a href="index.php?act=adm">Администрация</a>
                </li>   

            </ul>
    </div> <!-- /aside -->

		<hr class="noscreen" />


<script type="text/javascript">
    $(document).ready(function(){
        $("a.base_link").click(function(){
            $(this).parent().submit();
        }).css({'cursor':'pointer'});
    });
</script>		
<?php
}
?>	
