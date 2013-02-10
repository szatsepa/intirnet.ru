$(document).ready(function(){
    
    console.log('div_c '+$("div#content.box").width());
    console.log('div '+$("#tab01").width());
    console.log('tab '+$("#db_tab").width());
    
    
    var size_tab = $("#db_tab").width();
    var size_div = $("#tab01").width();
    
    if(size_div < size_tab){
        $("#tab01").width(size_tab);
        $("div#content.box").width(size_tab + 20);
    }
    
    console.log('div_c '+$("div#content.box").width());
    console.log('div '+$("#tab01").width());
    console.log('tab '+$("#db_tab").width());
});


