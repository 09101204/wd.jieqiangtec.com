<?php
include("check.php");
if(strtolower(substr($_SERVER['HTTP_REFERER'],7,strlen($_SERVER["SERVER_NAME"])))!=$_SERVER["SERVER_NAME"])exit("��Դ���Ϸ�");
$action=Char_Cv("action","get");
switch($action){
  case"config"://�޸�����
    $company=Char_Cv("company");
    $content=Char_Cv("content");
    $db->update("agent","company,content","$company|$content","username='$username'");
    ero("�޸ĳɹ�","agent.php?action=config");
    break;
  case"changepass"://�޸�����
    $pass0=Char_Cv("pass0");
    $pass1=Char_Cv("pass1");
    $pass2=Char_Cv("pass2");
    if($pass0){
      $pass=md5($pass0);
      $newpass=md5($pass2);
      if($db->rows("agent","username='$username' and password='$pass'")==0){
        ero("���ľ��������벻��ȷ",1);
      }else{
        $db->update("agent","password","$newpass","username='$username'");
      }
    }
    ero("�޸�����ɹ�","agent.php?action=changepass");
    break;
  case"agent_set"://
    if($Ntype!='prov'){
      header('location:?action=main');
      exit;
    }
    $ntype=Char_Cv("ntype");
    $pword=Char_Cv("pword");
    $city=Char_Cv("c");
    $companyname=Char_Cv("companyname");
    $content=Char_Cv("content");
    if($ntype=='add'){
      $uname=Char_Cv("uname");
      if($db->rows('agent',"username='$uname'"))ero('���û����Ѵ���');
      $pass=md5($pword);
      $exptime=GetTime(date('Y-m-d',$time))+365*86400;
      if($db->rows('agent',"prov='$prov' and city='$city'"))ero($prov.$city.'�����ܴ���');
      $db->insert("agent","ntype,prov,city,username,password,company,content,infotime,infoip,infotype,exptime","city|$prov|$city|$uname|$pass|$companyname|$content|$time|$onlineip|1|$exptime");
      WriteLog($uname,'��ͨ�д���','ʡ�ܴ���ͨ����'.$prov.$city.'�ܴ����ʸ�',1);
      WriteLog($username,'��ͨ�д���','��ͨ'.$prov.$city.'�ܴ���',1);
    }else{
      $id=Char_Cv("id");
      $money=Char_Cv("money");
      $days=Char_Cv("days");
      $agent=$db->record("agent","username,money,exptime","prov='$prov' and city='$c' and id=$id",1);
      if(!$agent)ero('��Ҫ�༭�Ĵ����̲�����');
      $exptime=$agent[0]['exptime'];
      if(!$money || !is_numeric($money))$money=0;
      if($money<0)ero('��ֵ����С��0');
      if($money>0){
        $mymoney=$db->select("agent","money","username='$username'");
        if($money>$mymoney)ero('�����˺�����,���ܽ���ת�˲���');
        WriteMoneyLog($agent[0]['username'],$money,'ʡ�ܴ���Ϊ�����˻����г�ֵ',1);
        WriteMoneyLog($username,-$money,'ת�˸�'.$city.'�ܴ���',1);
      }
      $m=$money+$agent[0]['money'];
      if(intval($days)!=intval(($exptime-GetTime(date('Y-m-d',$time)))/86400)){
        WriteLog($agent[0]['username'],'��������','ʡ�ܴ������������Ч�ڣ�',1);
        WriteLog($username,'��������','����'.$city.'�ܴ������Ч�ڣ�',1);
      }
      $exptime=GetTime(date('Y-m-d',$time))+$days*86400;
      $db->update("agent","prov,city,company,content,money,exptime","$prov|$city|$companyname|$content|$m|$exptime","prov='$prov' and id=$id");
      $db->query("update {$tbl}agent set money=money-$money,paymoney=paymoney+$money where username='$username'");
      if($pword){
        $pass=md5($pword);
        $db->update("agent","password","$pass","id=$id");
        WriteLog($uname,$prov.'�޸�����',"�ܴ���������������",1);
      }
    }
    ero('�����д���ɹ�',"agent.php?action=agent_set&c=$city");
    break;
  case"agent_del"://
    $id=Char_Cv('id','get');
    $agent=$db->record("agent","username,ntype,prov,city","id=$id",1);
    $uname=$agent[0]['username'];
    $ntype=$agent[0]['ntype'];
    $prov_=$agent[0]['prov'];
    $city=$agent[0]['city'];
    if(!$agent)ero("��Ҫɾ���Ĵ�������",1);
    if($Ntype!='prov' || $prov!=$prov_ || $ntype=='prov')ero("��û�н��и��������Ȩ��",1);
    $db->delete("agent","id=$id");
    $db->delete("log","agent='$uname'");
    $db->delete("money","agent='$uname'");
    WriteLog($username,'ɾ���¼�������','ɾ������'.$city.'������,�û���:'.$uname,1);
    ero($prov.$city."�ܴ����ѱ�ɾ��","agent.php?action=agent_set&c=$city");
    break;
  case"editcompany"://
    $id=Char_Cv("id");
    $company=Char_Cv("company");
    $money=Char_Cv("money");
    $days=Char_Cv("days");
    $isfull=Char_Cv("isfull");
    $setting=$db->record("setting","agent,companyid,paymoney,money,exptime,ntype,infoprov","id=$id");
    if(($Ntype=='prov' && $setting[0]['infoprov']!=$prov) || ($Ntype!='prov' && $setting[0]['agent']!=$username))ero('�����Ǹÿͻ��Ĵ�����');
    $companyid=$setting[0]['companyid'];
    $exptime=$setting[0]['exptime'];
    $ntype=$thegrade ? ($isfull?2:($setting[0]['paymoney']>0?1:0)) : $setting[0]['ntype'];
    if(!$money || !is_numeric($money))$money=0;
    if($money<0)ero('��ֵ����С��0');
    if($money>0){
      $mymoney=$db->select("agent","money","username='$username'");
      if($money>$mymoney)ero('�����˺�����,���ܽ���ת�˲���');
      WriteMoneyLog($uname,$money,'������Ϊ�����˻����г�ֵ',1);
      WriteMoneyLog($username,-$money,'ת�˸��ͻ�,��ҵ���:'.$companyid,1);
    }
    $m=$money+$setting[0]['money'];
    if($setting[0]['ntype']!=2 && $ntype==2){
      WriteLog($companyid,'ȫ����','�����̽�������Ϊȫ���ܿͻ���');
    }elseif($setting[0]['ntype']==2 && $ntype!=2){
      WriteLog($companyid,'ȫ����','������ȡ������ȫ���ܿͻ��ʸ�');
    }
    if($thegrade){
      if(intval($days)!=intval(($exptime-GetTime(date('Y-m-d',$time)))/86400)){
        WriteLog($companyid,'��������','�����̸������Ŀͷ���Ч�ڣ�');
      }
      $exptime=GetTime(date('Y-m-d',$time))+$days*86400;
    }else{
      $exptime=$setting[0]['exptime'];
    }
    $db->update("setting","company,money,exptime,ntype","$company|$m|$exptime|$ntype","id=$id");
    $db->query("update {$tbl}agent set money=money-$money,paymoney=paymoney+$money where username='$username'");
    ero("�޸ĳɹ�","agent.php?action=companyedit&id=$id");
    break;
  case"editcompany2"://
    if(!$thegrade)ero('��û�н��и��������Ȩ��');
    if(($Ntype=='prov' && $setting[0]['infoprov']!=$prov) || ($Ntype!='prov' && $setting[0]['agent']!=$username))ero('�����Ǹÿͻ��Ĵ�����');
    $id=Char_Cv('id');
    $companyid=Char_Cv('companyid');
    $used=Char_Cv('used');
    $A=Char_Cv('A');
    $package=$db->select("setting","package","companyid='$companyid'");
    $thefun=$db->record("package","funs","id=$package");
    $myfuns=explode(',',$thefun[0]['funs']);
    $thefun=$db->record("myfunction","keyname","companyid='$companyid'");
    foreach($thefun as $rs){
      if(!in_array($rs['keyname'],$myfuns)){
        $myfuns[]=$rs['keyname'];
      }
    }
    foreach($A as $k=>$v){
      if(!in_array($k,$myfuns) && $used[$k]=='1'){
        $sname=$db->select('function','title',"keyname='$k'");
        WriteLog($companyid,'��ͨ����','������Ϊ����ͨ��'.$sname.'������');
        $db->insert("myfunction","companyid,keyname,starttime","$companyid|$k|$time");
      }elseif(in_array($k,$myfuns) && $used[$k]!='1'){
        $sname=$db->select('function','title',"keyname='$k'");
        WriteLog($companyid,'ɾ������','��������ɾ�����ġ�'.$sname.'������');
        $db->delete("myfunction","companyid='$companyid' and keyname='$k'");
      }
    }
    ero("�޸ĳɹ�","agent.php?action=companyedit&id=$id");
    break;
  case"delcompany"://
    $id=Char_Cv("id","get");
    $ac=Char_Cv("ac","get");
    if(!$id)ero("��û��ѡ���κ�����",1);
    if(!$thegrade)ero('��û�н��и��������Ȩ��');
    $setting=$db->record("setting","agent,companyid,ntype","id=$id",1);
    if(!$setting)ero("��Ҫɾ���Ŀͻ�������",1);
    if($setting[0]['agent']!=$username)ero('�����Ǹÿͻ��Ĵ�����');
    $companyid=$setting[0]['companyid'];
    $ac='company'.($setting[0]['companyid']+1);
    $db->delete("client","companyid='$companyid'");
    $db->delete("dialog","companyid='$companyid'");
    $db->delete("faq","companyid='$companyid'");
    $db->delete("history","companyid='$companyid'");
    $db->delete("log","companyid='$companyid'");
    $db->delete("message","companyid='$companyid'");
    $db->delete("money","companyid='$companyid'");
    $db->delete("myfunction","companyid='$companyid'");
    $db->delete("style","companyid='$companyid'");
    $db->delete("workersort","companyid='$companyid'");
    $db->delete("worker","companyid='$companyid'");
    $db->delete("setting","id=$id");
    WriteLog($username,'ɾ���ͻ�','ɾ�����Ŀͻ�,��ҵ���:'.$companyid,1);
    ero("ɾ���ɹ�","agent.php?action=".$ac);
    break;
  case"company_add"://
    $companyid=Char_Cv("companyid");
    $pass=Char_Cv("pass");
    $city=Char_Cv("c");
    if(!$companyid || !$pass)ero("����д�����ݲ�ȫ",1);
    if($db->rows('setting',"companyid='$companyid'"))ero("��Ҫ��ӵĿͻ�����Ѵ���");
    $exptime=GetTime(date('Y-m-d',$time))+$freeday*86400;
    
    $myfun=array();
    $xxx=$isfull=='1' ? '' : 'price=0 and ';
    $fun=$db->record("function","keyname",$xxx."isused=1");
    foreach($fun as $rs){
      $myfun[]=$rs['keyname'];
    }
    $myfun=implode(',',$myfun);
    $myfun.=$myfun ? $regfuns ? ','.$regfuns : '' : $regfuns;
    if($regfuns){
      WriteLog($cid,"��ѿ�ͨ","���ø߼����ܡ�".$regfuns."��,��Ч����".date('Y-m-d',$exptime));
      $regfuns=explode(',',$regfuns);
      foreach($regfuns as $v){
        $db->insert('myfunction','companyid,keyname,starttime,exptime',"$companyid|$v|$time|$exptime");
      }
    }
    $agent=$db->select("agent","username","prov='$prov' and city='$city'");
    if(!$agent)$agent=$username;
    $db->insert('setting','companyid,status,company,logo,infotime,exptime,grade,agent,infoprov,infocity',"$companyid|1|$companyid|$homepage|$time|$exptime|$myfun|$agent|$prov|$city");
    $db->insert('workersort','companyid,sort',"$companyid|$default_workersort");
    $sid=$db->select('workersort','id',"companyid='$companyid' order by id desc");
    $address=getaddress($onlineip,true);
    $pass=md5($pass);
    $db->insert('worker','companyid,sortid,grade,username,password,nickname',"$companyid|$sid|all|$companyid|$pass|$default_worker");
    
    $id=$db->select("worker","id","1 order by id desc");
    $mq=$MQStart+$id;
    $db->update("worker","mq",$mq,"id=$id");
    
    WriteLog($companyid,"����˺�","��ͨ�ͻ��˺ţ�");
    $id=$db->select("setting","id","agent='$agent' order by id desc");
    ero("��ӿͻ��ɹ�","agent.php?action=companyedit&id=".$id);
    break;
  case"ggs"://
    $ntype=Char_Cv('ntype','get');
    $ac=Char_Cv('ac','get');
    $thetext=Char_Cv('thetext');
    $theurl=Char_Cv('theurl');
    if($ntype=='gg_dialog_add'){
      $db->insert("ads","thetext,theurl,ntype,agent,addtime","$thetext|$theurl|dialog|$username|$time");
    }elseif($ntype=='gg_dialog_edit'){
      $id=Char_Cv('id');
      $db->update("ads","thetext,theurl","$thetext|$theurl","agent='$username' and id=$id");
    }elseif($ntype=='gg_main_add'){
      $db->insert("ads","thetext,theurl,ntype,agent,addtime","$thetext|$theurl|main|$username|$time");
    }elseif($ntype=='gg_main_edit'){
      $id=Char_Cv('id');
      $db->update("ads","thetext,theurl","$thetext|$theurl","agent='$username' and id=$id");
    }elseif($ntype=='gg_login'){
      if($db->rows("ads","agent='$username' and ntype='login'")==0){
        $db->insert("ads","thetext,theurl,ntype,agent,addtime","$thetext|$theurl|login|$username|$time");
      }else{
        $db->update("ads","thetext,theurl","$thetext|$theurl","agent='$username' and ntype='login'");
      }
    }elseif($ntype=='del'){
      $id=Char_Cv('id');
      if(!$id || !is_array($id))ero("��û��ѡ���κ�����",1);
      for($i=0;$i<count($id);$i++){
        $db->delete("ads","agent='$username' and id=".$id[$i]);
      }
    }
    if(!$ac)$ac='main';
    ero('�����ɹ�','agent.php?action='.$ac);
    break;
}
$db->close();
?>