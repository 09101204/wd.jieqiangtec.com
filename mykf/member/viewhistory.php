<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<input type="button" name="button" onclick="location.href='?action=history'" value=" �߼���ѯ ">
<input type="button" name="button" onclick="savehistory()" value="���汾ҳ��¼������">
<style>
.im_to{
  color:#008040;
  height:20px;
  line-height:18px;
  cursor:default;
}
.im_from{
  color:#0000ff;
  height:20px;
  line-height:18px;
  cursor:default;
}
.im_content{
  padding-left:10px;
}
.sel{
  height:20px;
  border:1px solid #79c9ff;
  background:#d5eeff;
}
</style>
<textarea id="mycontent" style="display:none">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�ÿ�<?=$clientid?>��ǡ̸��¼</title>
<style>
body {
	font-size: 12px;
	border:0;
	scrollbar-face-color: #F6F6f6;
	scrollbar-highlight-color: #FFFFFF;
	scrollbar-shadow-color: #F0F2DB;
	scrollbar-3dlight-color: #cccccc;
	scrollbar-arrow-color:  #666666;
	scrollbar-track-color: #FCFDF9;
	scrollbar-darkshadow-color: #cccccc; 
  background:#ffffff url(dialogbg.gif) no-repeat right bottom;
  word-break:break-all;
  line-height:18px;
  overflow:auto;
}
.im_to{
  color:#008040;
  height:20px;
  line-height:18px;
  cursor:default;
}
.im_from{
  color:#0000ff;
  height:20px;
  line-height:18px;
  cursor:default;
}
.im_content{
  padding-left:10px;
}
.sel{
  height:20px;
  border:1px solid #79c9ff;
  background:#d5eeff;
}
</style>
</head>
<body>
<table border="0" cellspacing="1" align="center" width="98%">
<tr align="left">
<td>
<?foreach($dialog[0] as $r){
$wname=$r["workername"] ? $r["workername"] : $r["workerid"];
$cname=$r["client"] ? $r["client"] : $r["clientid"];
?><?if($r["action"]=="1"){?><div class="im_to"><?=$wname?> <?=$r["addtime"]?></div>
<?}else{?><div class="im_from"><?=$cname?> <?=$r["addtime"]?></div>
<?}?><div class="im_content"><?=$r["content"]?></div>
<?}?></td>
</tr>
</table>
</body>
</html>
</textarea>
<script type="text/javascript">
function savehistory(){
  var win=window.open('','','top=10000,left=10000');
  win.document.write(document.all.mycontent.innerText)
  win.document.execCommand('SaveAs','','�ÿ�<?=$clientid?>.htm')
  win.close();
}
</script>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="left">
<td>
<?foreach($dialog[0] as $r){
$wname=$r["workername"] ? $r["workername"] : $r["workerid"];
$cname=$r["client"] ? $r["client"] : $r["clientid"];
$c=$db->record('client',"clientid,browser,os,prov,systemlanguage,color,screen,charset,thispage,comeurl,ip,address,keyword,search","companyid='$cid' and id=".intval($r["clientid"]),1);
$c=$c[0];
?><div onmouseover="this.className='sel'" onmouseout="this.className=''">
<?if($r["action"]=="1"){?><div class="im_to" title="<div style='text-align:left'>�ͷ���ţ�<?=$r["clientid"]?><br/>�ͷ����ƣ�<?=$wname?></div>"><?=$wname?> <?=$r["addtime"]?></div>
<?}else{?><div class="im_from" title="<div style='text-align:left'>�ÿͱ�ţ�<?=$r["clientid"]?><br />IP��ַ��<?=$c["ip"]?><br />����λ�ã�<?=$c["address"]?><br />���ҳ�棺<?=$c["thispage"]?><br />��·��ַ��<?=$c["comeurl"]?><br />����ϵͳ��<?=$c["os"]?></div>"><a href="member.php?action=viewhistory&clientid=<?=$r["clientid"]?>" title="�鿴�÷ÿ����м�¼"><?=$cname?></a> <?=$r["addtime"]?></div>
<?}?><div class="im_content"><?=$r["content"]?></div>
</div>
<?}?></td>
</tr>
</table>
<input type="button" name="button" onclick="savehistory()" value="���汾ҳ��¼������">
<?=$dialog[1]?><?include("footer.php");?>