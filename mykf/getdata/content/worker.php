<?
include_once '../../include/common.inc.php';
$token=Char_Cv("token");
if(!$token){
  $action=Char_Cv("action");
  $cid=Char_Cv("cid");
  if($action=='list2')$action='list';
  print('&cmd='.$action);
  print('&fdata=');
}else{
  $o=explode('#',$token);
  $action=$o[0];
  $cid=$o[1];
  $wid=$o[2];
  $lt=$o[3];
  print('&fdata=');
  //writeover('debug.txt',$token."\n",'a+');
}
switch($action){
  case "info"://基本信息
    print("EQMK|$company|$companyurl|$softtitle|1|$closeloginad|$closemainad|$closefile|$closecatch|$closepublic|$closelimit");
    break;
  case "login"://监控页更新
    $user=Char_Cv("user");
    $pass=Char_Cv("pwd");
    $lt=Char_Cv("lt");
    $status=Char_Cv("status")=="1" ? "-1" : "1";
    if(!$worker=$db->record("worker","id,nickname","companyid='$cid' and username='$user' and password='$pass'")){
      exit("fail");
    }else{
      $setting=$db->record("setting","ntype,exptime","companyid='$cid'",1);
      if(!$setting)exit("notexists");
      $exptime=$setting[0]['exptime'];
      $mytime=GetTime(date('Y-m-d',$time));
      if($exptime<$mytime)exit("overtime");
      $address=getaddress($onlineip,true);
      
      $db->query("update {$tbl}worker set lasttime=thistime,lastip=thisip,lastaddress=thisaddress,thistime=now(),thisip='$onlineip',thisaddress='".$address."',logincount=logincount+1,updatetime=$time,online=$status where companyid='$cid' and username='$user'");
      
      if($w=$db->record("worker","id","companyid='$cid' and id<>".$worker[0]['id']." and online>0")){//上线提示
        foreach($w as $rs){
          $db->insert("message","companyid,workerid,clientid,action,content,addtime",$cid.'|'.$rs['id']."|".$worker[0]['id']."|7|1|$now");
        }
      }
      $db->delete("message","companyid='$cid' and workerid=".$worker[0]['id']." and (action='5' or action='7' or (action='2' and content='对话框已关闭'))");
      //删除监控数据
      $tplpath="../../eqmkdata/cache";
      $dh=opendir($tplpath);
      while ($file=readdir($dh)) {
        if($file!="." && $file!="..") {
          if(!is_dir($tplpath.'/'.$file)) {
            if(substr($file,0,2)!='__'&&filemtime($tplpath.'/'.$file)<$time-1800)@unlink($tplpath.'/'.$file);
          }
        }
      }
      $fdata=$worker[0]["id"]."|".formatdata($worker[0]["nickname"])."|F00002|".date('Y-m-d H:i:s',$time)."|";
      writeover('../../eqmkdata/cache/__system_login_'.$worker[0]["id"].'.txt',$lt);
    }
    $fdata=urlencode($fdata);
    print($fdata);
    exit();
    break;
  case "update"://列表
    if($time % 5==0){
      $db->delete("dialog","companyid='$cid' and time2<".($time-60));
      $db->update("worker","online","0","companyid='$cid' and lasttime<".($time-60));
      $user=array();
      $Icon=array('-2'=>'7','-1'=>'7','0'=>'7','1'=>'8','2'=>'9','3'=>'10');
      if($w=$db->record("worker","id,nickname,online","companyid='$cid' and id<>$wid")){
        foreach($w as $rs){
          $user[]="1|" .$rs['id'] . "|" .$rs['nickname'] . "|" .$rs['online'] . "|" .$Icon[$rs['online']];
        }
      }
      if($online=$db->record("client","id,thispage,ip,address","companyid='$cid' and status<>-1 and status<>-2 and (workerid='' or workerid='$wid') and lasttime>".($time-60),20)){
        foreach($online as $rs){
          $user[]="2|" .$rs['id']."|" .GetId($rs['id'],7)."|".$rs['ip']."|".$rs['address']."|".urldecode($rs['thispage']);
        }
      }
      $fdata=implode("<E>",$user);
      $fdata=urlencode($fdata);
      $fdata=urlencode("&cmd=list&fdata=$fdata");
    }else{
      if(!$wid)exit;
      if(readover('../../eqmkdata/cache/__system_login_'.$wid.'.txt')!=$lt)die("0<E>eqmk_repeat_login<E>$time<E>5<E><E>");
      $db->update("worker","online","0","companyid='$cid' and updatetime<".($time-60));
      $db->update("worker","updatetime","$time","companyid='$cid' and id=$wid");
      $message=array();
      if($Msg=$db->record("message","id,clientid,content,addtime,action","companyid='$cid' and workerid='$wid' and action<>1 and action<>4 order by addtime asc")){
        foreach($Msg as $rs){
          if($rs["action"]==2){
            $username=$db->select("client","address","id=".intval($rs["clientid"]));
          }
          $message[]=$rs["clientid"].'<E>'.$rs["content"].'<E>'.$rs["addtime"].'<E>'.$rs["action"].'<E>'.$word.'<E>'.$username;
        }
        $db->delete("message","companyid='$cid' and workerid='$wid' and action<>1 and action<>4");
      }
      $fdata=implode('＄',$message);
      $fdata=urlencode($fdata);
      $fdata=urlencode("&cmd=get&fdata=$fdata");
    }
    print($fdata);
    exit();
    break;
  case "list"://列表
    $db->delete("dialog","companyid='$cid' and time2<".($time-60));
    $db->update("worker","online","0","companyid='$cid' and lasttime<".($time-60));
    $user=array();
    $Icon=array('-2'=>'7','-1'=>'7','0'=>'7','1'=>'8','2'=>'9','3'=>'10');
    if($w=$db->record("worker","id,nickname,online","companyid='$cid'")){
      foreach($w as $rs){
        $user[]="1|" .$rs['id'] . "|" .$rs['nickname'] . "|" .$rs['online'] . "|" .$Icon[$rs['online']];
      }
    }
    if($online=$db->record("client","id,thispage,ip,address","companyid='$cid' and status<>-1 and status<>-2 and (workerid='' or workerid='$wid') and lasttime>".($time-60),20)){
      foreach($online as $rs){
        $user[]="2|" .$rs['id']."|" .GetId($rs['id'],7)."|".$rs['ip']."|".$rs['address']."|".urldecode($rs['thispage']);
      }
    }
    $fdata=implode("<E>",$user);
    $fdata=urlencode($fdata);
    print($fdata);
    exit();
    break;
  case "ClientInfo"://访客记录资料
    $id=Char_Cv("id");
    $Client=$db->record("client","browser,os,systemlanguage,color,screen,charset,thispage,comeurl,ip,address,keyword,search,addtime,lasttime,keyword,workerid","companyid='$cid' and id=$id",1);
    $rs=$Client[0];
    $wid=$rs['workerid'];
    if($wid){
      $w=$db->select('worker','nickname',"companyid='$cid' and id=$wid");
    }else{
      $w='无';
    }
    $fdata=GetId($id,7)."|".$rs['ip']."|".$rs['address']."|".urldecode($rs['thispage'])."|".date('Y-m-d H:i:s',$rs['lasttime'])."|".urldecode($rs['comeurl'])."|".$rs['keyword']."|".$rs['os']."|".str_replace('Internet Explorer','IE',$rs['browser'])."|".$rs['screen']."|".$rs['color']."|".$rs['systemlanguage']."|".$rs['charset']."|".$w;
    $fdata=urlencode($fdata);
    print($fdata);
    break;
  case "WorkerInfo"://访客记录资料
    $id=Char_Cv("id");
    $Worker=$db->record("worker","nickname,sex,city,phone,email,qq,content,onlinetitle,onlinetip,offlinetitle,offlinetip,closetip","companyid='$cid' and id=$id",1);
    $rs=$Worker[0];
    $fdata=$rs['nickname']."|".$rs['sex']."|".$rs['city']."|".$rs['phone']."|".$rs['email']."|".$rs['qq']."|".$rs['content']."|".$rs['onlinetitle']."|".$rs['onlinetip']."|".$rs['offlinetitle']."|".$rs['offlinetip']."|".$rs['closetip'];
    $fdata=urlencode($fdata);
    print($fdata);
    exit();
    break;
  case "tmpInput"://输入监控
    $uid=Char_Cv("uid");
    $fdata=@readover('../../eqmkdata/cache/'.$cid.'_'.$uid.'.txt');
    if($fdata=='EQMK_COM_WINDOW_QUAKE')writeover('../../eqmkdata/cache/'.$cid.'_'.$uid.'.txt','');
    $fdata=urlencode($fdata);
    print($fdata);
    exit();
    break;
  case "myInput"://客服输入状态
    $wid=Char_Cv("wid");
    $uid=Char_Cv("uid");
    writeover('../../eqmkdata/cache/'.$cid.'_wid_'.$wid.'_'.$uid.'.txt','');
    exit();
    break;
  case "send"://发送消息
    $wid=Char_Cv("wid");
    $uid=Char_Cv("uid");
    $uname=Char_Cv("uname");
    $utype=Char_Cv("utype");
    $fdata=Char_Cv("fdata");
    $fdata=str_replace("&lt;","<",$fdata);
    $fdata=str_replace("&quot;","\"",$fdata);
    $fdata=str_replace("&gt;",">",$fdata);
    if(!$wid)exit("N");
    if(!$fdata)exit("O");
    //$fdata=iconv('utf-8','gb2312',$fdata);
    $fdata=eqmkcode($fdata);
    if($utype=="6"){
      if($w=$db->record("worker","id","companyid='$cid' and id<>$wid and online>0")){
        foreach($w as $rs){
          $db->insert("message","companyid,workerid,clientid,action,content,addtime",$cid.'|'.$rs['id']."|$wid|6|$fdata|$now");
        }
      }
    }elseif($utype=="3"){
      $db->insert("message","companyid,workerid,clientid,action,content,addtime","$cid|$uid|$wid|$utype|$fdata|$now");
      $db->insert("history","companyid,workerid,workername,clientid,clientname,action,content,addtime","$cid|$uid|$uname|$wid||$utype|$fdata|$now");
    }elseif($utype=="1"){
      $db->insert("message","companyid,workerid,clientid,action,content,addtime","$cid|$wid|$uid|$utype|$fdata|$now");
      $db->insert("history","companyid,workerid,workername,clientid,clientname,action,content,addtime","$cid|$wid|$uname|$uid||$utype|$fdata|$now");
    }
    exit("Y");
    break;
  case "get"://读取信息
    $wid=Char_Cv("wid");
    $lt=Char_Cv("lt");
    if(!$wid)exit;
    if(readover('../../eqmkdata/cache/__system_login_'.$wid.'.txt')!=$lt)die("0<E>eqmk_repeat_login<E>$time<E>5<E><E>");
    $db->update("worker","online","0","companyid='$cid' and updatetime<".($time-60));
    $db->update("worker","updatetime","$time","companyid='$cid' and id=$wid");
    $message=array();
    if($Msg=$db->record("message","id,clientid,content,addtime,action","companyid='$cid' and workerid='$wid' and action<>1 and action<>4 order by addtime asc")){
      foreach($Msg as $rs){
        if($rs["action"]==2){
          $username=$db->select("client","address","id=".intval($rs["clientid"]));
        }
        $message[]=$rs["clientid"].'<E>'.$rs["content"].'<E>'.$rs["addtime"].'<E>'.$rs["action"].'<E>'.$word.'<E>'.$username;
      }
      $db->delete("message","companyid='$cid' and workerid='$wid' and action<>1 and action<>4");
    }
    $fdata=implode('＄',$message);
    $fdata=urlencode($fdata);
    print($fdata);
    exit();
    break;
  case "save"://保存资料
    unset($Info);
    $wid=Char_Cv("wid");
    $password=Char_Cv("pwd");
    $Info['nickname']=Char_Cv("nickname");
    $Info['sex']=Char_Cv("sex");
    $Info['city']=Char_Cv("city");
    $Info['phone']=Char_Cv("phone");
    $Info['email']=Char_Cv("email");
    $Info['qq']=Char_Cv("qq");
    $Info['content']=Char_Cv("content");
    $Info['onlinetitle']=Char_Cv("onlinetitle");
    $Info['onlinetip']=Char_Cv("onlinetip");
    $Info['offlinetitle']=Char_Cv("offlinetitle");
    $Info['offlinetip']=Char_Cv("offlinetip");
    $Info['closetip']=Char_Cv("closetip");
    if(!$wid)exit;
    $key=$value=array();
    foreach($Info as $k=>$v){
      $key[]=$k;
      $value[]=$v;
    }
    $db->update("worker",implode(',',$key),implode('|',$value),"companyid='$cid' and id=$wid ");
    exit("Y");
    break;
  case "online"://在线状态
    unset($Info);
    $wid=Char_Cv("wid");
    $online=Char_Cv("online");
    if(!$wid)exit;
    $db->update("worker","online",$online,"companyid='$cid' and id=$wid");
    exit("Y");
    break;
  case "logout"://退出
    $wid=Char_Cv("wid");
    if(!$wid)exit;
    $db->update("worker","online","0","companyid='$cid' and id=$wid");
    exit("Y");
    break;
  case "limit"://屏蔽访问并关闭对话框
    $wid=Char_Cv("wid");
    $uid=Char_Cv("uid");
    $db->update("client","status","-1","companyid='$cid' and id=".intval($uid));
    $db->insert("message","companyid,workerid,clientid,addtime,content,action",$cid.'|'.$wid.'|'.$uid."|$now|eqmk://system.close|1");
    break;
  case "closed"://关闭对话框
    $wid=Char_Cv("wid");
    $uid=Char_Cv("uid");
    //$db->insert("message","companyid,workerid,clientid,addtime,content,action",$cid.'|'.$wid.'|'.$uid."|$now|eqmk://system.close|1");
    break;
  case "regchange"://客服转接申请
    //$tmpdata参数：访客|A客服|B客服
    $wid=Char_Cv("wid");
    $password=Char_Cv("pwd");
    $tmpdata=Char_Cv("tmpdata");
    if(!$wid||!$tmpdata)exit;
    //if($db->rows("worker","companyid='$cid' and id=$wid and password='$password'")==0)exit("N");
    $tmpdata=explode("｜",$tmpdata);
    $db->insert("message","companyid,workerid,clientid,addtime,content,action",$cid.'|'.$tmpdata[2].'|'.$tmpdata[1]."|$now|eqmk://system.regchange.".$tmpdata[0]."|3");
    break;
  case "agreechange"://是否同意客服转接
    //$tmpdata参数：访客|B客服|A客服|是否同意
    $wid=Char_Cv("wid");
    $password=Char_Cv("pwd");
    $tmpdata=Char_Cv("tmpdata");
    if(!$wid||!$tmpdata)exit;
    //if($db->rows("worker","companyid='$cid' and id=$wid and password='$password'")==0)exit("N");
    $tmpdata=explode("｜",$tmpdata);
    $db->insert("message","companyid,workerid,clientid,addtime,content,action",$cid.'|'.$tmpdata[2].'|'.$tmpdata[0]."|$now|eqmk://system.agreechange.".$tmpdata[3].".".$tmpdata[1]."|2");
    if($tmpdata[3]=='agree'){
      $db->update("client","workerid",$tmpdata[1],"companyid='$cid' and workerid='".$tmpdata[2]."' and id=".intval($tmpdata[0]));
      $db->update("dialog","workerid",$tmpdata[1],"companyid='$cid' and workerid='".$tmpdata[2]."' and clientid='".$tmpdata[0]."'");
      $db->insert("message","companyid,workerid,clientid,addtime,content,action",$cid.'|'.$tmpdata[1]."|".$tmpdata[0]."|$now||4");
    }
    exit("Y");
    break;
}
?>