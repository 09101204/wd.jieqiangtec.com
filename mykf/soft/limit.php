<?include_once 'check.php';
if($action=Char_Cv('action','get')){
  $id=Char_Cv('id','get');
  if($id && is_numeric($id)){
    $db->update("client","status","0","companyid='$cid' and id=$id");
  }
}
?>
<html>
<title>访客屏蔽列表</title>
<META http-equiv=Content-Type content=text/html; charset=gb2312>
<link rel="stylesheet" type="text/css" href="images/style.css">
<body LEFTMARGIN="0" TOPMARGIN="2" scroll="no" oncontextmenu=self.event.returnValue=false onselectstart="return false">
<?
$client=$db->record("client","id,ip,address,lasttime","companyid='$cid' and status=-1");
?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr bgcolor="#f4f9ff">
<th width="20%">访客编号</th>
<th width="25%">IP地址</th>
<th width="40%">地理位置</th>
<th width="15%">操作</th>
</tr>
<?foreach($client as $rs){?>
<tr bgcolor="#ffffff">
<td><?=GetId($rs['id'],7)?></td>
<td><?=$rs['ip']?></td>
<td><?=$rs['address']?></td>
<td><a href="?action=del&id=<?=$rs['id']?>">解除</a></td>
</tr>
<?}?>
</table>
</body>
</html>