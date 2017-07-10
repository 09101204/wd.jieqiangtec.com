<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="member.php" name="searchform" method="get">
<table border="0" cellspacing="1" align="center" class="list" style="width:500px">
<tr align="left">
<th colspan="2">洽谈记录查询</th>
</tr>
<tr align="left">
<td width="120">内容关键字</td>
<td><input type="text" name="keyword" value=""></td>
</tr>
<tr align="left">
<td width="120">选择客服：</td>
<td>
<select name="workerid">
<?if($grade=='all'){?><option value="0" <?if($workerid=='0')echo'selected'?>>全部客服</option>
<?}?><?foreach($worker as $rs){?><option value="<?=$rs['id']?>" <?if($workerid==$rs['id'])echo'selected'?>><?=$rs['nickname']?></option>
<?}?></select>
</td>
</tr>
<tr align="left">
<td>查询方式：</td>
<td>
<input type="radio" name="t" value="1" <?=$check1?> onclick="s1.style.display='';s2.style.display='none';s3.style.display='none';">近期数据查询
<input type="radio" name="t" value="2" <?=$check2?> onclick="s1.style.display='none';s2.style.display='';s3.style.display='';">历史数据查询
</td>
</tr>
<tr align="left" id="s1" style="display:<?=$display1?>">
<td>选择查询时间：</td>
<td>
<input type="radio" name="thedate" value="-2" <?=$radio1?>><?=date('Y-m-d',$time-86400*2)?><input type="radio" name="thedate" value="-1" <?=$radio2?>><?=date('Y-m-d',$time-86400)?><input type="radio" name="thedate" value="0" <?=$radio3?>><?=date('Y-m-d',$time)?></td>
</tr>
<tr align="left" id="s2" style="display:<?=$display2?>">
<td>起始时间：</td>
<td>
<select name="dt1[y]">
<?for($i=2006;$i<=date('Y',$time);$i++){
$s=$i==$dt1['y'] ? 'selected' : '';?><option value="<?=$i?>" <?=$s?>><?=$i?></option>
<?}?></select>年
<select name="dt1[m]">
<?for($i=1;$i<=12;$i++){
$s=$i==$dt1['m'] ? 'selected' : '';?><option value="<?=$i?>" <?=$s?>><?=$i?></option>
<?}?></select>月
<select name="dt1[d]">
<?for($i=1;$i<=31;$i++){
$s=$i==$dt1['d'] ? 'selected' : '';?><option value="<?=$i?>" <?=$s?>><?=$i?></option>
<?}?></select>日
<select name="dt1[h]">
<?for($i=0;$i<=23;$i++){
$k=$i<10 ?$k='0'.$i : $i;
$s=$i==$dt1['h'] ? 'selected' : '';?><option value="<?=$i?>" <?=$s?>><?=$k?></option>
<?}?></select>时
<select name="dt1[i]">
<?for($i=0;$i<=59;$i++){
$k=$i<10 ?$k='0'.$i : $i;
$s=$i==$dt1['i'] ? 'selected' : '';?><option value="<?=$i?>" <?=$s?>><?=$k?></option>
<?}?></select>分
</td>
</tr>
<tr align="left" id="s3" style="display:<?=$display3?>">
<td>截止时间：</td>
<td>
<select name="dt2[y]">
<?for($i=2006;$i<=date('Y',$time);$i++){
$s=$i==$dt2['y'] ? 'selected' : '';?><option value="<?=$i?>" <?=$s?>><?=$i?></option>
<?}?></select>年
<select name="dt2[m]">
<?for($i=1;$i<=12;$i++){
$s=$i==$dt2['m'] ? 'selected' : '';?><option value="<?=$i?>" <?=$s?>><?=$i?></option>
<?}?></select>月
<select name="dt2[d]">
<?for($i=1;$i<=31;$i++){
$s=$i==$dt2['d'] ? 'selected' : '';?><option value="<?=$i?>" <?=$s?>><?=$i?></option>
<?}?></select>日
<select name="dt2[h]">
<?for($i=0;$i<=23;$i++){
$k=$i<10 ?$k='0'.$i : $i;
$s=$i==$dt2['h'] ? 'selected' : '';?><option value="<?=$i?>" <?=$s?>><?=$k?></option>
<?}?></select>时
<select name="dt2[i]">
<?for($i=0;$i<=59;$i++){
$k=$i<10 ?$k='0'.$i : $i;
$s=$i==$dt2['i'] ? 'selected' : '';?><option value="<?=$i?>" <?=$s?>><?=$k?></option>
<?}?></select>分
</td>
</tr>
</table>
<p align="center">
	<input type="hidden" name="action" value="history">
	<input type="submit" name="submit" value=" 查询 ">
	<input type="button" name="button" onclick="location.href='member.php?action=history'" value=" 重量 ">
	<input type="button" name="button" onclick="location.href='member.php?action=historyby'" value="按访客编辑查询">
</p>
</form>
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
<title><?=$c?>的恰谈记录</title>
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
<?if($dialog[2]==0){?><p align="center"><h4>很抱歉！没有查询到任何洽谈记录</h4></p>
<?}else{?><table border="0" cellspacing="1" align="center" width="98%">
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
  win.document.execCommand('SaveAs','','<?=$c?>.htm')
  win.close();
}
</script>
<input type="button" name="button" onclick="savehistory()" value="保存本页记录到本地">
<table border="0" cellspacing="1" align="center" class="list">
<tr align="left">
<td>
<?foreach($dialog[0] as $r){
$wname=$r["workername"] ? $r["workername"] : $r["workerid"];
$cname=$r["client"] ? $r["client"] : $r["clientid"];
$c=$db->record('client',"clientid,browser,os,prov,systemlanguage,color,screen,charset,thispage,comeurl,ip,address,keyword,search","companyid='$cid' and clientid=".$r["clientid"],1);
$c=$c[0];
?><div onmouseover="this.className='sel'" onmouseout="this.className=''">
<?if($r["action"]=="1"){?><div class="im_to" title="<div style='text-align:left'>客服编号：<?=$r["clientid"]?><br/>客服名称：<?=$wname?></div>"><?=$wname?> <?=$r["addtime"]?></div>
<?}else{?><div class="im_from" title="<div style='text-align:left'>访客编号：<?=$r["clientid"]?><br />IP地址：<?=$c["ip"]?><br />地理位置：<?=$c["address"]?><br />最后页面：<?=$c["thispage"]?><br />来路地址：<?=$c["comeurl"]?><br />操作系统：<?=$c["os"]?></div>"><a href="member.php?action=viewhistory&clientid=<?=$r["clientid"]?>" title="查看该访客所有记录"><?=$cname?></a> <?=$r["addtime"]?></div>
<?}?><div class="im_content"><?=$r["content"]?></div>
</div>
<?}?></td>
</tr>
</table>
<input type="button" name="button" onclick="savehistory()" value="保存本页记录到本地">
<?=$dialog[1]?><?}?><?include("footer.php");?>