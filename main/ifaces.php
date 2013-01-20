<?php
foreach ($is_case as $key => $value) {
    ?>
<input class="h_if" type="hidden" id="<?php echo $key;?>" name="<?php echo $value;?>">
<?php
}

?>
<div id="d_wr">
    <input type="hidden" id="uid" value="<?php echo $_SESSION[id];?>"/>
    
    <div id="paragraff">
        <p>&nbsp;</p>
    </div>
    <div id="users_list">
        <table class="info_tables" id="ifaces">
            <thead>
<!--                <tr>
                    <th>Список пользователей ....</th>
                </tr>-->
            </thead>
            <tbody>
                <tr id="r_0">
                    <td>
                      Индекс  
                    </td>
                    <td>
                       Название   
                    </td>
                    <td>
                        Страницы
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                </tr>
                <?php
                foreach ($ifases as $value) {
                    
                    ?>
                <tr id="r_<?php echo $value[id];?>">
                    <td>
                      <?php echo $value[id];?>  
                    </td>
                    <td>
                        <?php echo $value[name];?>                          
                    </td>
                    <td>
                        <?php echo $value[right];?> 
                    </td>
                    <td>
                        <a class="user_action" id="e_<?php echo $value[id];?>">Редактировать</a> 
                    </td>
                    <td>
                        <a class="user_action" id="d_<?php echo $value[id];?>">Удалить</a> 
                    </td>
                </tr>
                <?php
                }
                ?>
                <tr id="add_interface">
                    <td colspan="6" align="right">
                        <br/>
                        <input type="button" id="add_if" value="Добавить интерфейс"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div id="u_dat">
    <div class="right_block">
        <input id="i_name" type="text" value="" size="36" required placeholder="Введите имя"/>
        <br/>
        <br/>
       
        <p style="text-align: right;"><input id="d_save" type="button" value="Сохранить"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="close" type="button" value="Отменить"/></p>
        <br/>
        <br/>
    </div>
    <div id="left_block">
        <table id="if_pages">
            <thead></thead>
            <tbody>
                <?php
                $n=0;
                                foreach ($is_case as $key => $value) {
                                    ?>
                <tr id="r_<?php echo $key;?>">
                    <td>
                        <input class="check_if" type="checkbox" id="<?php echo $key;?>"/>&nbsp;&nbsp;<?php echo $value;?>
                    </td>
                </tr>
                <?php
                         $n++;       } 
                ?>
                <tr>
                    <td>
                        <small>(Отметьте страницы которые можно посещать)</small>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){ 
        
        var action_url = {e:'action/edit_right.php',d:'action/delete_right.php',a:'action/add_right.php'};
        var iface_name = {};
        var action = '';
        var fid;
        
        $("#close").mousedown(function(){
            $("#users_list").css('display','block');
            $("#u_dat").css('display','none');
        });
        
        $(".h_if").each(function(){
            iface_name[this.id] = this.name;
        });
                
//        console.log(iface_name);
        //        изменим кой для чиво таблицы стилей
        $("#users_list").css({'padding-left':'32px','top':'146px','position':'relative'});
        $("#r_0").css({'background-color':'#aaa','text-align':'center','border':'1px solid #ececec'});
        $("#left_block,#right_block").css({'position':'relative','float':'right','width':'50%'});
        
        $("#add_if").mousedown(function(){
            action = 'a';
            $("#users_list").css('display','none');
            $("#u_dat").css('display','block');
        });
        
        $(".user_action").live('click',function(){
            
            
            var id = this.id;//read id of element
            action = id.substr(0,1);//выделим код действия которое лежит в обьекте action_url
            fid = id.substr(2);//составной частью this.id а именно начиная с третьего символа
            var out = {iface:fid};
//            console.log(out);
            if(action == 'e'){
                $.ajax({
                    url:'query/right.php',
                    type:'post',
                    dataType:'json',
                    data:out,
                    success:function(data){
                        $("#users_list").css('display','none');
                        $("#u_dat").css('display','block');
                        var rights = data['ok']['right'];
                        var r_arr = rights.split(':');
                        $("#i_name").val(data['ok']['name']);
                        $("input:checkbox").each(function(){
                            var str = this.id;
                            var check = false;
                            $.each(r_arr, function(){ 
                                if(str == this){
                                    check = true;  
                                }
                            });
                            $("#"+str).attr({'checked':check});
                        });
                    },
                    error:function(data){
                        console.log(data['responseText']);
                    }
                });
            }else if(action == 'd'){
            
                 _action(action_url[action], {iface:fid});
            }
            
        });
        
        $("#d_save").live('click',function(){
            
            var pages = "";
            
            $("input.check_if").each(function(index){
                
                if(this.checked)pages+=this.id+":";

            });
            
            pages = pages.substr(0,pages.length-1);
            var out = {name:$("#i_name").val(),rights:pages};
            
            if(action == 'e'){
                out['fid'] = fid;
            } 
            
            _action(action_url[action], out);
        });
        
        function _action(url, data){
            console.log(data);
            var url = url;
            var fdata = data;
            
            $.ajax({
                url:url,
                dataType:'json',
                type:'post',
                data:fdata,
                success:function(data){
                    $("#users_list").css('display','block');
                    $("#u_dat").css('display','none');
//                    console.log(action);
//                    console.log(data);
                    if(action == 'a'){
                        $("#add_interface").remove();
                        $("#info_tables > tbody").append("<tr id='r_"+data['ok']+"'><td>"+data['ok']+"</td><td>"+fdata['name']+"</td><td>"+fdata['rights']+"</td><td><a class='user_action' id='e_'"+data['ok']+">Редактировать</a></td><td><a class='user_action' id='d_'"+data['ok']+">Удалитьть</a></td>"); 
                        $("#info_tables > tbody").append('<tr id="add_interface"><td colspan="6" align="right"><br/><input type="button" id="add_u" value="Добавить интерфейс"/></td></tr>');
                    }else if(action == 'e'){
                        $("#r_"+data['id']+">td:eq(0)").text(data['id']);
                        $("#r_"+data['id']+">td:eq(1)").text(fdata['name']);
                        $("#r_"+data['id']+">td:eq(2)").text(fdata['rights']);
                    }else if(action == 'd'){
                        if(data['ok'] > 0){
                            $("#r_"+data['id']).remove();
                        }
                    }
                },
                error:function(data){
                    console.log(data['responseText']); 
                }
            });
        }
    });
</script>
