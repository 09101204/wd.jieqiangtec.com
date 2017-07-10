<?
define('IN_KEFU', TRUE);
include_once("include/common.inc.php");
$cid=Char_Cv("cid","get");
function GetFreeWorker($online){
  global $db,$cid;
  $xxx=$online==0?"":" and online=$online";
  $TalkCount=array();
  $Worker=$db->record("worker","id","companyid='$cid' and isshow=1".$xxx);
  foreach($Worker as $rs){//循环得到客服当前对话数量
    $TalkCount[$rs['id']]=$db->rows("dialog","companyid='$cid' and workerid=".$rs['id']);
    if($TalkCount[$rs['id']]==0)break;//有空闲客服退出循环
  }
  //得到对话数量最少的客服
  if(count($TalkCount)>0){
    asort($TalkCount);
    reset($TalkCount);
    $wid=key($TalkCount);
  }
  return $wid;
}
function RndSel(){//随机选择客服
  $wid=GetFreeWorker(1);
  if(!$wid)$wid=GetFreeWorker(3);//忙碌
  if(!$wid)$wid=GetFreeWorker(2);//离开
  if(!$wid)$wid=GetFreeWorker(-1);//隐身
  if(!$wid)$wid=GetFreeWorker(0);//离线
  if(!$wid)$wid=0;//无客服
  return $wid;
}
if($mod=Char_Cv("mod","get")){
  switch($mod){
    case "im"://调用代码
      if(strtolower(Char_Cv('charset','get'))=='utf-8')header("Content-type: text/html; charset=utf-8");
      if(!$cid)die('fail');
      $db->update("worker","online","0","companyid='$cid' and lasttime<".($time-20));
      $type=Char_Cv("type","get");
      if($type=='pic'){
        $wid=Char_Cv("wid","get");
        $icon=Char_Cv("icon","get");
        if(!$icon)$icon='004';
        if(CheckGrade('super')){
          $index=0;
          if($wid && !is_numeric($wid)){
            $o=explode(',',$wid);
            if(count($o)==1){
              $wid=$o[0];
              $index=$o[1];
            }
          }else{
            if(!$wid || !is_numeric($wid))$wid=RndSel();
          }
        }
        $online=$db->select("worker","online","companyid='$cid' and id=$wid");
        header('Content-Type: image/gif');
        $tmp=@readover("skins/kefu/icon/$icon/".($online ? 'online' : 'offline').".gif");
        echo $tmp;
        exit;
      }
      $sessionid=$_SESSION['eqmk_com_client_tmpid'];
      if(!$sessionid){
        $sessionid=$_COOKIE['eqmk_com_client_tmpid'];
        if(!$sessionid){
          $sessionid=random(28);
          dsetcookie('client_tmpid',$sessionid,86400*365);
        }
      }
      if($a=$db->record("client","id","companyid='$cid' and clientid='$sessionid'",1)){
        $uid=GetId($a[0]['id'],7);
      }else{
        $address=getaddress($onlineip,true);
        $db->insert("client","companyid,clientid,ip,address,addtime,lasttime","$cid|$sessionid|$onlineip|$address|$time|$time");
        $u=$db->record("client","id","companyid='$cid' and clientid='$sessionid'",1);
        $uid=GetId($u[0]['id'],7);
      }
      $client_status=$db->select("client","status","companyid='$cid' and clientid='$sessionid'");
      if($client_status==-1)exit();//已屏蔽此人
      
      $setting=$db->record("setting","delay,grade,invitetitle,invitecontent,autoinvite,effect,opennew,urlkg,url","companyid='$cid'",1);
      $Grade=explode(',',$setting[0]['grade']);
      $delay=$setting[0]['delay'];
      $invitetitle=$setting[0]['invitetitle'];
      $invitecontent=$setting[0]['invitecontent'];
      $autoinvite=$setting[0]['autoinvite'];
      $effect=$setting[0]['effect'];
      $opennew=$setting[0]['opennew'];
      $urlkg=$setting[0]['urlkg'];
      $url=$setting[0]['url'];
      if(!CheckGrade('invite')||$autoinvite==0){
        $autoinvite='';
      }else{
        $autoinvite='Y';
      }
      if(!is_numeric($delay))$delay=0;
      $delay = is_numeric($delay) ? intval($delay) : 0;
      $w=$db->record("worker","id,online,nickname,updatetime","companyid='$cid' and id=".RndSel(),1);
      $wid=$w[0]['id'];
      $nickname=$w[0]['nickname'];
      if(CheckGrade('super')){
        if(strpos($nickname,',')){
          $o=explode(',',$nickname);
          if(!$index)$index=0;
          if($index>=count($o))$index=count($o)-1;
          $nickname=$o[$index];
        }
      }
      if($type=="list"||$type=="icon"||$type=="image"){
        $file="code.inc.php";
        $icon2=$homepage."images/kefu/002.gif";
        $tip_center_skin="001";
        $tip_rightbottom_skin="QQ";
        $button1=$homepage."skins/kefu/tip/center/$tip_center_skin/accept.gif";
        $button2=$homepage."skins/kefu/tip/center/$tip_center_skin/next.gif";
        if($db->rows("style","companyid='$cid'")==0)$db->insert("style","companyid,posx,x,posy,y,iconstyle,liststyle,tipstyle,dialogstyle","$cid|right|0|top|0|001|QQ2006|001|blue");
        if($c=$db->record("style","caption,posx,posy,x,y,iconstyle,liststyle,tipstyle","companyid='$cid'",1)){
          $posx=$c[0]["posx"];
          $x=$c[0]["x"];
          $posy=$c[0]["posy"];
          $y=$c[0]["y"];
          $tipstyle=$c[0]["tipstyle"];
          $imtitle=myutf8($c[0]["caption"]);
          $tippos=in_array($tipstyle,array('001')) ? "center" : "bottom";
        }
        if($w[0]['updatetime']<$time-5 && $setting[0]['autoinvite']!=2)$autoinvite='';
      }
      //转换邀请字符
      $invitetitle=myutf8(EqmkVars($setting[0]['invitetitle']));
      $invitecontent=myutf8(EqmkVars($setting[0]['invitecontent']));
      
      $InviteIndex=$setting[0]['autoinvite'];
      if($InviteIndex==3)$autoinvite='';
      $skins=$c[0]["liststyle"];
      switch($type){
        case "list"://列表
          $icon=$homepage."images/kefu/001.gif";
          $face1=$homepage."skins/kefu/list/".$skins."/online.gif";
          $face2=$homepage."skins/kefu/list/".$skins."/offline.gif";
          $workersort=$db->record("workersort","id,sort","companyid='$cid' order by taxis asc");
          $worker=array();
          if(!$workersort)$workersort=array();
          foreach($workersort as $rs){
            if(CheckGrade('super')){
              $wlist=array();
              $w=$db->record("worker","id,nickname,password,updatetime,username","companyid='$cid' and sortid=".$rs["id"]." and isshow=1 order by taxis asc");
              foreach($w as $r){
                $o=explode(',',myutf8($r['nickname']));
                for($i=0;$i<count($o);$i++){
                  $wlist[]=array('id'=>$r['id'].','.$i,'nickname'=>$o[$i],'password'=>$r['password'],'updatetime'=>$r['updatetime'],'username'=>$r['username']);
                }
              }
              $worker[]=array(myutf8($rs["sort"]),$wlist);
            }else{
              $worker[]=array(myutf8($rs["sort"]),$db->record("worker","id,nickname,password,updatetime,username","companyid='$cid' and sortid=".$rs["id"]." and isshow=1 order by taxis asc"));
            }
          }
          unset($workersort);
          break;
        case "icon"://图标
          $icon=$c[0]["iconstyle"];
          if(!$icon)$icon="001";
          if($db->rows("worker","companyid='$cid' and updatetime>$time-5")){
            $icon=$homepage."skins/kefu/icon/".$icon."/online.gif";
          }else{
            $icon=$homepage."skins/kefu/icon/".$icon."/offline.gif";
          }
          break;
        case "image"://嵌入固定图片
          $icon=$c[0]["iconstyle"];
          if(!$icon)$icon="001";
          if($db->rows("worker","companyid='$cid' and updatetime>$time-5")){
            $icon="";
          }else{
            $icon="";
          }
          break;
      }
      $mtime_swf=GetmTime("eqmkdata/update.swf");
      if($mtime_swf)$mtime_swf="?".$mtime_swf;
      unset($c);
      break;
    case "client"://对话框
      include_once('eqmkdata/sort.inc.php');
      $file="client.inc.php";
      $mq=Char_Cv("mq","get");
      if(is_numeric($mq) && $mq>$MQStart){
        $w=$db->record("worker","companyid,id","mq=$mq");
        $cid=$w[0]['companyid'];
        $wid=$w[0]['id'];
      }else{
        $wid=Char_Cv("wid","get");
      }
      $index=0;
      if($wid && !is_numeric($wid)){
        $o=explode(',',$wid);
        if(count($o)==2){
          $wid=$o[0];
          $index=$o[1];
        }
      }
      $uid=Char_Cv("uid","get");
      $sessionid=$_SESSION['eqmk_com_client_tmpid'];
      if(!$sessionid){
        $sessionid=$_COOKIE['eqmk_com_client_tmpid'];
        if(!$sessionid){
          $sessionid=random(28);
          dsetcookie('client_tmpid',$sessionid,86400*365);
        }
      }
      
      $setting=$db->record("setting","company,keywords,description,dialogad,dialoglogo,dialoglogourl,grade,dialogtitle,dialoginfotitle,autofaq,allowpingfen,language,dialogsort,companyinfo","companyid='$cid'",1);
      $Grade=explode(',',$setting[0]['grade']);
      $company=$setting[0]['company'];
      $keywords=$setting[0]['keywords'];
      $description=$setting[0]['description'];
      $dialogad=$setting[0]['dialogad'];
      $dialogtitle=$setting[0]['dialogtitle'];
      $dialoginfotitle=$setting[0]['dialoginfotitle'];
      $autofaq=$setting[0]['autofaq'];
      $allowpingfen=$setting[0]['allowpingfen'];
      $language_dialog=$setting[0]['language'];
      $dialogsort=$setting[0]['dialogsort'];
      $companyinfo=$setting[0]['companyinfo'];
      if(!$language_dialog)$language_dialog=$lang_dialog;
      include_once('language/'.$language_dialog.'/dialog.php');
      if(!CheckGrade('delad'))$dialogad=$default_dialogad;
      if(CheckGrade('mylogo')){//自定义LOGO
        if($setting[0]['dialoglogo'])$dialoglogo=$setting[0]['dialoglogo'];
        if($setting[0]['dialoglogourl'])$dialoglogourl=$setting[0]['dialoglogourl'];
      }
      if(!$dialogsort)$dialogsort='问题反馈｜代理加盟｜服务支持｜购买产品';
      $d_sort='<select name="sort">';
      foreach(explode('｜',$dialogsort) as $v){
        if($v){
          $d_sort.='<option value="'.$v.'">'.$v.'</option>';
        }
      }
      $d_sort.='</select>';
      $dialogsort=$d_sort;
      $allowfiletype=str_replace('|','&nbsp;',$allowfiletype);
      if($allowpingfen){
        for($i=0;$i<5;$i++){
          $pingfens.='<input type="radio" id="myfen" name="myfen" style="border:0" value="'.$i.'" '.($i==2 ? 'checked':'').'>'.$language['pingfen_'.$i.''].' ';
        }
      }
      
      if(!$uid){//解析访客临时编号
        $uid=$_COOKIE['eqmk_com_client_tmpid'];
        if(!$uid){
          $uid=random(28);
          dsetcookie('client_tmpid',$uid,86400*365);
        }
      }
      if(!$uid)exit('Not Support Cookie!');
      if($a=$db->record("client","id","companyid='$cid' and clientid='$uid'",1)){
        $uid=GetId($a[0]['id'],7);
      }else{
        $address=getaddress($onlineip,true);
        $db->insert("client","companyid,clientid,ip,address,addtime,lasttime","$cid|$uid|$onlineip|$address|$time|$time");
        $u=$db->record("client","id","companyid='$cid' and clientid='$uid'",1);
        $uid=GetId($u[0]['id'],7);
      }
      
      if(!$wid || !is_numeric($wid))$wid=RndSel();//如没有指定客服，自动选择
      
      //将该访客加入恰谈队列
      if($db->rows("dialog","companyid='$cid' and clientid='$uid'")==0){
        $db->insert("dialog","companyid,workerid,clientid,time1,time2","$cid|$wid|$uid|$time|$time");
      }

      $w=$db->record("worker","qq,mq,email,sex,city,phone,nickname,online,content,onlinetitle,onlinetip,offlinetitle,offlinetip,closetip,Favorite,FavoriteUrl,FavoriteName,updatetime","companyid='$cid' and id=$wid",1);
      if(!$w)die('Illegal sources');
      foreach($w[0] as $k=>$v){
        $$k=$v;
      }
      $im=$qq;
      $content=str_replace('%D%A','<br>',eqmkcode($content));
      $online=$updatetime>$time-5 ? true : false;
      

      if(CheckGrade('super')){
        if(strpos($nickname,',')){
          $kefuindex=$wid.'&'.$index;
        }
      }

      $wlist=array();
      $kefuindex=0;
      $w=$db->record("worker","id,nickname,qq,email,sex,city,phone,content,updatetime","companyid='$cid' and isshow=1 order by taxis asc");
      foreach($w as $r){
        $o=explode(',',$r['nickname']);
        $r['content']=str_replace("'","\'",$r['content']);
        for($i=0;$i<count($o);$i++){
          $t=$r;
          $t['id']=$r['id'].','.$i;
          $t['nickname']=$o[$i];
          if(count($o)>0){
            if($p=$db->record("worker","qq,mq,email,sex,city,phone,content,updatetime","companyid='$cid' and nickname='".$o[$i]."' order by isshow=0",1)){
              $v_['content']=str_replace("'","\'",$v_['content']);
              foreach($p[0] as $k_=>$v_){
                $t[$k_]=$v_;
              }
            }
          }
          $wlist[]=$t;
          if($wid==$r['id'] && $i==$index){
            $kefuindex=$i;
            $nickname=$t['nickname'];
          }
        }
      }
      
      $client_status=$db->select("client","status","companyid='$cid' and clientid='$uid'");
      if($client_status==-1)exit('Unwelcome');//已屏蔽此人
      
      if($online>0){//在线
        $tiptitle=$onlinetitle;
        $tip=$onlinetip;
      }else{
        $tiptitle=$offlinetitle;
        $tip=$offlinetip;
      }
      $tiptitle.=' ('.$language['id'].($MQStart+$wid).','.$language['name'].'<span id="workername">'.$nickname.'</span>)';
      
      //自动应答
       if(($autofaq==1 &&$online) || $autofaq==2){
        $faq=$db->record("faq","id,title","companyid='$cid' order by id asc");
        $FAQ='';$i=0;
        foreach($faq as $rs){
          $i++;
          $FAQ.=$i.'、<span class="faq_ti" onclick="selfaq('.$rs['id'].')">'.$rs['title'].'</span><br />';
        }
        if($FAQ)$tip.='<br /><br />'.str_replace('"','\"',$FAQ);
      }
      
      $filetype=str_replace('|',' ',$allowfiletype);
      $myname=$language['you'];
      if($style=$db->record("style","dialogstyle","companyid='$cid'",1)){
        $dialogstyle=$style[0]['dialogstyle'];
      }
      if(!$dialogstyle)$dialogstyle='blue';
      $css1="skins/kefu/dialog/dialog.css";
      $mtime_css1=GetmTime("skins/kefu/dialog/dialog.css");
      if($mtime_css1)$mtime_css1="?".$mtime_css1;
      $css2="skins/kefu/dialog/$dialogstyle/style.css";
      $mtime_css2=GetmTime("skins/kefu/dialog/$dialogstyle/style.css");
      if($mtime_css2)$mtime_css2="?".$mtime_css2;
      $mtime_swf=GetmTime("eqmkdata/client.swf");
      if($mtime_swf)$mtime_swf="?".$mtime_swf;
      $webtitle=$company;
      break;
	  
case "card" :
	$wid = char_cv( "wid", "get" );
	if ( !$wid )
	{
					exit( "ERROR1" );
	}
	include_once( "include/db_mysql.class.php" );
	$KF = $db->record("worker","id,nickname,qq,email,sex,city,phone,content,updatetime","id='{$wid}'" );
	if ( !$KF )
	{
					exit( "ERROR2" );
	}
	$KF = $KF[0];
	$tmpdata = "BEGIN:VCARD\r\nVERSION:2.1\r\nN:;;;\r\nFN:{$KF['nickname']}\r\nORG:{$setting['homename']};\r\nTITLE:\r\nTEL;WORK;VOICE:{$KF['phone']}\r\nADR;WORK:;;;{$KF['city']};;;?D1ú\r\nURL;HOME:{$homepage}\r\nBDAY:0\r\nEMAIL;PREF;INTERNET:{$KF['email']}\r\nX-QQ:{$KF['qq']}\r\nEND:VCARD\r\n";
	header( "Cache-control: max-age=31536000" );
	header( "Content-Encoding: none" );
	header( "Content-Disposition: attachment; filename=".$KF['nickname'].".vcf" );
	header( "Content-Type: file" );
	exit( $tmpdata );
    case "demo"://演示
      if(!$cid)die('fail');
      $type=Char_Cv("type","get");
      $wid=Char_Cv("wid","get");
      $charset=strtolower(Char_Cv('charset','get'));
      if($charset!='utf-8'){
        $charset='gb2312';
      }
      if($charset=='utf-8')header("Content-type: text/html; charset=utf-8");
      if($type=="list" || $type=="icon"){
        print('<h3 style="font-family:Arial Black;">'.strtoupper($charset).myutf8('编码').'</h3><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>');
        echo"<script type=\"text/javascript\" src=\"{$homepage}kf.php?mod=im&type=$type&cid=$cid&wid=$wid&charset=$charset\"></script>";
      }elseif($type=="pic"){
        if(!$wid)exit('代码有误');
        $icon=Char_Cv("icon","get");
        echo'<a href="'.$homepage.'kf.php?mod=client&cid='.$cid.'&wid='.$wid.'" target="_blank"><img src="'.$homepage.'kf.php?mod=im&type=pic&cid='.$cid.'&wid='.$wid.'&icon='.$icon.'" border="0"></a>';
      }elseif($type=="text"){
        if(!$wid)exit('代码有误');
        $text=Char_Cv("text","get");
        if(!$text)$text="网上客服";
        echo'<a href="'.$homepage.'kf.php?mod=client&cid='.$cid.'&wid='.$wid.'" target="_blank">'.$text.'</a>';
      }
      exit();
      break;
  }
  if(file_exists('kefu/'.$file))include_once('kefu/'.$file);
}
?>