<?php
if(!function_exists('iconv')){
  function iconv($a,$b,$string){
    return mb_convert_encoding($string,$b,$a);
  }
}
function EqmkVars($msg){
  global $onlineip,$company,$homepage,$nickname;
  if(strpos('EQMK'.$msg,'#company#'))$msg=str_replace('#company#',$company,$msg);
  if(strpos('EQMK'.$msg,'#homepage#'))$msg=str_replace('#homepage#',$homepage,$msg);
  if(strpos('EQMK'.$msg,'#workername#'))$msg=str_replace('#workername#',$nickname,$msg);
  if(strpos('EQMK'.$msg,'#ip#'))$msg=str_replace('#ip#',$onlineip,$msg);
  if(strpos('EQMK'.$msg,'#address#'))$msg=str_replace('#address#',getaddress($onlineip),$msg);
  if(strpos('EQMK'.$msg,'#br#'))$msg=str_replace('#br#','<br />',$msg);
  if(strpos($msg,'#font#'))$msg=str_replace('#font#','<font color=red>',$msg);
  if(strpos($msg,'#/font#'))$msg=str_replace('#/font#','</font>',$msg);
  return $msg;
}
function ClientNickName($rs){
  global $clientnickname;
  if(!$clientnickname)$clientnickname="[address]访客";
  if(!$rs['uid']){
    global $uid;
    $rs['uid']=$uid;
  }
  return preg_replace("/\[([a-z0-9]+)\]/ie","\$rs[$1]",$clientnickname);
}
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
function dir_empty($dir){
  if($dp = @dir($dir)){
    while($file = $dp->read()){
      if($file != '.' && $file != '..'){
        return false;
      }
    }
    $dp->close();
    return true;
  }else{
    return true;
  }
}
function cleartmpdata($tplpath,$showlog=''){
  global $Log;
  if(is_dir($tplpath)){
    $dh=opendir($tplpath);
    while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
        if(is_dir($tplpath.'/'.$file)) {
          cleartmpdata($tplpath.'/'.$file,$showlog);
        }else{
          if(filemtime($tplpath.'/'.$file)<time()-1800){
            @unlink($tplpath.'/'.$file);
            if($showlog)$Log[]=$tplpath.'/'.$file;
          }
        }
      }
    }
    closedir($dh);
    if(dir_empty($tplpath)){
      rmdir($tplpath);
      if($showlog)$Log[]=$tplpath;
    }
  }
}
function dsetcookie($var, $value, $life = 0, $prefix = 1) {
	global $time, $_SERVER;
	$cookiepre='eqmk_com_';
	$cookiedomain='';
	$cookiepath='/';
	setcookie(($prefix ? $cookiepre : '').$var, $value,
		$life ? $time + $life : 0, $cookiepath,
		$cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}
function myutf8($string) {
	global $_GET;
	if(strtolower($_GET['charset'])!='utf-8'){
    return $string;
	}
  return preg_match('%^(?:
[\x09\x0A\x0D\x20-\x7E] # ASCII
| [\xC2-\xDF][\x80-\xBF] # non-overlong 2-byte
| \xE0[\xA0-\xBF][\x80-\xBF] # excluding overlongs
| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
| \xED[\x80-\x9F][\x80-\xBF] # excluding surrogates
| \xF0[\x90-\xBF][\x80-\xBF]{2} # planes 1-3
| [\xF1-\xF3][\x80-\xBF]{3} # planes 4-15
| \xF4[\x80-\x8F][\x80-\xBF]{2} # plane 16
)*$%xs', $string)?$string:iconv('gbk','utf-8',$string);
}
function utf82gbk($string) {
return preg_match('%^(?:
[\x09\x0A\x0D\x20-\x7E] # ASCII
| [\xC2-\xDF][\x80-\xBF] # non-overlong 2-byte
| \xE0[\xA0-\xBF][\x80-\xBF] # excluding overlongs
| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
| \xED[\x80-\x9F][\x80-\xBF] # excluding surrogates
| \xF0[\x90-\xBF][\x80-\xBF]{2} # planes 1-3
| [\xF1-\xF3][\x80-\xBF]{3} # planes 4-15
| \xF4[\x80-\x8F][\x80-\xBF]{2} # plane 16
)*$%xs', $string)?iconv('utf-8','gbk',$string):$string;
}
function template($file) {
	global $tplrefresh,$tpldir,$lang_web;

	$tpldir = $tpldir ? $tpldir : "default";

	$tplfile = EQMK_ROOT.'./template/web/'.$tpldir.'/'.$file.'.htm';
	$objfile = EQMK_ROOT.'./eqmkdata/template/'.$file.'.'.$lang_web.'.tpl.php';
  if(@filemtime($tplfile) > @filemtime($objfile)) {
    require_once EQMK_ROOT.'./include/template.func.php';
    parse_template($file, $tpldir);
  }
	return $objfile;
}
function ero($msg1,$msg2="1"){
  if ($msg2=="0"){
    echo "<script language=\"javascript\">alert('".$msg1."');window.close();</script>";
    exit;
  }elseif($msg2=="1"){
    echo "<script language=\"javascript\">alert('".$msg1."');history.go(-1);</script>";
    exit;
  }elseif($msg2=="2"){
    echo "<script language=\"javascript\">alert('".$msg1."');</script>";
  }elseif ($msg2=="3"){
    echo "<script language=\"javascript\">location.href='".$msg1."';</script>";
    exit;
  }else{
    echo "<script language=\"javascript\">alert('".$msg1."');location.href='".$msg2."';</script>";
    exit;
  } 
}

function formatdata($str){
  $str=str_replace("<E>","《E》",$str);
  $str=str_replace("|","｜",$str);
  $str=str_replace(",","，",$str);
  return $str;
}
function WriteLog($cid,$ti,$co,$utype=0){
  global $db,$tbl,$onlineip,$time;
  $xxx=$utype==0 ? 'companyid' : 'agent';
  return $db->insert("log","$xxx,title,content,addtime,ip","$cid|$ti|$co|$time|$onlineip");
}
function WriteMoneyLog($cid,$money,$co,$utype=0){
  global $db,$tbl,$onlineip,$time;
  $xxx=$utype==0 ? 'companyid' : 'agent';
  return $db->insert("money","$xxx,money,content,addtime,ip","$cid|$money|$co|$time|$onlineip");
}

function CheckGrade($g){
  global $Grade;
  return @in_array($g,$Grade) ? true : false;
}

function Char_Cv($msg,$method="post",$type=""){
	global $_GET,$_POST;
	$msg = strtolower($method)=="get" ? $_GET[$msg] : $_POST[$msg];
  if($type=="num"){
    if(!is_numeric($msg))$msg=0;
    return $msg;
  }
  $msg = str_replace('|','｜',$msg);
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

function getid($id,$len=3,$head=""){
  for($i=0;$i<($len-strlen($id));$i++){
    $id_.="0";
  }
  return $head.$id_.$id;
}

function GetTime($time){
  switch(true){
    case !strpos($time," "):
      $str=preg_replace("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/e","'0,0,0,'.round('$2').','.round('$3').',$1'",$time);
      break;
    default:
      $str=preg_replace("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})\s+([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/e","round('$4').','.round('$5').','.round('$6').','.round('$2').','.round('$3').',$1'",$time);
      break;
  }
  eval("\$str=mktime($str);");
  return $str;
}
function random(){
	return md5(date("YmdHis").((double)microtime()*1000000).rand(10000000, 99999999));
}
function SelAgent($addr){
  include_once(EQMK_ROOT."eqmkdata/citylist.inc.php");
  $P='';$C='';
  foreach($province as $p){
    if(substr($addr,0,strlen($p))==$p){
      $P=$p;
      foreach($city as $c){
        if($c[0]==$p && strpos($addr,$c[1])){
          $C=$c[1];
          break;
        }
      }
      break;
    }
  }
  return array($P,$C);
}
function getaddress($ip,$area=true){
  include_once(EQMK_ROOT."include/ip.class.php");
  $p=new IpLocation();
  $l=$p->getlocation($ip);
  //print_r($l);
  $address=$l['country'];
  if($area)$address.=$l['area'];
  return $address;
}

function escape($str) {
	preg_match_all("/[\x80-\xff].|[\x01-\x7f]+/",$str,$r);
	$ar = $r[0];
	foreach($ar as $k=>$v) {
		if(ord($v[0]) < 128)
		$ar[$k] = rawurlencode($v);
		else
		$ar[$k] = "%u".bin2hex(iconv("GB2312","UCS-2",$v));
	}
	return join("",$ar);
}
function unescape($str) {
  $str = rawurldecode($str);
  preg_match_all("/%u.{4}|&#x.{4};|&#d+;|.+/U",$str,$r);
  $ar = $r[0];
  foreach($ar as $k=>$v) {
    if(substr($v,0,2) == "%u")
      $ar[$k] = iconv("UCS-2","GBK",pack("H4",substr($v,-4)));
    elseif(substr($v,0,3) == "&#x")
      $ar[$k] = iconv("UCS-2","GBK",pack("H4",substr($v,3,-1)));
    elseif(substr($v,0,2) == "&#") {
      $ar[$k] = iconv("UCS-2","GBK",pack("n",substr($v,2,-1)));
    }
  }
  return join("",$ar);
}
function CkPost(){
  $server_v1=$_SERVER['HTTP_REFERER'];
  $server_v2=$_SERVER["SERVER_NAME"];
  if(strtolower(substr($server_v1,7,strlen($server_v1)))!=strtolower(server_v2))die("请不要从其他页面提交数据");
}

function GetmTime($filename){
  return date("Y-m-d H:i:s",@filemtime($filename));
}

function daddslashes($string, $force = 0) {
	if(!$GLOBALS['magic_quotes_gpc'] || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force);
			}
		} else {
			$string = addslashes($string);
		}
	}
	return $string;
}


