$(document).ready(function(){
    
    $("#tab01").css({'width':$("#content").width()});

    $("#tab02").show().css({'text-align':'center'});
    
    if($("#is_select").val() == 0){
        $("#myTabs ul li").empty();
    }
    var tyts = false;
    
    $("select.common").click(function(){
        if(tyts){
            var str = $("#"+this.id+" option:selected").val();
            if(str != '0'){
               var obj = $(this).css({'color':'green','font-weight':'bold'});
            }            
        }
        tyts = !tyts;
    });
    
    $("#save_fields").click(function(){
        
        var output = {'db_id':$("#db_i").val(),'tablename':$("#db_t").val()};
        
        $.each($("#db_tab tbody tr"),function(index){
            output[$(this).children('td:eq(0)').text()] = $(this).children('td:eq(1)').children('select').children('option:selected').val();
        });
        
        console.log(output);
    });
        
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

   
});


