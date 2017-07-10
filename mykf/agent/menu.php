<?php
if(!defined('IN_EQMK') || !defined('IN_AGENT')) {
	exit('Access Denied');
}
?><html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=gb2312">
<title><?=$language["workermenu"]?></title>
<script type="text/javascript" src="../include/javascript/common.js"></script>
<script type="text/javascript">
function menu_tree(meval){
  if($(meval).style.display=="none"){
    $(meval).style.display='';
  }else{
    $(meval).style.display='none';
  }
}
</script>
<link type="text/css" href='../template/admin/<?=$adminstyle?>/style.css' rel=stylesheet>
<base target=main>
</head>
<body style="overflow-x:hidden" class="menubody" topmargin="0">
<center>
  <table cellspacing=0>
  <tr><td align=center height="40"><?=$logo?></td></tr>
  </table>
<?for($i=0;$i<count($Menu);$i++){?>  <table cellspacing="0" class="Menu">
  <tr><th align=center onclick="menu_tree('left_<?=$i?>');" >≡ <?=$Menu[$i][0]?> ≡</th></tr>
  <tr style="display:<?=$display?>" id='left_<?=$i?>'><td >
    <table width='100%'>
    <?if(is_array($Menu[$i][1])){
    foreach($Menu[$i][1] as $k=>$v){
    $s=$k=="logout" ? " onClick=\"return confirm('您确定要退出登陆吗？')\" target='_parent'" : "";
    $url=$k=="logout" ? "logout.php":"agent.php?action=$k";
    ?>    <tr><td><?=$ico?>&nbsp;<a<?=$s?> href='<?=$url?>'><?=$v?></a></td></tr>
    <?}}?>    </table>
  </td></tr>
  </table>
<?}?><?$i++;?></center>
</body>
</html>