<?php
@include_once("../include/common.inc.php");
if($paytype=='1'){
  $notify_url	= "{$homepage}api/alipay.php";
  $return_url	= "{$homepage}api/alipay.php";
  $link=generateURLForDirect($o_body,$notify_url,$torder,$return_url,$alipayid,$o_title,$price,$partner,$alipaykey);
	print('<script type="text/javascript">
window.open("'.$link.'","","");
if(confirm("ϵͳ�ѵ���֧����֧��ҳ�棡\n\n֧���ɹ����뵥����ȷ�����������밴��ȡ������")){
  location.href="member.php?action=money";
}else{
  history.go(-1);
}
</script>');
	exit;
}
$returnTxt			= "Error";
//���֧����֪ͨ�ӿڴ��ݹ����Ĳ����Ƿ�Ϸ�
$out_trade_no		= $_POST['out_trade_no'];
$total_fee			= $_POST['total_fee'];
$notify_id			= $_POST['notify_id'];
function  log_result($word) {
	$fp = fopen("log.txt","a");	
	fwrite($fp,$word."��ִ�����ڣ�".date("YmdHis")."\t\n");
	fclose($fp);
}
//��֤��Ϣ�ĺϷ��ԣ�������ؽ��ResponseTxt=True����˵����Ϣ�ǺϷ��ģ�������Ϊ���Ϸ�
$alipayNotifyURL	= "http://notify.alipay.com/trade/notify_query.do?";
$alipayNotifyURL	= $alipayNotifyURL."notify_id=".$notify_id."&partner=$partner";
//log_result($alipayNotifyURL);
$urlarr = parse_url($alipayNotifyURL);
$time_out="60";
$errno = "";
$errstr = "";
$transports = "";
$transports = "tcp://";
$urlarr["port"] = "80";
$fp=@fsockopen($transports . $urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
if(!$fp) {
  die("ERROR: $errno - $errstr<br />\n");
}else{
  fputs($fp, "POST ".$urlarr["path"]." HTTP/1.1\r\n");
  fputs($fp, "Host: ".$urlarr["host"]."\r\n");
  fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
  fputs($fp, "Content-length: ".strlen($urlarr["query"])."\r\n");
  fputs($fp, "Connection: close\r\n\r\n");
  fputs($fp, $urlarr["query"] . "\r\n\r\n");
  while(!feof($fp)) {
    $info[]=@fgets($fp, 1024);
  }
  fclose($fp);
  $info = implode(",",$info);
  while (list ($key, $val) = each ($_POST)) {
    $arg.=$key."=".$val."&";
  }
}
$ResponseTxt= eregi("true$",$info) ? true : false;
//log_result($alipayNotifyURL."\n------------------------------------------------------\n".$ResponseTxt."\n\n");
if($ResponseTxt=='true') {
    $v_oid=$out_trade_no;
    $torder=$db->record("torder","companyid,ntype,price,content,endtime","torder='$v_oid'",1);
    if(!$torder){
      $returnTxt	= "fail";
    }elseif($torder[0]["price"]!=$total_fee){
      $returnTxt	= "fail";
    }elseif($torder[0]["endtime"]>0){
      $returnTxt	= "success";
    }
    
    $companyid=$torder[0]["companyid"];
    $ntype=$torder[0]["ntype"];
    $content=$torder[0]["content"];
    $setting=$db->record("setting","ntype,paymoney,exptime,sortcount,workercount","companyid='$companyid'",1);
    $paymoney=$setting[0]['paymoney'];
    $exptime=$setting[0]['exptime'];
    $mytime=GetTime(date('Y-m-d',$time));
    
    if($returnTxt	== "Error"){
      if($ntype=='exptimes'){
        $paymoney+=$total_fee;
        $days=$content;
        $exptime_=$exptime>=$mytime ? $exptime+$days*86400*$PriceOne[1] : $mytime+$days*86400*$PriceOne[1];
        $db->update("setting","exptime,paymoney","$exptime_|$paymoney","companyid='$companyid'");
        WriteMoneyLog($companyid,-$total_fee,"[֧����]�ͷ�չ����".date('Y-m-d',$exptime_));
        WriteLog($companyid,"�ͷ�չ��","�ͷ�չ����".date('Y-m-d',$exptime_));
      }elseif($ntype=='pay'){
        $db->query("update {$tbl}setting set `money`=`money`+".$total_fee." where companyid='$companyid'");
        WriteMoneyLog($companyid,$total_fee,"[֧����]Ϊ�˻�����".$total_fee."Ԫ");
        WriteLog($companyid,"�˻���ֵ","Ϊ�˻�����".$total_fee."Ԫ");
      }elseif($ntype=='reg'){
        $co=explode(',',$content);
        $keyname=$co[0];
        $days=$co[1];
        $buynum=$co[2];
        $price=$co[3];
        $ti=$co[4];
        $grade=$setting[0]['grade'] ? $setting[0]['grade'].','.$keyname : $keyname;
        $paymoney+=$total_fee;
        $exptime=$mytime+$days*$buynum*86400;
        if($db->rows("myfunction","companyid='$companyid' and keyname='$keyname'")==0){
          $db->insert("myfunction","companyid,keyname,starttime,exptime","$companyid|$keyname|$time|$exptime");
        }
        $db->update("setting","ntype,paymoney,grade","1|$paymoney|$grade","companyid='$companyid'");
        WriteMoneyLog($companyid,-$total_fee,"[֧����]��ͨ���ܡ�".$ti."��,����$price,����$buynum,��Ч����".date('Y-m-d',$exptime));
        WriteLog($companyid,"��ͨ����","��ͨ���ܡ�".$ti."��");
      }elseif($ntype=='add'){
        $co=explode(',',$content);
        $keyname=$co[0];
        $days=$co[1];
        $buynum=$co[2];
        $price=$co[3];
        $ti=$co[4];
        $grade=$setting[0]['grade'] ? $setting[0]['grade'].','.$keyname : $keyname;
        $paymoney+=$total_fee;
        $exptime=$db->select("myfunction","exptime","companyid='$companyid' and keyname='$keyname'");
        $exptime_=$exptime>=$mytime ? $exptime+$days*$buynum*86400 : $mytime+$days*$buynum*86400;
        $db->update("myfunction","exptime","$exptime_","companyid='$cid' and keyname='$keyname'");
        $db->update("setting","ntype,paymoney,grade","1|$paymoney|$grade","companyid='$companyid'");
        WriteMoneyLog($companyid,-$total_fee,"[֧����]�������ѡ�".$ti."��,����$price,����$buynum,��Ч����".date('Y-m-d',$exptime_));
        WriteLog($companyid,"��������","�������ѡ�".$ti."��");
      }elseif($ntype=='buypackage'){
        $paymoney+=$total_fee;
        $o=explode(',',$content);
        $packid=$o[0];
        $ti=urldecode($o[1]);
        $exptime=$o[2];
        $db->update("setting","package,packtime,exptime,money,paymoney","$packid|$time|$exptime|$money|$paymoney","companyid='$companyid'");
        WriteMoneyLog($companyid,-$total_fee,"[֧����]".$ti);
        WriteLog($companyid,"�ײ�",$ti);
      }elseif($ntype=='paypackage'){
        $paymoney+=$total_fee;
        $o=explode(',',$content);
        $ti=urldecode($o[0]);
        $exptime=$o[1];
        $db->update("setting","exptime,money,paymoney","$exptime|$money|$paymoney","companyid='$companyid'");
        WriteMoneyLog($companyid,-$total_fee,"[֧����]".$ti);
        WriteLog($companyid,"�ײ�",$ti);
      }elseif($ntype=='buysort' || $ntype=='buyworker'){
        $buynum=$content;
        $paymoney+=$total_fee;
        if($ntype=='buysort'){
          $sortcount=$setting[0]['sortcount'];
          if($sortcount<1)$sortcount=$default_sortcount;
          $curcount=$sortcount;
          $xxx='sortcount';
          WriteMoneyLog($cid,-$totalprice,"[֧����]����".$buynum."��ϯλ");
          WriteLog($cid,"����ϯλ��","����".$buynum."��ϯλ");
        }else{
          $workercount=$setting[0]['workercount'];
          if($workercount<1)$workercount=$default_workercount;
          $curcount=$workercount;
          $xxx='workercount';
          WriteMoneyLog($cid,-$totalprice,"[֧����]����".$buynum."���ͷ�");
          WriteLog($cid,"���ӿͷ���","����".$buynum."���ͷ�");
        }
        $totalcount=$curcount+$buynum;
        $db->update("setting","ntype,paymoney,$xxx","1|$paymoney|$totalcount","companyid='$companyid'");
      }
      $returnTxt	= "success";
      $db->update("torder","endtime",$time,"torder='$v_oid'");
    }
}
echo $returnTxt;
//�½ӿڼ�ʱ���ʣ�����������Ʒ���ף�
function generateURLForDirect($s1,$s2,$s3,$s4,$s5,$s6,$s7,$s8,$s9){
  $strTemp				= "https://www.alipay.com/cooperate/gateway.do?";
  $strTemp				= $strTemp."agent=20200601050219";
  $strTemp				= $strTemp."&body=".$s1;
  $strTemp				= $strTemp."&notify_url=".$s2;
  $strTemp				= $strTemp."&out_trade_no=".$s3;
  $strTemp				= $strTemp."&partner=".$s8;
  $strTemp				= $strTemp."&payment_type=1";
  $strTemp				= $strTemp."&return_url=".$s4;
  $strTemp				= $strTemp."&seller_email=".$s5;
  $strTemp				= $strTemp."&service=create_direct_pay_by_user";
  $strTemp				= $strTemp."&subject=".$s6;
  $strTemp				= $strTemp."&total_fee=".$s7;
  $strTemp				= $strTemp."&sign=".generateSignForDirect($s1,$s2,$s3,$s4,$s5,$s6,$s7,$s8,$s9);
  $strTemp				= $strTemp."&sign_type=MD5";
  return $strTemp;
}

//�½ӿڼ�ʱ��������MD5ժҪ
function generateSignForDirect($s1,$s2,$s3,$s4,$s5,$s6,$s7,$s8,$s9){
  $strTemp		= "agent=20200601050219"."&body=".$s1."&notify_url=".$s2."&out_trade_no=".$s3."&partner=".$s8."&payment_type=1"."&return_url=".$s4."&seller_email=".$s5."&service=create_direct_pay_by_user"."&subject=".$s6."&total_fee=".$s7.$s9;
  return md5($strTemp);
}
?>