<?include_once 'check.php';
$id=Char_Cv('id','get');
$page=Char_Cv('page','get');
if($id && is_numeric($id)){
  $s=Char_Cv('s','get');
  if($s=='del'){
    $db->delete("phone","companyid='$cid' and id=$id");
    ero($language['091'],"phone.php");
  }
  $phone=$db->record("phone","clientid,sort,realname,phone,co,addtime,addip","companyid='$cid' and id=$id",1);
  if(!$phone)ero($language['092'],"phone.php");
  $phone=$phone[0];
}else{
  unset($id);
}
?>
<html>
<title><?=$language['093']?></title>
<META http-equiv="Content-Type" content="text/html; charset=<?=$webcharset?>" />
<link rel="stylesheet" type="text/css" href="images/style.css">
<body>
<script type="text/javascript">
function delphone(id){
  if(confirm("<?=$language['094']?>")){
    location.href="?s=del&page=<?=$page?>&id="+id;
  }
}
</script>
<?if($id){?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr>
<td bgcolor="#f4f9ff" width="20%" height="20" align="right"><?=$language['005']?></td>
<td bgcolor="#ffffff" width="80%"><?=$phone['sort']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['006']?></td>
<td bgcolor="#ffffff"><?=$phone['clientid']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['007']?></td>
<td bgcolor="#ffffff"><?=$phone['realname']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['008']?></td>
<td bgcolor="#ffffff"><?=$phone['phone']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['095']?></td>
<td bgcolor="#ffffff"><?=$phone['co']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['096']?></td>
<td bgcolor="#ffffff"><?=date('Y-m-d H:i:s',$phone['addtime'])?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">IP<?=$language['012']?></td>
<td bgcolor="#ffffff"><?=$phone['addip']?></td>
</tr>
</table>
<input type="button" value="<?=$language['097']?>" onclick="location.href='?page=<?=$page?>'">
<?}else{
$phone=$db->page("phone","id,sort,realname,addtime","companyid='$cid' and workerid='$wid' order by id desc",15);?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr bgcolor="#f4f9ff">
<th width="20%" height="20"><?=$language['014']?></th>
<th width="25%"><?=$language['098']?></th>
<th width="40%"><?=$language['099']?></th>
<th width="15%"><?=$language['017']?></th>
</tr>
<?foreach($phone[0] as $rs){?>
<tr bgcolor="#ffffff">
<td><?=$rs['sort']?></td>
<td><?=$rs['realname']?></td>
<td><?=date('Y-m-d H:i:s',$rs['addtime'])?></td>
<td>
  <a href="?id=<?=$rs['id']?>"><?=$language['018']?></a>
  <a href="#" onclick="delphone(<?=$rs['id']?>)"><?=$language['019']?></a>
</td>
</tr>
<?}?>
</table>
<?=$phone[1]?>
<?}?>
</body>
</html>