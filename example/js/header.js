$(document).ready(function(){

    $("#d_nick_name").focus();
    
    $("#logout").mousedown(function(){
                document.location.href = "index.php?act=logout";
            });

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
