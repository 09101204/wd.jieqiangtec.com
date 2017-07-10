<?
$IsFirst=$_GET["IsFirst"];
$FileTitle=$_GET["FileTitle"];
$pathtype=$_GET["pathtype"];
$day=$_GET["day"];
function readover($filename,$method="rb"){
	if($handle=@fopen($filename,$method)){
		flock($handle,LOCK_SH);
		$filedata=fread($handle,filesize($filename));
		fclose($handle);
	}
	return $filedata;
}
function writeover($filename,$data,$method="rb+",$iflock=1){
	touch($filename);
	$handle=fopen($filename,$method);
	if($iflock){
		flock($handle,LOCK_EX);
	}
	fwrite($handle,$data);
	if($method=="rb+") ftruncate($handle,strlen($data));
	fclose($handle);
}
function mkdirs($dir){
  if(!is_dir($dir)){
    mkdirs(dirname($dir));
    mkdir($dir,0777);
  }
  return ;
}
function GetFileData(){
  global $HTTP_RAW_POST_DATA,$filename;
  $tmp=readover($filename);
  $tmp.=base64_decode(current(explode("</file></root>",end(explode('<file dt:dt="bin.base64">',$HTTP_RAW_POST_DATA)))));
  writeover($filename,$tmp);
}

//writeover("test.txt","$IsFirst\n$FileTitle\n$pathtype");//µ÷ÊÔÐÅÏ¢
if(!$FileTitle)exit("Error");
$filetype=end(explode(".",$FileTitle));
if($pathtype=='EqmkFace'){
  $filepath='../images/face';
  if($IsFirst=='1'){
    $id=current(explode('.',$FileTitle));
    @unlink($filepath.'/'.$id.'.gif');
    @unlink($filepath.'/'.$id.'.jpg');
  }
}elseif($pathtype=='EqmkCatch'){
  $filepath='catch/'.$day;
}elseif($pathtype=='EqmkCatch2'){
  $filepath='catch2/'.$day;
}elseif($pathtype=='EqmkPic'){
  $filepath='file/'.$day;
}elseif($pathtype=='EqmkWrite'){
  $filepath='write/'.$day;
}

if(!is_dir($filepath))mkdirs($filepath);
$filename=$filepath.'/'.$FileTitle.($pathtype=='EqmkCatch'||$pathtype=='EqmkCatch2'||$pathtype=='EqmkWrite'?'':'.eqmk');
GetFileData();
if($pathtype=='EqmkCatch2'){
  @include_once('../config.inc.php');
  $cid=$_GET["cid"];
  $wid=$_GET["wid"];
  $uid=$_GET["uid"];
  mkdirs('../eqmkdata/application/messageA');
  mkdirs('../eqmkdata/application/messageB');
  $time=time()+$timezone*60*60;
  $now=date("Y-m-d H:i:s",$time);
  $fdata="<img src=\"{$homepage}attachment/$filename\" border=\"0\">";
  writeover('../eqmkdata/application/messageA/'.$wid.'.eqmk',"2\t$uid\t$fdata\t$now\n",'a+');
  writeover('../eqmkdata/application/messageB/'.$uid.'.eqmk',"0\t$fdata\n",'a+');
  writeover('test.txt',"0\t$fdata\n");
}
?>