$(document).ready(function(){
    
    $("#tab01").css({'width':$("#content").width()});

    $("#tab02").show().css({'text-align':'center'});
        
        if($("#db_tab").width()>$("#content").width()){
            var b_scale = ($("#content").width()/$("#db_tab").width())+0.00;
        }
                    
        $("#tab01").css({zoom: b_scale, transform: "scale("+b_scale+")", transformOrigin: "0 0"});
        $("#tab01").css({"-moz-transform": "scale("+b_scale+")"});

        if ($.browser.msie) {

                $("#tab01").css({zoom: b_scale, transform: "scale("+b_scale+")", transformOrigin: "0 0"});	
                if ($.browser.version == 8.0) {
                        $("#tab01").css({zoom: b_scale, transform: "scale("+b_scale+")", transformOrigin: "0 0"});
                }

        }

        if ($.browser.opera) {
                $("#tab01").css({"-o-transform": "scale("+b_scale+")"});
        }

    var fields_select = "";


    fields_select = "<input type='checkbox' name='field'>&nbsp;<select class='field_select'>";
    
        $.each($("#db_tab thead tr th"), function(){

            fields_select += "<option value='"+$(this).text()+"'>"+$(this).text()+"</option>";
        });

        fields_select += "</select>";
        
    if($("#is_table").val() == 0 || $("#is_table").val() == ''){ 

            $.each($("#customer_t tbody tr td"), function(){

                    $(this).html(fields_select);

            });
        }else{

            $("#save_fields").val("Присоединить таблицу к базе");

            $("#save_fields").attr('id', 'save_customers');
        }
        
    $("#save_customers").live('click',function(){
                
        var output = {'db_id':$("#db_i").val(), 'tablename':$("#db_t").val(), 'charset':$("#db_c").val(),'cdata':$("#customers").val()};
        
        $.ajax({
            url:'../action/add_customers.php',
            type:'post',
            dataType:'json',
            data:output,
            success:function(data){
                if(data['query']>0){
                    $("#tab02").append("<span><p><strong>В таблицу добавлено "+data['query']+" записей!</strong></p></span>").css({'background-color':'#afdf6f'});
                    
                }
                _sincro({'tablename':$("#db_t").val()});
            },
            error:function(data){
                console.log("ERROR "+data['responseText']);
            }
        });
    });
    
    $("#save_fields").mousedown(function(){
        
        
        
        var str_out = '{';
        
        $.each($("#customer_t tbody tr td input:checkbox:checked"), function(){
            
            var obj = $(this).siblings();
            
            var prnt = $(this).parent("td");
            
            str_out += '"'+$("#customer_t thead tr th:eq("+prnt.index()+")").text()+'":"'+$(obj).val()+'",'
            
        });
        
        str_out = str_out.substr(0,str_out.length -1)+'}';
        
        var out_obj = {"str_json":str_out,"db_id":$("#db_i").val(),'tablename':$("#db_t").val()};
        
        $.ajax({
            url:'../action/add_fields_in_db.php',
            type:'post',
            dataType:'json',
            data:out_obj,
            success:function(data){
                 if(data['out']>0){
                    var str_form = "<form id='f_reload' action='index.php?act=table' method='post'>";
                        str_form += "<input type='hidden' name='db_name' value='"+$("#db_n").val()+"'>";
                        str_form += "<input type='hidden' name='db_server' value='"+$("#db_s").val()+"'>";
                        str_form += "<input type='hidden' name='db_tablename' value='"+$("#db_t").val()+"'>";
                        str_form += "<input type='hidden' name='db_login' value='"+$("#db_l").val()+"'>";
                        str_form += "<input type='hidden' name='db_pwd' value='"+$("#db_p").val()+"'>";
                        str_form += "<input type='hidden' name='db_charset' value='"+$("#db_c").val()+"'>";
                        str_form += "</form>";
                        
                        $("#tab02").append(str_form);
                        $("#f_reload").submit();
                 }
            },
            error:function(data){
                console.log(data['responseText']);
            }
        });
    });
     

    $("#find_btn").click(function(){
        
        var str_form = "<form id='find_f' action='index.php?act=table&find=1' method='post'>";
        str_form += "<input type='hidden' name='db_name' value='"+$("#db_n").val()+"'>";
        str_form += "<input type='hidden' name='db_server' value='"+$("#db_s").val()+"'>";
        str_form += "<input type='hidden' name='db_tablename' value='"+$("#db_t").val()+"'>";
        str_form += "<input type='hidden' name='db_login' value='"+$("#db_l").val()+"'>";
        str_form += "<input type='hidden' name='db_pwd' value='"+$("#db_p").val()+"'>";
        str_form += "<input type='hidden' name='db_charset' value='"+$("#db_c").val()+"'>";
        str_form += "<input type='hidden' name='db_field' value='"+$("#fields option:selected").val()+"'>";
        str_form += "<input type='hidden' name='str_find' value='"+$("#find_string").val()+"'>";
        str_form += "</form>";
        
        $("#tab02").append(str_form);
        $("#find_f").submit();
        
    });
    
    function _sincro(tablename){
        $.ajax({
            url:'../action/sinchro.php',
            type:'post',
            dataType:'text',
            data:{tablename:tablename},
            success:function(data){
                $("#tab02").append(data);
//                $.each(data, function(index){
//                    $.each(this, function(index){
//                        if(index != 'tables'){
//                            $("#tab02").append("<span id='log'><p>"+index+" =>> "+this+"</p></span>");
//                        }else{
//                           $.each(this,function(index){
//                               $.each(this,function(){
//                                   if(typeof(this)=='number'){
//                                       $("#tab02").append("<span id='log'><p>  2 - "+index+" =>> "+this+"</p></span>");
//                                   }else{
//                                       $.each(this,function(index){
//                                           $("#tab02").append("<span id='log'><p>  2 - "+index+" =>> "+this+"</p></span>");
//                                       });
//                                   }
//                                   
//                               });                               
//                           }) ;
//                        }
//                        
//                    });
//
//                });
                    
               
                
            },
            error:function(data){
                document.write(data['responseText']);
            }
        });
    }
    
});


