<?
include("../include/common.inc.php");
$cid=$_SESSION["eqmk_worker_companyid"];
$username=$_SESSION["eqmk_worker_username"];
if($cid=='' || $username==''){
  header("location:index.php");
  exit;
}
if($rs=$db->record("setting","grade,sortcount,workercount","companyid='$cid'",1)){
  $Grade=explode(',',$rs[0]['grade']);
  $sortcount=$rs[0]['sortcount'];
  $workercount=$rs[0]['workercount'];
  if($sortcount<1)$sortcount=$default_sortcount;
  if($workercount<1)$workercount=$default_workercount;
}
$MyGrades=array('modify'=>'�޸�����',
                'config'=>'��������',
                'style'=>'�������',
                'word'=>'����������',
                'function'=>'���ܹ���',
                'log'=>'������־',
                'money'=>'������ϸ',
                'history'=>'ǡ̸��¼',
                'worker'=>'�ͷ�����',
                'workersort'=>'ϯλ����',
                'getcode'=>'��ȡ����',
                'faq'=>'�Զ�Ӧ��',
                'count'=>'����ͳ��',
                'buy'=>'����',
                'pay'=>'��ֵ',
                'add'=>'����',
                'exptimes'=>'չ��'
);
if($rs=$db->record("worker","grade,nickname,workerid,id,logincount,lasttime,thistime,lastip,thisip,lastaddress,thisaddress,style,mq","companyid='$cid' and username='$username'")){
  $logincount=$rs[0]["logincount"];
  $grade=$rs[0]["grade"];
  $nickname=$rs[0]["nickname"];
  $wid=$rs[0]["id"];
  $lasttime=$rs[0]["lasttime"];
  $thistime=$rs[0]["thistime"];
  $lastip=$rs[0]["lastip"];
  $thisip=$rs[0]["thisip"];
  $lastaddress=$rs[0]["lastaddress"];
  $thisaddress=$rs[0]["thisaddress"];
  $adminstyle=$rs[0]["style"];
  $MQ=$rs[0]["mq"];
  if(!$MQ){
    $MQ=$MQStart+$wid;
    $db->update("worker","mq",$MQ,"companyid='$cid' and username='$username'");
  }
}else{
  print('<script type="text/javascript">
alert("�û��������벻��ȷ");
top.location.href="../index.php";
</script>');
  exit();
}
function MyGrade($g){
  global $grade,$cid,$username;
  if($cid==$username)return true;
  return @in_array($g,explode(',',$grade)) ? true : false;
}
if(!$adminstyle)$adminstyle="default";
include("../template/admin/$adminstyle/config.php");
unset($logo,$rs);
?>