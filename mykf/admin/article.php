<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");
if($ntype=='index'){
  print('<a href="admin.php?action=page_index_add" style="color:red">�����ҳ���</a>');
}
?>
<form action="save.php?action=delarticle2&ntype=<?=$ntype?>" name="myform" method="post">
<table border="0" cellspacing="1" align="center" class="list">

<tr align="center">
<th width="50">ѡ��</th>
<th><?=$ti?>����</th>
<th width="60">�����</th>
<th width="120">����ʱ��</th>
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
<?=SetInput("checkbox","checkbox","checkbox","onclick=\"CheckAll(myform)\"")?>ѡ�б�ҳ��ʾ������
<?=SetInput("button","button"," ɾ��ѡ������ ","onclick=\"if(confirm('��ȷ��Ҫɾ����ѡ��������')){myform.submit();}\"")?>
</form>
<!--ҳ�뿪ʼ-->
<?=$Article[1]?>
<!--ҳ�����-->
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