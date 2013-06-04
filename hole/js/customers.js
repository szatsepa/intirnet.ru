$(document).ready(function(){

    var customers = "";
    var add = false;
    var search = false;
    var d_bases = new Array();
    var base_name = '';
    var pre_input = {};
//    console.log(getCode());
    
    
    var w_content = $("#content").width();
    
    $("#tab03, #customer_data").css({'width':w_content});
    
    $("td.t-center").css({'cursor':'default'});
    
    $("#pager p a").css({'font-weight':'bold'});

    customers = $("#customers_tab > tbody").html(); 
    
    $("#t04").hide();

    $.each($("#my_db > input"), function(){

        d_bases.push({db_name:this.name,dbid:this.id,password:$(this).val(),login:$(this).attr('title'),charset:$(this).attr('alt')});
    });

//    changeBasename();

    $("#products a").click(function(){
        $("#chap").text($(this).text());
//        //console.log();
    });
    
    $("#tab02,#tab03").hide();
    
    $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});

    $(".ico-info").live('click',function(){

        var id = this.id;
        id = id.substr(2); 
        $("#uid").val(id);
        $("#user_insert_submit").val('Изменить');
        add = false;
        search = false;
        
        $.ajax({
            url:'query/read_customer.php',
            type:'post',
            dataType:'json',
            data:{'uid':id},
            success:function(data){
                 $("#tab02").show();
                 $("#tab01").hide();
                $.each(data, function(index){
                    var str_id = "#"+index;
                    $(str_id).val(this);
                });
            },
            error:function(data){
                console.log(data['responseText']);
            }
        });
        

    }).css({'cursor':'pointer'});
    
    $(".ico-delete").live('click',function(){

        var id = this.id;
        id = id.substr(2); 
        $("#uid").val(id);
        var obj = $(this).parent().parent();
        if(confirm("Вы действительно хотите это сделать?")){
            
            var form_delete = "<form id='del_cu' action='index.php?act=del' method='post'>";
            
            form_delete += "<input type='hidden' name='addr' value="+$("#str_addr").val()+"><input type='hidden' name='email' value='"+$(obj).find('td:eq(3)').text()+"'></form>";
            
            $("#sbmt_btn").append(form_delete);
            
            $("#del_cu").submit();
        } 

    }).css({'cursor':'pointer'});
    
    $("#customer_data tbody tr td").live('hover',function(){
        var index = this['cellIndex'];
        if($("#customer_data thead tr th:eq("+index+")").text()=='name' || $("#customer_data thead tr th:eq("+index+")").text() == 'surname' || $("#customer_data thead tr th:eq("+index+")").text()=='patronymic'){
            $(this).css('cursor', 'pointer');
        }
        
    });

    $("#customer_data tbody tr td").live('click',function(){

        var str = $(this).text();
        var index = $(this).index();
        var this_id = $(this).children();

        if($(pre_input).attr('id')!=$(this).children().attr('id')){
                var txt = $(pre_input).val();
                $(pre_input).parent().text(txt);
                $(pre_input).remove();
        }

    if($(this).index() != 0 && $(this).children()[0] == undefined) {
        
        if($("#customer_data thead tr th:eq("+index+")").text()=='name' || $("#customer_data thead tr th:eq("+index+")").text() == 'surname' || $("#customer_data thead tr th:eq("+index+")").text()=='patronymic'){
            
            $(this).html("<input type='text' class='text_field' value='"+str+"' id='"+$("#customer_data thead tr th:eq("+index+")").text()+"'>");

            pre_input = $(this).children();
            
            $(pre_input).focus().select();
        }        
    }

});

    $(".ico-user-02").live('click',function(){

        var id = this.id;
        id = id.substr(4);

    });


