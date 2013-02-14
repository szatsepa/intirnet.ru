$(document).ready(function(){
    
    $("a.db_table").css({'cursor':'pointer','text-decoration':'underline'});
    
    $("a.db_table").click(function(){
        
        var db_name = $("#db_n").val();
        var db_server = $("#db_s").val();
        var db_tablename = this.id;
        var db_login = $("#db_l").val();
        var db_pwd = $("#db_p").val();
        var db_char = $("#db_c").val();
        
        var str_form = "<form id='look_t' action='index.php?act=table' method='post'><input type='hidden' name='db_name' value='"+db_name+"'><input type='hidden' name='db_server' value='"+db_server+"'><input type='hidden' name='db_tablename' value='"+db_tablename+"'><input type='hidden' name='db_login' value='"+db_login+"'><input type='hidden' name='db_pwd' value='"+db_pwd+"'><input type='hidden' name='db_charset' value='"+db_char+"'></form>";
//       console.log(str_form); 
       $("#tab02").append(str_form);
       
       $("#look_t").submit();
    });
});


