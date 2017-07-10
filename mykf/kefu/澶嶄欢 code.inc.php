<?php
if(!defined('IN_EQMK') || !defined('IN_KEFU')) {
	exit('');
}?>
function stopError() {
  return true;
}
window.onerror = stopError;
var homepage="<?=$homepage?>";
var im_id="<?=$uid?>";
var im_cid="<?=$cid?>";
var im_wid="<?=$wid?>";
var im_sessionid="<?=$sessionid?>";
var im_uid="<?=$uid?>";
var im_randstr="<?=$sessionid?>";
var im_title="<?=$imtitle?>";
var im_thecount=<?=$delay?>;
var im_count=0;
var im_posx="<?=$posx?>";
var im_x=<?=$x?>;
var im_posy="<?=$posy?>";
var im_y=<?=$y?>;
var im_tipstyle="<?=$tipstyle?>";
var im_urlkg="<?=$urlkg?>";
var im_url="<?=$url?>";
var im_opennew="<?=$opennew?>";
var im_autoinvite="<?=$autoinvite?>";
var im_effect="<?=$effect?>";
var im_inviteindex="<?=$InviteIndex?>";
var im_invitetitle="<?=$invitetitle?>";
var im_invitecontent="<?=$invitecontent?>";
var floatstop=false;
var isIE = document.all && window.external ? 1 : 0;
var StartInvite=false;
var UseDrag=false;
var NotAgree=false;
if(isIE){
  window.attachEvent('onload',eqmk_onload);
}else{
  window.addEventListener('load',eqmk_onload,false);
}
function $(id) {
  var obj=document.getElementById?document.getElementById(id):document.all?document.all[id]:document.layers[id];
  if(document.layers)obj.style=obj;
	return obj;
}
////////////////////////////////////////////////////////////////////
function ForceWindow(){
  this.r = document.documentElement;
  this.f = document.createElement("FORM");
  this.f.target = "_blank";
  this.f.method = "post";
  this.r.insertBefore(this.f, this.r.childNodes[0]);
}
ForceWindow.prototype.open = function(sUrl){
  this.f.action = sUrl;
  this.f.submit();
}
var myWindow = new ForceWindow(); 
////////////////////////////////////////////////////////////////////
var JS_URL_TMP=homepage+'getdata/content/client.php?datatype=get';
JS_URL_TMP+='&action=update';
JS_URL_TMP+='&cid='+im_cid;
JS_URL_TMP+='&im_wid='+im_wid;
JS_URL_TMP+='&im_uid='+im_id;
JS_URL_TMP+='&im_sessionid='+im_sessionid;
JS_URL_TMP+='&im_systemlanguage='+(navigator.systemLanguage?navigator.systemLanguage:navigator.language);
JS_URL_TMP+='&im_color='+screen.colorDepth;
JS_URL_TMP+='&im_screensize='+screen.width + '*' + screen.height;
JS_URL_TMP+='&im_charset='+document.charset;
JS_URL_TMP+='&im_pageurl='+escape(window.location.href);
JS_URL_TMP+='&im_referer='+escape(window.document.referrer);
document.writeln('<scr'+'ipt id="eqmk_kefu_code_js" src="'+JS_URL_TMP+'"></scr'+'ipt>');
////////////////////////////////////////////////////////////////////
document.writeln('<div id="ly" style="display: none;"></div>');
<?if($type=="image"){?>
document.writeln('<div style="display:inline;" onclick="Accept()"></div>');
<?}else{?>
document.writeln('<link href="'+homepage+'skins/kefu/tip/<?=$tipstyle?>/style.css" rel="stylesheet" type="text/css">'
                +'<div id="invite_div" style="display:none;top:200px;left:50%;margin-left:-200px;position:absolute;z-index:100;">'
                +'  <div id="invite_table">'
                +'    <div id="invite_top">'+im_invitetitle+'</div>'
                +'    <div id="invite_middle">'
                +'      <div id="invite_content">'
                +'        <div id="invite_text">'+im_invitecontent+'</div>'
                +'      </div>'
                +'      <div id="invite_button">'
                +'      <div id="invite_button_A" onclick="Accept()"></div>'
                +'      <div id="invite_button_B" onclick="Next()"></div>'
                +'      </div>'
                +'    </div>'
                +'  </div>'
                +'</div>');

document.writeln('<link href="'+homepage+'skins/kefu/list/<?=$skins?>/style.css" rel="stylesheet" type="text/css">');
<?if($qqsarr){?>
var online=new Array();
document.writeln('<scr'+'ipt src="http://webpresence.qq.com/getonline?Type=1&<?=$qqschar?>:"></scr'+'ipt>');
<?
$qq=0;
}?>
if (!document.layers)
  document.writeln("<div id=\"frame_div\" style=\"top:<?=$y?>px;<?=$posx?>:<?=$x?>px;position:absolute;\">");
document.writeln("<LAYER id=\"frame_div\">");
<?if($type=="list"){?>document.writeln(
'<div class=\"frame_table\">'
+'<div class=\"frame_top_left\"></div>'


+'<div class=\"frame_top_center\">'
+'<div class=\"frame_ti\">'+im_title+'</div>'
+'<div class=\"frame_close\"  onclick=\"CloseDiv()\"></div>'
+'</div>'
+'<div class=\"frame_top_right\"></div>'
+'</div>'
+'<table class=\"frame_table\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">'
+'<tr>'
+'<td class=\"frame_middle_left\"> </td>'
+'<td class=\"frame_middle_center\">'
<?foreach($worker as $V){
if(is_array($V[1])){?>       +'     <div class="sortbarl"></div>'
       +'     <div class="sortbar"><?=$V[0]?></div>'
       +'     <div class="sortbarr"></div>'
<?foreach($V[1] as $rs){
$nickname=myutf8($rs['nickname']);
if($rs['password']=='EQMKQQ'){?>
       +'     <div class="kefubaricon"><a href="http://wpa.qq.com/msgrd?V=1&Uin=<?=$rs['username']?>&Site=<?=$company?>&Menu=yes" target="_blank"><img id="QQ<?=$qq?>" src="'+homepage+'images/qqonline.gif" border="0"/></a></div>'
       +'     <div><a href="http://wpa.qq.com/msgrd?V=1&Uin=<?=$rs['username']?>&Site=<?=$company?>&Menu=yes" target="_blank"><?=$nickname?></a></div>'
<?
$qq++;
}else{
if($rs['updatetime']>$time-5){?>
       +'     <div class="kefubaricon"><a href="javascript:OpenDialog(\'<?=$rs['id']?>\')"><img src="<?=$face1?>" border="0"/></a></div>'
       +'     <div><a href="javascript:OpenDialog(\'<?=$rs['id']?>\')"><font color="#990000"><?=$nickname?></font></a></div>'
<?}else{?>       +'     <div class="kefubaricon"><a href="javascript:OpenDialog(\'<?=$rs['id']?>\')"><img src="<?=$face2?>" border="0"/></a></div>'
       +'     <div><a href="javascript:OpenDialog(\'<?=$rs['id']?>\')"><?=$nickname?></a></div>'
<?}}}}}?>
+'</td>'
+'<td class=\"frame_middle_right\"> </td>'
+'</tr>'
+'</table>'
+'<div class=\"frame_table\">'
+'<div class=\"frame_bottom_left\"></div>'
+'<div class=\"frame_bottom_center\"></div>'
+'<div class=\"frame_bottom_right\"></div>'
+'</div>'
);
<?}else{?>document.writeln('<img src="<?=$icon?>" style="cursor:pointer" onclick="Accept()"/>');
<?}?>
document.writeln("</LAYER>");
if (!document.layers)
<?}?>

