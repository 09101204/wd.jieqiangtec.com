<?php
include_once("../include/common.inc.php");
$cid=Char_Cv("companyid");
$user=Char_Cv("username");
$pass=md5(Char_Cv("password"));
if($db->rows("worker","companyid='$cid' and username='$user' and password='$pass'")==0){
  ero("用户名或密码不正确",1);
}else{
  $mytime=GetTime(date('Y-m-d',$time));
  $setting=$db->record("setting","ntype,exptime,package","companyid='$cid'",1);
  if(!$setting)ero("账号不存在",1);
  $exptime=$setting[0]['exptime'];
  $package=$setting[0]['package'];
  
  $myfun=array();
  if($exptime<$mytime){
    ero("您的套餐功能过期，已恢复为普通账号！",2);
    WriteLog($cid,'套餐','套餐功能过期，已恢复为普通账号！');
  }else{
    if($package!=0){
      $pfun=$db->select("package","funs","id=$package");
      $pfun=explode(',',$pfun);
      foreach($pfun as $v){
        $myfun[$v]=$v;
      }
    }
  }
  $fun=$db->record("function","keyname","price=0 and isused=1");
  foreach($fun as $rs){
    $myfun[$rs['keyname']]=$rs['keyname'];
  }
  $fun=$db->record("myfunction","keyname","companyid='$cid' and exptime>=$mytime");
  foreach($fun as $rs){
    $myfun[$rs['keyname']]=$rs['keyname'];
  }
  $db->update("setting","grade,status",implode(',',$myfun).'|1',"companyid='$cid'");
  
  $address=getaddress($onlineip,true);
  $db->query("update {$tbl}worker set lasttime=thistime,lastip=thisip,lastaddress=thisaddress,thistime=now(),thisip='$onlineip',thisaddress='".$address."',logincount=logincount+1 where companyid='$cid' and username='$user'");
  
  $talktimes=count($db->record("history","id","companyid='$cid' group by clientid"));
  $db->update("setting","talk","$talktimes","companyid='$cid'");
  
  $_SESSION["eqmk_worker_companyid"]=$cid;
  $_SESSION["eqmk_worker_username"]=$user;
  print('<script>location.href="manage.php"</script><a href="manage.php">立即进入</a>');
  exit;
}
?>