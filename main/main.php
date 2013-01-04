<div id="main">
	<!-- Tray -->
	<div id="tray" class="box">
		<p class="f-left box">			
			<strong>Административная область</strong>
		</p>
        <?php if(isset($_SESSION[auth]) && $_SESSION[auth]==1) {?>
		<form action='index.php?act=logout' method='post' name="logout_form"><p class="f-right">Пользователь: <strong><a href="#"><?php echo $user["name"]."&nbsp;".$user["surname"]; ?></a></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><a href="javascript:document.logout_form.submit();" id="logout">Выход</a></strong></p></form>
        <?php } else {?>
        <p class="f-right"><form action="index.php?act=authentication" method="post" name="login_form"><p class="f-right"><input type="hidden" name="query_str" value="<? echo $_SERVER["QUERY_STRING"]; ?>"><input type="password" name="code" size="10"><strong><a href="javascript:document.login_form.submit();" id="logout">Войти</a></strong></p></form>
        <?php } ?>
	</div> <!--  /tray -->

	<hr class="noscreen" />

	<!-- Columns -->
<!--	<div id="cols" class="box">-->
           
