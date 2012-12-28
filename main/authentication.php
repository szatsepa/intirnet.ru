<?php

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
		<!-- Form -->
        
<!--            <input type="hidden" name="query_str" value="<? echo $_SERVER["QUERY_STRING"]; ?>">-->
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
<!--      <form action="index.php?act=authentication" method="post" name="login_form">  </form>-->

	 <!-- </div>/login-box -->

	<div id="login-bottom"></div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
        $("#submit_psw").mousedown(function(){
            
            var ch = 0;
            
            if($("#login-remember").attr('checked') == 'checked')ch = 1;
            
            var out = {code:$("#code").val(),minde:ch};
            console.log(out);
            $.ajax({
                url:'query/userauth.php',
                type:'post',
                dataType:'json',
                data:out,
                success:function(data){
                    console.log(data);
                    if(data['ok'] == 1){
                        document.location = "index.php?act=main";
                    }
                },
                error:function(data){
                    console.log(data['responseText']);
                }
            });
        });
    });
</script>