function SetInput($In_type,$In_name,$In_value,$In_other='',$In_size='',$In_maxlen=''){
  switch(true){
    case ($In_type=='text'||$In_type=='password'||$In_type=='file'):
      return "<input type=\"$In_type\" id=\"$In_name\" name=\"$In_name\" value=\"$In_value\" size=\"$In_size\" maxlength=\"$In_maxlen\" onblur=\"this.style.borderColor='#7F9DB9';\" onmouseover=\"this.style.borderColor='#7DAF02'\" onfocus=\"this.style.borderColor='#7DAF02'\" onmouseout=\"this.style.borderColor='#7F9DB9'\"  style=\"BORDER-RIGHT: #7f9db9 1px solid; BORDER-TOP: #7f9db9 1px solid; BORDER-LEFT: #7f9db9 1px solid; BORDER-BOTTOM: #7f9db9 1px solid; HEIGHT: 18px\" $In_other>";
      break;
    case ($In_type=='button'||$In_type=='submit'||$In_type=='reset'):
      return "<input type=\"$In_type\" class=\"bn1\" id=\"$In_name\" name=\"$In_name\" value=\"$In_value\" $In_other>";
      break;
    case ($In_type=='radio'||$In_type=='checkbox'):
      return "<input type=\"$In_type\" style=\"border:0\" id=\"$In_name\" name=\"$In_name\" value=\"$In_value\" $In_other>";
      break;
    case $In_type=='hidden':
      return "<input type=\"$In_type\" id=\"$In_name\" name=\"$In_name\" value=\"$In_value\">";
      break;
    case $In_type=='textarea':
      return "<textarea id=\"$In_name\" name=\"$In_name\" wrap=\"virtual\" cols=\"$In_size\" rows=\"$In_maxlen\" $In_other>$In_value</textarea>";
      break;
  }
}
function SetEditor($E_id,$E_content='',$style='',$width='100%',$height=400){
  global $editorstyle;
  $editorstyle=$style ? $style : $editorstyle;
  $str="<textarea name=\"content$E_id\" style=\"display:none\">$E_content</textarea><IFRAME ID=\"eWebEditor$E_id\" src=\"../editor/ewebeditor.htm?id=content$E_id&style=$editorstyle\" frameborder=\"0\" scrolling=\"no\" width=\"$width\" height=\"$height\"></IFRAME>";
  if($E_content){
    $str .= "<script language=\"javascript\">window.onload=function(){eWebEditor$E_id.setHTML(myform.content$E_id.value)}</script>";
  }
  return $str;
}
function SetEditor2($E_id,$E_content='',$style='',$width='100%',$height=200){
  global $editorstyle;
  $editorstyle=$style ? $style : $editorstyle;
  $str="<textarea name=\"companyinfo$E_id\" style=\"display:none\">$E_content</textarea><IFRAME ID=\"eWebEditor$E_id\" src=\"../editor/ewebeditor.htm?id=companyinfo$E_id&style=$editorstyle\" frameborder=\"0\" scrolling=\"no\" width=\"$width\" height=\"$height\"></IFRAME>";
  if($E_content){
    $str .= "<script language=\"javascript\">window.onload=function(){eWebEditor$E_id.setHTML(myform.companyinfo$E_id.value)}</script>";
  }
  return $str;
}
function delhtml($document){
  $search = array ("'<script[^>]*?>.*?</script>'si",  // 去掉 javascript
                   "'<[\/\!]*?[^<>]*?>'si",           // 去掉 HTML 标记
                   "'([\r\n])[\s]+'",                 // 去掉空白字符
                   "'&(quot|#34);'i",                 // 替换 HTML 实体
                   "'&(amp|#38);'i",
                   "'&(lt|#60);'i",
                   "'&(gt|#62);'i",
                   "'&(nbsp|#160);'i",
                   "'&(iexcl|#161);'i",
                   "'&(cent|#162);'i",
                   "'&(pound|#163);'i",
                   "'&(copy|#169);'i",
                   "'&#(\d+);'e");                    // 作为 PHP 代码运行
  $replace = array ("",
                    "",
                    "\\1",
                    "\"",
                    "&",
                    "<",
                    ">",
                    " ",
                    chr(161),
                    chr(162),
                    chr(163),
                    chr(169),
                    "chr(\\1)");
  return preg_replace ($search, $replace, $document);
}

