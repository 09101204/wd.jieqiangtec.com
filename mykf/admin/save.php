<?php
include("check.php");
if(strtolower(substr($_SERVER['HTTP_REFERER'],7,strlen($_SERVER["SERVER_NAME"])))!=$_SERVER["SERVER_NAME"])exit("来源不合法");
if($demoversion=='Y')ero('您当前使用的为测试版本，不能进行增加、修改、删除等操作！');
$action=Char_Cv("action","get");
switch($action){
  case"config":
    $myqq=Char_Cv("mycompanyqq");
    if($myqq<$MQStart || !is_numeric($myqq))$myqq='';
    writeover("../config.inc.php","<?php
\$company='".Char_Cv("company")."';
\$homepage='".Char_Cv("homepage")."';
\$dialoglogo='".Char_Cv("dialoglogo")."';
\$dialoglogourl='".Char_Cv("dialoglogourl")."';
\$mycompanyqq='".$myqq."';
\$timezone='".Char_Cv("timezone")."';
\$allowreg='".(Char_Cv("allowreg")?'1':'0')."';
\$default_agenttype='".(Char_Cv("default_agenttype")?'1':'0')."';
\$regfuns='".@implode(',',Char_Cv("regfun"))."';
\$freeday='".Char_Cv("freeday")."';
\$autolock='".(Char_Cv("autolock")?'1':'0')."';
\$price_sort='".Char_Cv("price_sort")."';
\$price_worker='".Char_Cv("price_worker")."';
\$price_days1='".Char_Cv("price_days1")."';
\$price_days2='".Char_Cv("price_days2")."';
\$price_allfun='".Char_Cv("price_allfun")."';
\$default_workersort='".Char_Cv("default_workersort")."';
\$default_worker='".Char_Cv("default_worker")."';
\$default_sortcount='".Char_Cv("default_sortcount")."';
\$default_workercount='".Char_Cv("default_workercount")."';
\$maxfilesize='".Char_Cv("maxfilesize")."';
\$allowfiletype='".str_replace('｜','|',Char_Cv("allowfiletype"))."';
\$companyurl='".Char_Cv("companyurl")."';
\$softtitle='".Char_Cv("softtitle")."';
\$closeloginad='".(Char_Cv("closeloginad")?'1':'0')."';
\$closemainad='".(Char_Cv("closemainad")?'1':'0')."';
\$closefile='".(Char_Cv("closefile")?'1':'0')."';
\$closecatch='".(Char_Cv("closecatch")?'1':'0')."';
\$closepublic='".(Char_Cv("closepublic")?'1':'0')."';
\$closelimit='".(Char_Cv("closelimit")?'1':'0')."';
\$lang_web='".Char_Cv("lang_web")."';
\$lang_dialog='".Char_Cv("lang_dialog")."';
\$alipayid='".Char_Cv("alipayid")."';
\$alipaykey='".Char_Cv("alipaykey")."';
\$partner='".Char_Cv("partner")."';
\$smtp_mail='".Char_Cv("smtp_mail")."';
\$smtp_smtp='".Char_Cv("smtp_smtp")."';
\$smtp_psd='".Char_Cv("smtp_psd")."';
\$tpldir='".Char_Cv("tpldir")."';
\$demoversion='$demoversion';
\$tpldir='$tpldir';
\$dbtype='$dbtype';//数据库类型
\$tbl='$tbl';//数据表前缀
\$dbhost='$dbhost';//数据库地址
\$dbuser='$dbuser';//数据库用户名
\$dbpass='$dbpass';//数据库密码
\$dbname='$dbname';//数据库名
\$charset='$charset';//MySQL 字符集, 可选 'gbk', 'big5', 'utf8', 'latin1', 留空为按照网站字符集设定
\$wcharset='gbk';//网站页面默认字符集, 可选 'gbk', 'big5', 'utf-8'
\$headercharset=1;//强制网站页面使用默认字符集，可避免部分服务器空间页面出现乱码，一般无需开启。 0=关闭 1= 开启

?>");
    writeover("../member/mail.config.inc.php","<?php
met_fd_fromname=".Char_Cv("homepage").";

met_fd_usename=".Char_Cv("smtp_mail").";
met_fd_smtp=".Char_Cv("smtp_smtp").";
met_fd_password=".Char_Cv("smtp_psd").";

tablepre=$tbl;
con_db_host=$dbhost;
con_db_id=$dbuser;
con_db_pass=$dbpass;
con_db_name=$dbname;
db_charset=$charset;
?>");
    $myqq ? ero("操作成功",1) : ero("官方客服编号填写无效",1);
    break;
  case"setstyle":
    $curstyle=Char_Cv("curstyle","get");
    $db->update("admin","style",$curstyle,"username='$username'");
    echo"<script type=\"text/javascript\">";
    if($curstyle!==$adminstyle){
      echo'parent.frames["menu"].location.reload();';
    }
    echo"location.href='admin.php?action=main'</script>";
    break;
  case"modify"://修改资料
    $pass0=Char_Cv("pass0");
    $pass1=Char_Cv("pass1");
    $pass2=Char_Cv("pass2");
    if($pass0){
      $pass=md5($pass0);
      $newpass=md5($pass2);
      if($db->rows("admin","username='$username' and password='$pass'")==0){
        ero("您的旧密码输入不正确",1);
      }else{
        $db->update("admin","password","$newpass","username='$username'");
      }
    }
    ero("修改资料成功","admin.php?action=modify");
    break;
  case"runsql":
    $thesql=Char_Cv("thesql");
    $pwd=Char_Cv("pwd");
    if(!$thesql)ero('请输入您要执行的SQL语句');
    if(!$pwd)ero('请输入您的密码');
    $pass=md5($pwd);
    $thesql=str_replace('eqmk_',$tbl,$thesql);
    $thesql=str_replace('eyhc_',$tbl,$thesql);
    if($db->rows("admin","username='$username' and password='$pass'")==0){
      ero("您的密码不正确",1);
    }else{
      $db->query($thesql) ? ero("SQL语句执行成功",1) :ero("SQL语句执行失败",1);
    }
    break;
  case"editfunction"://
    $id=Char_Cv("id");
    $title=Char_Cv("title");
    $isused=Char_Cv("isused");
    $price=Char_Cv("price");
    $days=Char_Cv("days");
    $content=Char_Cv("content");
    $db->update("function","title,isused,price,days,content","$title|$isused|$price|$days|$content","id=$id");
    ero("修改成功","admin.php?action=".($price==0?'funcommon':'funsuper'));
    break;
  case"function"://
    $action_=Char_Cv("action_",'get');
    $isused=Char_Cv("isused");
    $price=Char_Cv("price");
    $days=Char_Cv("days");
    foreach($isused as $k=>$v){
      $days[$k]=abs(intval($days[$k]));
      if($days[$k]==0)$days[$k]=1;
      $a=$isused[$k]?'1':'0';$b=abs($price[$k]);$c=$days[$k];
      $db->update("function","isused,price,days","$a|$b|$c","id=$k");
    }
    ero("修改成功","admin.php?action=".$action_);
    break;
  case"addnews"://
    $title=Char_Cv("title");
    $author=Char_Cv("author");
    $comefrom=Char_Cv("comefrom");
    $db->insert("article","ntype,title,author,comefrom,content,addtime,updatetime","news|$title|$author|$comefrom|content1|$time|$time");
    ero("添加成功","admin.php?action=newslist");
    break;
  case"editnews"://
    $id=Char_Cv("id");
    $title=Char_Cv("title");
    $author=Char_Cv("author");
    $comefrom=Char_Cv("comefrom");
    $db->update("article","title,author,comefrom,content,updatetime","$title|$author|$comefrom|content1|$time","id=$id");
    ero("修改成功","admin.php?action=newslist");
    break;
  case"addUpdate"://
    $title=Char_Cv("title");
    $author=Char_Cv("author");
    $comefrom=Char_Cv("comefrom");
    $db->insert("article","ntype,title,author,comefrom,content,addtime,updatetime","Update|$title|$author|$comefrom|content1|$time|$time");
    ero("添加成功","admin.php?action=Updatelist");
    break;
  case"editUpdate"://
    $id=Char_Cv("id");
    $title=Char_Cv("title");
    $author=Char_Cv("author");
    $comefrom=Char_Cv("comefrom");
    $db->update("article","title,author,comefrom,content,updatetime","$title|$author|$comefrom|content1|$time","id=$id");
    ero("修改成功","admin.php?action=Updatelist");
    break;
  case"addhelp"://
    $title=Char_Cv("title");
    $db->insert("article","ntype,title,content,addtime,updatetime","help|$title|content1|$time|$time");
    ero("添加成功","admin.php?action=helplist");
    break;
  case"edithelp"://
    $id=Char_Cv("id");
    $title=Char_Cv("title");
    $db->update("article","title,content,updatetime","$title|content1|$time","id=$id");
    ero("修改成功","admin.php?action=helplist");
    break;
  case"delarticle2"://
    $ntype=Char_Cv("ntype","get");
    $id=Char_Cv("id");
    if(!$id)ero("您没有选择任何内容",1);
    for($i=0;$i<count($id);$i++){
      $db->delete("article","id=".$id[$i]);
    }
    $ac=$ntype=='index' ? 'page_index' :$ntype.'list';
    ero("删除成功","admin.php?action=".$ac);
    break;
  case"page_index_add"://
    $title=Char_Cv("title");
    $db->insert("article","ntype,title,content,addtime,updatetime","index|$title|content1|$time|$time");
    ero("添加成功","admin.php?action=page_index");
    break;
  case"editindex"://
    $id=Char_Cv("id");
    $title=Char_Cv("title");
    $db->update("article","title,content,updatetime","$title|content1|$time","id=$id");
    ero("修改成功","admin.php?action=page_index");
    break;
  case"page_about"://
    $title=Char_Cv("title");
    $db->update("article","title,content,updatetime","$title|content1|$time","ntype='$action'");
    ero("修改成功","admin.php?action=$action");
    break;
  case"page_contact"://
    $title=Char_Cv("title");
    $db->update("article","title,content,updatetime","$title|content1|$time","ntype='$action'");
    ero("修改成功","admin.php?action=$action");
    break;
  case"page_func"://
    $title=Char_Cv("title");
    $db->update("article","title,content,updatetime","$title|content1|$time","ntype='$action'");
    ero("修改成功","admin.php?action=$action");
    break;
  case"page_soft"://
    $title=Char_Cv("title");
    $db->update("article","title,content,updatetime","$title|content1|$time","ntype='$action'");
    ero("修改成功","admin.php?action=$action");
    break;
  case"editcompany"://
    $id=Char_Cv("id");
    $company=Char_Cv("company");
    $money=Char_Cv("money");
    $days=Char_Cv("days");
    $package=Char_Cv("package");
    $setting=$db->record("setting","companyid,paymoney,money,exptime,ntype,package","id=$id");
    $companyid=$setting[0]['companyid'];
    $exptime=$setting[0]['exptime'];
    if($setting[0]['package']!=$package){
      $packagename=$package==0?'普通':$db->select('package','title',"id=$package");
      WriteLog($companyid,'套餐','管理员将您设置为'.$packagename.'客户！');
    }
    if(!$money || !is_numeric($money))$money=0;
    $m=$money+$setting[0]['money'];
    if(intval($days)!=intval(($exptime-GetTime(date('Y-m-d',$time)))/86400)){
      WriteLog($companyid,'服务期限','管理员更改您的客服有效期！');
    }
    $exptime=GetTime(date('Y-m-d',$time))+$days*86400;
    $db->update("setting","company,money,exptime,package","$company|$m|$exptime|$package","id=$id");
    if($money>0){
      WriteMoneyLog($companyid,$money,'管理员为您的账户进行充值');
    }
    if($money<0){
      WriteMoneyLog($companyid,-$money,'管理员从您的账户中扣除部分余额');
    }
    
    ero("修改成功","admin.php?action=companyedit&id=$id");
    break;
  case"editcompany2"://
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
        WriteLog($companyid,'开通服务','管理员为您开通“'.$sname.'”服务');
        $db->insert("myfunction","companyid,keyname,starttime","$companyid|$k|$time");
      }elseif(in_array($k,$myfuns) && $used[$k]!='1'){
        $sname=$db->select('function','title',"keyname='$k'");
        WriteLog($companyid,'删除服务','管理员已删除您的“'.$sname.'”服务');
        $db->delete("myfunction","companyid='$companyid' and keyname='$k'");
      }
    }
    ero("修改成功");
    break;
  case"delcompany"://
    $id=Char_Cv("id","get");
    $ac=Char_Cv("ac","get");
    if(!$id)ero("您没有选择任何内容",1);
    $setting=$db->record("setting","companyid,ntype","id=$id",1);
    if(!$setting)ero("您要删除的客户不存在",1);
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
    ero("删除成功","admin.php?action=".$ac);
    break;
  case"agent_set"://
    $type=Char_Cv("type");
    $ntype=Char_Cv("ntype");
    $pword=Char_Cv("pword");
    $prov=Char_Cv("prov");
    $city=Char_Cv("city");
    $companyname=Char_Cv("companyname");
    $content=Char_Cv("content");
    if($ntype=='add'){
      $uname=Char_Cv("uname");
      if($db->rows('agent',"username='$uname'"))ero('该用户名已存在');
      $pass=md5($pword);
      $exptime=GetTime(date('Y-m-d',$time))+365*86400;
      if($type=='prov'){
        if($db->rows('agent',"prov='$prov'"))ero($prov.'已有总代理');
        $db->insert("agent","ntype,prov,city,username,password,company,content,infotime,infoip,exptime","prov|$prov||$uname|$pass|$companyname|$content|$time|$onlineip|$exptime");
        WriteLog($uname,'开通总代理',$prov.'总代理资格正式开通',1);
      }else{
        if($db->rows('agent',"prov='$prov' and city='$city'"))ero($prov.$city.'已有代理');
        $db->insert("agent","ntype,prov,city,username,password,company,content,infotime,infoip,exptime","city|$prov|$city|$uname|$pass|$companyname|$content|$time|$onlineip|$exptime");
        WriteLog($uname,'开通市代理',$prov.$city.'总代理资格正式开通',1);
      }
    }else{
      $id=Char_Cv("id");
      $money=Char_Cv("money");
      $days=Char_Cv("days");
      $thegrade=Char_Cv("thegrade");
      $agent=$db->record("agent","username,money,exptime","id=$id",1);
      if(!$agent)ero('您要编辑的代理商不存在');
      $exptime=$agent[0]['exptime'];
      if(!$money || !is_numeric($money))$money=0;
      $m=$money+$agent[0]['money'];
      if(intval($days)!=intval(($exptime-GetTime(date('Y-m-d',$time)))/86400)){
        WriteLog($agent[0]['username'],'服务期限','管理员更改您的有效期！',1);
      }
      $exptime=GetTime(date('Y-m-d',$time))+$days*86400;
      $db->update("agent","ntype,prov,city,company,content,money,exptime,grade","$type|$prov|$city|$companyname|$content|$m|$exptime|$thegrade","id=$id");
      if($money>0){
        WriteMoneyLog($agent[0]['username'],$money,'管理员为您的账户进行充值',1);
      }
      if($money<0){
        WriteMoneyLog($agent[0]['username'],-$money,'管理员从您的账户中扣除部分余额',1);
      }
      if($pword){
        $pass=md5($pword);
        $db->update("agent","password","$pass","id=$id");
        WriteLog($uname,$prov.'修改密码',"管理员重设您的密码",1);
      }
    }
    $type=='prov' ? ero('设置省代理成功',"admin.php?action=agent_set&type=$type&prov=$prov") : ero('设置市代理成功',"admin.php?action=agent_set&type=$type&prov=$prov&city=$city");
    break;
  case"agent_del"://
    $id=Char_Cv('id','get');
    $agent=$db->record("agent","username,ntype,prov,city","id=$id",1);
    $uname=$agent[0]['username'];
    $ntype=$agent[0]['ntype'];
    $prov=$agent[0]['prov'];
    $city=$agent[0]['city'];
    if(!$agent)ero("您要删除的代理不存在",1);
    $db->delete("agent","id=$id");
    $db->delete("log","agent='$uname'");
    $db->delete("money","agent='$uname'");
    if($ntype=='prov'){
      ero($prov."省总代理已被删除","admin.php?action=agent_set&type=prov&prov=$prov");
    }else{
      ero($prov."省".$city."市总代理已被删除","admin.php?action=agent_set&type=city&prov=$prov&city=$city");
    }
    break;
  case"company_add"://
    $companyid=Char_Cv("companyid");
    $pass=Char_Cv("pass");
    $prov=Char_Cv("prov");
    $city=Char_Cv("city");
    if(!$companyid || !$pass)ero("您填写的内容不全",1);
    if($db->rows('setting',"companyid='$companyid'"))ero("您要添加的客户编号已存在");
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
        $db->insert('myfunction','companyid,keyname,starttime,exptime',"$companyid|$v|$time|$exptime");
      }
    }
    $agent=$db->select("agent","username","prov='$prov' and city='$city' and ntype='city'");
    if(!$agent)$agent=$db->select("agent","username","prov='$prov' and ntype='prov'");
    $db->insert('setting','companyid,status,company,logo,infotime,exptime,grade,agent,infoprov,infocity',"$companyid|1|$companyid|$homepage|$time|$exptime|$myfun|$agent|$prov|$city");
    $db->insert('workersort','companyid,sort',"$companyid|$default_workersort");
    $sid=$db->select('workersort','id',"companyid='$companyid' order by id desc");
    $address=getaddress($onlineip,true);
    $pass=md5($pass);
    $db->insert('worker','companyid,sortid,grade,username,password,nickname',"$companyid|$sid|all|$companyid|$pass|$default_worker");
    
    $id=$db->select("worker","id","1 order by id desc");
    $mq=$MQStart+$id;
    $db->update("worker","mq",$mq,"id=$id");
    
    WriteLog($companyid,"添加账号","开通客户账号！");
    $id=$db->select("setting","id","companyid='$companyid'");
    
    ero("添加客户成功","admin.php?action=companyedit&id=".$id);
    break;
  case"ggs"://
    $ntype=Char_Cv('ntype','get');
    $ac=Char_Cv('ac','get');
    $thetext=Char_Cv('thetext');
    $theurl=Char_Cv('theurl');
    if($ntype=='gg_dialog_add'){
      $db->insert("ads","thetext,theurl,ntype,admin,addtime","$thetext|$theurl|dialog|$username|$time");
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
        $db->insert("ads","thetext,theurl,ntype,admin,addtime","$thetext|$theurl|login|$username|$time");
      }else{
        $db->update("ads","thetext,theurl","$thetext|$theurl","admin<>'' and ntype='login'");
      }
    }elseif($ntype=='del'){
      $id=Char_Cv('id');
      if(!$id || !is_array($id))ero("您没有选择任何内容",1);
      for($i=0;$i<count($id);$i++){
        $db->delete("ads","admin<>'' and id=".$id[$i]);
      }
    }
    if(!$ac)$ac='main';
    ero('操作成功','admin.php?action='.$ac);
    break;
  case"addpackage"://
    $title=Char_Cv("title");
    $dayti=Char_Cv("dayti");
    $day=Char_Cv("day");
    $price=Char_Cv("price");
    $funs=Char_Cv("funs");
    $content=Char_Cv("content");
    if(!$day)$day='1';
    if(!$funs)ero('请选择至少一个包含功能');
    if(!is_numeric($day))ero('套餐有效天数必须为数字');
    if(!is_numeric($price))ero('套餐价格必须为数字');
    $superfun=$db->record("function","keyname,title","1");
    $funcos=array();
    foreach($superfun as $rs){
      if(in_array($rs['keyname'],$funs)){
        $funcos[]=$rs['title'];
      }
    }
    $funs=implode(',',$funs);
    $funcos=implode(',',$funcos);
    $db->insert("package","title,dayti,day,price,funs,content,funcos,addtime,updatetime","$title|$dayti|$day|$price|$funs|$content|$funcos|$time|$time");
    ero("添加成功","admin.php?action=package");
    break;
  case"editpackage"://
    $id=Char_Cv("id");
    $title=Char_Cv("title");
    $dayti=Char_Cv("dayti");
    $day=Char_Cv("day");
    $price=Char_Cv("price");
    $funs=Char_Cv("funs");
    $content=Char_Cv("content");
    if(!$day)$day='1';
    if(!is_numeric($day))ero('套餐有效天数必须为数字');
    if(!is_numeric($price))ero('套餐价格必须为数字');
    $superfun=$db->record("function","keyname,title","1");
    $funcos=array();
    foreach($superfun as $rs){
      if(in_array($rs['keyname'],$funs)){
        $funcos[]=$rs['title'];
      }
    }
    $funs=implode(',',$funs);
    $funcos=implode(',',$funcos);
    $db->update("package","title,dayti,day,price,funs,content,funcos,updatetime","$title|$dayti|$day|$price|$funs|$content|$funcos|$time","id=$id");
    ero("修改成功","admin.php?action=package");
    break;
  case"delpackage"://
    $id=Char_Cv("id");
    $db->delete("package","id=$id");
    ero("删除成功","admin.php?action=package");
    break;
  case"editfile":
    $file=Char_Cv('file');
    $path=Char_Cv('path');
    if(!file_exists('../eqmkdata/filebaks/'.urlencode($file).'.php')){
      if(!is_dir('../eqmkdata/filebaks')){
        mkdir('../eqmkdata/filebaks',0777);
      }
      @copy($file,'../eqmkdata/filebaks/'.urlencode($file).'.php');
    }
    $co=str_replace('&lt;/textarea&gt;','</textarea>',$_POST['content1']);
    $co=str_replace('$co=str_replace(\'</textarea>\',\'</textarea>\',$co);','$co=str_replace(\'</textarea>\',\'&lt;/textarea&gt;\',$co);',$_POST['content1']);
    $co=preg_replace("/^([\s0-9]+)│/m","",$co);
    writeover($file,$co);
    ero('操作成功','admin.php?action=explorer&path='.urlencode($path));
    break;
  case"sqlbak":
    if(!is_dir('../eqmkdata/sqlbaks')){
      mkdir('../eqmkdata/sqlbaks',0777);
    }
    $rndstring = "";
    for($i=0;$i<6;$i++){
      $rndstring .= chr(mt_rand(65,90));
    }
    $sqlpath='../eqmkdata/sqlbaks/'.date('Y_m_d_H_i_s_',$time).$rndstring;
    if(!is_dir($sqlpath)){
      mkdir($sqlpath,0777);
    }
    $tables_query = $db->query('show tables');
    while ($tables = $db->fetch_array($tables_query)) {
      if(substr($tables[0],0,strlen($tbl))!=$tbl)continue;
      $table=substr($tables[0],strlen($tbl)-strlen($tables[0]));
      if(!is_dir($sqlpath.'/'.$table)){
        mkdir($sqlpath.'/'.$table,0777);
      }
      $result=$db->query("SHOW FIELDS FROM ".$tables[0]);
      $fieldlist=array();
      while($data=mysql_fetch_array($result)) {
        $fieldlist[]=$data['Field'];
      }
      writeover($sqlpath.'/'.$table.'/config.php',"<?php\nif(!defined('IN_EQMK'))exit('Access Denied');\n\$fields='".implode(',',$fieldlist)."';\n?>");
      $eqmk=$db->record($table,implode(',',$fieldlist),"1 order by id asc");
      $i=0;$page=1;$A=array();
      foreach($eqmk as $rs){
        $i++;
        $B=array();
        foreach($fieldlist as $v){
          $B[]=str_replace('"','\"',$rs[$v]);
        }
        $A[]=implode('|',$B);
        if($i % 1000==0){
          ob_flush();
          flush();
          writeover($sqlpath.'/'.$table.'/'.$page.'.php',"<?php\nif(!defined('IN_EQMK'))exit('Access Denied');\n\$DATAS=".var_export($A,true)."\n?>");
          $page++;
          $A=array();
        }
      }
      writeover($sqlpath.'/'.$table.'/'.$page.'.php',"<?php\nif(!defined('IN_EQMK'))exit('Access Denied');\n\$DATAS=".var_export($A,true)."\n?>");
      print('<font size=2>备份数据表'.$table.',分卷'.$page.'成功</font><br />');
    }
    ero('备份数据库成功','admin.php?action=sqlbak');
    break;
  case"delsqlbak":
    function DelSqlFiles($tplpath){
      if(substr($tplpath,0,20)!='../eqmkdata/sqlbaks/')die('Error');
      if(!is_dir($tplpath))return $A;
      $dh=opendir($tplpath);
      while ($file=readdir($dh)) {
        if($file!="." && $file!="..") {
          if(is_dir($tplpath.'/'.$file)) {
            DelSqlFiles($tplpath.'/'.$file);
          }else{
            @unlink($tplpath.'/'.$file);
          }
        }
      }
      closedir($dh);
      @rmdir($tplpath);
    }
    $file=Char_Cv('file','get');
    DelSqlFiles('../eqmkdata/sqlbaks/'.$file);
    if(is_dir($tplpath)){
      ero('删除备份文件失败，请用FTP在空间上手动删除','admin.php?action=sqlre');
    }else{
      ero('删除备份文件成功','admin.php?action=sqlbak');
    }
    break;
  case"sqlbakre":
    $thefile=Char_Cv('file','get');
    $tplpath='../eqmkdata/sqlbaks/'.$thefile;
    if(substr($tplpath,0,20)!='../eqmkdata/sqlbaks/')die('Error');
    if(!is_dir($tplpath))ero('备份文件不存在');
    $dh=opendir($tplpath);
    while ($file=readdir($dh)) {
      if($file!="." && $file!="..") {
        if(is_dir($tplpath.'/'.$file)) {
          include($tplpath.'/'.$file.'/config.php');
          if($fields){
            $db->query('TRUNCATE TABLE '.$tbl.$file.';');
            $dh2=opendir($tplpath.'/'.$file);
            while ($file2=readdir($dh2)) {
              if($file2!="." && $file2!="..") {
                if(!is_dir($tplpath.'/'.$file.'/'.$file2) && $file2!='config.php') {
                  @include($tplpath.'/'.$file.'/'.$file2);
                  if($DATAS){
                    foreach($DATAS as $v){
                      $db->insert("$file","$fields","$v");
                    }
                    unset($DATAS);
                  }
                }
              }
            }
            closedir($dh2);
          }
        }
      }
    }
    closedir($dh);
    ero('还原数据库成功','admin.php?action=sqlbak');
    break;
  case"optimize":
    $table=Char_Cv('table');
    print($db->query('OPTIMIZE TABLE '.$table)?'Y':'N');
    break;
  case"repair":
    $table=Char_Cv('table');
    print($db->query('REPAIR TABLE '.$table)?'Y':'N');
    break;
  case"truncate":
    $table=Char_Cv('table');
    print($db->query('TRUNCATE TABLE '.$table)?'Y':'N');
    break;
}
?>