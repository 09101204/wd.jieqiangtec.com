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
            <div class="title" id="dialogtitle"><?=$tiptitle?> &nbsp;<span id="winput"></span></div>
            <div class="show" id="showbox" onclick="CloseAllDiv()"><?=$FAQ?></div>
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