<?
include_once("include/common.inc.php");
switch(Char_Cv('action','get')){
  case 'checkcompanyid':
    $cid=Char_Cv('cid');
    print($db->rows('setting',"companyid='$cid'")?'N':'Y');
    exit();
    break;
  case 'save':
    $cid=Char_Cv('companyid');
    $pass1=Char_Cv('pass1');
    $pass2=Char_Cv('pass2');
    $email=Char_Cv('email');
    $url=Char_Cv('url');
    $upuser=Char_Cv('upuser');
    if(!$cid || !$pass1 || !$pass2 || !$email || !$url)ero($language['reg_error_save_imperfect']);
    if($pass1 !=$pass2)ero($language['reg_error_pass2_distinct']);
    if($db->rows('setting',"companyid='$cid'"))ero($language['reg_error_companyid_exists']);
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
      WriteLog($cid,"免费开通","试用高级功能“".$regfuns."”,有效期至".date('Y-m-d',$exptime));
      $regfuns=explode(',',$regfuns);
      foreach($regfuns as $v){
        $db->insert('myfunction','companyid,keyname,starttime,exptime',"$cid|$v|$time|$exptime");
      }
    }
    //根据注册IP选择所属代理商
    $address=getaddress($onlineip,true);
    $infoaddr=SelAgent($address);
    $infoprov=$infoaddr[0];
    $infocity=$infoaddr[1];
    if($infocity){
      $agent=$db->select("agent","username","prov='$infoprov' and city='$infocity' and ntype='city'");
    }
    if($infoprov && !$agent){
      $agent=$db->select("agent","username","prov='$infoprov' and ntype='prov'");
    }
    $ntype=$fullfun=='1' ? 2 : 0;
    $upuser=$db->select("setting","companyid","companyid='$upuser'");
    $db->insert('setting','companyid,status,company,infotime,exptime,grade,agent,infoprov,infocity,ntype,upuser',"$cid|1|$cid|$time|$exptime|$myfun|$agent|$infoprov|$infocity|$ntype|$upuser");
    $db->insert('workersort','companyid,sort',"$cid|$default_workersort");
    $sid=$db->select('workersort','id',"companyid='$cid' order by id desc");
    $pass=md5($pass2);
    $db->insert('worker','companyid,sortid,grade,username,password,email,nickname,thisip,thistime,thisaddress,logincount',"$cid|$sid|all|$cid|$pass|$email|$default_worker|$onlineip|$now|$address|1");
    WriteLog($cid,"注册账号","成功注册账号并已开通！");
    
    $_SESSION["eqmk_worker_companyid"]=$cid;
    $_SESSION["eqmk_worker_username"]=$cid;
    
    header("location:member/manage.php");
    exit();
    break;
}
$Update=$db->record("article","id,title,updatetime","ntype='Update' order by updatetime desc",9);
$title=$title_=$language['reg'];
include_once("left.php");
include template('header');
include template('reg');
include template('footer');
?>