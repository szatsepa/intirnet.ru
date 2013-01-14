<script type="text/javascript">
    $(document).ready(function(){
        
        var add = false;
        
         $("#myTabs").css({'width':'47%','margin':'0 auto'});
         $("#myTabs > p").css({'font-size':'1.4em','font-weight':'bold','text-align':'center'});
         $("#tab01").css('margin', '8px auto');
         $("#tab02").hide().css({'width':'66%','margin':'12px auto'});
         $("#about_bottom").css({'width':'100%'});
         $(".col50").css({'position':'relative','width':'50%','float':'left'});
         $("#right_side").css({'position':'relative','width':'50%','float':'left','padding-top':'66px'} );
         $("#aside").css({'position':'relative','float':'left','width':'12%'});
         
         $(".ico-edit").mousedown(function(){
             
             var id = this.id;
             id = id.substr(2); 
             $("#uid").val(id)
             _readUser({uid:id});
         });
         
         $(".ico-user-02").mousedown(function(){
//             $("#tab01").hide();
             var id = this.id;
             id = id.substr(4);
             
         });
         
         $("#add_new_user").mousedown(function(){
             $("#tab01").hide();
             $("#tab02").show();
             add = true;
         });
         
         $("#back").mousedown(function(){
             add = false;   
             $("#tab01").show();
             $("#tab02").hide();

        });
         
         $("#user_insert_submit").mousedown(function(){
             var out = {uid:$("#uid").val(),pwd:$("#pwd").val(),name:$("#name").val(),patronymic:$("#patronymic").val(),surname:$("#surname").val(),phone:$("#phone").val(),phone2:$("#phone2").val(),fax:$("#fax").val(),email:$("#email").val(),postcode:$("#postcode").val(),address:$("#address").val(),comments:$("#comments").val(),tags:$("#tags").val()};
             if(!add){
                 _saveData(out);
             }else{
                 _addUser(out);
             }
            
         });
         
         function _saveData(arg){
             $.ajax({
                 url:'..action/update_user.php',
                 type:'post',
                 dataType:'json',
                 data:arg,
                 success:function(data){
                     $("#tab01").show();
                     $("#tab02").hide();
                     $("#r_"+$("#uid").val()+" td:eq(1)").text(data['customer']['surname']+" "+data['customer']['name']+" "+data['customer']['patronymic']);
                     $("#r_"+$("#uid").val()+" td:eq(2)").text(data['customer']['phone']);
                     $("#r_"+$("#uid").val()+" td:eq(3)").text(data['customer']['email']);
                 },
                 error:function(data){
                     document.write(data['responseText']);                     
                 }
             });
         }
         
         function _readUser(arg){
            $.ajax({
                url:'../query/read_user.php',
                type:'post',
                dataType:'json',
                data:arg,
                success:function(data){
//                     document.write(data);
                     $("#surname").val(data['surname']);
                     $("#name").val(data['name']);
                     $("#patronymic").val(data['patronymic']);
                     $("#phone").val(data['phone']);
                     $("#phone2").val(data['phone2']);
                     $("#fax").val(data['fax']);
                     $("#email").val(data['email']);
                     $("#postcode").val(data['postcode']);
                     $("#address").val(data['address']);
                     $("#comments").val(data['comments']);
                     $("#pwd").val(data['pwd']);
                     $("#tags").val(data['tags']);
                     $("#role").val(data['role']);
                     
                     $("#tab01").hide();
                     $("#tab02").show();
                },
                error:function(data){
                    document.write(data['responseText']);
                }
            });
        }
        function _addUser(arg){
            $.ajax({
                    url:'../action/add_user.php',
                    type:'post',
                    dataType:'json',
                    data:arg,
                    success:function(data){
                        $("#tab01").show();
                        $("#tab02").hide();
                        if(data['ins'] > 0){
                            $("#db_tab > tbody").append("<tr id='r_"+data['ins']+"'><td class='t-right'>"+data['ins']+"</td><td>"+data['ok']['db_name']+"</td><td class='smaller'>"+data['ok']['login']+"</td><td class='smaller'>"+data['ok']['password']+"</td><td class='smaller t-center'>"+data['ok']['addr']+"</td><td class='smaller t-center'>"+data['ok']['charset']+"</td><td class='smaller t-center'>"+data['ok']['db_query']+"</td><td class='t-center'><a id='e_"+data['ins']+"' class='ico-edit' title='Редактировать'></a><a id='del_"+data['ins']+"' class='ico-delete' title='Удалить'></a></td></tr>");                            
                        }

                    },
                    error:function(data){
                        document.write(data['responseText']);
                    }
                });
            }
    });
