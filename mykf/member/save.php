<?php
include("check.php");
if(strtolower(substr($_SERVER['HTTP_REFERER'],7,strlen($_SERVER["SERVER_NAME"])))!=$_SERVER["SERVER_NAME"])exit("��Դ���Ϸ�");
$action=Char_Cv("action","get");
switch($action){
  case"config":
    if(!MyGrade($action))ero('û��Ȩ��','?action=main');
    $company=Char_Cv("company");
    $dialoglogo=Char_Cv("dialoglogo");
    $dialoglogourl=Char_Cv("dialoglogourl");
    $keywords=Char_Cv("keywords");
    $description=Char_Cv("description");
    $autoinvite=Char_Cv("autoinvite");
    $effect=Char_Cv("effect");
    $opennew=Char_Cv("opennew")?'1':'0';
    $delay=Char_Cv("delay");
    if(!$delay || !is_numeric($delay))$delay=5;
    $invitetitle=Char_Cv("invitetitle");
    $invitecontent=Char_Cv("invitecontent");
    $dialogad=Char_Cv("dialogad");
    $dialogtitle=Char_Cv("dialogtitle");
    $dialoginfotitle=Char_Cv("dialoginfotitle");
    $logo=Char_Cv("logo_");
    $prov=Char_Cv("prov");
    $city=Char_Cv("city");
    $trade=Char_Cv("trade");
    $autofaq=Char_Cv("autofaq");
    $language_dialog=Char_Cv("language_dialog");
    $dialogsort=str_replace('|','��',Char_Cv("dialogsort"));
    $allowpingfen=Char_Cv("allowpingfen")?'1':'0';
    $db->update("setting","company,dialogad,dialoglogo,dialoglogourl,keywords,description,autoinvite,effect,opennew,delay,invitetitle,invitecontent,dialogtitle,dialoginfotitle,logo,prov,city,trade,autofaq,allowpingfen,language,dialogsort,companyinfo","$company|$dialogad|$dialoglogo|$dialoglogourl|$keywords|$description|$autoinvite|$effect|$opennew|$delay|$invitetitle|$invitecontent|$dialogtitle|$dialoginfotitle|$logo|$prov|$city|$trade|$autofaq|$allowpingfen|$language_dialog|$dialogsort|$companyinfo1","companyid='$cid'");
    
    ero("�����ɹ�","member.php?action=config");
    break;
  case"zdyurl":
    $urlkg=Char_Cv("urlkg");
    $url=Char_Cv("url");
    $db->update("setting","urlkg,url","$urlkg|$url","companyid='$cid'");
    
    ero("�����ɹ�","member.php?action=zdyurl");
    break;
  case"ggs"://
    $ntype=Char_Cv('ntype','get');
    $ac=Char_Cv('ac','get');
    $thetext=Char_Cv('thetext');
    $theurl=Char_Cv('theurl');
    if($ntype=='gg_dialog_add'){
      $db->insert("ads","thetext,theurl,ntype,admin,companyid,addtime","$thetext|$theurl|dialog|$username|$username|$time");
    }elseif($ntype=='gg_dialog_edit'){
      $id=Char_Cv('id');
      $db->update("ads","thetext,theurl","$thetext|$theurl","admin<>'' and id=$id");
    }elseif($ntype=='gg_main_add'){
      $db->insert("ads","thetext,theurl,ntype,admin,addtime","$thetext|$theurl|main|$username|$time");
    }elseif($ntype=='gg_main_edit'){
      $id=Char_Cv('id');
      $db->update("ads","thetext,theurl","$thetext|$theurl","admin<>'' and id=$id");
    }elseif($ntype=='gg_login'){
      if($db->rows("ads","admin<>'' and ntype='login'")==0){
        $db->insert("ads","thetext,theurl,ntype,admin,companyid,addtime","$thetext|$theurl|login|$username|$username|$time");
      }else{
        $db->update("ads","thetext,theurl","$thetext|$theurl","admin<>'' and ntype='login'");
      }
    }elseif($ntype=='del'){
      $id=Char_Cv('id');
      if(!$id || !is_array($id))ero("��û��ѡ���κ�����",1);
      for($i=0;$i<count($id);$i++){
        $db->delete("ads","admin<>'' and id=".$id[$i]);
      }
    }
    if(!$ac)$ac='main';
    ero('�����ɹ�','member.php?action='.$ac);
    break;
  case"setstyle":
    $curstyle=Char_Cv("curstyle","get");
    $db->update("worker","style",$curstyle,"companyid='$cid' and username='$username'");
    echo"<script language=\"javascript\">";
    if($curstyle!==$adminstyle){
      echo'parent.frames["menu"].location.reload();';
    }
    echo"location.href='member.php?action=main'</script>";
    break;
  case"modify":
    if(!MyGrade($action))ero('û��Ȩ��','?action=main');
    $nickname=Char_Cv("nickname");
    $realname=Char_Cv("realname");
    $sex=Char_Cv("sex");
    $city=Char_Cv("city");
    $phone=Char_Cv("phone");
    $email=Char_Cv("email");
    $qq=Char_Cv("qq");
    $content=delhtml($_POST['content']);
    $pass0=Char_Cv("pass0");
    $pass1=Char_Cv("pass1");
    $pass2=Char_Cv("pass2");
    $onlinetitle=delhtml(Char_Cv("onlinetitle"));
    $offlinetitle=delhtml(Char_Cv("offlinetitle"));
    $onlinetip=delhtml(Char_Cv("onlinetip"));
    $offlinetip=delhtml(Char_Cv("offlinetip"));
    $closetip=delhtml(Char_Cv("closetip"));
    $Favorite=Char_Cv("Favorite");
    $FavoriteUrl=Char_Cv("FavoriteUrl");
    $FavoriteName=Char_Cv("FavoriteName");
    $db->update("worker","nickname,realname,sex,city,phone,email,qq,content,onlinetitle,offlinetitle,onlinetip,offlinetip,closetip,Favorite,FavoriteUrl,FavoriteName","$nickname|$realname|$sex|$city|$phone|$email|$qq|$content|$onlinetitle|$offlinetitle|$onlinetip|$offlinetip|$closetip|$Favorite|$FavoriteUrl|$FavoriteName","companyid='$cid' and username='$username'");
    if($pass0){
      $pass=md5($pass0);
      $newpass=md5($pass2);
      if($db->rows("worker","companyid='$cid' and username='$username' and password='$pass'")==0){
        ero("���ľ����벻��ȷ",1);
      }else{
        $db->update("worker","password","$newpass","companyid='$cid' and username='$username'");
      }
      WriteLog($cid,"�޸�����","��������");
    }
    
    ero("�����ɹ�","member.php?action=modify");
    break;
  case"addworker":
    if(!MyGrade('worker'))ero('û��Ȩ��','?action=main');
    if(!CheckGrade('allworker') && $db->rows("worker","companyid='$cid'")>=$workercount){
      print('<script type="text/javascript">
if(confirm("���Ŀ��ÿͷ����Ѵﵽ������������ܼ������!\\n�����ȷ��������ͷ�����")){
  location.href="member.php?action=pay&type=buyworker";
}else{
  history.go(-1);
}
</script>');
  exit();
    }
    $taxis=Char_Cv("taxis");
    $sort=Char_Cv("sort");
    $qq=Char_Cv("qq");
    $username=Char_Cv("username");
    $realname=Char_Cv("realname");
    $nickname=Char_Cv("nickname");
    $password=Char_Cv("password");
    $sortid=Char_Cv("sortid","post","num");
    $isshow=Char_Cv("isshow","post","num");
    $grade=Char_Cv("mygrade");
    $style=Char_Cv("style");
    if($grade)$grade=implode(',',$grade);
    $password=md5($password);
    if($sort=='2'){
      $username=$qq;
      $password='EQMKQQ';
    }
    if($db->rows("worker","companyid='$cid' and username='$username'")>0)ero("���û����Ѵ��ڣ������");
    $db->insert("worker","companyid,taxis,sortid,username,nickname,password,style,grade,isshow,realname","$cid|$taxis|$sortid|$username|$nickname|$password|$style|$grade|$isshow|$realname");
    $id=$db->select("worker","id","1 order by id desc");
    $mq=$MQStart+$id;
    $db->update("worker","mq",$mq,"id=$id");
    if($db->rows("worker","companyid='$cid' and isshow=1")>0){
      $db->update("setting","status","1","companyid='$cid'");
    }
    $curcount=$db->rows("worker","companyid='$cid'");
    $db->update("setting","workercount",$curcount,"companyid='$cid'");
    
    WriteLog($cid,"���ӿͷ�","���ӿͷ�:{$nickname}[$username]");
    ero("�����ɹ�","member.php?action=worker");
    break;
  case"editworker":
    if(!MyGrade('worker'))ero('û��Ȩ��','?action=main');
    $id=Char_Cv("id");
    $uname=$username;
    $wid=Char_Cv("workerid");
    $sort=Char_Cv("sort");
    $qq=Char_Cv("qq");
    $username=Char_Cv("username");
    $realname=Char_Cv("realname");
    $nickname=Char_Cv("nickname");
    $password=Char_Cv("password");
    $sortid=Char_Cv("sortid","post","num");
    $isshow=Char_Cv("isshow","post","num");
    $grade=Char_Cv("mygrade");
    if($grade)$grade=implode(',',$grade);
    if($sort=='2'){
      $username=$qq;
      $password='EQMKQQ';
    }
    if($password!==""){
      $password=md5($password);
      if($sort=='2')$password='EQMKQQ';
      $db->update("worker","password","$password","companyid='$cid' and id=$id");
    }
    if($db->rows("worker","companyid='$cid' and username='$username' and id<>$id")>0)ero("���û����Ѵ��ڣ������");
    $db->update("worker","taxis,sortid,username,nickname,grade,isshow,realname","$taxis|$sortid|$username|$nickname|$grade|$isshow|$realname","companyid='$cid' and id=$id");
    if($db->rows("worker","companyid='$cid' and isshow=1")>0){
      $db->update("setting","status","1","companyid='$cid'");
    }
    WriteLog($cid,"�༭�ͷ�","�༭�ͷ�:{$nickname}[$username]");
    
    
    ero("�����ɹ�","member.php?action=worker");
    break;
  case"delworker":
    if(!MyGrade('worker'))ero('û��Ȩ��','?action=main');
    $id=Char_Cv("id","get");
    $w=$db->record("worker","username,nickname","companyid='$cid' and id=$id",1);
    if(!$w)ero("��Ҫɾ���Ĺ���Ա������");
    $username=$w[0]['username'];
    $nickname=$w[0]['nickname'];
    if($username==$cid)ero("����ɾ��Ĭ�Ϲ���Ա");
    
    $db->delete("worker","companyid='$cid' and id=$id");
    if($db->rows("worker","companyid='$cid' and isshow=1")==0){
      $db->update("setting","status","0","companyid='$cid'");
    }
    if($db->rows("worker","companyid='$cid' and isshow=1")>0){
      $db->update("setting","status","1","companyid='$cid'");
    }
    $curcount=$db->rows("worker","companyid='$cid'");
    $db->update("setting","workercount",$curcount,"companyid='$cid'");
    
    WriteLog($cid,"ɾ���ͷ�","ɾ���ͷ�:{$nickname}[$username]");
    
    ero("�����ɹ�","member.php?action=worker");
    break;
  case"addworkersort":
    if(!MyGrade('workersort'))ero('û��Ȩ��','?action=main');
    if(!CheckGrade('allworker') && $db->rows("workersort","companyid='$cid'")>=$sortcount){
      print('<script type="text/javascript">
if(confirm("���Ŀ���ϯλ���Ѵﵽ������������ܼ������!\\n�����ȷ��������ϯλ����")){
  location.href="member.php?action=pay&type=buysort";
}else{
  history.go(-1);
}
</script>');
  exit();
    }
    $workersort=Char_Cv("sort");
    $taxis=Char_Cv("taxis","post","num");
    $db->insert("workersort","companyid,sort,taxis","$cid|$workersort|$taxis");
    $curcount=$db->rows("workersort","companyid='$cid'");
    $db->update("setting","sortcount",$curcount,"companyid='$cid'");
    WriteLog($cid,"����ϯλ","����ϯλ:{$workersort}[$taxis]");
    
    ero("�����ɹ�","member.php?action=workersort");
    break;
  case"editworkersort":
    if(!MyGrade('workersort'))ero('û��Ȩ��','?action=main');
    $id=Char_Cv("id");
    $workersort=Char_Cv("sort");
    $taxis=Char_Cv("taxis","post","num");
    $db->update("workersort","sort,taxis","$workersort|$taxis","companyid='$cid' and id=$id");
    WriteLog($cid,"�༭ϯλ","�༭ϯλ:{$workersort}[$taxis]");
    
    ero("�����ɹ�","member.php?action=workersort");
    break;
  case"delworkersort":
    if(!MyGrade('workersort'))ero('û��Ȩ��','?action=main');
    $id=Char_Cv("id","get");
    if($db->rows("worker","companyid='$cid' and username='$cid' and sortid=$id")>0){
      ero("����ɾ��Ĭ�Ϲ���Ա����ϯλ");
    }
    $worker=array();
    $w=$db->record("worker","username,nickname","companyid='$cid' and sortid=$id");
    foreach($w as $rs){
      $worker[]=$rs['nickname'].'['.$rs['username'].']';
    }
    $worker=$worker ? '{'.(implode('��',$worker)).'}' : '';
    
    $workersort=$db->select("workersort","sort","companyid='$cid' and id=$id");
    WriteLog($cid,"ɾ��ϯλ","ɾ��ϯλ�������ͷ�:{$workersort}{$worker}");
    $db->delete("workersort","companyid='$cid' and id=$id");
    $db->delete("worker","companyid='$cid' and sortid=$id");
    if($db->rows("worker","companyid='$cid' and isshow=1")==0){
      $db->update("setting","status","0","companyid='$cid'");
    }
    $curcount=$db->rows("workersort","companyid='$cid'");
    $db->update("setting","sortcount",$curcount,"companyid='$cid'");
    
    ero("�����ɹ�","member.php?action=workersort");
    break;
  case"delhistory":
    if(!MyGrade('history'))ero('û��Ȩ��','?action=main');
    $clientid=Char_Cv("clientid","get");
    $page=Char_Cv("page","get");
    $db->delete("history","companyid='$cid' and clientid='$clientid'");
    ero("�����ɹ�","member.php?action=history&page=$page");
    break;
  case"delcount":
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $clientid=Char_Cv("clientid","get");
    $page=Char_Cv("page","get");
    $db->delete("count","companyid='$cid' and clientid='$clientid'");
    ero("�����ɹ�","member.php?action=count&page=$page");
    break;
  case"addfaq":
    if(!MyGrade('faq'))ero('û��Ȩ��','?action=main');
    $title=Char_Cv("title");
    $db->insert("faq","companyid,title,content","$cid|$title|content1");
    ero("�����ɹ�","member.php?action=faqadd");
    break;
  case"editfaq":
    if(!MyGrade('faq'))ero('û��Ȩ��','?action=main');
    $id=Char_Cv("id");
    $title=Char_Cv("title");
    $db->update("faq","title,content","$title|content1","companyid='$cid' and id=$id");
    ero("�����ɹ�","member.php?action=faq");
    break;
  case"delfaq":
    if(!MyGrade('faq'))ero('û��Ȩ��','?action=main');
    $id=Char_Cv("id");
    $db->delete("faq","companyid='$cid' and id=$id");
    ero("�����ɹ�","member.php?action=faq");
    break;
  case"delfaq2":
    if(!MyGrade('faq'))ero('û��Ȩ��','?action=main');
    $id=Char_Cv("id");
    if(!$id)ero('��û��ѡ���κ��Զ�Ӧ��',1);
    for($i=0;$i<count($id);$i++){
      $db->delete("faq","companyid='$cid' and id=".$id[$i]);
    }
    ero("�����ɹ�","member.php?action=faq");
    break;
  case"wordsadd":
    $ntype=Char_Cv("ntype")=='1'?'1':'0';
    $words=Char_Cv("words");
    $sort=Char_Cv("sort");
    $db->insert("words","companyid,workerid,ntype,words,sort,addtime","$cid|$wid|$ntype|$words|$sort|$time");
    ero("�����ɹ�","member.php?action=words");
    break;
  case"wordsedit":
    $id=Char_Cv("id");
    $ntype=Char_Cv("ntype")=='1'?'1':'0';
    $words=Char_Cv("words");
    $sort=Char_Cv("sort");
    $db->update("words","ntype,words,sort","$ntype|$words|$sort","companyid='$cid' and workerid='$wid' and id=$id");
    ero("�����ɹ�","member.php?action=words");
    break;
  case"wordsdel":
    $id=Char_Cv("id","get");
    $db->delete("words","companyid='$cid' and workerid='$wid' and id=$id");
    ero("�����ɹ�","member.php?action=words");
    break;
  case"savestyle":
    if(!MyGrade('style'))ero('û��Ȩ��','?action=main');
    $caption=Char_Cv("caption");
    $posx=Char_Cv("posx");
    $x=Char_Cv("x");
    $posy=Char_Cv("posy");
    $y=Char_Cv("y");
    $iconstyle=Char_Cv("iconstyle");
    $liststyle=Char_Cv("liststyle");
    $tipstyle=Char_Cv("tipstyle");
    $dialogstyle=Char_Cv("dialogstyle");
    if(!$x || !is_numeric($x))$x=0;
    if(!$y || !is_numeric($y))$y=0;
    $db->update("style","caption,posx,x,posy,y,iconstyle,liststyle,tipstyle,dialogstyle","$caption|$posx|$x|$posy|$y|$iconstyle|$liststyle|$tipstyle|$dialogstyle","companyid='$cid'");
    
    ero("�����ɹ�","member.php?action=style");
    break;
  case"pay":
    $type = Char_Cv("type","get");
    $paytype = Char_Cv("paytype");
    $setting=$db->record("setting","ntype,money,paymoney,exptime,grade,package,packtime","companyid='$cid'",1);
    $money=$setting[0]['money'];
    $paymoney=$setting[0]['paymoney'];
    $ntype=$setting[0]['ntype'];
    $package=$setting[0]['package'];
    $exptime=$setting[0]['exptime'];
    $packtime=$setting[0]['packtime'];
    if($type=='exptimes'){
      if(!MyGrade('exptimes'))ero('û��Ȩ��','?action=main');
      $exptime=$setting[0]['exptime'];
      $mytime=GetTime(date('Y-m-d',$time));
      $price=$ntype==2 ? $price_days2 : $price_days1;
      $days = Char_Cv("days");
      $totalprice=$price*$days;
      if($totalprice<0)ero('�Ƿ�����');
      $exptime_=$exptime>=$mytime ? $exptime+$days*86400*$PriceOne[1] : $mytime+$days*86400*$PriceOne[1];
      if($paytype=='0'){
        if($money<$totalprice)ero('�����˻����㣬����ʧ��');
        $money-=$totalprice;
        $paymoney+=$totalprice;
        $ntype=$ntype==2 ? 2 : 1;
        $db->update("setting","ntype,exptime,money,paymoney","$ntype|$exptime_|$money|$paymoney","companyid='$cid'");
        WriteMoneyLog($cid,-$totalprice,"[����]�ͷ�չ����".date('Y-m-d',$exptime_));
        WriteLog($cid,"�ͷ�չ��","�ͷ�չ����".date('Y-m-d',$exptime_));
        ero("����ɹ�","member.php?action=money");
      }elseif($paytype=='1'){//����֧��
        $price=$totalprice;
        $o_title='�ͷ�չ��';
        $o_body='�����Ŀͷ���Ч���ӳ���'.date('Y-m-d',$exptime_);
        $torder=$time;
        $db->insert("torder","companyid,torder,ntype,addtime,price,content","$cid|$torder|$type|$time|$price|$days");
        include("../api/alipay.php");
      }
    }elseif($type=='pay'){
      if(!MyGrade('pay'))ero('û��Ȩ��','?action=main');
      $price = Char_Cv("pmoney");
      $o_title='�˻���ֵ';
      $o_body='Ϊ�����˻�����'.$price.'Ԫ';
      $torder=$time;
      $db->insert("torder","companyid,torder,ntype,addtime,price","$cid|$torder|$type|$time|$price");
      include("../api/alipay.php");
    }elseif($type=='reg' || $type=='add'){
      if($type=='reg' && !MyGrade('buy'))ero('û��Ȩ��','?action=main');
      if($type=='add' && !MyGrade('add'))ero('û��Ȩ��','?action=main');
      $keyname = Char_Cv("keyname");
      $buynum = Char_Cv("num");
      $function=$db->record("function","price,days,title,content","keyname='$keyname' and isused=1");
      if($type=='reg'){
        if(!$function)ero('��Ҫ����Ĺ��ܲ�����');
        if($db->rows("myfunction","companyid='$cid' and keyname='$keyname'")>0)ero('���ѹ�����˹��ܣ���ѡ������');
      }else{
        if(!$function)ero('��Ҫ���ѵĹ��ܲ�����');
        if($db->rows("myfunction","companyid='$cid' and keyname='$keyname'")==0)ero('��û�й�����˹���');
      }
      $ti=$function[0]['title'];
      $content=$function[0]['content'];
      $days=$function[0]['days'];
      $price=$function[0]['price'];
      $totalprice=$price*$buynum;
      if($totalprice<0)ero('�Ƿ�����');
      $mytime=GetTime(date('Y-m-d',$time));
      if($paytype=='0'){
        if($money<$totalprice)ero('�����˻����㣬����ʧ��');
        $money-=$totalprice;
        $paymoney+=$totalprice;
        $grade=$setting[0]['grade'] ? $setting[0]['grade'].','.$keyname : $keyname;
        if($type=='reg'){
          $exptime=$mytime+$days*$buynum*86400;
          $db->insert("myfunction","companyid,keyname,starttime,exptime","$cid|$keyname|$time|$exptime");
          $db->update("setting","ntype,money,paymoney,grade","1|$money|$paymoney|$grade","companyid='$cid'");
          WriteMoneyLog($cid,-$totalprice,"[����]��ͨ���ܡ�".$ti."��,����$price,����$buynum,��Ч����".date('Y-m-d',$exptime));
          WriteLog($cid,"��ͨ����","��ͨ���ܡ�".$ti."��");
          ero("��ͨ���ܳɹ�","member.php?action=function");
        }else{
          $exptime=$db->select("myfunction","exptime","companyid='$cid' and keyname='$keyname'");
          $exptime_=$exptime>=$mytime ? $exptime+$days*$buynum*86400 : $mytime+$days*$buynum*86400;
          $db->update("myfunction","exptime","$exptime_","companyid='$cid' and keyname='$keyname'");
          $db->update("setting","ntype,money,paymoney,grade","1|$money|$paymoney|$grade","companyid='$cid'");
          WriteMoneyLog($cid,-$totalprice,"[����]�������ѡ�".$ti."��,����$price,����$buynum,��Ч����".date('Y-m-d',$exptime_));
          WriteLog($cid,"��������","�������ѡ�".$ti."��");
          ero("���ѳɹ�\\n���Ѻ����Ҫ���µ�½������Ч","member.php?action=function");
        }
      }elseif($paytype=='1'){//����֧��
        $price=$totalprice;
        $o_title=($type=='reg' ? '��ͨ����' : '��������').'��'.$ti.'��';
        $o_body=$content;
        $torder=$time;
        $db->insert("torder","companyid,torder,ntype,addtime,price,content","$cid|$torder|$type|$time|$price|$keyname,$days,$buynum,$price,$ti");
        include("../api/alipay.php");
      }
    }elseif($type=='buypackage'){
      if(!MyGrade('buy'))ero('û��Ȩ��','?action=main');
      $packid = Char_Cv("id");
      if($packid==$package)ero('��ǰ�Ѿ��Ǵ��ײ��ˣ������ظ�����');
      $buynum = Char_Cv("buynum");
      $P=$db->record("package","title,funcos,price,dayti,day","id=$packid");
      if(!$P)ero('��Ҫ��ͨ���ײͲ�����',1);
      $P=$P[0];
      $totalprice=$buynum*$P['price'];
      if($paytype=='0'){
        if($money<$totalprice)ero('�����˻����㣬����ʧ��');
        $money-=$totalprice;
        $paymoney+=$totalprice;
        $exptime=$time+$P['day']*$buynum;
        $db->update("setting","package,packtime,exptime,money,paymoney","$packid|$time|$exptime|$money|$paymoney","companyid='$cid'");
        WriteMoneyLog($cid,-$totalprice,"[����]��ͨ".$buynum.$P['dayti']."��".$P['title']."���ײ�");
        WriteLog($cid,"��������","��ͨ".$buynum.$P['dayti']."��".$P['title']."���ײ�");
        ero("��ͨ��".$P['title']."���ײͳɹ�","member.php?action=function");
      }elseif($paytype=='1'){//����֧��
        $price=$totalprice;
        $o_title="��ͨ".$buynum.$P['dayti']."��".$P['title']."���ײ�";
        $o_body='�������ܣ�'.$P['funcos'];
        $torder=$time;
        $exptime=$time+$P['day']*$buynum;
        $ti=urlencode($o_title);
        $db->insert("torder","companyid,torder,ntype,addtime,price,content","$cid|$torder|$type|$time|$price|$packid,$ti,$exptime");
        include("../api/alipay.php");
      }
    }elseif($type=='paypackage'){
      if(!MyGrade('pay'))ero('û��Ȩ��','?action=main');
      $packid = Char_Cv("id");
      if($packid!=$package)ero('����δ������ײ�');
      $buynum = Char_Cv("buynum");
      $P=$db->record("package","title,funcos,price,dayti,day","id=$packid");
      if(!$P)ero('��Ҫ���ѵ��ײͲ�����',1);
      $P=$P[0];
      $totalprice=$buynum*$P['price'];
      if($paytype=='0'){
        if($money<$totalprice)ero('�����˻����㣬����ʧ��');
        $money-=$totalprice;
        $paymoney+=$totalprice;
        $exptime+=$P['day']*86400*$buynum;
        $db->update("setting","exptime,money,paymoney","$exptime|$money|$paymoney","companyid='$cid'");
        WriteMoneyLog($cid,-$totalprice,"[����]��".$P['title']."���ײ�����".$buynum.$P['dayti']);
        WriteLog($cid,"��������","��".$P['title']."���ײ�����".$buynum.$P['dayti']);
        ero("���ѳɹ�","member.php?action=function");
      }elseif($paytype=='1'){//����֧��
        $price=$totalprice;
        $o_title="��".$P['title']."���ײ�����".$buynum.$P['dayti'];
        $o_body='�������ܣ�'.$P['funcos'];
        $torder=$time;
        $exptime+=$P['day']*86400*$buynum;
        $ti=urlencode($o_title);
        $db->insert("torder","companyid,torder,ntype,addtime,price,content","$cid|$torder|$type|$time|$price|$ti,$exptime");
        include("../api/alipay.php");
      }
    }elseif($type=='buysort' || $type=='buyworker'){
      if(!MyGrade('buy'))ero('û��Ȩ��','?action=main');
      $buynum = Char_Cv("buynum");
      $price=$type=='buysort' ? $price_sort : $price_worker;
      $totalprice=$price * $buynum;
      $curcount=$type=='buysort' ? $sortcount : $workercount;
      $totalcount=$curcount+$buynum;
      if($paytype=='0'){
        if($money<$totalprice)ero('�����˻����㣬����ʧ��');
        $money-=$totalprice;
        $paymoney+=$totalprice;
        $xxx=$type=='buysort' ? 'sortcount' : 'workercount';
        $db->update("setting","ntype,money,paymoney,$xxx","1|$money|$paymoney|$totalcount","companyid='$cid'");
        if($type=='buysort'){
          WriteMoneyLog($cid,-$totalprice,"[����]����".$buynum."��ϯλ");
          WriteLog($cid,"����ϯλ��","����".$buynum."��ϯλ");
        }else{
          WriteMoneyLog($cid,-$totalprice,"[����]����".$buynum."���ͷ�");
          WriteLog($cid,"���ӿͷ���","����".$buynum."���ͷ�");
        }
        ero("����ɹ�","member.php?action=main");
      }elseif($paytype=='1'){//����֧��
        $price=$totalprice;
        if($type=='buysort'){
          $o_title='����ϯλ����';
          $o_body='֧���ɹ������Ŀ���ϯλ����������'.$buynum;
        }else{
          $o_title='����ͷ�����';
          $o_body='֧���ɹ������Ŀ��ÿͷ�����������'.$buynum;
        }
        $torder=$time;
        $db->insert("torder","companyid,torder,ntype,addtime,price","$cid|$torder|$type|$time|$buynum");
        include("../api/alipay.php");
      }
    }
    break;
}
?>