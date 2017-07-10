<?php
if(!defined('IN_EQMK') || !defined('IN_KEFU')) {
	exit('');
}?>
function stopError() {
  return true;
}
//window.onerror = stopError;
var homepage="<?=$homepage?>";
var im_id="<?=$uid?>";
var im_cid="<?=$cid?>";
var im_wid="<?=$wid?>";
var im_sessionid="<?=$sessionid?>";
var im_uid="";
var im_randstr="<?=$sessionid?>";
var im_title="<?=$imtitle?>";
var im_thecount=<?=$delay?>;
var im_count=0;
var im_posx="<?=$posx?>";
var im_x=<?=$x?>;
var im_posy="<?=$posy?>";
var im_y=<?=$y?>;
var im_tipstyle="<?=$tipstyle?>";
var im_opennew="<?=$opennew?>";
var im_autoinvite="<?=$autoinvite?>";
var im_inviteindex="<?=$InviteIndex?>";
var im_invitetitle="<?=$invitetitle?>";
var im_invitecontent="<?=$invitecontent?>";
var myFlashObj;
var floatstop=false;
var isIE = document.all && window.external ? 1 : 0;
var isW3C =typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat'?true:false;
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
JS_URL_TMP+='&im_sessionid='+im_sessionid;
JS_URL_TMP+='&im_systemlanguage='+(navigator.systemLanguage?navigator.systemLanguage:navigator.language);
JS_URL_TMP+='&im_color='+screen.colorDepth;
JS_URL_TMP+='&im_screensize='+screen.width + '*' + screen.height;
JS_URL_TMP+='&im_charset='+document.charset;
JS_URL_TMP+='&im_pageurl='+escape(window.top.location.href);
JS_URL_TMP+='&im_referer='+escape(window.top.document.referrer);
document.writeln('<scr'+'ipt id="eqmk_kefu_code_js" src="'+JS_URL_TMP+'"></scr'+'ipt>');
////////////////////////////////////////////////////////////////////

<?if(CheckGrade('invite')){?>
<?if($tippos=="center"){?>document.writeln('<link href="'+homepage+'skins/kefu/tip/<?=$tipstyle?>/style.css" rel="stylesheet" type="text/css">');
document.writeln('<div id="invite_div" style="display:none">'
                +'  <div id="invite_table">'
                +'    <div id="invite_top_left"></div>'
                +'    <div id="invite_top_center">'+im_invitetitle+'</div>'
                +'    <div id="invite_top_right"></div>'
                +'    <div id="invite_middle">'
                +'      <div id="invite_icon"></div>'
                +'      <div id="invite_content">'
                +'        <div id="invite_text">'+im_invitecontent+'</div>'
                +'      </div>'
                +'      <div id="invite_button">'
                +'        <img src="'+homepage+'skins/kefu/tip/<?=$tipstyle?>/accept.gif" onclick="Accept()" />'
                +'        <img src="'+homepage+'skins/kefu/tip/<?=$tipstyle?>/next.gif" onclick="Next()" />'
                +'      </div>'
                +'    </div>'
                +'    <div id="invite_bottom_left"></div>'
                +'    <div id="invite_bottom_center"></div>'
                +'    <div id="invite_bottom_right"></div>'
                +'  </div>'
                +'</div>');
<?}elseif($tippos=="bottom"){?>document.writeln('<link href="'+homepage+'skins/kefu/tip/<?=$tipstyle?>/style.css" rel="stylesheet" type="text/css">');
document.writeln('<div id="RB_Invite_div" style="display:none"><img style="display:none" src=""/>'
                +'  <div id="RB_Invite_title">'+im_invitetitle+'</div>'
                +'  <div class="RB_Invite_close_normal" onmouseover="this.className=\'RB_Invite_close_hover\'" onmouseout="this.className=\'RB_Invite_close_normal\'" onclick="Next()"></div>'
                +'  <div id="RB_Invite_content" onclick="Accept()">'+im_invitecontent+'</div>'
                +'  <div id="RB_Invite_open" onclick="Accept()"></div>'
                +'</div>');
<?}}?>

