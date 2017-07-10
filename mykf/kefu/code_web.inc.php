<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$cid=$_GET['cid'];
$wid=$_GET['wid'];
$uid=$_GET['uid'];
?>
<script type="text/javascript" src="../include/javascript/ajax.js"></script>
<script type="text/javascript">
function stopError() {
  return true;
}
window.onerror = stopError;
var invite=0;
setInterval("UpdateData()",1000);
function UpdateData(){
  var tmp='action=newGet';
  tmp+='&cid=<?=$cid?>';
  tmp+='&wid=<?=$wid?>';
  tmp+='&uid=<?=$uid?>';
  tmp+='&invite='+invite;
  try{
  var x=new Ajax('HTML','');
  x.post('../getdata/content/client.php?'+Math.random(),tmp,function(s){
    if(s.indexOf('&fdata=')!=-1){
      var t=s.split('&fdata=');
      if(t[1]!=''){
        window.status='kefu_invite'+t[1];
      }
    }
  });
  }catch(e){}
}
</script>