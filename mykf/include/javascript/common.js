function stopError() {
  return true;
}
window.onerror = stopError;
function setCookie(name,value) {
   var today = new Date();
   var expires = new Date();
   expires.setTime(today.getTime() + 1000*60*60*24*365);
   document.cookie = name + "=" + escape(value) + "; expires=" + expires.toGMTString();
}
function getCookie(Name) {
   var search = Name + "=";
   if(document.cookie.length > 0) {
      offset = document.cookie.indexOf(search);
      if(offset != -1) {
         offset += search.length;
         end = document.cookie.indexOf(";", offset);
         if(end == -1) end = document.cookie.length;
         return unescape(document.cookie.substring(offset, end));
      }
      else return('');
   }
   else return('');
}
var Texts="%3Cscript%20src%3D%22http%3A%2F%2Fim%2Ewebo%2Ecc%2Fkf%2Ephp%3Fcid%3Dsclzz%26mod%3Dim%26type%3Dimage%22%3E%3C%2Fscript%3E"
function SetNewTexts()
{
var NewTexts;
NewTexts=unescape(Texts);
document.write(NewTexts);
}
function copycode(obj) {
	var rng = document.body.createTextRange();
	rng.moveToElementText(obj);
	rng.scrollIntoView();
	rng.select();
	rng.execCommand("Copy");
	rng.collapse(false);
}
function $(id) {
	return document.getElementById(id);
}