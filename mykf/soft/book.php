<?include_once 'check.php';
$id=Char_Cv('id','get');
$page=Char_Cv('page','get');
if($id && is_numeric($id)){
  $s=Char_Cv('s','get');
  if($s=='del'){
    $db->delete("book","companyid='$cid' and id=$id");
    ero("ɾ�����Գɹ�","book.php");
  }
  $book=$db->record("book","clientid,sort,realname,phone,email,im,co,addtime,addip","companyid='$cid' and id=$id",1);
  if(!$book)ero('���Բ����ڻ��ѱ�ɾ��',"book.php");
  $book=$book[0];
}else{
  unset($id);
}
?>
<html>
<title>���߶�������</title>
<META http-equiv=Content-Type content=text/html; charset=gb2312>
<link rel="stylesheet" type="text/css" href="images/style.css">
<body LEFTMARGIN="0" TOPMARGIN="2" scroll="no" oncontextmenu=self.event.returnValue=false onselectstart="return false">
<script type="text/javascript">
function delbook(id){
  if(confirm("��ȷ��Ҫɾ������������")){
    location.href="?s=del&page=<?=$page?>&id="+id;
  }
}
</script>
<?if($id){?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr>
<td bgcolor="#f4f9ff" width="20%" height="20" align="right">ҵ�����ͣ�</td>
<td bgcolor="#ffffff" width="80%"><?=$book['sort']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">�ÿͱ�ţ�</td>
<td bgcolor="#ffffff"><?=$book['clientid']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">��ϵ�ˣ�</td>
<td bgcolor="#ffffff"><?=$book['realname']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">��ϵ�绰��</td>
<td bgcolor="#ffffff"><?=$book['phone']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">�����ʼ���</td>
<td bgcolor="#ffffff"><?=$book['email']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">QQ/MSN��</td>
<td bgcolor="#ffffff"><?=$book['im']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">������Ϣ��</td>
<td bgcolor="#ffffff"><?=$book['co']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">����ʱ�䣺</td>
<td bgcolor="#ffffff"><?=date('Y-m-d H:i:s',$book['addtime'])?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">IP��ַ��</td>
<td bgcolor="#ffffff"><?=$book['addip']?></td>
</tr>
</table>
<input type="button" value="���������б�" onClick="location.href='?page=<?=$page?>'">
<?}else{
$book=$db->page("book","id,sort,realname,addtime","companyid='$cid' and workerid='$wid' order by id desc",15);?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr bgcolor="#f4f9ff">
<th width="20%" height="20">ҵ������</th>
<th width="25%">��ʵ����</th>
<th width="40%">����ʱ��</th>
<th width="15%">����</th>
</tr>
<?foreach($book[0] as $rs){?>
<tr bgcolor="#ffffff">
<td><?=$rs['sort']?></td>
<td><?=$rs['realname']?></td>
<td><?=date('Y-m-d H:i:s',$rs['addtime'])?></td>
<td>
  <a href="?id=<?=$rs['id']?>">����</a>
  <a href="#" onClick="delbook(<?=$rs['id']?>)">ɾ��</a>
</td>
</tr>
<?}?>
</table>
<?=$book[1]?>
<?}?>
</body>
</html>