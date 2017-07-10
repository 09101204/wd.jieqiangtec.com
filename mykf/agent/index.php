<?php
include_once("../include/common.inc.php");
if(Char_Cv("action")=="login"){
  $user=Char_Cv("username");
  $pass=md5(Char_Cv("password"));
  if($db->rows("agent","username='$user' and password='$pass'")==0){
    ero("用户名或密码不正确",1);
  }else{
    $mytime=GetTime(date('Y-m-d',$time));
    $agent=$db->record("agent","exptime","username='$user'",1);
    $exptime=$agent[0]['exptime'];
    if($exptime<$mytime)ero("您的账号已过期",0);
    
    $address=getaddress($onlineip,true);
    $db->query("update {$tbl}agent set lasttime=thistime,lastip=thisip,lastaddress=thisaddress,thistime=now(),thisip='$onlineip',thisaddress='".$address."',logincount=logincount+1 where username='$user'");
    $_SESSION["eqmk_agent_username"]=$user;
    header("location:manage.php");
    exit;
  }
}
$title=$language["login"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>代理商登陆</title>
<link href="../images/agentcp/login.css" rel="stylesheet" type="text/css">
<link href="../images/dedecms.css" rel="stylesheet" type="text/css" />
<link href="../images/dialog.css" rel="stylesheet" type="text/css" />
<link href="../images/login.css" rel="stylesheet" type="text/css" />
</head>
<body>
<script type="text/javascript">
<!--
    function ChangIterm(n) {
        for(var i=1;i<=2;i++){
            var curC=document.getElementById("tab_"+i);
            var curB=document.getElementById("tab_t"+i);
            if(n==i){
                curC.style.display="block";
                curB.className="thisiterm"
            }else{
                curC.style.display="none";
                curB.className=""
            }
        } 
    }
	
	//输入框状态
	function inputAutoClear(ipt)
	{
	 	ipt.onfocus=function()
	 	{if(this.value==this.defaultValue){this.value='';}};
	 	ipt.onblur=function()
	 	{if(this.value==''){this.value=this.defaultValue;}};
	 	ipt.onfocus();
	} 	
//-->
</script>
</head>
<body>
<script type="text/javascript" src="images/topNav.js"></script>
<div class="wrapper">
  <div id="head">
  <div class="htitle">
      <h1> <a href="http://www.2800.com.cn">28客服官方网站</a> </h1>
    </div>
    <div style="padding-top: 10px; padding-right: 17px;"></div>
    <div style="padding-top: 20px; padding-right: 18px;font-size:14px;">全国统一服务热线：<font color=red><strong> 400-004-1991</strong></font></div>
  </div>
  <div id="navo">
    <div id="navi">
      <div id="menu">
        <ul id="nav">
          <li><a href="../index.php"><span>首 页 </span></a></li>
          <li class="menu_line"/>
          <li><a class="" href="../reg.php"><span>免费申请</span></a></li>
            <li class='menu_line'></li>
			          
          <li><a class="" href="../download.php"><span>软件下载</span></a></li>
            <li class='menu_line'></li>
          
          <li><a class="" href="../function.php"><span>功能介绍</span></a></li>
            <li class='menu_line'></li>
          
          <li><a class="" href="../price.php"><span>资费套餐</span></a></li>
            <li class='menu_line'></li>
          
          <li><a class="" href="index.php"><span>代理专区</span></a></li>
            <li class='menu_line'></li>
          
          <li><a class="" href="../news.php"><span>新闻资讯</span></a></li>
            <li class='menu_line'></li>
          
          <li><a class="" href="../help.php"><span>帮助中心</span></a></li>
            <li class='menu_line'></li>
          
          <li><a class="" href="../about.php"><span>关于我们</span></a></li>
            <li class='menu_line'></li>           
          
          <li><a class="" href="../service.php"><span>客户服务</span></a></li>
            <li class='menu_line'></li>           
          
          
        </ul>
      </div>
    </div>
  </div>
</div>
<DIV id=MainDiv>
<DIV class=ContentDiv1>
<DIV id=LoginDiv>
<DIV class=content1>
<DIV><IMG src="../images/agentcp/2.jpg" width="956" height=94 border=0></DIV>
<DIV id=LoginBox>
<DIV class=Login_tit></DIV>
<DIV class=Login_Cont>
  <form action="index.php" method="post" name="myform" onSubmit="return checkform()">
<UL>
  <LI class=li_ud>用户名：<?=setinput("text","username","",16,20)?> 
  <LI class=li_ud>密　码：<?=setinput("password","password","",16,20)?> 
  <LI class=li_bt>
  <DIV class=btn1aq onMouseOver="this.className='btn2aq'" onmouseout="this.className='btn1aq'"><BUTTON class=btnaq name=submit type=submit  onFocus="this.blur()" value="登　录">登　录</BUTTON> </DIV>
  <DIV class=btn3aq onMouseOver="this.className='btn4aq'" onMouseOut="this.className='btn3aq'"><BUTTON class=btnaq name=reset type=reset value="取　消">取　消</BUTTON> </DIV>
  <LI class=li_line>
  <LI class=li_input><a onclick="javascript:getpassword('../member/getpassword.php','',400,300);" style="cursor:pointer"><font color="#FF0000">找回密码？</font></a></LI></UL>            
  <input type="hidden" name="action" value="login">
  </form>

</DIV>
</DIV>
<DIV id=FuncDiv>
<DIV class=speed>
<UL>
  <LI class=icon><IMG height=47 src="../images/agentcp/icon1.gif" width=47 border=0>
  <LI class=tit><span class=green0 >低投入低风险 </span> 
  <LI class=cont><SPAN class=green00>代理伙伴拥有巨大的利润空间，我们的高速发展，保证代理有更多的利益。</SPAN> </LI></UL></DIV>
<DIV class=safe>
<UL>
  <LI class=icon><IMG height=47 src="../images/agentcp/icon2.gif" width=47 border=0> 
  <LI class=tit><span class=green0 >长期的利润回报</span> 
  <LI class=cont><SPAN class=green00>客户和代理商采取终身绑定制，保护代理商利益。每年可持续收取年服务费。</SPAN> </LI></UL></DIV>
<DIV class=attach>
<UL>
  <LI class=icon><IMG height=47 alt=在线网银安全支付 
  src="../images/agentcp/icon3.gif" width=47 border=0> 
  <LI class=tit><span class=green0 >在线网银安全支付</span> 
  <LI class=cont><SPAN class=green00>我们为代理商提供安全、稳定、高效益的一站式转账支付平台，方便快捷。</SPAN> </LI></UL></DIV>
</DIV></DIV></DIV>
</DIV>

<div class="content12">
</div>
</DIV>
<div class="clear"></div>
<div class="wrapper mT5">
  <div id="partner">
    <div class="utitle">
      <div class="utitlei">
        <div class="title"><span class="title_t fLeft"><span class="title_t_i fLeft">
          <h2>合作伙伴</h2>
          </span></span>
          <div class="title_text fLeft mL10 mT13"><img src="../images/partner_text.gif" width="53" height="12" /></div>
        </div>
      </div>
    </div>
    <div class="ucontent">
<div class="partneri clear" style="margin-top: 0px; padding-top: 10px; padding-bottom: 10px;"> <a target="_blank" href="https://www.alipay.com"><img src="../images/zfb.gif"/></a> <a target="_blank" href="https://www.tenpay.com"><img src="../images/cft.gif"/></a> <a target="_blank" href="http://www.visa.com.cn"><img src="../images/visa.gif"/></a> <a target="_blank" href="http://www.chinabank.com.cn"><img src="../images/wy.gif"/></a> <a target="_blank" href="https://www.paypal.com/cn/"><img src="../images/ba.gif"/></a> <a target="_blank" href="https://www.99bill.com"><img src="../images/qqzf.gif"/></a> <a target="_blank" href="http://www.xinnet.com"><img src="../images/xinnet.gif"/></a> <a target="_blank" href="http://www.chinatelecom.com.cn"><img src="../images/dx.gif"/></a> </div>
    </div>
    <div class="title_buttom">
      <div class="title_buttom_i"></div>
    </div>
  </div>
</div>
<div class="wrapper mT5 mB10">
  <div class="title_top">
    <div class="title_top_i"></div>
  </div>
  <div class="ucontent">
    <div id="buttom_c" class="clear">
      <div id="buttom_logo"><img src="../images/buttom_logo.gif" width="149" height="25" /></div>
      <div id="buttom_text">全国统一服务热线：<font color=red><strong>400-004-1991</strong></font>&nbsp;&nbsp;&nbsp;&nbsp;13077494808&nbsp;&nbsp;&nbsp;&nbsp;QQ：26897364</div>
      <div id="buttom_top"><a href="#top"><img src="../images/gto_top.gif" width="76" height="23" /></a></div>
      <div id="copyright" class="clear" style="padding-top: 5px;padding-left: 200px;">&copy; 2010  28客服 Inc. All rights reserved Powered by <a href="http://www.2800.com.cn" target="_blank">2800.com.cn</a>&nbsp;&nbsp;&nbsp;&nbsp;
</div>
      <div class="clear"></div>
    </div>
  </div>
  <div class="title_buttom">
    <div class="title_buttom_i"></div>
  </div>
</div>
<div style="top: 1475px;" id="foot"></div>
</body>
</html>
<script language="JavaScript" type="text/JavaScript">
function getpassword(url,name,iWidth,iHeight)
{
var url; //转向网页的地址;
var name; //网页名称，可为空;
var iWidth; //弹出窗口的宽度;
var iHeight; //弹出窗口的高度;
var iTop = (window.screen.availHeight-30-iHeight)/2; //获得窗口的垂直位置;
var iLeft = (window.screen.availWidth-10-iWidth)/2; //获得窗口的水平位置;
window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=no,menubar=no,scrollbars=auto,resizeable=no,location=no,status=no');
}
</script>

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
</body>
</html>