$("#user_insert_submit").mousedown(function(){
    
    var user_data = {};
    
    if(add && !search){
        
         var form_add = "<form id='add_cu' action='index.php?act=add' method='post'><input type='hidden' name='addr' value='"+$("#str_addr").val()+"'>";
         
         form_add += "<input type='hidden' name='surname' value='"+$("#surname").val()+"'><input type='hidden' name='patronymic' value='"+$("#patronymic").val()+"'>";
         
         form_add += "<input type='hidden' name='name' value='"+$("#name").val()+"'><input type='hidden' name='phone' value='"+$("#phone").val()+"'>";
         
         form_add += "<input type='hidden' name='email' value='"+$("#email").val()+"'><input type='hidden' name='password' value='"+getCode()+"'>";
         
         form_add += "</form>";
         
         $("#sbmt_btn").append(form_add);
            
         $("#add_cu").submit()
        
    }else if(!add && search){
        
            var search_obj = {name:$("#name").val(),patronymic:$("#patronymic").val(),surname:$("#surname").val(),phone:$("#phone").val(),email:$("#email").val(),role:$("#role").val()};
            
           _searchData(search_obj); 
            
    }else if(!add && !search){
        
        var form_add = "<form id='add_cu' action='index.php?act=update' method='post'><input type='hidden' name='addr' value='"+$("#str_addr").val()+"'>";
         
         form_add += "<input type='hidden' name='surname' value='"+$("#surname").val()+"'><input type='hidden' name='patronymic' value='"+$("#patronymic").val()+"'>";
         
         form_add += "<input type='hidden' name='name' value='"+$("#name").val()+"'><input type='hidden' name='phone' value='"+$("#phone").val()+"'>";
         
         form_add += "<input type='hidden' name='email' value='"+$("#email").val()+"'>";
         
         form_add += "</form>";
         
         $("#sbmt_btn").append(form_add);
            
         $("#add_cu").submit()
            
    }

   
        
});

// Один раз объявляем функцию, потом используем так, как в примере
function exists(obj) {
   return $(obj).length;
}

$("#back").mousedown(function(){
        add = false;   
        $("#tab01").show();
        $("#tab02,#tab03").hide();

});

var role_vision = false;
var alphabet_vision = false;

$("#a_role").mousedown(function(){
    $("#fieldset_filter_alphabet").css('display', 'none');
    if(!role_vision){
        $("#fieldset_filter_roles").css('display', 'block');
    }else{
        $("#fieldset_filter_roles").css('display', 'none');
    }
    role_vision = !role_vision; 
    alphabet_vision = false;
});

$("#a_alphabet").mousedown(function(){
    $("#fieldset_filter_roles").css('display', 'none');
    if(!alphabet_vision){
        $("#fieldset_filter_alphabet").css('display', 'block');
    }else{
        $("#fieldset_filter_alphabet").css('display', 'none');
    }
    alphabet_vision = !alphabet_vision; 
    role_vision = false;
});

$("#a_all").mousedown(function(){
    alphabet_vision = role_vision = false;
    $("#fieldset_filter_alphabet").css('display', 'none');
    $("#fieldset_filter_roles").css('display', 'none');
});



$(".bigger").mousedown(function(){

    var role = this.id;

    $("#customers_tab > tbody").empty().append(customers);           

    $("#customers_tab > tbody > tr").each(function(){

        var id = this.id;
        var td_data = $("#"+id+" > td:eq(2)").text();

        if(role != td_data){
            $("#"+id).remove();
        }

    });
    changeBasename();
});

$(".simbls").mousedown(function(){

    var simbl = this.id;

    $("#customers_tab > tbody").empty().append(customers);           

    $("#customers_tab > tbody > tr").each(function(){

        var id = this.id;
        var td_data = $("#"+id+" > td:eq(1)").text();

        if(simbl != td_data.substr(0,1)){
            $("#"+id).remove();
        }
    });
    changeBasename();
});

$("#a_all").mousedown(function(){

    $("#customers_tab > tbody").empty().append(customers); 
    changeBasename();

});

$("#t01").mousedown(function(){
    $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
    $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
    $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});

    $("#tab01").show();
    $("#tab02,#tab03").hide();

    $("#customers_tab > tbody").empty().append(customers);
    $("#user_insert_submit").val('Сохранить');

    changeBasename();

    add = false;
    search = false;
});

