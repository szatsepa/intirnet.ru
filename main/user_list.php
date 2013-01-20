<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="d_wr">
    <input type="hidden" id="uid" value="<?php echo $_SESSION[id];?>"/>
    <div id="back_v_zad">
        <a id="a_v_zad"></a>
    </div>
    <div id="paragraff">
        <p>&nbsp;</p>
    </div>
    <div id="users_list">
        <table class="info_tables" id="users">
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
                        Роль
                    </td>
                    <td>
                       Имя   
                    </td>
                    <td>
                        Отчество
                    </td>
                    <td>
                        Фамилия
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                </tr>
                <?php
                foreach ($users_list as $value) {
                    $user_del = '';
                    if($value[activity] == 0)$user_del = "Пользователь удален";
                    ?>
                <tr id="r_<?php echo $value[id];?>">
                    <td title="<?php echo $user_del;?>">
                      <?php echo $value[id];?>  
                    </td>
                    <td id="u_right">
                        <?php echo $value[right];?> 
                    </td>
                    <td>
                        <?php echo $value[name];?>                          
                    </td>
                    <td>
                        <?php echo $value[patronimyc];?> 
                    </td>
                    <td>
                        <?php echo $value[surname];?>
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
                <tr id="add_user">
                    <td colspan="7" align="right">
                        <br/>
                        <input type="button" id="add_u" value="Добавить пользователя"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div id="u_dat">
    <div class="right_block" id="rb">
        <input id="d_name" type="text" value="" size="48" required placeholder="Введите имя"/>
        <br/>
        <br/>
        <input id="d_patronimyc" type="text" value="" size="48" required placeholder="Введите отчество"/>
        <br/>
        <br/>
        <input id="d_surname" type="text" value="" size="48" required placeholder="Введите фамилию"/>
        <br/>
        <br/>
        <input id="d_doc" type="text" value="" size="48" required placeholder="Вид документа"/>
        <br/>
        <br/>
        <input id="d_series" type="text" value="" size="48" required placeholder="Серия документа"/>
        <br/>
        <br/>
        <input id="d_num" type="text" value="" size="48" required placeholder="Номер документа"/>
        <br/>
        <br/>
        <input id="d_date" type="text" value="" size="48" required placeholder="Когда выдан"/>
        <br/>
        <br/>
        <input id="d_agency" type="text" value="" size="48" required placeholder="Кем выдан"/>
        <br/>
        <br/>
        <input id="d_addr" type="text" value="" size="48" required placeholder="Адрес регистрации"/>
        <br/>
        <br/>
        <input id="d_inn" type="text" value="" size="48" required placeholder="ИНН"/>
        <br/>
        <br/>
        <select id="s_role">
            
        </select>
        <br/>
        <br/>
        <p style="text-align: right;"><input id="d_save" type="button" value="Сохранить"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        <br/>
        <br/>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){ 
        
        var act = '';
        var id_role, name_role;
//        изменим кой для чиво таблицы стилей
        $("#users_list").css({'padding-left':'32px','top':'146px','position':'relative'});
        $("#r_0").css({'background-color':'#aaa','text-align':'center','border':'1px solid #ececec'});
//        как ежели сделать тыц по ссылке класса .user_action ето приведет к неким действиям которые определим в функции
        $(".user_action").live('click',function(){
            var action_url = {e:'action/edit_userdata.php',d:'action/delete_userdata.php',a:'action/add_newuser.php'};
            var id = this.id;//read id of element
            var action = id.substr(0,1);//выделим код действия которое лежит в обьекте action_url
            var uid = id.substr(2);//составной частью this.id а именно начиная с третьего символа
//            есть идентификатор пользователя в БД
            var udata = {uid:id.substr(2)};//объкт с даными о юзере для технологии аякс ниже собсно фильтр действие
            $("#uid").val(id.substr(2));
            if(action == 'e'){
                act = 'e';
//                console.log(id.substr(2));
                $.ajax({
                    url:'query/user.php',
                    type:'post',
                    dataType:'json',
                    data:udata,
                    success:function(data){
//                        console.log(data); 
                        $("#u_dat").css({'display':'block','position':'absolute','left':'174px'});
                        $("#users_list").css('display', 'none');
                        $("#d_name").val(data['name']);
                        $("#d_patronimyc").val(data['patronimyc']);
                        $("#d_surname").val(data['surname']);
                        $("#d_doc").val(data['doc_type']);
                        $("#d_series").val(data['doc_series']);
                        $("#d_num").val(data['doc_number']);
                        $("#d_date").val(data['doc_date']);
                        $("#d_agency").val(data['doc_agency']);
                        $("#d_addr").val(data['doc_address']);
                        $("#d_inn").val(data['inn']);
                        _buildSelect(data['right']);
                    },
                    error:function(data){
                        console.log(data['responseText']);
                    }
                });
               
                udata = {uid:uid,name:$("#d_name").val(),patronimyc:$("#d_patronimyc").val(),surname:$("#d_surname").val(),doc:$("#d_doc").val(),series:$("#d_series").val(),num:$("#d_num").val(),ddate:$("#d_date").val(),agency:$("#d_agency").val(),addr:$("#d_addr").val(),inn:$("#d_inn").val(),role:id_role};
//            собсно вызываем функцию некоего действия с параметрами            
            }else if(action == 'd'){
                udata = {uid:uid};
//            собсно вызываем функцию некоего действия с параметрами 
                _action('d', action_url['d'],udata);                
            }

        });

//        функция ниже гасит блок с таблицей и откривает форму для записи даных о юзере
        $("#add_u").live('click', function(){
            act = 'a';
            $("#u_dat").css({'display':'block','position':'absolute','left':'174px'});
            $("#users_list").css('display', 'none');
//            почистим инпуты как ежели в них чиво нить было
            $.each($("#rb input:text"),function(){
                var id = this.id;
                $("#"+id).val('');
            });
//            наполним содержимым элемент селект
            _buildSelect(1);

        });
//        собсно запулить дание о юзере в БД
        $("#d_save").mousedown(function(){
            var  data = {uid:$("#uid").val(),name:$("#d_name").val(),patronimyc:$("#d_patronimyc").val(),surname:$("#d_surname").val(),doc:$("#d_doc").val(),series:$("#d_series").val(),num:$("#d_num").val(),ddate:$("#d_date").val(),agency:$("#d_agency").val(),addr:$("#d_addr").val(),inn:$("#d_inn").val(),role:id_role};
            
            $("#users_list") .css('display', 'block');
            $("#u_dat") .css('display', 'none');
            if(!data['name'] || !data['surname']){
//                нихарашо еси поля имя - фамилея бут пустиме
                alert("Поля ИМЯ и ФАМИЛИЯ должны быть заполнены!");
            }else{
                if(act == 'a'){
                    _action(act,'action/add_newuser.php',data);
                }else if(act == 'e'){
                    _action(act,'action/edit_userdata.php',data);
                }
            }
//           console.log(data);
        });
        
        $("#s_role").live('change',function(){
            id_role = $("#s_role option:selected").val();
            name_role = $("#s_role option:selected").text();
        });
        
        function _action(action, url, data){
            var url = url;
            var udata = data;
            var action = action;
            
            $.ajax({
                url:url,
                dataType:'json',
                type:'post',
                data:udata,
                success:function(data){
                    console.log(data);
//                    провиряем шош за действие еси добавить юзера то убиваем последнюю строку таблицы для стройности оной
// и ясен пень добавляем новую строку с зареганим юзером а посе для стройности восстановим строку с кнопкай добавить
                    if(action == 'a'){
                        $("#add_user").remove();
                        $("#users > tbody").append("<tr id='r_"+data['ok']+"'><td>"+data['ok']+"</td><td>"+udata['name']+"</td><td>"+udata['patronimyc']+"</td><td>"+udata['surname']+"</td><td><a class='user_action' id='e_'"+data['ok']+">Редактировать</a></td><td><a class='user_action' id='d_'"+data['ok']+">Удалитьть</a></td>"); 
                        $("#users > tbody").append('<tr id="add_user"><td colspan="6" align="right"><br/><input type="button" id="add_u" value="Добавить пользователя"/></td></tr>');
                    }else if(action == 'e'){
//                        заменим содержимое строки которую редактируваем
//                        $("#r_"+data['uid']).empty();
                        $("#r_"+data['uid']+">td:eq(0)").text(data['uid']);
                        $("#r_"+data['uid']+">td:eq(1)").text(name_role);
                        $("#r_"+data['uid']+">td:eq(2)").text(udata['name']);
                        $("#r_"+data['uid']+">td:eq(3)").text(udata['patronimyc']);
                        $("#r_"+data['uid']+">td:eq(4)").text(udata['surname']);
                }else if(action == 'd'){
//                        и нарешти удалим строку ежели пользователь удален
                        $("#r_"+data['uid']).remove();
                    }
                },
                error:function(data){
//                ета вот для контроля как ежели шо на сервере не так
                    console.log(data['responseText']);
                }

            });
            return false;
        }
        
        function _buildSelect(right){
            is_selector = true;
            var right = right;
            $.ajax({
                url:'query/iface_1.php',
                type:'post',
                dataType:'json',
                success:function(data){
                   $("#s_role").empty(); 
                   $.each(data, function(){
                        if(right == this['id']){
                            id_role = this['id'];
                            $("#s_role").append('<option value="'+this['id']+'" selected>'+this['name']+'</option>');
                        }else{
                            $("#s_role").append('<option value="'+this['id']+'">'+this['name']+'</option>');
                        }
                        
                   });
                },
                error:function(data){
                    console.log(data['responseText']);
                }
            });
            name_role = $("#s_role option:selected").text();
            return false;
        }
    });
</script>
