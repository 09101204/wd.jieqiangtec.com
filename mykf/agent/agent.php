<?
define('IN_AGENT', TRUE);
include("check.php");
$action=Char_Cv('action','get');
function ToHelp($ac){
  return '[<a href="agent.php?action=help#'.$ac.'"><font color="#0000ff">?</font></a>]';
}
switch($action){
  case'menu':
    include("../template/admin/$adminstyle/config.php");
    $logo='<img src="../images/agentcp/logo.gif">';
    $Menu[]=array('��������',
               array(
                'main'=>'������ҳ',
                'config'=>'��������',
                'changepass'=>'�޸�����',
                'logout'=>'ע���˳�'
               )
            );
     if($Ntype=='prov'){
    $Menu[]=array('�����̹���',
               array(
                'agent_city'=>'�¼�����'
               )
            );
    }
    $Menu[]=array('�ͻ�����',
               array(
                'company_add'=>'��ӿͻ�',
                'company1'=>'��ѿͻ�',
                'company2'=>'���ѿͻ�',
                'company3'=>'ȫ���ܿͻ�'
               )
            );
    $Menu[]=array('������',
               array(
                'gg_dialog'=>'��ҳ�Ի����',
                'gg_login'=>'�����½���',
                'gg_main'=>'��������',
                'help#gg'=>'�������˵��'
               )
            );
    $Menu[]=array('��������',
               array(
                'my_log'=>'������־',
                'my_money'=>'������ϸ'
               )
            );
    include("menu.php");
    break;
  case'main':
    $tplpath="../template/admin";
    $style_options='';
    $dh=opendir($tplpath);
    while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
        if(is_dir($tplpath.'/'.$file)) {
          $files="$tplpath/$file/licence.txt";
          $fso = fopen($files, 'r');
          $data = fgets($fso,65536);
          fclose($fso);
          if($file==$adminstyle){
            $s=' selected';
          }else{
            $s='';
          }
          $style_options.="<option value=\"$file\"$s>$data</option>";
        }
      }
    }
    closedir($dh);
    $title='������ҳ';
    $comcount1=$db->rows('setting',"ntype=0 and agent='$username'");
    $comcount2=$db->rows('setting',"ntype=1 and agent='$username'");
    $comcount3=$db->rows('setting',"ntype=2 and agent='$username'");
    
    if($Ntype=='prov')$grade=$prov.'�ܴ���';
    if($Ntype=='city')$grade=$prov.$city.'�ܴ���';
    $agent=$db->record("agent","money,paymoney","username='$username'",1);
    $money=$agent[0]['money'];
    $paymoney=$agent[0]['paymoney'];
    
    //���´��������ڻ��ѹ���
    $mytime=GetTime(date('Y-m-d',$time));
    if($Ntype=='prov'){
      $expagent=$db->record("agent","city,content,company,exptime","prov='$prov' and ntype='city' and exptime<=".($mytime+86400*7)." order by exptime desc",12);
    }
    //���¿ͻ��������ڻ��ѹ���
    $xxx=$Ntype=='prov' ? " infoprov='$prov'" : "infoprov='$prov' and infocity='$city' and agent='$username'";
    $expcompany=$db->record("setting","id,companyid,agent,company,exptime","$xxx and exptime<=".($mytime+86400*7)." order by exptime desc",12);
    
    //������ʾ
    $tips=array();
    if($db->rows('agent',"username='$username' and (password=md5(username) or password=md5('123456') or password=md5('000000') or password=md5('111111'))")>0)$tips[]='<font color=red>����������ڼ򵥣�������������</font> <a href="?action=changepass" style="color:blue">�޸�����</a>';
    if($lastaddress!=$thisaddress && $logincount>1)$tips[]='<font color=red>���ĵ�½��Ϣ���ϴε�½��Ϣ����,��ע���˺Ű�ȫ��</font> <a href="?action=modify" style="color:blue">�޸�����</a>';
    $tips=implode('<br />',$tips);
    include("main.php");
    break;
  case'config':
    $title='��������';
    $agent=$db->record("agent","company,content","username='$username'",1);
    $company=$agent[0]['company'];
    $content=$agent[0]['content'];
    include("config.php");
    break;
  case'changepass':
    $title='�޸�����';
    include("changepass.php");
    break;
  case'agent_city':
    $title=$prov.'�¼������̹���';
    include("../eqmkdata/sort.inc.php");
    foreach($Province as $k=>$v){
      if($v[0]==$prov){;
        $vars.="&cnt".$k."=6";
        break;
      }
    }
    include("../eqmkdata/citylist.inc.php");
    $citys=array();
    foreach($city as $rs){
      if($rs[0]==$prov && substr($rs[1],0,4)!='����'){
        $citys[]=$rs[1];
      }
    }
    include("agent_city.php");
    break;
  case'agent_set':
    if($Ntype!='prov'){
      header('location:?action=main');
      exit;
    }
    include("../include/getletter.func.php");
    $city=Char_Cv('c','get');
    if(!$city){
      header('location:?action=agent_city');
      exit;
    }
    $title=$prov.$city.'����������';
    $thecity=$prov.$city;
    if($agent=$db->record("agent","id,username,company,content,money,paymoney,infotime,infotype,exptime","prov='$prov' and city='$city'",1)){
      $ntype='edit';
      $id=$agent[0]['id'];
      $uname=$agent[0]['username'];
      $companyname=$agent[0]['company'];
      $content=$agent[0]['content'];
      $money=$agent[0]['money'];
      $paymoney=$agent[0]['paymoney'];
      $infotime=$agent[0]['infotime'];
      $infotype=$agent[0]['infotype']==1 ? 'ʡ�ܴ���' : 'ϵͳ����Ա';
      $exptime=$agent[0]['exptime'];
      $etime_=intval(($exptime-GetTime(date('Y-m-d',$time)))/86400);
    }else{
      $ntype='add';
      $uname=getletter($prov.$city);
      $companyname=$prov.$city.'�ܴ���';
      if($uname=='shanxi' && $prov=='ɽ��')$uname=='shanxi2';
      $pword=$uname;
    }
    include("agent_set.php");
    break;
  case'company1':
    $title='��ѿͻ�';
    $xxx=$Ntype=='prov' ? " infoprov='$prov'" : "infoprov='$prov' and infocity='$city' and agent='$username'";
    $company=$db->page("setting","id,company,companyid,money,paymoney,infotime,hot,talk,comment,agent,infoprov,infocity","ntype=0 and $xxx",20,"action=$action");
    include("company.php");
    break;
  case'company2':
    $title='���ѿͻ�';
    $xxx=$Ntype=='prov' ? " infoprov='$prov'" : "infoprov='$prov' and infocity='$city' and agent='$username'";
    $company=$db->page("setting","id,company,companyid,money,paymoney,infotime,hot,talk,comment,agent,infoprov,infocity","ntype=1 and $xxx",20,"action=$action");
    include("company.php");
    break;
  case'company3':
    $title='ȫ���ܿͻ�';
    $xxx=$Ntype=='prov' ? " infoprov='$prov'" : "infoprov='$prov' and infocity='$city' and agent='$username'";
    $company=$db->page("setting","id,company,companyid,money,paymoney,infotime,hot,talk,comment,agent,infoprov,infocity","ntype=2 and $xxx",20,"action=$action");
    include("company.php");
    break;
  case'company5':
    $city=Char_Cv('c','get');
    if(!$prov){
      header('location:?action=agent_prov');
      exit;
    }
    if(!$city){
      header('location:?action=agent_city&prov='.$prov);
      exit;
    }
    $xxx=$Ntype=='prov' ? " infoprov='$prov'" : "infoprov='$prov' and infocity='$city' and agent='$username'";
    $company=$db->page("setting","id,company,companyid,money,paymoney,infotime,hot,talk,comment,agent,infoprov,infocity","infoprov='$prov' and infocity='$city' and $xxx",20,"action=$action&c=$city");
    $MyTitle=$title=$prov.$city.'�ͻ�';
    include("company.php");
    break;
  case'companyedit':
    $id=Char_Cv('id','get');
    if(!$id || !is_numeric($id))ero('��������ȷ',1);
    $xxx=$Ntype=='prov' ? " infoprov='$prov'" : "infoprov='$prov' and infocity='$city' and agent='$username'";
    $setting=$db->record("setting","companyid,company,money,paymoney,infotime,infoip,exptime,ntype,agent,package","$xxx and id=$id",1);
    if(!$setting)ero('��Ҫ�༭�Ŀͻ�������',1);
    $companyid=$setting[0]['companyid'];
    $company=$setting[0]['company'];
    $money=$setting[0]['money'];
    $paymoney=$setting[0]['paymoney'];
    $infotime=$setting[0]['infotime'];
    $infoip=$setting[0]['infoip'];
    $exptime=$setting[0]['exptime'];
    $ntype=$setting[0]['ntype'];
    $grade=$setting[0]['grade'];
    $agent=$setting[0]['agent'];
    $isfull=$ntype==2 ? 'checked' :'';
    $package=$setting[0]['package'];
    
    $mytime=GetTime(date('Y-m-d',$time));
    
    $ac=$ntype==2 ? 'company3' : ($paymoney>0 ? 'company2' : 'company1');
    $etime_=intval(($exptime-GetTime(date('Y-m-d',$time)))/86400);
    $funs=$db->record("function","keyname,title,price","isused=1");
    $myfuns=array();
    $MyPackage='��ͨ�û�';
    if($package>0){
      $thefun=$db->record("package","funs,title","id=$package");
      $myfuns=$myfuns2=explode(',',$thefun[0]['funs']);
      $MyPackage=$thefun[0]['title'];
    }
    $thefun=$db->record("myfunction","keyname","companyid='$companyid'");
    foreach($thefun as $rs){
      $myfuns[]=$rs['keyname'];
    }
    $wsort=$db->record("workersort","id,sort","companyid='$companyid' order by taxis asc");
    
    if($agent){
      if($agent=$db->record("agent","prov,city,ntype,company","username='$agent'",1)){
        $ag='<a href="'.($agent[0]['ntype']=='prov' ? '?action=agent_set&type=prov&prov='.$agent[0]['prov'] : '?action=agent_set&type=city&prov='.$agent[0]['prov'].'&city='.$agent[0]['city']).'" title="'.($agent[0]['ntype']=='prov' ? $agent[0]['prov'].'�ܴ���' : $agent[0]['prov'].$agent[0]['city'].'�ܴ���').'">'.$agent[0]['company'].'</a>';
      }else{
        $ag='��';
      }
    }else{
      $ag='��';
    }
    
    $title='�鿴/�༭��ҵ����';
    include("companyedit.php");
    break;
  case'company_add':
    $cid=Char_Cv('cid','get');
    $MyTitle=$title='����¿ͻ�';
    $provs='<option value="'.$prov.'">'.$prov.'</option>';
    if($Ntype=='prov'){
      include("../eqmkdata/citylist.inc.php");
      $citys='';
      foreach($city as $rs){
        if($rs[0]==$prov){
          $citys.='<option value="'.$rs[1].'">'.$rs[1].'</option>';
        }
      }
    }else{
      $citys='<option value="'.$city.'">'.$city.'</option>';
    }
    $id=$db->select("setting","id","1 order by id desc");
    $id=$id ? $id+1 : 1;
    function gletter($str){
      $ret='';
       for($i=0;$i<strlen($str);$i++){
         $p=ord(substr($str,$i,1));
         if($p>160){
           $q=substr($str,$i,1).substr($str,++$i,1);
         }else{
           $q=substr($str,$i,1);
         }
         $ret.=strtoupper(substr(getletter($q),0,1));
       }
       return $ret;
    }
    include("../include/getletter.func.php");
    $companyid=getid($id,strlen($id) > 4 ? strlen($id)+1: 4,$Ntype=='prov' ? gletter($prov) : gletter($city));
    include("company_add.php");
    break;
  case'company_money':
    $cid=Char_Cv('cid','get');
    if(!$cid)ero('��������ȷ');
    $xxx=$Ntype=='prov' ? " infoprov='$prov'" : "infoprov='$prov' and infocity='$city' and agent='$username'";
    if($db->rows("setting","companyid='$cid' and $xxx")==0)ero('��û�н��и��������Ȩ��');
    $money=$db->page("money","id,content,money,addtime","companyid='$cid' order by id desc",20,"action=$action&cid=$cid");
    $MyTitle=$title='�ͻ�('.$cid.')������ϸ';
    include("company_money.php");
    break;
  case'company_log':
    $cid=Char_Cv('cid','get');
    if(!$cid)ero('��������ȷ');
    $xxx=$Ntype=='prov' ? " infoprov='$prov'" : "infoprov='$prov' and infocity='$city' and agent='$username'";
    if($db->rows("setting","companyid='$cid' and $xxx")==0)ero('��û�н��и��������Ȩ��');
    $log=$db->page("log","id,content,addtime","companyid='$cid' order by id desc",20,"action=$action&cid=$cid");
    $MyTitle=$title='�ͻ�('.$cid.')������־';
    include("company_log.php");
    break;
  case'my_money':
    $money=$db->page("money","id,content,money,addtime","agent='$username' order by id desc",20,"action=$action");
    $title='������ϸ';
    include("company_money.php");
    break;
  case'my_log':
    $log=$db->page("log","id,content,addtime","agent='$username' order by id desc",20,"action=$action");
    $title='������־';
    include("company_log.php");
    break;
  case'agent_money':
    $agent=Char_Cv('agent','get');
    if(!$agent)ero('��������ȷ');
    if($Ntype!='prov'){
      header('location:?action=main');
      exit;
    }
    if($db->rows("agent","username='$agent' and ntype='city' and prov='$prov'")==0)ero('��û�н��и��������Ȩ��');
    $money=$db->page("money","id,content,money,addtime","agent='$agent' order by id desc",20,"action=$action");
    $title='������ϸ';
    include("company_money.php");
    break;
  case'agent_log':
    $agent=Char_Cv('agent','get');
    if(!$agent)ero('��������ȷ');
    if($Ntype!='prov'){
      header('location:?action=main');
      exit;
    }
    if($db->rows("agent","username='$agent' and ntype='city' and prov='$prov'")==0)ero('��û�н��и��������Ȩ��');
    $log=$db->page("log","id,content,addtime","agent='$agent' order by id desc",20,"action=$action");
    $title='������־';
    include("company_log.php");
    break;
  case'agent_exp':
    $mytime=GetTime(date('Y-m-d',$time));
    if($Ntype!='prov'){
      header('location:?action=main');
      exit;
    }
    $expagent=$db->page("agent","city,content,company,exptime","prov='$prov' and ntype='city' and exptime<=".($mytime+86400*7)." order by exptime desc");
    include("agent_exp.php");
    break;
  case'company_exp':
    $mytime=GetTime(date('Y-m-d',$time));
    $xxx=$Ntype=='prov' ? " infoprov='$prov'" : "infoprov='$prov' and infocity='$city' and agent='$username'";
    $expcompany=$db->page("setting","id,companyid,agent,company,exptime","$xxx and exptime<=".($mytime+86400*7)." order by exptime desc");
    include("company_exp.php");
    break;
  case'gg_main':
    $ac='gg_main';
    $MyTitle=$title='��������';
    $ntype='gg_main_add';
    $ntype2='gg_main_edit';
    $Ads=$db->page("ads","id,thetext,theurl,hits,addtime","agent='$username' and ntype='main' order by id desc");
    include("ads.php");
    break;
  case'gg_dialog':
    $ac='gg_dialog';
    $MyTitle=$title='��ҳ�Ի�����';
    $ntype='gg_dialog_add';
    $ntype2='gg_dialog_edit';
    $Ads=$db->page("ads","id,thetext,theurl,hits,addtime","agent='$username' and ntype='dialog' order by id desc");
    include("ads.php");
    break;
  case'gg_login':
    $ntype=$ac='gg_login';
    $MyTitle=$title=$adtype='�����½���';
    $text='ͼƬ��ַ(301*191)';
    $btnname='����';
    if($gg=$db->record("ads","thetext,theurl","agent='$username' and ntype='login'",1)){
      $thetext=$gg[0]['thetext'];
      $theurl=$gg[0]['theurl'];
    }
    include("ads.php");
    break;
  case'gg_edit':
    $ntype=Char_Cv('ntype','get');
    if($ntype=='gg_dialog_add'){
      $ac='gg_dialog';
      $MyTitle=$title=$adtype='��ҳ�Ի�����';
      $text='�ı�';
      $btnname='���';
    }elseif($ntype=='gg_dialog_edit'){
      $ac='gg_dialog';
      $MyTitle=$title=$adtype='��ҳ�Ի�����';
      $text='�ı�';
      $btnname='�޸�';
      $id=Char_Cv('id','get');
      if(!$id || !is_numeric($id)){
        header("location:?action=gg_dialog");
        exit();
      }
      $gg=$db->record("ads","thetext,theurl","agent='$username' and ntype='dialog' and id=$id",1);
      if(!$gg)ero("��Ҫ�༭�����ݲ�����");
      $thetext=$gg[0]['thetext'];
      $theurl=$gg[0]['theurl'];
    }elseif($ntype=='gg_main_add'){
      $ac='gg_main';
      $MyTitle=$title=$adtype='��������';
      $text='�ı�';
      $btnname='���';
    }elseif($ntype=='gg_main_edit'){
      $ac='gg_main';
      $MyTitle=$title=$adtype='��������';
      $text='�ı�';
      $btnname='�޸�';
      $id=Char_Cv('id','get');
      if(!$id || !is_numeric($id)){
        header("location:?action=gg_main");
        exit();
      }
      $gg=$db->record("ads","thetext,theurl","agent='$username' and ntype='main' and id=$id",1);
      if(!$gg)ero("��Ҫ�༭�����ݲ�����");
      $thetext=$gg[0]['thetext'];
      $theurl=$gg[0]['theurl'];
    }else{
      header("location:?action=main");
      exit();
    }
    include("ads.php");
    break;
  case'help':
    $title='����˵������������';
    include("../eqmkdata/help.inc.php");
    include("help.php");
    break;
}
?>