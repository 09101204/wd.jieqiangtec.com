<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");
if($action!=='gg_login' && $action!=='gg_edit'){
?>
<h4><a href="?action=gg_edit&ntype=<?=$ntype?>">���<?=$title?></a></h4>
<form action="save.php?action=ggs&ntype=del&ac=<?=$ac?>" name="myform" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="50">ѡ��</th>
<th width="200">�ı�</th>
<th width="200">����</th>
<th width="60">�����</th>
<th width="50"></th>
</tr>
<?foreach($Ads[0] as $rs){
$id=$rs["id"];
$companyid=$rs["companyid"];
if($cid==$companyid){
?>
<tr>
<td height="20" align="center"><?=SetInput("checkbox","id[]",$id)?></td>
<td><a href="?action=gg_edit&ntype=<?=$ntype2?>&id=<?=$id?>"><?=$rs["thetext"]?></a></td>
<td><a href="<?=$rs["theurl"]?>" target="_blank"><?=$rs["theurl"]?></a></td>
<td align="center"><?=$rs["hits"]?></td>
<td><a href="?action=gg_edit&ntype=<?=$ntype2?>&id=<?=$id?>"><img src="../images/admincp/icon_edit.gif" border="0" alt="�༭"></a></td>
</tr>
<?}}?>
</table>
<table width='90%' height=2><tr ><td></td></tr></table>
<?=SetInput("checkbox","checkbox","checkbox","onclick=\"CheckAll(myform)\"")?>ѡ�б�ҳ��ʾ������
<?=SetInput("button","button"," ɾ��ѡ������ ","onclick=\"if(confirm('��ȷ��Ҫɾ����ѡ��������')){myform.submit();}\"")?>
</form>
<!--ҳ�뿪ʼ-->
<?=$Ads[1]?>
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
<?}else{?>
<form name="myform" action="save.php?action=ggs&ntype=<?=$ntype?>&ac=<?=$ac?>" onsubmit="return checkform()" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;<?=$title?></th>
</tr>
<tr>
<td width="30%" height="20" align="right">������ͣ�</td>
<td width="70%"><font color="#ff0000"><?=$adtype?></font></td>
</tr>
<tr>
<td height="20" align="right"><?=$text?>��</td>
<td><?=setinput("text","thetext",$thetext,"",50,120)?>��</td>
</tr>
<tr>
<td height="20" align="right">���ӣ�</td>
<td><?=setinput("text","theurl",$theurl,"",50,120)?>��</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("hidden","id",$id)?> 
<?=setinput("submit","submit",$btnname)?> 
<?=setinput("button","button","������һҳ","onclick='history.go(-1)'")?>
</td>
</tr>
</table>
</form>
<?}
include("footer.php");?>