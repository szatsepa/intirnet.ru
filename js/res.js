$(document).ready(function(){

        var add = false;
        
        $("#tab02").hide();
        
        $(".ico-edit, .ico-info, .ico-delete").css('cursor','pointer');

        $(".ico-edit").live('click',function(){

            var id = this.id;
            id = id.substr(2); 
            $("#uid").val(id)
            _read_DB({id:id});
        });

    $("#update_db").mousedown(function(){

        var out = {id:$("#uid").val(),db_name:$("#db_name").val(),login:$("#db_login").val(),password:$("#db_password").val(),addr:$("#db_addr").val(),charset:$("#db_charset").val(),net_addr:$("#db_s_address").val(),net_name:$("#db_s_name").val()};

        if(!add){
            $.ajax({
                url:'../action/update_db_data.php',
                type:'post',
                dataType:'json',
                data:out,
                success:function(data){
//                        document.write(data);
                    $("#tab01").show();
                    $("#tab02").hide();
                    if(data['aff'] > 0){
                        $("#r_"+$("#uid").val()+" td:eq(1)").text(data['ok']['db_name']);
                        $("#r_"+$("#uid").val()+" td:eq(2)").text(data['ok']['login']);
                        $("#r_"+$("#uid").val()+" td:eq(3)").text(data['ok']['password']);
                        $("#r_"+$("#uid").val()+" td:eq(4)").text(data['ok']['addr']);
                        $("#r_"+$("#uid").val()+" td:eq(5)").text(data['ok']['charset']);
                        $("#r_"+$("#uid").val()+" td:eq(6)").text(data['ok']['db_query']);
                    }

                },
                error:function(data){
                    document.write(data['responseText']);
                }
            });
        }else{ 
//            console.log(out);
            $.ajax({
                url:'../action/add_db_data.php',
                type:'post',
                dataType:'json',
                data:out,
                success:function(data){
//                    console.log(data);
                    $("#tab01").show();
                    $("#tab02").hide();
                    if(data['ins'] > 0){
                        $("#db_tab > tbody").append("<tr id='r_"+data['ins']+"'><td class='t-right'>"+data['ins']+"</td><td>"+data['ok']['db_name']+"</td><td class='smaller'>"+data['ok']['login']+"</td><td class='smaller'>"+data['ok']['password']+"</td><td class='smaller t-center'>"+data['ok']['addr']+"</td><td class='smaller t-center'>"+data['ok']['charset']+"</td><td class='smaller t-center'><a href='http://"+data['ok']['inet_addr']+"' target='_blank'>"+data['ok']['inet_name']+"</a></td><td class='t-center'><a id='v_"+data['ins']+"' class='ico-info' title='Смотреть'></a>&nbsp;<a id='e_"+data['ins']+"' class='ico-edit' title='Редактировать'></a>&nbsp;<a id='del_"+data['ins']+"' class='ico-delete' title='Удалить'></a></td></tr>");                            
                    }

                },
                error:function(data){
                    document.write(data['responseText']);
                } 
            });
        }

    });
    
    $(".ico-info").live('click',function(){
        var tr_obj = $(this).parent().parent();
        var row = tr_obj[0].rowIndex;
        var id = this.id;
        id = id.substr(2);
        var str_form = "<form action='index.php?act=dbinfo' method='post' id='f_dbinfo'>";
        str_form += "<input type='hidden' name='db_id' value='"+$("#db_tab tbody tr:eq("+(row-1)+") td:eq(0)").text()+"'>";
        str_form += "<input type='hidden' name='db_server' value='"+$("#db_tab tbody tr:eq("+(row-1)+") td:eq(4)").text()+"'>";
        str_form += "<input type='hidden' name='db_login' value='"+$("#db_tab tbody tr:eq("+(row-1)+") td:eq(2)").text()+"'>";
        str_form += "<input type='hidden' name='db_pwd' value='"+$("#db_tab tbody tr:eq("+(row-1)+") td:eq(3)").text()+"'>";
        str_form += "<input type='hidden' name='db_name' value='"+$("#db_tab tbody tr:eq("+(row-1)+") td:eq(1)").text()+"'>";
        str_form += "<input type='hidden' name='db_charset' value='"+$("#db_tab tbody tr:eq("+(row-1)+") td:eq(5)").text()+"'>";
        str_form += "</form>";
        
        var form = $("body").append(str_form);
        $("#f_dbinfo").submit();
        
    });

        $("#add_new_base").mousedown(function(){
            $("#tab01").hide();
            $("#tab02").show();
            add = true;
        });

    $("#back").mousedown(function(){
            add = false;   
            $("#tab01").show();
            $("#tab02").hide();

    });
        function _read_DB(arg){
            $.ajax({
                url:'../query/uno_data.php',
                type:'post',
                dataType:'json',
                data:arg,
                success:function(data){
                    $("#uid").val(data['id']);
                    $("#db_name").val(data['db_name']);
                    $("#db_login").val(data['login']);
                    $("#db_password").val(data['password']);
                    $("#db_addr").val(data['addr']);
                    $("#db_charset").val(data['charset']);
                    $("#db_s_name").val(data['inet_name']);
                    $("#db_s_address").val(data['inet_address']);
                    $("#tab01").hide();
                    $("#tab02").show();
                },
                error:function(data){
                    document.write(data['responseText']);
                }
            });

        }
});


