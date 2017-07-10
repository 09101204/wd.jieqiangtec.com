<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ob_start();
function Char_Cv($msg,$method="post",$type=""){
	global $_GET,$_POST;
	$msg = strtolower($method)=="get" ? $_GET[$msg] : $_POST[$msg];
  if($type=="num"){
    if(!is_numeric($msg))$msg=0;
    return $msg;
  }
  $msg = str_replace('|','£ü',$msg);
  $msg = str_replace('&amp;','&',$msg);
  $msg = str_replace('&nbsp;',' ',$msg);
  $msg = str_replace('"','&quot;',$msg);
  $msg = str_replace("'",'&#39;',$msg);
  $msg = str_replace("<","&lt;",$msg);
  $msg = str_replace(">","&gt;",$msg);
  $msg = str_replace("\t","   &nbsp;  &nbsp;",$msg);
  $msg = str_replace("\r","",$msg);
  $msg = str_replace("   "," &nbsp; ",$msg);
	return $msg;
}

$filename=Char_Cv('f',"get");
$filetitle=Char_Cv('r',"get");
$filename=str_replace('../','',$filename);
if(!$filetitle)$filetitle=$filename;
$ftype=strtolower(end(explode('.',$filetitle)));
//$tmpname=($ftype=='gif' || $ftype=='jpg' || $ftype=='bmp')?$filename:$filename.".eqmk";
$tmpname=$filename.".eqmk";
$filetype=filetype($tmpname);
$filesize = filesize($tmpname);
ob_end_clean();
if($ftype=='gif' || $ftype=='jpg' || $ftype=='bmp'){
	header('Content-Disposition: inline; filename='.$filetitle);
	header('Content-Type: image/pjpeg');
}else{
  header('Cache-control: max-age=31536000');
  header('Content-Encoding: none');
  header('Content-Disposition: attachment; filename='.$filetitle);
  header('Content-Type: '.$filetype);
}
@$fp = fopen($tmpname, 'rb');
@flock($fp, 2);
$attachment = @fread($fp, $filesize);
@fclose($fp);
echo $attachment;
?>