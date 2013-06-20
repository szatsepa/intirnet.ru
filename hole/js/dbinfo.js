$(document).ready(function(){
    
    $("#chap").append("Список таблиц базы данных - <strong>\""+$("#db_n").val()+"\"</strong>")
    $("#tab01").css({'margin-left':'27px'});
    
    $("#db_tab tbody tr td input:checkbox").click(function(){
        
          var obj = $(this).parent().parent();
          var tmp = $(obj).find("a").text().split('-');
          var table = tmp[1].replace(/"/g, ''); 

          var str = $(obj).find("p").text();
          var fields = str.split(';');
          var f_arr = new Array();

          $.each(fields, function(index){
              var tmp = fields[index].replace(/"/g, '');
              tmp = tmp.replace(/^[\s\xa0]+|[\s\xa0]+$/g, "");
              f_arr.push(tmp);
          });

          f_arr.pop();
          
        if($(this).attr('checked')){
            
          addTable(table,f_arr,obj);
          
        }else{
           delTable(table, obj); 
        }
    });
    
    function addTable(table, fields, obj){
        
        var output = {'table':table,'fields':fields,'dbi':$("#db_i").val()};
        
        var trow = obj;
        
        console.log(output);
        
        $.ajax({
            url:'action/add_new_table.php',
            type:'post',
            dataType:'json',
            data:output,
            success:function(data){
                if(data['rows']>0){
                    $(trow).css({'background-color': '#afffaf'});
                }
            },
            error:function(data){
                console.log(data['responseText']);
            }
        });
        
        return false;
    }
    
    function delTable(table, obj){
        
        var output = {'table':table,'dbi':$("#db_i").val()};
        
        var trow = obj;
        
        $.ajax({
            url:'action/delete_table.php',
            type:'post',
            dataType:'json',
            data:output,
            success:function(data){
                console.log(data);
                if(data['rows']>0){
                    $(trow).css({'background-color': '#ffffff'});
                }
            },
            error:function(data){
                console.log(data['responseText']);
            }
        });
        
        return false;
    }
    
    function actionWithT(){
     
        return false;
    }
});


