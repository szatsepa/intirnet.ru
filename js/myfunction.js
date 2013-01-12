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


