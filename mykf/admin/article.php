<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");
if($ntype=='index'){
  print('<a href="admin.php?action=page_index_add" style="color:red">添加首页版块</a>');
}
?>
<form action="save.php?action=delarticle2&ntype=<?=$ntype?>" name="myform" method="post">
<table border="0" cellspacing="1" align="center" class="list">

<tr align="center">
<th width="50">选中</th>
<th><?=$ti?>标题</th>
<th width="60">点击率</th>
<th width="120">更新时间</th>
</tr>
<?foreach($Article[0] as $rs){
$id=$rs["id"];
?>
<tr>
<td height="20" align="center"><?=SetInput("checkbox","id[]",$id)?></td>
<td><a href="admin.php?action=edit<?=$ntype?>&id=<?=$id?>"><?=$rs["title"]?></a></td>
<td align="center"><?=$rs["hits"]?></td>
<td align="center"><?=date('Y-m-d H:i:s',$rs["updatetime"])?></td>
</tr>
<?}?>
</table>
<table width='90%' height=2><tr ><td></td></tr></table>
<?=SetInput("checkbox","checkbox","checkbox","onclick=\"CheckAll(myform)\"")?>选中本页显示的所有
<?=SetInput("button","button"," 删除选中内容 ","onclick=\"if(confirm('您确定要删除所选中内容吗？')){myform.submit();}\"")?>
</form>
<!--页码开始-->
<?=$Article[1]?>
<!--页码结束-->
<script language=javascript>
function CheckAll(form){
  for (var i=0;i<form.elements.length;i++){
    var e = form.elements[i];
    if (e.name != 'checkbox')
    e.checked = form.checkbox.checked;
  }
}
</script>
<?include("footer.php");?>