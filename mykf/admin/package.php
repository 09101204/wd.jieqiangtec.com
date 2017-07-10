<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<style type="text/css">
.co{
  text-overflow:ellipsis;
}
</style>
<a href="admin.php?action=addpackage" style="color:red">添加新套餐</a>
<table width='90%' height=5><tr ><td></td></tr></table>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="120">套餐名称</th>
<th width="60">价格</th>
<th width="80">单位时间</th>
<th>包含功能</th>
<th width="50">操作</th>
</tr>
<?foreach($package[0] as $rs){
$id=$rs['id'];?><tr align="center">
<td height="20"><a href="admin.php?action=editpackage&id=<?=$id?>"><?=$rs["title"]?></a></td>
<td><?=$rs["price"]?></td>
<td><?=$rs["dayti"]?></td>
<td class="co" align="left"><?=$rs["funcos"]?></td>
<td>
  <a href="admin.php?action=editpackage&id=<?=$id?>" style="color:blue">编辑</a>
  <a href="javascript:del(<?=$id?>)" style="color:red">删除</a>
</td>
</tr>
<?}?></table>
<br />
<?=$package[1]?>
<script type="text/javascript">
function del(id){
  if(confirm('您确定要删除此套餐吗？')){
    location.href="save.php?action=delpackage&id="+id;
  }
}
</script>
<?include("footer.php");?>