$(document).ready(function(){
      
    
    var size_tab = $("#db_tab").width();
    var size_div = $("#tab01").width();
    
    var user_dat = '';
    
    if(size_div < size_tab){
        $("#tab01").width(size_tab);
        $("div#content.box").width(size_tab + 20);
    }
    
    $("#db_tab tbody tr td").click(function(){
        
//        console.log($($(this).parent().children("td:eq(0)")).text());
        
        var str_button = "<p><input id='save_data' type='button' value='Сохранить'></p>";
                
        var db = '{"db_server":"'+$("#db_s").val()+'","db_name":"'+$("#db_n").val()+'","db_login":"'+$("#db_l").val()+'","db_pwd":"'+$("#db_p").val()+'","db_charset":"'+$("#db_c").val()+'","db_tablename":"'+$("#db_t").val()+'"}';
        
        var str_hidden = "<input class='data_hide' type='hidden' name='db_data' value='"+db+"'>";
        
        var str_form = "";
        
        var str_user = '';
        
        if($("#db_tab thead tr th:eq("+this.cellIndex+")").text() != 'password' && $("#db_tab thead tr th:eq("+this.cellIndex+")").text()!='id'){
            
            user_dat += '"' + $("#db_tab thead tr th:eq("+this.cellIndex+")").text()+'":"'+$(this).text()+'",';
            
            if(exists($("#edit_data"))){
                
                $("#save_data").remove();
            
                    str_form = "<p><input type='text' name='"+$("#db_tab thead tr th:eq("+this.cellIndex+")").text()+"' value='"+$(this).text()+"'></p>";

                    $("#edit_data").append(str_form);
                    
                    $("#edit_data").append(str_button);

                }else{
                    str_form = "<div class='data_hide' id='tab02'><form id='edit_data' action='index.php?act=edata' method='post'><br><p><input type='text' name='uid' value='"+$($(this).parent().children("td:eq(0)")).text()+"' readonly></p><p><input type='text' name='"+$("#db_tab thead tr th:eq("+this.cellIndex+")").text()+"' value='"+$(this).text()+"'></p></form></div>";
                    
                    $("#content").append(str_form); 
                    
                    $("#edit_data").append(str_hidden);
                    
                    $("#edit_data").append(str_button);
                }
        }
        
    }).css({'cursor':'pointer','text-decoration':'underline'});
    
    $("#save_data").live('click',function(){
        
        var str_user = '';
        
        $.each($("#edit_data input:text"), function(){
            if(this.name != 'uid'){
                str_user += '"'+this.name+'":"'+$(this).val()+'",'
            }           
         });
        
        $("#edit_data").append("<input class='data_hide' type='hidden' name='us_data' value='{"+str_user.substr(0,str_user.length-1)+"}'>").submit();
        
        
    });
    
    $("#find_btn").click(function(){
        
        var str_form = "<form id='find_f' action='index.php?act=table&find=1' method='post'>";
        str_form += "<input type='hidden' name='db_name' value='"+$("#db_n").val()+"'>";
        str_form += "<input type='hidden' name='db_server' value='"+$("#db_s").val()+"'>";
        str_form += "<input type='hidden' name='db_tablename' value='"+$("#db_t").val()+"'>";
        str_form += "<input type='hidden' name='db_login' value='"+$("#db_l").val()+"'>";
        str_form += "<input type='hidden' name='db_pwd' value='"+$("#db_p").val()+"'>";
        str_form += "<input type='hidden' name='db_charset' value='"+$("#db_c").val()+"'>";
        str_form += "<input type='hidden' name='db_name' value='"+$("#db_n").val()+"'>";
        str_form += "<input type='hidden' name='db_field' value='"+$("#fields option:selected").val()+"'>";
        str_form += "<input type='hidden' name='str_find' value='"+$("#finde_string").val()+"'>";
        str_form += "</form>";
        
        $("#tab02").append(str_form);
        $("#find_f").submit();
//        console.log();
    });
    
});


