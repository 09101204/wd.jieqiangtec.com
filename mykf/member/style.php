<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="save.php?action=savestyle" method="post" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left" colspan=2>&nbsp;��ʾ����</th>
</tr>
<tr>
<td width="30%" height="20" align="right">�б����⣺</td>
<td width="70%" align="left">
  <input type="text" name="caption" value="<?=$caption?>" size="20" />
</td>
</tr>
<tr>
<td width="30%" height="20" align="right">������뷽ʽ��</td>
<td width="70%" align="left">
  <input type="radio" name="posx" value="left" <?if($posx=='left')echo'checked'?> />
  ��ҳ���
  <input type="radio" name="posx" value="right" <?if($posx=='right')echo'checked'?> />    ��ҳ�Ҳ�</td>
</tr>
<tr>
<td height="20" align="right">����룺</td>
<td align="left">
  <input type="text" name="x" value="<?=$x?>" size="5" />px &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999999"> ����ͼ�����������������Ҳ�ľ���] </span>
</td>
</tr>
<tr>
<td height="20" align="right">�����룺</td>
<td align="left">
  <input type="text" name="y" value="<?=$y?>" size="5" />px &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999999">����ͼ����������������λ��</span>
</td>
</tr>
</table>
<br />
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th align="left" colspan="3">&nbsp;��ʾ���</th>
</tr>
<tr>
<td width="50%" height="20" align="left">ͼ����ʽ
  <input type="button" value="��һ��" onclick="getstyle('icon',CurIcon-1)" />
  <input type="button" value="��һ��" onclick="getstyle('icon',CurIcon+1)" />
</td>
<td width="50%" height="20" align="left">�б���ʽ
  <input type="button" value="��һ��" onclick="getstyle('list',CurList-1)" <?if(!CheckGrade('selworker'))print('disabled')?>/>
  <input type="button" value="��һ��" onclick="getstyle('list',CurList+1)" <?if(!CheckGrade('selworker'))print('disabled')?>/>
</td>
</tr>
<tr>
<td id="showicon" height="200" align="center" valign="bottom"></td>
<td id="showlist" align="center" valign="bottom"><?if(!CheckGrade('selworker'))print('<a href="function.php" style="color:red">δ��ͨ�˹���</a><br /><br /><br /><br /><br />')?></td>
</tr>
<tr>
<td height="20" align="left">�������ʽ
  <input type="button" value="��һ��" onclick="getstyle('tip',CurTip-1)" <?if(!CheckGrade('invite'))print('disabled')?>/>
  <input type="button" value="��һ��" onclick="getstyle('tip',CurTip+1)" <?if(!CheckGrade('invite'))print('disabled')?>/>
</td>
<td height="20" align="left">�Ի�����ʽ
  <input type="button" value="��һ��" onclick="getstyle('dialog',CurDialog-1)" />
  <input type="button" value="��һ��" onclick="getstyle('dialog',CurDialog+1)" />
</td>
</tr>
<tr>
<td id="showtip" height="200" align="center" valign="bottom"><?if(!CheckGrade('invite'))print('<a href="function.php" style="color:red">δ��ͨ�˹���</a><br /><br /><br /><br /><br />')?></td>
<td id="showdialog" align="center" valign="bottom"></td>
</tr>
</tr>
</table>
<input type="hidden" name="iconstyle" value="<?=$iconstyle?>"/>
<input type="hidden" name="liststyle" value="<?=$liststyle?>"/>
<input type="hidden" name="tipstyle" value="<?=$tipstyle?>"/>
<input type="hidden" name="dialogstyle" value="<?=$dialogstyle?>"/>
<p align="center">
  <input type="submit" name="submit" value=" ���� "/>
