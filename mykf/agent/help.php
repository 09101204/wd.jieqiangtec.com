<?php
if(!defined('IN_EQMK') || !defined('IN_AGENT')) {
	exit('Access Denied');
}
include("header.php");?>
<style type="text/css">
.help{
  width:100%;
  text-align:left;
  margin:0px;
  padding:0px;
}
.help li{
  margin:10px 0px 10px 0px;
  line-height:20px;
}
.help .title{
  color:#0000ff;
  font-weight:bold;
}
.help .title2{
  color:red;
  font-weight:bold;
}
.help .content{
  margin-left:20px;
}
</style>
<ul class="help">
<?foreach($AgentHelp as $k=>$v){?>
<li><?$id='loginmsg';?>
  <a name="<?=$k?>"></a>
  <div class="title" id="<?=$k?>_"><?=$v[0]?></div>
  <div class="content"><?=$v[1]?> <a href="javascript:history.go(-1)" style="color:#999999;text-decoration:none" title="·µ»Ø"><<<</a></div>
</li>
<?}?>
</ul>
<script type="text/javascript">
function $(id) {
	return document.getElementById(id);
}
window.onload=function(){
  var aParams = document.location.href.split('#') ;
  var uid=aParams[aParams.length-1];
  if(!uid)return;
  $(uid+'_').className='title2';
}
</script>
<?include("footer.php");?>