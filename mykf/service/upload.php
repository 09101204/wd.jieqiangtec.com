<?php
include_once 'check.php';
$tmpname=$_FILES['myFile']['tmp_name'];
$filetype=$_FILES['myFile']['type'];
$filename=$_FILES['myFile']['name'];
if(!$wid){
  exit('error');
}
if(!$tmpname){
  print('<script type="text/javascript">parent.PrintChat("'.$language['100'].'","im_info");parent.myfile.reset();</script>');
}
$filetype=strtolower(end(explode('.',$filename)));
$allowfiletype=explode('|',strtolower($allowfiletype));
if(!in_array($filetype,$allowfiletype)){
  print('<script type="text/javascript">parent.PrintChat("'.$language['101'].'","im_info");parent.myfile.reset();</script>');
  exit();
}
if(filesize($tmpname)>$maxfilesize*1024*1024){
  print('<script type="text/javascript">parent.PrintChat("'.$language['102'].$maxfilesize.'MB'.$language['103'].'","im_info");parent.myfile.reset();</script>');
  exit();
}
$f=md5($uid.'_'.date('YmdHis',$time).'_'.$filename);
if(copy($tmpname,"../uploadfile/".$f.".eqmk")){
  $fdata=''.$language['104'].''.$filename.''.$language['105'].',[url='.$homepage.'attachment.php?f='.$f.'&r='.$filename.']'.$language['106'].'[/url]';
  print('<script type="text/javascript">parent.inputbox.value+="'.str_replace('"','\"',$fdata).'";parent.PrintChat("'.$language['104'].$filename.''.$language['107'].'","im_info");parent.myfile.reset();</script>');
  exit();
}
?>