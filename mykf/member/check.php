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
$MyGrades=array('modify'=>'修改资料',
                'config'=>'基本设置',
                'style'=>'风格设置',
                'word'=>'常用语设置',
                'function'=>'功能管理',
                'log'=>'操作日志',
                'money'=>'消费明细',
                'history'=>'恰谈记录',
                'worker'=>'客服管理',
                'workersort'=>'席位管理',
                'getcode'=>'获取代码',
                'faq'=>'自动应答',
                'count'=>'访问统计',
                'buy'=>'购买',
                'pay'=>'充值',
                'add'=>'续费',
                'exptimes'=>'展期'
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
alert("用户名或密码不正确");
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