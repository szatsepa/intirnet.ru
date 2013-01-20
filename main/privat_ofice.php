<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="d_wr">
    <div id="back_v_zad">
        <a id="a_v_zad"></a>
    </div>
    <div id="paragraff">
        <p>&nbsp;</p>
    </div>
    <div class="left_block">
        <input type="hidden" id="uid" value="<?php echo $u_array[id];?>"/>
        <input id="d_nick_name" type="text" value="" required placeholder="Введите логин"/>
        <br/>
        <br/>
        <input id="d_pas" type="password" value="" required placeholder="Ваш пароль"/><span id="vpsw">&nbsp;</span>
        <br/>
        <br/>
        <input id="d_pas_sec" type="password" value="" required placeholder="Ваш пароль еще раз"/><span id="svpsw">&nbsp;</span>
        <br/>
        <br/>
        <p style="text-align: right;"><input id="d_in" type="button" value="Изменить"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </div>
    <div class="right_block">
        <input id="d_name" type="text" value="<?php echo $u_array[name];?>" size="48" required placeholder="Введите имя"/>
        <br/>
        <br/>
        <input id="d_patronimyc" type="text" value="<?php echo $u_array[patronimyc];?>" size="48" required placeholder="Введите отчество"/>
        <br/>
        <br/>
        <input id="d_surname" type="text" value="<?php echo $u_array[surname];?>" size="48" required placeholder="Введите фамилию"/>
        <br/>
        <br/>
        <input id="d_doc" type="text" value="<?php echo $u_array[doc_type];?>" size="48" required placeholder="Вид документа"/>
        <br/>
        <br/>
        <input id="d_series" type="text" value="<?php echo $u_array[doc_series];?>" size="48" required placeholder="Серия документа"/>
        <br/>
        <br/>
        <input id="d_num" type="text" value="<?php echo $u_array[doc_number];?>" size="48" required placeholder="Номер документа"/>
        <br/>
        <br/>
        <input id="d_date" type="text" value="<?php echo $u_array[doc_date];?>" size="48" required placeholder="Когда выдан"/>
        <br/>
        <br/>
        <input id="d_agency" type="text" value="<?php echo $u_array[doc_agency];?>" size="48" required placeholder="Кем выдан"/>
        <br/>
        <br/>
        <input id="d_addr" type="text" value="<?php echo $u_array[doc_address];?>" size="48" required placeholder="Адрес регистрации"/>
        <br/>
        <br/>
        <input id="d_inn" type="text" value="<?php echo $u_array[inn];?>" size="48" required placeholder="ИНН"/>
        <br/>
        <br/>
        <p style="text-align: right;"><input id="d_save" type="button" value="Сохранить"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        <br/>
        <br/>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
        $("#d_in").mousedown(function(){
           _save("action/change_psw.php", {uid:$("#uid").val(),log:$("#d_nick_name").val(),psw:$("#d_pas_sec").val()});  
        }).attr("disabled","disabled").css({"cursor":"default"});
        
        $("#d_save").mousedown(function(){
            _save("action/change_userdata.php", {uid:$("#uid").val(),name:$("#d_name").val(),patronimyc:$("#d_patronimyc").val(),surname:$("#d_surname").val(),doc:$("#d_doc").val(),series:$("#d_series").val(),num:$("#d_num").val(),ddate:$("#d_date").val(),agency:$("#d_agency").val(),addr:$("#d_addr").val(),inn:$("#d_inn").val()}); 
           
        }).css({"cursor":"pointer"});
        
        $("#d_pas").keyup(function(){
            var str = '';
            $.each($("#d_pas").val(), function(){
                str += "*";
            });
            if(str.length > 0 && str.length < 6){
              $("#vpsw").css('visibility', 'visible').css({'color':'red'});   
            }else if(str.length > 5 && str.length < 9){
                $("#vpsw").css({'background-color':'yellow','color':'yellow'}); 
            }else if(str.length > 8){
                $("#vpsw").css({'background-color':'greenyellow','color':'greenyellow'}); 
            }
            if(str.length < 24)$("#vpsw").text(str);
        });
        
        $("#d_pas_sec").keyup(function(){
            var psw = $("#d_pas_sec").val();
            var count = psw.length;
            var fpsw = $("#d_pas").val();
            fpsw = fpsw.substr(0,count);
            var str = '';
            
            $.each(psw, function(){
                str += "*";
            });
            
            if(count > 0){
                $("#svpsw").css('visibility', 'visible');
            }
        
            if($("#d_pas_sec").val() != $("#d_pas").val()){
              $("#svpsw").css({'background-color':'red','color':'red'});   
            }else{
              $("#svpsw").css({'background-color':'greenyellow','color':'greenyellow'});
              $("#d_in").removeAttr('disabled').css({"cursor":"pointer"});
            }
            
            if(str.length < 24)$("#svpsw").text(str);
        }).keypress(function(e){
            if(e.which == 13){
                _save("action/change_psw.php", {uid:$("#uid").val(),log:$("#d_nick_name").val(),psw:$("#d_pas_sec").val()});
            }
        });
        
        function _save(url, out){
            var url = url;
            var out = out;
            $.ajax({
                asinc:false,
                url:url,
                type:'post',
                dataType:'json',
                data:out,
                success:function(data){
//                    console.log(data); 
                    alert(data['ok']);
//                    document.write(data['query']);
                },
                error:function(data){
                    console.log(data['responseText']);
                }
                
            });
        }
        
        function _pswValidation(psw,psw1){
            
        }
        
        function checkMail(value){
            var pattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return ret = (pattern.test(value)) ? (1) : (0);
        }
    });
</script>