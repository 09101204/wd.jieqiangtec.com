<?
//����
$Lang['en']='Ӣ��';
$Lang['zh-TW']='��������';
$Lang['zh-CN']='��������';
$Lang['ar']='��������';
$Lang['bg']='����������';
$Lang['pl']='������';
$Lang['ko']='������';
$Lang['da']='������';
$Lang['de']='����';
$Lang['ru']='����';
$Lang['fr']='����';
$Lang['fi']='������';
$Lang['nl']='������';
$Lang['cs']='�ݿ���';
$Lang['hr']='���޵�����';
$Lang['ro']='����������';
$Lang['no']='Ų����';
$Lang['pt']='��������';
$Lang['ja']='����';
$Lang['sv']='�����';
$Lang['es']='��������';
$Lang['el']='ϣ����';
$Lang['it']='�������';
$Lang['hi']='ӡ����';
$MG=$_POST['text'];
$fromlang=$_POST['sl'];
$tolang=$_POST['tl'];
if(!$MG || !$fromlang || !$tolang)die();

function PostData($host,$script,$params){
  $length = strlen($params);
  //����socket���� 
  $fp = @fsockopen($host,80,$errno,$errstr,10) or exit($errstr."--->".$errno); 
  //����post�����ͷ 
  $header = "POST $script HTTP/1.1\r\n"; 
  $header .= "Host: $host:80\r\n"; 
  $header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
  $header .= "Content-Length: $length\r\n"; 
  $header .= "Connection: Close\r\n\r\n";
  //���post���ַ��� 
  $header .= $params."\r\n"; 
  //����post������ 
  fputs($fp,$header); 
  $inheader = 1; 
  $tmp='';
  while (!feof($fp)) {
    $line = fgets($fp,1024); //ȥ���������ͷֻ��ʾҳ��ķ�������
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