</script>
<div id="content" class="box">   
                    <!-- Tab01 -->
                    
            

    <div  class="tabs box" id="myTabs">
        <p>Администрация.</p>
<!--        <ul>    
            <li><span><strong></strong></span></li>
        </ul>-->
    </div>

    <div id="tab01">

        <table id="customers_tab">
            <thead>

            </thead> 
            <tbody>
                <tr>
                    <th class="t-center">ID</th>
                    <th class="t-center">Ф.И.О.</th>
                    <th class="t-center">Телефон</th>
                    <th class="t-center">Email</th>
                    <th class="t-center">Дата<br />рег.</th>
                    <th class='t-center'>Действ.</th>
                </tr>
    <?php
    foreach ($users as $value) {
        echo "<tr id='r_$value[id]'><td class='t-right'>$value[id]</td><td>$value[surname]&nbsp;$value[name]&nbsp;$value[patronymic]</td><td class='smaller'>$value[phone]</td><td class='smaller'>$value[email]</td><td class='smaller t-center'>$value[creation_time]</td><td class='t-center'><a id='e_$value[id]' class='ico-edit' title='Редактировать'></a><a id='set_$value[id]' class='ico-user-02' title='Выбрать контакт'></a></td></tr>";

                }
                ?>
            </tbody>
        </table>
        <br>
        <p class="nom" style="text-align: center"><input value="Добавить" class="input-submit" type="button" id="add_new_user"></p>
    </div> <!-- /tab01 -->

</div>
<!-- TAB02 -->
<div id="tab02">
        <fieldset>
    	<legend>Основные данные</legend>     
        <div class="col50">
             <p><label for="surname">Фамилия:</label><br />
			    <input size="50" value="" class="input-text required" id="surname" type="text"></p>
            <p><label for="patronymic">Отчество:</label><br />
			    <input size="50" value="" class="input-text" id="patronymic" type="text"></p>
             <p><label for="phone">Телефон:</label><br />
			    <input size="30" value="" class="input-text required" id="phone" type="text"></p>
            <p><label for="fax">Факс:</label><br />
			    <input size="30" value="" class="input-text" id="fax" type="text"></p>
        </div>
        
        <div class="col50 f-right">
            <p><label for="name">Имя:</label><br />
			    <input size="50" value="" class="input-text required" id="name" type="text"></p>
            
            <p><label for="role">Роль:</label><br />
                            <input size="50" value="" class="input-text" id="role"/></p>
            <p><label for="phone2">Дополнительный телефон:</label><br />
			    <input size="30" value="" class="input-text" id="phone2" type="text"></p>
            <p><label for="email">Электронная почта:</label><br />
			    <input size="30" value="" class="input-text email" id="email" type="text"></p><br />
        </div>
         <p><label for="postcode">Почтовый индекс:</label><br />
			    <input size="12" value="" class="input-text digits" id="postcode" minlength="6" maxlength="6" type="text"></p>
         <p><label for="address">Почтовый адрес:</label><br />
			    <input size="100" value="" class="input-text" id="address" type="text"></p>
         <p><label for="comments">Комментарии:</label><br />
			    <textarea cols="95" rows="3" class="input-text" id="comments"></textarea></p>
         <p><label for="tags">Теги:</label><br />
			    <input size="100" value="" class="input-text" id="tags" type="text"><br />
            <span class="smaller low">несколько тегов разделяются запятыми</span></p>
          
    
        </fieldset>
                <div class="box-01">
		    <p class="nom"><input value="Сохранить пользователя" class="input-submit" type="button" id="user_insert_submit"></p>
		</div> 
   
        
        <fieldset id="fieldset_doc" style="display:none;">        
    
</div> <!-- /tab02 -->
