<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="save.php?action=config" method="post" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;��������</th>
</tr>
<tr>
<td width="20%" align="right" height="20">��˾���ƣ�</td>
<td width="80%">
<?=setinput("text","company",$company,"",52,100)?></td>
</tr>
<tr>
<td align="right" height="20">����ʡ�У�</td>
<td>
<select name="prov" onchange="eqmk_sel(this.options.value)"></select>
	  <select name="city"></select></td>
</tr>
<tr>
<td align="right" height="20">������ҵ��</td>
<td><select name="trade">
<?
foreach($Trade as $v){
print("<option value=\"$v\"".($v==$trade ? 'selected' : '').">$v</option>\n");
}
?>
</select></td>
</tr>
<tr>
<td align="right" height="20">��վͼ�꣺</td>
<td>
<?=setinput("text","logo_",$logo_,"",52,100)?> <img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_icon.gif'>" style="cursor:pointer"><font color="#999999">48*48</font></td>
</tr>
<?if(CheckGrade('mylogo')){?>
<tr>
<td align="right" height="20">��վLogo��</td>
<td>
<?=setinput("text","dialoglogo",$dialoglogo,"",52,100)?> <img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_logo.gif'>" style="cursor:pointer"><font color="#999999">(��ʾ�ڶԻ������½�)</font></td>
</tr>
<tr>
<td align="right" height="20">Logo���ӣ�</td>
<td>
<?=setinput("text","dialoglogourl",$dialoglogourl,"",52,100)?></td>
</tr>
<?}else{?>
<tr>
<td align="right" height="20">�Զ���Logo��</td>
<td><font color=red>�ܱ�Ǹ����û�п�ͨ�˹��ܣ�</font><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_sign.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<?}?>
<tr>
<td align="right" height="20">�Ի���ײ���棺</td>
<td>
<?if(CheckGrade('delad')){?>
<?=setinput("text","dialogad",$dialogad,"",52,100)?> <img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_ad.gif'>" style="cursor:pointer" align="absmiddle"><br />
<font color="#999999">����д�滻�ı�;����ʱ��ʾ���Զ����桱�� <a href="?action=gg_dialog" style="color:#0000ff">����</a></font></td>
<?}else{?>
<font color=red>�ܱ�Ǹ����û�п�ͨ�˹��ܣ�</font><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_ad.gif'>" style="cursor:pointer">
<?}?>
</td>
</tr>
<tr>
<td align="right" height="20">��վ�ؼ��֣�</td>
<td>
<?=setinput("text","keywords",$keywords,"",52,100)?></td>
</tr>
<tr>
<td align="right" height="20">��վ������</td>
<td>
<?=setinput("text","description",$description,"",52,100)?></td>
</tr>
<tr>
<td align="right" height="20">ҵ�����ͣ�</td>
<td>
<?=setinput("text","dialogsort",$dialogsort,"",52,100)?><br />�������ԡ���ѵ绰�������µ��мǿͿ�ѡ���ҵ�����͡������������<font color="red">|</font>�ָ�</td>
</tr>
<tr>
<td align="right" height="20">��˾��飺</td>
<td>
<?=SetEditor2(1,$companyinfo)?></td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;������������</th>
</tr>
<?if(CheckGrade('invite')){?>
<tr>
<td align="right" height="20">�Ƿ�����</td>
<td>
  <input type="radio" name="autoinvite" value="0" <?if($autoinvite==0)echo'checked'?>>��ʹ���������빦��<br />
  <input type="radio" name="autoinvite" value="1" <?if($autoinvite==1)echo'checked'?>>�����пͷ�����ʱ������������<br />
  <input type="radio" name="autoinvite" value="2" <?if($autoinvite==2)echo'checked'?>>���ۿͷ��Ƿ����߶�������������<br />
  <input type="radio" name="autoinvite" value="3" <?if($autoinvite==3)echo'checked'?>>�ͷ��ֶ�����</td>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
  <input type="checkbox" name="opennew" value="1" <?if($opennew)echo'checked'?> />ǿ�Ƶ����Ի��� <font color="#ff0000">(���ᱻ����,1��Сʱ֮��ֻ��ǿ�Ƶ���һ��)</font></td>
</tr>
<tr>
  <td align="right" height="20">ҳ�涳��Ч����</td>
  <td>  <input type="radio" name="effect" value="1" <?if($effect==1)echo'checked'?>>����
  <input type="radio" name="effect" value="0" <?if($effect==0)echo'checked'?>>�ر�
</td>
</tr>
<tr>
<td align="right" height="20">����������ʱ��</td>
<td>
<?=setinput("text","delay",$delay,"",5,10)?> ��</td>
</tr>
<tr>
<td align="right" height="20">����������⣺</td>
<td>
<?=setinput("text","invitetitle",$invitetitle,"",52,100)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_invitetitle.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<tr>
<td align="right" height="20">�����������ݣ�</td>
<td>
<?=setinput("text","invitecontent",$invitecontent,"",52,1000)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_invitecontent.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<tr>
<td align="right" height="20">����˵����</td>
<td>
  <font color=red>#ip#</font>: �ÿ�IP<br />
  <font color=red>#address#</font>: �ÿ͵���λ��<br />
  <font color=red>#company#</font>: ��˾����<br />
  <font color=red>#homepage#</font>: �ͷ���ַ<br />
  <font color=red>#workername#</font>: ��������Ŀͷ�����<br />
  <font color=red>#br#</font>: ���з�<br />
  <font color=red>#font#</font>: �������忪ʼ<br />
  <font color=red>#/font#</font>: �����������<br /></td>
</tr>
<?}else{?>
<tr>
<td align="right" height="20"></td>
<td><font color=red>�ܱ�Ǹ����û�п�ͨ�˹��ܣ�</font></td>
</tr>
<?}?>
<tr>
<th colspan=2 align="left">&nbsp;�ÿͶ˽�������</th>
</tr>
<tr>
<td align="right" height="20">�Ի���Ĭ�����ԣ�</td>
<td>
  <input type="radio" name="language_dialog" value="zh-cn" <?if($language_dialog=='zh-cn')echo'checked'?>>��������<br />
  <input type="radio" name="language_dialog" value="zh-tw" <?if($language_dialog=='zh-tw')echo'checked'?>>�������� <br />
  <input type="radio" name="language_dialog" value="en" <?if($language_dialog=='en')echo'checked'?>>Ӣ��<br />
  <input type="radio" name="language_dialog" value="fy" <?if($language_dialog=='fy')echo'checked'?>>����<br />
  </td>
