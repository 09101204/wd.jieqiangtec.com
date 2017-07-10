<?php
include_once("include/common.inc.php");
$filename=Char_Cv('f',"get");
$filetitle=Char_Cv('r',"get");
$filename=str_replace('../','',$filename);
if(!$filetitle)$filetitle=$filename;
$tmpname="uploadfile/".$filename.".eqmk";
$filetype=filetype($tmpname);
$filesize = filesize($tmpname);
ob_end_clean();
$ftype=strtolower(end(explode('.',$filetitle)));
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