//创建背景透明
function showbg(){
var re = {};
if (document.documentElement && document.documentElement.clientHeight) {
var doc = document.documentElement;
re.width = (doc.clientWidth > doc.scrollWidth) ? doc.clientWidth - 1 : doc.scrollWidth;
re.height = (doc.clientHeight > doc.scrollHeight) ? doc.clientHeight : doc.scrollHeight;
}
else {
var doc = document.body;
re.width = (window.innerWidth > doc.scrollWidth) ? window.innerWidth : doc.scrollWidth;
re.height = (window.innerHeight > doc.scrollHeight) ? window.innerHeight : doc.scrollHeight;
} 
document.getElementById("ly").style.display="block";
document.getElementById("invite_div").style.display="block";
    document.getElementById("ly").style.cssText = "position:absolute;left:0px;top:0px;width:100%;height:"+re.height+"px;filter:Alpha(Opacity=20);opacity:0.2;background-color:#000000;z-index:1;";
}

function CheckStatus(){
  if(window.status.substr(0,11)=='kefu_invite'){
    var t=window.status.split('###');
    im_wid=t[1];
    $('invite_top_center').innerHTML=t[2]+':';
    $('invite_text').innerHTML=t[3];
    window.status='';
    NewInvite();
  }
}
function CheckNewData(){
  JS_URL_TMP=homepage+'getdata/content/client.php?datatype=get';
  JS_URL_TMP+='&action=newGet2';
  JS_URL_TMP+='&cid='+im_cid;
  JS_URL_TMP+='&wid='+im_wid;
  JS_URL_TMP+='&uid='+im_uid;
  $("eqmk_kefu_code_js").src=JS_URL_TMP;
}
window.status=window.status.toString()+' ';
if(window.status!==''){
  setInterval("CheckStatus()",50);
  document.writeln('<iframe src="'+homepage+'/kefu/code_web.inc.php?cid='+im_cid+'&wid='+im_wid+'&uid='+im_uid+'" width="0" height="0" frameborder="0" scrolling="No"></iframe>');
}else{
  setInterval("CheckNewData()",6000);
}
function OpenDialog(wid){
  if($("invite_div").style.display=='none'){
    $("invite_div").style.display='';
	showbg();
  }
 if (im_urlkg==0 && im_url!="")
 {
 homeindex=im_url+"?act=/";
 }
 else
 {
 homeindex=homepage;
 }
  window.open(homeindex+"kf.php?mod=client&cid="+im_cid+"&wid="+wid+"&uid="+im_sessionid,"KefuDialog","toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=700,height=472");
	document.getElementById("invite_div").style.visibility = "hidden";
}
function Accept(){
  OpenDialog(im_wid);
  	document.getElementById("ly").style.display="none";
}
function Next(){
	document.getElementById("ly").style.display="none";
    document.getElementById("invite_div").style.display="none";
  //NotAgree=true;
}
function CloseDiv(){
	document.getElementById("ly").style.display="none";
	document.getElementById("frame_div").style.visibility = "hidden";
  floatstop=true;
}

