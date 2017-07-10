function $(id) {
	return document.getElementById?document.getElementById(id):document.all?d.all[id]:document.layers[id];
}
var JS_URL_TMP=homepage+'getdata/content/client.php?datatype=get';
JS_URL_TMP+='&action=update';
JS_URL_TMP+='&cid='+cid;
JS_URL_TMP+='&im_wid='+wid;
JS_URL_TMP+='&im_sessionid='+sessionid;
JS_URL_TMP+='&im_systemlanguage='+(navigator.systemLanguage?navigator.systemLanguage:navigator.language);
JS_URL_TMP+='&im_color='+screen.colorDepth;
JS_URL_TMP+='&im_screensize='+screen.width + '*' + screen.height;
JS_URL_TMP+='&im_charset='+document.charset;
JS_URL_TMP+='&im_pageurl='+escape(window.location.href);
JS_URL_TMP+='&im_referer='+escape(window.document.referrer);
document.writeln('<scr'+'ipt id="eqmk_kefu_code_js" src="'+JS_URL_TMP+'"></scr'+'ipt>');
function fssshow(){
var divId=document.getElementById("fss");
if(document.all) {	
	divId.style.display="block";
}else {
divId.style.display="inline";	
}
}
function fssclose(){
document.getElementById("fss").style.display="none";
}
function getkeyCode(e)
{
var keynum = "";
if(isIE) // window.event IE
{
    keynum = e.keyCode;
}
else // Netscape/Firefox/Opera
{
    keynum = e.which;
}
return keynum;
}

function input_onkeydown(e){
var postkey=getSelectedRadioValue("fsf");
 if(isIE) {
	 xx=event;
 }else{
	 xx=e;
 }
  if (postkey==1){
  if(!(xx.ctrlKey) && getkeyCode(xx)==13){
    e.returnValue=false;
    send();
  }
	return true;
	}
  if (postkey==2){
  if(xx.ctrlKey && getkeyCode(xx)==13){
    e.returnValue=false;
    send();
  }
	return true;
	}
}
function getSelectedRadioValue(radioName)
{
var radioObj = document.getElementsByName(radioName); 
var radioValue;

if(radioObj.length){
for(var i = 0; i < radioObj.length; i++)
{

   if(radioObj[i].checked)
   {  
    radioValue = radioObj[i].value;
   }
}
}else{
      if(radioObj){
         radioValue = radioObj.value;
      }else{
    radioValue = 0;
   }
}
return radioValue;
}

var timer1=null;
function send(){
  var message=$('inputbox').value;
  message=message.replace(/\n/g,'');
	message=message.replace(new RegExp('<scr'+'ipt[^>]*?>.*?</scr'+'ipt>','g'), "") ;
	message=message.replace(new RegExp('\<\!\-\-.*?\-\-\>','g'), "") ;
	message=message.replace('\<\!\-\-', "") ;
  if(message.length<1){
    $('inputbox').value='';
    $('inputbox').focus();
    return false;
  }
  var tmp='action=send';
  tmp+='&cid='+cid;
  tmp+='&wid='+WorkerToken;
  tmp+='&wname='+encodeURI(wnickname);
  tmp+='&uid='+uid;
  tmp+='&content1='+encodeURI(message).replace(/\+/g,'%2B');
  var x=new Ajax('HTML','');
  PrintChat("<div class=\"im_to\">"+cnickname+"  " + Now() + "</div>\r\n<div class=\"im_content\">" + ubbtohtml(message) + "</div>\r\n");
  $('inputbox').value='';
  IsBusy=true;
  x.post(homepage+'getdata/content/client.php',tmp,function(s){
    if(s.indexOf('&fdata=Y')!=-1){
      $('inputbox').value='';
      $('inputbox').focus();
	document.title =webtitlename;
    }else{
      PrintChat("<div class=\"im_info\">Error!</div>\r\n");
    }
    IsBusy=false;
  });
}
function selfaq(id){
  var tmp='action=faq';
  tmp+='&cid='+cid;
  tmp+='&fid='+id;
  tmp+='&uid='+uid;
  try{
  $('showbox').removeChild($('EqmkFaq'));
  }catch(e){}
  var x=new Ajax('HTML','');
  x.post(homepage+'getdata/content/client.php',tmp,function(s){
    if(s.indexOf('&fdata=')!=-1){
      PrintChat('<div id="EqmkFaq">'+s.split('&fdata=')[1]+'</div>');
    }else{
      alert(Lang['senderror']);
    }
  });
}
function SelWorker(wid_){
  for(i=0;i<WorkerList.length;i++){
    if(WorkerList[i][0]==wid_){
      WorkerToken=wid_;
      WorkerIndex=i;
      wnickname=WorkerList[i][1];
      $('workername').innerHTML=WorkerList[i][1];
      $('w_nickname').innerHTML=WorkerList[i][1];
      $('w_sex').innerHTML=WorkerList[i][4];
      $('w_city').innerHTML=WorkerList[i][5];
      $('w_phone').innerHTML=WorkerList[i][6];
      $('w_email').innerHTML=WorkerList[i][3];
      $('w_qq').innerHTML=WorkerList[i][2];
      $('w_content').innerHTML=WorkerList[i][7];
      return;
    }
  }
}
function changeKefu(){
  try{$('showbox').removeChild($('EqmkKefuList'));}catch(e){}
  var tmp='<ul id="EqmkKefuList">';
  for(i=0;i<WorkerList.length;i++){
    tmp+='<li onclick="SelWorker(\''+WorkerList[i][0]+'\')">'+WorkerList[i][1]+'</li>';
  }
  tmp+='</ul><div style="clear:both"></div>';
  PrintChat(tmp);
  CloseAllDiv();
}
function UpdateData(){
  var tmp='action=get';
  tmp+='&cid='+cid;
  tmp+='&wid='+wid;
  tmp+='&uid='+uid;
  try{
  var x=new Ajax('HTML','');
  x.post(homepage+'getdata/content/client.php',tmp,function(s){
    if(s.indexOf('&fdata=')!=-1){
      var t=s.split('&fdata=');
      if(t[1]!=''){
        myFlash_DoFSCommand('get',t[1]);
      }
    }
  });
  }catch(e){}
}
//if(online){
  window.setInterval("UpdateData()",1600);