function cuturl($url) {
	$length = 65;
	$urllink = "<a href=\"".(substr(strtolower($url), 0, 4) == 'www.' ? "http://$url" : $url).'" target="_blank">';
	if(strlen($url) > $length) {
		$url = substr($url, 0, intval($length * 0.5)).' ... '.substr($url, - intval($length * 0.3));
	}
	$urllink .= $url.'</a>';
	return $urllink;
}
function eqmkcode($document){
  global $company;
  $search = array (
    "/\[url\]\s*(www.|https?:\/\/|ftp:\/\/|gopher:\/\/|news:\/\/|telnet:\/\/|rtsp:\/\/|mms:\/\/|callto:\/\/|ed2k:\/\/){1}([^\[\"']+?)\s*\[\/url\]/ie",
				"/\[img\](.+?)\[\/img\]/is",
				"/\[url=www.([^\[\"']+?)\](.+?)\[\/url\]/is",
				"/\[url=(https?|ftp|gopher|news|telnet|rtsp|mms|callto|ed2k){1}:\/\/([^\[\"']+?)\](.+?)\[\/url\]/is",
				"/\[qq\]([0-9]{5,10})\[\/qq\]/is",
				"/\[email\]\s*([a-z0-9\-_.+]+)@([a-z0-9\-_]+[.][a-z0-9\-_.]+)\s*\[\/email\]/i",
				"/\[email=([a-z0-9\-_.+]+)@([a-z0-9\-_]+[.][a-z0-9\-_.]+)\](.+?)\[\/email\]/is",
				"/\[color=([^\[\<]+?)\]/i",
				"/\[size=(\d+?)\]/i",
				"/\[size=(\d+(px|pt|in|cm|mm|pc|em|ex|%)+?)\]/i",
				"/\[font=([^\[\<]+?)\]/i",
				"/\[align=([^\[\<]+?)\]/i"
				);
  $replace = array (
				"cuturl('\\1\\2')",
				"<img src=\"\\1\" border=\"0\" onload=\"if(this.width>400){this.width=400};if(this.height>400){this.height=400}\">",
				"<a href=\"http://www.\\1\" target=\"_blank\">\\2</a>",
				"<a href=\"\\1://\\2\" target=\"_blank\">\\3</a>",
				"<a href=\"http://wpa.qq.com/msgrd?V=1&amp;Uin=\\1&amp;Site=$company&amp;Menu=yes\" target=\"_blank\"><img src=\"http://wpa.qq.com/pa?p=1:\\1:4\" border=\"0\" alt=\"QQ\" /></a>",
				"<a href=\"mailto:\\1@\\2\">\\1@\\2</a>",
				"<a href=\"mailto:\\1@\\2\">\\3</a>",
				"<font color=\"\\1\">",
				"<font size=\"\\1\">",
				"<font style=\"font-size: \\1\">",
				"<font face=\"\\1\">",
				"<p align=\"\\1\">"
        );
  $document = preg_replace ($search, $replace, $document);
  
  
  $search = array(
				'[/color]', '[/size]', '[/font]', '[/align]', '[b]', '[/b]',
				'[i]', '[/i]', '[u]', '[/u]', '[list]', '[list=1]', '[list=a]',
				'[list=A]', '[*]', '[/list]', '[indent]', '[/indent]',"\t", '   ', '  '
			);
  $replace =array(
				'</font>', '</font>', '</font>', '</p>', '<b>', '</b>', '<i>',
				'</i>', '<u>', '</u>', '<ul>', '<ol type=1>', '<ol type=a>',
				'<ol type=A>', '<li>', '</ul></ol>', '<blockquote>', '</blockquote>','&nbsp; &nbsp; &nbsp; &nbsp; ', '&nbsp; &nbsp;', '&nbsp;&nbsp;'
			);
  $document = str_replace ($search, $replace, $document);
  $document = str_replace ("\n", "<br>", $document);
  $document = str_replace ("\r\n", "<br>", $document);
  $document = str_replace ("\r", "<br>", $document);
  return $document;
}

/*
Utf-8、gb2312都支持的汉字截取函数
cut_str(字符串, 截取长度, 开始长度, 编码);
编码默认为 utf-8
开始长度默认为 0
*/
function cut_str($string, $sublen, $code = 'UTF-8', $start = 0)
{
    if($code == 'UTF-8')
    {
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa, $string, $t_string);

        if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."...";
        return join('', array_slice($t_string[0], $start, $sublen));
    }
    else
    {
        $start = $start*2;
        $sublen = $sublen*2;
        $strlen = strlen($string);
        $tmpstr = '';

        for($i=0; $i< $strlen; $i++)
        {
            if($i>=$start && $i< ($start+$sublen))
            {
                if(ord(substr($string, $i, 1))>129){
                    $tmpstr.= substr($string, $i, 2);
                }else{
                    $tmpstr.= substr($string, $i, 1);
                }
            }
            if(ord(substr($string, $i, 1))>129) $i++;
        }
        if(strlen($tmpstr)< $strlen ) $tmpstr.= "...";
        return $tmpstr;
    }
} 

function FormatCharLen($String,$len=20){
  return strlen($String)>$len ? substr($String,0,$len).'...' :$String;
}
?>
