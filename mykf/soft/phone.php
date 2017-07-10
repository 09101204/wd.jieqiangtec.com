<?include_once 'check.php';
$id=Char_Cv('id','get');
$page=Char_Cv('page','get');
if($id && is_numeric($id)){
  $s=Char_Cv('s','get');
  if($s=='del'){
    $db->delete("phone","companyid='$cid' and id=$id");
    ero("删除回拨信息成功","phone.php");
  }
  $phone=$db->record("phone","clientid,sort,realname,phone,co,addtime,addip","companyid='$cid' and id=$id",1);
  if(!$phone)ero('回拨信息不存在或已被删除',"phone.php");
  $phone=$phone[0];
}else{
  unset($id);
}
?>
<html>
<title>电话回拨记录</title>
<META http-equiv=Content-Type content=text/html; charset=gb2312>
<link rel="stylesheet" type="text/css" href="images/style.css">
<body LEFTMARGIN="0" TOPMARGIN="2" scroll="no" oncontextmenu=self.event.returnValue=false onselectstart="return false">
<script type="text/javascript">
function delphone(id){
  if(confirm("您确定要删除此条信息吗？")){
    location.href="?s=del&page=<?=$page?>&id="+id;
  }
}
</script>
<?if($id){?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr>
<td bgcolor="#f4f9ff" width="20%" height="20" align="right">业务类型：</td>
<td bgcolor="#ffffff" width="80%"><?=$phone['sort']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">访客编号：</td>
<td bgcolor="#ffffff"><?=$phone['clientid']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">联系人：</td>
<td bgcolor="#ffffff"><?=$phone['realname']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">联系电话：</td>
<td bgcolor="#ffffff"><?=$phone['phone']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">联系事宜：</td>
<td bgcolor="#ffffff"><?=$phone['co']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">提交时间：</td>
<td bgcolor="#ffffff"><?=date('Y-m-d H:i:s',$phone['addtime'])?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">IP地址：</td>
<td bgcolor="#ffffff"><?=$phone['addip']?></td>
</tr>
</table>
<input type="button" value="返回列表" onclick="location.href='?page=<?=$page?>'">
<?}else{
$phone=$db->page("phone","id,sort,realname,addtime","companyid='$cid' and workerid='$wid' order by id desc",15);?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr bgcolor="#f4f9ff">
<th width="20%" height="20">业务类型</th>
<th width="25%">联系人</th>
<th width="40%">提交时间</th>
<th width="15%">操作</th>
</tr>
<?foreach($phone[0] as $rs){?>
<tr bgcolor="#ffffff">
<td><?=$rs['sort']?></td>
<td><?=$rs['realname']?></td>
<td><?=date('Y-m-d H:i:s',$rs['addtime'])?></td>
<td>
  <a href="?id=<?=$rs['id']?>">详情</a>
  <a href="#" onclick="delphone(<?=$rs['id']?>)">删除</a>
</td>
</tr>
<?}?>
</table>
<?=$phone[1]?>
<?}?>
</body>
</html>