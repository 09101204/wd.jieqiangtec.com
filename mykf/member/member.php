<?
define('IN_MEMBER', TRUE);
include("check.php");
$action=Char_Cv('action','get');
function ToHelp($ac){
  return '[<a href="member.php?action=help#'.$ac.'"><font color="#0000ff">?</font></a>]';
}
switch($action){
  case'menu':
    $title='����˵�';
    $ChildMenu['main']='������ҳ';
    if(MyGrade('modify'))$ChildMenu['modify']='�޸�����';
    $ChildMenu['logout']='ע���˳�';
    $Menu[]=array('��������',$ChildMenu);unset($ChildMenu);
    
    if(MyGrade('config'))$ChildMenu['config']='��������';
    if(MyGrade('style'))$ChildMenu['style']='�������';
    if(MyGrade('zdyurl'))$ChildMenu['zdyurl']='�Զ���URL';
    if(MyGrade('function'))$ChildMenu['function']='���ܹ���';
    if(MyGrade('log'))$ChildMenu['log']='������־';
    if(MyGrade('money'))$ChildMenu['money']='������ϸ';
    if($ChildMenu)$Menu[]=array('�߼�ѡ��',$ChildMenu);unset($ChildMenu);
    
    if(MyGrade('history'))$ChildMenu['history']='ǡ̸��¼';
    if(MyGrade('worker'))$ChildMenu['worker']='�ͷ�����';
    if(MyGrade('workersort'))$ChildMenu['workersort']='ϯλ����';
    if(MyGrade('getcode'))$ChildMenu['getcode']='��ȡ����';
    if($ChildMenu)$Menu[]=array('���߿ͷ�',$ChildMenu);unset($ChildMenu);
    
    if(MyGrade('faq'))$Menu[]=array('�Զ�Ӧ��',
               array(
                'faqadd'=>'���Ӧ���¼',
                'faq'=>'�Զ�Ӧ���б�'
               )
           );
    if(MyGrade('word'))$Menu[]=array('�ͷ�������',
               array(
                'wordsadd'=>'��ӳ�����',
                'words'=>'�������б�'
               )
           );
    if(MyGrade('count'))$Menu[]=array('����ͳ��',
               array(
                'count_main'=>'�ۺ�ͳ��',
                'count_list'=>'��ϸ�б�',
                'count_hour'=>'ʱ��ͳ��',
                'count_day'=>'��ͳ�Ʊ���',
                'count_week'=>'����ͳ�Ʊ���',
                'count_month'=>'��ͳ�Ʊ���',
                'count_year'=>'��ͳ�Ʊ���',
                'count_come'=>'��·ͳ��',
                'count_location'=>'�ܷ�ҳ��ͳ��',
                'count_search'=>'��������ͳ��',
                'count_keyword'=>'�ؼ���ͳ��',
                'count_address'=>'����λ�÷���',
                'count_screen'=>'��Ļ�ֱ��ʷ���',
                'count_browser'=>'���������',
                'count_os'=>'����ϵͳ����'
               )
            );
    include("../template/admin/$adminstyle/config.php");
    include("menu.php");
    break;
  case'main':
    $title='����˵������������';
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
    
    $count1=$db->rows("workersort","companyid='$cid'");
    $count2=$db->rows("worker","companyid='$cid'");
    $count3=$db->rows('worker',"companyid='$cid' and online>0");
    $count4=$db->rows('client',"companyid='$cid' and lasttime>".($time-90));
    $usercount1=$db->rows('setting',"upuser='$cid'");
    $usercount2=$db->rows('setting',"upuser='$cid' and ntype>0");
    $usermoney=$ListUserPrice[0]*$usercount2;
    $setting=$db->record('setting','agent,infotime,exptime,ntype,money,paymoney',"companyid='$cid'",1);
    $infotime=date('Y-m-d',$setting[0]['infotime']);
    $exptime=date('Y-m-d',$setting[0]['exptime']);
    $Agent=$setting[0]['agent'];
    if($Agent){
      if($agent=$db->record("agent","prov,city,ntype,company,content","username='".$Agent."'",1)){
        $ag=$agent[0]['company'].'</font> <font color="gray">('.($agent[0]['ntype']=='prov' ? $agent[0]['prov'].'�ܴ���' : $agent[0]['prov'].$agent[0]['city'].'�ܴ���').($agent[0]['content']?'����ϵ��ʽ:'.$agent[0]['content']:'').')';
      }else{
        $ag=$Agent;
      }
    }else{
      $ag='��';
    }
    $ntype=$setting[0]['ntype'];
    $money=$setting[0]['money'];
    $paymoney=$setting[0]['paymoney'];
    $days=intval(($setting[0]['exptime']-GetTime(date('Y-m-d',$time)))/86400);
    if($days<=7)$tips='<br /><font color="#ff6600">����ϵͳ����<font color="#ff0000"><b> '.$days.' </b></font>������,�뼰ʱ����!</font> '.(MyGrade('exptimes') ? '<a href="?action=pay&type=exptimes" style="color:#0000ff">չ��</a>':'');
    include("main.php");
    break;
  case'config':
    if(!MyGrade($action))ero('û��Ȩ��','?action=main');
    $title='������Ϣ����';
    $rs=$db->record("setting","company,dialogad,dialoglogo,dialoglogourl,keywords,description,autoinvite,effect,opennew,delay,invitetitle,invitecontent,dialogtitle,dialoginfotitle,prov,city,logo,trade,autofaq,allowpingfen,language,dialogsort,companyinfo","companyid='$cid'",1);
    $company=$rs[0]['company'];
    $keywords=$rs[0]['keywords'];
    $description=$rs[0]['description'];
    $dialoglogo=$rs[0]['dialoglogo'];
    $dialoglogourl=$rs[0]['dialoglogourl'];
    $autoinvite=$rs[0]['autoinvite'];
    $effect=$rs[0]['effect'];
    $opennew=$rs[0]['opennew'];
    $delay=$rs[0]['delay'];
    $invitetitle=$rs[0]['invitetitle'];
    $invitecontent=$rs[0]['invitecontent'];
    $dialogad=$rs[0]['dialogad'];
    $dialogtitle=$rs[0]['dialogtitle'];
    $dialoginfotitle=$rs[0]['dialoginfotitle'];
    $prov_=$rs[0]['prov'];
    $city_=$rs[0]['city'];
    $logo_=$rs[0]['logo'];
    $trade=$rs[0]['trade'];
    $autofaq=$rs[0]['autofaq'];
    $allowpingfen=$rs[0]['allowpingfen'];
    $language_dialog=$rs[0]['language'];
    $dialogsort=str_replace('��','|',$rs[0]['dialogsort']);
    $companyinfo=$rs[0]['companyinfo'];
    if(!$language_dialog)$language_dialog=$lang_dialog;
    include("../eqmkdata/citylist.inc.php");
    include("../eqmkdata/sort.inc.php");
    include("config.php");
    break;
  case'zdyurl':
    if(!MyGrade($action))ero('û��Ȩ��','?action=main');
    $title='�Զ���URL';
    $rs=$db->record("setting","urlkg,url","companyid='$cid'",1);
    $urlkg=$rs[0]['urlkg'];
    $url=$rs[0]['url'];
    include("zdyurl.php");
    break;
  case'count_address':
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $title='����λ�÷���';
    include("../eqmkdata/sort.inc.php");
    $dayscount=$db->rows("client","companyid='$cid'");
    if($dayscount<1)$dayscount=1;
    $count=$db->record("client as c1,{$tbl}client as c2","c1.prov,(select count(id) from {$tbl}client where companyid='$cid' and prov=c1.prov)","c1.companyid='$cid' and c2.companyid='$cid' and c2.prov=c1.prov group by c1.prov order by count(c2.id) desc");
    $length=300;
    $Color=array('7AC5CD','EEC591','36648B','FF8C69','8DB6CD','FFFACD','104E8B','458B00','DAA520','EEC591','FF8C69','8DB6CD','A8DE98');
    //��ͼ����
    if(is_array($count)){
      $tmp='';$k=0;
      foreach($count as $rs){
        $count2=$rs[1];
        $prov=$rs[0] ? $Province[$rs[0]][1] : "δ֪����";
        $tmp.="<set name='$prov' value='$count2' color='".$Color[$k]."'/>";
        $k++;
        if($k>=13){
          break;
        }
      }
    }
    include("count_address.php");
    break;
  case'count_browser':
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $title='���������';
    $dayscount=$db->rows("client","companyid='$cid'");
    if($dayscount<1)$dayscount=1;
    $count=$db->record("client as c1,{$tbl}client as c2","c1.browser,(select count(id) from {$tbl}client where companyid='$cid' and browser=c1.browser)","c1.companyid='$cid' and c2.companyid='$cid' and c2.browser=c1.browser group by c1.browser order by count(c2.id) desc");
    $length=300;
    include("count_browser.php");
    break;
  case'count_come':
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $title='��·ͳ��';
    $dayscount=$db->rows("client","companyid='$cid'");
    if($dayscount<1)$dayscount=1;
    $count=$db->record("client as c1,{$tbl}client as c2","c1.comeurl,(select count(id) from {$tbl}client where companyid='$cid' and comeurl=c1.comeurl)","c1.companyid='$cid' and c2.companyid='$cid' and c2.comeurl=c1.comeurl group by c1.comeurl order by count(c2.id) desc");
    $length=300;
    include("count_come.php");
    break;
  case'count_day':
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $title='��ͳ�Ʊ���';
    $M=Char_Cv("m","get");
    if(!$M)$M=date('Y-m',$time);
    $dayscount=$db->rows("client","companyid='$cid' and addtime>=".(GetTime("$M-01")));
    if($dayscount<1)$dayscount=1;
    $length=300;
    $sec=date('Y',GetTime("$M-01")) % 4==0 ?29:28;
    $Days=array(31,$sec,31,30,31,30,31,31,30,31,30,31);
    include("count_day.php");
    break;
  case'count_hour':
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $title='ʱ��ͳ��';
    $D=Char_Cv("d","get");
    if(!$D)$D=date('Y-m-d',$time);
    $dayscount=$db->rows("client","companyid='$cid' and addtime>=".(GetTime($D)));
    if($dayscount<1)$dayscount=1;
    $length=300;
    //�������
    $tmp='';
    $nums=array();
    for($i=0;$i<24;$i++){
    $T1=GetTime($D)+$i*3600;
    $T2=$T1+3600;
    $ti=$i.':00-'.($i+1).':00';
    $count2=$db->rows("client","companyid='$cid' and addtime>=$T1 and addtime<$T2");
    $bl2=number_format($count2/$dayscount*100,2, '.', '');
    $pic=$bl2>0 ? '<img src="../images/membercp/sum_on.gif" width="'.($length*$bl2/100).'" height="8">' : '';
    $tmp.='
    <tr align="center">
    <td align="left" height="20">'.$ti.'</td>
    <td><font color="#0163d1"><font color="#ad1963">'.$count2.'</font></td>
    <td><font color="#ad1963">'.$bl2.'%</font></td>
    <td align="left">'.$pic.'</td>
    </tr>';
    $nums[]=$count2;
    }
    $nums=implode(',',$nums);
    //
    include("count_hour.php");
    break;
  case'count_keyword':
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $title='�ؼ���ͳ��';
    include("../eqmkdata/sort.inc.php");
    include("header.php");
    $length=300;
    if(is_array($Search)){
    foreach($Search as $k=>$v){
    $dayscount=$db->rows("client","companyid='$cid' and search='$k'");
    $count=$db->record("client as c1,{$tbl}client as c2","c1.keyword,(select count(id) from {$tbl}client where companyid='$cid' and keyword=c1.keyword)","c1.companyid='$cid' and c2.companyid='$cid' and c1.search='$k' and c2.keyword=c1.keyword group by c1.keyword order by count(c2.id) desc");
    include("count_keyword.php");
    }}
    include("footer.php");
    break;
  case'count_list':
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $title='��ϸ�б�';
    $count=$db->page("client","id,addtime,ip,address,comeurl,thispage","companyid='$cid' order by lasttime desc",20,"action=$action");
    include("count_list.php");
    break;
  case'count_location':
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $title='�ܷ�ҳ��ͳ��';
    $dayscount=$db->rows("client","companyid='$cid'");
    if($dayscount<1)$dayscount=1;
    $count=$db->record("client as c1,{$tbl}client as c2","c1.thispage,(select count(id) from {$tbl}client where companyid='$cid' and thispage=c1.thispage)","c1.companyid='$cid' and c2.companyid='$cid' and c2.thispage=c1.thispage group by c1.thispage order by count(c2.id) desc");
    $length=300;
    include("count_location.php");
    break;
  case'count_main':
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $title='�ۺ�ͳ��';
    include("header.php");
    $firsttime=$db->select("client","addtime","companyid='$cid' order by addtime asc");
    if(!$firsttime){
      echo"����δ�зÿ�����,ͳ�Ʒ���δ������";
    }else{
      $zerotime=GetTime(date('Y-m-d',$time));
      $days=intval(($time-$firsttime)/86400);
      if($days<1)$days=1;
      $online=$db->rows("client","companyid='$cid' and lasttime>".($time-90));
      $totalcount=$db->rows("client","companyid='$cid'");
      $newuser=$db->rows("client","companyid='$cid' and addtime>=$zerotime and clientid not in(select clientid from {$tbl}client where addtime<$zerotime)");
      $olduser=$db->rows("client","companyid='$cid' and addtime>=$zerotime and clientid in(select clientid from {$tbl}client where addtime<$zerotime)");
      $thisday=$newuser+$olduser;
      $lastday=$db->rows("client","companyid='$cid' and addtime>=($zerotime-86400) and addtime<$zerotime");
      $thisweek=$db->rows("client","companyid='$cid' and addtime>=".intval($zerotime-86400*(date('w',$time)-1)));
      $lastweek=$db->rows("client","companyid='$cid' and addtime>=".intval($zerotime-86400*(date('w',$time)+7))." and addtime<".intval($zerotime-86400*(date('w',$time)-1))."");
      $thismonth=$db->rows("client","companyid='$cid' and addtime>=".intval($zerotime-86400*(date('d',$time)-1)));
      $lastmonth=$db->rows("client","companyid='$cid' and addtime>=".intval($zerotime-86400*(date('d',$time)+30))." and addtime<".intval($zerotime-86400*(date('d',$time)-1))."");
      
      $avgday=intval($rs["counts"]/$days);
      $num=intval($days/7);
      if($num<1)$num=1;
      $avgweek=intval($rs["counts"]/$num);
      $num=intval($days/30);
      if($num<1)$num=1;
      $avgmonth=intval($rs["counts"]/$num);
      include("count_main.php");
    }
    include("footer.php");
    break;
  case'count_month':
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $title='��ͳ�Ʊ���';
    $Y=Char_Cv("y","get");
    if(!$Y)$Y=date('Y',$time);
    $dayscount=$db->rows("client","companyid='$cid' and addtime>=".(GetTime("$Y-01-01")));
    if($dayscount<1)$dayscount=1;
    $length=300;
    include("count_month.php");
    break;
  case'count_os':
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $title='����ϵͳ����';
    $dayscount=$db->rows("client","companyid='$cid'");
    if($dayscount<1)$dayscount=1;
    $count=$db->record("client as c1,{$tbl}client as c2","c1.os,(select count(id) from {$tbl}client where companyid='$cid' and os=c1.os)","c1.companyid='$cid' and c2.companyid='$cid' and c2.os=c1.os group by c1.os order by count(c2.id) desc");
    $length=300;
    include("count_os.php");
    break;
  case'count_screen':
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $title='��Ļ�ֱ��ʷ���';
    $dayscount=$db->rows("client","companyid='$cid'");
    if($dayscount<1)$dayscount=1;
    $count=$db->record("client as c1,{$tbl}client as c2","c1.screen,(select count(id) from {$tbl}client where companyid='$cid' and screen=c1.screen)","c1.companyid='$cid' and c2.companyid='$cid' and c2.screen=c1.screen group by c1.screen order by count(c2.id) desc");
    $length=300;
    include("count_screen.php");
    break;
  case'count_search':
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $title='��������ͳ��';
    include("../eqmkdata/sort.inc.php");
    $dayscount=$db->rows("client","companyid='$cid' and search<>''");
    if($dayscount<1)$dayscount=1;
    $count=$db->record("client as c1,{$tbl}client as c2","c1.search,(select count(id) from {$tbl}client where companyid='$cid' and search=c1.search)","c1.companyid='$cid' and c2.companyid='$cid' and c1.search<>'' and c2.search=c1.search group by c1.search order by count(c2.id) desc");
    $length=300;
    $Color=array('7AC5CD','EEC591','36648B','FF8C69','8DB6CD','FFFACD','104E8B','458B00','DAA520','EEC591','FF8C69','8DB6CD','A8DE98');
    //��ͼ����
    if(is_array($count)){
    $tmp='';$k=0;
    foreach($count as $rs){
      $count2=$rs[1];
      $prov=$Search[$rs[0]][0];
      $tmp.="<set name='$prov ' value='$count2' color='".$Color[$k]."'/>";
      $k++;
      if($k>=13){
        break;
      }
      }
    }
    include("count_search.php");
    break;
  case'count_week':
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $title='����ͳ�Ʊ���';
    $Y=Char_Cv("y","get");
    if(!$Y)$Y=date('Y',$time);
    $length=300;
    $zerotime=$time-date('H',$time)*3600-date('i',$time)*60-date('s',$time)-86400*(date('w',$time)-1);
    $Name=array('һ','��','��','��','��','��','��');
    $dayscount=$db->rows("client","companyid='$cid' and addtime>=$zerotime");
    if($dayscount<1)$dayscount=1;
    include("count_week.php");
    break;
  case'count_year':
    if(!MyGrade('count'))ero('û��Ȩ��','?action=main');
    $title='��ͳ�Ʊ���';
    $dayscount=$db->rows("client","companyid='$cid'");
    if($dayscount<1)$dayscount=1;
    $length=300;
    include("count_year.php");
    break;
  case'faq':
    if(!MyGrade('faq'))ero('û��Ȩ��','?action=main');
    $title='�Զ�Ӧ���б�';
    $faq=$db->page("faq","id,title,hits,content","companyid='$cid'",20,"action=$action");
    include("faq.php");
    break;
  case'faqadd':
    if(!MyGrade('faq'))ero('û��Ȩ��','?action=main');
    $title='����Զ�Ӧ��';
    include("faqadd.php");
    break;
  case'faqedit':
    if(!MyGrade('faq'))ero('û��Ȩ��','?action=main');
    $title='�༭�Զ�Ӧ��';
    $id = Char_Cv("id","get","num");
    $faq=$db->record("faq","title,content","companyid='$cid' and ID=$id");
    $title=$faq[0]["title"];
    $content=$faq[0]["content"];
    include("faqedit.php");
    break;
  case'words':
    if(!MyGrade('word'))ero('û��Ȩ��','?action=main');
    $title='�������б�';
    $Onez=$db->record("words","id,sort,words","companyid='$cid' and workerid='$wid' order by sort asc,words asc");
    $Words=array();
    foreach($Onez as $rs){
      if(!is_array($Words[$rs['sort']]))$Words[$rs['sort']]=array();
      array_push($Words[$rs['sort']],array($rs['id'],$rs['words']));
    }
    include("words.php");
    break;
  case'wordsadd':
    if(!MyGrade('word'))ero('û��Ȩ��','?action=main');
    $title='��ӳ�����';
    $Sort=$db->record("words","sort","companyid='$cid' and workerid='$wid' group by sort order by sort asc");
    $btnname='���';
    include("wordsEdit.php");
    break;
  case'wordsedit':
    if(!MyGrade('word'))ero('û��Ȩ��','?action=main');
    $Ti=$title='�༭������';
    $id = Char_Cv("id","get","num");
    $words=$db->record("words","ntype,sort,words","companyid='$cid' and workerid='$wid' and ID=$id");
    $ntype=$words[0]["ntype"];
    $sort=$words[0]["sort"];
    $words=$words[0]["words"];
    $Sort=$db->record("words","sort","companyid='$cid' and workerid='$wid' group by sort order by sort asc");
    $btnname='����';
    include("wordsEdit.php");
    break;
  case'function':
    if(!MyGrade($action))ero('û��Ȩ��','?action=main');
    $title='���ܹ���';
    $setting=$db->record("setting","ntype,infotime,exptime,packtime,package","companyid='$cid'",1);
    $ntype=$setting[0]['ntype'];
    $infotime=$setting[0]['infotime'];
    $exptime=$setting[0]['exptime'];
    $packtime=$setting[0]['packtime'];
    $package=$setting[0]['package'];
    $PA=$F=array();
    $allfun=$db->record("function","keyname,title,content,price,days","isused=1");
    foreach($allfun as $rs){
      $F[$rs['keyname']]=array($rs['keyname'],$rs['title'],$rs['content'],$rs['price']>0?'<font color="red">'.$rs['price'].'</font>Ԫ/<font color="red">'.$rs['days'].'</font>��':'���',$rs['price']>0?'�շѹ���':'��ͨ����','---','---',0);
    }
    $myfun=$db->record("myfunction","keyname,starttime,exptime","companyid='$cid'",1);
    foreach($myfun as $rs){
      $F[$rs['keyname']][5]=date('Y-m-d H:i:s',$rs['starttime']);
      $F[$rs['keyname']][6]=date('Y-m-d H:i:s',$rs['exptime']);
      if($rs['exptime']<$time)$F[$rs['keyname']][6]='<font color="red">'.$F[$rs['keyname']][6].'</font>';
    }
    if($package!=0){
      $PA=$db->record("package","funs,funcos,title","id=$package");
      $PA=$PA[0];
      foreach(explode(',',$PA['funs']) as $v){
        $F[$v][4]=$PA['title'].'�ײ�';
        $F[$v][5]=date('Y-m-d H:i:s',$packtime);
        $F[$v][6]=date('Y-m-d H:i:s',$exptime);
        if($exptime<$time)$F[$v][6]='<font color="red">'.$F[$v][6].'</font>';
        $F[$v][7]=$package;
      }
    }
    $PackAge=$db->record("package","id,funs,funcos,title,price,dayti","1 order by title asc");
    include("function.php");
    break;
  case'getcode':
    if(!MyGrade($action))ero('û��Ȩ��','?action=main');
    $title='��ȡ����';
    include("getcode.php");
    break;
  case'history':
    if(!MyGrade($action))ero('û��Ȩ��','?action=main');
    $title='ǡ̸��¼';
    $keyword=Char_Cv('keyword','get');
    $workerid=Char_Cv('workerid','get');
    $thedate=Char_Cv('thedate','get');
    $t=Char_Cv('t','get');
    $dt1=Char_Cv('dt1','get');
    $dt2=Char_Cv('dt2','get');
    //д���ѯ���
    $xxx="companyid='$cid'";
    if($keyword){
      $xxx.=" and content like '%$keyword%'";
    }
    if($cid==$username){
      if(is_numeric($workerid) && $workerid!=='0'){
        $xxx.=" and workerid='$workerid'";
      }
    }else{
      $xxx.=" and workerid='$wid'";
    }
    if($t=='1'){
      if($thedate=='-2'){
        $time1=mktime(0,0,0,date('m',$time-86400*2),date('d',$time-86400*2),date('Y',$time-86400*2));
        $time2=mktime(23,59,59,date('m',$time-86400*2),date('d',$time-86400*2),date('Y',$time-86400*2));
      }elseif($thedate=='-1'){
        $time1=mktime(0,0,0,date('m',$time-86400),date('d',$time-86400),date('Y',$time-86400));
        $time2=mktime(23,59,59,date('m',$time-86400),date('d',$time-86400),date('Y',$time-86400));
      }else{
        $time1=mktime(0,0,0,date('m',$time),date('d',$time),date('Y',$time));
        $time2=$time;
      }
    }elseif($t=='2'){
      $time1=mktime($dt1['h'],$dt1['i'],0,$dt1['m'],$dt1['d'],$dt1['y']);
      $time2=mktime($dt2['h'],$dt2['i'],0,$dt2['m'],$dt2['d'],$dt2['y']);
    }else{
      $time1=mktime(0,0,0,date('m',$time),date('d',$time),date('Y',$time));
      $time2=$time;
    }
    $xxx.=" and addtime between '".date('Y-m-d H:i:s',$time1)."' and '".date('Y-m-d H:i:s',$time2)."'";
    $dialog=$db->page("history","id,workerid,clientid,workername,addtime,action,content",$xxx,50,$_SERVER['QUERY_STRING']);
    
    $xxx=$cid==$username ? "companyid='$cid'" : "companyid='$cid' and id='$wid'";
    $worker=$db->record("worker","id,nickname","$xxx");
    //��ʼ����ѯ����
    if($t=='1'){
      $check1='checked';
      $check2='';
      $display1='';
      $display2='none';
      $display3='none';
    }elseif($t=='2'){
      $check1='';
      $check2='checked';
      $display1='none';
      $display2='';
      $display3='';
    }else{
      $check1='checked';
      $check2='';
      $display1='';
      $display2='none';
      $display3='none';
      
      $dt1['y']=date('Y',$time);
      $dt1['m']=date('m',$time);
      $dt1['d']=date('d',$time);
      $dt1['h']=0;
      $dt1['i']=0;
      
      $dt2['y']=date('Y',$time);
      $dt2['m']=date('m',$time);
      $dt2['d']=date('d',$time);
      $dt2['h']=date('H',$time);
      $dt2['i']=date('i',$time);
    }
    if($thedate=='-2'){
      $radio1='checked';
    }elseif($thedate=='-1'){
      $radio2='checked';
    }else{
      $radio3='checked';
    }
    $a=$dt1['y'].'-'.$dt1['m'].'-'.$dt1['d'];
    $b=$dt2['y'].'-'.$dt2['m'].'-'.$dt2['d'];
    $c=$a==$b ? $a : $a.'��'.$b;
    include("history.php");
    break;
  case'historyby':
    if(!MyGrade('history'))ero('û��Ȩ��','?action=main');
    $title='';
    $xxx=$cid==$username ? "companyid='$cid'" : "companyid='$cid' and workerid='$wid'";
    $dialog=$db->page("history","clientid","$xxx group by clientid",20,"action=$action");
    include("historyby.php");
    break;
  case'log':
    if(!MyGrade($action))ero('û��Ȩ��','?action=main');
    $title='������־';
    $log=$db->page("log","content,addtime","companyid='$cid' order by id desc",20,"action=$action");
    include("log.php");
    break;
  case'modify':
    if(!MyGrade($action))ero('û��Ȩ��','?action=main');
    $title='�޸�����';
    $rs=$db->record("worker","nickname,realname,sex,city,phone,email,qq,content,onlinetitle,onlinetip,offlinetitle,offlinetip,closetip,Favorite,FavoriteUrl,FavoriteName","companyid='$cid' and username='$username'");
    $nickname = $rs[0]["nickname"];
    $realname = $rs[0]["realname"];
    $sex = $rs[0]["sex"];
    $city = $rs[0]["city"];
    $phone = $rs[0]["phone"];
    $email = $rs[0]["email"];
    $qq = $rs[0]["qq"];
    $content = str_replace('%D%A',"\n",$rs[0]["content"]);
    $onlinetitle = $rs[0]["onlinetitle"];
    $onlinetip = $rs[0]["onlinetip"];
    $offlinetitle = $rs[0]["offlinetitle"];
    $offlinetip = $rs[0]["offlinetip"];
    $closetip = $rs[0]["closetip"];
    $Favorite = $rs[0]["Favorite"];
    $FavoriteUrl = $rs[0]["FavoriteUrl"];
    $FavoriteName = $rs[0]["FavoriteName"];
    include("modify.php");
    break;
  case'money':
    if(!MyGrade($action))ero('û��Ȩ��','?action=main');
    $title='������ϸ';
    $money=$db->page("money","content,money,addtime","companyid='$cid' order by id desc",20,"action=$action");
    include("money.php");
    break;
  case'pay':
    $type = Char_Cv("type","get");
    if(!MyGrade(strpos($type,'package')?substr($type,0,3):$type))ero('û��Ȩ��','?action=main');
    $IsPay=$partner && $alipaykey && $alipayid ? true : false;
    $setting=$db->record("setting","ntype,money,exptime,packtime,package","companyid='$cid'",1);
    $money=$setting[0]['money'];
    $exptime=$setting[0]['exptime'];
    $packtime=$setting[0]['packtime'];
    $package=$setting[0]['package'];
    if($type=='buypackage'){
      $id = Char_Cv("id","get");
      if($id==$package){
        header("location:?action=pay&type=paypackage&id=$id");
        exit();
      }
      $MyPackage=$db->select("package","title","id=$package");
      if(!$MyPackage)$MyPackage='��';
      $P=$db->record("package","title,funcos,price,dayti","id=$id");
      if(!$P)ero('���ײͲ�����',1);
      $P=$P[0];
      $price=$P['price'];
      $title='�����ײ�';
      $num=1;
      $totalprice=$price*$num;
    }elseif($type=='paypackage'){
      $id = Char_Cv("id","get");
      if($id!=$package){
        header("location:?action=pay&type=buypackage&id=$id");
        exit();
      }
      $P=$db->record("package","title,funcos,price,dayti","id=$id");
      if(!$P)ero('���ײͲ�����',1);
      $P=$P[0];
      $price=$P['price'];
      $MyPackage=$P['title'];
      $title='�ײ�����';
      $num=1;
      $totalprice=$price*$num;
    }elseif($type=='pay'){
      $title='�˻���ֵ';
      $pmoney=0.01;
    }elseif($type=='reg' || $type=='add'){
      $keyname = Char_Cv("keyname","get");
      if($type=='add'){
        $exptime=$db->select("myfunction","exptime","companyid='$cid' and keyname='$keyname'");
        if(!$exptime)ero('��û�й�����˹���');
      }
      $title=$type=='reg' ? '��ͨ����' : '��������';
      if($setting[0]['ntype']==2)ero('����ȫ���ܿͻ������蹺��˹���');
      $function=$db->record("function","price,days,title,content","keyname='$keyname' and isused=1");
      if(!$function)ero('��Ҫ����Ĺ��ܲ�����');
      $ti=$function[0]['title'];
      $content=$function[0]['content'];
      $days=$function[0]['days'];
      $price=$function[0]['price'];
    }elseif($type=='buysort'){
      $title='����ϯλ����';
      $ti='ϯλ';
      $buynum=1;
      $usecount=$db->rows("workersort","companyid='$cid'");
      $curcount=$sortcount;
      $price=$price_sort;
      $totalprice=$price;
    }elseif($type=='buyworker'){
      $title='���ӿͷ�����';
      $ti='�ͷ�';
      $buynum=1;
      $usecount=$db->rows("worker","companyid='$cid'");
      $curcount=$workercount;
      $price=$price_worker;
      $totalprice=$price;
    }
    include("pay.php");
    break;
  case'style':
    if(!MyGrade($action))ero('û��Ȩ��','?action=main');
    $title='�������';
    if($db->rows("style","companyid='$cid'")==0)$db->insert("style","companyid,posx,x,posy,y,iconstyle,liststyle,tipstyle,dialogstyle","$cid|right|0|top|0|001|QQ2006|001|blue");
    $style=$db->record("style","caption,posx,x,posy,y,iconstyle,liststyle,tipstyle,dialogstyle","companyid='$cid'",1);
    $posx=$style[0]['posx'];
    $x=$style[0]['x'];
    $posy=$style[0]['posy'];
    $y=$style[0]['y'];
    $iconstyle=$style[0]['iconstyle'];
    $liststyle=$style[0]['liststyle'];
    $tipstyle=$style[0]['tipstyle'];
    $dialogstyle=$style[0]['dialogstyle'];
    $caption=$style[0]['caption'];
    include("style.php");
    break;
  case'viewhistory':
    if(!MyGrade('history'))ero('û��Ȩ��','?action=main');
    $title='';
    $clientid=Char_Cv("clientid","get");
    $xxx=$cid==$username ? "companyid='$cid' and " : "companyid='$cid' and workerid='$wid' and ";
    $dialog=$db->page("history","workerid,workername,clientid,clientname,addtime,action,content","$xxx clientid='$clientid' order by addtime asc",20,"action=$action&clientid=$clientid");
    include("viewhistory.php");
    break;
  case'pingfen':
    if(!MyGrade($action))ero('û��Ȩ��','?action=main');
    $id = Char_Cv("id","get","num");
    $title='�ͷ����ּ�¼';
    $P=$db->page("pingfen","id,workerid,clientid,fen,ip,addtime","companyid='$cid' and workerid='$id' order by id desc",20,"action=$action");
     //print_r($P[0]);
      /*
    $W=$Fen=array();
    $w=$db->record("worker","id,realname,nickname","companyid='$cid'");
    foreach($w as $rs){
      $W[$rs['id']]=array($rs['nickname'],$rs['realname']);
    }
    $p=$db->select("setting","allowpingfen","companyid='$cid'");
    for($i=0;$i<count($p);$i++){
      $Fen[$i]=$p[$i];
    }
    */
    include("pingfen.php");
    break;
  case'worker':
    if(!MyGrade($action))ero('û��Ȩ��','?action=main');
    $title='�ͷ�����';
    $worker=$db->page("worker","id,taxis,sortid,grade,username,password,realname,nickname,online","companyid='$cid' order by taxis asc",20,"action=$action");
    include("worker.php");
    break;
  case'workeradd':
    if(!MyGrade('worker'))ero('û��Ȩ��','?action=main');
    $title='��ӿͷ�';
    $sort=$db->record("workersort","id,sort","companyid='$cid' order by taxis asc");
    $G=array();$i=0;
    $mygrade='modify,history,getcode,count';
    $mygrade=explode(',',$mygrade);
    foreach($MyGrades as $k=>$v){
      $i++;
      $G[]='<input type="checkbox" name="mygrade[]" value="'.$k.'" '.(in_array($k,$mygrade) ? 'checked' : '').'>'.$v.($i % 5==0 && $i<12 ? '<br />' : '');
    }
    $G=implode("\n",$G);
    $ws=$db->rows("worker","companyid='$cid'");
    for($i=1;$i<=$ws+1;$i++){
      $uname=GetId($i,3,'kf');
      $nname=$i.'�ſͷ�';
      if($db->rows("worker","companyid='$cid' and username='$uname'")==0)break;
    }
    $pword=$uname;
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
    include("workeradd.php");
    break;
  case'workeredit':
    if(!MyGrade('worker'))ero('û��Ȩ��','?action=main');
    $title='�༭�ͷ�';
    $id = Char_Cv("id","get","num");
    $worker=$db->record("worker","taxis,sortid,grade,username,nickname,password,isshow,realname","companyid='$cid' and id=$id");
    $taxis=$worker[0]["taxis"];
    $sortid=$worker[0]["sortid"];
    if($worker[0]["username"]==$username){
      //header("location:?action=modify");
      //exit();
    }
    $qq=$uname=$worker[0]["username"];
    $realname=$worker[0]["realname"];
    $nickname=$worker[0]["nickname"];
    $mygrade=$worker[0]["grade"];
    $isshow=$worker[0]["isshow"];
    $isshow==1 ? $s4="checked" : $s3="checked" ;
    if(is_numeric($uname) && $worker[0]["password"]=='EQMKQQ'){
      $sort2='checked';
      $common='none';
    }else{
      $sort1='checked';
      $qq1='none';
    }
    
    $mygrade=explode(',',$mygrade);
    foreach($MyGrades as $k=>$v){
      $i++;
      $G[]='<input type="checkbox" name="mygrade[]" value="'.$k.'" '.(in_array($k,$mygrade) ? 'checked' : '').'>'.$v.($i % 5==0 && $i<12 ? '<br />' : '');
    }
    $G=implode("\n",$G);
    include("workeredit.php");
    break;
  case'workersort':
    if(!MyGrade($action))ero('û��Ȩ��','?action=main');
    $title='ϯλ����';
    $workersort=$db->record("workersort","id,sort,taxis","companyid='$cid' order by taxis asc");
    include("workersort.php");
    break;
  case'logout':
    $_SESSION["eqmk_worker_companyid"]="";
    $_SESSION["eqmk_worker_username"]="";
    header("location:../");
    exit();
    break;
  case'help':
    $title='����˵������������';
    include("../eqmkdata/help.inc.php");
    include("help.php");
    break;
	
    case'gg_dialog':
    $ac='gg_dialog';
    $MyTitle=$title='��ҳ�Ի�����';
    $ntype='gg_dialog_add';
    $ntype2='gg_dialog_edit';
    $Ads=$db->page("ads","id,thetext,theurl,hits,addtime,companyid","admin<>'' and ntype='dialog' order by id desc");
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
	
}
?>