<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<table width='90%' height=5><tr ><td></td></tr></table>
<form action="save.php?action_=<?=$action?>&action=function" name="myform" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="80">功能名称</th>
<th width="60">有效<?=ToHelp('function2')?></th>
<th width="50">价格</th>
<?if($action=='funsuper'){?><th width="60">使用天数</th><?}?>
<th>描述</th>
<th width="50">操作</th>
</tr>
<?foreach($function as $rs){
$id=$rs['id'];?><tr align="center">
<td height="20"><a href="admin.php?action=editfunction&id=<?=$id?>"><?=$rs["title"]?></a></td>
<td><?=setinput('checkbox',"isused[$id]",'1',$rs['isused']==1?'checked':'')?></td>
<td><?=setinput('text',"price[$id]",$rs['price']?$rs['price']:'0','',5,5)?></td>
<?if($action=='funsuper'){?><td><?=setinput('text',"days[$id]",$rs['days']?$rs['days']:'0','',5,5)?></td><?}?>
<td align="left"><?=$rs['content']?></td>
<td><a href="admin.php?action=editfunction&id=<?=$id?>" style="color:blue">编辑</a></td>
</tr>
<?}?></table>
<br />
<?=setinput("submit","submit","保存修改")?>
<div style="text-align:left">
注:
<span style="color:red;line-height:20px">
<?if($action=='funsuper'){?>
  将价格设为0元则显示为基本功能
<?}else{?>
  将价格设为0元以上则显示为高级功能
<?}?>
</span>
</div>
</form>
<?include("footer.php");?>