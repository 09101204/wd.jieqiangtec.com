<?
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ob_start();
header('Content-Disposition: inline; filename=Í·Ïñ');
header('Content-Type: image/pjpeg');
$id=$_GET['id'];
if(file_exists('../images/face/'.$id.'.gif')){
  $tmpname='../images/face/'.$id.'.gif';
}elseif(file_exists('../images/face/'.$id.'.jpg')){
  $tmpname='../images/face/'.$id.'.jpg';
}else{
  $tmpname='../images/rose.gif';
}
$filesize=filesize($tmpname);
@$fp = fopen($tmpname, 'rb');
@flock($fp, 2);
$attachment = @fread($fp, $filesize);
@fclose($fp);
echo $attachment;
?>