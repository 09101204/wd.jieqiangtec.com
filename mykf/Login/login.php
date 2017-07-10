<?php
include_once("../include/common.inc.php");
if(Char_Cv("action")=="login"){
  $cid=Char_Cv("companyid");
  $user=Char_Cv("username");
  $pass=md5(Char_Cv("password"));
  if($db->rows("worker","companyid='$cid' and username='$user' and password='$pass'")==0){
    ero("用户名或密码不正确",0);
  }else{
    $setting=$db->record("setting","ntype,exptime,grade,package","companyid='$cid'",1);
    if(!$setting)ero("账号不存在",0);
    $exptime=$setting[0]['exptime'];
    $package=$setting[0]['package'];
    $mytime=GetTime(date('Y-m-d',$time));
    $myfun=array();
    if($exptime<$mytime){
      WriteLog($cid,'套餐','套餐功能过期，已恢复为普通账号！');
    }else{
      if($package!=0){
        $pfun=$db->select("package","funs","id=$package");
        $pfun=explode(',',$pfun);
        foreach($pfun as $v){
          $myfun[$v]=$v;
        }
      }
    }
    $fun=$db->record("myfunction","keyname","companyid='$cid' and exptime>=$mytime");
    foreach($fun as $rs){
      $myfun[$rs['keyname']]=$rs['keyname'];
    }
    if(count($myfun)==0 && $autolock=='1'){
      exit("overtime");
    }
    $fun=$db->record("function","keyname","price=0 and isused=1");
    foreach($fun as $rs){
      $myfun[$rs['keyname']]=$rs['keyname'];
    }
    $Grade=$myfun;
    $super=CheckGrade('super')?'Y':'';
    $db->update("setting","grade,status",implode(',',$myfun).'|1',"companyid='$cid'");
    
    $address=getaddress($onlineip,true);
    $db->query("update {$tbl}worker set lasttime=thistime,lastip=thisip,lastaddress=thisaddress,thistime=now(),thisip='$onlineip',thisaddress='".$address."',logincount=logincount+1 where companyid='$cid' and username='$user'");
    
    $talktimes=count($db->record("history","id","companyid='$cid' group by clientid"));
    $db->update("setting","talk","$talktimes","companyid='$cid'");
    
    $_SESSION["eqmk_worker_companyid"]=$cid;
    $_SESSION["eqmk_worker_username"]=$user;
    print('<script>location.href="/service/index.php?'.$time.'"</script><a href="/service/index.php">立即进入</a>');
    exit;
  }
}
$title=$language["login"];
?><html>


<title>28在线客服系统V1.1.0</title>

<style>
html{ overflow:hidden;}
body {margin-top:0px;margin-left:0px;width:100%;background:url(/images/login_bg2.gif) ;}
#login{ position:relative; width:100%; height:201px;background:url(/images/login_bg3.gif) no-repeat;}
#logo{ position:absolute; top:10px; left:14px;}
img{ border:0px;}
#login_tb{ position:absolute; left:20px; top:50px; width:240px; height:auto; font-size:12px;}
.login_td_left{ width:80px;line-height:30px; height:30px;color:#333;}
.text-input2{ line-height:20px; height:20px; width:150px; border:1px solid #A9BCDA;padding-left:4px; background:url(/images/login_inputbg2.gif);}
form{ margin:0px; padding:0px;}
#login_wait_word{font-size:12px;color:#FF9900;width:280px;height:25px;position:absolute;left:9px;bottom:32px;text-align:center;display:none;}
#login_wait{width:280px;height:25px;position:absolute;left:9px;bottom:12px;display:none;}
</style>
</head>


<body onload="login_resize()">
<div id="login">
	<div id="logo"><img src="/images/login_2.gif" width="275" height="40" title="28客服系统"/></div>
	<table border="0" cellpadding="0" cellspacing="0" id="login_tb">
  		<form action="login.php"  method="post" name="myform" onSubmit="return checkform()">
		<tr>
			<td align="right" valign="middle" class="login_td_left">账号：</td>
			<td align="left" valign="middle"><input class="text-input2" type="text" id="companyid" name="companyid" value="" size="12" maxlength="20" onblur="this.style.background='#FFFFEE'; this.style.border='1px solid #F4BF20';" onfocus="this.style.background='#FFFFFF'; this.style.borderTop='1px solid #000000'; this.style.borderRight='1px solid #CCC'; this.style.borderBottom='1px solid #CCC'; this.style.borderLeft='1px solid #000000';" >
			
			</td>
		</tr>
		<tr>
			<td align="right" valign="middle" class="login_td_left">工号：</td>
			<td align="left" valign="middle"><input class="text-input2"   type="text" id="username" name="username" value="" size="12" maxlength="20" onblur="this.style.background='#FFFFEE'; this.style.border='1px solid #F4BF20';" onfocus="this.style.background='#FFFFFF'; this.style.borderTop='1px solid #000000'; this.style.borderRight='1px solid #CCC'; this.style.borderBottom='1px solid #CCC'; this.style.borderLeft='1px solid #000000';" title="请输入您的客服工号"></td>
		</tr>
		<tr>
			<td align="right" valign="middle" class="login_td_left">密码：</td>
			<td align="left" valign="middle"><input  class="text-input2" type="password" id="password" name="password" value="" size="12" maxlength="20" onblur="this.style.background='#FFFFEE'; this.style.border='1px solid #F4BF20';" onfocus="this.style.background='#FFFFFF'; this.style.borderTop='1px solid #000000'; this.style.borderRight='1px solid #CCC'; this.style.borderBottom='1px solid #CCC'; this.style.borderLeft='1px solid #000000';" title="请输入您的登录密码"></td>
		</tr>

		<tr>
			<td valign="middle" class="login_td_left">　</td>
			<td align="left" valign="middle">
			<INPUT class="loginbutton" type=image src="/images/login_sub2_cn.gif" width="50" height="22" style="cursor:pointer;margin-top:3px;"  value="确定" name="Submit">	
			&nbsp;&nbsp;&nbsp;<img src="/images/login_reg2_cn.gif" alt="申请28客服账号" width="70" height="22" style="cursor:pointer" onClick="window.open('/reg.php','_blank')" /></td>
		</tr>
		  <input type="hidden" name="action" value="login">
	  </form>
	</table>
</div>
<script type="text/javascript">
function checkform(){
  if(myform.username.value==""){
    alert("用户名不能为空");
    myform.username.focus()
    return false;
  }
  if(myform.password.value==""){
    alert("密码不能为空");
    myform.password.focus()
    return false;
  }
}
</script>

<script type="text/javascript">
  window.onresize = login_resize;
  function login_resize()
  {
    try
    {
      docHeight = document.documentElement.clientHeight;
      if(docHeight==0)
      {
        docHeight = document.body.clientHeight;
      }

      docWidth = document.documentElement.clientWidth;
      if(docWidth==0)
      {
        docWidth = document.body.clientWidth;
      }

      if(docWidth<298)
      {
        docWidth = 298;
      }
      if(docHeight<194)
      {
        docHeight = 194;
      }

      document.getElementById("login").style.top = (parseInt((docHeight-194)/2))+"px";
      document.getElementById("login").style.left = (parseInt((docWidth-298)/2))+"px";
    }
    catch(e){}
  }
</script>

</body>
</html>