<?php
if(!defined('IN_EQMK') || !defined('IN_KEFU')) {
	exit('Access Denied');
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="<?=$keywords?>">
<meta name="description" content="<?=$description?>">
<link href="<?=$css1?><?=$mtime_css1?>" rel="stylesheet" type="text/css" />
<link href="<?=$css2?><?=$mtime_css2?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="include/javascript/ajax.js"></script>
<script type="text/javascript" src="include/javascript/radiostylejs.js"></script>
<script type="text/javascript">
function stopError() {
  return true;
}
window.onerror = stopError;
var homepage="<?=$homepage?>";
var cid="<?=$cid?>";
var cnickname="<?=$myname?>";
var newinfo="<?=$newinfo?>";
var webtitlename="<?=$webtitle?>";
var uid="<?=$uid?>";
var wid="<?=$wid?>";
var sessionid="<?=$sessionid?>";
var isIE = document.all && window.external ? 1 : 0;
var CurMenuIndex=<?=$online?1:2?>;
var TimeAdd=(new Date()).getTime()-(new Date(<?=date('Y,m,d,H,i,s',$time)?>)).getTime();
var online=<?=$online?'true':'false'?>;
var tip='<?=str_replace("'","\'",$tip)?>';
var closetip='<?=str_replace("'","\'",$closetip)?>';
var pingfens='<?=str_replace("'","\'",$pingfens)?>';
var Favorite='<?=str_replace("'","\'",$Favorite)?>';
var FavoriteUrl='<?=str_replace("'","\'",$FavoriteUrl)?>';
var FavoriteName='<?=str_replace("'","\'",$FavoriteName)?>';
var InfoHeight=0;
var Lang=new Object();
Lang['senderror']='<?=str_replace("'","\'",$language['senderror'])?>';
Lang['inserturl']='<?=str_replace("'","\'",$language['inserturl'])?>';
Lang['insertpic']='<?=str_replace("'","\'",$language['insertpic'])?>';
Lang['windowquake']='<?=str_replace("'","\'",$language['windowquake'])?>';
Lang['inputing']='<?=str_replace("'","\'",$language['inputing'])?>';
Lang['link_closed']='<?=str_replace("'","\'",$language['link_closed'])?>';
Lang['pingfenpost']='<?=str_replace("'","\'",$language['pingfenpost'])?>';
Lang['pingfenover']='<?=str_replace("'","\'",$language['pingfenover'])?>';
Lang['pingfenti']='<?=str_replace("'","\'",$language['pingfenti'])?>';
Lang['pingfenbtn']='<?=str_replace("'","\'",$language['pingfenbtn'])?>';
Lang['close']='<?=str_replace("'","\'",$language['close'])?>';
Lang['unloadword']='<?=str_replace("'","\'",$language['unloadword'])?>';
Lang['error_realname']='<?=str_replace("'","\'",$language['error_realname'])?>';
Lang['error_realname2']='<?=str_replace("'","\'",$language['error_realname2'])?>';
Lang['error_email']='<?=str_replace("'","\'",$language['error_email'])?>';
Lang['error_phone']='<?=str_replace("'","\'",$language['error_phone'])?>';
Lang['error_im']='<?=str_replace("'","\'",$language['error_im'])?>';
Lang['error_title']='<?=str_replace("'","\'",$language['error_title'])?>';
Lang['error_buynum']='<?=str_replace("'","\'",$language['error_buynum'])?>';
Lang['error_co_book']='<?=str_replace("'","\'",$language['error_co_book'])?>';
Lang['error_co_phone']='<?=str_replace("'","\'",$language['error_co_phone'])?>';
Lang['error_co_order']='<?=str_replace("'","\'",$language['error_co_order'])?>';
var cursmiley=0;
<?if(CheckGrade('smiley')){?>
var smileys=new Array();<?for($i=0;$i<count($smileys);$i++){?>

smileys[<?=$i?>]=new Array("<?=$smileys[$i][0]?>","<?=$smileys[$i][1]?>",<?=$smileys[$i][2]?>,<?=$smileys[$i][3]?>);<?}}?>

function $(id) {
	return document.getElementById?document.getElementById(id):document.all?d.all[id]:document.layers[id];
}
function input_onkeydown(e){
  var keycode=isIE==1?e.keyCode:e.which;
  if(keycode==13){
    e.returnValue=false;
    send();
  }
}
function send(){
  if(!IsConnect){
    if(myFlashObj==undefined){
      PrintChat("<div class=\"im_info\"><?=$language['flash_none']?></div>\r\n");
    }else{
      PrintChat("<div class=\"im_info\"><?=$language['link_none']?></div>\r\n");
    }
    return false;
  }
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
  myFlashObj.SendMsg('send','0',message);
  PrintChat("<div class=\"im_to\">"+cnickname+"  " + Now() + "</div>\r\n<div class=\"im_content\">" + ubbtohtml(message) + "</div>\r\n");
  $('inputbox').value='';
  IsBusy=true;
}
function selfaq(id){
  myFlashObj.SendMsg('faq',id,'');
}
function SwfInit(){
  myFlashObj = isIE ? myFlash : document.myFlash;
  myFlashObj.SetVariable("BaseUrl", homepage+'getdata/content/client.php');
  myFlashObj.SetVariable("CompanyId", cid);
  myFlashObj.SetVariable("WorkerId", wid);
  myFlashObj.SetVariable("WorkerName", wnickname);
  myFlashObj.SetVariable("ClientId", uid);
}
function FindServer(){
  if(IsConnect){
    $('showbox').innerHTML="<div class=\"im_info\"><?=$language['link_suc']?></div>\r\n";
    if(tiptext.length>1){
      PrintChat("<div class=\"im_tip\">"+ tiptext + "</div>\r\n");
    }
  }else if(LinkTime>=80){
    $('showbox').innerHTML='<?=$language['link_error']?>';
  }else{
    LinkTime++;
    setTimeout("FindServer()",100);
    myFlashObj.SendMsg('init','','');
  }
}
function window_onload(){
  $('showbox').innerHTML="<div class=\"im_info\"><?=$language['link_start']?></div>\r\n";
  SwfInit();
  FindServer();
  $('inputbox').focus();
  var tmp='<ul>';
  for(var i=0;i<smileys.length;i++){
    tmp+='<li id="t_'+i+'" onclick="sel_smiley_g('+i+')">'+smileys[i][0]+'</li>';
  }
  tmp+='</ul>';
  $('s_title').innerHTML=tmp;
}
function saveas() {
  try {
    var savestyle='<style type="text/css"> <!--body{margin: 0px; padding: 0px 0px 0px 0px; border: 0px;FONT-SIZE: 9pt; FONT-FAMILY: Tahoma;}.im_to{color:#008040;height:18px;line-height:18px;}.im_from{color:#0000ff;height:18px;line-height:18px;}.im_content{color:#000000;padding-left:10px;}.im_tip{color:#0000ff;}.error{color:#7982c1;height:18px;line-height:18px;padding-left:20px;background:url(im_info.gif) no-repeat 2px 1px;}--></style>';
    var time=new Date();
    var filename=time.toLocaleDateString();
    filename=filename+" <?=$webtitle?>.htm";
    var winSave=window.open('about:blank','_blank','top=10000');
    winSave.document.open("text/html","utf-8");
		winSave.document.write("<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><base target=\"_blank\">"+savestyle+"</head><body>"+$("showbox").outerHTML+"</body></html>");
    winSave.document.execCommand ("SaveAs",true,filename);
    winSave.close();
  }
  catch(e){}
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
      cursmiley=index;
    }else{
      $('t_'+i).className='';
    }
  }
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
	var url = prompt('<?=$language['inserturl']?>','http://');
	if(url==null || url=='' || url=='http://'){
    $('inputbox').focus();
    return false;
	}
  $('inputbox').value+='[url]'+url+'[/url]';
  $('inputbox').focus();
}
function insertpic(){
	var url = prompt('<?=$language['insertpic']?>','http://');
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
}
function window_onunload(){
  myinfo.wid.value=wid;
  myinfo.submit();<?if($closetip){?>
  
  alert("<?=$closetip?>");<?}?>
  
}
function PrintChat(str,islog){
	$('showbox').innerHTML += str;
	ScrollControl();
}
function ScrollControl(){
	$('showbox').scrollTop+=50000;
}
function Now(){
	date = new Date();
	H_=date.getHours().toString();
	i_=date.getMinutes().toString();
	s_=date.getSeconds().toString();
	if(i_.length==1)i_="0"+i_;
	if(s_.length==1)s_="0"+s_;
	return H_+":"+i_+":"+s_;
}
function UpdateData(){
  var tmp='action=get';
  tmp+='&cid='+cid;
  tmp+='&wid='+wid;
  tmp+='&uid='+uid;
  var x=new Ajax('HTML','');
  x.post(homepage+'getdata/content/client.php',tmp,function(s){
    if(s.indexOf('&fdata=')!=-1){
      var t=s.split('&fdata=');
      myFlash_DoFSCommand('fdata',t[1]);
    }
  });
}
function tmpInput(e){
  myFlashObj.SendMsg('tmpInput','',$('inputbox').value);
}
function myFlash_DoFSCommand(command, args) {
  var myFlashObj = isIE ? myFlash : document.myFlash;
  if(args!="undefined" && args!=""){
    if(command=="init"){
      IsConnect=args=='Y' ? true :false;
    }else if(command=="get"){
      var fdata=args.split("{@}");
      for(i=0;i<fdata.length;i++){
        fdata_=fdata[i].split("{|}");
        if(fdata_[2]=="4"){
          wid=fdata_[3];
          wnickname=fdata_[0];
          SwfInit();
          PrintChat("<div class=\"im_info\">"+ fdata_[1] + "</div>\r\n");
        }else{
          if(fdata_[1]=='eqmk://system.close'){
            ForceClosed=true;
            alert("<?=$language['link_closed']?>");
            window.close();
            return false;
          }
          fdata_[1]=fdata_[1].replace(/＆/g,"&");
          PrintChat("<div class=\"im_from\">"+wnickname+"  " + fdata_[0] + "</div>\r\n<div class=\"im_content\">" + fdata_[1] + "</div>\r\n");
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
    }else if(command=="send"){
      $('div_pingfen').innerHTML='';
      $('showbox').innerHTML = $('showbox').innerHTML.replace('<div id="div_pingfen"></div>','');
    }
  }
}
<?if($allowpingfen){?>
function pingfen(){
  PrintChat('<div id="div_pingfen"><div><br /><?=$language['pingfenti']?></div><div><?=$pingfens?></div><div><input type="button" value="<?=$language['pingfenbtn']?>" onclick="selfen()"></div>\r\n</div>');
}
function selfen(){
  if($('div_pingfen') && $('div_pingfen').style.display=='none'){
    alert('<?=$language['pingfenover']?>');
    return false;
  }
  var fen=2;
  for(i=0;i<$("myfen").length;i++){
    if($("myfen").checked){
      fen=$("myfen").value;
      break;
    }
  }
  myFlashObj.SendMsg('pingfen',fen,'');
}
<?}?>
var ForceClosed=false;
function window_beforeunload(){
  if(!ForceClosed){
    window.event.returnValue="<?=$language['unloadword']?>";
  }
}
if (navigator.appName && navigator.appName.indexOf("Microsoft") != -1 && navigator.userAgent.indexOf("Windows") != -1 && navigator.userAgent.indexOf("Windows 3.1") == -1) {
  document.write('<SCRIPT LANGUAGE=VBScript\> \n');
  document.write('on error resume next \n');
  document.write('Sub myFlash_FSCommand(ByVal command, ByVal args)\n');
  document.write(' call myFlash_DoFSCommand(command, args)\n');
  document.write('end sub\n');
  document.write('</SCRIPT\> \n');
}
function KeyDown(){
	if (window.event.keyCode == 116){	
		event.keyCode = 0;
		event.returnValue = false;
	}
}
document.onkeydown = KeyDown;
var WorkerIndex=<?=$kefuindex?>;
var WorkerToken='<?=$wid?>,<?=$index?>';
var WorkerList=new Array();
<?$i=0;
foreach($wlist as $rs){?>
WorkerList[<?=$i?>]=new Array('<?=implode("','",$rs)?>');
<?$i++;
}?>
var wnickname='<?=$nickname?>';
</script>
<script type="text/javascript" src="include/javascript/dialog.js"></script>
</head>
<body onbeforeunload="window_beforeunload();" onload="window_onload()" onunload="window_onunload()">
  <div id="body" class="body">
    <div class="table">
      <div class="title">
        <div class="logo"><?=$dialogtitle?></div>
        <ul class="menu">
          <li id="m1"<?=$online?' class="sel"':''?> onmouseover="MenuOvr(1)" onmouseout="MenuOut(1)" onclick="MenuClick(1)"><?=$language['label_title_talk']?></li>
          <li id="m2"<?=!$online?' class="sel"':''?> onmouseover="MenuOvr(2)" onmouseout="MenuOut(2)" onclick="MenuClick(2)"><?=$language['label_title_book']?></li>
          <li id="m3" onmouseover="MenuOvr(3)" onmouseout="MenuOut(3)" onclick="MenuClick(3)"><?=$language['label_title_phone']?></li>
          <li id="m4" onmouseover="MenuOvr(4)" onmouseout="MenuOut(4)" onclick="MenuClick(4)"><?=$language['label_title_order']?></li>
        </ul>
      </div>
      <div class="main" id="mainbody">
        <div class="left" id="mainbody1" style="display:<?=$online?'':'none'?>">
          <div class="dialog" id="dialogdiv">
             <div class="title"><?=$tiptitle?> &nbsp;<span id="winput"></span></div>
            <div class="show" id="showbox" onclick="CloseAllDiv()"></div>
            <div class="toolbar" id="toolbardiv">
              <ul>


                <?if(CheckGrade('smiley')){?><li class="smileys" title="<?=$language['smiley']?>" onclick="sel_smiley_g(-1)"><?=$language['btn_smiley']?></li><?}?>
                <li class="image" title="<?=$language['image']?>" onclick="insertimageurl()"><?=$language['btn_image']?></li>
                <li class="quake" title="<?=$language['quake']?>" onclick="windowquake()"><?=$language['btn_quake']?></li>
                <?if(CheckGrade('file')){?><li class="file" title="<?=$language['file']?>" onclick="CloseAllDiv();$('upload').style.display='';"><?=$language['btn_file']?></li><?}?>
                <li class="save" title="<?=$language['save']?>" onclick="saveas()"><?=$language['btn_save']?></li>
                <li class="change" title="<?=$language['change']?>" onclick="changeKefu()"><?=$language['btn_change']?></li>
                <?if($allowpingfen){?><li class="pingfen" title="<?=$language['pingfen']?>" onclick="pingfen()"><?=$language['btn_pingfen']?></li><?}?>
              </ul>
            </div>
            <div class="input" id="inputdiv" onclick="CloseAllDiv()">
              <textarea id="inputbox" onkeydown="input_onkeydown(event)" onkeyup="tmpInput(event)" onclick="if($('imagediv').style.display=='')getimage2();fssclose();"></textarea>
              <div class="btn2" onmouseover="this.className='btn1'" onmouseout="this.className='btn2'" onclick="send();fssclose();"></div>
			  <div class="btn_key" style="cursor:hand" onClick="fssshow()">
			  </div>
<div id="fss">
  <table style="border:1px #85A6DD solid" height="60" width="150" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="left"><label for="radio1"><?=$language['Enter']?></label><input name="fsf" id="radio1" type="radio" value="1" class="weboradioHidden" checked>
      </td>
    </tr>
    <tr>
      <td align="left"><label for="radio2"><?=$language['CtrlEnter']?></label><input name="fsf" id="radio2" type="radio" value="2" class="weboradioHidden">
      </td>
    </tr>
  </table>
</div>
            </div>
            <?if(CheckGrade('smiley')){?>
            <div id="smiley" class="smiley" style="display:none">
              <div class="title_" id="s_title"></div>
              <div class="content_ clearfix2" id="s_content"></div>
            </div>
            <?}?>
            <script type="text/javascript">$('inputbox').focus();</script>
            <?if(CheckGrade('file')){?>
            <div id="upload" class="upload" style="display:none">
              <?=$language['filesize']?> <?=$maxfilesize?>MB<br />
              <?=$language['filetype']?> <?=$allowfiletype?> 
              <form action="upload.php?cid=<?=$cid?>&wid=<?=$wid?>&uid=<?=$uid?>" target="upload_frame" name="myfile" id="myfile" method="post" enctype="multipart/form-data">
                <input type="file" name="myFile" size="20">
                <input type="submit" value="<?=$language['sendfile']?>" onclick="$('upload').style.display='none'">
                <input type="button" value="<?=$language['close']?>" onclick="$('upload').style.display='none'">
              </form>
            </div>
            <?}?>
            <div id="imagediv" class="uploadimage" style="display:none"><?=$language['picurl']?>
            <input type="text" id="insertimage" size="50" onkeyup="getimage(event)">
            </div>
          </div>
        </div>
        <div class="left" id="mainbody2" style="display:<?=$online?'none':''?>">
          <div class="dialog">
            <div class="title"><?=$language['label_title_book']?></div>
            <div class="show other"><br />
<form action="getdata/save.php" method="post" name="bookform" target="info_frame" enctype="multipart/form-data">
<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%" height="20" align="right"><?=$language['label_sort']?></td>
    <td width="80%"><?=$dialogsort?></td>
  </tr>
  <tr>
    <td height="25" align="right"><?=$language['label_realname']?></td>
    <td><input type="text" class="text" name="realname" maxlength="100" style="width:300px"></td>
  </tr>
  <tr>
    <td height="25" align="right"><?=$language['label_email']?></td>
    <td><input type="text" class="text" name="email" maxlength="100" style="width:300px"></td>
  </tr>
  <tr>
    <td height="25" align="right"><?=$language['label_phone']?></td>
    <td><input type="text" class="text" name="phone" maxlength="100" style="width:300px"></td>
  </tr>
  <tr>
    <td height="25" align="right"><?=$language['label_im']?></td>
    <td><input type="text" class="text" name="im" maxlength="100" style="width:300px"></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" style="padding-top:2px"><?=$language['label_co_book']?></td>
    <td>
      <textarea class="formresult" name="co" onkeydown="input_onkeydown(event)" onkeyup="tmpInput(event)"></textarea>
      <div class="btn2" onmouseover="this.className='btn1'" onmouseout="this.className='btn2'" onclick="booksubmit()"></div>
    </td>
  </tr>
</table>
<input type="hidden" name="cid" value="<?=$cid?>">
<input type="hidden" name="wid" value="<?=$wid?>">
<input type="hidden" name="uid" value="<?=$uid?>">
<input type="hidden" name="ntype" value="book">
</form>
            </div>
            <div class="toolbar"><div><?=$language['label_title_result_book']?></div></div>
            <div class="result">
              <?=$bookresult?>
            </div>
          </div>
        </div>
        <div class="left" id="mainbody3" style="display:none">
          <div class="dialog">
            <div class="title"><?=$language['label_title_phone']?></div>
            <div class="show other"><br />
<form action="getdata/save.php" method="post" name="phoneform" target="info_frame" enctype="multipart/form-data">
<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%" height="20" align="right"><?=$language['label_sort']?></td>
    <td width="80%"><?=$dialogsort?></td>
  </tr>
  <tr>
    <td height="25" align="right"><?=$language['label_phone']?></td>
    <td><input type="text" class="text" name="phone" maxlength="100" style="width:300px"></td>
  </tr>
  <tr>
    <td height="25" align="right"><?=$language['label_realname2']?></td>
    <td><input type="text" class="text" name="realname" maxlength="100" style="width:300px"></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" style="padding-top:2px"><?=$language['label_co_phone']?></td>
    <td>
      <textarea class="formresult" name="co" onkeydown="input_onkeydown(event)" onkeyup="tmpInput(event)"></textarea>
      <div class="btn2" onmouseover="this.className='btn1'" onmouseout="this.className='btn2'" onclick="phonesubmit()"></div>
    </td>
  </tr>
</table>
<input type="hidden" name="cid" value="<?=$cid?>">
<input type="hidden" name="wid" value="<?=$wid?>">
<input type="hidden" name="uid" value="<?=$uid?>">
<input type="hidden" name="ntype" value="phone">
</form>
            </div>
            <div class="toolbar"><div><?=$language['label_title_result_phone']?></div></div>
            <div class="result">
              <?=str_replace('#ip#',$onlineip,$language['label_phone_readme'])?>
            </div>
          </div>
        </div>
        <div class="left" id="mainbody4" style="display:none">
          <div class="dialog">
            <div class="title"><?=$language['label_title_order']?></div>
            <div class="show other"><br />
<form action="getdata/save.php" method="post" name="orderform" target="info_frame" enctype="multipart/form-data">
<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%" height="20" align="right"><?=$language['label_product']?></td>
    <td width="80%">
      <input type="text" class="text" name="title" maxlength="100" style="width:187px">
      <?=$language['label_buynum']?><input type="text" class="text" name="buynum" maxlength="10" style="width:60px">
    </td>
  </tr>
  <tr>
    <td height="25" align="right"><?=$language['label_realname']?></td>
    <td><input type="text" class="text" name="realname" maxlength="100" style="width:300px"></td>
  </tr>
  <tr>
    <td height="25" align="right"><?=$language['label_email']?></td>
    <td><input type="text" class="text" name="email" maxlength="100" style="width:300px"></td>
  </tr>
  <tr>
    <td height="25" align="right"><?=$language['label_phone']?></td>
    <td><input type="text" class="text" name="phone" maxlength="100" style="width:300px"></td>
  </tr>
  <tr>
    <td height="25" align="right"><?=$language['label_im']?></td>
    <td><input type="text" class="text" name="im" maxlength="100" style="width:300px"></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top" style="padding-top:2px"><?=$language['label_co_order']?></td>
    <td>
      <textarea class="formresult" name="co" onkeydown="input_onkeydown(event)" onkeyup="tmpInput(event)"></textarea>
      <div class="btn2" onmouseover="this.className='btn1'" onmouseout="this.className='btn2'" onclick="ordersubmit()"></div>
    </td>
  </tr>
</table>
<input type="hidden" name="cid" value="<?=$cid?>">
<input type="hidden" name="wid" value="<?=$wid?>">
<input type="hidden" name="uid" value="<?=$uid?>">
<input type="hidden" name="ntype" value="order">
</form>
            </div>
            <div class="toolbar"><div><?=$language['label_title_result_order']?></div></div>
            <div class="result">
              <?=$orderresult?>
            </div>
          </div>
        </div>
        <div class="right">
          <div class="info">
            <div class="title">
              <div id="btnA" class="sel" onclick="InfoClick('A')"><?=$language['label_btn_a']?></div>
              <div id="btnB" onclick="InfoClick('B')"><?=$language['label_btn_b']?></div>
            </div>
            <div class="content" id="coA" style="display:"><div class="scroll" id="scroll"><?=$companyinfo?></div></div>
            <div class="content" id="coB" style="display:none">
<table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="30%" height="20" align="right"><?=$language['label_worker_nickname']?></td>
    <td id="w_nickname"><?=$nickname?></td>
  </tr>
  <tr>
    <td height="20" align="right"><?=$language['label_worker_sex']?></td>
    <td id="w_sex"><?=$sex?></td>
  </tr>
  <tr>
    <td height="20" align="right"><?=$language['label_worker_city']?></td>
    <td id="w_city"><?=$city?></td>
  </tr>
  <tr>
    <td height="20" align="right"><?=$language['label_worker_phone']?></td>
    <td id="w_phone"><?=$phone?></td>
  </tr>
  <tr>
    <td height="20" align="right"><?=$language['label_worker_email']?></td>
    <td id="w_email"><?=$email?></td>
  </tr>
  <tr>
    <td height="20" align="right"><?=$language['label_worker_im']?></td>
    <td id="w_qq"><?=$qq?></td>
  </tr>
  <tr>
    <td height="20" align="right" valign="top"><?=$language['label_worker_co']?></td>
    <td id="w_content"><?=$content?></td>
  </tr>
  <tr>
    <td height="40" align="right" valign="top"></td>
    <td id="w_content"><div class="kefucard"><a href="?mod=card&wid=<?=$wid?>" target="_blank">下载客服名片</a></div></td>
  </tr>
</table>
            </div>
          </div>
          <div class="logo" id="logodiv">
            <div class="title"> </div>
            <div class="content"><a href="<?=$dialoglogourl?>" target="_blank"><img src="<?=$dialoglogo?>" border="0" /></a></div>
          </div>
        </div>
        <div class="link">
          <?if(!CheckGrade('delad') || !$dialogad){?>
          <div class="title"><?=$language['adtitle']?></div>
          <div class="content"><script src="<?=$homepage?>api/ads.php?t=dialog&cid=<?=$cid?>" type="text/javascript"></script></div>
          <?}else{
          print('&nbsp;'.$dialogad);
          }?>
        </div>
      </div>
    </div>
  </div>
  <?if(CheckGrade('file')){?><iframe frameborder="0" id="upload_frame" name="upload_frame" scrolling="no" src="about:blank" style="display:none"></iframe><?}?>
  <iframe frameborder="0" id="info_frame" name="info_frame" scrolling="no" src="about:blank" style="display:none"></iframe>
  <form style="display:none" action="getdata/content/client.php" target="info_frame" name="myinfo" id="myinfo" method="post">
  <input type="hidden" name="action" value="bye">
  <input type="hidden" name="cid" value="<?=$cid?>">
  <input type="hidden" name="wid" value="<?=$wid?>">
  <input type="hidden" name="uid" value="<?=$uid?>">
  </form>
  <?if($allowpingfen){?>
  <form style="display:none" action="getdata/content/client.php" target="info_frame" name="mypingfen" id="mypingfen" method="post">
  <input type="hidden" name="action" value="pingfen">
  <input type="hidden" name="cid" value="<?=$cid?>">
  <input type="hidden" name="wid" value="<?=$wid?>">
  <input type="hidden" name="uid" value="<?=$uid?>">
  <input type="hidden" name="fen" value="2">
  </form>
  <?}?>

<?if($language_dialog=='zh-tw'){?>
<script type="text/javascript" src="include/javascript/charset.js"></script>
<script type="text/javascript">turnlang('$lang_web');</script>
<?}?>
<embed id="thesound" src="sound/msg.wav" hidden="true" autostart="false" loop="false"></embed>
</body>
</html>