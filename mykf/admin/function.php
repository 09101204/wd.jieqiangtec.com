<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<table width='90%' height=5><tr ><td></td></tr></table>
<form action="save.php?action_=<?=$action?>&action=function" name="myform" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="80">��������</th>
<th width="60">��Ч<?=ToHelp('function2')?></th>
<th width="50">�۸�</th>
<?if($action=='funsuper'){?><th width="60">ʹ������</th><?}?>
<th>����</th>
<th width="50">����</th>
</tr>
<?foreach($function as $rs){
$id=$rs['id'];?><tr align="center">
<td height="20"><a href="admin.php?action=editfunction&id=<?=$id?>"><?=$rs["title"]?></a></td>
<td><?=setinput('checkbox',"isused[$id]",'1',$rs['isused']==1?'checked':'')?></td>
<td><?=setinput('text',"price[$id]",$rs['price']?$rs['price']:'0','',5,5)?></td>
<?if($action=='funsuper'){?><td><?=setinput('text',"days[$id]",$rs['days']?$rs['days']:'0','',5,5)?></td><?}?>
<td align="left"><?=$rs['content']?></td>
<td><a href="admin.php?action=editfunction&id=<?=$id?>" style="color:blue">�༭</a></td>
</tr>
<?}?></table>
<br />
<?=setinput("submit","submit","�����޸�")?>
<div style="text-align:left">
ע:
<span style="color:red;line-height:20px">
<?if($action=='funsuper'){?>
  ���۸���Ϊ0Ԫ����ʾΪ��������
<?}else{?>
  ���۸���Ϊ0Ԫ��������ʾΪ�߼�����
<?}?>
</span>
</div>
</form>
<?include("footer.php");?>