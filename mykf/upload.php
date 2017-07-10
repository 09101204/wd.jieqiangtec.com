<?php
include_once("include/common.inc.php");
$cid=Char_Cv('cid','get');
$wid=Char_Cv('wid','get');
$uid=Char_Cv('uid','get');
$tmpname=$_FILES['myFile']['tmp_name'];
$filetype=$_FILES['myFile']['type'];
$filename=$_FILES['myFile']['name'];
if(!$wid || !$uid){
  exit('error');
}
if(!$tmpname){
  exit('none');
}
$filetype=strtolower(end(explode('.',$filename)));
$allowfiletype=explode('|',strtolower($allowfiletype));
if(!in_array($filetype,$allowfiletype)){
  print('<script type="text/javascript">top.PrintChat("<div class=\"im_info\">您选择了不允许的文件格式！</div>\r\n");top.myfile.reset();</script>');
  exit();
}
if(filesize($tmpname)>$maxfilesize*1024*1024){
  print('<script type="text/javascript">top.PrintChat("<div class=\"im_info\">单个文件不能超过'.$maxfilesize.'MB！</div>\r\n");top.myfile.reset();</script>');
  exit();
}
$f=md5($uid.'_'.date('YmdHis',$time).'_'.$filename);
if(copy($tmpname,"uploadfile/".$f.".eqmk")){
  $fdata='我给您发送了文件“'.$filename.'”,<a href="'.$homepage.'attachment.php?f='.$f.'&r='.$filename.'" target="_blank">点击这里接收</a>';
  $fdata=addslashes($fdata);
  $db->insert("message","companyid,workerid,clientid,action,content,addtime","$cid|$wid|$uid|2|$fdata|$now");
  print('<script type="text/javascript">top.PrintChat("<div class=\"im_info\">文件“'.$filename.'”已发送成功！</div>\r\n");top.myfile.reset();</script>');
  exit();
}
?>