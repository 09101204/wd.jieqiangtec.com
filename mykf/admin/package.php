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
<a href="admin.php?action=addpackage" style="color:red">������ײ�</a>
<table width='90%' height=5><tr ><td></td></tr></table>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="120">�ײ�����</th>
<th width="60">�۸�</th>
<th width="80">��λʱ��</th>
<th>��������</th>
<th width="50">����</th>
</tr>
<?foreach($package[0] as $rs){
$id=$rs['id'];?><tr align="center">
<td height="20"><a href="admin.php?action=editpackage&id=<?=$id?>"><?=$rs["title"]?></a></td>
<td><?=$rs["price"]?></td>
<td><?=$rs["dayti"]?></td>
<td class="co" align="left"><?=$rs["funcos"]?></td>
<td>
  <a href="admin.php?action=editpackage&id=<?=$id?>" style="color:blue">�༭</a>
  <a href="javascript:del(<?=$id?>)" style="color:red">ɾ��</a>
</td>
</tr>
<?}?></table>
<br />
<?=$package[1]?>
<script type="text/javascript">
function del(id){
  if(confirm('��ȷ��Ҫɾ�����ײ���')){
    location.href="save.php?action=delpackage&id="+id;
  }
}
</script>
<?include("footer.php");?>