document.writeln('<link href="'+homepage+'skins/kefu/list/<?=$skins?>/style.css" rel="stylesheet" type="text/css">');
if (!document.layers)
  document.writeln("<div id=\"frame_div\" style=\"display:none\">");
document.writeln("<LAYER id=\"frame_div\" style=\"display:none\">");
<?if($type=="list"){?>document.writeln(
        '<div id="frame_table">'
       +' <div id="frame_top_left"></div>'
       +' <div id="frame_top_center"><div class="frame_ti">'+im_title+'</div><div class="frame_close" onclick="CloseDiv()"></div></div>'
       +' <div id="frame_top_right"></div>'
       +'</div>'
       +'<table id="frame_table" border="0" cellpadding="0" cellspacing="0">'
       +' <tr>'
       +'   <td id="frame_middle_left"> </td>'
       +'   <td id="frame_middle_center">'
<?foreach($worker as $V){
if(is_array($V[1])){?>       +'     <div id="sortbarl"></div>'
       +'     <div id="sortbar"><?=$V[0]?></div>'
       +'     <div id="sortbarr"></div>'
<?foreach($V[1] as $rs){
$nickname=myutf8($rs['nickname']);
if($rs['updatetime']>$time-60){
?>       +'     <img src="<?=$face1?>" id="kefubaricon"/>'
       +'     <div id="kefubartitle"><a href="javascript:OpenDialog(\'<?=$rs['id']?>\')"><?=$nickname?></a></div>'
       +'     <div style="clear:both"></div>'
<?}else{?>       +'     <img src="<?=$face2?>" id="kefubaricon"/>'
       +'     <div id="kefubartitle"><a href="javascript:OpenDialog(\'<?=$rs['id']?>\')"><?=$nickname?></a></div>'
       +'     <div style="clear:both"></div>'
<?}}}}?>       +'   </td>'
       +'   <td id="frame_middle_right"> </td>'
       +' </tr>'
       +'</table>'
       +'<div style="clear:both"></div>'
       +'<div id="frame_table">'
       +' <div id="frame_bottom_left"></div>'
       +' <div id="frame_bottom_center"></div>'
       +' <div id="frame_bottom_right"></div>'
       +'</div>'
);
<?}else{?>document.writeln('<img src="<?=$icon?>" style="cursor:pointer" onclick="Accept()"/>');
<?}?>
document.writeln("</LAYER>");
if (!document.layers)
  document.writeln('</div>');
  
document.writeln('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="1" height="1" align="middle" id="myFlash">');
document.writeln('<param name="movie" value="'+homepage+'eqmkdata/update.swf<?=$mtime_swf?>"/>');
document.writeln('<param name="allowScriptAccess" value="always" />');
document.writeln('<param name="quality" value="high" />');
document.writeln('<param name="bgcolor" value="#ffffff" />');
document.writeln('<embed name="myFlash" src="'+homepage+'eqmkdata/update.swf<?=$mtime_swf?>" quality="high" bgcolor="#ffffff" width="1" height="1" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" swLiveConnect="true"/>');
document.writeln('</object>');
//document.writeln('<input type="button" onclick="test()" value="Test">');
function test(){
  var tmp='Object->'+typeof(myFlashObj)+"\n";
  tmp+='Baseurl->'+myFlashObj.getVariable("BaseUrl")+"\n";
  tmp+='CompanyId->'+myFlashObj.getVariable("CompanyId")+"\n";
  tmp+='WorkerId->'+myFlashObj.getVariable("WorkerId")+"\n";
  tmp+='ClientId->'+myFlashObj.getVariable("ClientId")+"\n";
  tmp+='Debug->'+myFlashObj.getVariable("Debug")+"\n";
  tmp+='isInvited->'+myFlashObj.getVariable("isInvited")
  alert(tmp);
}
function SwfInit(){
  myFlashObj = isIE ? myFlash : document.myFlash;
  if(myFlashObj==undefined){
    return false;
  }
  //clearInterval(InitTimer);
  myFlashObj.SetVariable("BaseUrl", homepage+'getdata/content/client.php');
  myFlashObj.SetVariable("CompanyId", im_cid);
  myFlashObj.SetVariable("WorkerId", im_wid);
  myFlashObj.SetVariable("ClientId", im_uid);
  //myFlashObj.SetVariable("Debug", 1);
}
var InitTimer=setInterval("SwfInit()",100);
function myFlash_DoFSCommand(command, args) {
  if(im_inviteindex!='3'){
    return false;
  }
  if(args!="undefined" && args!=""){
    if(command=="fdata"){
      var tmp=args.split("|");
      im_wid=tmp[0];
      myFlashObj.SetVariable("WorkerId", im_wid);
      <?if($tippos=="center"){?>
      $("invite_text").innerHTML=tmp[1];
      <?}else{?>
      $("RB_Invite_content").innerHTML=tmp[1];
      <?}?>
      NewInvite();
    }
  }
}

