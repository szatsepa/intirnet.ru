<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript">
    $(document).ready(function(){
         $("#myTabs").css({'width':'47%','margin':'0 auto'});
         $("#myTabs > p").css({'font-size':'1.4em','font-weight':'bold','text-align':'center'});
         $("#tab01").css('margin', '8px auto').hide();
         $("#tab02").css({'width':'66%','margin':'12px auto'});
         $("#tab03").css({'width':'66%','margin':'12px auto'}).hide();
         $("#about_bottom").css({'width':'100%'});
         $(".col50").css({'position':'relative','width':'50%','float':'left'});
         $("#right_side").css({'position':'relative','width':'50%','float':'left','padding-top':'66px'} );
         $("#aside").css({'position':'relative','float':'left','width':'12%'});
         $(".box-01").css({'background': 'none repeat scroll 0% 0% rgb(255, 255, 255)','border': 'none'});
         
         $("#c_search").mousedown(function(){
            _search({uid:$("#uid").val(),name:$("#name").val(),patronymic:$("#patronymic").val(),surname:$("#surname").val(),phone:$("#phone").val(),phone2:$("#phone2").val(),fax:$("#fax").val(),email:$("#email").val(),postcode:$("#postcode").val(),address:$("#address").val(),comments:$("#comments").val(),tags:$("#tags").val()});
        });
        
        $(".ico-edit").live('click',function(){
             
             var id = this.id;
             id = id.substr(2); 
             $("#uid").val(id)
             _readCustomer({uid:id});
         });
         
         $("#back").mousedown(function(){   
             $("#tab03").show();
             $("#tab02").hide();
             $("#tab01").hide();
        });
        
        $("#user_insert_submit").mousedown(function(){
            _saveData({uid:$("#e_uid").val(),name:$("#e_name").val(),patronymic:$("#e_patronymic").val(),surname:$("#e_surname").val(),phone:$("#e_phone").val(),phone2:$("#e_phone2").val(),fax:$("#e_fax").val(),email:$("#e_email").val(),postcode:$("#e_postcode").val(),address:$("#e_address").val(),comments:$("#e_comments").val(),tags:$("#e_tags").val()});
        });
        
        function _search(arg){
            var count = 0;
            
            $.each(arg, function(){
                if(this.length > 3)count++;
            });
            if(count > 0){
                $.ajax({
                    url:'query/search.php',
                    type:'post',
                    dataType:'json',
                    data:arg,
                    success:function(data){
//                        console.log(data);
                        $("#tab02").hide();
                        $("#tab01").show();
                        if(data.length > 0){
                            $.each(data, function(){
                                $("#customers_tab > tbody").append("<tr id='r_"+this['id']+"'><td class='t-right'>"+this['id']+"</td><td>"+this['name']+" "+this['patronymic']+" "+this['surname']+"</td><td class='smaller'>"+this['phone']+"</td><td class='smaller'>"+this['email']+"</td><td class='smaller t-center'>"+this['creation_time']+"</td><td class='t-center'><a id='e_"+this['id']+"' class='ico-edit' title='Редактировать'></a><a id='del_"+this['id']+"' class='ico-user-02' title='Выбрать контакт'></a></td></tr>");                            
                            });
                        }
                    },
                    error:function(data){
                        document.write(data['responseText']);
                    }
                });
            }else{
                alert("Строка поиска должна содержать не менее трех символов.")
            }
            
        }
        function _readCustomer(arg){
        
            $.ajax({
                url:'../query/customer.php',
                type:'post',
                dataType:'json',
                data:arg,
                success:function(data){
                     console.log(arg);
                     $("#e_surname").val(data['surname']);
                     $("#e_name").val(data['name']);
                     $("#e_patronymic").val(data['patronymic']);
                     $("#e_phone").val(data['phone']);
                     $("#e_phone2").val(data['phone2']);
                     $("#e_fax").val(data['fax']);
                     $("#e_email").val(data['email']);
                     $("#e_postcode").val(data['postcode']);
                     $("#e_address").val(data['address']);
                     $("#e_comments").val(data['comments']);
                     $("#e_tags").val(data['tags']);
                     $("#tab01").hide();
                     $("#tab03").show();
                },
                error:function(data){
                    document.write(data['responseText']);
                }
            });
        }
        
        function _saveData(arg){
             $.ajax({
                 url:'action/update_customer.php',
                 type:'post',
                 dataType:'json',
                 data:arg,
                 success:function(data){
                     $("#tab01").show();
                     $("#tab03").hide();
                     $("#r_"+$("#uid").val()+" td:eq(1)").text(data['customer']['surname']+" "+data['customer']['name']+" "+data['customer']['patronymic']);
                     $("#r_"+$("#uid").val()+" td:eq(2)").text(data['customer']['phone']);
                     $("#r_"+$("#uid").val()+" td:eq(3)").text(data['customer']['email']);
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
        <p>Клиенты - поиск.</p>

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
            </tbody>
        </table>
    </div> <!-- /tab01 -->


    <!-- Tab02 -->
    <div id="tab02">
            <fieldset>
            <legend><strong>Введите в любое поле или несколько полей строку поиска...</strong></legend>     
            <div class="col50">
                <p><label for="surname">Фамилия:</label><br />
                                <input size="50" value="" class="input-text" id="surname" type="text"/></p>
                <p><label for="name">Имя:</label><br />
                                <input size="50" value="" class="input-text" id="name" type="text"/></p>
                <p><label for="patronymic">Отчество:</label><br />
                                <input size="50" value="" class="input-text" id="patronymic" type="text"/></p>
                <p><label for="phone">Телефон:</label><br />
                                <input size="30" value="" class="input-text" id="phone" type="text"/></p>
                <p><label for="phone2">Дополнительный телефон:</label><br />
                                <input size="30" value="" class="input-text" id="phone2" type="text"/></p>
                <p><label for="fax">Факс:</label><br />
                                <input size="30" value="" class="input-text" id="fax" type="text"/></p>
                <p><label for="email">Электронная почта:</label><br />
                                <input size="30" value="" class="input-text email" id="email" type="text"/></p><br />
                <p><label for="postcode">Почтовый индекс:</label><br />
                                    <input size="12" value="" class="input-text" id="postcode" minlength="6" maxlength="6" type="text"></p>
                <p><label for="address">Почтовый адрес:</label><br />
                                    <input size="100" value="" class="input-text" id="address" type="text"/></p>
                <p><label for="comments">Комментарии:</label><br />
                                    <textarea cols="95" rows="3" class="input-text" id="comments"></textarea></p>
                <p><label for="tags">Теги:</label><br />
                                <input size="100" value="" class="input-text" id="tags" type="text"/><br />
            </div>  

            </fieldset>

            <div class="box-01">
                        <p class="nom" style="text-align: center"><input value="Искать" class="input-submit" type="button" id="c_search"></p>
                    </div> 

    </div> <!-- /tab02 -->
</div>
<!-- tab03 -->
<div id="tab03">
        <fieldset>
    	<legend><strong>Основные данные</strong></legend>     
        <div class="col50">
            <input type="hidden" value="" id="uid"/>
             <p><label for="surname">Фамилия:</label><br />
			    <input size="50" value="" class="input-text required" id="e_surname" type="text"/></p>
            <p><label for="name">Имя:</label><br />
			    <input size="50" value="" class="input-text required" id="e_name" type="text"/></p>
             <p><label for="phone">Телефон:</label><br />
			    <input size="30" value="" class="input-text required" id="e_phone" type="text"/></p>
            <p><label for="fax">Факс:</label><br />
			    <input size="30" value="" class="input-text" id="e_fax" type="text"/></p>
        </div>
        
        <div class="col50 f-right" id="right_side">
            <p><label for="patronymic">Отчество:</label><br />
			    <input size="50" value="" class="input-text" id="e_patronymic" type="text"/></p>
            <p><label for="phone2">Дополнительный телефон:</label><br />
			    <input size="30" value="" class="input-text" id="e_phone2" type="text"/></p>
            <p><label for="email">Электронная почта:</label><br />
			    <input size="30" value="" class="input-text email" id="e_email" type="text"/></p><br />
        </div>
        <div id="about_bottom">
         <p><label for="postcode">Почтовый индекс:</label><br />
			    <input size="12" value="" class="input-text digits" id="e_postcode" minlength="6" maxlength="6" type="text"></p>
         <p><label for="address">Почтовый адрес:</label><br />
			    <input size="100" value="" class="input-text" id="e_address" type="text"/></p>
         <p><label for="comments">Комментарии:</label><br />
			    <textarea cols="95" rows="3" class="input-text" id="e_comments"></textarea></p>
         <p><label for="tags">Теги:</label><br />
			    <input size="100" value="" class="input-text" id="e_tags" type="text"/><br />
            <span class="smaller low">несколько тегов разделяются запятыми</span></p>
        </div>  
    
        </fieldset>
    
        <div class="box-01">
		    <p class="nom" style="text-align: center"><input value="Сохранить" class="input-submit" type="submit" id="user_insert_submit">&nbsp;&nbsp;<input value="Вернутся" class="input-submit" type="button" id="back"></p>
		</div> 
           
</div> <!-- /tab03 -->