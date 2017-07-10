<?include_once 'check.php';
$id=Char_Cv('id','get');
$page=Char_Cv('page','get');
if($id && is_numeric($id)){
  $s=Char_Cv('s','get');
  if($s=='del'){
    $db->delete("book","companyid='$cid' and id=$id");
    ero($language['001'],"book.php");
  }
  $book=$db->record("book","clientid,sort,realname,phone,email,im,co,addtime,addip","companyid='$cid' and id=$id",1);
  if(!$book)ero($language['002'],"book.php");
  $book=$book[0];
}else{
  unset($id);
}
?>
<html>
<title><?=$language['003']?></title>
<META http-equiv="Content-Type" content="text/html; charset=<?=$webcharset?>">
<link rel="stylesheet" type="text/css" href="images/style.css">
<body>
<script type="text/javascript">
function delbook(id){
  if(confirm("<?=$language['004']?>")){
    location.href="?s=del&page=<?=$page?>&id="+id;
  }
}
</script>
<?if($id){?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr>
<td bgcolor="#f4f9ff" width="20%" height="20" align="right"><?=$language['005']?></td>
<td bgcolor="#ffffff" width="80%"><?=$book['sort']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['006']?></td>
<td bgcolor="#ffffff"><?=$book['clientid']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['007']?></td>
<td bgcolor="#ffffff"><?=$book['realname']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['008']?></td>
<td bgcolor="#ffffff"><?=$book['phone']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">QQ/MSN<?=$language['009']?></td>
<td bgcolor="#ffffff"><?=$book['im']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['010']?></td>
<td bgcolor="#ffffff"><?=$book['co']?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right"><?=$language['011']?></td>
<td bgcolor="#ffffff"><?=date('Y-m-d H:i:s',$book['addtime'])?></td>
</tr>
<tr>
<td bgcolor="#f4f9ff" height="20" align="right">IP<?=$language['012']?></td>
<td bgcolor="#ffffff"><?=$book['addip']?></td>
</tr>
</table>
<input type="button" value="<?=$language['013']?>" onclick="location.href='?page=<?=$page?>'">
<?}else{
$book=$db->page("book","id,sort,realname,addtime","companyid='$cid' and workerid='$wid' order by id desc",15);?>
<table border="0" cellspacing="1" align="center" width="99%" bgcolor="#cedbeb">
<tr bgcolor="#f4f9ff">
<th width="20%" height="20"><?=$language['014']?></th>
<th width="25%"><?=$language['015']?></th>
<th width="40%"><?=$language['016']?></th>
<th width="15%"><?=$language['017']?></th>
</tr>
<?foreach($book[0] as $rs){?>
<tr bgcolor="#ffffff">
<td><?=$rs['sort']?></td>
<td><?=$rs['realname']?></td>
<td><?=date('Y-m-d H:i:s',$rs['addtime'])?></td>
<td>
  <a href="?id=<?=$rs['id']?>"><?=$language['018']?></a>
  <a href="#" onclick="delbook(<?=$rs['id']?>)"><?=$language['019']?></a>
</td>
</tr>
<?}?>
</table>
<?=$book[1]?>
<?}?>
</body>
</html>