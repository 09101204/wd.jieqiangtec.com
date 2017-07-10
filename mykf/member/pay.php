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
<td width="20%" height="20" align="right">账户类型：</td>
<td width="80%"><?=$usertype?></td>
</tr>
<tr>
<td height="20" align="right"><?=$PriceOne[0]?>价格：</td>
<td><font color="#ff0000"><?=$price?></font> 元</td>
</tr>
<tr>
<td height="20" align="right">购买时间：</td>
<td><input type="text" name="days" value="<?=$days?>" onblur="totalprice()" size="5" maxlength="5"> <?=$PriceOne[0]?></td>
</tr>
<tr>
<td height="20" align="right">账户余额：</td>
<td><font color="#ff0000"><?=$money?></font> 元 <a href="?action=pay&type=pay" style="color:#0000ff">充值</a></td>
</tr>
<tr>
<td height="20" align="right">支付总额：</td>
<td id="TotalPrice"><font color="#ff0000"><?=$totalprice?></font> 元</td>
</tr>
<tr>
<td height="20" align="right">支付方式：</td>
<td><input type="radio" id="paytype1" name="paytype" value="0" <?=$money>=$totalprice ? 'checked' : 'disabled'?>>余额支付 
<?if($IsPay){?><input type="radio" id="paytype2" name="paytype" value="1" <?if($money<$totalprice)echo 'checked'?>>在线支付<?}?>
</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit"," 确定购买 ")?></td>
</tr>
</table>
<script type="text/javascript">
function totalprice(){
	if(myform.days.value.length<1){
    alert('请填写购买时间');
    myform.days.focus();
    return false;
	}
	if(isNaN(myform.days.value) || myform.days.value.indexOf('.')!=-1 || myform.days.value<=0){
    alert('购买时间必须为正整数');
    myform.days.focus();
    return false;
	}
	var tprice=myform.days.value*<?=$price?>;
	document.getElementById('TotalPrice').innerHTML='<font color="#ff0000">'+tprice+'</font> 元';
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
    alert('请选择支付方式');
    return false;
  }
  return confirm('您确定要执行该操作吗？');
}
</script>
<?}elseif($type=='pay'){?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td width="20%" height="20" align="right">充值金额：</td>
<td width="80%"><input type="text" name="pmoney" value="<?=$pmoney?>" onblur="checkmoney()" size="5" maxlength="5"> 元</td>
</tr>
<tr>
<td height="20" align="right">账户余额：</td>
<td><font color="#ff0000"><?=$money?></font> 元</td>
</tr>
<tr>
<td height="20" align="right">支付方式：</td>
<td><?if($IsPay){?><input type="radio" id="paytype2" name="paytype" value="1" checked>在线支付<?}else{?>系统已暂停在线支付功能，请与管理员联系<?}?>
</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit"," 确定充值 ")?></td>
</tr>
</table>
<script type="text/javascript">
function checkmoney(){
	if(myform.pmoney.value.length<1){
		alert('请填写充值金额');
		myform.pmoney.focus();
		return false;
	}
	if(isNaN(myform.pmoney.value) || myform.pmoney.value<=0){
		alert('充值金额必须为正数');
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
<td width="20%" height="20" align="right">功能名称：</td>
<td width="80%"><?=$ti?></td>
</tr>
<tr>
<td height="20" align="right">功能描述：</td>
<td><?=$content?></td>
</tr>
<?if($type=='add'){?>
<tr>
<td height="20" align="right">过期时间：</td>
<td><?=date('Y-m-d',$exptime)?> 
<?if($exptime<$time)echo('续费后的起始时间为'.date('Y-m-d',$time));?>
</td>
</tr>
<?}?>
<tr>
<td height="20" align="right">单价：</td>
<td><font color="#ff0000"><?=$price?></font> 元</td>
</tr>
<tr>
<td height="20" align="right">有效期：</td>
<td><font color="#ff0000"><?=$days?></font> <?=$PriceOne[0]?></td>
</tr>
<tr>
<td height="20" align="right">购买数量：</td>
<td><select name="num" onchange="totalprice()">
<?for($i=1;$i<=20;$i++){
print("<option value=\"$i\">$i</option>\n");
}?>
</select></td>
</tr>
<tr>
<td height="20" align="right">账户余额：</td>
<td><font color="#ff0000"><?=$money?></font> 元 <a href="?action=pay&type=pay" style="color:#0000ff">充值</a></td>
</tr>
<tr>
<td height="20" align="right">支付总额：</td>
<td id="TotalPrice"><font color="#ff0000"><?=$price?></font> 元</td>
</tr>
<tr>
<td height="20" align="right"><?=$type=='add' ? '有效期延长' : '时间'?>：</td>
<td id="TotalDays"><font color="#ff0000"><?=$days?></font> <?=$PriceOne[0]?></td>
</tr>
<tr>
<td height="20" align="right">支付方式：</td>
<td><input type="radio" id="paytype1" name="paytype" value="0" <?=$money>=$totalprice ? 'checked' : 'disabled'?>>余额支付 
<?if($IsPay){?><input type="radio" id="paytype2" name="paytype" value="1" <?if($money<$totalprice)echo 'checked'?>>在线支付<?}?>
</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit"," 确定购买 ")?></td>
</tr>
</table>
<script type="text/javascript">
function totalprice(){
  var num=myform.num.options[myform.num.selectedIndex].value;
	var tprice=num*<?=$price?>;
	var tdays=num*<?=$days?>;
	document.getElementById('TotalPrice').innerHTML='<font color="#ff0000">'+tprice+'</font> 元';
	document.getElementById('TotalDays').innerHTML='<font color="#ff0000">'+tdays+'</font> 天';
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
    alert('请选择支付方式');
    return false;
  }
  return confirm('您确定要购买吗？');
}
</script>
<?}elseif($type=='buyall'){?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td width="20%" height="20" align="right">所需费用：</td>
<td width="80%"><font color="#ff0000"><?=$price?></font> 元</td>
</tr>
<tr>
<td height="20" align="right">账户余额：</td>
<td><font color="#ff0000"><?=$money?></font> 元</td>
</tr>
<tr>
<td height="20" align="right">支付方式：</td>
<td><input type="radio" id="paytype1" name="paytype" value="0" <?=$money>=$price ? 'checked' : 'disabled'?>>余额支付
<?if($IsPay){?><input type="radio" id="paytype2" name="paytype" value="1">在线支付<?}else{?>系统已暂停在线支付功能，请与管理员联系<?}?>
</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit"," 确定升级 ")?></td>
</tr>
</table>
<script type="text/javascript">
function checkform(){
  if(document.getElementById('paytype1').checked==false<?if($IsPay){?> && document.getElementById('paytype2').checked==false<?}?>){
    alert('请选择支付方式');
    return false;
  }
  return confirm('您确定要升级吗？');
}
</script>
<?}elseif($type=='buypackage'){?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td width="20%" height="20" align="right">当前套餐名称：</td>
<td width="80%"><font color="#ff0000"><?=$MyPackage?></font></td>
</tr>
<tr>
<td height="20" align="right">新套餐名称：</td>
<td><font color="#ff0000"><?=$P['title']?></font></td>
</tr>
<tr>
<td height="20" align="right">包含功能：</td>
<td><?=$P['funcos']?></td>
</tr>
<tr>
<td height="20" align="right">单价：</td>
<td><font color="#ff0000"><?=$P['price']?></font> 元/<?=$P['dayti']?></td>
</tr>
<tr>
<td height="20" align="right">购买数量：</td>
<td><select name="buynum" onchange="totalprice(this.options[this.selectedIndex].value)">
<?for($i=1;$i<=10;$i++){
$s=$num==$i?'selected':''?>
<option value="<?=$i?>" <?=$s?>><?=$i?></option>
<?}?>
</select>
<?=$P['dayti']?></td>
</tr>
<tr>
<td height="20" align="right">支付总额：</td>
<td id="TotalPrice"><font color="#ff0000"><?=$totalprice?></font> 元</td>
</tr>
<tr>
<td height="20" align="right">账户余额：</td>
<td><font color="#ff0000"><?=$money?></font> 元</td>
</tr>
<tr>
<td height="20" align="right">支付方式：</td>
<td><input type="radio" id="paytype1" name="paytype" value="0" <?=$money>=$totalprice ? 'checked' : 'disabled'?>>余额支付 
<?if($IsPay){?><input type="radio" id="paytype2" name="paytype" value="1" <?if($money<$totalprice)echo 'checked'?>>在线支付<?}?>
</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit"," 确定开通 ")?></td>
</tr>
</table>
<script type="text/javascript">
function totalprice(num){
	var tprice=myform.buynum.value*<?=$price?>;
	document.getElementById('TotalPrice').innerHTML='<font color="#ff0000">'+tprice+'</font> 元';
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
    alert('请选择支付方式');
    return false;
  }
  return confirm('您确定要购买吗？');
}
</script>
<?}elseif($type=='paypackage'){?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td width="20%" height="20" align="right">当前套餐名称：</td>
<td width="80%"><font color="#ff0000"><?=$MyPackage?></font></td>
</tr>
<tr>
<td height="20" align="right">单价：</td>
<td><font color="#ff0000"><?=$P['price']?></font> 元/<?=$P['dayti']?></td>
</tr>
<tr>
<td height="20" align="right">购买数量：</td>
<td><select name="buynum" onchange="totalprice(this.options[this.selectedIndex].value)">
<?for($i=1;$i<=10;$i++){
$s=$num==$i?'selected':''?>
<option value="<?=$i?>" <?=$s?>><?=$i?></option>
<?}?>
</select>
<?=$P['dayti']?></td>
</tr>
<tr>
<td height="20" align="right">支付总额：</td>
<td id="TotalPrice"><font color="#ff0000"><?=$totalprice?></font> 元</td>
</tr>
<tr>
<td height="20" align="right">账户余额：</td>
<td><font color="#ff0000"><?=$money?></font> 元</td>
</tr>
<tr>
<td height="20" align="right">支付方式：</td>
<td><input type="radio" id="paytype1" name="paytype" value="0" <?=$money>=$totalprice ? 'checked' : 'disabled'?>>余额支付 
<?if($IsPay){?><input type="radio" id="paytype2" name="paytype" value="1" <?if($money<$totalprice)echo 'checked'?>>在线支付<?}?>
</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit"," 确定续费 ")?></td>
</tr>
</table>
<script type="text/javascript">
function totalprice(num){
	var tprice=myform.buynum.value*<?=$price?>;
	document.getElementById('TotalPrice').innerHTML='<font color="#ff0000">'+tprice+'</font> 元';
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
    alert('请选择支付方式');
    return false;
  }
  return confirm('您确定要续费吗？');
}
</script>
<?}elseif($type=='buysort' || $type=='buyworker'){?>
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td height="20" align="right"></td>
<td><a href="?action=pay&type=reg&keyname=allworker" style="color:blue">开通无限客服功能，座席不受限制，咨询量不受限制</a></td>
</tr>
<tr>
<td width="20%" height="20" align="right">最大<?=$ti?>数量：</td>
<td width="80%"><font color="#ff0000"><?=$curcount?></font> 个</td>
</tr>
<tr>
<td height="20" align="right">已用数量：</td>
<td><font color="#ff0000"><?=$usecount?></font> 个</td>
</tr>
<tr>
<td height="20" align="right">可用数量：</td>
<td><font color="#ff0000"><?=$curcount-$usecount?></font> 个</td>
</tr>
<tr>
<td height="20" align="right">预购买数量：</td>
<td><input type="text" name="buynum" value="<?=$buynum?>" onblur="totalprice()" size="5" maxlength="5"></td>
</tr>
<tr>
<td height="20" align="right">单价：</td>
<td><font color="#ff0000"><?=$price?></font> 元</td>
</tr>
<tr>
<td height="20" align="right">账户余额：</td>
<td><font color="#ff0000"><?=$money?></font> 元</td>
</tr>
<tr>
<td height="20" align="right">支付总额：</td>
<td id="TotalPrice"><font color="#ff0000"><?=$totalprice?></font> 元</td>
</tr>
<tr>
<td height="20" align="right">支付方式：</td>
<td><input type="radio" id="paytype1" name="paytype" value="0" <?=$money>=$totalprice ? 'checked' : 'disabled'?>>余额支付 
<?if($IsPay){?><input type="radio" id="paytype2" name="paytype" value="1" <?if($money<$totalprice)echo 'checked'?>>在线支付<?}?>
</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("submit","submit"," 确定升级 ")?></td>
</tr>
</table>
<script type="text/javascript">
function totalprice(){
	if(myform.buynum.value.length<1){
    alert('请填写购买数量');
    myform.buynum.focus();
    return false;
	}
	if(isNaN(myform.buynum.value) || myform.buynum.value.indexOf('.')!=-1 || myform.buynum.value<=0){
    alert('购买数量必须为正整数');
    myform.buynum.focus();
    return false;
	}
	var tprice=myform.buynum.value*<?=$price?>;
	document.getElementById('TotalPrice').innerHTML='<font color="#ff0000">'+tprice+'</font> 元';
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
    alert('请选择支付方式');
    return false;
  }
  return confirm('您确定要购买吗？');
}
</script>
<?}?>
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="keyname" value="<?=$keyname?>">
</form>
<?include("footer.php");?>