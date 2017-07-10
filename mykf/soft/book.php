<?include_once 'check.php';
$id=Char_Cv('id','get');
$page=Char_Cv('page','get');
if($id && is_numeric($id)){
  $s=Char_Cv('s','get');
  if($s=='del'){
    $db->delete("book","companyid='$cid' and id=$id");
    ero("删除留言成功","book.php");
  }
  $book=$db->record("book","clientid,sort,realname,phone,email,im,co,addtime,addip","companyid='$cid' and id=$id",1);
  if(!$book)ero('留言不存在或已被删除',"book.php");
  $book=$book[0];
}else{
  unset($id);
}
?>
<html>
<title>在线订单管理</title>
<META http-equiv=Content-Type content=text/html; charset=gb2312>
<link rel="stylesheet" type="text/css" href="images/style.css">
<body LEFTMARGIN="0" TOPMARGIN="2" scroll="no" oncontextmenu=self.event.returnValue=false onselectstart="return false">
<script type="text/javascript">
function delbook(id){
  if(confirm("您确定要删除此条留言吗？")){
    location.href="?s=del&page=<?=$page?>&id="+id;
  }
}
</script>
<?if($id){?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr>
<td bgcolor="#f4f9ff" width="20%" height="20" align="right">业务类型：</td>
<td bgcolor="#ffffff" width="80%"><?=$book['sort']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">访客编号：</td>
<td bgcolor="#ffffff"><?=$book['clientid']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">联系人：</td>
<td bgcolor="#ffffff"><?=$book['realname']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">联系电话：</td>
<td bgcolor="#ffffff"><?=$book['phone']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">电子邮件：</td>
<td bgcolor="#ffffff"><?=$book['email']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">QQ/MSN：</td>
<td bgcolor="#ffffff"><?=$book['im']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">留言信息：</td>
<td bgcolor="#ffffff"><?=$book['co']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">留言时间：</td>
<td bgcolor="#ffffff"><?=date('Y-m-d H:i:s',$book['addtime'])?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">IP地址：</td>
<td bgcolor="#ffffff"><?=$book['addip']?></td>
</tr>
</table>
<input type="button" value="返回留言列表" onClick="location.href='?page=<?=$page?>'">
<?}else{
$book=$db->page("book","id,sort,realname,addtime","companyid='$cid' and workerid='$wid' order by id desc",15);?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr bgcolor="#f4f9ff">
<th width="20%" height="20">业务类型</th>
<th width="25%">真实姓名</th>
<th width="40%">留言时间</th>
<th width="15%">操作</th>
</tr>
<?foreach($book[0] as $rs){?>
<tr bgcolor="#ffffff">
<td><?=$rs['sort']?></td>
<td><?=$rs['realname']?></td>
<td><?=date('Y-m-d H:i:s',$rs['addtime'])?></td>
<td>
  <a href="?id=<?=$rs['id']?>">详情</a>
  <a href="#" onClick="delbook(<?=$rs['id']?>)">删除</a>
</td>
</tr>
<?}?>
</table>
<?=$book[1]?>
<?}?>
</body>
</html>