<script type="text/javascript">
    $(document).ready(function(){
        
         var add = false;
        
         $("#myTabs").css({'width':'47%','margin':'0 auto'});
         $("#myTabs > p").css({'font-size':'1.4em','font-weight':'bold','text-align':'center'});
         $("#tab01").css('margin', '8px auto');
         $("#tab02").hide().css({'width':'66%','margin':'12px auto'});
         $("#back_box").css({'position':'relative','width':'50%'});
         $(".col50").css({'position':'relative','width':'50%','float':'left'});
         $("#right_side").css({'position':'relative','width':'50%','float':'left','padding-top':'66px'} );
         $("#aside").css({'position':'relative','float':'left','width':'12%'});
         
          $(".ico-edit").live('click',function(){
             
             var id = this.id;
             id = id.substr(2); 
             $("#uid").val(id)
             _read_DB({id:id});
         });
         
        $("#update_db").mousedown(function(){
            
            var out = {id:$("#uid").val(),db_name:$("#db_name").val(),login:$("#db_login").val(),password:$("#db_password").val(),addr:$("#db_addr").val(),charset:$("#db_charset").val(),db_query:$("#db_query").val()};
           
           if(!add){
               $.ajax({
                    url:'./action/update_db_data.php',
                    type:'post',
                    dataType:'json',
                    data:out,
                    success:function(data){
//                        console.log(data);
                        $("#tab01").show();
                        $("#tab02").hide();
                        if(data['aff'] > 0){
                            $("#r_"+$("#uid").val()+" td:eq(1)").text(data['ok']['db_name']);
                            $("#r_"+$("#uid").val()+" td:eq(2)").text(data['ok']['login']);
                            $("#r_"+$("#uid").val()+" td:eq(3)").text(data['ok']['password']);
                            $("#r_"+$("#uid").val()+" td:eq(4)").text(data['ok']['addr']);
                            $("#r_"+$("#uid").val()+" td:eq(5)").text(data['ok']['charset']);
                            $("#r_"+$("#uid").val()+" td:eq(6)").text(data['ok']['db_query']);
                        }

                    },
                    error:function(data){
                        console.log(data['responseText']);
                    }
                });
           }else{ 
               $.ajax({
                    url:'./action/add_db_data.php',
                    type:'post',
                    dataType:'json',
                    data:out,
                    success:function(data){
                        $("#tab01").show();
                        $("#tab02").hide();
                        if(data['ins'] > 0){
                            $("#db_tab > tbody").append("<tr id='r_"+data['ins']+"'><td class='t-right'>"+data['ins']+"</td><td>"+data['ok']['db_name']+"</td><td class='smaller'>"+data['ok']['login']+"</td><td class='smaller'>"+data['ok']['password']+"</td><td class='smaller t-center'>"+data['ok']['addr']+"</td><td class='smaller t-center'>"+data['ok']['charset']+"</td><td class='smaller t-center'>"+data['ok']['db_query']+"</td><td class='t-center'><a id='e_"+data['ins']+"' class='ico-edit' title='Редактировать'></a><a id='del_"+data['ins']+"' class='ico-delete' title='Удалить'></a></td></tr>");                            
                        }

                    },
                    error:function(data){
                        console.log(data['responseText']);
                    }
                });
           }
           
        });
         
         $("#add_new_base").mousedown(function(){
             $("#tab01").hide();
             $("#tab02").show();
             add = true;
         });
         
        $("#back").mousedown(function(){
             add = false;   
             $("#tab01").show();
             $("#tab02").hide();

        });
         function _read_DB(arg){
             $.ajax({
                 url:'./query/uno_data.php',
                 type:'post',
                 dataType:'json',
                 data:arg,
                 success:function(data){
                     $("#uid").val(data['id']);
                     $("#db_name").val(data['db_name']);
                     $("#db_login").val(data['login']);
                     $("#db_password").val(data['password']);
                     $("#db_addr").val(data['addr']);
                     $("#db_charset").val(data['charset']);
                     $("#db_query").val(data['db_query']);
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
                    <!-- Tab01 -->
                    
            

    <div  class="tabs box" id="myTabs">
        <p>Базы данных.</p>
    </div>

    <div id="tab01">

        <table id="db_tab">
            <thead>

            </thead> 
            <tbody>
                <tr>
                    <th class="t-center">ID</th>
                    <th class="t-center">Data base</th>
                    <th class="t-center">Login</th>
                    <th class="t-center">Password</th>
                    <th class="t-center">Address</th>
                    <th class='t-center'>Charset</th>
                    <th class='t-center'>Query</th>
                    <th class='t-center'>Action</th>
                </tr>
<?php

foreach ($res_data as $value) {
     echo "<tr id='r_$value[id]'><td class='t-right'>$value[id]</td><td>$value[db_name]</td><td class='smaller'>$value[login]</td><td class='smaller'>$value[password]</td><td class='smaller t-center'>$value[addr]</td><td class='smaller t-center'>$value[charset]</td><td class='smaller t-center'>$value[db_query]</td><td class='t-center'><a id='e_$value[id]' class='ico-edit' title='Редактировать'></a><a id='del_$value[id]' class='ico-delete' title='Удалить'></a></td></tr>";
}
?>
            </tbody>
        </table>
        <br>
        <p class="nom" style="text-align: center"><input value="Добавить" class="input-submit" type="button" id="add_new_base"></p>
    </div> <!-- /tab01 -->
       
            
<!--        <div id="add_db"> </div>-->

<div id="tab02">
        <fieldset>     
        <div class="col50">
            <input type="hidden" value="" id="uid"/>
             <p><label for="surname">Data base name:</label><br />
			    <input size="50" value="" class="input-text required" id="db_name" type="text"/></p>
            <p><label for="name">Login:</label><br />
			    <input size="50" value="" class="input-text required" id="db_login" type="text"/></p>
             <p><label for="phone">Password:</label><br />
			    <input size="30" value="" class="input-text required" id="db_password" type="text"/></p>
            <p><label for="fax">Address:</label><br />
			    <input size="30" value="" class="input-text" id="db_addr" type="text"/></p>

        
            <p><label for="postcode">Charset:</label><br />
                                <input size="12" value="" class="input-text digits" id="db_charset" minlength="9" maxlength="9" type="text"></p>
            <p><label for="comments">Query:</label><br />
			    <textarea cols="95" rows="3" class="input-text" id="db_query"></textarea></p>
<!--        <div id="about_bottom"></div>  -->
    
        </fieldset>
    
        <div id="back_box">
            <p class="nom" style="text-align: center"><input value="Сохранить" class="input-submit" type="button" id="update_db">&nbsp;&nbsp;<input value="Вернутся" class="input-submit" type="button" id="back"></p>
        </div> 
           
</div> <!-- /tab02 -->
</div>