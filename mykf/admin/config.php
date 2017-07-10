<?php
if(!defined('IN_EQMK') || !defined('IN_ADMIN')) {
	exit('Access Denied');
}
include("header.php");?>
<form action="save.php?action=config" method="post" name="myform">
<table border="0" cellspacing="1" align="center" class="list">
<tr>
<th colspan=2 align="left">&nbsp;基本设置<?=ToHelp('config')?></th>
</tr>
<tr>
<td width="30%" align="right" height="20">公司名称：</td>
<td width="70%">
<?=setinput("text","company",$company,"",40,100)?></td>
</tr>
<tr>
<td align="right" height="20">程序网址：</td>
<td>
<?=setinput("text","homepage",$homepage,"",40,100)?>最后必须以“/”结束！
</td>
</tr>
<tr>
<td align="right" height="20">官方客服编号：</td>
<td>
<?=setinput("text","mycompanyqq",$mycompanyqq,"",40,100)?> <font color="#999999">(官方提供客户服务的客服编号)</font></td>
</tr>
<tr>
<td align="right" height="20">前台网页语言：</td>
<td>
  <input type="radio" name="lang_web" value="zh-cn" <?if($lang_web=='zh-cn')echo'checked'?>>简体中文 
  <input type="radio" name="lang_web" value="zh-tw" <?if($lang_web=='zh-tw')echo'checked'?>>繁体中文
</td>
</tr>
<tr>
<td align="right" height="20">对话框默认语言：</td>
<td>
  <input type="radio" name="lang_dialog" value="zh-cn" <?if($lang_dialog=='zh-cn')echo'checked'?>>简体中文 
  <input type="radio" name="lang_dialog" value="zh-tw" <?if($lang_dialog=='zh-tw')echo'checked'?>>繁体中文 
  <input type="radio" name="lang_dialog" value="en" <?if($lang_dialog=='en')echo'checked'?>>英语
