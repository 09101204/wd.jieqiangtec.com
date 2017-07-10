<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<style type="text/css">
input.a{border:1px solid #319ace;background:#f7fbff;height:17px;color:#31659c}
</style>
<form action="admin.php" method="get" name="myform">
<table border="0" cellspacing="0" cellpadding="0">
<tr>
  <td width="200" height="20" align="right"> 企业名称：</td>
  <td width="400"><input type="text" class="a" size="22" name="mycompany" maxlength="20" value="<?=$mycompany?>"></td>
</tr>
<tr>
  <td height="20" align="right"> 企业编号：</td>
  <td><input type="text" class="a" size="22" name="loginname" maxlength="20" value="<?=$loginname?>"></td>
</tr>
<tr>
  <td height="20" align="right"> 代理商：</td>
  <td><input type="text" class="a" size="22" name="agent" maxlength="20" value="<?=$agent?>"></td>
</tr>
<tr>
  <td height="20" align="right"> 所在省市：</td>
  <td><select name="prov" onchange="eqmk_sel(this.options.value)"></select>
	  <select name="city"></select></td>
</tr>
<tr>
  <td height="20" align="right"> 套餐：</td>
  <td>
    <select name="package">
    <option value="-1"<?if($package==-1)echo' selected'?>>- 不限 -</option>
    <option value="0"<?if($package==0)echo' selected'?>>普通用户</option>
    <?$ThePackage=array();
    foreach($Package as $rs){
    $ThePackage[$rs['id']]=$rs['title'];
    $s=$rs['id']==$package?' selected':'';?>
    <option value="<?=$rs['id']?>"<?=$s?>><?=$rs['title']?></option>
    <?}?></select>
  </td>
</tr>
<tr>
  <td height="20" align="right"> 余额：</td>
  <td>
    <input type="text" class="a" size="8" name="moneya" maxlength="20" value="<?=$moneya?>">
    ～
    <input type="text" class="a" size="8" name="moneyb" maxlength="20" value="<?=$moneyb?>"> 元
  </td>
</tr>
<tr>
  <td height="20" align="right"> 消费额：</td>
  <td>
    <input type="text" class="a" size="8" name="paymoneya" maxlength="20" value="<?=$paymoneya?>">
    ～
    <input type="text" class="a" size="8" name="paymoneyb" maxlength="20" value="<?=$paymoneyb?>"> 元
  </td>
</tr>
<tr>
  <td height="32" align="right"></td>
  <td align="left">
    <input type="hidden" name="action" value="company">
    <input type="submit" name="submit" value=" 查找 " class="button">&nbsp;&nbsp;
    <input type="reset" name="submit" value=" 重置 " class="button">
  </td>
</tr>
</table>
</form>
<br />
<br />
<?if($_GET['submit']){
if($company[2]==0)print('<h1>很抱歉，没有找到任何符合当前搜索条件的客户</h1>');
if($MyTitle)echo'<h3>'.$MyTitle.'</h3>';?>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="20%">企业名称/编号</th>
<th width="20%">代理商</th>
<th width="8%">套餐</th>
<th width="8%">余额</th>
<th width="8%">消费额</th>
<th width="8%">热度</th>
<th width="8%">咨询</th>
<th width="8%">点评</th>
<th width="20%">操作</th>
</tr>
<?foreach($company[0] as $rs){
$id=$rs["id"];
if($rs['agent']){
  if($agent=$db->record("agent","prov,city,ntype,company","username='".$rs['agent']."'",1)){
    $ag='<a href="'.($agent[0]['ntype']=='prov' ? '?action=agent_set&type=prov&prov='.$agent[0]['prov'] : '?action=agent_set&type=city&prov='.$agent[0]['prov'].'&city='.$agent[0]['city']).'" title="'.($agent[0]['ntype']=='prov' ? $agent[0]['prov'].'总代理' : $agent[0]['prov'].$agent[0]['city'].'总代理').'">'.$agent[0]['company'].'</a>';
  }else{
    $ag='无';
  }
}else{
  $ag='无';
}
?>
<tr>
<td height="20"><a href="admin.php?action=companyedit&id=<?=$id?>"><?=$rs["company"]?></a>(<?=$rs["companyid"]?>)</td>
<td><?=$ag?></td>
<td align="center"><?=$ThePackage[$rs["package"]]?></td>
<td align="center"><?=$rs["money"]?></td>
<td align="center"><?=$rs["paymoney"]?></td>
<td align="center"><?=$rs["hot"]?></td>
<td align="center"><?=$rs["talk"]?></td>
<td align="center"><?=$rs["comment"]?></td>
<td align="center">
  <a href="admin.php?action=companyedit&id=<?=$id?>"><img src="../images/admincp/icon_edit.gif" border="0" alt="编辑客户"></a>
  <a href="save.php?action=delcompany&id=<?=$id?>" onClick="return confirm('您确定要删除该企业吗？\n\n该操作不可恢复，请慎重进行！')"><img src="../images/admincp/icon_delete.gif" border="0" alt="删除客户"></a>
  <a href="admin.php?action=company_money&cid=<?=$rs["companyid"]?>"><img src="../images/admincp/icon_money.gif" border="0" alt="消费明细"></a>
  <a href="admin.php?action=company_log&cid=<?=$rs["companyid"]?>"><img src="../images/admincp/icon_log.gif" border="0" alt="操作日志"></a>
</td>
</tr>
<?}?>
</table>
<table width='90%' height=2><tr ><td></td></tr></table>
<!--页码开始-->
<?=$company[1]?>
<?}?>
<!--页码结束-->
<script language=javascript>
var prov=new Array();
var city=new Array();
<?foreach($province as $p){?>
prov[prov.length]="<?=$p?>";
<?}
foreach($city as $c){?>
city[city.length]=new Array("<?=$c[0]?>","<?=$c[1]?>");
<?}?>
myform.prov.length=0;
myform.prov[0]=new Option("不限","");
myform.city[0]=new Option("不限","");
for(i=0;i<prov.length;i++){
  myform.prov[myform.prov.length]=new Option(prov[i],prov[i]);
  if(prov[i]=="<?=$prov_?>"){
    myform.prov[myform.prov.length-1].selected=true;
    eqmk_sel(prov[i]);
  }
}
function eqmk_sel(pid){
  if(pid=="")return;
  myform.city.length=0;
  myform.city[myform.city.length]=new Option("不限","");
  for(j=1;j<city.length;j++){
    if(pid==city[j][0]){
      myform.city[myform.city.length]=new Option(city[j][1],city[j][1]);
      if(city[j][1]=="<?=$city_?>"){
        myform.city[myform.city.length-1].selected=true;
      }
    }
  }
}
function CheckAll(form){
  for (var i=0;i<form.elements.length;i++){
    var e = form.elements[i];
    if (e.name != 'checkbox')
    e.checked = form.checkbox.checked;
  }
}
</script>
<?include("footer.php");?>