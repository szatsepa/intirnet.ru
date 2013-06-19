$(document).ready(function(){
    
    $("#tab01").css({'width':$("#content").width()});

    $("#tab02").show().css({'text-align':'center'});
    
    $("#myTabs ul li").empty();
   
    var tyts = false;
    
    var edit = false;
    
    var obj_edit = {};
    
    $("select.common").click(function(){
        
        if(tyts){
            if($(this).find("option:selected").val() != '0'){
                
               $(this).css({'color':'green','font-weight':'bold'});
            }
            
            if(edit && $(this).parent().index()==2){
                
                editField($(this).parent().parent());
                
                
            }                      
        }
        
        if(edit){
            $("#tab02").hide();
        }
        
        tyts = !tyts;
        
    });
    
    $("#save_fields").click(function(){
        
        edit = false;
        
        var output = {'db_id':$("#db_i").val(),'tablename':$("#db_t").val(),'fields':{}};
        
        $.each($("#db_tab tbody tr"),function(index){
            output['fields'][$(this).children('td:eq(0)').text()] = $(this).children('td:eq(1)').children('select').children('option:selected').val();
        });
        
        updateSynonym(output);
        
    });
    
    $("#db_tab tbody tr td a").live('click',function(){
        
        edit = true;
        
        var id = this.id;
        
        id = id.substr(2);
        
        obj_edit = $(this).parent().parent();
        
        $($(this).parent()).append($("#db_tab tbody tr td select:eq(0)").clone(true, true));
        
        $(this).remove();
        
    }).css({'cursor':'pointer'});
        
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
        
        function editField(obj){
            
            var field = {};
            
            field[$(obj).find('td:eq(0)').text()] = $(obj).find('td:eq(2) select option:selected').val();
            
            var output = {'db_id':$("#db_i").val(),'tablename':$("#db_t").val(),'fields':field, 'edit':'yes'};
            
//            console.log(output);
            
            updateSynonym(output);
            
            return false;
        }
        
        function updateSynonym(output){
            
            $.ajax({
                url:'action/synonym_in_minde.php',
                type:'post',
                dataType:'json',
                data:output,
                success:function(data){
                    console.log(data);
                    if(data['query']>0){
                        if(!edit){
                             $.each($("#db_tab tbody tr"),function(index){

                                var this_color = $(this).find('td:eq(1) select').css('color');

                                if(this_color != undefined){

                                    var value = $(this).find('td:eq(1) select option:selected').val();

                                    if(this_color.toString() ==='rgb(0, 128, 0)'){
                                       $(this).css({'background-color':'#afffaf'}); 
                                       $(this).children('td:eq(1)').empty().text(value);
                                       $(this).children('td:eq(2)').append("<a id='e_"+$(this).find('td:eq(0)').text()+"' class='ico-edit' title='Редактировать'></a>");
                                    }
                                }
                            });
                        }else{
                            var value = $(obj_edit).find('td:eq(2) select option:selected').val();
                            $(obj_edit).children('td:eq(1)').text(value);
                            $(obj_edit).children('td:eq(2)').empty().append("<a id='e_"+$(this).find('td:eq(0)').text()+"' class='ico-edit' title='Редактировать'></a>");

                        }
                        
                        $("a.ico-edit").css({'cursor':'pointer'});
                    }
                    
                    $("#tab02").show();
//                    $("#tab02").append(data['string']);
                },
                        error:function(data){
                            document.write(data['responseText']);
                        }
            });
            
            _complete();
            
            return false;
        }
        
        function _complete(){
            $.ajax({
                url:'action/check_complete.php',
                cache:false,
                success:function(data){
//                    console.log(data);
                },
                        error:function(data){
                    console.log(data['responseText']);
                        }
            });
        }
   
});


