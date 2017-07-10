<?php defined('IN_IA') or exit('Access Denied');?>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>

    <title><?php  echo $wkj['title'];?></title>
    <link rel="stylesheet" type="text/css"
          href="<?php echo MON_WKJ_RES;?>css/admin.css?ver=1">
    <script type="text/javascript">var _speedMark = new Date(), _loadTime = '1429101314';</script>
</head>
<body class="index">
<div style="display:none"><img
        src="<?php echo MON_WKJ_RES;?>images/TB2iVEjcXXXXXXjXpXXXXXXXXXX-23432926.jpg"/></div>
<div id="loading" class="loading">

    <img class="img-responsive"
                                       src="<?php echo MON_WKJ_RES;?>images/TB2qfh4aFXXXXatXpXXXXXXXXXX-23432926.png"
                                       alt="图片"/></div>
<div class="baominghou gyStyle">
    <div class="topImg"><a href="<?php  echo $wkj['p_url'];?>">

        <img class="img-responsive" src="<?php  echo $_W['attachurl'];?><?php  echo $wkj['p_pic'];?>"
                                                              alt="图片"/></a>

        <div class="daijishi" id="daijishi"> 我的活动倒计时：<span
                style="margin-left:0;"></span>天<span></span>时<span></span>分<span></span>秒
        </div>
        <span id="wo" style="display:none">我</span>

        <div class="kucun" style="display:none">30件</div>
        <div class="xianjia" style="display:none">￥???</div>
    </div>
    <div class="infoks"><p class="wenzikk"><span><?php  echo $joinUser['nickname'];?></span>：<br/> <?php  if($helped) { ?><?php  echo $fk_already_tip;?><?php  } else { ?><?php  echo $fk_fist_tip;?><?php  } ?></p>


        <div class="anniouk clearfix">


            <!-- 正常状态-->
            <?php  if($status==$this::$KJ_STATUS_ZC) { ?>
                  <div class="a1">


                <?php  if($firendJoined) { ?>
                <a href="<?php  echo $this->createMobileUrl('Index',array('kid'=>$wkj['id'],'openid'=>$firend['openid']))?>"> <img class="fenxiangk"
                                                    src="<?php echo MON_WKJ_RES;?>images/fenxiang.png"
                                                    alt="图片"/><span>我的活动</span></a>

                <?php  } else { ?>


                    <a href="<?php  echo $wkj['follow_url'];?>"> <img class="fenxiangk"
                                                     src="<?php echo MON_WKJ_RES;?>images/fenxiang.png" alt="图片"/><span>我要参与</span></a>
                <?php  } ?>


            </div>


                <div class="a2 bangkanyidao">

                <?php  if($helped) { ?>

                    <a href="<?php  echo $this->createMobileUrl('ranking',array('kid'=>$wkj['id'],'uid'=>$joinUser['id'],'fopenid'=>$firend['openid']),true)?>"><img
                            class="wdhuodong" src="<?php echo MON_WKJ_RES;?>images/futou.png"
                            alt="图片"/> <span>他的排行榜</a></span>
                <?php  } else { ?>
                     <a href="javascript:;" id="kanjia"><img class="wdhuodong" src="<?php echo MON_WKJ_RES;?>images/futou.png"
                                                        alt="图片"/><span>帮TA砍一刀</a></span>
                <?php  } ?>

            </div>

            <?php  } ?>


            <!--未开始状态-->
            <?php  if($status==$this::$KJ_STATUS_WKS) { ?>

                    <div class="a2 qingchuFloat">

                        <a href="javascript:;" ><img class="wdhuodong" src="<?php echo MON_WKJ_RES;?>images/futou.png" alt="图片"/><span>活动位未开始</a></span>
                    </div>

            <?php  } ?>


            <!--其他状态 -->
            <?php  if(($status==$this::$KJ_STATUS_JS||$status==$this::$KJ_STATUS_XD||$status==$this::$KJ_STATUS_GM)) { ?>

                <div class="a1">

                    <?php  if($firendJoined) { ?>
                            <a href="<?php  echo $this->createMobileUrl('Index',array('kid'=>$wkj['id'],'openid'=>$firend['openid']))?>"> <img class="fenxiangk" src="<?php echo MON_WKJ_RES;?>images/fenxiang.png" alt="图片"/><span>我的活动</span></a>
                    <?php  } ?>
                </div>

                <div class="a2 <?php  if(!$firendJoined) { ?>qingchuFloat<?php  } ?>" >
                    <a href="<?php  echo $this->createMobileUrl('ranking',array('kid'=>$wkj['id'],'uid'=>$joinUser['id'],'fopenid'=>$firend['openid']),true)?>"><img class="wdhuodong" src="<?php echo MON_WKJ_RES;?>images/futou.png" alt="图片"/> <span>他的排行榜</a></span>
                </div>
            <?php  } ?>




        </div>

    </div>
