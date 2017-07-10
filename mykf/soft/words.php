<?
include_once("../include/common.inc.php");
$cid=Char_Cv('cid','get');
$wid=Char_Cv('wid','get');
if(!$cid || !$wid){
  header("location:../");
}
$Onez=$db->record("words","sort,words","companyid='$cid' and (workerid='$wid' or ntype=0) order by sort asc,words asc");
$Menu=array();
foreach($Onez as $rs){
  if(!is_array($Menu[$rs['sort']]))$Menu[$rs['sort']]=array();
  array_push($Menu[$rs['sort']],$rs['words']);
}
?>
<html>
<title>客服常用语</title>
<META http-equiv=Content-Type content=text/html; charset=gb2312>
<link rel="stylesheet" type="text/css" href="images/style.css">
<style type="text/css">
td{height:30px}
</style>
<body leftmargin="0" topmargin="2" scroll="no" oncontextmenu=self.event.returnValue=false onload="myform.nickname.focus()">
<script type="text/javascript" src="../include/javascript/common.js"></script>
<script type="text/javascript">
function SetMenu(menuid,num){
  if($('menu_'+menuid).className=='sortopen'){
    $('menu_'+menuid).className='sortclose';
    var theDisplay='none';
  }else{
    $('menu_'+menuid).className='sortopen';
    var theDisplay='';
  }
  for(i=1;i<=num;i++){
    $('menu_'+menuid+'_'+i).style.display=theDisplay;
  }
}
function SetWord(){
  window.location.href='eqmk://setwords';
}
function SelWord(w){
  window.location.href='eqmk://selwords.'+w;
}
</script>
<div class="onez_words">
<ul class="menu">
  <li class="index"><a href="?cid=<?=$cid?>&wid=<?=$wid?>">更新常用语列表</a></li><?$i=0;
  foreach($Menu as $K=>$V){
  $i++;$j=0;?>
  <li class="sortopen" id="menu_<?=$i?>"><a href="#" onclick="SetMenu(<?=$i?>,<?=count($V)?>);void(0)"><?=$K?></a></li>
    <?foreach($V as $v){
    $j++;
    $class=$v==end($V)?'childlast':'child';
    ?>
    <li class="<?=$class?>" id="menu_<?=$i?>_<?=$j?>"><a href="#" onclick="SelWord('<?=urlencode($v)?>')"><?=$v?></a></li>
  <?}?>
<?}?></ul>
</div>
</body>
</html>