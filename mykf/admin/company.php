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
  <td width="200" height="20" align="right"> ��ҵ���ƣ�</td>
  <td width="400"><input type="text" class="a" size="22" name="mycompany" maxlength="20" value="<?=$mycompany?>"></td>
</tr>
<tr>
  <td height="20" align="right"> ��ҵ��ţ�</td>
  <td><input type="text" class="a" size="22" name="loginname" maxlength="20" value="<?=$loginname?>"></td>
</tr>
<tr>
  <td height="20" align="right"> �����̣�</td>
  <td><input type="text" class="a" size="22" name="agent" maxlength="20" value="<?=$agent?>"></td>
</tr>
<tr>
  <td height="20" align="right"> ����ʡ�У�</td>
  <td><select name="prov" onchange="eqmk_sel(this.options.value)"></select>
	  <select name="city"></select></td>
</tr>
<tr>
  <td height="20" align="right"> �ײͣ�</td>
  <td>
    <select name="package">
    <option value="-1"<?if($package==-1)echo' selected'?>>- ���� -</option>
    <option value="0"<?if($package==0)echo' selected'?>>��ͨ�û�</option>
    <?$ThePackage=array();
    foreach($Package as $rs){
    $ThePackage[$rs['id']]=$rs['title'];
    $s=$rs['id']==$package?' selected':'';?>
    <option value="<?=$rs['id']?>"<?=$s?>><?=$rs['title']?></option>
    <?}?></select>
  </td>
</tr>
<tr>
  <td height="20" align="right"> ��</td>
  <td>
    <input type="text" class="a" size="8" name="moneya" maxlength="20" value="<?=$moneya?>">
    ��
    <input type="text" class="a" size="8" name="moneyb" maxlength="20" value="<?=$moneyb?>"> Ԫ
  </td>
</tr>
<tr>
  <td height="20" align="right"> ���Ѷ</td>
  <td>
    <input type="text" class="a" size="8" name="paymoneya" maxlength="20" value="<?=$paymoneya?>">
    ��
    <input type="text" class="a" size="8" name="paymoneyb" maxlength="20" value="<?=$paymoneyb?>"> Ԫ
  </td>
</tr>
<tr>
  <td height="32" align="right"></td>
  <td align="left">
    <input type="hidden" name="action" value="company">
    <input type="submit" name="submit" value=" ���� " class="button">&nbsp;&nbsp;
    <input type="reset" name="submit" value=" ���� " class="button">
  </td>
</tr>
</table>
</form>
<br />
<br />
<?if($_GET['submit']){
if($company[2]==0)print('<h1>�ܱ�Ǹ��û���ҵ��κη��ϵ�ǰ���������Ŀͻ�</h1>');
if($MyTitle)echo'<h3>'.$MyTitle.'</h3>';?>
<table border="0" cellspacing="1" align="center" class="list">
<tr align="center">
<th width="20%">��ҵ����/���</th>
<th width="20%">������</th>
<th width="8%">�ײ�</th>
<th width="8%">���</th>
<th width="8%">���Ѷ�</th>
<th width="8%">�ȶ�</th>
<th width="8%">��ѯ</th>
<th width="8%">����</th>
<th width="20%">����</th>
</tr>
<?foreach($company[0] as $rs){
$id=$rs["id"];
if($rs['agent']){
  if($agent=$db->record("agent","prov,city,ntype,company","username='".$rs['agent']."'",1)){
    $ag='<a href="'.($agent[0]['ntype']=='prov' ? '?action=agent_set&type=prov&prov='.$agent[0]['prov'] : '?action=agent_set&type=city&prov='.$agent[0]['prov'].'&city='.$agent[0]['city']).'" title="'.($agent[0]['ntype']=='prov' ? $agent[0]['prov'].'�ܴ���' : $agent[0]['prov'].$agent[0]['city'].'�ܴ���').'">'.$agent[0]['company'].'</a>';
  }else{
    $ag='��';
  }
}else{
  $ag='��';
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
  <a href="admin.php?action=companyedit&id=<?=$id?>"><img src="../images/admincp/icon_edit.gif" border="0" alt="�༭�ͻ�"></a>
  <a href="save.php?action=delcompany&id=<?=$id?>" onClick="return confirm('��ȷ��Ҫɾ������ҵ��\n\n�ò������ɻָ��������ؽ��У�')"><img src="../images/admincp/icon_delete.gif" border="0" alt="ɾ���ͻ�"></a>
  <a href="admin.php?action=company_money&cid=<?=$rs["companyid"]?>"><img src="../images/admincp/icon_money.gif" border="0" alt="������ϸ"></a>
  <a href="admin.php?action=company_log&cid=<?=$rs["companyid"]?>"><img src="../images/admincp/icon_log.gif" border="0" alt="������־"></a>
</td>
</tr>
<?}?>
</table>
<table width='90%' height=2><tr ><td></td></tr></table>
<!--ҳ�뿪ʼ-->
<?=$company[1]?>
<?}?>
<!--ҳ�����-->
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
myform.prov[0]=new Option("����","");
myform.city[0]=new Option("����","");
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
  myform.city[myform.city.length]=new Option("����","");
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