<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<table width='100%' height=5><tr ><td>
<b>套餐功能</b>:客服增值套餐功能(<font color="red">注：如果更换套餐，原有套餐将会被替换，系统不会退还购买原有套餐所支付的金额</font>)
</td></tr></table>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="150">套餐名称</th>
<th width="80">价格</th>
<th>包含功能</th>
<th width="80">操作</th>
</tr>
<?foreach($PackAge as $rs){?>
<tr align="center">
<td height="20"<?=$package==$rs['id']?'style="color:green;font-weight:bold"':''?>><?=$rs['title']?></td>
<td><font color="red"><?=$rs['price']?></font>元/<?=$rs['dayti']?></td>
<td align="left"><?=$rs['funcos']?></td>
<td>
<?if($package!=$rs['id'] && MyGrade('buy')){?><a href="?action=pay&type=buypackage&id=<?=$rs['id']?>" style="color:#0000ff">开通</a><?}?>
<?if($package==$rs['id'] && MyGrade('pay')){?><a href="?action=pay&type=paypackage&id=<?=$rs['id']?>" style="color:#0000ff">续费</a><?}?>
</td>
</tr>
<?}?>
</table>
<table width='100%' height=5><tr ><td>
<b>单个功能</b>:所有客服功能列表
</td></tr></table>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="150">功能名称</th>
<th width="80">价格</th>
<th width="100">开通时间</th>
<th width="100">过期时间</th>
<th>备注</th>
<th width="80">操作</th>
</tr>
<?foreach($F as $rs){?><tr align="center">
<td height="20" title="<?=$rs[2]?>"><?=$rs[1]?></td>
<td><?=$rs[3]?></td>
<td><?=$rs[5]?></td>
<td><?=$rs[6]?></td>
<td><?=$rs[4]?></td>
<td>
<?if($rs[5]=='---' && MyGrade('buy')){?><a href="?action=pay&type=reg&keyname=<?=$rs[0]?>" style="color:#0000ff">开通</a><?}?>
<?if($rs[5]!='---' && MyGrade('add')){?>
<?if($rs[7]!=0){?>
<a href="?action=pay&type=paypackage&id=<?=$rs[7]?>" style="color:#0000ff">续费</a>
<?}else{?>
<a href="?action=pay&type=add&keyname=<?=$rs[0]?>" style="color:#0000ff">续费</a>
<?}}?>
</td>
</tr>
<?}?>
</table>
</form>
<?include("footer.php");?>