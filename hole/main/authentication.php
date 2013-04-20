<div id="entry">
    
        <p class="nom t-center" ><a href="#"><img src="../images/logo.gif" alt="Our logo" title="Visit Site" /></a></p>

        <!-- Messages -->

        <p class="msg error" id="bed_key" style="display: none;color: red;font-weight: bold;">Неверный ключ.</p>

        <p class="msg info" id="msg_key">Введите ключ.</p>


        <table> 
            <thead></thead>
            <tbody>
                <tr>
                    <td>
                        <label for="login-pass"><strong>Ключ:</strong></label>
                    </td>
                    <td>
                        <input type="password" size="35" name="code" class="input-text" id="code" />
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <span class="f-right"><a id="codeminde">Забыли ключ?</a></span>

                        <span class="f-left low"><input type="checkbox" value="" id="login-remember" /> <label for="login-remember">Запомнить меня</label></span>
                    </td>
                </tr>

                <tr>
                        <td colspan="2" class="t-right"><input type="button" id="submit_psw" class="input-submit" value="Войти &raquo;" /></td>
                </tr>
                <!-- Show/Hide -->
                <tr id="sendpass">

                </tr>
                <tr id="send_button">

                </tr>
            </tbody>
        </table>

<div id="login-bottom"></div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
            $("#code").focus();
            
            var pos_minde = true;
                
            $("#codeminde").mousedown(function(){
                if(pos_minde){
                    $("#sendpass").html('<td><label for="login-sendpass"><strong>E-mail:</strong></label></td><td><input type="text" placeholder="E-mail" size="35" name="" class="input-text f-left" id="login-sendpass" /></td>');
                    $("#send_button").html('<td colspan="2" class="t-right"><input type="button" id="send_psw" class="input-submit" value="Выслать &raquo;" /></td>');
                    $("#logo").css('height', '420px');
                    $("#code").blur();
                    $("#login-sendpass").focus();
                    pos_minde = !pos_minde;
                }else{
                   $("#sendpass").empty();
                   $("#send_button").empty();
                   $("#logo").css('height', '336px');
                   $("#code").focus();
                    pos_minde = !pos_minde; 
                }
            });
            
            $("#login-sendpass").live('keypress', function(event){
                    if(event.which == 13){
                        _sendPWD({email:$("#login-sendpass").val()});
                    }            
            });
            
            $("#send_psw").live('click',function(){
                
                _sendPWD({email:$("#login-sendpass").val()});
                
            });
        
            $("#submit_psw").mousedown(function(){

                var ch = 0;

                if($("#login-remember").attr('checked') == 'checked')ch = 1;

                _submit({code:$("#code").val(),minde:ch});

            });

            $("#code").keydown(function(event){

                if(event.which == 13){

                    var ch = 0;

                    if($("#login-remember").attr('checked') == 'checked')ch = 1;

                    _submit({code:$("#code").val(),minde:ch}); 
                }            
            });

         
        function _submit(arg){
               $.ajax({
                url:'./query/userauth.php',
                type:'post',
                dataType:'json',
                data:arg,
                success:function(data){
                    console.log(data);
                    var addr_str = '';
                    if(data['check']==1){
                        addr_str = "index.php?act=main&ch=1";
                    }else{
                        addr_str = "index.php?act=main";
                    }
                    if(data['ok'] == 1){
                        document.location = addr_str;
                    }else{
                        $("#bed_key").css({'display':'block'});
                        $("#msg_key").css({'display':'none'});
                    }
                },
                error:function(data){
                    console.log(data['responseText']);
                }
            }); 
            return false;
        }
        function _sendPWD(arg){
            $.ajax({
                    url:'./action/user_password.php',
                    type:'post',
                    dataType:'json',
                    data:arg,
                    success:function(data){
                        var msg = '';
                        if(data['ok']){
                            msg = "На зарегистрированый адрес отправлено писмо с кодом доступа.";
                            
                        }else{
                           msg = "Такого почтового адреса в базе данных нет!."; 
                        }
                        alert(msg);
                        $("#sendpass").empty();
                        $("#send_button").empty();
                        $("#logo").css('height', '336px');
                        $("#code").focus();
                    },
                    error:function(dat){
                        console.log(data['responceText']);
                    }
                });
        }
    });
</script>
