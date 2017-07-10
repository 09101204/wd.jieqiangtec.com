<?php
include("check.php");
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>">
<title><?=$company?> - 超级管理系统</title>
<script language="JavaScript">
window.self.focus();
</script>
</head>
<frameset cols="150,*" framespacing="0" border="0" frameborder="0">
  <frame name="menu" src="admin.php?action=menu" noresize scrolling="auto">
  <frame name="main" src="admin.php?action=main" scrolling="auto">
  <noframes>
    <body topmargin="0" leftmargin="0">
    <p>此网页使用了框架，但您的浏览器不支持框架</p>
    </body>
  </noframes>
</frameset>
</html>
