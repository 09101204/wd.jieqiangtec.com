<?include_once 'check.php';
$id=Char_Cv('id','get');
$page=Char_Cv('page','get');
if($id && is_numeric($id)){
  $s=Char_Cv('s','get');
  if($s=='del'){
    $db->delete("order","companyid='$cid' and id=$id");
    ero($language['079'],"order.php");
  }
  $order=$db->record("order","clientid,title,buynum,realname,phone,email,im,co,addtime,addip","companyid='$cid' and id=$id",1);
  if(!$order)ero($language['080'],"order.php");
  $order=$order[0];
}else{
  unset($id);
}
?>
<html>
<title><?=$language['081']?></title>
<META http-equiv="Content-Type" content="text/html; charset=<?=$webcharset?>" />
<link rel="stylesheet" type="text/css" href="images/style.css">
<body>
<script type="text/javascript">
function delorder(id){
  if(confirm("<?=$language['082']?>")){
    location.href="?s=del&page=<?=$page?>&id="+id;
  }
}
</script>
<?if($id){?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr>
<td bgcolor="#f4f9ff" width="20%" height="20" align="right"><?=$language['083']?></td>
<td bgcolor="#ffffff" width="80%"><?=$order['title']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['084']?></td>
<td bgcolor="#ffffff"><?=$order['buynum']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['006']?></td>
<td bgcolor="#ffffff"><?=$order['clientid']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['007']?></td>
<td bgcolor="#ffffff"><?=$order['realname']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['008']?></td>
<td bgcolor="#ffffff"><?=$order['phone']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">QQ/MSN<?=$language['009']?></td>
<td bgcolor="#ffffff"><?=$order['im']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['085']?></td>
<td bgcolor="#ffffff"><?=$order['co']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['086']?></td>
<td bgcolor="#ffffff"><?=date('Y-m-d H:i:s',$order['addtime'])?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">IP<?=$language['012']?></td>
<td bgcolor="#ffffff"><?=$order['addip']?></td>
</tr>
</table>
<input type="button" value="<?=$language['087']?>" onclick="location.href='?page=<?=$page?>'">
<?}else{
$order=$db->page("order","id,title,buynum,realname,addtime","companyid='$cid' and workerid='$wid' order by id desc",15);
?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr bgcolor="#f4f9ff">
<th width="20%" height="20"><?=$language['088']?></th>
<th width="10%"><?=$language['089']?></th>
<th width="15%"><?=$language['015']?></th>
<th width="40%"><?=$language['090']?></th>
<th width="15%"><?=$language['017']?></th>
</tr>
<?foreach($order[0] as $rs){?>
<tr bgcolor="#ffffff">
<td><?=$rs['title']?></td>
<td><?=$rs['buynum']?></td>
<td><?=$rs['realname']?></td>
<td><?=date('Y-m-d H:i:s',$rs['addtime'])?></td>
<td>
  <a href="?id=<?=$rs['id']?>"><?=$language['018']?></a>
  <a href="#" onclick="delorder(<?=$rs['id']?>)"><?=$language['019']?></a>
</td>
</tr>
<?}?>
</table>
<?=$order[1]?>
<?}?>
</body>
</html>