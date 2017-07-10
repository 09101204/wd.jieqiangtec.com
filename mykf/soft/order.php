<?include_once 'check.php';
$id=Char_Cv('id','get');
$page=Char_Cv('page','get');
if($id && is_numeric($id)){
  $s=Char_Cv('s','get');
  if($s=='del'){
    $db->delete("order","companyid='$cid' and id=$id");
    ero("删除订单成功","order.php");
  }
  $order=$db->record("order","clientid,title,buynum,realname,phone,email,im,co,addtime,addip","companyid='$cid' and id=$id",1);
  if(!$order)ero('订单不存在或已被删除',"order.php");
  $order=$order[0];
}else{
  unset($id);
}
?>
<html>
<title>在线订单列表</title>
<META http-equiv=Content-Type content=text/html; charset=gb2312>
<link rel="stylesheet" type="text/css" href="images/style.css">
<body LEFTMARGIN="0" TOPMARGIN="2" scroll="no" oncontextmenu=self.event.returnValue=false onselectstart="return false">
<script type="text/javascript">
function delorder(id){
  if(confirm("您确定要删除此条订单吗？")){
    location.href="?s=del&page=<?=$page?>&id="+id;
  }
}
</script>
<?if($id){?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr>
<td bgcolor="#f4f9ff" width="20%" height="20" align="right">购买内容：</td>
<td bgcolor="#ffffff" width="80%"><?=$order['title']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">购买数量：</td>
<td bgcolor="#ffffff"><?=$order['buynum']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">访客编号：</td>
<td bgcolor="#ffffff"><?=$order['clientid']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">联系人：</td>
<td bgcolor="#ffffff"><?=$order['realname']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">联系电话：</td>
<td bgcolor="#ffffff"><?=$order['phone']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">QQ/MSN：</td>
<td bgcolor="#ffffff"><?=$order['im']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">订单详情：</td>
<td bgcolor="#ffffff"><?=$order['co']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">订单时间：</td>
<td bgcolor="#ffffff"><?=date('Y-m-d H:i:s',$order['addtime'])?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">IP地址：</td>
<td bgcolor="#ffffff"><?=$order['addip']?></td>
</tr>
</table>
<input type="button" value="返回订单列表" onclick="location.href='?page=<?=$page?>'">
<?}else{
$order=$db->page("order","id,title,buynum,realname,addtime","companyid='$cid' and workerid='$wid' order by id desc",15);
?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr bgcolor="#f4f9ff">
<th width="20%" height="20">购买内容</th>
<th width="10%">数量</th>
<th width="15%">真实姓名</th>
<th width="40%">订单时间</th>
<th width="15%">操作</th>
</tr>
<?foreach($order[0] as $rs){?>
<tr bgcolor="#ffffff">
<td><?=$rs['title']?></td>
<td><?=$rs['buynum']?></td>
<td><?=$rs['realname']?></td>
<td><?=date('Y-m-d H:i:s',$rs['addtime'])?></td>
<td>
  <a href="?id=<?=$rs['id']?>">详情</a>
  <a href="#" onclick="delorder(<?=$rs['id']?>)">删除</a>
</td>
</tr>
<?}?>
</table>
<?=$order[1]?>
<?}?>
</body>
</html>