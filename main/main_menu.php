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
                
                <li <?php echo $roles_active;?>>
                    <a href="index.php?act=main">Клиенты ресурсов</a>
                </li>
                
                <li <?php echo $users_active;?>>
                    <a href="index.php?act=res">Ресурсы и базы</a>
                </li>   
				
                <li <?php echo $kabagent_active;?>>
                    <a href="index.php?act=adm">Администрация</a>
                </li>   
<!--		<li <?php echo $objects_active;?>>
                    <a href="index.php?act=srch">Поиск</a>
                </li> -->
            </ul>
    </div> <!-- /aside -->

		<hr class="noscreen" />


<script type="text/javascript">
    $(document).ready(function(){
//        $("#logo").css({'width':'200px','height':'100px','padding':'4px 0px 0 0px','backgroung-color':'rgb(234, 234, 234)'});
    });
</script>		
<?php
}
?>	
