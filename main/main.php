<<<<<<< HEAD
<body>
    

    <div id="main">
        <input type="hidden" id="rem" value="<?php echo $_SESSION[rem];?>"/>
            <!-- Tray -->
            <div id="tray" class="box">
                    <p class="f-left box">			
                            <strong>Административная область</strong>
                    </p>
<!--                    <form action='index.php?act=logout' method='post' name="logout_form"> href="javascript:document.location = 'index.php?act=logout';"</form>-->
            <?php if(isset($_SESSION[auth]) && $_SESSION[auth]==1) {?>
                    <p class="f-right">Пользователь: <strong><a href="#"><?php echo $user["name"]."&nbsp;".$user["surname"]; ?></a></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><a id="logout">Выход</a></strong></p>
            <?php } else {?>
            <p class="f-right"><form action="index.php?act=authentication" method="post" name="login_form"><p class="f-right"><input type="hidden" name="query_str" value="<? echo $_SERVER["QUERY_STRING"]; ?>"><input type="password" name="code" size="10"><strong><a href="javascript:document.login_form.submit();" id="logout">Войти</a></strong></p></form>
            <?php } ?>
            </div> <!--  /tray -->

            <hr class="noscreen" />
    <script type="text/javascript">
        $(document).ready(function(){
            $("#logout").mousedown(function(){
                document.location.href = "index.php?act=logout";
            });
        });        
    </script>
           
=======
<?php
unset($_SESSION[auth]);
unset($_SESSION[user]);
unset($_SESSION[id]);
session_destroy(); 
if(isset($_SESSION[auth]) && $_SESSION[auth]=='yes'){
        header("location:index.php?act=main");
    }
if(isset($attributes[entry]) && $attributes[entry] == 0){
    echo '<script type="text/javascript">alert("Ваши права не позволяют вам зырить сюдой!!");</script>';
}
?>
    <div id="d_wrapper">
        <?php 
        include 'login.php';
        ?>
    </div>
</body>
<script type="text/javascript">
    $(document).ready(function(){
//        $("div").css('outline', '1px solid grey');

        $("#d_nick_name").focus();
        
        $("#d_password").keypress(function(e){ 
            var out = {login:$("#d_nick_name").val(), password:$("#d_password").val()};
            if(e.which == 13){
                 if(!$("#d_password").val()){
                        alert("Поле пароль пустое!");
                    }else{
                        logIn(out);
                    }
            }
        });
        
        $("#d_in").mousedown(function(){
            
                    var out = {login:$("#d_nick_name").val(), password:$("#d_password").val()};
                    
                    if(!$("#d_nick_name").val() || !$("#d_password").val()){
                        alert("Одно или оба поля пустые!");
                    }else{
                        logIn(out);
                    }
                    
                    

        });
        function logIn(out){
            $.ajax({
                        url:'query/autentication.php',
                        type:'post',
                        dataType:'json',
                        data:out,
                        success:function(data){
                            if(data['uid']){
                               document.location.href = "index.php?act=main";
                            }else{
                               alert("NE VASHOL!!!Проверь пароль-логин!"); 
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
>>>>>>> branch 'master' of https://github.com/szatsepa/dimon_app.git