$("#t02").mousedown(function(){
    $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
    $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
    $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});

    $("#tab02").show();
    $("#tab01").hide();

    $("#user_insert_submit").val('Сохранить');

    $.each($("#customers_data input:text"),function(){
        $(this).val('');
    });
    
    $("#role").val('Заказчик');

    add = true;
    search = false;
});

$("#t03").mousedown(function(){

        $("input:text").val("");

        $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
        $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
        $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});

        $("#tab02").show();
        $("#tab01").hide(); 

        $("#user_insert_submit").val('Искать');
        add = false;
        search = true;
});

function _searchData(arg){

        var count = 0;

        $.each(arg, function(){
            if(this.length > 3)count++;
        });
        if(count > 0){
            $.ajax({
                url:'../query/search.php',
                type:'post',
                dataType:'json',
                data:arg,
                success:function(data){

                    if(data.length > 0){
                        $("#customers_tab > tbody").empty();
                        var tab_str = '';
                        $.each(data, function(){
                            tab_str += "<tr id='r_"+this['id']+"'><td class='t-right'>"+this['id']+"</td><td>"+this['surname']+" "+this['name']+" "+this['patronymic']+"</td><td class='smaller'>"+this['phone']+"</td><td class='smaller'><a href='mailto:"+this['email']+"'>"+this['email']+"</a></td><td class='t-center'><a id='e_"+this['id']+"' class='ico-info' title='Смотреть'></a><a id='d_"+this['id']+"' class='ico-delete' title='Удалить'></a></td></tr>";
                        });

                        $("#customers_tab > tbody").append(tab_str); 

                        $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
                        $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                        $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});

                        $("#user_insert_submit").val('Сохранить');
                        add = false;
                        search = false;

                        $("#tab02,#tab03").hide();
                        $("#tab01").show();

                    }else{
                        alert("Запрос вернул пустой результат!");
                    }
                },
                error:function(data){
                    document.write(data['responseText']);
                }
            });
        }else{
            alert("Строка поиска должна содержать не менее трех символов.")
        }
    }

    function _saveData(path, arg){

        $.ajax({
            url:path,
            type:'post',
            dataType:'json',
            data:arg,
            success:function(data){
                
                var email = data['customer']['email'];

                var html_str = "<a href='mailto:"+email+"'>"+email+"</a>";
              
                console.log(data['query']);
//                document.write(data['query']);
                $("#tab01").show();
                $("#tab02,#tab03").hide();
                if(data['act'] == 'update'){

                $("#r_"+$("#uid").val()+" td:eq(1)").text(data['customer']['surname']+" "+data['customer']['name']+" "+data['customer']['patronymic']);
                $("#r_"+$("#uid").val()+" td:eq(3)").text(data['customer']['phone']);
                $("#r_"+$("#uid").val()+" td:eq(4)").html(html_str);

                $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'});
                $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});

                }else if(data['act'] == 'add'){

                    $("#customers_tab > tbody").append("<tr id='r_"+data['customer']['id']+"'><td class='t-right'>"+data['customer']['id']+"</td><td>"+data['customer']['surname']+" "+data['customer']['name']+" "+data['customer']['patronymic']+"</td><td class='smaller'>"+data['customer']['role']+"</td><td class='smaller'>"+data['customer']['phone']+"</td><td class='smaller'><a href='mailto:"+data['customer']['email']+"'>"+data['customer']['email']+"</a></td><td class='smaller'>"+data['customer']['creation_time']+"</td><td class='t-center'><a id='e_"+data['customer']['id']+"' class='ico-info' title='Смотреть'></a></td></tr>");         

                    var out_arg = new Array();

                    $.each(d_bases, function(){

                        var tmp = {db_name:this['db_name'],login:this['login'],password:this['password'],addr:this['addr'],charset:this['charset'],name:$("#name").val(),patronymic:$("#patronymic").val(),surname:$("#surname").val(),phone:$("#phone").val(),phone2:$("#phone2").val(),fax:$("#fax").val(),email:$("#email").val(),postcode:$("#postcode").val(),address:$("#address").val(),comments:$("#comments").val(),tags:$("#tags").val(),role:$("#role").val()};

                        out_arg.push(tmp);
                    });

    //                _addBases(out_arg);
                }                    
            },
            error:function(data){
                document.write(data['responseText']);                     
            }
        });
    }

    function _addBases(arg){
    var num = 1;
    $.each(arg, function(){
        var obj = this;

        $.ajax({
            url:'../action/add_to_other_bases.php',
            type:'post',
            dataType:'json',
            data:obj,
            success:function(data){

//                        //console.log(data);
            },
            error:function(data){
                console.log(data['responseText']);
            }
        });
        num++;
    });            
    }

