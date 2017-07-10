<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
  <meta name="Description" content="<?php echo $this->_var['description']; ?>" />
  
  <title><?php echo $this->_var['page_title']; ?></title>
  
  
  
  <link rel="shortcut icon" href="favicon.ico" />
  <link rel="icon" href="animated_favicon.gif" type="image/gif" />
  <link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
  
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'qrcode.js')); ?>
</head>
<body>
  <?php echo $this->fetch('library/page_header.lbi'); ?>

  <?php echo $this->fetch('library/ur_here.lbi'); ?>

  <div class="block clearfix">
    
    <div class="AreaL">
      <?php echo $this->fetch('library/left_help.lbi'); ?>
      
      
      
      <?php echo $this->fetch('library/history.lbi'); ?> </div>
    
    
    <div class="AreaR">

      <div >

        <center>
          扫码支付
          <div id="code"></div>
          <div id="msg">已完成支付？去<a href="user.php?act=order_list" target="_blank">订单中心</a></div>
        </center>
      </div>

       </div>


</body>
    <script type="text/javascript">
document.getElementById('cur_url').value = window.location.href;
</script>

    <script type="text/javascript">
$(function(){
  var str = "<?php echo $this->_var['qrcode']; ?>";
  $('#code').qrcode(str);
  
  $("#sub_btn").click(function(){
    $("#code").empty();
    var str = toUtf8($("#mytxt").val());
    
    $("#code").qrcode({
      render: "table",
      width: 200,
      height:200,
      text: str
    });
  });
})
function toUtf8(str) {   
    var out, i, len, c;   
    out = "";   
    len = str.length;   
    for(i = 0; i < len; i++) {   
      c = str.charCodeAt(i);   
      if ((c >= 0x0001) && (c <= 0x007F)) {   
          out += str.charAt(i);   
      } else if (c > 0x07FF) {   
          out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));   
          out += String.fromCharCode(0x80 | ((c >>  6) & 0x3F));   
          out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));   
      } else {   
          out += String.fromCharCode(0xC0 | ((c >>  6) & 0x1F));   
          out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));   
      }   
    }   
    return out;   
}  
</script>
  </html>