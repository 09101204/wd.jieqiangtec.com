<?
define('IN_KEFU', TRUE);
include_once("check.php");
include_once('../eqmkdata/sort.inc.php');
$lt=$time;
$nickname=thischarset($w[0]['nickname']);
$db->update("worker","online,updatetime","1|$time","companyid='$cid' and id=$wid");
writeover('../eqmkdata/cache/__system_login_'.$wid.'.txt',$lt);

$setting=$db->record("setting","company,keywords,description,grade","companyid='$cid'",1);
$Grade=explode(',',$setting[0]['grade']);
$company=thischarset($setting[0]['company']);
$keywords=thischarset($setting[0]['keywords']);
$description=thischarset($setting[0]['description']);

$filetype=str_replace('|',' ',$allowfiletype);
$myname=$language['you'];
if($style=$db->record("style","dialogstyle","companyid='$cid'",1)){
  $dialogstyle=$style[0]['dialogstyle'];
}
if(!$dialogstyle)$dialogstyle='blue';
$css1="images/dialog.css";
$mtime_css1=GetmTime("images/dialog.css");
if($mtime_css1)$mtime_css1="?".$mtime_css1;
$css2="images/default/style.css";
$mtime_css2=GetmTime("images/default/style.css");
if($mtime_css2)$mtime_css2="?".$mtime_css2;
$webtitle=$language['049'].' - '.$company;
$tip=$language['050'].','.$language['051'];
$IsSuper=CheckGrade('super');
$o=explode(',',$nickname);
if($IsSuper && count($o)>1){
  $accountlist='<select id="AccountList">';
  foreach($o as $v){
    if($v){
      $accountlist.='<option value="'.$v.'">'.$v.'</option>';
    }
  }
  $accountlist.='</select>';
}else{
  $IsSuper=false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META http-equiv="Content-Type" content="text/html; charset=<?=$webcharset?>" />
<title><?=$webtitle?></title>
<meta name="keywords" content="<?=$keywords?>">
<meta name="description" content="<?=$description?>">
<link href="<?=$css1?><?=$mtime_css1?>" rel="stylesheet" type="text/css" />
<link href="<?=$css2?><?=$mtime_css2?>" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript">
function stopError() {
  return true;
}
window.onerror = stopError;
var isIE = document.all && window.external ? 1 : 0;
var homepage="<?=$homepage?>";
var cid="<?=$cid?>";
var wid="<?=$wid?>";
var lt="<?=$lt?>";
var myname="<?=$nickname?>";
var cursmiley=0;
var CurMenuIndex=0;
var myFlashObj=null;
var Worker=new Object(),Client=new Object();
var UidsA='',UidsB='';
var SystemMsg='';
var PublicMsg='';
var ChatIndex='';
var ChatType='s';
var Tip='<?=$tip?>';
var IsSuper=<?=$IsSuper?'true':'false'?>;
var TimeAdd=(new Date()).getTime()-(new Date(<?=date('Y,m,d,H,i,s',$time)?>)).getTime();
window.opener=null;
var language=new Object();
language['023']='<?=str_replace("'","\'",$language['023'])?>';
language['033']='<?=str_replace("'","\'",$language['033'])?>';
language['061']='<?=str_replace("'","\'",$language['061'])?>';
language['065']='<?=str_replace("'","\'",$language['065'])?>';
language['066']='<?=str_replace("'","\'",$language['066'])?>';
language['105']='<?=str_replace("'","\'",$language['105'])?>';
language['108']='<?=str_replace("'","\'",$language['108'])?>';
language['109']='<?=str_replace("'","\'",$language['109'])?>';
language['110']='<?=str_replace("'","\'",$language['110'])?>';
language['111']='<?=str_replace("'","\'",$language['111'])?>';
language['112']='<?=str_replace("'","\'",$language['112'])?>';
language['113']='<?=str_replace("'","\'",$language['113'])?>';
language['114']='<?=str_replace("'","\'",$language['114'])?>';
language['115']='<?=str_replace("'","\'",$language['115'])?>';
language['116']='<?=str_replace("'","\'",$language['116'])?>';
language['117']='<?=str_replace("'","\'",$language['117'])?>';
language['118']='<?=str_replace("'","\'",$language['118'])?>';
language['119']='<?=str_replace("'","\'",$language['119'])?>';
language['120']='<?=str_replace("'","\'",$language['120'])?>';
language['121']='<?=str_replace("'","\'",$language['121'])?>';
language['122']='<?=str_replace("'","\'",$language['122'])?>';
language['123']='<?=str_replace("'","\'",$language['123'])?>';
language['124']='<?=str_replace("'","\'",$language['124'])?>';
language['125']='<?=str_replace("'","\'",$language['125'])?>';
language['126']='<?=str_replace("'","\'",$language['126'])?>';
language['127']='<?=str_replace("'","\'",$language['127'])?>';
language['128']='<?=str_replace("'","\'",$language['128'])?>';
language['129']='<?=str_replace("'","\'",$language['129'])?>';
language['130']='<?=str_replace("'","\'",$language['130'])?>';
language['131']='<?=str_replace("'","\'",$language['131'])?>';
language['132']='<?=str_replace("'","\'",$language['132'])?>';
language['133']='<?=str_replace("'","\'",$language['133'])?>';
language['134']='<?=str_replace("'","\'",$language['134'])?>';
language['135']='<?=str_replace("'","\'",$language['135'])?>';
language['136']='<?=str_replace("'","\'",$language['136'])?>';
language['137']='<?=str_replace("'","\'",$language['137'])?>';
language['138']='<?=str_replace("'","\'",$language['138'])?>';
language['139']='<?=str_replace("'","\'",$language['139'])?>';
language['140']='<?=str_replace("'","\'",$language['140'])?>';
language['141']='<?=str_replace("'","\'",$language['141'])?>';
language['142']='<?=str_replace("'","\'",$language['142'])?>';
language['143']='<?=str_replace("'","\'",$language['143'])?>';
language['144']='<?=str_replace("'","\'",$language['144'])?>';
language['145']='<?=str_replace("'","\'",$language['145'])?>';
language['146']='<?=str_replace("'","\'",$language['146'])?>';

var smileys=new Array();
<?if(CheckGrade('smiley')){?>
<?for($i=0;$i<count($smileys);$i++){?>

smileys[<?=$i?>]=new Array("<?=thischarset($smileys[$i][0])?>","<?=$smileys[$i][1]?>",<?=$smileys[$i][2]?>,<?=$smileys[$i][3]?>);<?}}?>
</script>
<script type="text/javascript" src="js/worker.js"></script>
</head>
<body onbeforeunload="window_beforeunload();" onload="window_onload()">
<div id="body" class="body">
  <div class="table">
    <div class="title">
      <div class="logo"><?=$dialogtitle?></div>
      <ul class="menu">
        <li id="m1" onmouseover="MenuOvr(1)" onmouseout="MenuOut(1)" onclick="MenuClick(1)"><?=$language['052']?></li>
        <li id="m2" onmouseover="MenuOvr(2)" onmouseout="MenuOut(2)" onclick="MenuClick(2)"><?=$language['053']?></li>
        <li id="m3" onmouseover="MenuOvr(3)" onmouseout="MenuOut(3)" onclick="MenuClick(3)"><?=$language['054']?></li>
        <li id="m5" onmouseover="MenuOvr(5)" onmouseout="MenuOut(5)" onclick="MenuClick(5)"><?=$language['055']?></li>
        <li id="m6" onmouseover="MenuOvr(6)" onmouseout="MenuOut(6)" onclick="MenuClick(6)"><?=$language['056']?></li>
        <li id="m7" onmouseover="MenuOvr(7)" onmouseout="MenuOut(7)" onclick="MenuClick(7)"><?=$language['057']?></li>
        <li id="m4" onmouseover="MenuOvr(4)" onmouseout="MenuOut(4)" onclick="MenuClick(4)"><?=$language['058']?></li>
      </ul>
    </div>
    <div class="main" id="mainbody">
      <div class="left">
        <div class="info">
          <div class="title">
            <div id="btnA" class="sel" onclick="InfoClick('A')"><?=$language['059']?></div>
            <div id="btnB" onclick="InfoClick('B')"><?=$language['060']?></div>
          </div>
          <div class="content list" id="coA" style="display:">
            <?if($IsSuper){?><div class="accountlist"><?=$accountlist?></div><?}?>
            <div class="public" id="public_" onclick="OpenDialog('public','')"><?=$language['061']?></div>
            <div class="list_open" onmousedown="HitListTi(this,'company',event)"><?=$language['062']?>(<span id="count_company" class="count">0</span>)</div>
            <ul id="companylist"></ul>
            <div class="list_open" onmousedown="HitListTi(this,'client',event)"><?=$language['063']?>(<span id="count_client" class="count">0</span>)</div>
            <ul id="clientlist"></ul>
            <div class="list_open" onmousedown="HitListTi(this,'last',event)"><?=$language['064']?>(<span id="count_last" class="count">0</span>)</div>
            <ul id="lastlist"></ul>
          </div>
          <div class="content" id="coB" style="display:none"><div id="UserInfo"></div></div>
        </div>
      </div>
      <div class="chat">
        <div class="dialog" id="dialogdiv">
          <div class="title">
            <span id="dialogtitle"><?=$language['065']?></span>
            <span id="closebtn" onclick="CloseCur()" style="display:none" title="<?=$language['066']?>"></span>
          </div>
          <div class="show" id="showbox" onclick="CloseAllDiv()"></div>
          <div class="toolbar" id="toolbardiv">
            <ul id="toolbarlist">
              <?if(CheckGrade('smiley')){?><li class="smileys" title="<?=$language['147']?>" onclick="sel_smiley_g(-1)"><?=$language['148']?></li><?}?>
              <li class="image" title="<?=$language['149']?>" onclick="insertimageurl()"><?=$language['150']?></li>
              <?if(CheckGrade('file')){?><li class="file" title="<?=$language['151']?>" onclick="$('upload').style.display=''"><?=$language['152']?></li><?}?>
              <li class="change" id="toolbar_change" title="<?=$language['067']?>" onclick="changekefu()"><?=$language['068']?></li>
              <li class="history" id="toolbar_history" title="<?=$language['069']?>" onclick="history()"><?=$language['070']?></li>
              <li class="save" title="<?=$language['153']?>" onclick="saveas()"><?=$language['154']?></li>
            </ul>
          </div>
          <div class="input disabled" id="inputdiv" onclick="CloseAllDiv()">
            <textarea id="inputbox" onkeydown="input_onkeydown(event)" onkeyup="tmpInput(event)" onclick="if($('imagediv').style.display=='')getimage2()"></textarea>
            <div id="inputbtn" class="btn2" onmouseover="this.className='btn1'" onmouseout="this.className='btn2'" onclick="send()"></div>
          </div>
          <?if(CheckGrade('smiley')){?>
          <div id="smiley" class="smiley" style="display:none">
            <div class="title_" id="s_title"></div>
            <div class="content_" id="s_content"></div>
          </div>
          <?}?>
          <script type="text/javascript">try{$('inputbox').focus();}catch(e){}</script>
          <?if(CheckGrade('file')){?>
          <div id="upload" class="upload" style="display:none"><?=$language['155']?> <?=$maxfilesize?>MB<br /><?=$language['156']?> <?=$allowfiletype?> 
            <form action="upload.php" target="upload_frame" name="myfile" id="myfile" method="post" enctype="multipart/form-data">
              <input type="file" class="filebox" name="myFile">
              <input type="submit" value="<?=$language['157']?>" onclick="$('upload').style.display='none'">
              <input type="button" value="<?=$language['158']?>" onclick="$('upload').style.display='none'">
            </form>
            <iframe frameborder="0" id="upload_frame" name="upload_frame" scrolling="no" src="about:blank" style="width:1px;height:1px;display:none">
</iframe>
          </div>
          <?}?>
          <div id="imagediv" class="upload" style="display:none"><?=$language['071']?>
          <input type="text" id="insertimage" size="60" onkeyup="getimage(event)">
          </div>
        </div>
      </div>
      <div class="link">
        <div class="title" onclick="myFlashObj.SendMsg('load')"><?=$language['072']?>:</div>
        <div class="content" id="sysmsg"></div>
        <div class="sounddiv"><input type="checkbox" id="soundbox" value="1"><?=$language['073']?></div>
      </div>
    </div>
  </div>
</div>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="1" height="1" align="middle" id="myFlash">
  <param name="allowScriptAccess" value="always" />
  <param name="movie" value="<?=$homepage?>service/kefu.swf<?=$mtime_swf?>"/>
  <param name="quality" value="high" />
  <param name="bgcolor" value="#ffffff" />
  <embed name="myFlash" src="<?=$homepage?>service/kefu.swf<?=$mtime_swf?>" quality="high" bgcolor="#ffffff" width="1" height="1" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" swLiveConnect="true"/>
</object>
<embed id="thesound_msg" src="<?=$homepage?>service/sound/msg.wav" style="display:none" autostart="false" loop="false">
<embed id="thesound_system" src="<?=$homepage?>service/sound/system.wav" style="display:none" autostart="false" loop="false">
<embed id="thesound_newuser" src="<?=$homepage?>service/sound/newuser.wav" style="display:none" autostart="false" loop="false">
<embed id="thesound_online" src="<?=$homepage?>service/sound/online.wav" style="display:none" autostart="false" loop="false">
<div id="myweb_div"></div>
<div id="myweb">
  <div class="title">
    <span id="myweb_ti"><?=$language['065']?></span>
    <span class="close" onmousedown="CloseUrl()" title="<?=$language['066']?>"></span>
  </div>
  <div class="content"><iframe frameborder="0" id="myweburl" name="myweburl" scrolling="auto" src="about:blank" style="width:100%;height:100%">
</iframe></div>
</div>
</body>
</html>