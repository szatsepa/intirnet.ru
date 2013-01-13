<script type="text/javascript">
	   
     $(document).ready(function(){
         
         var customers = "";

         customers = $("#customers_tab > tbody").html();              
 
         $("#myTabs").css({'width':'47%','margin':'0 auto'});
         $("#myTabs > p").css({'font-size':'1.4em','font-weight':'bold','text-align':'center'});
         $("#tab01").css('margin', '8px auto');
         $("#tab02").hide().css({'width':'66%','margin':'12px auto'});
         $("#about_bottom").css({'width':'100%'});
         $(".col50").css({'position':'relative','width':'50%','float':'left'});
         $("#right_side").css({'position':'relative','width':'50%','float':'left','padding-top':'66px'} );
         $("#aside").css({'position':'relative','float':'left','width':'12%'});
         
         $(".ico-edit").live('click',function(){
              
             var id = this.id;
             id = id.substr(2); 
             $("#uid").val(id)
             _readCustomer({uid:id});
         });
         
         $(".ico-user-02").live('click',function(){
//             $("#tab01").hide();
             var id = this.id;
             id = id.substr(4);
             
         });
         
         
        $("#user_insert_submit").mousedown(function(){
            _saveData({uid:$("#uid").val(),name:$("#name").val(),patronymic:$("#patronymic").val(),surname:$("#surname").val(),phone:$("#phone").val(),phone2:$("#phone2").val(),fax:$("#fax").val(),email:$("#email").val(),postcode:$("#postcode").val(),address:$("#address").val(),comments:$("#comments").val(),tags:$("#tags").val()});
        });
        
        $("#back").mousedown(function(){
             add = false;   
             $("#tab01").show();
             $("#tab02").hide();

        });
        
        var role_vision = false;
        var alphabet_vision = false;
        
        $("#a_role").mousedown(function(){
            $("#fieldset_filter_alphabet").css('display', 'none');
            if(!role_vision){
                $("#fieldset_filter_roles").css('display', 'block');
            }else{
                $("#fieldset_filter_roles").css('display', 'none');
            }
            role_vision = !role_vision;        
        });
        
        $("#a_alphabet").mousedown(function(){
            $("#fieldset_filter_roles").css('display', 'none');
            if(!alphabet_vision){
                $("#fieldset_filter_alphabet").css('display', 'block');
            }else{
                $("#fieldset_filter_alphabet").css('display', 'none');
            }
            role_vision = !alphabet_vision;        
        });
         
        $("#a_all").mousedown(function(){
            alphabet_vision = role_vision = false;
            $("#fieldset_filter_alphabet").css('display', 'none');
            $("#fieldset_filter_roles").css('display', 'none');
        });
        
        
        
        $(".bigger").mousedown(function(){
            
            var role = this.id;
            
            $("#customers_tab > tbody").empty().append(customers);           
            
            $("#customers_tab > tbody > tr").each(function(){
                
                var id = this.id;
                var td_data = $("#"+id+" > td:eq(2)").text();
                
                if(role != td_data){
                    $("#"+id).remove();
                }
            });
        });
        
        $(".simbls").mousedown(function(){
            
            var simbl = this.id;
            
            $("#customers_tab > tbody").empty().append(customers);           
            
            $("#customers_tab > tbody > tr").each(function(){
                
                var id = this.id;
                var td_data = $("#"+id+" > td:eq(1)").text();
                
                if(simbl != td_data.substr(0,1)){
                    $("#"+id).remove();
                }
            });
        });
        
         $("#a_all").mousedown(function(){
                       
            $("#customers_tab > tbody").empty().append(customers);           
           
        });
        
         function _saveData(arg){
             $.ajax({
                 url:'action/update_customer.php',
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
                     console.log(data['responseText']);                     
                 }
             });
         }
         
        function _readCustomer(arg){
            $.ajax({
                url:'../query/customer.php',
                type:'post',
                dataType:'json',
                data:arg,
                success:function(data){
                     
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
                     $("#tags").val(data['tags']);
                     $("#tab01").hide();
                     $("#tab02").show();
                },
                error:function(data){
                    console.log(data['responseText']);
                }
            });
        }
     });
     
</script>

<div id="content" class="box">   
    
    <?php
    if(isset($attributes[role])){
                echo "<input type='hidden' id='s_role' value='$attributes[role]'>";
          }
    if(isset($attributes[buk])){
                echo "<input type='hidden' id='s_buk' value='$attributes[buk]'>";
          }      
    ?>
                    <!-- Tab01 -->
                    <p class="box"><strong>Клиенты.</strong></p>
        <p class="box"><a id="a_role" class="btn-info"><span>Роли</span></a><a id="a_alphabet" class="btn-info"><span>Алфавит</span></a><a id="a_all" class="btn-info"><span>Все</span></a></p>            
    