function _readCustomer(arg){
    $.ajax({
        url:'../query/read_customer.php',
        type:'post',
        dataType:'json',
        data:arg,
        success:function(data){

            var str_head = '';
            var str_body = '';
            var n = 0;

    $.each(data, function(index, d){

            if(this != ''){}
                str_head += "<th class='t-center'>"+index+"</th>";
                str_body += "<td class='t-center'>"+this+"</td>";                
                n++;

    });
    
    str_head = "<tr>"+str_head+"</tr>";
    str_body = "<tr id='b0'>"+str_body+"</tr>";

                    $("#сid").val(data['id']);
                    $("#surname").val(data['surname']);
                    $("#name").val(data['name']);
                    $("#patronymic").val(data['patronymic']);
                    $("#phone").val(data['phone']);
                    $("#email").val(data['email']);
                    $("#role").val(data['role']);

                $("#customer_data thead").empty().append(str_head);
                $("#customer_data tbody").empty().append(str_body);

                    $("#tab01").hide();
                    $("#p-filter").hide();
                    $("#tab02,#tab03").show();
                    $("#cu_f, #cu_h").css('display', 'none');
                    $("#customer_data").css({'padding':'10px'});

                    $("#t01 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                    $("#t02 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% 0px transparent','color':'#fff','font-weight':'bold'}); 
                    $("#t03 span").css({'background':'url("../design/tabs-r.gif") no-repeat scroll 100% -100px transparent','color':'rgb(48, 48, 48)','font-weight':'normal'});
                    
                    var b_scale = 1*(w_content/$("#customer_data").width());
                    
                    $("html").css({ zoom: b_scale, transform: "scale("+b_scale+")", transformOrigin: "0 0" });
                    $("html").css({"-moz-transform": "scale("+b_scale+")"});
	
                    if ($.browser.msie) {

                            $("body").css({ zoom: b_scale, transform: "scale("+b_scale+")", transformOrigin: "0 0" });	
                            if ($.browser.version == 8.0) {
                                    $("body").css({ zoom: b_scale, transform: "scale("+b_scale+")", transformOrigin: "0 0" });
                            }

                    }

                    if ($.browser.opera) {
                            $("html").css({"-o-transform": "scale("+b_scale+")"});
                    }
            },
            error:function(data){
                document.write(data['responseText']);
            }
        });
    }

    function changeBasename(){
        $.each($("#customers_tab tbody tr"),function(i){
            var id = this.id;
            var td_data = $("#"+id+" > td:eq(5)").text();
    //                $("#"+id+" > td:eq(5)").text(d_bases[(td_data - 1)]['db_name']);
        });
        return false;
    }
    
    function getCode(){
        
        var bukoff_arr = new Array('a','s','d','f','g','h','j','k','l','q','w','e','r','t','y','u','i','o','p','z','x','c','v','b','n','m','Z','X','C','V','B','N','M','A','S','D','F','G','H','J','K','L','Q','W','E','R','T','Y','U','I','O','P');

        var string = '';

//        var numr = Math.floor(Math.random()*(51));

        for(i = 0;i<8;i++){

            num = Math.floor(Math.random()*(51));

            string += bukoff_arr[num];

        }
        return string;
    }
});


