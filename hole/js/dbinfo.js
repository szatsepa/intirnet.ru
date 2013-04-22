$(document).ready(function(){
    
    $("#db_tab tbody tr td input:checkbox").click(function(){
        if($(this).attr('checked')){
          console.log("V PIZDU");  
        }else{
           console.log("Na HUY");  
        }
    });
    
    function actionWithT(){
     
        return false;
    }
});


