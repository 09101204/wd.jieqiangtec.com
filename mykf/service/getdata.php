<?
define('NOTCLOSE', TRUE);
include_once("check.php");
#$debug=true;
$token=Char_Cv('token');
$msg=Char_Cv('msg');
if($debug)writeover('debug.txt',"[$now]token=$token;msg=$msg\n","a");
if($token){
  $o=explode(',',$token);
  if($o[0]=='worker'){
    $cid=$o[1];
    $wid=$o[2];
    $lt=$o[3];
    if($time % 3==0){
      $db->delete("dialog","companyid='$cid' and time2<".($time-60));
      $db->update("worker","online","0","companyid='$cid' and lasttime<".($time-60));
      $user=array();
      $Icon=array('-2'=>'offline','-1'=>'offline','0'=>'offline','1'=>'online','2'=>'online','3'=>'online');
      if($w=$db->record("worker","id,nickname,online,realname","companyid='$cid' and id<>$wid")){
        foreach($w as $rs){
          $user[]="1|" .$rs['id'] . "|" .$rs['nickname'] . "|" .$rs['online'] . "|" .$Icon[$rs['online']] . "|" .$rs['realname'];
        }
      }
      if($online=$db->record("client","id,thispage,ip,address","companyid='$cid' and status<>-1 and status<>-2 and (workerid='' or workerid='$wid') and lasttime>".($time-60),20)){
        foreach($online as $rs){
          $uid=GetId($rs['id'],7);
          $input=@readover('../eqmkdata/cache/'.$cid.'_'.$uid.'.txt');
          if($input=='EQMK_COM_WINDOW_QUAKE')writeover('../eqmkdata/cache/'.$cid.'_'.$uid.'.txt','');
          $user[]="2|" .$rs['id']."|" .$uid."|".$rs['ip']."|".$rs['address']."|".urldecode($rs['thispage'])."|".escape($input);
        }
      }
      $fdata=implode("<E>",$user);
      $fdata=escape($fdata);
      $fdata=urlencode("&cmd=list&fdata=$fdata");
    }else{
      if(!$wid)exit('&fdata='.urlencode('&cmd=get&fdata='.escape("0<E>Timeout!<E>$time<E>5<E><E>")));
      if(readover('../eqmkdata/cache/__system_login_'.$wid.'.txt')!=$lt){
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
      $fdata=escape($fdata);
      $fdata=urlencode("&cmd=get&fdata=$fdata");
    }
  }
  print('&fdata='.$fdata);
}elseif($msg){
  $o=explode(',',$msg);
  $cid=$o[1];
  switch($o[0]){
    case'loadinfo':
      if($o[2]=='w'){
        $id=$o[3];
        $Worker=$db->record("worker","mq,nickname,sex,city,phone,email,qq,content,realname","companyid='$cid' and id=$id",1);
        $O=$Worker[0];
        $tmp='<div style="text-align:center;padding:20px"><img src="../soft/face.php?id='.$id.'" onload="if(this.width>100)this.width=100"/></div>
<ul class="userinfo">
<li><span>'.$language['022'].'</span><font color="red">'.$language['023'].'</font></li>
<li><span>'.$language['024'].'</span><u>'.$O['mq'].'</u></li>
<li><span>'.$language['025'].'</span>'.$O['realname'].'</li>
<li style="padding-left:10px">'.$O['nickname'].'</li>
<li><span>'.$language['026'].'</span>'.$O['sex'].'</li>
<li><span>'.$language['027'].'</span>'.$O['city'].'</li>
<li><span>'.$language['008'].'</span>'.$O['phone'].'</li>
<li><span>'.$language['028'].'</span>'.$O['email'].'</li>
<li><span>'.$language['009'].'</span>'.$O['qq'].'</li>
<li><span>'.$language['029'].'</span>'.$O['content'].'</li>
</ul>';
        $fdata=urlencode('&cmd=loadinfo&fdata='.escape($tmp));
      }elseif($o[2]=='u'){
        $id=$o[3];
        $Client=$db->record("client","browser,os,systemlanguage,color,screen,charset,thispage,comeurl,ip,address,keyword,search,addtime,lasttime,keyword,workerid,status","companyid='$cid' and id=$id",1);
        $O=$Client[0];
        $wid=$O['workerid'];
        if($wid){
          $w=$db->select('worker','nickname',"companyid='$cid' and id=$wid");
        }else{
          $w=$language['030'];
        }
        $uid=GetId($id,7);
        $limit=$O['status']==-1?'<a href="#" onclick="SetLimit(\''.$uid.'\',0)">'.$language['031'].'</a>':'<a href="#" onclick="SetLimit(\''.$uid.'\',1)">'.$language['032'].'</a>';
        $tmp='<ul class="userinfo">
<li><span>'.$language['022'].'</span><font color="red">'.$language['033'].'</font></li>
<li><span>'.$language['006'].'</span><u>'.$uid.'</u> ['.$limit.']</li>
<li><span>'.$language['012'].'</span>'.$O['ip'].'</li>
<li><span>'.$language['034'].'</span>'.$O['address'].'</li>
<li><span>'.$language['035'].'</span><a href="'.$O['thispage'].'" target="_blank">'.$O['thispage'].'</a></li>
<li><span>'.$language['036'].'</span>'.date('Y-m-d H:i:s',$O['lasttime']).'</li>
<li><span>'.$language['037'].'</span><a href="'.$O['comeurl'].'" target="_blank">'.$O['comeurl'].'</a></li>
<li><span>'.$language['038'].'</span>'.$O['keyword'].'</li>
<li><span>'.$language['039'].'</span>'.$O['os'].'</li>
<li><span>'.$language['040'].'</span>'.str_replace('Internet Explorer','IE',$O['browser']).'</li>
<li><span>'.$language['041'].'</span>'.$O['screen'].'</li>
<li><span>'.$language['042'].'</span>'.$O['color'].'</li>
<li><span>'.$language['043'].'</span>'.$O['systemlanguage'].'</li>
<li><span>'.$language['044'].'</span>'.$O['charset'].'</li>
<li><span>'.$language['045'].'</span>'.$w.'</li>
</ul>';
        $fdata=urlencode('&cmd=loadinfo&fdata='.escape($tmp));
      }
      break;
    case'send':
      $wid=$wid2=$o[2];
      $utype=$o[3];
      $uid=$o[4];
      $uname=unescape($o[5]);
      $uname=eqmkcode($uname);
      $fdata=unescape($o[6]);
      $fdata=eqmkcode($fdata);
      $fdata=preg_replace("/:([a-zA-Z]+)_([0-9]{1,2})/",'<img src="'.$homepage.'images/smiley/$1/s_$1_$2.gif">',$fdata);
      $fdata=str_replace('"','\"',$fdata);
      $fdata=str_replace('\\"','\"',$fdata);
      if($utype=="p"){
        if($w=$db->record("worker","id","companyid='$cid' and id<>$wid and online>0")){
          foreach($w as $rs){
            $db->insert("message","companyid,workerid,clientid,action,content,addtime",$cid.'|'.$rs['id']."|$wid|6|$fdata|$now");
          }
        }
      }elseif($utype=="w"){
        $db->insert("message","companyid,workerid,clientid,action,content,addtime","$cid|$uid|$wid|3|$fdata|$now");
        $db->insert("history","companyid,workerid,workername,clientid,clientname,action,content,addtime","$cid|$uid|$uname|$wid||3|$fdata|$now");
      }elseif($utype=="u" || substr($utype,0,2)=='C&'){
        if(substr($utype,0,2)=='C&'){
          $o=explode('&',$utype);
          $wid2=$wid.','.$o[1];
          $utype='1';
        }
        $db->insert("message","companyid,workerid,clientid,action,content,addtime","$cid|$wid2|$uid|1|$fdata|$now");
        $db->insert("history","companyid,workerid,workername,clientid,clientname,action,content,addtime","$cid|$wid|$uname|$uid||1|$fdata|$now");
      }
      @unlink('../../eqmkdata/cache/'.$cid.'_wid_'.$wid.'_'.$uid.'.txt');
      $fdata=urlencode('&cmd=loadinfo&fdata=Y');
      break;
    case'regchange':
      $wid=$o[2];
      $uid=$o[3];
      $toid=$o[4];
      $db->insert("message","companyid,workerid,clientid,addtime,content,action","$cid|$toid|$wid|$now|eqmk://system.regchange.$uid|3");
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
      $uid=$o[3];
      $s=$o[4]=='1'?'-1':'0';
      $db->update("client","status",$s,"companyid='$cid' and id=".intval($uid));
      $db->insert("message","companyid,workerid,clientid,addtime,content,action",$cid.'|'.$wid.'|'.$uid."|$now|eqmk://system.close|1");
      break;
    case "myinput"://¿Í·þÊäÈë×´Ì¬
      $wid=$o[2];
      $uid=$o[3];
      writeover('../eqmkdata/cache/'.$cid.'_wid_'.$wid.'_'.$uid.'.txt','');
      exit();
      break;
  }
  print('&fdata='.$fdata);
}
?>