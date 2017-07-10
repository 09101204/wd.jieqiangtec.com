<?
include("../include/common.inc.php");
if(Char_Cv("action")=='login'){
  $cid=Char_Cv("cid");
  $u=Char_Cv("u");
  $p=Char_Cv("p");
  $url=Char_Cv("url");
  $p=md5($p);
  if($db->rows("worker","companyid='$cid' and username='$u' and password='$p'")==0){
    exit('用户名或密码错误');
  }
  $_SESSION["eqmk_worker_companyid"]=$cid;
  $_SESSION["eqmk_worker_username"]=$u;
  header("location:$url");
  exit();
}
$url=Char_Cv("url","get");
?>
<form action="<?=$PHP_SELF?>" method="post" name="myform">
<input type="hidden" name="action" value="login">
<input type="hidden" name="cid" value="">
<input type="hidden" name="u" value="">
<input type="hidden" name="p" value="">
<input type="hidden" name="url" value="<?=$url?>">
</form>