function OpenDialog(wid){
  window.open(homepage+"kf.php?mod=client&cid="+im_cid+"&wid="+wid+"&uid="+im_sessionid,"Dialog"+wid,"toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=700,height=472");
  <?if($tippos=="center"){?>$("invite_div")<?}else{?>$("RB_Invite_div")<?}?>.style.display='none';
}
function Accept(){
  OpenDialog(im_wid);
}
function Next(){
  <?if($tippos=="center"){?>$("invite_div")<?}else{?>$("RB_Invite_div")<?}?>.style.display='none';
  myFlashObj.SendMsg('notagree');
  NotAgree=true;
}
function CloseDiv(){
  $("frame_div").style.display='none';
  floatstop=true;
}
var verticalpos="fromtop";
var frame_startX=0,frame_startY=0;
var invite1_startX=0,invite1_startY=0;
var invite2_startX=0,invite2_startY=0;
function GetScroll(ntype){
  if(ntype=='top'){
    return isW3C?document.documentElement.scrollTop:document.body.scrollTop;
  }else{
    return isW3C?document.documentElement.scrollLeft:document.body.scrollLeft;
  }
}

function Eqmk_Float_<?=$cid?>_frame(){
  if(UseDrag){
    if(im_posx=='left'){
      frame_startX=im_x;
    }else if(im_posx=='center'){
      frame_startX=parseInt((document.body.clientWidth-$('frame_div').clientWidth)/2);
    }else if(im_posx=='right'){
      frame_startX=document.body.clientWidth-$('frame_div').clientWidth-im_x;
    }
    if(im_posy=='top'){
      frame_startY=im_y;
    }else if(im_posy=='middle'){
      frame_startY=parseInt((document.body.clientHeight-$('frame_div').clientHeight)/2);
    }else if(im_posy=='bottom'){
      frame_startY=document.body.clientHeight-$('frame_div').clientHeight-im_y;
    }
  }
	var ns = (navigator.appName.indexOf("Netscape") != -1);
	var d = document;
	function frame_ml(id){
		var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
		if(d.layers)el.style=el;
		el.sP=function(x,y){this.style.left=x;this.style.top=y};
		el.x = frame_startX;
		if (verticalpos=="fromtop")
		el.y = frame_startY;
		else{
		el.y = ns ? pageYOffset + innerHeight : GetScroll('top') + d.body.clientHeight;
		el.y -= frame_startY;
		}
		return el;
	}
	window.frame_stayTopLeft=function(){
    if(!UseDrag){
      if(im_posx=='left'){
        frame_startX=im_x;
      }else if(im_posx=='center'){
        frame_startX=parseInt((document.body.clientWidth-$('frame_div').clientWidth)/2);
      }else if(im_posx=='right'){
        frame_startX=document.body.clientWidth-$('frame_div').clientWidth-im_x;
      }
      if(im_posy=='top'){
        frame_startY=im_y;
      }else if(im_posy=='middle'){
        frame_startY=parseInt((document.body.clientHeight-$('frame_div').clientHeight)/2);
      }else if(im_posy=='bottom'){
        frame_startY=document.body.clientHeight-$('frame_div').clientHeight-im_y;
      }
    }
		if (verticalpos=="fromtop"){
      frame_ftlObj.x = (ns ? pageXOffset : GetScroll('left')) + frame_startX;
      var pY = ns ? pageYOffset : GetScroll('top');
      frame_ftlObj.y += (pY + frame_startY - frame_ftlObj.y)/8;
		}else{
      var pY = ns ? pageYOffset + innerHeight : GetScroll('top') + d.body.clientHeight;
      frame_ftlObj.y += (frame_pY - frame_startY - frame_ftlObj.y)/8;
		}
    frame_ftlObj.sP(frame_ftlObj.x, frame_ftlObj.y);
		setTimeout("frame_stayTopLeft()", 10);
	}
	frame_ftlObj = frame_ml('frame_div');
	frame_stayTopLeft();
}
function Eqmk_Float_<?=$cid?>_invite1(){
  if(UseDrag){
    invite1_startX=parseInt((document.body.clientWidth-400)/2);
    invite1_startY=200;//parseInt((document.body.clientHeight-$('invite_div').clientHeight)/2);
  }
	var ns = (navigator.appName.indexOf("Netscape") != -1);
	var d = document;
	function invite1_ml(id){
		var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
		if(d.layers)el.style=el;
		el.sP=function(x,y){this.style.left=x;this.style.top=y};
		el.x = invite1_startX;
		if (verticalpos=="fromtop")
		el.y = invite1_startY;
		else{
		el.y = ns ? pageYOffset + innerHeight : GetScroll('top') + d.body.clientHeight;
		el.y -= invite1_startY;
		}
		return el;
	}
	window.invite1_stayTopLeft=function(){
    if(!UseDrag){
      invite1_startX=parseInt((document.body.clientWidth-$('invite_div').clientWidth)/2);
      invite1_startY=200;//parseInt((document.body.clientHeight-$('invite_div').clientHeight)/2);
    }
		if (verticalpos=="fromtop"){
      invite1_ftlObj.x = (ns ? pageXOffset : GetScroll('left')) + invite1_startX;
      var pY = ns ? pageYOffset : GetScroll('top');
      invite1_ftlObj.y += (pY + invite1_startY - invite1_ftlObj.y)/8;
		}else{
      var pY = ns ? pageYOffset + innerHeight : GetScroll('top') + d.body.clientHeight;
      invite1_ftlObj.y += (invite1_pY - invite1_startY - invite1_ftlObj.y)/8;
		}
    invite1_ftlObj.sP(invite1_ftlObj.x, invite1_ftlObj.y);
		setTimeout("invite1_stayTopLeft()", 10);
	}
	invite1_ftlObj = invite1_ml('invite_div');
	invite1_stayTopLeft();
}
function Eqmk_Float_<?=$cid?>_invite2(){
	var ns = (navigator.appName.indexOf("Netscape") != -1);
	var d = document;
	function invite2_ml(id){
		var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
		if(d.layers)el.style=el;
		el.sP=function(x,y){this.style.left=x;this.style.top=y};
		el.x = invite2_startX;
		if (verticalpos=="fromtop")
		el.y = invite2_startY;
		else{
		el.y = ns ? pageYOffset + innerHeight : GetScroll('top') + d.body.clientHeight;
		el.y -= invite2_startY;
		}
		return el;
	}
	window.invite2_stayTopLeft=function(){
    invite2_startX=document.body.clientWidth-$('RB_Invite_div').clientWidth;
    invite2_startY=document.body.clientHeight-$('RB_Invite_div').clientHeight;
		if (verticalpos=="fromtop"){
      invite2_ftlObj.x = (ns ? pageXOffset : GetScroll('left')) + invite2_startX;
      var pY = ns ? pageYOffset : GetScroll('top');
      invite2_ftlObj.y += (pY + invite2_startY - invite2_ftlObj.y)/8;
		}else{
      var pY = ns ? pageYOffset + innerHeight : GetScroll('top') + d.body.clientHeight;
      invite2_ftlObj.y += (invite2_pY - invite2_startY - invite2_ftlObj.y)/8;
		}
    invite2_ftlObj.sP(invite2_ftlObj.x, invite2_ftlObj.y);
		setTimeout("invite2_stayTopLeft()", 10);
	}
	invite2_ftlObj = invite2_ml('RB_Invite_div');
	invite2_stayTopLeft();
}

