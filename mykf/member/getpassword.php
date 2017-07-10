<?php
require_once '../include/mail.common.inc.php';
if($action=="getpassword"){
$admin_list = $db->get_one("SELECT * FROM $met_admin_table WHERE companyid='$companyid' and username='$admin_name'");
$admin_list2 = $db->get_one("SELECT * FROM $met_admin_table WHERE companyid='$companyid' and username='$admin_name' and email is not null");
if(!$admin_list){
okinfo('getpassword.php',你输入的帐号或者工号不正确，请重新输入！);
}
if(!$admin_list2){
okinfo('getpassword.php',没有邮箱地址，请联系管理员处理！);
}
else{
$from=$met_fd_usename;
$fromname=$met_fd_fromname;
$to=$admin_list[email];
$usename=$met_fd_usename;
$usepassword=$met_fd_password;
$smtp=$met_fd_smtp;

$random = mt_rand(1000, 9999);
$passwords=date('Ymd').$random;
$getpass=$passwords;
$companyid=$admin_list[companyid];
$username=$admin_list[username];
$passwords=md5($passwords);

$query = "update $met_admin_table SET
          password         = '$passwords' 
		  where companyid='$companyid' and username='$admin_name'";
$db->query($query);


$title=蓝蜘蛛客服会员密码通知;
$body="您在我公司申请的帐号为:[<font color=red>".$companyid."</font>]，工号为:[<font color=red>".$username."</font>]的用户密码已随机更改为:<font color=red>".$getpass."</font>请您及时登陆会员管理后台并更改密码";
jmailsend($from,$fromname,$to,$title,$body,$usename,$usepassword,$smtp);
okinfo('../index.php',请您登陆邮箱收取最新密码);
}
}else{
echo "<link href=login.css rel=stylesheet type=text/css />";
echo "<title>找回密码</title>";
echo "<br><br><br><form method='post' action='getpassword.php?action=getpassword'>请输入您的帐号：<input type='text' onmouseover=this.style.borderColor='#7DAF02' onmouseout=this.style.borderColor='#7F9DB9' style='BORDER-RIGHT: #7F9DB9 1px solid;BORDER-left: #7F9DB9 1px solid;BORDER-top: #7F9DB9 1px solid;BORDER-bottom: #7F9DB9 1px solid;' name='companyid' size='20'/><br><br>请输入您的工号：<input type='text' onmouseover=this.style.borderColor='#7DAF02' onmouseout=this.style.borderColor='#7F9DB9' style='BORDER-RIGHT: #7F9DB9 1px solid;BORDER-left: #7F9DB9 1px solid;BORDER-top: #7F9DB9 1px solid;BORDER-bottom: #7F9DB9 1px solid;' name='admin_name' size='20'/><br><br><br><br><DIV class=btn1aq onMouseOver=this.className='btn2' onmouseout=this.className='btn1'><BUTTON class=btn name=submit type=submit  onFocus='this.blur()' value='找回密码'>找回密码</BUTTON> </DIV><form><br><br><br><div style=text-align:left;width:90%;line-height:20px;color:red;>找回密码是通过电子邮件将密码发送到您在用户后台设置的邮箱里，如没有设置邮箱，不能找回密码，请联系网站管理员处理！</div>";
}
?>