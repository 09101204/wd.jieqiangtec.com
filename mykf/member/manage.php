<?php
include("check.php");
$action=Char_Cv('action','get');
$token=$action?$action:'main';
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>">
<title>28���߿ͷ�ϵͳ - �ͷ�����</title>
<script language="JavaScript">
window.self.focus();
</script>
</head>
<frameset cols="150,*" framespacing="0" border="0" frameborder="0">
  <frame name="menu" src="member.php?action=menu" scrolling="auto">
  <frame name="main" src="member.php?action=<?=$token?>" scrolling="auto">
  <noframes>
    <body topmargin="0" leftmargin="0">
    <p>����ҳʹ���˿�ܣ��������������֧�ֿ��</p>
    </body>
  </noframes>
</frameset>
</html>