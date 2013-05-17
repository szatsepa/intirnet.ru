$(document).ready(function(){

    var add = false;

        $("#tab02").hide();

        $(".ico-edit").mousedown(function(){

            var id = this.id;
            id = id.substr(2); 
            $("#uid").val(id)
            _readUser({uid:id});
        });

        $(".ico-user-02").mousedown(function(){
//             $("#tab01").hide();
            var id = this.id;
            id = id.substr(4);

        });

        $("#add_new_user").mousedown(function(){
            
            $("#tab01").hide();
            $("#tab02").show();
            add = true;
        });

        $("#back").mousedown(function(){
            add = false;   
            $("#tab01").show();
            $("#tab02").hide();

    });

        $("#user_insert_submit").mousedown(function(){
            var out = {uid:$("#uid").val(),pwd:$("#pwd").val(),name:$("#name").val(),patronymic:$("#patronymic").val(),surname:$("#surname").val(),phone:$("#phone").val(),phone2:$("#phone2").val(),fax:$("#fax").val(),email:$("#email").val(),postcode:$("#postcode").val(),address:$("#address").val(),comments:$("#comments").val(),tags:$("#tags").val()};
            if(!add){
                _saveData(out);
            }else{
                _addUser(out);
            }

        });

        function _saveData(arg){
            $.ajax({
                url:'..action/update_user.php',
                type:'post',
                dataType:'json',
                data:arg,
                success:function(data){
                    $("#tab01").show();
                    $("#tab02").hide();
                    $("#r_"+$("#uid").val()+" td:eq(1)").text(data['customer']['surname']+" "+data['customer']['name']+" "+data['customer']['patronymic']);
                    $("#r_"+$("#uid").val()+" td:eq(2)").text(data['customer']['phone']);
                    $("#r_"+$("#uid").val()+" td:eq(3)").text(data['customer']['email']);
                },
                error:function(data){
                    document.write(data['responseText']);                     
                }
            });
        }

        function _readUser(arg){
        $.ajax({
            url:'../query/read_user.php',
            type:'post',
            dataType:'json',
            data:arg,
            success:function(data){
//                     document.write(data);
                    $("#surname").val(data['surname']);
                    $("#name").val(data['name']);
                    $("#patronymic").val(data['patronymic']);
                    $("#phone").val(data['phone']);
                    $("#phone2").val(data['phone2']);
                    $("#fax").val(data['fax']);
                    $("#email").val(data['email']);
                    $("#postcode").val(data['postcode']);
                    $("#address").val(data['address']);
                    $("#comments").val(data['comments']);
                    $("#pwd").val(data['pwd']);
                    $("#tags").val(data['tags']);
                    $("#role").val(data['role']);

                    $("#tab01").hide();
                    $("#tab02").show();
            },
            error:function(data){
                document.write(data['responseText']);
            }
        });
    }
    function _addUser(arg){
        $.ajax({
                url:'../action/add_user.php',
                type:'post',
                dataType:'json',
                data:arg,
                success:function(data){
                    $("#tab01").show();
                    $("#tab02").hide();
                    if(data['ins'] > 0){
                        $("#db_tab > tbody").append("<tr id='r_"+data['ins']+"'><td class='t-right'>"+data['ins']+"</td><td>"+data['ok']['db_name']+"</td><td class='smaller'>"+data['ok']['login']+"</td><td class='smaller'>"+data['ok']['password']+"</td><td class='smaller t-center'>"+data['ok']['addr']+"</td><td class='smaller t-center'>"+data['ok']['charset']+"</td><td class='smaller t-center'>"+data['ok']['db_query']+"</td><td class='t-center'><a id='e_"+data['ins']+"' class='ico-edit' title='Редактировать'></a><a id='del_"+data['ins']+"' class='ico-delete' title='Удалить'></a></td></tr>");                            
                    }

                },
                error:function(data){
                    document.write(data['responseText']);
                }
            });
        }
});

