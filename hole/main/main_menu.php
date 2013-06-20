<?php

if($_SESSION['auth'] == 1) { 
$roles_active    = "";
$users_active    = "";
$kabagent_active = "";

if ($attributes['act'] == "main") $roles_active = 'id="submenu-active"';
if ($attributes['act'] == "res") $users_active = 'id="submenu-active"';
if ($attributes['act'] == "adm" ) $kabagent_active = 'id="submenu-active"';
if ($attributes['act'] == "srch") $objects_active = 'id="submenu-active"';
?>
<!-- Columns -->
	<div id="cols" class="box"><!-- Aside (Left Column) -->
            <input type="hidden" id="act" value="<?php echo $attributes['act'];?>"/>
		<div id="aside" class="box">

                    <div class="padding box">

<!--				 Logo (Max. width = 200px) -->
                            <p id="logo"><a href="#"><img src="../images/logo.gif" alt="Our logo" title="Visit Site" /></a></p>
                    </div>	
<!-- /padding -->
            <ul class="box" id="m_menu">				
                
                <li id="act_main">
                    <a href="index.php?act=main">Ресурсы и базы</a>
                    <?php
                    if(isset($res_data) && count($res_data) > 0){
                        ?>
                    
                        <ul id="bases">
                            <?php 

                            foreach ($res_data as  $value) { ?>
                                <li>

                                    <form action='index.php?act=dbinfo' method='post'>
                                        <a class="base_link"><?php echo $value['inet_name'];?></a>
                                        <input type='hidden' name='db_id' value='<?php echo $value['id']; ?>'>
                                        <input type='hidden' name='db_server' value='<?php echo $value['addr']; ?>'>
                                        <input type='hidden' name='db_login' value='<?php echo $value['login']; ?>'>
                                        <input type='hidden' name='db_pwd' value='<?php echo $value['password']; ?>'>
                                        <input type='hidden' name='db_name' value='<?php echo $value['db_name']; ?>'>
                                        <input type='hidden' name='db_charset' value='<?php echo $value['charset']; ?>'>
                                        <input type="hidden" name="db_host" value="<?php echo $value['inet_address'];?>"> 
                                    </form>
                                </li>
                                <?php
                            }
    //                        
                            ?>
                        </ul>
                   <?php }
                   if(isset($attributes['act']) and ($attributes['act'] == 'dbinfo' or $attributes['act'] == 'table')){
                       ?>
                        <ul id="bases">
                            <?php 
                            $tables_fields = $_HOLE->donorsData;
                        reset($tables_fields);
                        $tables_key = key($tables_fields);
                        $tables_data = get_object_vars($tables_fields[$tables_key]);
            if(count($tables_fields[$attributes['db_name']])){
                foreach ($tables_fields[$attributes['db_name']] as $key => $value){ 
                    
                    $tid = array_search($key, $is_tables);
                    ?>
                                <li>

                                    <form action='index.php?act=table' method='post'>
                                        <a class="base_link"><?php echo $key;?></a>
                                        <input type='hidden' name='tid' value='<?php echo $tid; ?>'>
                                        <input type='hidden' name='db_id' value='<?php echo $attributes['db_id']; ?>'>
                                        <input type='hidden' name='table' value='<?php echo $key; ?>'>
                                        <input type="hidden" name="db_name" value="<?php echo $attributes['db_name'];?>">
                                    </form>
                                </li>
                                <?php
                                
                               
                            }
                            
                }
    //                        
                            ?>
                        </ul>
                    <?php
                   }
                    
                    ?>
                </li>  
                
                
                <li id="act_customers">
                        <a href="index.php?act=customers">Клиенты ресурсов</a>
                        <?php
                        if($attributes['act'] == 'customers'){
                        ?>
                        <ul id="products">
                            <?php 

//                            foreach ($roles as $key => $value) {
//                                echo '<li><a href="index.php?act=main&r='.$key.'">'.$value.'</a></li>';
//                            }
    //                        
                            ?>
                        </ul>
                        <?php
                        }
                        ?>
                </li>
                
				
                <li id="act_adm">
                    <a href="index.php?act=adm">Администрация</a>
                </li>  
                
                <li id="act_check">
                    <a href="index.php?act=check">Check</a>
                </li> 

            </ul>
    </div> <!-- /aside -->

		<hr class="noscreen" />


<script type="text/javascript">
    $(document).ready(function(){
        
        $("a.base_link").click(function(){
            $(this).parent().submit();
        }).css({'cursor':'pointer'});
        
        if($("#act").val()=='dbinfo'){
            $("#act_main").attr('id','act_dbinfo');
        }
        if($("#act").val()=='table'){
            $("#act_main").attr('id','act_table');
        }
        
        $.each($("ul.box li"),function(){
            var id = this.id;
            var act = $("#act").val();
            if(id.search(act) > -1){
                $(this).attr('id','submenu-active');
            }            
        });
        
        setInterval(function(){
            $.ajax({
                url:'action/check_complete.php',
                cache:false,
                success:function(data){
                    var search = document.location.search;
                    if(data == 0){
                       console.log(search); 
                    }else{
                       document.location = "index.php"+search+"&comlete=1"; 
                    }
                    
                },
                        error:function(data){
                    console.log(data['responseText']);
                        }
            });
        },1000*60*15);
    });
</script>		
<?php
}
?>	