</p>
</form>
<script type="text/javascript">
var IconStyle=new Array();
var ListStyle=new Array();
var TipStyle=new Array();
var DialogStyle=new Array();
var CurIcon=0;
var CurList=0;
var CurTip=0;
var CurDialog=0;
<?$tplpath="../skins/kefu/icon";
$dh=opendir($tplpath);$i=0;
while ($file=readdir($dh)) {
if($file!="." && $file!="..") {
if(is_dir($tplpath.'/'.$file)) {
$arr=getimagesize($tplpath.'/'.$file.'/online.gif');?>IconStyle[<?=$i?>]=new Array('<?=$file?>','<?=$arr[0]?>*<?=$arr[1]?>','<?=$tplpath.'/'.$file?>');
<?if($iconstyle==$file)echo"CurIcon=$i;\n";
$i++;}}}
if(CheckGrade('selworker')){
$tplpath="../skins/kefu/list";
$dh=opendir($tplpath);$i=0;
while ($file=readdir($dh)) {
if($file!="." && $file!="..") {
if(is_dir($tplpath.'/'.$file)) {?>ListStyle[<?=$i?>]=new Array('<?=$file?>','<?=$tplpath.'/'.$file?>');
<?if($liststyle==$file)echo"CurList=$i;\n";
$i++;}}}}
if(CheckGrade('invite')){
$tplpath="../skins/kefu/tip";
$dh=opendir($tplpath);$i=0;
while ($file=readdir($dh)) {
if($file!="." && $file!="..") {
if(is_dir($tplpath.'/'.$file)) {?>TipStyle[<?=$i?>]=new Array('<?=$file?>','<?=$tplpath.'/'.$file?>');
<?if($tipstyle==$file)echo"CurTip=$i;\n";
$i++;}}}}
$tplpath="../skins/kefu/dialog";
$dh=opendir($tplpath);$i=0;
while ($file=readdir($dh)) {
if($file!="." && $file!="..") {
if(is_dir($tplpath.'/'.$file)) {?>DialogStyle[<?=$i?>]=new Array('<?=$file?>','<?=$tplpath.'/'.$file?>');
<?if($dialogstyle==$file)echo"CurDialog=$i;\n";
$i++;}}}?>
function getstyle(type,id){
  if(type=='list'){
    if(id<0)id=ListStyle.length-1;
    if(id>=ListStyle.length)id=0;
    CurList=id;
    myform.liststyle.value=ListStyle[id][0];
    $('showlist').innerHTML="<img src='"+ListStyle[id][1]+"/demo.jpg'><br/>��ʶ��<font color='#ff0000'>"+ListStyle[id][0]+"</font>";
  }else if(type=='tip'){
    if(id<0)id=TipStyle.length-1;
    if(id>=TipStyle.length)id=0;
    CurTip=id;
    myform.tipstyle.value=TipStyle[id][0];
    $('showtip').innerHTML="<img src='"+TipStyle[id][1]+"/demo.jpg'><br/>��ʶ��<font color='#ff0000'>"+TipStyle[id][0]+"</font>";
  }else if(type=='dialog'){
    if(id<0)id=DialogStyle.length-1;
    if(id>=DialogStyle.length)id=0;
    CurDialog=id;
    myform.dialogstyle.value=DialogStyle[id][0];
    $('showdialog').innerHTML="<img src='"+DialogStyle[id][1]+"/demo.jpg'><br/>��ʶ��<font color='#ff0000'>"+DialogStyle[id][0]+"</font>";
  }else{
    if(id<0)id=IconStyle.length-1;
    if(id>=IconStyle.length)id=0;
    CurIcon=id;
    myform.iconstyle.value=IconStyle[id][0];
    $('showicon').innerHTML="<img src='"+IconStyle[id][2]+"/online.gif'> <img src='"+IconStyle[id][2]+"/offline.gif'><br/>��ʶ��<font color='#ff0000'>"+IconStyle[id][0]+"</font>&nbsp;�ߴ磺<font color='#ff0000'>"+IconStyle[id][1]+"</font>";
  }
}
getstyle('icon',CurIcon);
<?if(CheckGrade('selworker')){?>getstyle('list',CurList);<?}?>
<?if(CheckGrade('invite')){?>getstyle('tip',CurTip);<?}?>
getstyle('dialog',CurDialog);
</script>
<?include("footer.php");?>