<script type="text/javascript">
	   
     $(document).ready(function(){
         
         var customers = "";
         var add = false;
         var search = false;
         var d_bases = new Array();
<<<<<<< HEAD
         var base_name = '';
         var pre_input = {};
         
         customers = $("#customers_tab > tbody").html(); 
         
        $.each($("#my_db > input"), function(){

            d_bases.push({db_name:this.name,dbid:this.id,password:$(this).val(),login:$(this).attr('title'),charset:$(this).attr('alt')});
        });
        
         changeBasename();
         
         $("#tab02,#tab03").hide();
         $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
          
         $(".ico-info").live('click',function(){
              
             var id = this.id;
             id = id.substr(2); 
             $("#uid").val(id);
             $("#user_insert_submit").val('Сохранить');
             add = false;
             search = false;
             base_name = $("#customers_tab tbody tr td:eq(5)").text(); 
             _readCustomer({uid:id});
            
         }).css({'cursor':'pointer'});

         
         $("#customer_data tbody tr td").live('click',function(){
             
             var str = $(this).text();
             var index = $(this).index();
             var this_id = $(this).children();
             
//             this_id = "#"+this_id;
             
        console.log($(pre_input).attr('id')!=$(this).children().attr('id'));
             
             if($(pre_input).attr('id')!=$(this).children().attr('id')){
                     var txt = $(pre_input).val();
                     $(pre_input).parent().text(txt);
                     $(pre_input).remove();
             }

            if($(this).index() != 0 && $(this).children()[0] == undefined) {
                $(this).html("<input type='text' class='text_field' value='"+str+"' id='"+$("#customer_data thead tr th:eq("+index+")").text()+"'>");
                
                pre_input = $(this).children();
            }

        });
         
         $(".ico-user-02").live('click',function(){
             
             var id = this.id;
             id = id.substr(4);
             
         });
         
         
        $("#user_insert_submit").mousedown(function(){
            
            var seni = new Date();
            
            var creation_time = seni.getFullYear()+"-"+seni.getMonth()+"-"+seni.getDate()+" "+seni.getHours()+":"+seni.getMinutes()+":"+seni.getSeconds();
            var path = '';
            if(!add){
                path = '../action/update_customer.php';
             }else{
               path = '../action/add_customer.php'; 
            }
            var user_data = {db_name:base_name};
            $.each($("#customer_data tbody tr td"), function(i){
                
                    if($(this).text()==false){
                        var name = $("#customer_data thead tr th:eq("+i+")").text();
                        
                        user_data[$("#customer_data thead tr th:eq("+i+")").text()] = $(this).children().val();
                        user_data['uid'] = $("#customer_data tbody tr td:eq(0)").text();
                       
                    }

            });
            console.log(user_data);
//            if(!search && !add){
//                _saveData(path,{uid:$("#uid").val(),name:$("#name").val(),patronymic:$("#patronymic").val(),surname:$("#surname").val(),phone:$("#phone").val(),phone2:$("#phone2").val(),fax:$("#fax").val(),email:$("#email").val(),postcode:$("#postcode").val(),address:$("#address").val(),comments:$("#comments").val(),tags:$("#tags").val(),role:$("#role").val()});
//            }else if(search){                
//               _searchData({name:$("#name").val(),patronymic:$("#patronymic").val(),surname:$("#surname").val(),phone:$("#phone").val(),phone2:$("#phone2").val(),fax:$("#fax").val(),email:$("#email").val(),postcode:$("#postcode").val(),address:$("#address").val(),comments:$("#comments").val(),tags:$("#tags").val(),role:$("#role").val()}); 
//            }else if(!search && add){
//                $("#customers_tab > tbody").append("<tr id='r_00'><td class='t-right'>no_ID</td><td>"+$("#surname").val()+" "+$("#name").val()+" "+$("#patronymic")+"</td><td class='smaller'>"+$("#role").val()+"</td><td class='smaller'>"+$("#phone").val()+"</td><td class='smaller'><a href='mailto:"+$("#email").val()+"'>"+$("#email").val()+"</a></td><td class='smaller'>"+creation_time+"</td><td class='t-center'><a id='e_00' class='ico-info' title='Смотреть'></a></td></tr>");         
//                       
//                       var out_arg = new Array();
//                      
//                      $.each(d_bases, function(){
//                            
//                            var tmp = {db_name:this['db_name'],login:this['login'],password:this['password'],addr:this['addr'],charset:this['charset'],name:$("#name").val(),patronymic:$("#patronymic").val(),surname:$("#surname").val(),phone:$("#phone").val(),phone2:$("#phone2").val(),fax:$("#fax").val(),email:$("#email").val(),postcode:$("#postcode").val(),address:$("#address").val(),comments:$("#comments").val(),tags:$("#tags").val(),role:$("#role").val()};
//                            
//                            out_arg.push(tmp);
//                        });
//                        
//                        _addBases(out_arg);
//            }
            
        });
        
        $("#back").mousedown(function(){
             add = false;   
             $("#tab01").show();
             $("#tab02,#tab03").hide();

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
            alphabet_vision = false;
        });
        
        $("#a_alphabet").mousedown(function(){
            $("#fieldset_filter_roles").css('display', 'none');
            if(!alphabet_vision){
                $("#fieldset_filter_alphabet").css('display', 'block');
            }else{
                $("#fieldset_filter_alphabet").css('display', 'none');
            }
            alphabet_vision = !alphabet_vision; 
            role_vision = false;
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
            changeBasename();
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
            changeBasename();
        });
        
         $("#a_all").mousedown(function(){
                       
            $("#customers_tab > tbody").empty().append(customers); 
            changeBasename();
           
        });
        
        $("#t01").mousedown(function(){
            $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
            $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
            $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
            
            $("#tab01").show();
            $("#tab02,#tab03").hide();
            
            $("#customers_tab > tbody").empty().append(customers);
            $("#user_insert_submit").val('Сохранить');
            
            changeBasename();
            
            add = false;
            search = false;
        });

        $("#t02").mousedown(function(){
            $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
            $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
            $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
            
            $("#tab02").show();
            $("#tab01").hide();
            
            $("#user_insert_submit").val('Сохранить');

            $.each($("#customers_data input:text"),function(){
                
                $(this).val('');
            });
            
            add = true;
            search = false;
        });
        
        $("#t03").mousedown(function(){
            
                $("input:text").val("");
                
                $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
               
                $("#tab02").show();
                $("#tab01").hide();
                
                $("#user_insert_submit").val('Искать');
                add = false;
                search = true;
        });
        
        function _searchData(arg){
            
             var count = 0;
            
            $.each(arg, function(){
                if(this.length > 3)count++;
            });
            if(count > 0){
                $.ajax({
                    url:'../query/search.php',
                    type:'post',
                    dataType:'json',
                    data:arg,
                    success:function(data){
                        
                        if(data.length > 0){
                            $("#customers_tab > tbody").empty();
                            var tab_str = '';
                            $.each(data, function(){
                                tab_str += "<tr id='r_"+this['id']+"'><td class='t-right'>"+this['id']+"</td><td>"+this['surname']+" "+this['name']+" "+this['patronymic']+"</td><td class='smaller'>"+this['role']+"</td><td class='smaller'>"+this['phone']+"</td><td class='smaller'><a href='mailto:"+this['email']+"'>"+this['email']+"</a></td><td class='smaller t-center'>"+this['creation_time']+"</td><td class='t-center'><a id='e_"+this['id']+"' class='ico-info' title='Смотреть'></a></td></tr>";
                            });
                            
                            $("#customers_tab > tbody").append(tab_str); 
                            
                            $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
                            $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                            $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                            
                            $("#user_insert_submit").val('Сохранить');
                            add = false;
                            search = false;
                            
                            $("#tab02,#tab03").hide();
                            $("#tab01").show();
            
                        }else{
                            alert("Запрос вернул пустой результат!");
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
        
         function _saveData(path, arg){
         
             $.ajax({
                 url:path,
                 type:'post',
                 dataType:'json',
                 data:arg,
                 success:function(data){
                     $("#tab01").show();
                     $("#tab02,#tab03").hide();
                     if(data['act'] == 'update'){
                         
                        $("#r_"+$("#uid").val()+" td:eq(1)").text(data['customer']['surname']+" "+data['customer']['name']+" "+data['customer']['patronymic']);
                        $("#r_"+$("#uid").val()+" td:eq(2)").text(data['customer']['phone']);
                        $("#r_"+$("#uid").val()+" td:eq(3)").text(data['customer']['email']);
                        
                        $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
                        $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                        $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                     
                 }else if(data['act'] == 'add'){
                     
                        $("#customers_tab > tbody").append("<tr id='r_"+data['customer']['id']+"'><td class='t-right'>"+data['customer']['id']+"</td><td>"+data['customer']['surname']+" "+data['customer']['name']+" "+data['customer']['patronymic']+"</td><td class='smaller'>"+data['customer']['role']+"</td><td class='smaller'>"+data['customer']['phone']+"</td><td class='smaller'><a href='mailto:"+data['customer']['email']+"'>"+data['customer']['email']+"</a></td><td class='smaller'>"+data['customer']['creation_time']+"</td><td class='t-center'><a id='e_"+data['customer']['id']+"' class='ico-info' title='Смотреть'></a></td></tr>");         
                       
                       var out_arg = new Array();
                      
                      $.each(d_bases, function(){
                            
                            var tmp = {db_name:this['db_name'],login:this['login'],password:this['password'],addr:this['addr'],charset:this['charset'],name:$("#name").val(),patronymic:$("#patronymic").val(),surname:$("#surname").val(),phone:$("#phone").val(),phone2:$("#phone2").val(),fax:$("#fax").val(),email:$("#email").val(),postcode:$("#postcode").val(),address:$("#address").val(),comments:$("#comments").val(),tags:$("#tags").val(),role:$("#role").val()};
                            
                            out_arg.push(tmp);
                        });
                        
                        _addBases(out_arg);
                    }                    
                 },
                 error:function(data){
                     console.log(data['responseText']);                     
                 }
             });
         }
         
         function _addBases(arg){
            var num = 1;
            $.each(arg, function(){
                var obj = this;
                
                $.ajax({
                    url:'../action/add_to_other_bases.php',
                    type:'post',
                    dataType:'json',
                    data:obj,
                    success:function(data){
                        
//                        console.log(data);
                    },
                    error:function(data){
                        console.log(data['responseText']);
                    }
                });
                num++;
            });            
         }
         
        function _readCustomer(arg){
            $.ajax({
                url:'../query/read_customer.php',
                type:'post',
                dataType:'json',
                data:arg,
                success:function(data){
                    var str_head = '';
                    var str_body = '';
                    
            $.each(data, function(index){
                    if(this != ''){
                        str_head += "<th class='t-center'>"+index+"</th>";
                        str_body += "<td class='t-center'>"+this+"</td>";
                    }
                    
            });
            
            str_head = "<tr>"+str_head+"</tr>";
            str_body = "<tr id='b0'>"+str_body+"</tr>";
            
                     $("#uid").val(data['id']);
                     $("#surname").val(data['surname']);
                     $("#name").val(data['name']);
                     $("#patronymic").val(data['patronymic']);
                     $("#phone").val(data['phone']);
                     $("#email").val(data['email']);
                     $("#role").val(data['role']);
                     
                    $("#customer_data thead").empty().append(str_head);
                    $("#customer_data tbody").empty().append(str_body);
                    $("#customer_data tbody tr td").css('cursor', 'pointer');
                     
                     $("#tab01").hide();
                     $("#p-filter").hide();
                     $("#tab02,#tab03").show();
                     $("#content").css({'padding':'10px'});
                     
                     $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                     $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'}); 
                     $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                },
                error:function(data){
                    document.write(data['responseText']);
                }
            });
        }
        
        function changeBasename(){
            $.each($("#customers_tab tbody tr"),function(i){
                var id = this.id;
                var td_data = $("#"+id+" > td:eq(5)").text();
                $("#"+id+" > td:eq(5)").text(d_bases[(td_data - 1)]['db_name']);
            });
        }
     });
     
</script>

<div id="content" class="box">   
  <input type="hidden" id="uid" value="">
  <form id="my_db">
      <?php 
      foreach ($odb_tables as $value){
     echo "<input type='hidden' name='$value[db_name]' id='$value[db_id]' value='$value[password]' title='$value[login]' alt='$value[charset]'>";     
      }
      ?>
  </form>
  
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
        <p class="box" id="p-filter"><a id="a_role" class="btn-info"><span>Роли</span></a><a id="a_alphabet" class="btn-info"><span>Алфавит</span></a><a id="a_all" class="btn-info"><span>Все</span></a></p>            
    
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
<!-- href="index.php?act=srch"-->
    <div  class="tabs box" id="myTabs">
        <ul> 
    	<li><a id="t01"><span>Список</span></a></li>
    	<li><a id="t02"><span>Создать/Редактировать</span></a></li> 
        <li><a id="t03"><span>Поиск</span></a></li>
    </ul>
    </div>
<!-- class="ui-tabs-panel"-->
    <div id="tab01">

        <table id="customers_tab" >
            <thead>
                <tr>
                    <th class="t-center">ID</th>
                    <th class="t-center">Ф.И.О.</th>
                    <th class="t-center">Роль</th>
                    <th class="t-center">Телефон</th>
                    <th class="t-center">Email</th>
                    <th class="t-center">Database.</th>
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
            <td class='smaller'><?php echo $value[db_data_id];?></td>
            <td class='t-center'>
                <a id='e_<?php echo $value[id];?>' class='ico-info' title='Смотреть'></a>
<!--                <a id='e_<?php echo $value[id];?>' class='ico-delete' title='Удалить'></a>-->
<!--                <a id='set_<?php echo $value[id];?>' class='ico-user-02' title='Выбрать контакт'></a>-->
            </td>
        </tr>

      <?php          }
                ?>
            </tbody>
        </table>
    </div> <!-- /tab01 -->
    <div id="tab03">
        <table id="customer_data" >
            <thead>
                
            </thead>
            <tbody>
                
            </tbody>            
        </table>
    </div>
<!-- TAB02 -->
<div id="tab02">
    <form id="customers_data">
        <fieldset>
    	<legend>Основные данные</legend>     
        <div class="col50">
             <p><label for="surname">Фамилия:</label><br />
			    <input size="50" value="" class="input-text required" id="surname" type="text" readonly></p>
            <p><label for="patronymic">Отчество:</label><br />
			    <input size="50" value="" class="input-text" id="patronymic" type="text" readonly></p>
             <p><label for="phone">Телефон:</label><br />
			    <input size="30" value="" class="input-text required" id="phone" type="text" readonly></p>
<!--            <p><label for="fax">Факс:</label><br />
			    <input size="30" value="" class="input-text" id="fax" type="text"></p>-->
        </div>
        
        <div class="col50 f-right">
            <p><label for="name">Имя:</label><br />
			    <input size="50" value="" class="input-text required" id="name" type="text" readonly></p>
            
            <p><label for="role">Роль:</label><br />
                            <input size="50" value="" class="input-text" id="role" readonly></p>
            <p><label for="email">Электронная почта:</label><br />
			    <input size="30" value="" class="input-text email" id="email" type="text" readonly></p><br />
<!--            <p><label for="phone2">Дополнительный телефон:</label><br />
			    <input size="30" value="" class="input-text" id="phone2" type="text"></p>-->
            
        </div>
<!--        <table id="customer_data" >
            <thead>
                
            </thead>
            <tbody>
                
            </tbody>            
        </table>-->
<!--         <p><label for="postcode">Почтовый индекс:</label><br />
			    <input size="12" value="" class="input-text digits" id="postcode" minlength="6" maxlength="6" type="text"></p>
         <p><label for="address">Почтовый адрес:</label><br />
			    <input size="100" value="" class="input-text" id="address" type="text"></p>
         <p><label for="comments">Комментарии:</label><br />
			    <textarea cols="95" rows="3" class="input-text" id="comments"></textarea></p>
         <p><label for="tags">Теги:</label><br />
			    <input size="100" value="" class="input-text" id="tags" type="text"><br />
            <span class="smaller low">несколько тегов разделяются запятыми</span></p>-->
          
   
        </fieldset>
    </form> 
                <div class="box-01">
		    <p class="nom"><input value="Сохранить" class="input-submit" type="button" id="user_insert_submit"></p>
		</div> 
   
=======

         customers = $("#customers_tab > tbody").html(); 
         
              $.each($("#my_db > input"), function(){
                 
                  d_bases.push({db_name:this.name,login:this.id,password:$(this).val(),addr:$(this).attr('title')});
              });
         
         $("#tab02").hide();
         $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
          
         $(".ico-edit").live('click',function(){
              
             var id = this.id;
             id = id.substr(2); 
             $("#uid").val(id);
             $("#user_insert_submit").val('Сохранить');
             add = false;
             search = false;
             _readCustomer({uid:id});
            
         }).css({'cursor':'pointer'});
         
         $(".ico-user-02").live('click',function(){
             
             var id = this.id;
             id = id.substr(4);
             
         });
         
         
        $("#user_insert_submit").mousedown(function(){
            var path = '';
            if(!add){
                path = '../action/update_customer.php';
             }else{
               path = '../action/add_customer.php'; 
            }
            if(!search){
                _saveData(path,{uid:$("#uid").val(),name:$("#name").val(),patronymic:$("#patronymic").val(),surname:$("#surname").val(),phone:$("#phone").val(),phone2:$("#phone2").val(),fax:$("#fax").val(),email:$("#email").val(),postcode:$("#postcode").val(),address:$("#address").val(),comments:$("#comments").val(),tags:$("#tags").val(),role:$("#role").val()});
            }else{                
               _searchData({name:$("#name").val(),patronymic:$("#patronymic").val(),surname:$("#surname").val(),phone:$("#phone").val(),phone2:$("#phone2").val(),fax:$("#fax").val(),email:$("#email").val(),postcode:$("#postcode").val(),address:$("#address").val(),comments:$("#comments").val(),tags:$("#tags").val(),role:$("#role").val()}); 
            }
            
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
            alphabet_vision = false;
        });
        
        $("#a_alphabet").mousedown(function(){
            $("#fieldset_filter_roles").css('display', 'none');
            if(!alphabet_vision){
                $("#fieldset_filter_alphabet").css('display', 'block');
            }else{
                $("#fieldset_filter_alphabet").css('display', 'none');
            }
            alphabet_vision = !alphabet_vision; 
            role_vision = false;
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
        
        $("#t01").mousedown(function(){
            $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
            $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
            $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
            
            $("#tab01").show();
            $("#tab02").hide();
            
            $("#user_insert_submit").val('Сохранить');
            add = false;
            search = false;
        });

        $("#t02").mousedown(function(){
            $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
            $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
            $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
            
            $("#tab02").show();
            $("#tab01").hide();
            
            $("#user_insert_submit").val('Сохранить');
            add = true;
            search = false;
        });
        
        $("#t03").mousedown(function(){
            
                $("input:text").val("");
                
                $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
               
                $("#tab02").show();
                $("#tab01").hide();
                
                $("#user_insert_submit").val('Искать');
                add = false;
                search = true;
//                console.log($("#search_btn").attr('id')).attr('id', 'search_btn');
        });
        
        function _searchData(arg){
            
             var count = 0;
            
            $.each(arg, function(){
                if(this.length > 3)count++;
            });
            if(count > 0){
                $.ajax({
                    url:'../query/search.php',
                    type:'post',
                    dataType:'json',
                    data:arg,
                    success:function(data){
//                        console.log(data);
                        
                        if(data.length > 0){
                            $("#customers_tab > tbody").empty();
                            $.each(data, function(){
                                $("#customers_tab > tbody").append("<tr id='r_"+this['id']+"'><td class='t-right'>"+this['id']+"</td><td>"+this['name']+" "+this['patronymic']+" "+this['surname']+"</td><td class='smaller'>"+this['role']+"</td><td class='smaller'>"+this['phone']+"</td><td class='smaller'><a href='mailto:"+this['email']+"'>"+this['email']+"</a></td><td class='smaller t-center'>"+this['creation_time']+"</td><td class='t-center'><a id='e_"+this['id']+"' class='ico-edit' title='Редактировать'></a><a id='del_"+this['id']+"' class='ico-user-02' title='Выбрать контакт'></a></td></tr>");                            
                            });
                            $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
                            $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                            $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                            
                            $("#user_insert_submit").val('Сохранить');
                            add = false;
                            search = false;
                            
                            $("#tab02").hide();
                            $("#tab01").show();
            
                        }else{
                            alert("Запрос вернул пустой результат!");
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
        
         function _saveData(path, arg){
         
             $.ajax({
                 url:path,
                 type:'post',
                 dataType:'json',
                 data:arg,
                 success:function(data){
                     $("#tab01").show();
                     $("#tab02").hide();
                     if(data['act'] == 'update'){
                         
                        $("#r_"+$("#uid").val()+" td:eq(1)").text(data['customer']['surname']+" "+data['customer']['name']+" "+data['customer']['patronymic']);
                        $("#r_"+$("#uid").val()+" td:eq(2)").text(data['customer']['phone']);
                        $("#r_"+$("#uid").val()+" td:eq(3)").text(data['customer']['email']);
                        $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
                        $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                        $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                     }else if(data['act'] == 'add'){
                         $("#customers_tab > tbody").append("<tr id='r_"+data['customer']['id']+"'><td class='t-right'>"+data['customer']['id']+"</td><td>"+data['customer']['surname']+" "+data['customer']['name']+" "+data['customer']['patronymic']+"/td><td class='smaller'>"+data['customer']['role']+"</td><td class='smaller'>"+data['customer']['phone']+"</td><td class='smaller'><a href='mailto:"+data['customer']['email']+"'>"+data['customer']['email']+"</a></td><td class='smaller'>"+data['customer']['creation_time']+"</td><td class='t-center'><a id='e_"+data['customer']['id']+"' class='ico-edit' title='Редактировать'></a></td></tr>");         
                     }                    
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
                     $("#role").val(data['role']);
                     
                     $("#tab01").hide();
                     $("#p-filter").hide();
                     $("#tab02").show();
                     
                     $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                     $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'}); 
                     $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                },
                error:function(data){
                    document.write(data['responseText']);
                }
            });
        }
     });
     
</script>

<div id="content" class="box">   
  <input type="hidden" id="uid" value="">
  <form id="my_db">
      <?php 
      foreach ($db_data as $value){
     echo "<input type='hidden' name='$value[db_name]' id='$value[login]' value='$value[password]' title='$value[addr]'>";     
      }
      ?>
  </form>
  
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
        <p class="box" id="p-filter"><a id="a_role" class="btn-info"><span>Роли</span></a><a id="a_alphabet" class="btn-info"><span>Алфавит</span></a><a id="a_all" class="btn-info"><span>Все</span></a></p>            
    
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
<!-- href="index.php?act=srch"-->
    <div  class="tabs box" id="myTabs">
        <ul> 
    	<li><a id="t01"><span>Список</span></a></li>
    	<li><a id="t02"><span>Создать/Редактировать</span></a></li> 
        <li><a id="t03"><span>Поиск</span></a></li>
    </ul>
    </div>
<!-- class="ui-tabs-panel"-->
    <div id="tab01">

        <table id="customers_tab" >
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
<!-- TAB02 -->
<div id="tab02">
    <form id="customers_data">
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
		    <p class="nom"><input value="Сохранить" class="input-submit" type="button" id="user_insert_submit"></p>
		</div> 
   </form>
>>>>>>> branch 'master' of https://github.com/szatsepa/intirnet.ru.git
        
        <fieldset id="fieldset_doc" style="display:none;">        
    
</div> <!-- /tab02 -->
</div><!-- Content -->