</td>
</tr>
<tr>
<td align="right" height="20">默认对话框Logo：</td>
<td>
<?=setinput("text","dialoglogo",$dialoglogo,"",40,100)?></td>
</tr>
<tr>
<td align="right" height="20">默认对话框Logo链接：</td>
<td>
<?=setinput("text","dialoglogourl",$dialoglogourl,"",40,100)?></td>
</tr>
<tr>
<td align="right" height="20">服务器时差：</td>
<td>
<?=setinput("text","timezone",$timezone,"",4,5)?></td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;代理商设置</th>
</tr>
<tr>
<td align="right" height="20">操作权限</td>
<td>
<?=setinput("checkbox","default_agenttype","1",$agenttype)?>除转账外可对客户进行其他操作<?=ToHelp('agentset')?>
</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;客服管理软件</th>
</tr>
<tr>
<td align="right" height="20">官方网址：</td>
<td>
<?=setinput("text","companyurl",$companyurl,"",40,100)?><br /><font color="#999999">(点击客户端“访问官方网站”跳转的网址，可以不是当前域名)</font></td>
</tr>
<tr>
<td align="right" height="20">软件标题：</td>
<td>
<?=setinput("text","softtitle",$softtitle,"",40,100)?><br /><font color="#999999">(您的客服管理软件叫什么名称？如：客户通)</font></td>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
<?=setinput("checkbox","closeloginad","1",$closeloginad=='1'?'checked':'')?>关闭登陆框广告
</td>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
<?=setinput("checkbox","closemainad","1",$closemainad=='1'?'checked':'')?>关闭主列表广告
</td>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
<?=setinput("checkbox","closefile","1",$closefile=='1'?'checked':'')?>关闭文件发送功能
</td>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
<?=setinput("checkbox","closecatch","1",$closecatch=='1'?'checked':'')?>关闭截图功能
</td>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
<?=setinput("checkbox","closepublic","1",$closepublic=='1'?'checked':'')?>关闭公共频道(企业内部通话)
</td>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
<?=setinput("checkbox","closelimit","1",$closelimit=='1'?'checked':'')?>关闭黑名单功能
</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;客服设置<?=ToHelp('worker')?></th>
</tr>
<tr>
<td align="right" height="20"></td>
<td>
<?=setinput("checkbox","allowreg","1",$allowreg=='1'?'checked':'')?>允许新用户申请
</td>
</tr>
<tr>
<td align="right" height="20">高级功能免费时间：</td>
<td>
<?=setinput("text","freeday",$freeday,"",4,5)?> 天
</td>
</tr>
<tr>
<td align="right" height="20">免费时间内赠送的高级功能：</td>
<td>
<?$i=0;
foreach($superfun as $rs){
$i++;
echo setinput("checkbox","regfun[]",$rs['keyname'],in_array($rs['keyname'],$regfuns)?'checked':'').'<span style="width:60px">'.$rs['title'].'</span> ';
if($i>0 && $i % 4==0)echo'<br />';
}?>
</td>
</tr>
<tr>
<td align="right" height="20">高级功能过期后：</td>
<td>
<?=setinput("radio","autolock",'1',$autolock=='1'?'checked':'')?>禁止登录客服端
<?=setinput("radio","autolock",'0',$autolock!='1'?'checked':'')?>继续使用免费功能
</td>
</tr>
<tr>
<td align="right" height="20">默认席位名称：</td>
<td>
<?=setinput("text","default_workersort",$default_workersort,"",20,20)?>
</td>
</tr>
<tr>
<td align="right" height="20">默认客服名称：</td>
<td>
<?=setinput("text","default_worker",$default_worker,"",20,20)?>
</td>
</tr>
<tr>
<td align="right" height="20">默认席位数量：</td>
<td>
<?=setinput("text","default_sortcount",$default_sortcount,"",4,5)?>
</td>
</tr>
<tr>
<td align="right" height="20">默认客服数量：</td>
<td>
<?=setinput("text","default_workercount",$default_workercount,"",4,5)?>
</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;客服价格表</th>
</tr>
<tr>
<td align="right" height="20">席位数单价</td>
<td>
<?=setinput("text","price_sort",$price_sort,"",4,10)?> 元
</td>
</tr>
<tr>
<td align="right" height="20">客服数单价</td>
<td>
<?=setinput("text","price_worker",$price_worker,"",4,10)?> 元
</td>
</tr>
<tr>
<td align="right" height="20">标准客户续费<?=$PriceOne[0]?>价格</td>
<td>
<?=setinput("text","price_days1",$price_days1,"",4,10)?> 元
</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;文件上传设置<?=ToHelp('sendfile')?></th>
</tr>
<tr>
<td align="right" height="20">单个文件大小：</td>
<td>
<?=setinput("text","maxfilesize",$maxfilesize,"",4,100)?>MB
</td>
</tr>
<tr>
<td align="right" height="20">允许文件类型：</td>
<td>
<?=setinput("text","allowfiletype",$allowfiletype,"",40,100)?><font color="#999999">(以<font color="red">|</font>分隔)</font>
</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;支付宝设置<?=ToHelp('alipay')?></th>
</tr>
<tr>
<td align="right" height="20">支付宝账号：</td>
<td>
<?=setinput("text","alipayid",$alipayid,"",40,100)?>
</td>
</tr>
<tr>
<td align="right" height="20">安全检验码：</td>
<td>
<?=setinput("text","alipaykey",$alipaykey,"",40,100)?>
</td>
</tr>
<tr>
<td align="right" height="20">合作伙伴ID：</td>
<td>
<?=setinput("text","partner",$partner,"",40,100)?>
</td>
</tr>
<tr>
<th colspan=2 align="left">&nbsp;邮箱服务器设置</th>
</tr>
<tr>
<td align="right" height="20">邮箱账号：</td>
<td>
<?=setinput("text","smtp_mail",$smtp_mail,"",40,100)?>&nbsp;&nbsp;用于发送邮件的邮箱账号
</td>
</tr>
<tr>
<td align="right" height="20">邮件SMTP服务器：</td>
<td>
<?=setinput("text","smtp_smtp",$smtp_smtp,"",40,100)?>&nbsp;&nbsp;如163邮箱为smtp.163.com
</td>
</tr>
<tr>
<td align="right" height="20">邮箱密码：</td>
<td>
<?=setinput("password","smtp_psd",$smtp_psd,"",40,100)?>&nbsp;&nbsp;用于发送邮件的邮箱密码
</td>
</tr>
<tr>
<td colspan=2 align="center"><?=setinput("submit","submit","保存修改")?></td>
</tr>
</table>
</form>
<?include("footer.php");?>