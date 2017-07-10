<link href="themes/ecmoban_suning/qq/images/qq.css" rel="stylesheet" type="text/css" />
 
<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
</script>
<script type="text/javascript">
//设为首页 www.aspku.com
function SetHome(obj,url){
    try{
        obj.style.behavior='url(#default#homepage)';
       obj.setHomePage(url);
   }catch(e){
       if(window.netscape){
          try{
              netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
         }catch(e){
              alert("抱歉，此操作被浏览器拒绝！\n\n请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]设置为'true'");
          }
       }else{
        alert("抱歉，您所使用的浏览器无法完成此操作。\n\n您需要手动将【"+url+"】设置为首页。");
       }
  }
}
 
//收藏本站 bbs.aspku.com
function AddFavorite(title, url) {
  try {
      window.external.addFavorite(url, title);
  }
catch (e) {
     try {
       window.sidebar.addPanel(title, url, "");
    }
     catch (e) {
         alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");
     }
  }
}

function show_div(obj){
	if(obj.className == "more-menu")
	{
		obj.className = "more-menu hover";
	}
	else
	{
		obj.className = "more-menu";
	}
}	
</script>
<?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?>

<div class="hd_global_top_bar" id="global_top_bar">
  <div class="wrap clearfix">
    <div class="hd_topbar_left clearfix">
      <div class="hd_unlogin_wrap" id="global_unlogin">
      
        <div class="hd_login clearfix" id="ECS_MEMBERZONE"><?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>
        
      </div>
    </div>
    <div class="hd_top_manu clearfix">
      <ul class="clearfix">
        <li class="hd_menu_tit hd_my_order" id="glHdMyYhd" onMouseOver= "this.className='hd_menu_tit hd_my_order hd_menu_hover'" onMouseOut= "this.className='hd_menu_tit hd_my_order'"> <a class="hd_menu" target="_blank" href="user.php"><s></s>我的1号店</a>
          <div class="hd_menu_list">
            <ul>
              <li><a href="user.php?act=order_list" target="_blank">我的订单</a></li>
              <li><a href="user.php?act=affiliate" target="_blank">我的推荐</a></li>
              <li><a href="user.php?act=bonus" target="_blank">我的红包</a></li>
              <li><a href="user.php?act=collection_list" target="_blank">我的收藏夹</a></li>
              <li><a href="user.php?act=comment_list" target="_blank">我的评价</a></li>
            </ul>
          </div>
        </li>
        <?php if ($this->_var['navigator_list']['top']): ?> 
        <?php $_from = $this->_var['navigator_list']['top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_top_list']['iteration']++;
?>
        <li class="hd_menu_tit"> <a target="_blank" href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?> target="_blank" <?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a> </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        <?php endif; ?>
      </ul>
  </div>
</div>

<div id="site_header" class="wrap hd_header clearfix">
  <div class="hd_logo_area fl clearfix" id="logo_areaID"> 
  
  <a class="fl" href="./index.php"> <img alt="1号店" src="themes/ecmoban_yihaodian/images/logo.gif"> </a>
  
  </div>
  
  
  <div class="hd_head_search">
    <div class="hd_search_form clearfix">
    
      <div class="hd_search_wrap clearfix">
      <script type="text/javascript">
    
    <!--
    function checkSearchForm()
    {
        if(document.getElementById('keyword').value)
        {
            return true;
        }
        else
        {
            alert("请输入搜索关键词！");
            return false;
        }
    }
    -->
    
    </script>
      <form name="searchForm" id="newKeywords" method="get" action="search.php" onsubmit="return checkSearchForm()">
        <input type="text" value="" onblur="if(this.value == ''){this.value=''}" onfocus="if(this.value == ''){this.value = ''}" maxlength="100" style="color:#333333;" id="keyword" name="keywords" class="hd_input_test">
        <button class="hd_search_btn" type="button" onclick="$('#newKeywords').submit()">搜 索</button>
        </form>
      </div>
      
    </div>
    <p class="hd_hot_search" id="hotKeywordsShow">        <a href="search.php?keywords=%E7%BE%8E%E4%B8%BD%E5%BF%85%E5%A4%87" target="_blank" title="美丽必备">美丽必备</a>  <a href="search.php?keywords=%E5%A4%8F%E6%97%A5%E5%A5%BD%E7%9D%A1%E7%9C%A0" target="_blank" title="夏日好睡眠">夏日好睡眠</a>  <a href="search.php?keywords=%E8%81%94%E6%83%B3K900" target="_blank" title="联想K900">联想K900</a>  <a href="search.php?keywords=%E6%B0%B4" target="_blank" title="水">水</a>  <a href="search.php?keywords=%E6%B1%BD%E8%BD%A6%E7%94%A8%E5%93%81" target="_blank" title="汽车用品">汽车用品</a>  <a href="search.php?keywords=%E5%86%B7%E9%A3%8E%E6%89%87" target="_blank" title="冷风扇">冷风扇</a>  <a href="search.php?keywords=%E4%B9%90%E4%BA%AB%E6%97%A9%E9%A4%90" target="_blank" title="乐享早餐">乐享早餐</a>  <a href="search.php?keywords=%E6%96%B0%E5%A5%BD%E7%88%B8%E5%A6%88" target="_blank" title="新好爸妈">新好爸妈</a>        </p>
  </div>
  <div id="hdPrismWrap" class="hd_prism_wrap">
    <div id="hdPrismCoupon" class="hd_prism hd_welfare"> <u id="hdPrismCouponNum" style="display:none;"></u> <a class="hd_prism_tab" target="_blank" href="user.php?act=bonus"> <em></em>
      <p>福利</p>
      <i></i> </a>
      <div id="hdPrismCouponList" class="hd_prism_show global_loading"> </div>
    </div>
    <div id="hdPrismOrder" class="hd_prism hd_order"> <u id="hdPrismOrderNum" style="display:none;"></u> <a class="hd_prism_tab" data-ref="top_prism_order" target="_blank" href="user.php?act=order_list"> <em></em>
      <p>订单查询</p>
      <i></i> </a>
      <div id="hdPrismOrderList" class="hd_prism_show global_loading"> </div>
    </div>
  <div class="hd_mini_cart">
        
        <i></i><span id="in_cart_num"><u id="ECS_CARTINFO"><?php 
$k = array (
  'name' => 'cart_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></u></span> <a class="hd_prism_cart" href="flow.php"> <em></em>购物车 </a> 

<div class="ap_shopping_warning"></div>
</div>
    
  </div>
  
</div>

<div class="menu_box clearfix"> 
<div class="block"> 
<div class="menu">
  <a href="index.php"<?php if ($this->_var['navigator_list']['config']['index'] == 1): ?> class="cur"<?php endif; ?>><?php echo $this->_var['lang']['home']; ?></a>
  <?php $_from = $this->_var['navigator_list']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_middle_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_middle_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_middle_list']['iteration']++;
?>
  <a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?>target="_blank" <?php endif; ?> <?php if ($this->_var['nav']['active'] == 1): ?> class="cur"<?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a>
 
 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div> 
</div>

</div>


