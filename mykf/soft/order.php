<?include_once 'check.php';
$id=Char_Cv('id','get');
$page=Char_Cv('page','get');
if($id && is_numeric($id)){
  $s=Char_Cv('s','get');
  if($s=='del'){
    $db->delete("order","companyid='$cid' and id=$id");
    ero("ɾ�������ɹ�","order.php");
  }
  $order=$db->record("order","clientid,title,buynum,realname,phone,email,im,co,addtime,addip","companyid='$cid' and id=$id",1);
  if(!$order)ero('���������ڻ��ѱ�ɾ��',"order.php");
  $order=$order[0];
}else{
  unset($id);
}
?>
<html>
<title>���߶����б�</title>
<META http-equiv=Content-Type content=text/html; charset=gb2312>
<link rel="stylesheet" type="text/css" href="images/style.css">
<body LEFTMARGIN="0" TOPMARGIN="2" scroll="no" oncontextmenu=self.event.returnValue=false onselectstart="return false">
<script type="text/javascript">
function delorder(id){
  if(confirm("��ȷ��Ҫɾ������������")){
    location.href="?s=del&page=<?=$page?>&id="+id;
  }
}
</script>
<?if($id){?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr>
<td bgcolor="#f4f9ff" width="20%" height="20" align="right">�������ݣ�</td>
<td bgcolor="#ffffff" width="80%"><?=$order['title']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">����������</td>
<td bgcolor="#ffffff"><?=$order['buynum']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">�ÿͱ�ţ�</td>
<td bgcolor="#ffffff"><?=$order['clientid']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">��ϵ�ˣ�</td>
<td bgcolor="#ffffff"><?=$order['realname']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">��ϵ�绰��</td>
<td bgcolor="#ffffff"><?=$order['phone']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">QQ/MSN��</td>
<td bgcolor="#ffffff"><?=$order['im']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">�������飺</td>
<td bgcolor="#ffffff"><?=$order['co']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">����ʱ�䣺</td>
<td bgcolor="#ffffff"><?=date('Y-m-d H:i:s',$order['addtime'])?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">IP��ַ��</td>
<td bgcolor="#ffffff"><?=$order['addip']?></td>
</tr>
</table>
<input type="button" value="���ض����б�" onclick="location.href='?page=<?=$page?>'">
<?}else{
$order=$db->page("order","id,title,buynum,realname,addtime","companyid='$cid' and workerid='$wid' order by id desc",15);
?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr bgcolor="#f4f9ff">
<th width="20%" height="20">��������</th>
<th width="10%">����</th>
<th width="15%">��ʵ����</th>
<th width="40%">����ʱ��</th>
<th width="15%">����</th>
</tr>
<?foreach($order[0] as $rs){?>
<tr bgcolor="#ffffff">
<td><?=$rs['title']?></td>
<td><?=$rs['buynum']?></td>
<td><?=$rs['realname']?></td>
<td><?=date('Y-m-d H:i:s',$rs['addtime'])?></td>
<td>
  <a href="?id=<?=$rs['id']?>">����</a>
  <a href="#" onclick="delorder(<?=$rs['id']?>)">ɾ��</a>
</td>
</tr>
<?}?>
</table>
<?=$order[1]?>
<?}?>
</body>
</html>