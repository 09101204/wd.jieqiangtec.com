<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="save.php?action=config" method="post" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;基本设置</th>
</tr>
<tr>
<td width="20%" align="right" height="20">公司名称：</td>
<td width="80%">
<?=setinput("text","company",$company,"",52,100)?></td>
</tr>
<tr>
<td align="right" height="20">所在省市：</td>
<td>
<select name="prov" onchange="eqmk_sel(this.options.value)"></select>
	  <select name="city"></select></td>
</tr>
<tr>
<td align="right" height="20">所属行业：</td>
<td><select name="trade">
<?
foreach($Trade as $v){
print("<option value=\"$v\"".($v==$trade ? 'selected' : '').">$v</option>\n");
}
?>
</select></td>
</tr>
<tr>
<td align="right" height="20">网站图标：</td>
<td>
<?=setinput("text","logo_",$logo_,"",52,100)?> <img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_icon.gif'>" style="cursor:pointer"><font color="#999999">48*48</font></td>
</tr>
<?if(CheckGrade('mylogo')){?>
<tr>
<td align="right" height="20">网站Logo：</td>
<td>
<?=setinput("text","dialoglogo",$dialoglogo,"",52,100)?> <img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_logo.gif'>" style="cursor:pointer"><font color="#999999">(显示在对话框右下角)</font></td>
</tr>
<tr>
<td align="right" height="20">Logo链接：</td>
<td>
<?=setinput("text","dialoglogourl",$dialoglogourl,"",52,100)?></td>
</tr>
<?}else{?>
<tr>
<td align="right" height="20">自定义Logo：</td>
<td><font color=red>很抱歉，您没有开通此功能！</font><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_sign.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<?}?>
<tr>
<td align="right" height="20">对话框底部广告：</td>
<td>
<?if(CheckGrade('delad')){?>
<?=setinput("text","dialogad",$dialogad,"",52,100)?> <img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_ad.gif'>" style="cursor:pointer" align="absmiddle"><br />
<font color="#999999">请填写替换文本;留空时显示“自定义广告”！ <a href="?action=gg_dialog" style="color:#0000ff">设置</a></font></td>
<?}else{?>
<font color=red>很抱歉，您没有开通此功能！</font><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_ad.gif'>" style="cursor:pointer">
<?}?>
</td>
</tr>
<tr>
<td align="right" height="20">网站关键字：</td>
<td>
<?=setinput("text","keywords",$keywords,"",52,100)?></td>
</tr>
<tr>
<td align="right" height="20">网站描述：</td>
<td>
<?=setinput("text","description",$description,"",52,100)?></td>
</tr>
<tr>
<td align="right" height="20">业务类型：</td>
<td>
<?=setinput("text","dialogsort",$dialogsort,"",52,100)?><br />离线留言、免费电话、在线下单中记客可选择的业务类型。多个类型请用<font color="red">|</font>分隔</td>
</tr>
<tr>
<td align="right" height="20">公司简介：</td>
<td>
<?=SetEditor2(1,$companyinfo)?></td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;主动邀请设置</th>
</tr>
<?if(CheckGrade('invite')){?>
<tr>
<td align="right" height="20">是否开启：</td>
<td>
  <input type="radio" name="autoinvite" value="0" <?if($autoinvite==0)echo'checked'?>>不使用主动邀请功能<br />
  <input type="radio" name="autoinvite" value="1" <?if($autoinvite==1)echo'checked'?>>仅当有客服在线时发出主动邀请<br />
  <input type="radio" name="autoinvite" value="2" <?if($autoinvite==2)echo'checked'?>>无论客服是否在线都发出主动邀请<br />
  <input type="radio" name="autoinvite" value="3" <?if($autoinvite==3)echo'checked'?>>客服手动邀请</td>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
  <input type="checkbox" name="opennew" value="1" <?if($opennew)echo'checked'?> />强制弹出对话框 <font color="#ff0000">(不会被拦截,1个小时之内只能强制弹出一次)</font></td>
</tr>
<tr>
  <td align="right" height="20">页面冻结效果：</td>
  <td>  <input type="radio" name="effect" value="1" <?if($effect==1)echo'checked'?>>开启
  <input type="radio" name="effect" value="0" <?if($effect==0)echo'checked'?>>关闭
</td>
</tr>
<tr>
<td align="right" height="20">主动邀请延时：</td>
<td>
<?=setinput("text","delay",$delay,"",5,10)?> 秒</td>
</tr>
<tr>
<td align="right" height="20">主动邀请标题：</td>
<td>
<?=setinput("text","invitetitle",$invitetitle,"",52,100)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_invitetitle.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<tr>
<td align="right" height="20">主动邀请内容：</td>
<td>
<?=setinput("text","invitecontent",$invitecontent,"",52,1000)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_invitecontent.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<tr>
<td align="right" height="20">变量说明：</td>
<td>
  <font color=red>#ip#</font>: 访客IP<br />
  <font color=red>#address#</font>: 访客地理位置<br />
  <font color=red>#company#</font>: 公司名称<br />
  <font color=red>#homepage#</font>: 客服网址<br />
  <font color=red>#workername#</font>: 发出邀请的客服名称<br />
  <font color=red>#br#</font>: 换行符<br />
  <font color=red>#font#</font>: 设置字体开始<br />
  <font color=red>#/font#</font>: 设置字体结束<br /></td>
</tr>
<?}else{?>
<tr>
<td align="right" height="20"></td>
<td><font color=red>很抱歉，您没有开通此功能！</font></td>
</tr>
<?}?>
<tr>
<th colspan=2 align="left">&nbsp;访客端界面设置</th>
</tr>
<tr>
<td align="right" height="20">对话框默认语言：</td>
<td>
  <input type="radio" name="language_dialog" value="zh-cn" <?if($language_dialog=='zh-cn')echo'checked'?>>简体中文<br />
  <input type="radio" name="language_dialog" value="zh-tw" <?if($language_dialog=='zh-tw')echo'checked'?>>繁体中文 <br />
  <input type="radio" name="language_dialog" value="en" <?if($language_dialog=='en')echo'checked'?>>英语<br />
  <input type="radio" name="language_dialog" value="fy" <?if($language_dialog=='fy')echo'checked'?>>法语<br />
  </td>
</tr>
<tr>
<td align="right" height="20">对话框标题：</td>
<td>
<?=setinput("text","dialogtitle",$dialogtitle,"",52,100)?><img src="../images/membercp/view.gif" title="<img src='../images/membercp/view_title.gif'>" style="cursor:pointer" align="absmiddle"></td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;其他设置</th>
</tr>
<tr>
<td align="right" height="20">自动应答：</td>
<td><input type="radio" name="autofaq" value="0" <?if($autofaq==0)echo'checked'?>>不使用<br />
  <input type="radio" name="autofaq" value="1" <?if($autofaq==1)echo'checked'?>>仅当有客服在线时显示列表<br />
  <input type="radio" name="autofaq" value="2" <?if($autofaq==2)echo'checked'?>>无论客服是否在线都显示列表</td>
</tr>
<tr>
<td align="right" height="20"></td>
<td><input type="checkbox" name="allowpingfen" value="1" <?if($allowpingfen==1)echo'checked'?>>允许访客对客服进行评分</td>
</tr>
<tr>
<td colspan=2 align="center"><?=setinput("submit","submit","保存修改")?></td>
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
myform.prov[0]=new Option("未选择","");
myform.city[0]=new Option("未选择","");
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
    myform.city[myform.city.length]=new Option("未选择","");
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