<?php
include_once("../include/common.inc.php");
$license='FB16NXUSZKEDMO2.BL73H3I7RPNRUSUIC1FJCWI-96NXUSK';
header('Content-Type: text/xml; charset=utf-8');
$cid=Char_Cv('cid','get');
switch($action=Char_Cv('action','get')){
  case 'hour';
    $ti='最近24小时网站流量分析图';
    $label1='流量';
    $label2='时间';
    $thistime=GetTime(date('Y-m-d H:00:00',$time));
    $tmpArray[0]=array();
    $tmpArray[1]=array();
    $tmpArray[2]=array();
    for($i=-23;$i<=0;$i++){
      $a=date('H',$thistime+$i*60*60);
      $b=$thistime+$i*60*60;
      $c=$thistime+($i+1)*60*60;
      $tmpArray[0][]=intval($a)==0?date('d日',$time):$a;
      $tmpArray[1][]=$db->rows("client","companyid='$cid' and addtime>=$b and addtime<$c");
      $tmpArray[2][]=$db->rows("client","companyid='$cid' and addtime>=$b and addtime<$c group by ip");
    }
    sort($tmpArray[1],SORT_NUMERIC);
    $max=end($tmpArray[1]);
    $max+=intval($max/2);
    break;
  case 'date';
    $ti='最近30天网站流量分析图';
    $label1='流量';
    $label2='日';
    $thistime=GetTime(date('Y-m-d',$time));
    $tmpArray[0]=array();
    $tmpArray[1]=array();
    $tmpArray[2]=array();
    for($i=-29;$i<=0;$i++){
      $a=date('d',$thistime+$i*60*60*24);
      $b=$thistime+$i*60*60*24;
      $c=$thistime+($i+1)*60*60*24;
      $tmpArray[0][]=intval($a)==1?date('d月',$time):$a;
      $tmpArray[1][]=$db->rows("client","companyid='$cid' and addtime>=$b and addtime<$c");
      $tmpArray[2][]=$db->rows("client","companyid='$cid' and addtime>=$b and addtime<$c group by ip");
    }
    sort($tmpArray[1],SORT_NUMERIC);
    $max=end($tmpArray[1]);
    $max+=intval($max/2);
    break;
  case 'month';
    $ti='最近12个月网站流量分析图';
    $label1='流量';
    $label2='月';
    $thistime=GetTime(date('Y-m-01',$time));
    $tmpArray[0]=array();
    $tmpArray[1]=array();
    $tmpArray[2]=array();
    for($i=-11;$i<=0;$i++){
      $a=date('m',$thistime+$i*60*60*24*30);
      $b=$thistime+$i*60*60*24*30;
      $c=$thistime+($i+1)*60*60*24*30;
      $tmpArray[0][]=intval($a)==0?date('d年',$time):$a;
      $tmpArray[1][]=$db->rows("client","companyid='$cid' and addtime>=$b and addtime<$c");
      $tmpArray[2][]=$db->rows("client","companyid='$cid' and addtime>=$b and addtime<$c group by ip");
    }
    sort($tmpArray[1],SORT_NUMERIC);
    $max=end($tmpArray[1]);
    $max+=intval($max/2);
    break;
}
?>
<chart>
	<axis_category font='宋体' size='12' color='000000' alpha='0' bold='false' skip='0' orientation='horizontal' />
	<axis_ticks value_ticks='true' category_ticks='true' major_thickness='2' minor_thickness='1' minor_count='1' major_color='7388C1' minor_color='222222' position='outside' />
	<axis_value font='宋体' min='0' max='<?=$max?>' font='arial' bold='false' size='12' color='000000' alpha='50' steps='6' prefix='' suffix='' decimals='0' separator='' show_min='true' />

	<chart_border color='000000' top_thickness='2' bottom_thickness='2' left_thickness='2' right_thickness='2' />
<license><?=$license?></license>	
<chart_data>
		
		<row>
<null/><?foreach($tmpArray[0] as $v){?>
<string><?=$v?></string>
<?}?>
</row>

		<row>
<string>访客数量</string>
<?foreach($tmpArray[1] as $v){?>
<string><?=$v?></string>
<?}?>
</row>

		<row>
<string>独立IP数量</string>
<?foreach($tmpArray[2] as $v){?>
<string><?=$v?></string>
<?}?>
</row>

</chart_data>
<chart_grid_h alpha='10' color='000000' thickness='1' type='solid' />
<chart_grid_v alpha='10' color='000000' thickness='1' type='solid' />
<chart_pref line_thickness='1' point_shape='none' fill_shape='false' />
<chart_rect x='40' y='25' width='600' height='160' positive_color='ffffff' negative_color='000000' positive_alpha='75' negative_alpha='15'/>
<chart_type>Line</chart_type>
<chart_value position='cursor' size='12' color='000000' alpha='75' />

<draw>
  <text color='000066' alpha='15' font='宋体' rotation='-90' bold='false' size='12' x='-75' y='4' width='200' height='150' h_align='center' v_align='top'><?=$label1?></text>
  <text color='000066' alpha='15' font='宋体' rotation='-90' bold='false' size='14' x='565' y='191' width='200' height='150' h_align='center' v_align='top'><?=$label2?></text>
  <text color='000000' alpha='15' font='宋体' rotation='0' bold='false' size='20' x='190' y='-70' width='320' height='300' h_align='left' v_align='bottom'><?=$ti?></text>
  <text color='0000FF' alpha='15' font='宋体' rotation='0' bold='false' size='12' x='430' y='-74' width='320' height='300' h_align='left' v_align='bottom'></text>
</draw>

<link>
   <area x='440' y='210' width='45' height='20' url='' target='_blank'/>
</link>
<legend_label layout='horizontal' font='宋体' bold='false' size='12' color='333355' alpha='90' />
<legend_rect x='640' y='20' width='105' height='40' margin='5'  fill_alpha='8' line_alpha='0' line_thickness='0' /> 
	<series_color>
	  <color>DF0029</color>
		<color>080808</color>
		<color>205AA7</color>
		<color>7FFF00</color>
	</series_color>
</chart>