<!-- Upload -->
<fieldset id="fieldset_filter_roles" style="display:none;">
	<legend>Теги</legend>
    <?php include ("../main/roles.php");?>
</fieldset>

<!-- Upload --> 
<fieldset id="fieldset_filter_alphabet" style="display:none;">
	<legend>Алфавит</legend>
    <?php  include ("../main/alphabet.php");?>
</fieldset>        

    <div  class="tabs box" id="myTabs">
        <ul>    
    	<li><a id="t01"><span>Список</span></a></li>
    	<li><a id="t02"><span>Создать/Редактировать</span></a></li>        
    </ul>
    </div>

    <div id="tab01">

        <table id="customers_tab">
            <thead>
                <tr>
                    <th class="t-center">ID</th>
                    <th class="t-center">Ф.И.О.</th>
                    <th class="t-center">Роль</th>
                    <th class="t-center">Телефон</th>
                    <th class="t-center">Email</th>
                    <th class="t-center">Дата<br />рег.</th>
                    <th class='t-center'>Действ.</th>
                </tr>
            </thead> 
            <tbody>
                
    <?php
    foreach ($customers as $value) {
        ?>
        <tr id='r_<?php echo $value[id];?>'>
            <td class='t-right'><?php echo $value[id];?></td>
            <td><?php echo "$value[surname]&nbsp;$value[name]&nbsp;$value[patronymic]";?></td>
            <td class='smaller'><?php echo $value[role];?></td>
            <td class='smaller'><?php echo $value[phone];?></td>
            <td class='smaller'><a href='mailto:<?php echo $value[email];?>'><?php echo $value[email];?></a></td>
            <td class='smaller'><?php echo $value[creation_time];?></td>
            <td class='t-center'>
                <a id='e_<?php echo $value[id];?>' class='ico-edit' title='Редактировать'></a>
<!--                <a id='set_<?php echo $value[id];?>' class='ico-user-02' title='Выбрать контакт'></a>-->
            </td>
        </tr>

      <?php          }
                ?>
            </tbody>
        </table>
    </div> <!-- /tab01 -->


<!-- Tab02 -->
<div id="tab02">
    
<!--    <form action="index.php?act=user_insert" method="post" id="user_insert" name="user_insert">   </form>-->
        <fieldset>
    	<legend><strong>Основные данные</strong></legend>     
        <div class="col50">
            <input type="hidden" value="" id="uid"/>
             <p><label for="surname">Фамилия:</label><br />
			    <input size="50" name="surname" value="" class="input-text required" id="surname" type="text"/></p>
            <p><label for="name">Имя:</label><br />
			    <input size="50" name="name" value="" class="input-text required" id="name" type="text"/></p>
             <p><label for="phone">Телефон:</label><br />
			    <input size="30" name="phone" value="" class="input-text required" id="phone" type="text"/></p>
            <p><label for="fax">Факс:</label><br />
			    <input size="30" name="fax" value="" class="input-text" id="fax" type="text"/></p>
        </div>
        
        <div class="col50 f-right" id="right_side">
            <p><label for="patronymic">Отчество:</label><br />
			    <input size="50" name="patronymic" value="" class="input-text" id="patronymic" type="text"/></p>
            <p><label for="phone2">Дополнительный телефон:</label><br />
			    <input size="30" name="phone2" value="" class="input-text" id="phone2" type="text"/></p>
            <p><label for="email">Электронная почта:</label><br />
			    <input size="30" name="email" value="" class="input-text email" id="email" type="text"/></p><br />
        </div>
        <div id="about_bottom">
         <p><label for="postcode">Почтовый индекс:</label><br />
			    <input size="12" name="postcode" value="" class="input-text digits" id="postcode" minlength="6" maxlength="6" type="text"></p>
         <p><label for="address">Почтовый адрес:</label><br />
			    <input size="100" name="address" value="" class="input-text" id="address" type="text"/></p>
         <p><label for="comments">Комментарии:</label><br />
			    <textarea cols="95" rows="3" class="input-text" id="comments" name="comments"></textarea></p>
         <p><label for="tags">Теги:</label><br />
			    <input size="100" name="tags" value="" class="input-text" id="tags" type="text"/><br />
            <span class="smaller low">несколько тегов разделяются запятыми</span></p>
        </div>  
    
        </fieldset>
    
        <div class="box-01">
		    <p class="nom" style="text-align: center"><input value="Сохранить" class="input-submit" type="submit" id="user_insert_submit">&nbsp;&nbsp;<input value="Вернутся" class="input-submit" type="button" id="back"></p>
		</div> 
           
</div> <!-- /tab02 -->
</div><!-- Content -->