<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");
if($action!=='gg_login' && $action!=='gg_edit'){
?>
<h4><a href="?action=gg_edit&ntype=<?=$ntype?>">添加<?=$title?></a></h4>
<form action="save.php?action=ggs&ntype=del&ac=<?=$ac?>" name="myform" method="post">
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="50">选中</th>
<th width="200">文本</th>
<th width="200">链接</th>
<th width="60">点击率</th>
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
<td><a href="?action=gg_edit&ntype=<?=$ntype2?>&id=<?=$id?>"><img src="../images/admincp/icon_edit.gif" border="0" alt="编辑"></a></td>
</tr>
<?}}?>
</table>
<table width='90%' height=2><tr ><td></td></tr></table>
<?=SetInput("checkbox","checkbox","checkbox","onclick=\"CheckAll(myform)\"")?>选中本页显示的所有
<?=SetInput("button","button"," 删除选中内容 ","onclick=\"if(confirm('您确定要删除所选中内容吗？')){myform.submit();}\"")?>
</form>
<!--页码开始-->
<?=$Ads[1]?>
<!--页码结束-->
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
<td width="30%" height="20" align="right">广告类型：</td>
<td width="70%"><font color="#ff0000"><?=$adtype?></font></td>
</tr>
<tr>
<td height="20" align="right"><?=$text?>：</td>
<td><?=setinput("text","thetext",$thetext,"",50,120)?>　</td>
</tr>
<tr>
<td height="20" align="right">链接：</td>
<td><?=setinput("text","theurl",$theurl,"",50,120)?>　</td>
</tr>
<tr>
<td colspan=2 height="30" align="center">
<?=setinput("hidden","id",$id)?> 
<?=setinput("submit","submit",$btnname)?> 
<?=setinput("button","button","返回上一页","onclick='history.go(-1)'")?>
</td>
</tr>
</table>
</form>
<?}
include("footer.php");?>