</div>





<div id="tanchuk" class="tanchuk">
    <div class="tanchukMain">
        <div class="jianqiank"><strong>减0.01元</strong></div>
        <p>朋友，你这一刀已经砍到底了，商品数量有限，快让你朋友斩获吧！</p>

        <div class="anniouk clearfix"><a class="baisea quxiaok" href="javascript:;">取消</a> <a
                class="hongsea fenxiangDiv" href="javascript:;">找朋友帮她砍</a></div>
    </div>
</div>






<!--<div class="guanzhuan"><a-->
        <!--href="http://mp.weixin.qq.com/s?__biz=MjM5MDc3MzI5Mw==&mid=200800015&idx=1&sn=2e8850135b20dabc40a4feb84c56e74d#rd">关-->
    <!--注</a></div>-->



<div class="contact" style="padding-bottom:10px;text-align:center">活动热线：<a href="tel:<?php  echo $wkj['hot_tel'];?>"
                                                                           style="color:blue;font-size:16px"><?php  echo $wkj['hot_tel'];?></a>
</div>
<div class="xinyuemin" id="cprt"><a href="<?php  echo $wkj['copyright_url'];?>" target="_blank"><?php  echo $wkj['copyright'];?></a></div>
<div id="zhegaik" class="zhegaik"></div>



<div class="jizanimg">
    <div class="jiantou"></div>
    <p>分享到朋友圈就有机会获赠能量<!-- ，朋友中奖，你也中奖 -->。</p></div>
<div class="fenxiangImgk"><img class="img-responsive"
                               src="<?php echo MON_WKJ_RES;?>images/TB20KOcbFXXXXXmXXXXXXXXXXXX-23432926.png"
                               alt="图片"/></div>
<script type="text/javascript">
    var uid="<?php  echo $joinUser['id'];?>";
    var firend=true;
var ajaxUrl="<?php  echo MonUtil::str_murl($this->createMobileUrl ('Ajax',array('kid'=>$wkj['id'],'uid'=>$joinUser['id']),true)) ?>";
var rankingUrl="<?php  echo MonUtil::str_murl($this->createMobileUrl ('Ranking',array('kid'=>$wkj['id'],'fopenid'=>$firend['openid']),true)) ?>";

var res_path="<?php echo MON_WKJ_RES;?>";


var hid=1;
/*活动表 活动id*/
var kid = <?php  echo $wkj['id'];?>;
/*商品表 商品ID*/
var gid = "1";
/*活动参与记录表 参与 ID */
var jid = "492";
/* 是否 参与 过此次活动 true false */
var join = "1";
/* 是否 为 这个活动 砍过价 true false */
var bargain = "1";
/* 活动状态  已购买 已结束  */
var joinstatus = "<?php  echo $statusText;?>";

/* 活动结束时间 */
var joinendtime = "1432355143";
var endTimeJieshu = <?php  echo $wkj['endtime'];?>;

var startTimeKaishi = <?php echo TIMESTAMP;?>;


/*结束时间 年*/
var year = <?php  echo $year;?>;
/*结束时间 月*/
var yue = <?php  echo $month;?>;
/*结束时间 日*/
var date = <?php  echo $day;?>;
/*结束时间 时*/
var shi = <?php  echo $hours;?>;
/*结束时间 分*/
var fen = <?php  echo $minutes;?>;


</script>
<script src="<?php echo MON_WKJ_RES;?>js/jquery-1.11.2.min.js" type="text/javascript"
        charset="utf-8"></script>
<script src="<?php echo MON_WKJ_RES;?>js/wkj.js?ver=2" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo MON_WKJ_RES;?>js/wxapi-min.js"></script>
<script src="<?php echo MON_WKJ_RES;?>js/image-lazyload-min.js"></script>

<?php  echo register_jssdk(false);?>
<script type="text/javascript">
    initShare();

    function initShare(){
        wx.ready(function () {
            sharedata = {
                title: "<?php  echo $wkj['share_title']?>",
                desc: "<?php  echo $wkj['share_content']?>",
                link: "<?php  echo $shareUrl;?>&uid="+uid,
                imgUrl: "<?php  echo $_W['attachurl'];?><?php  echo $wkj['share_icon'];?>",
                success: function(){

                },
                cancel: function(){
                    // alert("分享失败，可能是网络问题，一会儿再试试？");
                }
            };
            wx.onMenuShareAppMessage(sharedata);
            wx.onMenuShareTimeline(sharedata);
        });
    }

</script>


</body></html>