function drag(o){
	o.onmousedown=function(a){
		var d=document;if(!a)a=window.event;
		var x=a.layerX?a.layerX:a.offsetX,y=a.layerY?a.layerY:a.offsetY;
		if(o.setCapture)
			o.setCapture();
		else if(window.captureEvents)
			window.captureEvents(Event.MOUSEMOVE|Event.MOUSEUP);

		d.onmousemove=function(a){
			if(!a)a=window.event;
			if(!a.pageX)a.pageX=a.clientX;
			if(!a.pageY)a.pageY=a.clientY;
			var tx=a.pageX-x,ty=a.pageY-y;
			var pX=isIE ? document.body.scrollLeft : pageXOffset;
			var pY=isIE ? document.body.scrollTop : pageYOffset;
			o.style.left=pX + tx;
			o.style.top=pY + ty;
			if(o.id=='frame_div'){
        frame_startX=tx;
        frame_startY=ty;
      }else if(o.id=='invite_div'){
        invite1_startX=tx;
        invite1_startY=ty;
      }
		};

		d.onmouseup=function(){
			if(o.releaseCapture)
				o.releaseCapture();
			else if(window.captureEvents)
				window.captureEvents(Event.MOUSEMOVE|Event.MOUSEUP);
			d.onmousemove=null;
			d.onmouseup=null;
		};
	};
}
try{
  Eqmk_Float_<?=$cid?>_frame();
  $("frame_div").style.display='';
}catch(e){}
function eqmk_onload(){
  Eqmk_Float_<?=$cid?>_frame();
  $("frame_div").style.display='';
	if(UseDrag){drag($('frame_div'));}
  <?if(CheckGrade('invite')){?>if(im_autoinvite=='Y')setTimeout("NewInvite()",im_thecount*1000);<?}?>
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
    myWindow.open(homepage+"kf.php?mod=client&cid="+im_cid+"&wid="+im_wid+"&uid="+im_sessionid);
    return false;
  }else{
    myFlashObj.SetVariable("isInvited", "1");
  }
  <?if($tippos=="center"){?>
  
  if(isIE){
    $("invite_div").style.pixelLeft=document.body.scrollLeft+parseInt((document.body.clientWidth-400)/2);
    $("invite_div").style.pixelTop=document.body.scrollTop+200;
  }else{
    $("invite_div").style.left=document.documentElement.scrollLeft+parseInt((document.documentElement.clientWidth-400)/2)+"px";
    $("invite_div").style.top=document.documentElement.scrollTop+200+"px";
  }
  if($("invite_div").style.display=='none'){
    $("invite_div").style.display='';
    Eqmk_Float_<?=$cid?>_invite1();
  }
  //if(UseDrag){drag($('invite_div'));}
  <?}else{?>  
            
  if(isIE){
    $("RB_Invite_div").style.pixelLeft=document.body.scrollLeft+document.body.clientWidth-258;
    $("RB_Invite_div").style.pixelTop=document.body.scrollTop+document.body.clientHeight-161;
  }else{
    $("RB_Invite_div").style.left=document.documentElement.scrollLeft+document.documentElement.clientWidth-258+"px";
    $("RB_Invite_div").style.top=document.documentElement.scrollTop+document.documentElement.clientHeight-161+"px";
  }
  if($("RB_Invite_div").style.display=='none')$("RB_Invite_div").style.display='';
  Eqmk_Float_<?=$cid?>_invite2();
  <?}?>
  clearInterval(InitTimer);
}
if (navigator.appName && navigator.appName.indexOf("Microsoft") != -1 && navigator.userAgent.indexOf("Windows") != -1 && navigator.userAgent.indexOf("Windows 3.1") == -1) {
  document.write('<SCRIPT LANGUAGE=VBScript\> \n');
  document.write('on error resume next \n');
  document.write('Sub myFlash_FSCommand(ByVal command, ByVal args)\n');
  document.write(' call myFlash_DoFSCommand(command, args)\n');
  document.write('end sub\n');
  document.write('</SCRIPT\> \n');
}