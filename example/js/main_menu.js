$(document).ready(function(){
    
    if(exists($("#db_tab"))){
    
        var str_app = '<ul class="box" id="ul_db">';

        $.each($("#db_tab tbody tr"),function(){
            
                str_app += "<li><a class='ali' id='ri_"+this.rowIndex+"'>"+$($(this).children("td:eq(1)")).text()+"</a></li>";
        });
        
        str_app += '</ul>'
        
        $("#submenu-active").append(str_app);
        
        $("#ul_db li a").css({'cursor':'pointer', 'text-decoration':'underline'});;
    }
    
    $("#ul_db li a").live('click',function(){
        var id = this.id;
        id = id.substr(3)-1;
        var obj = $("#db_tab tbody tr:eq("+id+")");
        var str_form = "<form id='ul_info' action='index.php?act=dbinfo' method='post'><input type='text' name='db_charset' value='"+obj.children("td:eq(6)").text()+"'><input type='hidden' name='db_server' value='"+obj.children("td:eq(5)").text()+"'><input type='hidden' name='db_pwd' value='"+obj.children("td:eq(4)").text()+"'><input type='hidden' name='db_login' value='"+obj.children("td:eq(3)").text()+"'><input type='hidden' name='db_name' value='"+obj.children("td:eq(2)").text()+"'></form>"
        var form = $("#tab02").append("<div>"+str_form+"</div>");
        $("#ul_info").submit();
    })
});


