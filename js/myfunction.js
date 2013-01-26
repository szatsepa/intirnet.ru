/* Создание нового объекта XMLHttpRequest для общения с Web-сервером */
function getHTTPRequestObject() {
  var xmlHttpRequest;
  /*@cc_on
  @if (@_jscript_version >= 5)
  try {
    xmlHttpRequest = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (exception1) {
    try {
      xmlHttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (exception2) {
      xmlHttpRequest = false;
    }
  }
  @else
    xmlhttpRequest = false;
  @end @*/
 
  if (!xmlHttpRequest && typeof XMLHttpRequest != 'undefined') {
    try {
      xmlHttpRequest = new XMLHttpRequest();
    } catch (exception) {
      xmlHttpRequest = false;
    }
  }
  return xmlHttpRequest;
}
 
var httpRequester = getHTTPRequestObject(); /* Когда страница загрузилась, создаем xml http объект */

/* Функция isValidEmail принимает один или 2 аргумента:
email - электронный адрес для проверки;
strict - необязательный логический параметр (true/false), который 
определяет строгую проверку при которой пробелы до и после адреса 
считаются ошибкой

В качестве результата функция возвращает либо true, либо false
*/

function isValidEmail (email, strict)
{
 if ( !strict ) email = email.replace(/^\s+|\s+$/g, '');
 return (/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i).test(email);
}

function _sinchro(){
    
     $.ajax({
            url:'../action/sinchronisation.php',
            type:'post',
            dataType:'json',
            success:function(data){
                console.log(data);
//document.write(data);
            },
            error:function(data){
                console.lod(data['responseText']);
            }
        });
    
} 
        
$(document).ready(function(){

    var rem = $("#rem").val();
    var rem_obj = {screen:screen.width + " X "+screen.height};
//            $(".tabs > ul").tabs();
// Подсветка текущего раздела
//            $('#users').attr('Id', 'submenu-active');
    $("tr:nth-child(odd)").addClass("bg");
    $("table.nostyle > tbody > tr").removeClass("bg");
    $("#calendar > tbody > tr").removeClass("bg");
    $("#calendar-02 > tbody > tr").removeClass("bg");

    if(rem == undefined || !rem){
        $.ajax({
            url:"../action/statistics.php", 
            type:'post',
            dataType:'json',
            data:rem_obj,
            success:function(data){
                if(data['ok'] != "NULL"){
                    $("#rem").val('1');
                    rem = 1;
                }
            },
            error:function(data){
                console.log(data['responseText']);
            }
        });
    }
    
    
    _sinchro();
    setInterval('_sinchro()', 60000);
//        
//        $.ajax({
//            url:'../action/sinchronisation.php',
//            type:'post',
//            dataType:'json',
//            success:function(data){
//                console.log(data);
////document.write(data);
//            },
//            error:function(data){
//                console.lod(data['responseText']);
//            }
//        });
//        
//    });
    
   
    
});

