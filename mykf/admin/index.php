<?php
include_once("../include/common.inc.php");
if(Char_Cv("action")=="login"){
  $user=Char_Cv("username");
  $pass=md5(Char_Cv("password"));
  if($db->rows("admin","username='$user' and password='$pass'")==0){
    ero("�û��������벻��ȷ",1);
  }else{
    $tmpdataarr=array('dialog','client','messageA','messageB','video');
    foreach($tmpdataarr as $v){
      cleartmpdata('../eqmkdata/application/'.$v);
    }
	
    $address=getaddress($onlineip,true);
    $db->query("update {$tbl}admin set lasttime=thistime,lastip=thisip,lastaddress=thisaddress,thistime=now(),thisip='$onlineip',thisaddress='".$address."',logincount=logincount+1 where username='$user'");
    $_SESSION["eqmk_administrator_username"]=$user;
    header("location:manage.php");
    exit;
  }
}
$title=$language["login"];
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����Ա��½</title>
<link href="../images/admincp/login.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="table">
  <form action="index.php" method="post" name="myform" onsubmit="return checkform()">
  <div class="form">
    <div class="name">�û���</div>
    <div class="value"><?=setinput("text","username","",16,20)?></div>
    <div class="clear"></div>
    <div class="name">�ܡ���</div>
    <div class="value"><?=setinput("password","password","",16,20)?></div>
    <div class="clear"></div>
    <div class="buttonbg">
      <input type="submit" name="submit" class="button" value="��½">
      <input type="reset" name="reset" class="button" value="ȡ��">
    </div>
  </div>
  <input type="hidden" name="action" value="login">
  </form>
</div>
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