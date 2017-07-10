<?php
include_once("../include/common.inc.php");
include_once('../eqmkdata/sort.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>输入表情管理</title>
<meta name="keywords" content="<?=$keywords?>">
<meta name="description" content="<?=$description?>">
<link href="images/smiley.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function stopError() {
  return true;
}
//window.onerror = stopError;
var cursmiley=0;
var smileys=new Array();<?for($i=0;$i<count($smileys);$i++){?>

smileys[<?=$i?>]=new Array("<?=$smileys[$i][0]?>","<?=$smileys[$i][1]?>",<?=$smileys[$i][2]?>,<?=$smileys[$i][3]?>);<?}?>

function $(id) {
	return document.getElementById?document.getElementById(id):document.all?d.all[id]:document.layers[id];
}
function window_onload(){
  var tmp='<ul>';
  for(var i=0;i<smileys.length;i++){
    tmp+='<li id="t_'+i+'" onclick="sel_smiley_g('+i+')">'+smileys[i][0]+'</li>';
  }
  tmp+='</ul>';
  $('s_title').innerHTML=tmp;
  sel_smiley_g(cursmiley);
}
function sel_smiley_g(index){
  if(index==-1){
    index=cursmiley;
  }
  for(var i=0;i<smileys.length;i++){
    if(i==index){
      $('t_'+i).className='sel';
      var tmp='<ul>';
      for(var k=smileys[i][2];k<=smileys[i][3];k++){
        tmp+='<li><img src="../images/smiley/'+smileys[i][1]+'/s_'+smileys[i][1]+'_'+k+'.gif" onclick="sel_smiley('+k+')" /></li>';
      }
      tmp+='</ul>';
      $('s_content').innerHTML=tmp;
      cursmiley=index;
    }else{
      $('t_'+i).className='';
    }
  }
  location.href="eqmk://resize."+$('smiley').offsetWidth+"."+$('smiley').offsetHeight;
}
function sel_smiley(index){
  location.href='eqmk://insert.:'+smileys[cursmiley][1]+'_'+index;
}
function KeyDown(){
	if (window.event.keyCode == 116){	
		event.keyCode = 0;
		event.returnValue = false;
	}
}
document.onkeydown = KeyDown;
</script>
</head>
<body onload="window_onload()" scroll="no" oncontextmenu=self.event.returnValue=false onselectstart="return false">
<div id="smiley" class="smiley">
  <div class="title" id="s_title"></div>
  <div class="content" id="s_content"></div>
</div>
</body>
</html>