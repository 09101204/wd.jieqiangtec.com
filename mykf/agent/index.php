<?php
include_once("../include/common.inc.php");
if(Char_Cv("action")=="login"){
  $user=Char_Cv("username");
  $pass=md5(Char_Cv("password"));
  if($db->rows("agent","username='$user' and password='$pass'")==0){
    ero("�û��������벻��ȷ",1);
  }else{
    $mytime=GetTime(date('Y-m-d',$time));
    $agent=$db->record("agent","exptime","username='$user'",1);
    $exptime=$agent[0]['exptime'];
    if($exptime<$mytime)ero("�����˺��ѹ���",0);
    
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
<title>�����̵�½</title>
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
	
	//�����״̬
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
      <h1> <a href="http://www.2800.com.cn">28�ͷ��ٷ���վ</a> </h1>
    </div>
    <div style="padding-top: 10px; padding-right: 17px;"></div>
    <div style="padding-top: 20px; padding-right: 18px;font-size:14px;">ȫ��ͳһ�������ߣ�<font color=red><strong> 400-004-1991</strong></font></div>
  </div>
  <div id="navo">
    <div id="navi">
      <div id="menu">
        <ul id="nav">
          <li><a href="../index.php"><span>�� ҳ </span></a></li>
          <li class="menu_line"/>
          <li><a class="" href="../reg.php"><span>�������</span></a></li>
            <li class='menu_line'></li>
			          
          <li><a class="" href="../download.php"><span>�������</span></a></li>
            <li class='menu_line'></li>
          
          <li><a class="" href="../function.php"><span>���ܽ���</span></a></li>
            <li class='menu_line'></li>
          
          <li><a class="" href="../price.php"><span>�ʷ��ײ�</span></a></li>
            <li class='menu_line'></li>
          
          <li><a class="" href="index.php"><span>����ר��</span></a></li>
            <li class='menu_line'></li>
          
          <li><a class="" href="../news.php"><span>������Ѷ</span></a></li>
            <li class='menu_line'></li>
          
          <li><a class="" href="../help.php"><span>��������</span></a></li>
            <li class='menu_line'></li>
          
          <li><a class="" href="../about.php"><span>��������</span></a></li>
            <li class='menu_line'></li>           
          
          <li><a class="" href="../service.php"><span>�ͻ�����</span></a></li>
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
  <LI class=li_ud>�û�����<?=setinput("text","username","",16,20)?> 
  <LI class=li_ud>�ܡ��룺<?=setinput("password","password","",16,20)?> 
  <LI class=li_bt>
  <DIV class=btn1aq onMouseOver="this.className='btn2aq'" onmouseout="this.className='btn1aq'"><BUTTON class=btnaq name=submit type=submit  onFocus="this.blur()" value="�ǡ�¼">�ǡ�¼</BUTTON> </DIV>
  <DIV class=btn3aq onMouseOver="this.className='btn4aq'" onMouseOut="this.className='btn3aq'"><BUTTON class=btnaq name=reset type=reset value="ȡ����">ȡ����</BUTTON> </DIV>
  <LI class=li_line>
  <LI class=li_input><a onclick="javascript:getpassword('../member/getpassword.php','',400,300);" style="cursor:pointer"><font color="#FF0000">�һ����룿</font></a></LI></UL>            
  <input type="hidden" name="action" value="login">
  </form>

</DIV>
</DIV>
<DIV id=FuncDiv>
<DIV class=speed>
<UL>
  <LI class=icon><IMG height=47 src="../images/agentcp/icon1.gif" width=47 border=0>
  <LI class=tit><span class=green0 >��Ͷ��ͷ��� </span> 
  <LI class=cont><SPAN class=green00>������ӵ�о޴������ռ䣬���ǵĸ��ٷ�չ����֤�����и�������档</SPAN> </LI></UL></DIV>
<DIV class=safe>
<UL>
  <LI class=icon><IMG height=47 src="../images/agentcp/icon2.gif" width=47 border=0> 
  <LI class=tit><span class=green0 >���ڵ�����ر�</span> 
  <LI class=cont><SPAN class=green00>�ͻ��ʹ����̲�ȡ������ƣ��������������档ÿ��ɳ�����ȡ�����ѡ�</SPAN> </LI></UL></DIV>
<DIV class=attach>
<UL>
  <LI class=icon><IMG height=47 alt=����������ȫ֧�� 
  src="../images/agentcp/icon3.gif" width=47 border=0> 
  <LI class=tit><span class=green0 >����������ȫ֧��</span> 
  <LI class=cont><SPAN class=green00>����Ϊ�������ṩ��ȫ���ȶ�����Ч���һվʽת��֧��ƽ̨�������ݡ�</SPAN> </LI></UL></DIV>
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
          <h2>�������</h2>
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
      <div id="buttom_text">ȫ��ͳһ�������ߣ�<font color=red><strong>400-004-1991</strong></font>&nbsp;&nbsp;&nbsp;&nbsp;13077494808&nbsp;&nbsp;&nbsp;&nbsp;QQ��26897364</div>
      <div id="buttom_top"><a href="#top"><img src="../images/gto_top.gif" width="76" height="23" /></a></div>
      <div id="copyright" class="clear" style="padding-top: 5px;padding-left: 200px;">&copy; 2010  28�ͷ� Inc. All rights reserved Powered by <a href="http://www.2800.com.cn" target="_blank">2800.com.cn</a>&nbsp;&nbsp;&nbsp;&nbsp;
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
var url; //ת����ҳ�ĵ�ַ;
var name; //��ҳ���ƣ���Ϊ��;
var iWidth; //�������ڵĿ��;
var iHeight; //�������ڵĸ߶�;
var iTop = (window.screen.availHeight-30-iHeight)/2; //��ô��ڵĴ�ֱλ��;
var iLeft = (window.screen.availWidth-10-iWidth)/2; //��ô��ڵ�ˮƽλ��;
window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=no,menubar=no,scrollbars=auto,resizeable=no,location=no,status=no');
}
</script>

<script type="text/javascript">
function checkform(){
  if(myform.username.value==""){
    alert("�û�������Ϊ��");
    myform.username.focus()
    return false;
  }
  if(myform.password.value==""){
    alert("���벻��Ϊ��");
    myform.password.focus()
    return false;
  }
}
</script>
</body>
</html>