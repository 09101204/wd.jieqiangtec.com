<?include_once 'check.php';
$index=Char_Cv('index','get');
$menu=array();
$menu[0]='��վ����';
$menu[1]='����λ��';
$menu[2]='������Դ';
$menu[3]='�ؼ���';
$menu[4]='�ܷ�ҳ��';
if(!$index)$index=0;
?>
<html>
<title>�ͷ��������ͳ�Ƶ���</title>
<META http-equiv=Content-Type content=text/html; charset=gb2312>
<link rel="stylesheet" type="text/css" href="images/style.css">
<body leftmargin="0" topmargin="2" scroll="no" oncontextmenu=self.event.returnValue=false onselectstart="return false">
<!--<ul class="count_menu"><?foreach($menu as $k=>$v){
if($k==$index){?>
  <li><font color=red><?=$v?></font></li><?}else{?>
  <li><a href="?index=<?=$k?>"><?=$v?></a></li>
  <?}}?>
</ul>-->
����ͳ�ƹ������ڿ�����...
<?if($index==0){
$source1=urlencode('countxml.php?action=hour&cid='.$cid.'&t='.$time);
$source2=urlencode('countxml.php?action=date&cid='.$cid.'&t='.$time);
$source3=urlencode('countxml.php?action=month&cid='.$cid.'&t='.$time);
?>
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
 codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
 width="790" height="230" id="charts" align="">
 <param name=movie value="charts.swf?library_path=charts_library&xml_source=<?=$source1?>">
 <param name=quality value=high> <param name=bgcolor value=#ffffff> <embed src="charts.swf?library_path=charts_library&xml_source=<?=$source1?>" quality=high bgcolor=#ff8800  width="300" height="300" name="charts" align=""
 type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>
</object>
<br />
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
 codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
 width="790" height="230" id="charts" align="">
 <param name=movie value="charts.swf?library_path=charts_library&xml_source=<?=$source2?>">
 <param name=quality value=high> <param name=bgcolor value=#ffffff> <embed src="charts.swf?library_path=charts_library&xml_source=<?=$source2?>" quality=high bgcolor=#ff8800  width="300" height="300" name="charts" align=""
 type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>
</object>
<br />
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
 codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
 width="790" height="240" id="charts" align="">
 <param name=movie value="charts.swf?library_path=charts_library&xml_source=<?=$source3?>">
 <param name=quality value=high> <param name=bgcolor value=#ffffff> <embed src="charts.swf?library_path=charts_library&xml_source=<?=$source3?>" quality=high bgcolor=#ff8800  width="300" height="300" name="charts" align=""
 type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>
</object>
<?}?>
</body>
</html>