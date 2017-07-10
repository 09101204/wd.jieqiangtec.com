<?
include_once("../include/common.inc.php");
switch(Char_Cv('action','get')){
  case 'checkcompanyid':
    $cid=Char_Cv('cid');
    print($db->rows('setting',"companyid='$cid'")?'N':'Y');
    exit();
    break;
  case 'save':
    $cid=Char_Cv('companyid');
    $pass1=Char_Cv('pass1');
    $pass2=Char_Cv('pass2');
    $email=Char_Cv('email');
    $url=Char_Cv('url');
    $upuser=Char_Cv('upuser');
    if(!$cid || !$pass1 || !$pass2 || !$email)ero($language['reg_error_save_imperfect']);
    if($pass1 !=$pass2)ero($language['reg_error_pass2_distinct']);
    if($db->rows('setting',"companyid='$cid'"))ero($language['reg_error_companyid_exists']);
    $exptime=GetTime(date('Y-m-d',$time))+$freeday*86400;
    
    $infoprov=$infoaddr[0];
    $infocity=$infoaddr[1];
    $ntype=$fullfun=='1' ? 2 : 0;
    $upuser=$db->select("setting","companyid","companyid='$upuser'");
    $db->insert('setting','companyid,status,company,infotime,exptime,grade,agent,infoprov,infocity,ntype,upuser',"$cid|1|$cid|$time|$exptime|$myfun|$agent|$infoprov|$infocity|2|$upuser");
    $db->insert('workersort','companyid,sort',"$cid|$default_workersort");
    $sid=$db->select('workersort','id',"companyid='$cid' order by id desc");
    $pass=md5($pass2);
    $db->insert('worker','companyid,sortid,grade,username,password,nickname,thisip,thistime,thisaddress,logincount',"$cid|$sid|all|$cid|$pass|$default_worker|$onlineip|$now|$address|1");
    WriteLog($cid,"注册账号","成功注册账号并已开通！");
    
    $_SESSION["eqmk_worker_companyid"]=$cid;
    $_SESSION["eqmk_worker_username"]=$cid;
    print('<script type="text/javascript">location.href="eqmk://ok.'.$cid.'.'.$cid.'.'.$pass1.'";location.href="reg.php"</script>');
    exit();
    break;
}
?>
<html>
<title>客服管理软件统计调用</title>
<META http-equiv=Content-Type content=text/html; charset=gb2312>
<link rel="stylesheet" type="text/css" href="images/style.css">
<body leftmargin="0" topmargin="2" scroll="no" oncontextmenu=self.event.returnValue=false onselectstart="return false">
<form name="regform" action="reg.php?action=save" method="post" onSubmit="return checkform()">
<table border="0" cellspacing="0" cellpadding="0" style="color:#2f539c">
<tr>
  <td width="120" height="45" align="right"><span style="color:#e65a00">*</span> 填写帐号：</td>
  <td width="160"><input type="text" class="a" name="companyid" size="18" maxlength="20" onFocus="return SetDefault('companyid');" onBlur="CheckCompanyid()" onKeyUp="SetNo(this)" onChange="SetNo(this)"></td>
  <td><div id="companyidmsg" class="tiptd1">4-20个字符 (仅限大小写字母,数字,下划线)，注册后不可修改。</div></td>
</tr>
<tr>
  <td height="20" align="right">管理工号：</td>
  <td><input type="text" class="a" name="username" size="18" disabled></td>
  <td>管理工号默认跟帐号统一，无需再次填写，登录时使用。</td>
</tr>
<tr>
  <td height="45" align="right"><span style="color:#e65a00">*</span> 填写登陆密码：</td>
  <td><input type="password" class="a" name="pass1" size="18" maxlength="20" onFocus="return SetDefault('pass1');" onBlur="CheckPass1()"></td>
  <td><div id="pass1msg" class="tiptd1">6～20个字符。</div></td>
</tr>
<tr>
  <td height="45" align="right"><span style="color:#e65a00">*</span> 确认登陆密码：</td>
  <td><input type="password" class="a" name="pass2" size="18" maxlength="20" onFocus="return SetDefault('pass2');" onBlur="CheckPass2()"></td>
  <td><div id="pass2msg" class="tiptd1">重复输入一次上面的密码。</div></td>
</tr>
<tr>
  <td height="45" align="right"><span style="color:#e65a00">*</span> 安全邮件地址：</td>
  <td><input type="text" class="a" name="email" size="18" maxlength="120" onFocus="return SetDefault('email');" onBlur="CheckEmail()"></td>
  <td><div id="emailmsg" class="tiptd1">安全邮件地址可帮你找回密码，请认真填写！</div></td>
</tr>
<tr>
  <td height="45" align="right"><span style="color:#e65a00"></span> 公司网站：</td>
  <td><input type="text" class="a" name="url" size="18" maxlength="120" value="http://"></td>
  <td>您自己的网址，例如“http://www.2800.com.cn”</td>
