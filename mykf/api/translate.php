<?
//翻译
$Lang['en']='英语';
$Lang['zh-TW']='繁体中文';
$Lang['zh-CN']='简体中文';
$Lang['ar']='阿拉伯文';
$Lang['bg']='保加利亚文';
$Lang['pl']='波兰语';
$Lang['ko']='朝鲜语';
$Lang['da']='丹麦语';
$Lang['de']='德语';
$Lang['ru']='俄语';
$Lang['fr']='法语';
$Lang['fi']='芬兰语';
$Lang['nl']='荷兰语';
$Lang['cs']='捷克语';
$Lang['hr']='克罗地亚文';
$Lang['ro']='罗马尼亚语';
$Lang['no']='挪威语';
$Lang['pt']='葡萄牙语';
$Lang['ja']='日语';
$Lang['sv']='瑞典语';
$Lang['es']='西班牙语';
$Lang['el']='希腊语';
$Lang['it']='意大利语';
$Lang['hi']='印度文';
$MG=$_POST['text'];
$fromlang=$_POST['sl'];
$tolang=$_POST['tl'];
if(!$MG || !$fromlang || !$tolang)die();

function PostData($host,$script,$params){
  $length = strlen($params);
  //创建socket连接 
  $fp = @fsockopen($host,80,$errno,$errstr,10) or exit($errstr."--->".$errno); 
  //构造post请求的头 
  $header = "POST $script HTTP/1.1\r\n"; 
  $header .= "Host: $host:80\r\n"; 
  $header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
  $header .= "Content-Length: $length\r\n"; 
  $header .= "Connection: Close\r\n\r\n";
  //添加post的字符串 
  $header .= $params."\r\n"; 
  //发送post的数据 
  fputs($fp,$header); 
  $inheader = 1; 
  $tmp='';
  while (!feof($fp)) {
    $line = fgets($fp,1024); //去除请求包的头只显示页面的返回数据
    if($inheader && ($line == "\n" || $line == "\r\n")){
      $inheader = 0;
    }
    if($inheader == 0){
      $tmp.=$line; 
    }
  }
  fclose($fp);
  return $tmp;
}
$A=$B='';
$A.='&text='.urlencode($MG);
$A.='&sl='.$fromlang;
$A.='&tl='.$tolang;
$A.='&ie=UTF8';
$i=0;
function CheckResult(){
  global $i,$A;
  $i++;
  if($i>=3)return;
  $tmpdata=PostData('translate.google.cn','/translate_t',$A);
  if(preg_match("/\<input type=hidden name=gtrans value=\"([^\"]+)\">/i",$tmpdata,$tmparr)){
    //$B='<input type=hidden name=gtrans value="'.$tmparr[1].'">';
    $B=$tmparr[1];
    print($B);
    exit();
  }else{
    CheckResult();
  }
}
CheckResult();
?>