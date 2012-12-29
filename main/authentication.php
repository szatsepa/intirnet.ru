<?php
if(isset($_SESSION[id])){
    header("location:index.php?act=main");
}
?>
<!--
<div>
    <p style="text-align: center">WELLCOME DEAR FRIENDS!!! Начали</p>
</div>-->
<div id="logo">
<!--    <div id="login-box">-->

		<!-- Logo -->
		<p class="nom t-center"><a href="#"><img src="images/logo.gif" alt="Our logo" title="Visit Site" /></a></p>

		<!-- Messages -->
        <?php if (isset($attributes[err]) and $attributes[err] == 'auth') {?>
		<p class="msg error">Неверный ключ.</p>
		<?php } else {?>
		<p class="msg info">Введите ключ.</p>
        <?php } ?>
                
		<table class="nom nostyle">			
			<tr>
				<td><label for="login-pass"><strong>Ключ:</strong></label></td>
				<td><input type="password" size="45" name="code" class="input-text" id="code" /></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<span class="f-right"><a id="codeminde">Забыли ключ?</a></span>
					<span class="f-left low"><input type="checkbox" value="" id="login-remember" /> <label for="login-remember">Запомнить меня</label></span>
				</td>
			</tr>
			<!-- Show/Hide -->
			<tr id="sendpass" style="display:none;">
				<td><label for="login-sendpass"><strong>E-mail:</strong></label></td>
				<td>
					<input type="text" size="35" name="" class="input-text f-left" id="login-sendpass" />
					<span class="f-right"><input type="submit" value="Выслать" /></span>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="t-right"><input type="button" id="submit_psw" class="input-submit" value="Войти &raquo;" /></td>
			</tr>
		</table>

	<div id="login-bottom"></div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
                $("#code").focus();
        
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
                url:'query/userauth.php',
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
                    }
                },
                error:function(data){
                    console.log(data['responseText']);
                }
            }); 
            return false;
        }
    });
</script>
