<?
define('NOTCLOSE', TRUE);
include_once '../../include/common.inc.php';
$action=Char_Cv("action");
switch($action){
  case "info"://基本信息
    print('&cmd=info');
    print('&fdata=');
    print("EQMK|$company|$companyurl|$softtitle|1|$closeloginad|$closemainad|$closefile|$closecatch|$closepublic|$closelimit");
    exit();
    break;
  case "login"://监控页更新
    $user=Char_Cv("user");
    $pass=Char_Cv("pwd");
    $lt=Char_Cv("lt");
    $status=Char_Cv("status")=="1" ? "-1" : "1";
    print('&cmd=login');
    print('&fdata=');
    if(!$worker=$db->record("worker","id,nickname","companyid='$cid' and username='$user' and password='$pass'")){
      exit("fail");
    }else{
      $setting=$db->record("setting","ntype,exptime,grade,package","companyid='$cid'",1);
      if(!$setting)exit("notexists");
      $exptime=$setting[0]['exptime'];
      $package=$setting[0]['package'];
      $mytime=GetTime(date('Y-m-d',$time));
      $myfun=array();
      if($exptime<$mytime){
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
      $fun=$db->record("myfunction","keyname","companyid='$cid' and exptime>=$mytime");
      foreach($fun as $rs){
        $myfun[$rs['keyname']]=$rs['keyname'];
      }
      if(count($myfun)==0 && $autolock=='1'){
        exit("overtime");
      }
      $fun=$db->record("function","keyname","price=0 and isused=1");
      foreach($fun as $rs){
        $myfun[$rs['keyname']]=$rs['keyname'];
      }
      $Grade=$myfun;
      $super=CheckGrade('super')?'Y':'';
      $db->update("setting","grade,status",implode(',',$myfun).'|1',"companyid='$cid'");
      
      $address=getaddress($onlineip,true);
      
      $db->query("update {$tbl}worker set lasttime=thistime,lastip=thisip,lastaddress=thisaddress,thistime=now(),thisip='$onlineip',thisaddress='".$address."',logincount=logincount+1,updatetime=$time,online=$status where companyid='$cid' and username='$user'");
      $db->update("client","updatetime","0","companyid='$cid' and lasttime>".($time-60));
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
      @include_once('../../api/mks/server.inc.php');
      $fdata=$worker[0]["id"]."|".formatdata($worker[0]["nickname"])."|F00002|".date('Y-m-d H:i:s',$time).'|'.$super.'|'.$onlineip.'|'.$mks[0].'|'.$mks[1];
      writeover('../../eqmkdata/cache/__system_login_'.$worker[0]["id"].'.txt',$lt);
    }
    $fdata=urlencode($fdata);
    print($fdata);
    exit();
    break;
}
#$debug=true;
$token=Char_Cv('token');
$msg=Char_Cv('msg');
if($debug)writeover('debug.txt',"[$now]token=$token;msg=$msg\n","a");
if($token){
  $o=explode(',',$token);
  if($o[0]=='update'){
    $cid=$o[1];
    $wid=$o[2];
    $lt=$o[3];
    if($time % 3==0){
      $db->delete("dialog","companyid='$cid' and time2<".($time-60));
      $db->update("worker","online","0","companyid='$cid' and lasttime<".($time-60));
      $user=array();
      $Icon=array('-2'=>'7','-1'=>'7','0'=>'7','1'=>'8','2'=>'9','3'=>'10');
      if($w=$db->record("worker","id,realname,nickname,online,updatetime","companyid='$cid' and id<>$wid")){
        unset($rs);
        foreach($w as $rs){
          $nickname=$rs['realname'];
          if(!$nickname)$nickname=$rs['nickname'];
          $input='';
          if($rs['online']>0){
            $input=time()-@filemtime('../../eqmkdata/cache/'.$cid.'_wid_'.$rs['id'].'_'.$wid.'.txt')<5?'Y':'';
          }
          $user[]="1|" .$rs['id'] . "|" .$nickname . "|" .$rs['online'] . "|" .$Icon[$rs['online']] . "|" .$input;
        }
      }
      if($online=$db->record("client","id,thispage,ip,address,updatetime","companyid='$cid' and status<>-1 and status<>-2 and (workerid='' or workerid='$wid') and lasttime>".($time-60),20)){
        unset($rs);
        foreach($online as $rs){
          $uid=GetId($rs['id'],7);
          if($rs['updatetime']<$time-60){
            $nickname=ClientNickname($rs);
            $tmp="|".$rs['ip']."|".$rs['address']."|".$rs['thispage']."|".$nickname;
            $db->update("client","updatetime","$time","id=".$rs['id']);
          }else{
            $tmp='';
          }
          $input=@readover('../../eqmkdata/cache/'.$cid.'_'.$uid.'.txt');
          if($input=='EQMK_COM_WINDOW_QUAKE')writeover('../../eqmkdata/cache/'.$cid.'_'.$uid.'.txt','');
          $user[]="2|" .$rs['id']."|" .$uid."|".htmlspecialchars($input).$tmp;
        }
      }
      $fdata=implode("<E>",$user);
      $fdata=urlencode($fdata);
      $fdata=urlencode("&cmd=list&fdata=$fdata");
    }else{
      if(!$wid)exit('&fdata='.urlencode('&cmd=get&fdata='.urlencode("0<E>Timeout!<E>$time<E>5<E><E>")));
      if(@readover('../../eqmkdata/cache/__system_login_'.$wid.'.txt')!=$lt){
        $fdata="0<E>eqmk_repeat_login<E>$time<E>5<E><E>";
      }else{
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
        $fdata=implode('{MK}',$message);
      }
      $fdata=urlencode($fdata);
      $fdata=urlencode("&cmd=get&fdata=$fdata");
    }
  }
  print('&fdata='.$fdata);
}elseif($msg){
  $o=explode(',',$msg);
  $cid=$o[1];
  if(readover('../../eqmkdata/cache/__system_login_'.$o[2].'.txt')!=end($o)){
    $fdata="0<E>Logout<E>$time<E>5<E><E>";
    $fdata=urlencode($fdata);
    $fdata=urlencode("&cmd=get&fdata=$fdata");
    exit();
  }
  switch($o[0]){
    case'loadinfo':
      if($o[3]=='m'){
        $id=$o[4];
        $Worker=$db->record("worker","nickname,sex,city,phone,email,qq,content,onlinetitle,onlinetip,offlinetitle,offlinetip,closetip,realname,grade","companyid='$cid' and id=$id",1);
        $rs=$Worker[0];
        $rs=str_replace("\n","\r\n",$rs);
        @include_once '../../include/cal.func.php';
        $nl=@getNlDay($time);
        $nlday=$nl[2].$nl[3];
        $weekday=$nl[4];
        $fdata=$rs['nickname']."|".$rs['sex']."|".$rs['city']."|".$rs['phone']."|".$rs['email']."|".$rs['qq']."|".$rs['content']."|".$rs['onlinetitle']."|".$rs['onlinetip']."|".$rs['offlinetitle']."|".$rs['offlinetip']."|".$rs['closetip']."|".$rs['realname']."|".$rs['grade']."|$weekday|$nlday";
        $fdata=urlencode('&cmd=MyInfo&fdata='.urlencode($fdata));
      }elseif($o[3]=='w'){
        $id=$o[4];
        $Worker=$db->record("worker","nickname,sex,city,phone,email,qq,content,onlinetitle,onlinetip,offlinetitle,offlinetip,closetip,online,updatetime,thisip,thisaddress","companyid='$cid' and id=$id",1);
        $rs=$Worker[0];
        $nickname=$rs['realname'];
        if(!$nickname)$nickname=$rs['nickname'];
        $fdata=$id."|".$nickname."|".$rs['sex']."|".$rs['city']."|".$rs['phone']."|".$rs['email']."|".$rs['qq']."|".$rs['content']."|".$rs['realname']."|".$rs['nickname'].($rs['online']>0 && $rs['updatetime']>$time-20 ? ("|" .$rs['thisip'] . "|" .$rs['thisaddress']):'||');
        $fdata=urlencode('&cmd=WorkerInfo&fdata='.urlencode($fdata));
      }elseif($o[3]=='u'){
        $id=intval($o[4]);
        $Client=$db->record("client","browser,os,systemlanguage,color,screen,charset,thispage,comeurl,ip,address,keyword,search,addtime,lasttime,keyword,workerid","companyid='$cid' and id=$id",1);
        $rs=$Client[0];
        if(!$rs['nickname'])$rs['nickname']=ClientNickname($rs);
        $fdata=GetId($id,7)."|".$rs['ip']."|".$rs['address']."|".$rs['thispage']."|".date('Y-m-d H:i:s',$rs['lasttime'])."|".$rs['comeurl']."|".$rs['keyword']."|".$rs['os']."|".str_replace('Internet Explorer','IE',$rs['browser'])."|".$rs['screen']."|".$rs['color']."|".$rs['systemlanguage']."|".$rs['charset']."|".$rs['nickname'];
        $fdata=urlencode('&cmd=ClientInfo&fdata='.urlencode($fdata));
      }
      break;
    case "myInput"://客服输入状态
      $wid=$o[2];
      $uid=$o[3];
      @touch('../../eqmkdata/cache/'.$cid.'_wid_'.$wid.'_'.$uid.'.txt');
      exit();
      break;
    case'send':
      $wid=$wid2=$o[2];
      $utype=$o[3];
      $uid=$o[4];
      $uname=urldecode($o[5]);
      $uname=eqmkcode($uname);
      $fdata=urldecode($o[6]);
	  //此处更改客服端修改字体后，发送不出消息
      //$fdata=eqmkcode($fdata);
      //$fdata=preg_replace("/:([a-zA-Z]+)_([0-9]{1,2})/",'<img src="'.$homepage.'images/smiley/$1/s_$1_$2.gif">',$fdata);
      //$fdata=str_replace('"','\"',$fdata);
      //$fdata=str_replace('\\"','\"',$fdata);
      if($utype=="6"){
        if($w=$db->record("worker","id","companyid='$cid' and id<>$wid and online>0")){
          foreach($w as $rs){
            $db->insert("message","companyid,workerid,clientid,action,content,addtime",$cid.'|'.$rs['id']."|$wid|6|$fdata|$now");
          }
        }
      }elseif($utype=="3"){
        $db->insert("message","companyid,workerid,clientid,action,content,addtime","$cid|$uid|$wid|3|$fdata|$now");
        $db->insert("history","companyid,workerid,workername,clientid,clientname,action,content,addtime","$cid|$uid|$uname|$wid||3|$fdata|$now");
      }elseif($utype=="1" || substr($utype,0,2)=='C&'){
        if(substr($utype,0,2)=='C&'){
          $o=explode('&',$utype);
          $wid2=$wid.','.$o[1];
          $utype='1';
        }
        $db->insert("message","companyid,workerid,clientid,action,content,addtime","$cid|$wid2|$uid|$utype|$fdata|$now");
        $db->insert("history","companyid,workerid,workername,clientid,clientname,action,content,addtime","$cid|$wid|$uname|$uid||$utype|$fdata|$now");
      }
      @unlink('../../eqmkdata/cache/'.$cid.'_wid_'.$wid.'_'.$uid.'.txt');
      $fdata=urlencode('&cmd=send&fdata=Y');
      break;
    case "save"://保存资料
      unset($Info);
      $wid=$o[2];
      $Info['nickname']=$o[3];
      $Info['sex']=$o[4];
      $Info['city']=$o[5];
      $Info['phone']=$o[6];
      $Info['email']=$o[7];
      $Info['qq']=$o[8];
      $Info['content']=$o[9];
      $Info['onlinetitle']=$o[10];
      $Info['onlinetip']=$o[11];
      $Info['offlinetitle']=$o[12];
      $Info['offlinetip']=$o[13];
      $Info['closetip']=$o[14];
      $Info['realname']=$o[15];
      if(!$wid)exit;
      $key=$value=array();
      foreach($Info as $k=>$v){
        $key[]=$k;
        $v=str_replace('%D%A','%0D%0A',$v);
        $v=urldecode($v);
        $v=str_replace('|','｜',$v);
        $v=str_replace('"','&quot;',$v);
        $v=str_replace('%D','',$v);
        $value[]=$v;
      }
      $db->update("worker",implode(',',$key),implode('|',$value),"companyid='$cid' and id=$wid ");
      $fdata=urlencode('&cmd=save&fdata=Y');
      break;
    case "online"://在线状态
      $wid=$o[2];
      $online=$o[3];
      if(!$wid)exit;
      $db->update("worker","online",$online,"companyid='$cid' and id=$wid");
      $fdata=urlencode('&cmd=online&fdata=Y');
      break;
    case "logout"://退出
      $wid=$o[2];
      if(!$wid)exit;
      $db->update("worker","online","0","companyid='$cid' and id=$wid");
      $fdata=urlencode('&cmd=logout&fdata=Y');
      break;
    case'regchange':
      $wid=$o[2];
      $uid=$o[3];
      $toid=$o[4];
      $db->insert("message","companyid,workerid,clientid,addtime,content,action","$cid|$toid|$wid|$now|eqmk://system.regchange.$uid|3");
      $fdata=urlencode('&cmd=regchange&fdata=Y');
      break;
    case'agreechange':
      $wid=$o[2];
      $uid=$o[3];
      $toid=$o[4];
      $result=$o[5];
      $db->insert("message","companyid,workerid,clientid,addtime,content,action","$cid|$toid|$wid|$now|eqmk://system.agreechange.$result.$toid|3");
      if($result=='agree'){
        $db->update("client","workerid",$toid,"companyid='$cid' and workerid='$wid' and id=".intval($uid));
        $db->update("dialog","workerid",$toid,"companyid='$cid' and workerid='$wid' and clientid='$uid'");
        $db->insert("message","companyid,workerid,clientid,addtime,content,action","$cid|$wid|$uid|$now||4");
      }
      break;
    case'limit':
      $wid=$o[2];
      $uid=$o[3];
      $s=$o[4]=='1'?'-1':'0';
      $db->update("client","status",$s,"companyid='$cid' and id=".intval($uid));
      if($s=='-1'){
        $db->insert("message","companyid,workerid,clientid,addtime,content,action",$cid.'|'.$wid.'|'.$uid."|$now|eqmk://system.close|1");
      }
      break;
    case "myinput"://客服输入状态
      $wid=$o[2];
      $uid=$o[3];
      writeover('../../eqmkdata/cache/'.$cid.'_wid_'.$wid.'_'.$uid.'.txt','');
      $fdata=urlencode('&cmd=myinput&fdata=Y');
      break;
  }
  print('&fdata='.$fdata);
}
?>