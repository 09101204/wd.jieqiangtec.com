<?php
if(!defined('IN_EQMK') || !defined('IN_MEMBER')) {
	exit('Access Denied');
}
include("header.php");
?>
<style type="text/css">
ul{padding:0;margin:0;list-style:none}
.onez_words{padding:0;text-align:left}
.onez_words .word li{width:500px;height:24px;line-height:24px;display:block;overflow:hidden;text-align:left}
.onez_words .word li.index a{background:url(../images/membercp/leftmenu_arrow.gif) no-repeat;padding-left:22px}
.onez_words .word li.sortopen a{width:500px;height:24px;line-height:24px;display:block;overflow:hidden;background:url(../images/membercp/leftmenu_open.gif) no-repeat;color:#003399;font-weight:bold;padding-left:22px;line-height:26px;}
.onez_words .word li.sortclose a{width:500px;height:24px;line-height:24px;display:block;overflow:hidden;background:url(../images/membercp/leftmenu_close.gif) no-repeat;color:#003399;font-weight:bold;padding-left:22px;line-height:26px;}
.onez_words .word li.child{background:url(../images/membercp/leftmenu_childarrow.gif) no-repeat;color:#0044dd;padding-left:40px;line-height:26px;}
.onez_words .word li.childlast{background:url(../images/membercp/leftmenu_childarrow_last.gif) no-repeat;color:#0044dd;padding-left:40px;line-height:26px;}
</style>
<script type="text/javascript">
function SetWords(wordid,num){
  if($('word_'+wordid).className=='sortopen'){
    $('word_'+wordid).className='sortclose';
    var theDisplay='none';
  }else{
    $('word_'+wordid).className='sortopen';
    var theDisplay='';
  }
  for(i=1;i<=num;i++){
    $('word_'+wordid+'_'+i).style.display=theDisplay;
  }
}
function del(id){
  if(confirm('您确定要删除这条记录吗？')){
    location.href='save.php?action=wordsdel&id='+id;
  }
}
</script>
<div class="onez_words">
<ul class="word"><?$i=0;
  foreach($Words as $K=>$V){
  $i++;$j=0;?>
  <li class="sortopen" id="word_<?=$i?>"><a href="javascript:SetWords(<?=$i?>,<?=count($V)?>);void(0)" onfocus="this.blur()"><?=$K?></a></li>
    <?foreach($V as $v){
    $j++;
    $class=$v==end($V)?'childlast':'child';
    $id=$v[0];
    ?>
    <li class="<?=$class?>" id="word_<?=$i?>_<?=$j?>"><?=$v[1]?>
    <a href="?action=wordsedit&id=<?=$id?>">编辑</a>
    <a href="#" onClick="del(<?=$id?>)">删除</a>
    </li>
  <?}?>
<?}?></ul>
</div>
<?if(!$Words){?>
<a href="?action=wordsadd"><h3 style="text-align:center;margin:40px;color:#ff0000">您尚未添加任何常用语，立即添加？</h3></a>
<?}?>
<?include("footer.php");?>