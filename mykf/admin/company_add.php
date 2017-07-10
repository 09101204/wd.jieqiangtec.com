<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="save.php?action=company_add" method="post" onsubmit="return checkform()" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">添加客户</th>
</tr>
<tr>
<td width="30%" align="right">所属省市：</td>
<td width="70%">
<select name="prov" onchange="eqmk_sel(this.options.value)"></select>
	  <select name="city"></select>
</td>
</tr>
<tr>
<td align="right">客户编号：</td>
<td><?=setinput("text","companyid",$companyid,"",20,100)?></td>
</tr>
<tr>
<td align="right">登陆用户名：</td>
<td><font color="red">默认管理账号与客户编号相同</font></td>
</tr>
<tr>
<td align="right">登陆密码：</td>
<td><?=setinput("text","pass",$pass,"",20,100)?> 
<?=setinput("button","dpass","000000","onclick=\"myform.pass.value=this.value\"")?> 
<?=setinput("button","dpass","123456","onclick=\"myform.pass.value=this.value\"")?> 
<?=setinput("button","dpass","666666","onclick=\"myform.pass.value=this.value\"")?> 
<?=setinput("button","dpass","888888","onclick=\"myform.pass.value=this.value\"")?> 
</td>
</tr>
<tr>
<td colspan=2 align="center"><?=setinput("submit","submit"," 保存修改 ")?></td>
</tr>
</table>
</form>
<script type="text/javascript">
var prov=new Array();
var city=new Array();
<?foreach($province as $p){?>
prov[prov.length]="<?=$p?>";
<?}
foreach($city as $c){?>
city[city.length]=new Array("<?=$c[0]?>","<?=$c[1]?>");
<?}?>
myform.prov.length=0;
myform.prov[0]=new Option("省份","");
myform.city[0]=new Option("地级市","");
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
  myform.city[myform.city.length]=new Option("地级市","");
  for(j=1;j<city.length;j++){
    if(pid==city[j][0]){
      myform.city[myform.city.length]=new Option(city[j][1],city[j][1]);
      if(city[j][1]=="<?=$city_?>"){
        myform.city[myform.city.length-1].selected=true;
      }
    }
  }
  //if(myform.city.length>1)myform.city[1].selected=true;
}
function checkform(){
  if(myform.prov.options[myform.prov.selectedIndex].value==""){
    alert("请选择所在省份");
    myform.prov.focus();
    return false;
  }
  if(myform.city.options[myform.city.selectedIndex].value==""){
    alert("请选择所在城市");
    myform.city.focus();
    return false;
  }
  if(myform.companyid.value==""){
    alert("客户编号不能为空");
    myform.companyid.focus();
    return false;
  }
  if(myform.pass.value==""){
    alert("登陆密码不能为空");
    myform.pass.focus();
    return false;
  }
  return true;
}
</script>
<?include("footer.php");?>