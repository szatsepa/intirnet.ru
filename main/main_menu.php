<?php
<<<<<<< HEAD
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
=======

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="d_wrapper">
    <div id="paragraff">
        <p>"Tтипа контора"</p>
    </div>
    <div id="d_main_menu">
        <table id="m_menu">
            <thead></thead>
            <tbody>
                <tr>
                    <td><a class="menu_btn" id="b_1">Kibined</a></td>
                    <td><a class="menu_btn" id="b_2">Второй</a></td>
                    <td><a class="menu_btn" id="b_3">Третий</a></td>
                    <td><a class="menu_btn" id="b_4">Шитвертый</a></td>
                    <td><a class="menu_btn" id="b_5">Пьятий</a></td>
                    <td><a class="menu_btn" id="b_6">Шистой</a></td>
                    <td><a class="menu_btn" id="b_7">Сидьмой</a></td>
                    <td><a class="menu_btn" id="b_8">Васьмой</a></td>
                    <td><a id="back_btn">В зад</a></td>
                    <td><a id="logout">Выйти</a></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div id="submenu">
      <ul id="s_m">
      </ul>
    </div>
    
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
        var step = false;
        var first_submenu = {0:'first'};
        var first_mine_menu = {first:{'privat':"кабинет",'users':'пользователи','ifase':'интерфейс','company':'предприятие'}};
        
        $(".menu_btn").mousedown(function(){
            
            $("#s_m").empty();
            
            if(!step){
                var id = this.id;
                var num = id.substr(2)-1;
                var aga = first_submenu[num];
                var pos = $("#"+id).position();
                var set = $("#"+id).offset();
                var str = $("#"+id).text();
                var num = 0;

                if(first_mine_menu[aga]){
                    $.each(first_mine_menu[aga], function(index, e){
                        $("#s_m").append('<li class="ll" id="'+index+'">'+e+'</li>'); 
                        num++;
                    });  
                }
                $("#l0").remove();
                $("#s_m").prepend('<li id="l0">'+str+"</li>");
                $("#submenu").css({'display':'block','left':(pos['left']-13)});
                $("#s_m").attr('name', num);
            }
            step = !step;
            
        });
        $(".ll").live('mousedown',function(){
            var id = this.id;
            var str = $("#"+id).text(); 
            alert('Ідітє в гм... па адріссу "'+str+'"');
            document.location = 'index.php?act='+id;
        });
        
        $("#logout").mousedown(function(){
            document.location = 'index.php?act=logout';
        });
        
        $("#back_btn").mousedown(function(){
            window.history.go(-1);
        });
    });
</script>
>>>>>>> branch 'master' of https://github.com/szatsepa/dimon_app.git
