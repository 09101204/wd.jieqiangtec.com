<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");
getdir("管理自动应答,?action=faq|添加自动应答,?action=faqadd");
?>
<form action="save.php?action=delfaq2" name="myform" method="post">
<table border="0" cellspacing="1" align="center" class="list">

<tr align="center">
<th width="10%">选中</th>
<th width="30%">标题</th>
<th width="10%">查询次数</th>
<th>内容</th>
</tr>
<?foreach($faq[0] as $rs){
$id=$rs["id"];
$hits=$rs["hits"];
$content=strlen($rs["content"])>20 ? substr($rs["content"],0,20)."..." :$rs["content"];
?><tr>
<td height="20" align="center"><?=SetInput("checkbox","id[]",$id)?></td>
<td><a href="member.php?action=faqedit&id=<?=$id?>"><?=$rs["title"]?></a></td>
<td align="center"><?=$hits?></td>
<td><?=$content?></td>
</tr>
<?}?></table>
<table width='90%' height=2><tr ><td></td></tr></table>
<?=SetInput("checkbox","checkbox","checkbox","onclick=\"CheckAll(myform)\"")?> 全选<?=SetInput("button","button","删除","onclick=\"if(confirm('您确定要删除所选记录吗？')){myform.submit();}\"")?></form>
<?=$faq[1]?><script language=javascript>
function CheckAll(form){
  for (var i=0;i<form.elements.length;i++){
    var e = form.elements[i];
    if (e.name != 'checkbox')
    e.checked = form.checkbox.checked;
  }
}
</script>
<?include("footer.php");?>