//}
function AutoTalk(){
  PrintChat("<div class=\"im_from\">"+wnickname+"  " + Now() + "</div>\r\n<div class=\"im_content\">"+tip+"</div>");
}
function window_onload(){
document.title =webtitlename;
changeKefu();
  if(online){
    setTimeout('AutoTalk()',3000);
  }else{
    PrintChat("<div>"+tip+"</div>");
  }
  var tmp='<ul>';
  for(var i=0;i<smileys.length;i++){
    tmp+='<li id="t_'+i+'" onclick="sel_smiley_g('+i+')">'+smileys[i][0]+'</li>';
  }
  tmp+='</ul>';
  $('s_title').innerHTML=tmp;
  InfoHeight=$('coC').parentNode.offsetHeight-2;
  $('inputbox').focus();
}
function saveas() {
  try {
    var savestyle='<style type="text/css"> <!--body{margin: 0px; padding: 0px 0px 0px 0px; border: 0px;FONT-SIZE: 9pt; FONT-FAMILY: Tahoma;}.im_to{color:#008040;height:18px;line-height:18px;}.im_from{color:#0000ff;height:18px;line-height:18px;}.im_content{color:#000000;padding-left:10px;}.im_tip{color:#0000ff;}.error{color:#7982c1;height:18px;line-height:18px;padding-left:20px;background:url(im_info.gif) no-repeat 2px 1px;}--></style>';
    var time=new Date();
    var filename=time.toLocaleDateString();
    filename=filename+" "+(document.title.toString().replace(/\s/g,'_'))+".htm";
    var winSave=window.open('about:blank','_blank','top=10000');
    winSave.document.open("text/html","utf-8");
		winSave.document.write("<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><base target=\"_blank\">"+savestyle+"</head><body>"+$("showbox").outerHTML+"</body></html>");
    winSave.document.execCommand ("SaveAs",true,filename);
    winSave.close();
  }
  catch(e){}
    CloseAllDiv();
}
function sel_smiley_g(index){
  if(index==-1){
    index=cursmiley;
  }
  for(var i=0;i<smileys.length;i++){
    if(i==index){
      $('t_'+i).className='sel';
      var tmp='<ul>';
      for(var k=smileys[i][2];k<=smileys[i][3];k++){
        tmp+='<li><img src="images/smiley/'+smileys[i][1]+'/s_'+smileys[i][1]+'_'+k+'.gif" onclick="sel_smiley('+k+')" /></li>';
      }
      tmp+='</ul>';
      $('s_content').innerHTML=tmp;
      $('smiley').style.display='';
      var t=-$('s_content').offsetHeight-$('inputdiv').offsetHeight-$('toolbardiv').offsetHeight-$('dialogtitle').offsetHeight-4;
      if(isIE){
        $('smiley').style.pixelTop=t;
      }else{
        $('smiley').style.top=t+"px";
      }
      cursmiley=index;
    }else{
      $('t_'+i).className='';
    }
  }
  CloseAllDiv();
  $('smiley').style.display='';
}
function sel_smiley(index){
  $('inputbox').value+=':'+smileys[cursmiley][1]+'_'+index;
  CloseAllDiv();
}
function ubbtohtml(fdata){
  fdata=fdata.replace(new RegExp(':([a-zA-Z]+)_([0-9]{1,2})','g'),'<img src="images/smiley/$1/s_$1_$2.gif">');
  fdata=fdata.replace(new RegExp('\\[url\\](www.|http:\/\/){1}([^\[\"\']+?)\\[\/url\\]','gi'),'<a href="$1$2" target="_blank">$1$2</a>');
  fdata=fdata.replace(new RegExp('\\[img\\]([^\[\"\']+?)\.(gif|jpg|bmp|png){1}\\[\/img\\]','gi'),'<img src="$1.$2" />');
  return fdata;
}
function inserturl(){
	var url = prompt(Lang['inserturl'],'http://');
	if(url==null || url=='' || url=='http://'){
    $('inputbox').focus();
    return false;
	}
  $('inputbox').value+='[url]'+url+'[/url]';
  $('inputbox').focus();
}
function insertimageurl(){
  CloseAllDiv();
  $('imagediv').style.display='';
}
function getimage(e){
  var keycode=isIE==1?e.keyCode:e.which;
  if(keycode==13){
    e.returnValue=false;
    if($('insertimage').value.length<1)return;
    $('inputbox').value+='[img]'+$('insertimage').value+'[/img]';
    $('insertimage').value="";
    CloseAllDiv();
  }
}
function getimage2(){
  if($('insertimage').value.length<1)return;
  $('inputbox').value+='[img]'+$('insertimage').value+'[/img]';
  $('insertimage').value="";
  CloseAllDiv();
}
function insertpic(){
	var url = prompt(Lang['insertpic'],'http://');
	if(url==null || url=='' || url=='http://'){
    $('inputbox').focus();
    return false;
	}
  $('inputbox').value+='[img]'+url+'[/img]';
  $('inputbox').focus();
}
function CloseAllDiv(){
  $('smiley').style.display='none';
  $('upload').style.display='none';
  $('imagediv').style.display='none';
}
function window_onunload(){
  myinfo.wid.value=wid;
  myinfo.submit();
  if(closetip.length>0){
    alert(closetip);
  }
}
function PrintChat(str,islog){
	$('showbox').innerHTML += str;
	ScrollControl();
}
function ScrollControl(){
	$('showbox').scrollTop+=50000;
}
function Now(){
	var date = new Date();
	H_=date.getHours().toString();
	i_=date.getMinutes().toString();
	s_=date.getSeconds().toString();
	if(i_.length==1)i_="0"+i_;
	if(s_.length==1)s_="0"+s_;
	return H_+":"+i_+":"+s_;
}
function NewTime(d){
	var date = new Date(d.getTime()+TimeAdd);
	//Y_=date.getYear().toString();
	//m_=date.getMonth().toString();
	//d_=date.getDay().toString();
	H_=date.getHours().toString();
	i_=date.getMinutes().toString();
	s_=date.getSeconds().toString();
	//if(m_.length==1)m_="0"+m_;
	//if(d_.length==1)d_="0"+d_;
	if(H_.length==1)H_="0"+H_;
	if(i_.length==1)i_="0"+i_;
	if(s_.length==1)s_="0"+s_;
	//return Y_+"-"+m_+"-"+d_+" "+H_+":"+i_+":"+s_;
	return H_+":"+i_+":"+s_;
}
function windowquake(){
  var tmp='action=tmpInput';
  tmp+='&cid='+cid;
  tmp+='&wid='+wid;
  tmp+='&uid='+uid;
  tmp+='&content1=EQMK_COM_WINDOW_QUAKE';
  var x=new Ajax('HTML','');
  x.post(homepage+'getdata/content/client.php',tmp,function(s){
    PrintChat("<div class=\"im_info\">"+Lang['windowquake']+"</div>\r\n");
  });
    CloseAllDiv();
}
function tmpInput(e){
  var tmp='action=tmpInput';
  tmp+='&cid='+cid;
  tmp+='&wid='+wid;
  tmp+='&uid='+uid;
  tmp+='&content1='+encodeURI($('inputbox').value).replace(/\+/g,'%2B');
  var x=new Ajax('HTML','');
  x.post(homepage+'getdata/content/client.php',tmp,function(s){
  });
}
var LastMsg='';
function myFlash_DoFSCommand(command, args) {
  if(args!="undefined" && args!=""){
    if(command=="init"){
      IsConnect=args=='Y' ? true :false;
    }else if(command=="get"){
      var fdata=args.split("{@}");
      $('winput').innerHTML=fdata[0]=='Y'?(' '+Lang['inputing']):'';
      for(j=1;j<fdata.length;j++){
        fdata_=fdata[j].split("{|}");
        if(fdata_[2]=="0"){
          PrintChat("<div class=\"im_to\">"+cnickname+"  " + Now() + "</div>\r\n<div class=\"im_content\">" + fdata_[0] + "</div>\r\n");
        }else if(fdata_[2]=="4"){
          wid=fdata_[3];
          wnickname=fdata_[0];
          PrintChat("<div class=\"im_info\">"+ fdata_[1] + "</div>\r\n");
        }else{
          if(fdata_[1]=='eqmk://system.close'){
            ForceClosed=true;
            alert(Lang['link_closed']);
            window.close();
            return false;
          }
          if(fdata_[3].indexOf(',')==-1){
            fdata_[3]+=',0';
          }
          if(fdata_[3]!=WorkerToken){
            SelWorker(fdata_[3]);
          }
          fdata_[1]=fdata_[1].replace(/£¦/g,"&");
          PrintChat("<div class=\"im_from\">"+wnickname+"  " + Now() + "</div>\r\n<div class=\"im_content\">" + fdata_[1] + "</div>\r\n");
          $('thesound').play();
	      document.title=newinfo;
          window.focus();
		  $('inputbox').focus();
        }
      }
    }else if(command=="faq"){
      PrintChat(args);
    }else if(command=="send"){
      if(args=="Y"){
        $('inputbox').focus();
        IsBusy=false;
      }else if(args=="N"){
        PrintChat("<div class=\"im_info\">Error!</div>\r\n");
        IsBusy=false;
      }
    }else if(command=="pingfen"){
      if(args=='&fdata=Y'){
        var mytxt=Lang['pingfenpost'];
      }else{
        var mytxt=Lang['pingfenover'];
      }
      $('showbox').removeChild($('div_pingfen'));
      PrintChat('<div class="im_info">'+mytxt+'</div>');
    }
  }
}
function pingfen(){
  try{
    $('showbox').removeChild($('div_pingfen'));
  }catch(e){}
  PrintChat('<div id="div_pingfen"><div><br />'+Lang['pingfenti']+'</div><div>'+pingfens+'</div><div><input type="button" value="'+Lang['pingfenbtn']+'" onclick="selfen()"> <input type="button" value="'+Lang['close']+'" onclick="$(\'showbox\').removeChild($(\'div_pingfen\'))"></div>\r\n</div>');
    CloseAllDiv();
}
function selfen(){
  if($('div_pingfen') && $('div_pingfen').style.display=='none'){
    alert(Lang['pingfenover']);
    return false;
  }
  var fen=2;
  var temp=document.getElementsByName("myfen");
  for (i=0;i<temp.length;i++){
    if(temp[i].checked){
    	fen=temp[i].value;
      	break;
    }
  }       
  var tmp='action=pingfen';
  tmp+='&cid='+cid;
  tmp+='&wid='+wid;
  tmp+='&fen='+fen;
  //tmp+='&content1='+$('inputbox').value;
  var x=new Ajax('HTML','');
  x.post(homepage+'getdata/content/client.php',tmp,function(s){
    myFlash_DoFSCommand('pingfen',s);
  });
}
function MenuOvr(id){
  if(!online){
    if(id==1){
      //return;
    }
  }
  $('m'+id).className='sel';
}
function MenuOut(id){
  if(CurMenuIndex==id){
    return;
  }
  $('m'+id).className='';
}
function MenuClick(id){
  if(!online){
    if(id==1){
      //return;
    }
  }
  if(CurMenuIndex==id){
    return;
  }
  $('m'+CurMenuIndex).className='';
  $('m'+id).className='sel';
  $('mainbody'+CurMenuIndex).style.display='none';
  $('mainbody'+id).style.display='';
  CurMenuIndex=id;
}
function InfoClick(s){
  if(s=='A'){
    $('btnA').className='sel';
    $('coA').style.display='';
    $('btnB').className='';
    $('coB').style.display='none';
  }else if(s=='B'){
    $('btnA').className='';
    $('coA').style.display='none';
    $('btnB').className='sel';
    $('coB').style.display='';
  }else{
    $('btnA').className='';
    $('btnB').className='';
    $('coA').style.display='none';
    $('coB').style.display='none';
  }
}
function checkEmail(e){
	var ok = "1234567890qwertyuiop[]asdfghjklzxcvbnm.+@-_QWERTYUIOPASDFGHJKLZXCVBNM";
	for(var i=0; i<e.length; i++){
		if (ok.indexOf(e.charAt(i))<0) {
			return false;
		}
	}
	if(e.indexOf("@")<=0){
		return false;
	}
	if(e.indexOf(".")<=0){
		return false;
	}	
	return true;
}
function booksubmit(){
  var theform=document.bookform;
  if(theform.realname.value.length<1){
    alert(Lang['error_realname']);
    theform.realname.focus();
    return false;
  }
  if(theform.email.value.length<1){
    alert(Lang['error_email']);
    theform.email.focus();
    return false;
  }
  if(!checkEmail(theform.email.value)){
    alert(Lang['error_email']);
    theform.email.focus();
    return false;
  }
  if(theform.phone.value.length<1){
    alert(Lang['error_phone']);
    theform.phone.focus();
    return false;
  }
  if(theform.co.value.length<1){
    alert(Lang['error_co_book']);
    theform.co.focus();
    return false;
  }
  theform.wid.value=wid;
  theform.submit();
}
function phonesubmit(){
  var theform=document.phoneform;
  if(theform.phone.value.length<1){
    alert(Lang['error_phone']);
    theform.phone.focus();
    return false;
  }
  if(theform.realname.value.length<1){
    alert(Lang['error_realname2']);
    theform.realname.focus();
    return false;
  }
  if(theform.co.value.length<1){
    alert(Lang['error_co_phone']);
    theform.co.focus();
    return false;
  }
  theform.wid.value=wid;
  theform.submit();
}
function ordersubmit(){
  var theform=document.orderform;
  if(theform.title.value.length<1){
    alert(Lang['error_title']);
    theform.title.focus();
    return false;
  }
  if(theform.buynum.value.length<1){
    alert(Lang['error_buynum']);
    theform.buynum.focus();
    return false;
  }
  if(isNaN(theform.buynum.value)){
    alert(Lang['error_buynum']);
    theform.buynum.focus();
    return false;
  }
  if(theform.realname.value.length<1){
    alert(Lang['error_realname']);
    theform.realname.focus();
    return false;
  }
  if(theform.email.value.length<1){
    alert(Lang['error_email']);
    theform.email.focus();
    return false;
  }
  if(!checkEmail(theform.email.value)){
    alert(Lang['error_email']);
    theform.email.focus();
    return false;
  }
  if(theform.phone.value.length<1){
    alert(Lang['error_phone']);
    theform.phone.focus();
    return false;
  }
  if(theform.co.value.length<1){
    alert(Lang['error_co_order']);
    theform.co.focus();
    return false;
  }
  theform.wid.value=wid;
  theform.submit();
}
var ForceClosed=false;
function addCookie(){¡¡ // ¼ÓÈëÊÕ²Ø¼Ð   
    if (document.all){   
        window.external.addFavorite(FavoriteUrl, FavoriteName);   
    }else if (window.sidebar){   
        window.sidebar.addPanel(FavoriteName, FavoriteUrl, "");   
    }   
}   
function window_beforeunload(){
  if(!ForceClosed){
    try{if(pingfens.length>1){pingfen();}}catch(e){}
    try{if(Favorite==1 && FavoriteUrl!=null && FavoriteName!=null){addCookie();}}catch(e){}
	window.event.returnValue=Lang['unloadword'];
  }
}
function KeyDown(){
	if (window.event.keyCode == 116){	
		event.keyCode = 0;
		event.returnValue = false;
	}
}
document.onkeydown = KeyDown;