</tr>
<tr>
  <td height="45" align="right"><span style="color:#e65a00"></span> 推荐人：</td>
  <td><input type="text" class="a" name="upuser" size="18" maxlength="20" value=""></td>
  <td></td>
</tr>
<tr>
  <td colspan="3" align="center">
    <input type="image" name="submit" style="width:80px;height:22px" src="../images/s_3.gif">
    <img src="../images/s_4.gif" style="cursor:pointer" onClick="regform.reset()">
  </td>
</tr>
</table>
</form>

<script type="text/javascript" src="../include/javascript/common.js"></script>
<script type="text/javascript" src="../include/javascript/ajax.js"></script>
<script type="text/javascript">
var theform=document.regform;
function SetNo(obj){
  theform.username.value=obj.value;
}
function SetDefault(s){
  switch(s){
    case 'companyid':
      $("companyidmsg").className="tiptd1";
      $("companyidmsg").innerHTML="4-20个字符 (仅限大小写字母,数字,下划线)，注册后不可修改。";
      break;
    case 'pass1':
      $("pass1msg").className="tiptd1";
      $("pass1msg").innerHTML="6～20个字符。";
      break;
    case 'pass2':
      $("pass2msg").className="tiptd1";
      $("pass2msg").innerHTML="重复输入一次上面的密码。";
      break;
    case 'email':
      $("emailmsg").className="tiptd1";
      $("emailmsg").innerHTML="安全邮件地址可帮你找回密码，请认真填写！";
      break;
  }
}
function checkstr(e){
var ok = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_";
for(var i=0; i<e.length; i++){
if (ok.indexOf(e.charAt(i))<0) {
return false;
}
}
return true;
}
function checkEmail(e){
var ok = "1234567890qwertyuiop[]asdfghjklzxcvbnm.+@-_QWERTYUIOPASDFGHJKLZXCVBNM";
for(var i=0; i<e.length; i++){
if (ok.indexOf(e.charAt(i))<0) {
return false;
}
}
if(e.indexOf("@")<=0){
return false;
}
if(e.indexOf(".")<=0){
return false;
}	
return true;
}
function CheckCompanyid(){
  if(theform.companyid.value.length<1){
$("companyidmsg").className="tiptd2";
$("companyidmsg").innerHTML="帐号不能为空。";
return false;
  }
  if(theform.companyid.value.length<4){
$("companyidmsg").className="tiptd2";
$("companyidmsg").innerHTML="帐号不能小于4个字符。";
return false;
  }
  if(theform.companyid.value.length>20){
$("companyidmsg").className="tiptd2";
$("companyidmsg").innerHTML="帐号不能大于20个字符。";
return false;
  }
  if(!checkstr(theform.companyid.value)){
$("companyidmsg").className="tiptd2";
$("companyidmsg").innerHTML="仅限大小写字母,数字,下划线。";
return false;
  }
  var x=new Ajax("HTML","");
  x.post("reg.php?action=checkcompanyid","cid="+theform.companyid.value,function(s){
    if(s=="Y"){
      $("companyidmsg").className="tiptd3";
      $("companyidmsg").innerHTML="您的账号可用。";
      return true;
    }else{
      $("companyidmsg").className="tiptd2";
      $("companyidmsg").innerHTML="您填写的账号已被其他人注册,请重新填写。";
      return false;
    }
  });
  return true;
}
function CheckPass1(){
  if(theform.pass1.value.length<1){
$("pass1msg").className="tiptd2";
$("pass1msg").innerHTML="密码不能为空。";
return false;
  }
  if(theform.pass1.value.length<6){
$("pass1msg").className="tiptd2";
$("pass1msg").innerHTML="密码不能小于6个字符。";
return false;
  }
  if(theform.pass1.value.length>20){
$("pass1msg").className="tiptd2";
$("pass1msg").innerHTML="密码不能大于20个字符。";
return false;
  }
  $("pass1msg").className="tiptd3";
  $("pass1msg").innerHTML="√";
  return true;
}
function CheckPass2(){
  if(theform.pass1.value!=theform.pass2.value){
$("pass2msg").className="tiptd2";
$("pass2msg").innerHTML="两次密码输入不一致";
return false;
  }
  $("pass2msg").className="tiptd3";
  $("pass2msg").innerHTML="√";
  return true;
}
function CheckEmail(){
  if(theform.email.value.length<1){
$("emailmsg").className="tiptd2";
$("emailmsg").innerHTML="邮件地址不能为空。";
return false;
  }
  if(!checkEmail(theform.email.value)){
$("emailmsg").className="tiptd2";
$("emailmsg").innerHTML="邮件地址格式不正确。";
return false;
  }
  $("emailmsg").className="tiptd3";
  $("emailmsg").innerHTML="您的邮件地址可用。";
  return true;
}
function checkform(){
  if(!CheckCompanyid()){return false;}
  if(!CheckPass1()){return false;}
  if(!CheckPass2()){return false;}
  if(!CheckEmail()){return false;}
  return true;
}
</script>
</body>
</html>