<?
define('IN_ADMIN', TRUE);
include("check.php");
$action=Char_Cv('action','get');
function ToHelp($ac){
  return '[<a href="admin.php?action=help#'.$ac.'"><font color="#0000ff">?</font></a>]';
}
function turnfilesize($size){
  if($size<800){
    return '<font color="#666666">'.$size.' bytes</font>';
  }
  $size=$size/1024;
  if($size<800){
    return '<font color="green">'.(number_format($size,2)*1).' KB</font>';
  }
  $size=$size/1024;
  return '<font color="#ff0000">'.(number_format($size,2)*1).' MB</font>';
}
function timecolor($t){
  if($t>time()-3600)return'#ff0000';
  if($t>time()-3600*6)return'#ff8000';
  if($t>time()-3600*12)return'#dad125';
  if($t>time()-3600*24)return'#008000';
  if($t>time()-3600*24*3)return'#75958a';
  if($t>time()-3600*24*7)return'#0000ff';
  if($t>time()-3600*24*31)return'#800080';
  return '#999999';
}
switch($action){
  case'menu':
    include("../template/admin/$adminstyle/config.php");
    $logo='<img src="../images/admincp/logo.gif">';
    $Menu=array(//��������˵�
            array('��������',
               array(
                'main'=>'������ҳ',
                'config'=>'��������',
                'modify'=>'�޸�����',
                'logout'=>'ע���˳�'
               )
            ),
            array('�����̹���',
               array(
                'agent_prov'=>'����Χ�趨'
               )
            ),
            array('�ͻ�����',
               array(
                'company_add'=>'����¿ͻ�',
                'company'=>'�鿴���пͻ�'
               )
            ),
            array('���ܹ���',
               array(
                'funcommon'=>'��ѹ�������',
                'funsuper'=>'�շѹ�������',
                'package'=>'�ͷ��ײ�����'
               )
            ),
            array('���¹���',
               array(
                'addUpdate'=>'��Ӹ���',
                'Updatelist'=>'�����б�'
               )
            ),
            array('���Ź���',
               array(
                'addnews'=>'�������',
                'newslist'=>'�����б�'
               )
            ),
            array('��������',
               array(
                'addhelp'=>'��Ӱ���',
                'helplist'=>'�����б�'
               )
            ),
            array('����ҳ����',
               array(
                'page_about'=>'��������',
                'page_contact'=>'��ϵ��ʽ',
                'page_func'=>'���ܼ��',
                'page_soft'=>'�������'
               )
            ),
            array('������',
               array(
                'gg_dialog'=>'��ҳ�Ի����',
                'gg_login'=>'�����½���',
                'gg_main'=>'��������',
                'help#gg'=>'�������˵��'
               )
            ),
            array('���ݿ����',
               array(
                'runsql'=>'���ݿ�����',
                'checkdb'=>'���ݿ�У��',
                'viewdb'=>'�Ż�/�޸�',
                'sqlbak'=>'���ݿⱸ��',
                'sqlrest'=>'���ݿ⻹ԭ'
               )
            ),
            array('��Ʒ����',
               array(
                'explorer'=>'��������ļ�',
                'filechange'=>'�ѱ��޸��ļ�'
               )
            ),
            array('��������',
               array(
                'clearcache'=>'�������'
               )
            )
    );
    include("menu.php");
    break;
  case'main':
    function showResult($v){
      if($v==1){
        echo'<b>��</b>&nbsp;<font class=gray>֧��</font>';
      }else{
        echo'<font class=red><b>��</b></font>&nbsp;<font class=gray>��֧��</font>';
      }
    }
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
    $title='��̨������ҳ';
    $comcount1=$db->rows('setting','ntype=0');
    $comcount2=$db->rows('setting','ntype=1');
    $comcount3=$db->rows('setting','ntype=2');
    $sortcount=$db->rows('workersort','');
    $workercount=$db->rows('worker','');
    $onlinecount1=$db->rows('worker','online>0');
    $onlinecount2=$db->rows('client','lasttime>'.($time-90));
    
    //���´��������ڻ��ѹ���
    $mytime=GetTime(date('Y-m-d',$time));
    $expagent=$db->record("agent","ntype,prov,city,content,company,exptime","exptime<=".($mytime+86400*7)." order by exptime desc",12);
    //���¿ͻ��������ڻ��ѹ���
    $expcompany=$db->record("setting","id,companyid,agent,company,exptime","exptime<=".($mytime+86400*7)." order by exptime desc",12);
    
    //������ʾ
    $tips=array();
    if($demoversion=='Y')$tips[]='<font color=red>����ǰʹ�õ�Ϊ���԰汾�����ܽ������ӡ��޸ġ�ɾ���Ȳ�����</font>';
    if(!$homepage || substr($homepage,strlen($homepage)-1,1)!='/' || str_replace("admin/admin.php","","http://".$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"])!=$homepage)$tips[]='<font color=red>��û����ȷ���ó�����ַ,�ͷ������޷�����ʹ��</font> <a href="?action=config" style="color:blue">����</a>';
    if($lastaddress!=$thisaddress)$tips[]='<font color=red>���ĵ�½��Ϣ���ϴε�½��Ϣ����,��ע���˺Ű�ȫ��</font> <a href="?action=modify" style="color:blue">�޸�����</a>';
    if(!($partner && $alipaykey && $alipayid))$tips[]='��û������֧������Ϣ,���迪������֧������,����ȷ��д����������->֧�������á�';
    if(!$mycompanyqq || $db->rows("worker","mq=$mycompanyqq")==0)$tips[]='��û����ȷ���ùٷ��ͷ����,ǰ̨����վ���ӡ����ܲ����� <a href="?action=config" style="color:blue">����</a>';
    if($db->rows("function","price>0 and days<=0")>0)$tips[]='�շѹ��ܵġ���������������С��1 <a href="?action=funsuper" style="color:blue">����</a>';
    $nosafe=$db->record("agent","username,ntype,prov,city","password=md5(username)");
    if($nosafe){
      $s=array();
      foreach($nosafe as $rs){
        $s[]='<a href="admin.php?action=agent_set&type='.($rs['ntype']=='prov' ? 'prov&prov='.$rs['prov'] :'city&prov='.$rs['prov'].'&city='.$rs['city']).'">'.$rs['username'].'</a>';
      }
      $tips[]='���ִ�����('.implode(',',$s).')��ʹ��Ĭ�������½���뽨�����޸ģ�';
    }
    $tips=implode('<br />',$tips);
    include("main.php");
    break;
  case'config':
    if($freeday=='')$freeday=7;
    $title='������Ϣ����';
    $superfun=$db->record("function","keyname,title","price>0 and isused=1");
    $regfuns=explode(',',$regfuns);
    
    $agenttype=$default_agenttype=='1' ? 'checked' : '';
    include("config.php");
    break;
  case'modify':
    $title='�޸�����';
    include("modify.php");
    break;
  case'agent_prov':
    $title=$prov.'ʡʡ�����̹���';
    include("../eqmkdata/sort.inc.php");
    foreach($Province as $k=>$v){
      $agent=$db->select("agent","company","prov='".$v[0]."' and ntype='prov'");
      $vars.="&agent".$k."=".($agent ? $agent :'��');
      $vars.="&num".$k."=".$db->rows("setting","infoprov='".$v[0]."'");
      if($agent){;
        $vars.="&cnt".$k."=6";
      }
    }
    include("agent_prov.php");
    break;
  case'agent_city':
    $prov=Char_Cv('prov','get');
    if(!$prov){
      header('location:?action=agent_prov');
      exit;
    }
    $title=$prov.'ʡ�д����̹���';
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
    $type=Char_Cv('type','get');
    include("../include/getletter.func.php");
    $prov=Char_Cv('prov','get');
    if(!$prov){
      header('location:?action=agent_prov');
      exit;
    }
    if($type=='city'){
      $city=Char_Cv('city','get');
      if(!$city){
        header('location:?action=agent_city&prov='.$prov);
        exit;
      }
      $title=$prov.$city.'�ܴ���������';
      $thecity=$prov.$city;
      $xxx="prov='$prov' and city='$city' and ntype='city'";
    }else{
      $title=$prov.'�ܴ���������';
      $thecity=$prov;
      $xxx="prov='$prov' and ntype='prov'";
    }
    if($agent=$db->record("agent","id,username,company,content,money,paymoney,infotime,infotype,exptime,grade","$xxx",1)){
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
      $grade=$agent[0]['grade'];
      $etime_=intval(($exptime-GetTime(date('Y-m-d',$time)))/86400);
    }else{
      $ntype='add';
      $uname=getletter($prov);
      if($uname=='shanxi' && $prov=='ɽ��')$uname=='shanxi2';
      $pword=$uname;
      $companyname=$type=='prov' ? $prov.'�ܴ���' : $prov.$city.'�ܴ���';
    }
    $url=$type=='prov' ? 'action=company4&prov='.$prov : 'action=company5&prov='.$prov.'&city='.$city;
    include("agent_set.php");
    break;
  case'company':
    $title='���ҿͻ�';
    $mycompany=Char_Cv('mycompany','get');
    $loginname=Char_Cv('loginname','get');
    $agent=Char_Cv('agent','get');
    $prov_=Char_Cv('prov','get');
    $city_=Char_Cv('city','get');
    $package=Char_Cv('package','get');
    $moneya=Char_Cv('moneya','get');
    $moneyb=Char_Cv('moneyb','get');
    $paymoneya=Char_Cv('paymoneya','get');
    $paymoneyb=Char_Cv('paymoneyb','get');
    if($package=='' || !is_numeric($package))$package=-1;
    if(!$moneya || !is_numeric($moneya))$moneya=0;
    if(!$paymoneya || !is_numeric($paymoneya))$paymoneya=0;
    if(!$moneyb || !is_numeric($moneyb))$moneyb=99999;
    if(!$paymoneyb || !is_numeric($paymoneyb))$paymoneyb=99999;
    $xxx='1';
    if($mycompany)$xxx.=" and company like '%$mycompany%'";
    if($loginname)$xxx.=" and companyid like '%$loginname%'";
    if($agent)$xxx.=" and agent like '%$agent%'";
    if($prov_)$xxx.=" and infoprov='$prov_'";
    if($city_)$xxx.=" and infocity='$city_'";
    if($package!=-1)$xxx.=" and package=$package";
    $xxx.=" and money>=$moneya and money<=$moneyb";
    $xxx.=" and paymoney>=$paymoneya and paymoney<=$paymoneyb";
    $company=$db->page("setting","id,company,companyid,money,paymoney,infotime,hot,talk,comment,agent,infoprov,infocity,package","$xxx",20,$_SERVER['QUERY_STRING']);
    $Package=$db->record("package","id,title");
    unset($prov,$city);
    include("../eqmkdata/citylist.inc.php");
    include("company.php");
    break;
  case'company1':
    $title='��ѿͻ�';
    $company=$db->page("setting","id,company,companyid,money,paymoney,infotime,hot,talk,comment,agent,infoprov,infocity","ntype=0",20,"action=$action");
    include("company.php");
    break;
  case'company2':
    $title='���ѿͻ�';
    $company=$db->page("setting","id,company,companyid,money,paymoney,infotime,hot,talk,comment,agent,infoprov,infocity","ntype=1",20,"action=$action");
    include("company.php");
    break;
  case'company3':
    $title='ȫ���ܿͻ�';
    $company=$db->page("setting","id,company,companyid,money,paymoney,infotime,hot,talk,comment,agent,infoprov,infocity","ntype=2",20,"action=$action");
    include("company.php");
    break;
  case'company4':
    $prov=Char_Cv('prov','get');
    if(!$prov){
      header('location:?action=agent_prov');
      exit;
    }
    $company=$db->page("setting","id,company,companyid,money,paymoney,infotime,hot,talk,comment,agent,infoprov,infocity","infoprov='$prov'",20,"action=$action&prov=$prov");
    $MyTitle=$title=$prov.'�ͻ�';
    include("company.php");
    break;
  case'company5':
    $title='�д���ͻ�';
    $prov=Char_Cv('prov','get');
    $city=Char_Cv('city','get');
    if(!$prov){
      header('location:?action=agent_prov');
      exit;
    }
    if(!$city){
      header('location:?action=agent_city&prov='.$prov);
      exit;
    }
    $company=$db->page("setting","id,company,companyid,money,paymoney,infotime,hot,talk,comment,agent,infoprov,infocity","infoprov='$prov' and infocity='$city'",20,"action=$action&prov=$prov&city=$city");
    $MyTitle=$title=$prov.$city.'�ͻ�';
    include("company.php");
    break;
  case'companyedit':
    $id=Char_Cv('id','get');
    if(!$id || !is_numeric($id))ero('��������ȷ',1);
    $setting=$db->record("setting","companyid,company,money,paymoney,infotime,infoip,exptime,ntype,agent,infoprov,infocity,package","id=$id",1);
    if(!$setting)ero('��Ҫ�༭�����ݲ�����',1);
    $companyid=$setting[0]['companyid'];
    $company=$setting[0]['company'];
    $money=$setting[0]['money'];
    $paymoney=$setting[0]['paymoney'];
    $infotime=$setting[0]['infotime'];
    $infoip=$setting[0]['infoip'];
    $exptime=$setting[0]['exptime'];
    $ntype=$setting[0]['ntype'];
    $agent=$setting[0]['agent'];
    $infoprov=$setting[0]['infoprov'];
    $infocity=$setting[0]['infocity'];
    $package=$setting[0]['package'];
    
    $mytime=GetTime(date('Y-m-d',$time));
    
    $ac=$ntype==2 ? 'company3' : ($paymoney>0 ? 'company2' : 'company1');
    $etime_=intval(($exptime-GetTime(date('Y-m-d',$time)))/86400);
    $funs=$db->record("function","keyname,title,price","isused=1");
    $myfuns=array();
    if($package>0){
      $thefun=$db->record("package","funs","id=$package");
      $myfuns=$myfuns2=explode(',',$thefun[0]['funs']);
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
    $Package=$db->record("package","id,title");
    include("companyedit.php");
    break;
  case'company_money':
    $cid=Char_Cv('cid','get');
    if(!$cid)ero('��������ȷ');
    $money=$db->page("money","id,content,money,addtime","companyid='$cid' order by id desc",20,"action=$action&cid=$cid");
    $title='�ͻ�������ϸ';
    include("company_money.php");
    break;
  case'company_log':
    $cid=Char_Cv('cid','get');
    if(!$cid)ero('��������ȷ');
    $log=$db->page("log","id,content,addtime","companyid='$cid' order by id desc",20,"action=$action&cid=$cid");
    $title='�ͻ�������־';
    include("company_log.php");
    break;
  case'agent_money':
    $agent=Char_Cv('agent','get');
    if(!$agent)ero('��������ȷ');
    $money=$db->page("money","id,content,money,addtime","agent='$agent' order by id desc",20,"action=$action&agent=$agent");
    $title='������('.$agent.')������ϸ';
    include("company_money.php");
    break;
  case'agent_log':
    $agent=Char_Cv('agent','get');
    if(!$agent)ero('��������ȷ');
    $log=$db->page("log","id,content,addtime","agent='$agent' order by id desc",20,"action=$action&agent=$agent");
    $title='������('.$agent.')������־';
    include("company_log.php");
    break;
  case'agent_exp':
    $mytime=GetTime(date('Y-m-d',$time));
    $expagent=$db->page("agent","ntype,prov,city,content,company,exptime","exptime<=".($mytime+86400*7)." order by exptime desc");
    include("agent_exp.php");
    break;
  case'company_add':
    $MyTitle=$title='����¿ͻ�';
    include("../eqmkdata/citylist.inc.php");
    $id=$db->select("setting","id","1 order by id desc");
    $id=$id ? $id+1 : 1;
    $companyid=getid($id,strlen($id) > 4 ? strlen($id)+1: 4,'KF');
    include("company_add.php");
    break;
  case'company_exp':
    $mytime=GetTime(date('Y-m-d',$time));
    $expcompany=$db->page("setting","id,companyid,agent,company,exptime","exptime<=".($mytime+86400*7)." order by exptime desc");
    include("company_exp.php");
    break;
  case'funcommon':
    $function=$db->record("function","id,title,isused,price,days,content","price=0");
    $title='��ѹ�������';
    include("function.php");
    break;
  case'funsuper':
    $function=$db->record("function","id,title,isused,price,days,content","price>0");
    $title='�շѹ�������';
    include("function.php");
    break;
  case'editfunction':
    $id=Char_Cv('id','get');
    if(!$id || !is_numeric($id))ero('��������ȷ',1);
    $function=$db->record("function","title,isused,price,days,content","id=$id",1);
    if(!$function)ero('��Ҫ�༭�Ĺ��ܲ�����',1);
    $title_=$function[0]['title'];
    $isused=$function[0]['isused']==1 ? 'checked':'';
    $price=$function[0]['price'];
    $days=$function[0]['days'];
    $content=$function[0]['content'];
    $title='�༭�ͷ�����';
    include("editfunction.php");
    break;
  case'addnews':
    $title='�������';
    $ntype="news";
    $btnname=' ��� ';
    include("articleedit.php");
    break;
  case'editnews':
    $title='�޸�����';
    $ntype="news";
    $btnname=' �޸� ';
    $id=Char_Cv('id','get');
    if(!$id || !is_numeric($id))ero('��������ȷ',1);
    $article=$db->record("article","title,content,author,comefrom","id=$id",1);
    if(!$article)ero('��Ҫ�༭�����ݲ�����',1);
    $title_=$article[0]['title'];
    $author=$article[0]['author'];
    $company=$article[0]['comefrom'];
    $content=$article[0]['content'];
    include("articleedit.php");
    break;
  case'newslist':
    $title='�����б�';
    $ntype='news';
    $ti='����';
    $Article=$db->page("article","id,title,hits,updatetime","ntype='news' order by updatetime desc",20,"action=$action");
    include("article.php");
    break;
  case'addUpdate':
    $title='��Ӹ���';
    $ntype="Update";
    $btnname=' ��� ';
    include("articleedit.php");
    break;
  case'editUpdate':
    $title='�޸ĸ���';
    $ntype="Update";
    $btnname=' �޸� ';
    $id=Char_Cv('id','get');
    if(!$id || !is_numeric($id))ero('��������ȷ',1);
    $article=$db->record("article","title,content,author,comefrom","id=$id",1);
    if(!$article)ero('��Ҫ�༭�����ݲ�����',1);
    $title_=$article[0]['title'];
    $author=$article[0]['author'];
    $company=$article[0]['comefrom'];
    $content=$article[0]['content'];
    include("articleedit.php");
    break;
  case'Updatelist':
    $title='�����б�';
    $ntype='news';
    $ti='����';
    $Article=$db->page("article","id,title,hits,updatetime","ntype='Update' order by updatetime desc",20,"action=$action");
    include("article.php");
    break;
  case'addhelp':
    $title='��Ӱ���';
    $ntype="help";
    $btnname=' ��� ';
    include("articleedit.php");
    break;
  case'edithelp':
    $title='�޸İ���';
    $ntype="help";
    $btnname=' �޸� ';
    $id=Char_Cv('id','get');
    if(!$id || !is_numeric($id))ero('��������ȷ',1);
    $article=$db->record("article","title,content","id=$id",1);
    if(!$article)ero('��Ҫ�༭�����ݲ�����',1);
    $title_=$article[0]['title'];
    $content=$article[0]['content'];
    include("articleedit.php");
    break;
  case'helplist':
    $title='�����б�';
    $ntype='help';
    $ti='����';
    $Article=$db->page("article","id,title,hits,updatetime","ntype='help' order by updatetime desc",20,"action=$action");
    include("article.php");
    break;
  case'page_index':
    $title='��ҳ���ݶ���';
    $ntype='index';
    $ti='���';
    $Article=$db->page("article","id,title,hits,updatetime","ntype='index' order by id asc",20,"action=$action");
    include("article.php");
    break;
  case'page_index_add':
    $title='�����ҳ����';
    $ntype="index";
    $btnname=' ��� ';
    include("articleedit.php");
    break;
  case'editindex':
    $title='�޸���ҳ����';
    $ntype="index";
    $btnname=' �޸� ';
    $id=Char_Cv('id','get');
    if(!$id || !is_numeric($id))ero('��������ȷ',1);
    $article=$db->record("article","title,content","id=$id",1);
    if(!$article)ero('��Ҫ�༭�����ݲ�����',1);
    $title_=$article[0]['title'];
    $content=$article[0]['content'];
    include("articleedit.php");
    break;
  case'page_func':
    $title='����ҳ���� - ���ܼ��';
    $ntype="page";
    $btnname=' �޸� ';
    $article=$db->record("article","title,content","ntype='page_func'",1);
    if(!$article){
      $title_='���ܼ��';
      $content='��';
      $db->insert('article',"ntype,title,content,addtime,updatetime","page_func|���ܼ��|��|$time|$time");
    }else{
      $title_=$article[0]['title'];
      $content=$article[0]['content'];
    }
    include("articleedit.php");
    break;
  case'page_about':
    $title='����ҳ���� - ��������';
    $ntype="page";
    $btnname=' �޸� ';
    $article=$db->record("article","title,content","ntype='page_about'",1);
    if(!$article){
      $title_='��������';
      $content='��';
      $db->insert('article',"ntype,title,content,addtime,updatetime","page_about|�ͻ�����|��|$time|$time");
    }else{
      $title_=$article[0]['title'];
      $content=$article[0]['content'];
    }
    include("articleedit.php");
    break;
  case'page_contact':
    $title='����ҳ���� - ��ϵ��ʽ';
    $ntype="page";
    $btnname=' �޸� ';
    $article=$db->record("article","title,content","ntype='page_contact'",1);
    if(!$article){
      $title_='���ܼ��';
      $content='��';
      $db->insert('article',"ntype,title,content,addtime,updatetime","page_contact|��ϵ��ʽ|��|$time|$time");
    }else{
      $title_=$article[0]['title'];
      $content=$article[0]['content'];
    }
    include("articleedit.php");
    break;
  case'page_soft':
    $title='����ҳ���� - �������';
    $ntype="page";
    $btnname=' �޸� ';
    $article=$db->record("article","title,content","ntype='page_soft'",1);
    if(!$article){
      $title_='���ܼ��';
      $content='��';
      $db->insert('article',"ntype,title,content,addtime,updatetime","page_soft|�������|��|$time|$time");
    }else{
      $title_=$article[0]['title'];
      $content=$article[0]['content'];
    }
    include("articleedit.php");
    break;
  case'package':
    $package=$db->page("package","id,title,price,dayti,funcos","1",20,"&action=$action");
    $title='�ͷ��ײ�����';
    include("package.php");
    break;
  case'addpackage':
    $title='������ײ�';
    $dayTis=array('��','��','��','����','��');
    $dayTis2=array(1,7,30,90,365);
    $dayti='��';
    $day='1';
    $price='1';
    $superfun=$db->record("function","keyname,title,content","price>0 and isused=1");
    $regfuns=array();
    $btnname='�������';
    include("packageEdit.php");
    break;
  case'editpackage':
    $id=Char_Cv('id','get');
    if(!$id || !is_numeric($id))ero('��������ȷ',1);
    $package=$db->record("package","title,price,dayti,day,content,funs","id=$id",1);
    if(!$package)ero('��Ҫ�༭�����ݲ�����',1);
    $title='�༭�ײ�';
    $dayTis=array('��','��','��','����','��');
    $dayTis2=array(1,7,30,90,365);
    $ti=$package[0]['title'];
    $dayti=$package[0]['dayti'];
    $day=$package[0]['day'];
    $price=$package[0]['price'];
    $content=$package[0]['content'];
    $superfun=$db->record("function","keyname,title,content","price>0 and isused=1");
    $regfuns=explode(',',$package[0]['funs']);
    $btnname='�����޸�';
    include("packageEdit.php");
    break;
  case'runsql':
    $title='���ݿ�����';
    include("runsql.php");
    break;
  case'checkdb':
    $title='���ݿ�У��';
    $tmpData=@readover('../install/eqmk.sql');
    if(!$tmpData)exit('<h1>install/eqmk.sql�ļ�������</h1>');
    preg_match_all("/CREATE TABLE (.+?) \(([^$]+)\) TYPE=MyISAM;/iU",$tmpData, $arrayTmp);
    $a=$arrayTmp[1];
    $b=$arrayTmp[2];
    $table=array();
    for($i=0;$i<count($a);$i++){
      preg_match_all("/\s+(.+?)\s(char|int|longtext|datetime)/i",$b[$i], $arrayTmp2);
      $c=array();
      for($k=0;$k<count($arrayTmp2[1]);$k++){
        $c[]=$arrayTmp2[1][$k];
      }
      $a[$i]=str_replace('eyhc_',$tbl,$a[$i]);
      $a[$i]=str_replace('eqmk_',$tbl,$a[$i]);
      $table[]='����У�����ݱ�'.$a[$i].'......'.($db->query('select '.implode(',',$c).' from '.$a[$i].' limit 1') ? '<font color="green">��������</font>' :'<font color="red">����ʧ��</font>');
    }
    include("showtable.php");
    break;
  case'gg_main':
    $ac='gg_main';
    $MyTitle=$title='��������';
    $ntype='gg_main_add';
    $ntype2='gg_main_edit';
    $Ads=$db->page("ads","id,thetext,theurl,hits,addtime","admin<>'' and ntype='main' order by id desc");
    include("ads.php");
    break;
  case'gg_dialog':
    $ac='gg_dialog';
    $MyTitle=$title='��ҳ�Ի�����';
    $ntype='gg_dialog_add';
    $ntype2='gg_dialog_edit';
    $Ads=$db->page("ads","id,thetext,theurl,hits,addtime,companyid","admin<>'' and ntype='dialog' order by id desc");
    include("ads.php");
    break;
  case'gg_login':
    $ntype=$ac='gg_login';
    $MyTitle=$title=$adtype='�����½���';
    $text='ͼƬ��ַ(301*191)';
    $btnname='����';
    if($gg=$db->record("ads","thetext,theurl","admin<>'' and ntype='login'",1)){
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
      $gg=$db->record("ads","thetext,theurl","admin<>'' and ntype='dialog' and id=$id",1);
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
      $gg=$db->record("ads","thetext,theurl","admin<>'' and ntype='main' and id=$id",1);
      if(!$gg)ero("��Ҫ�༭�����ݲ�����");
      $thetext=$gg[0]['thetext'];
      $theurl=$gg[0]['theurl'];
    }else{
      header("location:?action=main");
      exit();
    }
    include("ads.php");
    break;
  case'explorer':
    $title='��������ļ�';
    $tplpath=Char_Cv('path','get');
    if(!$tplpath)$tplpath='..';
    if(substr($tplpath,3)=='../'){
      $tplpath=str_replace('../','',$tplpath);
    }
    if(strpos($tplpath,"/")){
      $parentpath=preg_replace("/\/([^\/]+)$/","",$tplpath);
      $parentpath='<font face="Wingdings">1</font> <a href="?action=explorer&path='.urlencode($parentpath).'">���ϼ�Ŀ¼��</a>';
    }else{
      $parentpath='<font face="Wingdings">0</font> ���ϼ�Ŀ¼��';
    }
    $folder=$files=array();
    $dh=opendir($tplpath);
    while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
        if(is_dir($tplpath.'/'.$file) && $file!='filebaks') {
          $folder[$file]=$file;
        }
      }
    }
    closedir($dh);
    $dh=opendir($tplpath);
    while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
        if(!is_dir($tplpath.'/'.$file)) {
          $files[$file]=array($file,turnfilesize(filesize($tplpath.'/'.$file)),date('Y-m-d H:i:s',filemtime($tplpath.'/'.$file)+$timezone*60*60),(file_exists('../eqmkdata/filebaks/'.urlencode($tplpath.'/'.$file.'.php'))?true:false),timecolor(filemtime($tplpath.'/'.$file)));
        }
      }
    }
    closedir($dh);
    ksort($folder);
    ksort($files);
    include("explorer.php");
    break;
  case'editfile':
    $title='�޸��ļ�';
    $file=Char_Cv('file','get');
    $path=Char_Cv('path','get');
    if($path=='../eqmkdata/filebaks')die('Error');
    if(substr($file,5)=='../..')die('Error');
    $todefault=Char_Cv('todefault','get');
    if($todefault=='Y'){
      $co=file_exists('../eqmkdata/filebaks/'.urlencode($file).'.php') ? @readover('../eqmkdata/filebaks/'.urlencode($file).'.php') : @readover($file);
      writeover($file,$co);
      @unlink('../eqmkdata/filebaks/'.urlencode($file).'.php');
    }else{
      $co=@readover($file);
      if(file_exists('../eqmkdata/filebaks/'.urlencode($file).'.php'))$defaultfile=true;
    }
    $co=str_replace('</textarea>','&lt;/textarea&gt;',$co);
    $A=explode("\n",$co);
    $B='';
    for($i=0;$i<count($A);$i++){
      if($B)$B.="\n";
      $B.=substr('   '.($i+1),-4)."��".$A[$i];
    }
    $co=$B;
    include("editfile.php");
    break;
  case'filechange':
    $title='�ѱ��޸Ĺ����ļ�';
    $tplpath='../eqmkdata/filebaks';
    $dh=opendir($tplpath);
    $files=array();
    while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
        if(!is_dir($tplpath.'/'.$file)) {
          $file2=@urldecode(substr($file,0,strlen($file)-4));
          if($file2){
            $files[filemtime($file2)]=array($file2,turnfilesize(filesize($tplpath.'/'.$file)),turnfilesize(filesize($file2)),date('Y-m-d H:i:s',filemtime($file2)+$timezone*60*60),timecolor(filemtime($file2)));
          }
        }
      }
    }
    closedir($dh);
    krsort($files);
    include("filebaks.php");
    break;
  case'runsql':
    $title='���ݿ�����';
    include("runsql.php");
    break;
  case'checkdb':
    $title='���ݿ�У��';
    $tmpData=@readover('../install/eqmk.sql');
    if(!$tmpData)exit('<h1>install/eqmk.sql�ļ�������</h1>');
    preg_match_all("/CREATE TABLE (.+?) \(([^$]+)\) (TYPE|ENGINE)=MyISAM;/iU",$tmpData, $arrayTmp);
    $a=$arrayTmp[1];
    $b=$arrayTmp[2];
    $table=array();
    for($i=0;$i<count($a);$i++){
      $a[$i]=str_replace('eqmk_',$tbl,$a[$i]);
      $result=$db->query("SHOW FIELDS FROM ".$a[$i]);
      $fieldlist=array();
      while($data=mysql_fetch_array($result)) {
        $fieldlist[]=$data['Field'];
      }
      preg_match_all("/\s+(.+?)\s(char|int|longtext|datetime)/i",$b[$i], $arrayTmp2);
      $same=true;
      $errorfield=array();
      for($k=0;$k<count($arrayTmp2[1]);$k++){
        $arrayTmp2[1][$k]=str_replace('`','',$arrayTmp2[1][$k]);
        if(!in_array($arrayTmp2[1][$k],$fieldlist)){
          $same=false;
          $errorfield[]='<u>'.$arrayTmp2[1][$k].'</u>';
        }
      }
      $table[]='����У�����ݱ�'.$a[$i].'......'.($same ? '<font color="green">��������</font>' :'<font color="red">����ʧ��</font>(�ֶ�'.implode('��',$errorfield).'������)');
    }
    include("showtable.php");
    break;
  case'viewdb':
    $title='�Ż�/�޸����ݿ�';
    include("viewdb.php");
    break;
	
  case'sqlbak':
    $title='���ݿⱸ��';
    include("backup.php");
    break;
	
  case'sqlrest':
    $title='���ݿ⻹ԭ';
    include("restore.php");
    break;
	
  case'viewtable':
    $table=Char_Cv('table','get');
    $title='�鿴��ṹ';
    function sqldumptable($table) {
      global $DB_site;
      $tabledump = "DROP TABLE IF EXISTS $table;\n";
      $tabledump .= "CREATE TABLE $table (\n";
      $firstfield=1;
      $fields = mysql_query("SHOW FIELDS FROM $table");
      while ($field = mysql_fetch_array($fields)) {
        if (!$firstfield) {$tabledump .= ",\n";} else {$firstfield=0;}
        $tabledump .= "  $field[Field] $field[Type]";
        if ($field[Null] != "YES") {$tabledump .= " NOT NULL";}
        if (!empty($field["Default"])) {$tabledump .= " DEFAULT '$field[Default]'";}
        if ($field[Extra] != "") {$tabledump .= " $field[Extra]";}
      }
      mysql_free_result($fields);
      $keys = mysql_query("SHOW KEYS FROM $table");
      while ($key = mysql_fetch_array($keys)) {
        $kname=$key['Key_name'];
        if ($kname != "PRIMARY" and $key['Non_unique'] == 0) { $kname="UNIQUE|$kname";}
        if(!is_array($index[$kname])) { $index[$kname] = array();}
        $index[$kname][] = $key['Column_name'];
      }
      mysql_free_result($keys);
      // get each key info
      while(list($kname, $columns) = @each($index)){
        $tabledump .= ",\n";
        $colnames=implode($columns,",");
        
        if($kname == "PRIMARY"){ $tabledump .= "  PRIMARY KEY ($colnames)";} 
        else {
        if (substr($kname,0,6) == "UNIQUE") {
          // key is unique
          $kname=substr($kname,7);
        }
        
        $tabledump .= "  KEY $kname ($colnames)";
        
        }
      }
      
      $tabledump .= "\n) TYPE=MyISAM;\n\n";
    
      return $tabledump;
    }
    $table=sqldumptable($table);
    $table=preg_replace("/(DROP|CREATE|TABLE| IF | NOT| NULL|PRIMARY |KEY )/i",'<font color="#800080">$1</font>',$table);
    $table=preg_replace("/\(([0-9]+)\)/i",'(<font color="#ff0000">$1</font>)',$table);
    $table=str_replace("\n","<br>",$table);
    $table=str_replace("  ","&nbsp;&nbsp;",$table);
    $table=array('<div style="font-family:Fixedsys">'.$table.'</div>');
    include("showtable.php");
    break;
  case'clearcache':
    $title='�������';
    include("clearcache.php");
    break;
  case'upfiles':
    $title='�ϴ��ļ�����';
    include("showtable.php");
    break;
  case'help':
    $title='����˵������������';
    include("../eqmkdata/help.inc.php");
    include("help.php");
    break;
}
?>