<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<form name="myform" action="save.php?action=<?=$action?>" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td width="20%" height="20" align="right">�ײ����ƣ�</td>
<td width="80%" style="color:red"> <?=setinput("text","title",$ti,"",40,100)?></td>
</tr>
<tr>
<td height="20" align="right">��Чʱ�����ͣ�</td>
<td>
<?for($i=0;$i<count($dayTis);$i++){
$s=$dayTis[$i]==$dayti?'checked':'';
if($s)$Js='SetDayName(\''.$dayTis[$i].'\',\''.$dayTis2[$i].'\')';
?>
<input type="radio" id="dayti<?=$i?>" name="dayti" onclick="SetDayName('<?=$dayTis[$i]?>','<?=$dayTis2[$i]?>')" value="<?=$dayTis[$i]?>"<?=$s?>><label for="dayti<?=$i?>" id="dayname<?=$i?>"><?=$dayTis[$i]?></label> 
<?}?>
</td>
</tr>
<tr>
<td height="20" align="right">�ײ���Ч������</td>
<td><input type="text" id="day" name="day" size="6" value="<?=$day?>" onkeyup="SetPrice()"> ��</td>
</tr>
<tr>
<td height="20" align="right">�ײͼ۸�</td>
<td><input type="text" name="price" size="6" value="<?=$price?>" onkeyup="SetPrice()"> Ԫ</td>
</tr>
<tr>
<td height="20" align="right"></td>
<td id="dayDemo"></td>
</tr>
<tr>
<td align="right" height="20">�������ܣ�</td>
<td>
<?$i=0;
foreach($superfun as $rs){
$i++;
echo setinput("checkbox","funs[]",$rs['keyname'],in_array($rs['keyname'],$regfuns)?'checked':'').'<span style="width:60px;cursor:default" title="'.$rs['content'].'">'.$rs['title'].'</span> ';
if($i>0 && $i % 4==0)echo'<br />';
}?>
</td>
</tr>
<tr>
<td height="20" align="right">�ײͼ�飺</td>
<td><?=setinput("textarea","content",$content,"",40,10)?></td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("hidden","id","$id")?> 
<?=setinput("submit","submit",$btnname)?> 
<?=setinput("button","button","������һҳ","onclick='history.go(-1)'")?>
</td>
</tr>
</table>
</form>
<script language="JavaScript">
var thedayti='';
var theday='';
function SetDayName(n,d){
  thedayti=n;
  theday=d;
  myform.day.value=theday;
  $('day').disabled=(thedayti=='��');
  SetPrice();
}
function SetPrice(){
  $('dayDemo').innerHTML='���ײ�'+(thedayti=='��'?'ÿ��':('<font color=blue>'+myform.day.value+'</font>��(ÿ'+thedayti+')'))+' <font color=red>'+myform.price.value+'</font>Ԫ';
}
function checkform(){
  if(myform.title.value.length<1){
    alert("�ײ����Ʋ���Ϊ��");
    myform.title.focus();
    return false;
  }
  return true;
}
<?=$Js?>
</script>
<?include("footer.php");?>