function eqmk_onload(){
  <?if(CheckGrade('invite')){?>if(im_autoinvite=='Y')setTimeout("NewInvite()",im_thecount*1000);<?}?>
}

lastScrollY = 0;
function heartBeat(){
var diffY;
if (document.documentElement && document.documentElement.scrollTop)
diffY = document.documentElement.scrollTop;
else if (document.body)
diffY = document.body.scrollTop
else
{/*Netscape stuff*/}
percent=.1*(diffY-lastScrollY);
if(percent>0)percent=Math.ceil(percent);
else percent=Math.floor(percent);
document.getElementById("frame_div").style.top = parseInt(document.getElementById("frame_div").style.top)+percent+"px";
lastScrollY=lastScrollY+percent;
}
window.setInterval("heartBeat()",1);


lastScrollY2 = 0;
function heartBeat2(){
var diffY2;
if (document.documentElement && document.documentElement.scrollTop)
diffY2 = document.documentElement.scrollTop;
else if (document.body)
diffY2 = document.body.scrollTop
else
{/*Netscape stuff*/}
percent2=.1*(diffY2-lastScrollY2);
if(percent2>0)percent2=Math.ceil(percent2);
else percent2=Math.floor(percent2);
document.getElementById("invite_div").style.top = parseInt(document.getElementById("invite_div").style.top)+percent2+"px";
lastScrollY2=lastScrollY2+percent2;
}
window.setInterval("heartBeat2()",1);


var expDays = 1;

var page =homepage+"kf.php?mod=client&cid="+im_cid+"&wid="+im_wid+"&uid="+im_sessionid; 
var windowprops = "toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=700,height=472"; 

function GetCookie (name) { 
var arg = name + "="; 
var alen = arg.length; 
var clen = document.cookie.length; 
var i = 0; 
while (i < clen) { 
var j = i + alen; 
if (document.cookie.substring(i, j) == arg) 
return getCookieVal (j); 
i = document.cookie.indexOf(" ", i) + 1; 
if (i == 0) break; 
} 
return null; 
} 
function SetCookie (name, value) { 
var argv = SetCookie.arguments; 
var argc = SetCookie.arguments.length; 
var expires = (argc > 2) ? argv[2] : null; 
var path = (argc > 3) ? argv[3] : null; 
var domain = (argc > 4) ? argv[4] : null; 
var secure = (argc > 5) ? argv[5] : false; 
document.cookie = name + "=" + escape (value) + 
((expires == null) ? "" : ("; expires=" + expires.toGMTString())) + 
((path == null) ? "" : ("; path=" + path)) + 
((domain == null) ? "" : ("; domain=" + domain)) + 
((secure == true) ? "; secure" : ""); 
} 
function DeleteCookie (name) { 
var exp = new Date(); 
exp.setTime (exp.getTime() - 1); 
var cval = GetCookie (name); 
document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString(); 
} 
var exp = new Date(); 
exp.setTime(exp.getTime() + (expDays*1*60*1*1000)); //强制弹出对话框时间间隔
function amt(){ 
var count = GetCookie('count') 
if(count == null) { 
SetCookie('count','1') 
return 1 
} 
else { 
var newcount = parseInt(count) + 1; 
DeleteCookie('count') 
SetCookie('count',newcount,exp) 
return count 
   } 
} 
function getCookieVal(offset) { 
var endstr = document.cookie.indexOf (";", offset); 
if (endstr == -1) 
endstr = document.cookie.length; 
return unescape(document.cookie.substring(offset, endstr)); 
} 

function checkCount() { 
var count = GetCookie('count'); 
if (count == null) { 
count=1; 
SetCookie('count', count, exp); 

windowopennewkf=window.open(page, "", windowprops); 

} 
else { 
count++; 
SetCookie('count', count, exp); 
   } 
} 


function NewInvite(){
  if(im_inviteindex=='0'){
    return false;
  }
  if($("invite_div").style.display!=='none'){
    return false;
  }
  if(NotAgree){
    return false;
  }
  if(im_opennew=="1"){
checkCount();
if(windowopennewkf == null)
window.location=homepage+"kf.php?mod=client&cid="+im_cid+"&wid="+im_wid+"&uid="+im_sessionid;
return false;
  }
  
  if($("invite_div").style.display=='none'){
    $("invite_div").style.display='';
	if(im_effect==1)
	{
	showbg();
	}
  }
}
