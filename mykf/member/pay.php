<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");
?>
<form name="myform" action="save.php?action=pay&type=<?=$type?>" onsubmit="return checkform()" method="post">
<?if($type=='exptimes'){?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td width="20%" height="20" align="right">�˻����ͣ�</td>
<td width="80%"><?=$usertype?></td>
</tr>
<tr>
<td height="20" align="right"><?=$PriceOne[0]?>�۸�</td>
<td><font color="#ff0000"><?=$price?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">����ʱ�䣺</td>
<td><input type="text" name="days" value="<?=$days?>" onblur="totalprice()" size="5" maxlength="5"> <?=$PriceOne[0]?></td>
</tr>
<tr>
<td height="20" align="right">�˻���</td>
<td><font color="#ff0000"><?=$money?></font> Ԫ <a href="?action=pay&type=pay" style="color:#0000ff">��ֵ</a></td>
</tr>
<tr>
<td height="20" align="right">֧���ܶ</td>
<td id="TotalPrice"><font color="#ff0000"><?=$totalprice?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">֧����ʽ��</td>
<td><input type="radio" id="paytype1" name="paytype" value="0" <?=$money>=$totalprice ? 'checked' : 'disabled'?>>���֧�� 
<?if($IsPay){?><input type="radio" id="paytype2" name="paytype" value="1" <?if($money<$totalprice)echo 'checked'?>>����֧��<?}?>
</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit"," ȷ������ ")?></td>
</tr>
</table>
<script type="text/javascript">
function totalprice(){
	if(myform.days.value.length<1){
    alert('����д����ʱ��');
    myform.days.focus();
    return false;
	}
	if(isNaN(myform.days.value) || myform.days.value.indexOf('.')!=-1 || myform.days.value<=0){
    alert('����ʱ�����Ϊ������');
    myform.days.focus();
    return false;
	}
	var tprice=myform.days.value*<?=$price?>;
	document.getElementById('TotalPrice').innerHTML='<font color="#ff0000">'+tprice+'</font> Ԫ';
	var obj=document.getElementById('paytype1');
	if(tprice<=<?=$money?>){
    obj.disabled=false;
	}else{
    obj.disabled=true;
    obj.checked=false;
	}
  return true;
}
function checkform(){
  if(!totalprice()){
    return false;
  }
  if(document.getElementById('paytype1').checked==false<?if($IsPay){?> && document.getElementById('paytype2').checked==false<?}?>){
    alert('��ѡ��֧����ʽ');
    return false;
  }
  return confirm('��ȷ��Ҫִ�иò�����');
}
</script>
<?}elseif($type=='pay'){?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td width="20%" height="20" align="right">��ֵ��</td>
<td width="80%"><input type="text" name="pmoney" value="<?=$pmoney?>" onblur="checkmoney()" size="5" maxlength="5"> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">�˻���</td>
<td><font color="#ff0000"><?=$money?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">֧����ʽ��</td>
<td><?if($IsPay){?><input type="radio" id="paytype2" name="paytype" value="1" checked>����֧��<?}else{?>ϵͳ����ͣ����֧�����ܣ��������Ա��ϵ<?}?>
</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit"," ȷ����ֵ ")?></td>
</tr>
</table>
<script type="text/javascript">
function checkmoney(){
	if(myform.pmoney.value.length<1){
		alert('����д��ֵ���');
		myform.pmoney.focus();
		return false;
	}
	if(isNaN(myform.pmoney.value) || myform.pmoney.value<=0){
		alert('��ֵ������Ϊ����');
		myform.pmoney.focus();
		return false;
	}
  return true;
}
function checkform(){
  if(!checkmoney()){
    return false;
  }
  return true;
}
</script>
<?}elseif($type=='reg' || $type=='add'){?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td width="20%" height="20" align="right">�������ƣ�</td>
<td width="80%"><?=$ti?></td>
</tr>
<tr>
<td height="20" align="right">����������</td>
<td><?=$content?></td>
</tr>
<?if($type=='add'){?>
<tr>
<td height="20" align="right">����ʱ�䣺</td>
<td><?=date('Y-m-d',$exptime)?> 
<?if($exptime<$time)echo('���Ѻ����ʼʱ��Ϊ'.date('Y-m-d',$time));?>
</td>
</tr>
<?}?>
<tr>
<td height="20" align="right">���ۣ�</td>
<td><font color="#ff0000"><?=$price?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">��Ч�ڣ�</td>
<td><font color="#ff0000"><?=$days?></font> <?=$PriceOne[0]?></td>
</tr>
<tr>
<td height="20" align="right">����������</td>
<td><select name="num" onchange="totalprice()">
<?for($i=1;$i<=20;$i++){
print("<option value=\"$i\">$i</option>\n");
}?>
</select></td>
</tr>
<tr>
<td height="20" align="right">�˻���</td>
<td><font color="#ff0000"><?=$money?></font> Ԫ <a href="?action=pay&type=pay" style="color:#0000ff">��ֵ</a></td>
</tr>
<tr>
<td height="20" align="right">֧���ܶ</td>
<td id="TotalPrice"><font color="#ff0000"><?=$price?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right"><?=$type=='add' ? '��Ч���ӳ�' : 'ʱ��'?>��</td>
<td id="TotalDays"><font color="#ff0000"><?=$days?></font> <?=$PriceOne[0]?></td>
</tr>
<tr>
<td height="20" align="right">֧����ʽ��</td>
<td><input type="radio" id="paytype1" name="paytype" value="0" <?=$money>=$totalprice ? 'checked' : 'disabled'?>>���֧�� 
<?if($IsPay){?><input type="radio" id="paytype2" name="paytype" value="1" <?if($money<$totalprice)echo 'checked'?>>����֧��<?}?>
</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit"," ȷ������ ")?></td>
</tr>
</table>
<script type="text/javascript">
function totalprice(){
  var num=myform.num.options[myform.num.selectedIndex].value;
	var tprice=num*<?=$price?>;
	var tdays=num*<?=$days?>;
	document.getElementById('TotalPrice').innerHTML='<font color="#ff0000">'+tprice+'</font> Ԫ';
	document.getElementById('TotalDays').innerHTML='<font color="#ff0000">'+tdays+'</font> ��';
	var obj=document.getElementById('paytype1');
	if(tprice<=<?=$money?>){
    obj.disabled=false;
	}else{
    obj.disabled=true;
    obj.checked=false;
	}
  return true;
}
function checkform(){
  if(document.getElementById('paytype1').checked==false<?if($IsPay){?> && document.getElementById('paytype2').checked==false<?}?>){
    alert('��ѡ��֧����ʽ');
    return false;
  }
  return confirm('��ȷ��Ҫ������');
}
</script>
<?}elseif($type=='buyall'){?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td width="20%" height="20" align="right">������ã�</td>
<td width="80%"><font color="#ff0000"><?=$price?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">�˻���</td>
<td><font color="#ff0000"><?=$money?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">֧����ʽ��</td>
<td><input type="radio" id="paytype1" name="paytype" value="0" <?=$money>=$price ? 'checked' : 'disabled'?>>���֧��
<?if($IsPay){?><input type="radio" id="paytype2" name="paytype" value="1">����֧��<?}else{?>ϵͳ����ͣ����֧�����ܣ��������Ա��ϵ<?}?>
</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit"," ȷ������ ")?></td>
</tr>
</table>
<script type="text/javascript">
function checkform(){
  if(document.getElementById('paytype1').checked==false<?if($IsPay){?> && document.getElementById('paytype2').checked==false<?}?>){
    alert('��ѡ��֧����ʽ');
    return false;
  }
  return confirm('��ȷ��Ҫ������');
}
</script>
<?}elseif($type=='buypackage'){?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td width="20%" height="20" align="right">��ǰ�ײ����ƣ�</td>
<td width="80%"><font color="#ff0000"><?=$MyPackage?></font></td>
</tr>
<tr>
<td height="20" align="right">���ײ����ƣ�</td>
<td><font color="#ff0000"><?=$P['title']?></font></td>
</tr>
<tr>
<td height="20" align="right">�������ܣ�</td>
<td><?=$P['funcos']?></td>
</tr>
<tr>
<td height="20" align="right">���ۣ�</td>
<td><font color="#ff0000"><?=$P['price']?></font> Ԫ/<?=$P['dayti']?></td>
</tr>
<tr>
<td height="20" align="right">����������</td>
<td><select name="buynum" onchange="totalprice(this.options[this.selectedIndex].value)">
<?for($i=1;$i<=10;$i++){
$s=$num==$i?'selected':''?>
<option value="<?=$i?>" <?=$s?>><?=$i?></option>
<?}?>
</select>
<?=$P['dayti']?></td>
</tr>
<tr>
<td height="20" align="right">֧���ܶ</td>
<td id="TotalPrice"><font color="#ff0000"><?=$totalprice?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">�˻���</td>
<td><font color="#ff0000"><?=$money?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">֧����ʽ��</td>
<td><input type="radio" id="paytype1" name="paytype" value="0" <?=$money>=$totalprice ? 'checked' : 'disabled'?>>���֧�� 
<?if($IsPay){?><input type="radio" id="paytype2" name="paytype" value="1" <?if($money<$totalprice)echo 'checked'?>>����֧��<?}?>
</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit"," ȷ����ͨ ")?></td>
</tr>
</table>
<script type="text/javascript">
function totalprice(num){
	var tprice=myform.buynum.value*<?=$price?>;
	document.getElementById('TotalPrice').innerHTML='<font color="#ff0000">'+tprice+'</font> Ԫ';
	var obj=document.getElementById('paytype1');
	if(tprice<=<?=$money?>){
    obj.disabled=false;
	}else{
    obj.disabled=true;
    obj.checked=false;
	}
  return true;
}
function checkform(){
  if(!totalprice()){
    return false;
  }
  if(document.getElementById('paytype1').checked==false<?if($IsPay){?> && document.getElementById('paytype2').checked==false<?}?>){
    alert('��ѡ��֧����ʽ');
    return false;
  }
  return confirm('��ȷ��Ҫ������');
}
</script>
<?}elseif($type=='paypackage'){?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td width="20%" height="20" align="right">��ǰ�ײ����ƣ�</td>
<td width="80%"><font color="#ff0000"><?=$MyPackage?></font></td>
</tr>
<tr>
<td height="20" align="right">���ۣ�</td>
<td><font color="#ff0000"><?=$P['price']?></font> Ԫ/<?=$P['dayti']?></td>
</tr>
<tr>
<td height="20" align="right">����������</td>
<td><select name="buynum" onchange="totalprice(this.options[this.selectedIndex].value)">
<?for($i=1;$i<=10;$i++){
$s=$num==$i?'selected':''?>
<option value="<?=$i?>" <?=$s?>><?=$i?></option>
<?}?>
</select>
<?=$P['dayti']?></td>
</tr>
<tr>
<td height="20" align="right">֧���ܶ</td>
<td id="TotalPrice"><font color="#ff0000"><?=$totalprice?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">�˻���</td>
<td><font color="#ff0000"><?=$money?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">֧����ʽ��</td>
<td><input type="radio" id="paytype1" name="paytype" value="0" <?=$money>=$totalprice ? 'checked' : 'disabled'?>>���֧�� 
<?if($IsPay){?><input type="radio" id="paytype2" name="paytype" value="1" <?if($money<$totalprice)echo 'checked'?>>����֧��<?}?>
</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit"," ȷ������ ")?></td>
</tr>
</table>
<script type="text/javascript">
function totalprice(num){
	var tprice=myform.buynum.value*<?=$price?>;
	document.getElementById('TotalPrice').innerHTML='<font color="#ff0000">'+tprice+'</font> Ԫ';
	var obj=document.getElementById('paytype1');
	if(tprice<=<?=$money?>){
    obj.disabled=false;
	}else{
    obj.disabled=true;
    obj.checked=false;
	}
  return true;
}
function checkform(){
  if(!totalprice()){
    return false;
  }
  if(document.getElementById('paytype1').checked==false<?if($IsPay){?> && document.getElementById('paytype2').checked==false<?}?>){
    alert('��ѡ��֧����ʽ');
    return false;
  }
  return confirm('��ȷ��Ҫ������');
}
</script>
<?}elseif($type=='buysort' || $type=='buyworker'){?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td height="20" align="right"></td>
<td><a href="?action=pay&type=reg&keyname=allworker" style="color:blue">��ͨ���޿ͷ����ܣ���ϯ�������ƣ���ѯ����������</a></td>
</tr>
<tr>
<td width="20%" height="20" align="right">���<?=$ti?>������</td>
<td width="80%"><font color="#ff0000"><?=$curcount?></font> ��</td>
</tr>
<tr>
<td height="20" align="right">����������</td>
<td><font color="#ff0000"><?=$usecount?></font> ��</td>
</tr>
<tr>
<td height="20" align="right">����������</td>
<td><font color="#ff0000"><?=$curcount-$usecount?></font> ��</td>
</tr>
<tr>
<td height="20" align="right">Ԥ����������</td>
<td><input type="text" name="buynum" value="<?=$buynum?>" onblur="totalprice()" size="5" maxlength="5"></td>
</tr>
<tr>
<td height="20" align="right">���ۣ�</td>
<td><font color="#ff0000"><?=$price?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">�˻���</td>
<td><font color="#ff0000"><?=$money?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">֧���ܶ</td>
<td id="TotalPrice"><font color="#ff0000"><?=$totalprice?></font> Ԫ</td>
</tr>
<tr>
<td height="20" align="right">֧����ʽ��</td>
<td><input type="radio" id="paytype1" name="paytype" value="0" <?=$money>=$totalprice ? 'checked' : 'disabled'?>>���֧�� 
<?if($IsPay){?><input type="radio" id="paytype2" name="paytype" value="1" <?if($money<$totalprice)echo 'checked'?>>����֧��<?}?>
</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit"," ȷ������ ")?></td>
</tr>
</table>
<script type="text/javascript">
function totalprice(){
	if(myform.buynum.value.length<1){
    alert('����д��������');
    myform.buynum.focus();
    return false;
	}
	if(isNaN(myform.buynum.value) || myform.buynum.value.indexOf('.')!=-1 || myform.buynum.value<=0){
    alert('������������Ϊ������');
    myform.buynum.focus();
    return false;
	}
	var tprice=myform.buynum.value*<?=$price?>;
	document.getElementById('TotalPrice').innerHTML='<font color="#ff0000">'+tprice+'</font> Ԫ';
	var obj=document.getElementById('paytype1');
	if(tprice<=<?=$money?>){
    obj.disabled=false;
	}else{
    obj.disabled=true;
    obj.checked=false;
	}
  return true;
}
function checkform(){
  if(!totalprice()){
    return false;
  }
  if(document.getElementById('paytype1').checked==false<?if($IsPay){?> && document.getElementById('paytype2').checked==false<?}?>){
    alert('��ѡ��֧����ʽ');
    return false;
  }
  return confirm('��ȷ��Ҫ������');
}
</script>
<?}?>
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="keyname" value="<?=$keyname?>">
</form>
<?include("footer.php");?>