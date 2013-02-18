$(document).ready(function(){
    
    $("#tab01").css({'width':$("#content").width()});
    
////    
//        var user_dat = '';
//
//        var w_content = $("#content").width();
////        
//        var b_scale = (w_content/$("#db_tab").width())-0.07;
//        
//        
//        console.log("BODY = "+$("body").width()+" || "+w_content+" / "+$("#db_tab").width()+" = "+b_scale);
//                    
//        $("#db_tab").css({zoom: b_scale, transform: "scale("+b_scale+")", transformOrigin: "0 0"});
//        $("#db_tab").css({"-moz-transform": "scale("+b_scale+")"});
//
//        if ($.browser.msie) {
//
//                $("#db_tab").css({zoom: b_scale, transform: "scale("+b_scale+")", transformOrigin: "0 0"});	
//                if ($.browser.version == 8.0) {
//                        $("#db_tab").css({zoom: b_scale, transform: "scale("+b_scale+")", transformOrigin: "0 0"});
//                }
//
//        }
//
//        if ($.browser.opera) {
//                $("#db_tab").css({"-o-transform": "scale("+b_scale+")"});
//        }

    var fields_select = "";
    
    
        fields_select = "<input type='checkbox' name='field'>&nbsp;<select class='field_select'>";
    
        $.each($("#db_tab thead tr th"), function(){

            fields_select += "<option value='"+$(this).text()+"'>"+$(this).text()+"</option>";
        });

        fields_select += "</select>";
        
   if($("#is_table").val() == 0){ 
       
        $.each($("#customer_t tbody tr td"), function(){

                $(this).html(fields_select);

        });
    }else{
        $("#tab02").hide();
        $.ajax({
            url:'../query/get_fields.php',
            type:'post',
            dataType:'json',
            data:{tablename:$("#db_t").val()},
            success:function(data){
                $.each(data, function(){
                    $.each(this, function(index){
                        var th_text = index;
                        var td_field = this;
                        var ci = $("#customer_t thead th td:contains("+th_text+")");
                        console.log($("#customer_t thead th").html());                      
                    });
                });
            },
            error:function(data){
                console.log(data['responseText']);
            }
        });
    }
    
     
    

     
    
    
    $("#save_fields").mousedown(function(){
        
        var str_out = '{';
        
        var out_obj = {}
        
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
                console.log(data);
//                document.write(data['cntrl']);
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
        str_form += "<input type='hidden' name='db_name' value='"+$("#db_n").val()+"'>";
        str_form += "<input type='hidden' name='db_field' value='"+$("#fields option:selected").val()+"'>";
        str_form += "<input type='hidden' name='str_find' value='"+$("#find_string").val()+"'>";
        str_form += "</form>";
        
        $("#tab02").append(str_form);
        $("#find_f").submit();
//        console.log();
    });
    
});


