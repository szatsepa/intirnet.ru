$(document).ready(function(){
    
    $("a.db_table").css({'cursor':'pointer','text-decoration':'underline','font-size':'1.1em'});
    $("#tab02").hide();
    
    $("#tab01 table tbody tr td input:checkbox").mouseup(function(){
        $("#tab02").show();
    });
    
    $("a.db_table").click(function(){
        
        var db_name = $("#db_n").val();
        var db_server = $("#db_s").val();
        var db_tablename = this.id;
        var db_login = $("#db_l").val();
        var db_pwd = $("#db_p").val();
        var db_char = $("#db_c").val();
        var db_id = $("#db_i").val();
        
        var str_form = "<form id='look_t' action='index.php?act=table' method='post'><input type='hidden' name='db_id' value='"+db_id+"'><input type='hidden' name='db_name' value='"+db_name+"'><input type='hidden' name='db_server' value='"+db_server+"'><input type='hidden' name='db_tablename' value='"+db_tablename+"'><input type='hidden' name='db_login' value='"+db_login+"'><input type='hidden' name='db_pwd' value='"+db_pwd+"'><input type='hidden' name='db_charset' value='"+db_char+"'></form>";
//       console.log(str_form); 
       $("body").append(str_form);
       
       $("#look_t").submit();
    });
    
    $("#add_tables").mousedown(function(){
        
        var fields = '{';
        
        var n = 0;
        
        $.each($("#db_tab tbody tr td input:checkbox:checked"), function(){
            fields += '"'+n+'":"'+$(this).parent().text().substr(1)+'",';
            n++;
        });
        
        fields = fields.substr(0,fields.length-1);
        
        fields += '}';
        
        console.log(fields);
        
        $.ajax({
            url:'../action/add_table_in_db.php',
            type:'post',
            dataType:'json',
            data:{fields:fields,db_id:$("#db_i").val()},
            success:function(data){
                var msg= data['cntrl'];
                
                if(data['error'] == 0 && msg == 0){
                    $("#tab02").hide();
                    document.location = "index.php?act=res";
                }else if(data['error'] == 0 && msg > 0){
                    alert("Одна или несколько таблиц уже внесены в базу данных!");
                    document.location = "index.php?act=res";
                }
                
            },
            erroe:function(data){
                console.log(data['responseText']);
            }
        });
    });
});


