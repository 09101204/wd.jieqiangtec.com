<?
include_once '../../include/common.inc.php';
$datatype=Char_Cv("datatype","get");
if($datatype=='get')$_POST=$_GET;
$action=Char_Cv("action");
$cid=Char_Cv("cid");
switch($action){
  case "init"://初始化链接
    print('&fdata=Y');
    break;
  case "update"://监控页更新
    $wid=Char_Cv("im_wid");
    $im_sessionid=Char_Cv("im_sessionid");
    $im_count=Char_Cv("im_count");
    $im_thecount=Char_Cv("im_thecount");
    $im_systemlanguage=Char_Cv("im_systemlanguage");
    $im_color=Char_Cv("im_color");
    $im_screensize=Char_Cv("im_screensize");
    $im_charset=Char_Cv("im_charset");
    $im_pageurl=unescape(Char_Cv("im_pageurl"));
    $im_referer=unescape(Char_Cv("im_referer"));
    $im_pageurl=utf82gbk($im_pageurl);
    $im_referer=utf82gbk($im_referer);
    $address=getaddress($onlineip,true);
    $thesoft=$_SERVER["HTTP_USER_AGENT"];//浏览器
    switch(true){
      case stripos($thesoft,"SE"):
        $vsoft="Sogou";
        break;
      case stripos($thesoft,"360SE"):
        $vsoft="360SE";
        break;
      case stripos($thesoft,"TheWorld"):
        $vsoft="TheWorld";
        break;
      case stripos($thesoft,"MAXTHON"):
        $vsoft="MAXTHON";
        break;
      case stripos($thesoft,"TencentTraveler"):
        $vsoft="TencentTraveler";
        break;
      case stripos($thesoft,"NetCaptor"):
        $vsoft="NetCaptor";
        break;
      case stripos($thesoft,"MSIE 8"):
        $vsoft="MSIE 8.x";
        break;
      case stripos($thesoft,"MSIE 7"):
        $vsoft="MSIE 7.x";
        break;
      case stripos($thesoft,"MSIE 6"):
        $vsoft="MSIE 6.x";
        break;
      case stripos($thesoft,"MSIE 5"):
        $vsoft="MSIE 5.x";
        break;
      case stripos($thesoft,"MSIE 4"):
        $vsoft="MSIE 4.x";
        break;
      case stripos($thesoft,"Netscape"):
        $vsoft="Netscape";
        break;
      case str_ireplace("Opera","",$thesoft)==$thesoft:
        $vsoft="Opera";
        break;
      case stripos($thesoft,"Firefox/3"):
        $vsoft="Firefox 3";
        break;
      case stripos($thesoft,"Firefox/2"):
        $vsoft="Firefox 2";
        break;
      case stripos($thesoft,"Chrome"):
        $vsoft="Google Chrome";
        break;
      case stripos($thesoft,"Safari"):
        $vsoft="Safari";
        break;
      default:
        $vsoft=$_SERVER["HTTP_USER_AGENT"];
        break;
    }
    $vsoft=preg_replace("/MSIE ([0-9]).x/","Internet Explorer $1",$vsoft);
    switch(true){//操作系统
      case strpos($thesoft,"Windows NT 5.0"):
        $os="Win 2000";
        break;
      case strpos($thesoft,"Windows NT 5.1"):
        $os="Win XP";
        break;
      case strpos($thesoft,"Windows NT 5.2"):
        $os="Win 2003";
        break;
      case strpos($thesoft,"Windows NT"):
        $os="Windows NT";
        break;
      case strpos($thesoft,"Win 9x"):
        $os="Win 9x";
        break;
      case strpos($thesoft,"类Unix"):
        $os="类Unix";
        break;
      case strpos($thesoft,"Mac"):
        $os="Mac";
        break;
      default:
        $os="Other";
        break;
    }
    include("../../eqmkdata/sort.inc.php");//省份
    if(is_array($Province)){
      foreach($Province as $k=>$v){
        if(substr($address,0,strlen($v[0]))==$v[0]){
          $prov=$k;
          break;
        }
      }
    }
    //搜索引擎
    foreach($Search as $k=>$v){
      if(strpos($im_referer,$v[2])){
        $searchname=$k;
        $o=explode(',',$v[3]);
        for($i=0;$i<count($o);$i++){
          if(preg_match("/".$o[$i]."([^&]+)/",$im_referer,$match)){
            $keyword=urldecode($match[1]);
            break;
          }
        }
      }
    }
    $db->update("client","companyid,clientid,browser,os,prov,systemlanguage,color,screen,charset,thispage,comeurl,ip,address,keyword,search,addtime,lasttime,status,workerid","$cid|$im_sessionid|$vsoft|$os|$prov|$im_systemlanguage|$im_color|$im_screensize|$im_charset|$im_pageurl|$im_referer|$onlineip|$address|$keyword|$searchname|$time|$time|1|$wid","companyid='$cid' and clientid='$im_sessionid'");
    $uid=$db->select("client","id","companyid='$cid' and clientid='$im_sessionid'");
    $uid=GetId($uid,7);
    //访客更换页面以后删除旧消息
    if($db->rows("dialog","companyid='$cid' and clientid='$uid'")==0){
      $db->delete("message","companyid='$cid' and clientid='$uid' and (action='1' or action='4')");
    }
    print("im_uid='$uid';\n");
    break;
  case "newGet"://自动邀请
    print('&fdata=');
    $uid=Char_Cv("uid");
    $invite=Char_Cv("invite");
    $db->update("client","lasttime",$time,"companyid='$cid' and id=".intval($uid));
    //if($invite=='0'){
      if($db->rows("dialog","companyid='$cid' and clientid='$uid'")>0)exit();//访客已开始对话
      $message=$db->record("message","id,workerid,content","companyid='$cid' and clientid='$uid' and content<>'eqmk://system.close' and action='1'",1);
      if($message){
        $id=$message[0]['id'];
        $wid=$message[0]['workerid'];
        $index=-1;
        if(strpos($wid,',')){
          $o=explode(',',$wid);
          $wid=$o[0];
          $index=$o[1];
        }
        $wname=$db->select("worker","nickname","companyid='$cid' and id=$wid");
        if($index!=-1 && strpos($wname,',')){
          $o=explode(',',$wname);
          $wname=$o[$index];
          $wid.=','.$index;
        }
        $content=$message[0]['content'];
        $db->delete("message","companyid='$cid' and id=$id");
        print("###$wid###$wname###$content");
      }
    //}
    exit();
    break;
  case "newGet2"://自动邀请
    $uid=Char_Cv("uid");
    $db->update("client","lasttime",$time,"companyid='$cid' and id=".intval($uid));
    if($db->rows("dialog","companyid='$cid' and clientid='$uid'")>0)exit();//访客已开始对话
    $message=$db->record("message","id,workerid,content","companyid='$cid' and clientid='$uid' and content<>'eqmk://system.close' and action='1'",1);
    if($message){
      $id=$message[0]['id'];
      $wid=$message[0]['workerid'];
      $index=-1;
      if(strpos($wid,',')){
        $o=explode($wid,',');
        $wid=$o[0];
        $index=$o[1];
      }
      $wname=$db->select("worker","nickname","companyid='$cid' and id=$wid");
      if($index!=-1 && strpos($wname,',')){
        $o=explode($wname,',');
        $wname=$o[$index];
        $wid.=','.$index;
      }
      $content=$message[0]['content'];
      $db->delete("message","companyid='$cid' and id=$id");
      print("
im_wid=$wid;
$('invite_top_center').innerHTML='$wname:';
$('invite_text').innerHTML='".str_replace("'","\'",$content)."';
NewInvite();
    ");
    }
    exit();
    break;
  case "notagree"://自动邀请
    print('&fdata=');
    $wid=Char_Cv("wid");
    $uid=Char_Cv("uid");
    $wid=$db->select("message","workerid","companyid='$cid' and clientid='$uid'");
    $db->delete("message","companyid='$cid' and clientid='$uid'");
    $db->insert("message","companyid,workerid,clientid,addtime,content,action",$cid.'|'.$wid.'|'.$uid."|$now|eqmk://system.notagree|2");
    exit('Y');
    break;
  case "tmpInput"://输入监控
    print('&fdata=');
    $uid=Char_Cv("uid");
    $msg=Char_Cv("content1");
    $msg=utf82gbk($msg);
    writeover('../../eqmkdata/cache/'.$cid.'_'.$uid.'.txt',$msg);
    exit("Y");
    break;
  case "faq"://自动应答
    $fid=Char_Cv("fid");
    $uid=Char_Cv("uid");
    $faq=$db->record("faq","title,content","companyid='$cid' and id=$fid");
    if(!$faq){
      $fdata="&fdata=<div>很抱歉，没有找到您要查询的答案</div>";
    }else{
      $fdata='&fdata=<div style="font-size:13px"><br /><b>问:'.$faq[0]['title'].'</b></div><div><b>答:</b>'.$faq[0]['content'].'</div>';
    }
    print($fdata);
    exit();
    break;
  case "pingfen"://客服评分
    $wid=Char_Cv("wid");
    $uid=Char_Cv("uid");
    $fen=Char_Cv("fen")?Char_Cv("fen"):Char_Cv("fid");
    if($db->rows("pingfen","companyid='$cid' and ip='$onlineip' and addtime>".($time-86400)))exit("&fdata=N");
    if($fen==0){
      $db->query("update {$tbl}setting set comment=comment+1 where companyid='$cid'");
    }elseif($fen==4){
      $db->query("update {$tbl}setting set comment=comment-1 where companyid='$cid'");
    }
    $db->insert("pingfen","companyid,workerid,clientid,fen,ip,addtime","$cid|$wid|$uid|$fen|$onlineip|$time");
    exit("&fdata=Y");
    break;
  case "send"://发送消息
    $wid=Char_Cv("wid");
    $wname=Char_Cv("wname");
    $uid=$uid2=Char_Cv("uid");
    $fdata=Char_Cv("content1");
    $wname=utf82gbk($wname);
    $fdata=utf82gbk($fdata);
    $fdata=eqmkcode($fdata);
    $fdata=preg_replace("/:([a-zA-Z]+)_([0-9]{1,2})/",'<img src="'.$homepage.'images/smiley/$1/s_$1_$2.gif">',$fdata);
    $fdata=str_replace('"','\"',$fdata);
    $fdata=str_replace('\\"','\"',$fdata);
    if(!$wid)exit("N");
    if($fdata=='')exit("Y");
    if(strpos($wid,',')){
      $o=explode(',',$wid);
      $wid=$o[0];
      $uid2=$uid.','.$o[1];
    }
    $db->insert("message","companyid,workerid,clientid,action,content,addtime","$cid|$wid|$uid2|2|$fdata|$now");
    $db->insert("history","companyid,workerid,workername,clientid,clientname,action,content,addtime","$cid|$wid|$wname|$uid||2|$fdata|$now");
    @unlink('../../eqmkdata/cache/'.$cid.'_'.$uid.'.txt');
    exit("&fdata=Y");
    break;
  case "get"://读取信息
    $uid=Char_Cv("uid");
    $wid=Char_Cv("wid");
    $t=Char_Cv("t");
    if(!$uid)exit;
    $db->update("dialog","time2","$time","companyid='$cid' and clientid='$uid'");
    $db->update("client","lasttime,workerid","$time|$wid","companyid='$cid' and id=".intval($uid));
    $message=array();
    $message[]=time()-@filemtime('../../eqmkdata/cache/'.$cid.'_wid_'.$wid.'_'.$uid.'.txt')<5?'Y':'N';
    if($Msg=$db->record("message","content,addtime,action,workerid","companyid='$cid' and clientid='$uid' and (action='1' or action='4') order by addtime asc")){
      foreach($Msg as $rs){
        if($rs["action"]=='4'){
          $wname=$db->select("worker","nickname","companyid='$cid' and id=".$rs["workerid"],1);
          if(!$wname)$wname=$rs["workerid"];
          $message[]=$wname.'{|}'.'您的对话已转移至“'.$wname.'”{|}'.$rs["action"].'{|}'.$rs["workerid"];
        }else{
          $message[]=$rs["addtime"].'{|}'.$rs["content"].'{|}'.$rs["action"].'{|}'.$rs["workerid"];
        }
      }
      $db->delete("message","companyid='$cid' and clientid='$uid' and action='1' or action='4'");
    }
    print("&fdata=");
    print(str_replace("&","＆",implode('{@}',$message)));
    exit();
    break;
  case "bye"://读取信息
    $uid=Char_Cv("uid");
    $wid=Char_Cv("wid");
    if(!$uid)exit;
    $db->delete("dialog","companyid='$cid' and clientid='$uid'");
    exit;
    $db->insert("message","companyid,workerid,clientid,addtime,content,action",$cid.'|'.$wid.'|'.$uid."|$now|eqmk://system.close|2");
    exit("Y");
    break;
}
?>