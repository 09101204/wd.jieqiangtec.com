<?
include_once("../include/common.inc.php");
$id=Char_Cv('id','get');
if($id && is_numeric($id)){
  $theurl=$db->select("ads","theurl","id=$id");
  if($theurl){
    $db->query("update {$tbl}ads set hits=hits+1 where id=$id");
    header("location:$theurl");
    exit();
  }
}
$cid=Char_Cv('cid','get');
$ntype=Char_Cv('t','get');
if($cid){
  $agent=$db->select("setting","agent","companyid='$cid'");
  if($ntype=='dialog')$ads=$db->record("ads","id,thetext","companyid='$cid' and ntype='$ntype' order by rand()");
}
if(!$ntype)exit('Access Denied');
if($agent && !$ads)$ads=$db->record("ads","id,thetext","agent='$agent' and ntype='$ntype' order by rand()");
if(!$ads)$ads=$db->record("ads","id,thetext","admin<>'' and ntype='$ntype' order by rand()");
if($ntype=='dialog'){?>
function SlideBox(container, frequency, direction, speed) {
	if (typeof(container) == 'string') {
		container = document.getElementById(container);
	}
	this.container = container;
	this.frequency = frequency;
	this.direction = direction;
	this.speed = speed || 2;
	this.films = [];
	var divs = this.container.getElementsByTagName('div');
	for (var i = 0; i < divs.length; i++) {
		if (divs[i].className == 'slideFilm') {
			divs[i].onmouseover = function(self){return function(){self._mouseover()};}(this);
			divs[i].onmouseout = function(self){return function(){self._mouseout()};}(this);
			this.films[this.films.length] = divs[i];
		}
	}
	this._playTimeoutId = null;
	this._slideTimeoutId = null;
	this._slidable = true;
	var isIE5 = navigator.userAgent.toLowerCase().indexOf("msie 5.0")>0;
	if (!isIE5)
		this._loop();
}

SlideBox.prototype = {
	_loop : function() {
		var sb = this;
		this._playTimeoutId = setTimeout(function(){sb._slide()}, this.frequency);
	},

	_slide : function() {
		var sb = this;
		var _slide = function() {
      try{
			if (!sb._slidable) return;
			var c = sb.container;
			if (sb.direction == 'top') {
				if (c.scrollTop < c.offsetHeight-sb.speed) {
					c.scrollTop += sb.speed;
				} else {
					clearInterval(sb._slideTimeoutId);
					sb._loop();
					var ul = c.getElementsByTagName('ul')[0];
					ul.appendChild(c.getElementsByTagName('li')[0]);
					c.scrollTop = 0;
				}
			} else if (sb.direction == 'left') {
				if (c.scrollLeft < c.offsetWidth-sb.speed) {
					c.scrollLeft += sb.speed;
				} else {
					clearInterval(sb._slideTimeoutId);
					sb._loop();
					var ul = c.getElementsByTagName('ul')[0];
					ul.appendChild(c.getElementsByTagName('li')[0]);
					c.scrollLeft = 0;
				}
			}
      }catch(e){}
		}
		this._slideTimeoutId = setInterval(_slide, 10);
	},

	_mouseover : function() {
		this._slidable = false;
	},

	_mouseout : function() {
		this._slidable = true;
	}
}
document.write("<table border=\"0\" padding=\"0\" cellspacing=\"0\"><tr><td><style type=\"text/css\">\n div#Shortcu {height:25px;}\n div#Shortcu div {height:25px;text-align:left;overflow:hidden;}\n div#Shortcu div .Info{ float:left; width:100%; padding-right:10px; height:25px; line-height:20px;}\n div#Shortcu div .Info ul{ margin:0px 0 0 0; padding:0px; list-style-type:none;}\n div#Shortcu div .Info ul li{  }\n div#Shortcu div .slideFilm{ width:100%;}\n </style>\n <div id=\"Shortcu\"><div><div class=\"Info\" id=\"ADList\"><ul><?foreach($ads as $rs){?><li><div class=\"slideFilm\"> <a href=\"<?=$homepage?>api/ads.php?id=<?=$rs['id']?>\" target=\"_blank\"><?=$rs['thetext']?></a></div></li><?}?></ul>\n <script type=\"text/javascript\">	\n new SlideBox('ADList', 5000, 'top');\n </script>\n </div></div></div></td></tr></table>");
<?exit();
}?>
<html>
<title>客服软件广告</title>
<META http-equiv="Content-Type" content="text/html; charset=gb2312">
<style type="text/css">
<!--
A:visited{TEXT-DECORATION: none;Color:#333366}
A:active{TEXT-DECORATION: none;Color:#333366}
A:hover{TEXT-DECORATION:;color:#cc0000}
A:link{text-decoration: none;Color:#333366}
body {
  font-size: 9pt;
  border: 1px solid #C0C0C0;
  scrollbar-face-color: #F6F6f6;
  scrollbar-highlight-color: #FFFFFF;
  scrollbar-shadow-color: #F0F2DB;
  scrollbar-3dlight-color: #cccccc;
  scrollbar-arrow-color:  #666666;
  scrollbar-track-color: #FCFDF9;
  scrollbar-darkshadow-color: #cccccc; 
  word-break:break-all;
  overflow:hidden;
  margin:0px;
}
TD,p{FONT-SIZE: 9pt; FONT-FAMILY: "宋体"}
-->
</style>
<body LEFTMARGIN="0" TOPMARGIN="0" scroll="no" oncontextmenu=self.event.returnValue=false onselectstart="return false">
<?if($ntype=='main'){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/trade_2.jpg">
  <tr background="images/trade_2.jpg"> 
    <td width="5%"><img src="images/trade_1.jpg" width="40" height="53" alt=""></td>
    <td width="95%" background="images/trade_2.jpg">
     <MARQUEE onmouseout=this.start() direction=up onmouseover=this.stop() height=48 scrollAmount=1 scrollDelay=-2 width="100%">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <?foreach($ads as $rs){?>
        <tr> 
          <td><a href="?id=<?=$rs['id']?>" target="_blank"><?=$rs['thetext']?></a></td>
        </tr>
      <?}?>
      </table>
    </MARQUEE>
   </td>
  </tr>
</table>
<?}elseif($ntype=='login' && $ads){?>
<a href="?id=<?=$ads[0]['id']?>" target="_blank"><img src="<?=$ads[0]['thetext']?>" width="301" height="191" border="0" /> </a>
<?}?>
</body>
</html>