</tr>
<tr>
<td align="right" height="20">�Ի�����⣺</td>
<td>
<?=setinput("text","dialogtitle",$dialogtitle,"",52,100)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_title.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;��������</th>
</tr>
<tr>
<td align="right" height="20">�Զ�Ӧ��</td>
<td><input type="radio" name="autofaq" value="0" <?if($autofaq==0)echo'checked'?>>��ʹ��<br />
  <input type="radio" name="autofaq" value="1" <?if($autofaq==1)echo'checked'?>>�����пͷ�����ʱ��ʾ�б�<br />
  <input type="radio" name="autofaq" value="2" <?if($autofaq==2)echo'checked'?>>���ۿͷ��Ƿ����߶���ʾ�б�</td>
</tr>
<tr>
<td align="right" height="20"></td>
<td><input type="checkbox" name="allowpingfen" value="1" <?if($allowpingfen==1)echo'checked'?>>����ÿͶԿͷ���������</td>
</tr>
<tr>
<td colspan=2 align="center"><?=setinput("submit","submit","�����޸�")?></td>
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
myform.prov[0]=new Option("δѡ��","");
myform.city[0]=new Option("δѡ��","");
window.onload=function(){
  for(i=0;i<prov.length;i++){
    myform.prov[myform.prov.length]=new Option(prov[i],prov[i]);
    if(prov[i]=="<?=$prov_?>"){
      myform.prov[myform.prov.length-1].selected=true;
      eqmk_sel(prov[i]);
    }
  }
}
function eqmk_sel(pid){
  myform.city.length=0;
  if(pid==""){
    myform.city[myform.city.length]=new Option("δѡ��","");
    return;
  }
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
</script>
<?include("footer.php");?>