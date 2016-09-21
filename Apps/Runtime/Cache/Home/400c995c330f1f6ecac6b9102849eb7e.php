<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($title); ?></title>
<link href="/6doffice/Public/css/css.css" rel="stylesheet" type="text/css" />
<link href="/6doffice/Public/css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript" src="/6doffice/Public/js/jquery.min.js" charset="utf-8"></script>
<meta name="keywords" content="<?php echo ($keyword); ?>" />
<meta name="description" content="<?php echo ($description); ?>" />

    <script type="text/javascript" src="/6doffice/Public/js/index_top.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/home.v3.js"></script>
</head>
<body>
<!-- 新增部分开始 -->


<div class="topbar_bg">
    <div class="topbar">
        <div style="float:left">
            您当前所在的城市 <b><?php echo ($city); ?></b> <?php if($switch_url != null): ?><a href="<?php echo ($switch_url); ?>" title="切换城市">【切换城市】</a><?php endif; ?>
        </div>
        <div style="float:right">
            <?php if($username != null): ?><span class="s_l">您好，<?php echo ($username); ?>！</span><a class="s_l" href="<?php echo U('Member/Index/index');?>" target="_blank">[我的办公室]</a><a class="s_l" href="<?php echo U('Member/Login/logout');?>" target="_blank">[退出登录]</a>

            <?php else: ?>
            <span class="s_l">您好，欢迎来到<?php echo ($titlec); ?>！</span><a class="s_l" href="<?php echo U('Member/Login/index');?>" target="_blank" title="登录">[登录]</a><a class="s_l" href="<?php echo U('Member/Login/index');?>" target="_blank" title="经纪人注册">[经纪人注册]</a><?php endif; ?>
        </div>


    </div>
</div>


<div class="xg_nav">
    <div class="xg_navcont1">
        <div class="xg_logo"><a title="<?php echo ($titlec); ?>" href="<?php echo U(MODULE_NAME.'/Index/index');?>"><img alt="<?php echo ($titlec); ?>" src="/6doffice/Public/images/logo.png" height="53" /></a><span>租售引擎</span></div>
        <div class="xg_menu">
            <div class="xg_menucont">
                <ul>

                    <li <?php if($menu == 'index'): ?>class="xg_cur"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Index/index');?>">首  页</a></li>
                    <?php if($newsOpen == 1): ?><li><a href="<?php echo ($cfg["url_news"]); ?>">新  闻</a></li><?php endif; ?>
                    <li <?php if($menu == 'sale'): ?>class="xg_cur"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>">二手房</a></li>
                    <li <?php if($menu == 'rent'): ?>class="xg_cur"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Rent/index');?>">租  房</a></li>
                    <?php if($newhouseOpen == 1): ?><li <?php if($menu == 'newHouse'): ?>class="xg_cur"<?php endif; ?>><a href="<?php echo ($cfg["url_newHouse"]); ?>">新  房</a></li><?php endif; ?>
                    <li <?php if($menu == 'broker'): ?>class="xg_cur"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Broker/index');?>">经纪人</a></li>
                    <li <?php if($menu == 'community'): ?>class="xg_cur"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Community/index');?>">小  区</a></li>
                    <li <?php if($menu == 'company'): ?>class="xg_cur"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Company/index');?>">公  司</a></li>
                    <?php if($bbsOpen == 1): ?><li><a href="<?php echo ($cfg["url_bbs"]); ?>">论  坛</a></li><?php endif; ?>
                </ul>
                <span class="xg_map"><a href="<?php echo ($cfg["url"]); ?>m/map">地图找房</a></span>  </div>
            <i></i>
        </div>
    </div>
    <div class="xg_line"></div>

</div>
<!-- 新增部分结束 -->
<div class="fwxx">
    <div style="float:left;">这里有<strong><?php echo ($statistics['sellNum']+$statistics['rentNum']); ?></strong>套二手房正在出售出租，最新发布<strong><?php echo ($addFangNum); ?></strong>套。</div>
    <?php if($sinaapp != null): ?><div style="float:right; padding-top:10px;">
            <iframe width="136" height="24" frameborder="0" allowtransparency="true" marginwidth="0" marginheight="0" scrolling="no" border="0" src="http://widget.weibo.com/relationship/followbutton.php?language=zh_cn&width=136&height=24&uid=<?php echo ($sinaapp); ?>&style=2&btn=red&dpc=1"></iframe>
        </div><?php endif; ?>

</div>
<div class="content">
    <div class="content_left">
        <script type="text/javascript">
    <!--
    var timeout         = 500;
    var closetimer		= 0;
    var ddmenuitem      = 0;

    // open hidden layer
    function mopen(id)
    {
        // cancel close timer
        mcancelclosetime();

        // close old layer
        if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

        // get new layer and show it
        ddmenuitem = document.getElementById(id);
        ddmenuitem.style.visibility = 'visible';

    }
    // close showed layer
    function mclose()
    {
        if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
    }

    // go close timer
    function mclosetime()
    {
        closetimer = window.setTimeout(mclose, timeout);
    }

    // cancel close timer
    function mcancelclosetime()
    {
        if(closetimer)
        {
            window.clearTimeout(closetimer);
            closetimer = null;
        }
    }

    // close layer when click-out
    document.onclick = mclose;
    // -->
</script>
<script type="text/javascript">
    function newHouse()
    {
        document.form_search.xz.value="新房";
        document.form_search.action = '<?php echo ($cfg["url"]); ?>newHouse/index.php';
    }
    function sale()
    {
        document.form_search.xz.value="二手房";
        document.form_search.action = "<?php echo U(MODULE_NAME.'/Sell/index');?>";
    }
    function rent()
    {
        document.form_search.xz.value="租房";
        document.form_search.action = '<?php echo ($cfg["url"]); ?>rent/index.php';}

    function broker()
    {
        document.form_search.xz.value="经纪人";
        document.form_search.action = '<?php echo ($cfg["url"]); ?>broker/index.php';}

    function community()
    {
        document.form_search.xz.value="小区";
        document.form_search.action = '<?php echo ($cfg["url"]); ?>community/index.php';}

    function company()
    {
        document.form_search.xz.value="公司";
        document.form_search.action = '<?php echo ($cfg["url"]); ?>company/index.php';}
</SCRIPT>


<div class="xg_search">
    <div class="xmsearch_inp1">

        <form method="GET" action="<?php echo U(MODULE_NAME.'/Sell/index');?>" id="form_search" name="form_search">


            <input class="xg_inp1" type="text" value="请输入房源特征,地点或小区名..." id="home_kw" name="q" autocomplete="off" onfocus="if (value =='请输入房源特征,地点或小区名...'){value =''}" onblur="if (value ==''){value='请输入房源特征,地点或小区名...'}"  onclick="value =''">

            <input type="submit" class="xg_inp2" value=" "><ul id="sddm">
            <li><input name="xz" type="text"  class="x-xz" id="xz"  onmouseover="mopen('m1')" onmouseout="mclosetime()" value="二手房">
                <div id="m1" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
                    <?php if($newhouseOpen == 1): ?><a onclick="newHouse()">新房</a><?php endif; ?>
                    <a onclick="sale()">二手房</a>
                    <a onclick="rent()">租房</a>
                    <a onclick="broker()">经纪人</a>
                    <a onclick="community()">小区</a>
                    <a onclick="company()">公司</a>
                </div>
            </li>

        </ul>
        </form>
        <span class="xg_ditu"> <a href="<?php echo ($cfg["url"]); ?>m/map">地图找房 >></a></span>

        <div id="popimg2">
            <div id="test"></div>
        </div>

    </div>
    <div class="xg_keys">热点搜索：
        <?php if(is_array($boroughHot)): foreach($boroughHot as $key=>$item): ?><a title="<?php echo ($item["borough_name"]); ?>" href="<?php echo U(MODULE_NAME.'/Sell/index');?>?q=<?php echo ($item["borough_name"]); ?>"><?php echo ($item["borough_name"]); ?></a><?php endforeach; endif; ?>
    </div>
    <div class="blank"></div>
    <div class="xg_searchlist">
        <dl class="xg_s1">
            <dt>从区域开始</dt>
            <dd>
                <ul>
                    <?php if(is_array($cityarea_option)): foreach($cityarea_option as $key=>$item): if($key < 21): ?><li><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($key); ?>"><?php echo ($item); ?></a>
                            </li><?php endif; endforeach; endif; ?>

                </ul>
            </dd>
        </dl>
        <dl class="s2">
            <dt>热门房型</dt>
            <dd class="clear_box">
                <ul>
                    <li><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?room=1" target="_blank">一室</a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?room=2" target="_blank">二室</a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?room=3" target="_blank">三室</a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?room=4" target="_blank">四室</a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?room=5" target="_blank">五室</a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?room=6" target="_blank">五室以上</a></li>
                </ul>
            </dd>
        </dl>
        <dl  class="s3">
            <dt>热门价格</dt>
            <dd>
                <ul>
                    <?php if(is_array($house_price_option)): foreach($house_price_option as $key=>$item): ?><li> <a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?price=<?php echo ($key); ?>"><?php echo ($item); ?></a></li><?php endforeach; endif; ?>
                </ul>
            </dd>
        </dl>
        <dl class="s4">
            <dt>热门面积</dt>
            <dd>
                <ul>
                    <?php if(is_array($house_totalarea_option)): foreach($house_totalarea_option as $key=>$item): ?><li><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?totalarea=<?php echo ($key); ?>"><?php echo ($item); ?></a></li><?php endforeach; endif; ?>
                    <li><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>">更多</a></li>
                </ul>
            </dd>
        </dl>
    </div>
</div>

        <div class="blank"></div>
        <script src="http://<?php echo ($host); echo U(MODULE_NAME.'/Index/ad','','');?>/id/4" type="text/javascript"></script>
        <?php if($newsOpen == 1): ?><div class="h-10"></div>
            <div class="house_info">
                <dl class="new_title">
                    <dd style="width:670px;">
                        <h1>楼市资讯</h1>
                        <div class="news_more" style="padding:8px 8px 0 0;">
                            <a href="<?php echo ($cfg["url_news"]); ?>" target="_blank">更多&gt;&gt;</a>
                        </div>
                    </dd>
                </dl>
                <div class="co_main">
                    <script src='<?php echo ($cfg["url_news"]); ?>data/js/2.js' language='javascript'></script>
                </div>

            </div><?php endif; ?>

        <div class="blank"></div>
        <!--代码开始-->
        <div class="content_left1">
            <div class="columnl tjzj">
                <div class="new_title">
                    <h1>房价行情</h1>
                </div>
                <div class="clear"></div>
                <div class="tjzj_infos">
                    <div class="tjzj_img">
                        <a href="/market/" class="thumb">
                            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="350" height="180" id="zst_269_172" align="middle">
                            <param name="FlashVars" value="configURL=<?php echo U(MODULE_NAME.'/Index/swfapi');?>" />
                            <param name="allowScriptAccess" value="sameDomain" />
                            <param name="movie" value="/6doffice/Data/flash/tu.swf" />
                            <param name="quality" value="high" />
                            <param name="bgcolor" value="#ffffff" />
                            <embed src="/6doffice/Data/flash/tu.swf" quality="high" bgcolor="#ffffff" width="350" height="180" name="zst_269_172" align="middle" allowScriptAccess="sameDomain" FlashVars="configURL=<?php echo U(MODULE_NAME.'/Index/swfapi');?>" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
                        </object>
                        </a>
                    </div>
                    <div class="treads">
                        <div class="stat">截至昨日，<?php echo ($titlec); ?>统计：<br>
                            <?php echo ($city); ?>二手房均价<span class="price"><?php echo ($val["avgprice"]); ?>元/平米</span>。

                        </div><br />

                        <form action="<?php echo U(MODULE_NAME.'/Community/index');?>" id="price_form" method="get">
                            <div class="tip">还能查<a class="hidelink" target="_blank" href="<?php echo U(MODULE_NAME.'/Community/index');?>"><?php echo ($city); ?>小区房价</a>，快试试</div>
                            <div class="searchbox">
                                <input type="text" id="price_form_kw" onblur="javascript:if(this.value==''){this.value='请输入小区名或路名…';this.className='treads_input';}" onfocus="javascript:if(this.value=='请输入小区名或路名…')this.value='';this.className='treads_input2';" value="请输入小区名或路名…" x-webkit-speech="" lang="zh-CN" class="treads_input" name="q">
                                <input type="submit" value="查房价" onclick="javascript:if($('price_form_kw').value=='请输入小区名或路名…'){$('price_form_kw').value='';};" onmouseover="this.style.cursor='pointer'" class="btn">

                            </div>
                        </form>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="blank"></div>

        <div class="l w740 foucsImgs borderG " id="tab1">
            <div class="mhead row10" >
                <h2>淘房</h2>
                <p class="foucs-tab" id="foucs_tab">
                    <a href="javascript:void(0);" target="_self" class="on"><span>猜你想要</span></a>
                    <a href="javascript:void(0);" target="_self"><span>出售推荐</span></a>
                    <a href="javascript:void(0);" target="_self"><span>出租推荐</span></a>
                </p>
            </div>
            <div class="mbody" id="tab_cont">
                <div class="tabcont tabcont-on">
                    <div class="foucs-div c sliders" id="interest_v1">
                        <div class="home-v3">
                            <!-- 猜你喜欢 -->
                            <?php if(is_array($houseSellLike)): foreach($houseSellLike as $key=>$item): ?><dl>
                                    <dt>
                                        <span>
                                          <a class="fcd-img" target="_blank" href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["title"]); ?>" pl="h_intr" >
                                              <?php if($item['house_thumb'] != null): ?><img src="/6doffice/Uploads/<?php echo ($item["house_thumb"]); ?>" />
                                              <?php else: ?>
                                                  <img src="/6doffice/Public/images/housePhotoDefault.gif" /><?php endif; ?>

                                          </a>
                                          <p class="fcd-name">
                                              <a href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["title"]); ?>" pl="h_intr" >
                                                  <?php echo ($item["borough_name"]); ?>
                                              </a>
                                          </p>
                                        </span>
                                        <span class="fcd-price">￥<em><?php echo ($item["house_price"]); ?></em>万</span>
                                    </dt>
                                    <dd>
                                        <p><span><?php echo (date("m月d日",$item["updated"])); ?>&nbsp;&nbsp;</span>发布</p>
                                        <p>
                                            <span><?php echo ($item["house_totalarea"]); ?>平米&nbsp;&nbsp;</span>
                                            <span><?php echo ($item["description"]); ?>&nbsp;</span><?php echo ($item["house_floor"]); ?>/<?php echo ($item["house_topfloor"]); ?>层
                                        </p>
                                    </dd>
                                </dl><?php endforeach; endif; ?>
                        </div>
                    </div>
                </div>


                <div class="tabcont">
                    <div class="foucs-div c sliders" id="interest_v2">
                        <div class="home-v3">
                            <!-- 出售推荐 -->
                            <?php if(is_array($houseSellBest)): foreach($houseSellBest as $key=>$item): ?><dl>
                                <dt>
                                    <span >
                                      <a class="fcd-img" target="_blank" href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["title"]); ?>" pl="h_intr" >
                                          <?php if($item['house_thumb'] != null): ?><img src="/6doffice/Uploads/<?php echo ($item["house_thumb"]); ?>" />
                                              <?php else: ?>
                                              <img src="/6doffice/Public/images/housePhotoDefault.gif" /><?php endif; ?>
                                      </a>
                                      <p class="fcd-name">
                                          <a href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["title"]); ?>" pl="h_intr" >
                                              <?php echo ($item["borough_name"]); ?>
                                          </a>
                                      </p>
                                    </span>
                                    <span class="fcd-price">￥<em><?php echo ($item["house_price"]); ?></em>万</span>
                                </dt>
                                <dd>
                                    <p><span><?php echo (date("m月d日",$item["updated"])); ?>&nbsp;&nbsp;</span>发布</p>
                                    <p>
                                        <span><?php echo ($item["house_totalarea"]); ?>平米&nbsp;&nbsp;</span>
                                        <span><?php echo ($item["description"]); ?>&nbsp;</span><?php echo ($item["house_floor"]); ?>/<?php echo ($item["house_topfloor"]); ?>层
                                    </p>
                                </dd>
                            </dl><?php endforeach; endif; ?>

                        </div>
                    </div>

                </div>
                <div class="tabcont">

                    <div class="foucs-div c sliders" id="interest_v3">
                        <div class="home-v3">
                            <!-- 出租推荐 -->
                            <?php if(is_array($houseRentBest)): foreach($houseRentBest as $key=>$item): ?><dl>
                                    <dt>
                                        <span >
                                          <a class="fcd-img" target="_blank" href="<?php echo U(MODULE_NAME.'/Rent/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["title"]); ?>" pl="h_intr" >
                                              <?php if($item['house_thumb'] != null): ?><img src="/6doffice/Uploads/<?php echo ($item["house_thumb"]); ?>" />
                                                  <?php else: ?>
                                                  <img src="/6doffice/Public/images/housePhotoDefault.gif" /><?php endif; ?>
                                          </a>
                                          <p class="fcd-name">
                                              <a href="<?php echo U(MODULE_NAME.'/Rent/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["title"]); ?>" pl="h_intr" >
                                                  <?php echo ($item["borough_name"]); ?>
                                              </a>
                                          </p>
                                        </span>
                                        <span class="fcd-price">￥<em><?php echo ($item["house_price"]); ?></em>元/月</span>
                                    </dt>
                                    <dd>
                                        <p><span><?php echo (date("m月d日",$item["updated"])); ?>&nbsp;&nbsp;</span>发布</p>
                                        <p>
                                            <span><?php echo ($item["house_totalarea"]); ?>平米&nbsp;&nbsp;</span>
                                            <span><?php echo ($item["description"]); ?>&nbsp;</span><?php echo ($item["house_floor"]); ?>/<?php echo ($item["house_topfloor"]); ?>层
                                        </p>
                                    </dd>
                                </dl><?php endforeach; endif; ?>


                        </div>
                    </div>

                </div>
            </div>

        </div><!--end foucsImgs-->


        <div class="h-10"></div>

        <div class="house_info2">
            <dl class="new_title" style="*height:auto">
                <dd style="width:670px;">
                    <div class="bt"><span>七</span>天主题房源 </div>
                    <div class="jj"><?php echo ($themesMessage); ?></div><div class="blank"></div>
                    <div class="lsbt"><?php echo ($themesDescription); ?></div>
                    <div class="news_more">

                    </div>
                </dd>
            </dl><div class="blank"></div>
            <div class="w650">
                <div class="left">
                    <?php if(is_array($houseSellThemes1)): foreach($houseSellThemes1 as $key=>$item): ?><div class="img">
                        <a href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["title"]); ?>" target="_blank">
                            <?php if($item['house_thumb'] != null): ?><img src="/6doffice/Uploads/<?php echo ($item["house_thumb"]); ?>" />
                                <?php else: ?>
                                <img src="/6doffice/Public/images/housePhotoDefault.gif" /><?php endif; ?>
                            <div class="txt"><div class="bt"><?php echo ($item["borough_name"]); ?></div>
                                <div class="bt2"><?php echo ($item["house_totalarea"]); ?>㎡ 、 <?php echo ($item["description"]); ?> 、 <?php echo ($item["house_floor"]); ?>/<?php echo ($item["house_topfloor"]); ?>层 、 <?php echo ($item["house_age"]); ?>年建
                            </div>
                            </div>
                        <div class="txt2">￥<span><?php echo ($item["house_price"]); ?></span>万</div></a></div><?php endforeach; endif; ?>
                </div>

                <div class="right">
                    <div class="mmdd">

                        <?php if(is_array($houseSellThemes)): foreach($houseSellThemes as $key=>$item): ?><li>
                                <div class="kua"><a href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["title"]); ?>" target="_blank">
                                    <div class="iimg">
                                        <?php if($item['house_thumb'] != null): ?><img src="/6doffice/Uploads/<?php echo ($item["house_thumb"]); ?>" />
                                            <?php else: ?>
                                            <img src="/6doffice/Public/images/housePhotoDefault.gif" /><?php endif; ?>
                                    </div>
                                    <div class="txt">
                                        <span><?php echo ($item["borough_name"]); ?></span>
                                        <span>￥<b><?php echo ($item["house_price"]); ?></b>万</span>
                                    </div>
                                    <div class="txt2"><?php echo ($item["house_totalarea"]); ?>㎡ 、<?php echo ($item["description"]); ?></div>
                                </a>
                                </div>
                            </li><?php endforeach; endif; ?>

                        <div id=qc></div>
                    </div>

                </div>
                <div class="blank"></div>
            </div>

        </div>


        <div class="blank"></div>

        <div class="columnl">
            <div class="new_title">
                <dd>
                    <h1>最新二手房源</h1><div class="news_more" style="padding:8px 8px 0 0;"><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>" target="_blank">更多>></a></div>
                </dd>
                <dd style="margin-left: 6px; width:300px;">
                    <h1>最新出租房源</h1><div class="news_more" style="padding:8px 0 0 0;"><a href="<?php echo U(MODULE_NAME.'/Rent/index');?>" target="_blank">更多>></a></div>
                </dd>
            </div>
            <div class="co_main">
                <div class="co_main_table" style="border-right:1px dashed #ccc">
                    <table width="300" border="0" cellspacing="0" cellpadding="0" class="bgtable">
                        <?php if(is_array($houseSellNew)): foreach($houseSellNew as $key=>$item): ?><tr>
                            <td width="34" height="24" align="center"></td>
                            <td width="161" align="left"><a href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["title"]); ?>" target="_blank"><span style="color:#2f5aaf"><?php echo ($item["cityarea_name"]); ?> - </span><?php echo ($item["borough_name"]); ?></a>&nbsp;</td>
                            <td width="37" class="nshi"><?php echo ($item["description"]); ?></td>
                            <td width="68" align="right"><span style="color:#FF0000; font-weight:bold"><?php echo ($item["house_price"]); ?></span>万元</td>
                        </tr><?php endforeach; endif; ?>
                    </table>
                </div>
                <div class="co_main_table">
                    <table width="300" border="0" cellspacing="0" cellpadding="0" class="bgtable" style="margin-left:7px;">
                        <?php if(is_array($houseRentNew)): foreach($houseRentNew as $key=>$item): ?><tr>
                            <td width="34" height="24" align="center"></td>
                            <td width="151"><a href="<?php echo U(MODULE_NAME.'/Rent/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["title"]); ?>" target="_blank"><span style="color:#2f5aaf"><?php echo ($item["cityarea_name"]); ?> - </span><?php echo ($item["borough_name"]); ?></a>&nbsp;</td>
                            <td width="37" class="nshi"><?php echo ($item["description"]); ?></td>
                            <td width="78" align="right"><span style="color:#FF0000; font-weight:bold"><?php echo ($item["house_price"]); ?></span>元/月</td>
                        </tr><?php endforeach; endif; ?>
                    </table>
                </div>
            </div>

        </div>
        <!-- -->
        <div class="blank"></div>
        <script src="http://<?php echo ($host); echo U(MODULE_NAME.'/Index/ad','','');?>/id/3" type="text/javascript"></script>
    </div>


    <div class="xj_left">
        <div class="gpf_login">
            <a class="gpf_login1" target="_blank" href="<?php echo U(MODULE_NAME.'/Guest/consignSale');?>">委托房源</a>
            <a href="<?php echo U(MODULE_NAME.'/Assessment/index');?>" class="gpf_login2">评估房源</a>
            <a href="<?php echo U(MODULE_NAME.'/Guest/guestManage');?>" class="gpf_login3">游客管理</a>
        </div>
        <div class="blank5"></div>

        <div class="l_login">
            <?php if($username != null): ?><UL class="servers icon" id=servers>
                    <table width="100%" cellspacing="5" cellpadding="4">
                        <tr>
                            <td><a href="<?php echo U('Member/houseSell/addSell');?>" ><span></span><img src="/6doffice/Public/images/login/sale.gif"></a></td>
                            <td><a href="<?php echo U('Member/houseRent/addRent');?>" ><span></span><img src="/6doffice/Public/images/login/rent.gif"></a></td>
                        </tr>
                        <tr>
                            <td><a href="<?php echo U('Member/ManageBroker/pwdEdit');?>" ><span></span><img src="/6doffice/Public/images/login/pwd.gif"></a></td>
                            <td><a href="<?php echo U('Member/HouseSell/index');?>" ><span></span><img src="/6doffice/Public/images/login/house.gif"></a></td>
                        </tr>
                        <tr>
                            <td><a href="<?php echo U('Member/ManageShop/shopProfile');?>" ><span></span><img src="/6doffice/Public/images/login/shop.gif"></a></td>
                            <td><a href="<?php echo U('Member/ManageBroker/brokerProfile');?>" ><span></span><img src="/6doffice/Public/images/login/base.gif"></a></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="right"><a href="<?php echo U('Member/Login/logout');?>">退出登录>></a></td>
                        </tr>
                    </table>


                </UL>
            <?php else: ?>

                <!----------------------------------新增内容开始--------------------------------->
                <style type="text/css">
                    *{ margin:0; padding:0;}
                    .login_but{ width:250px; margin:0 auto;}
                    .login_but a{color:#666; text-decoration:none;font-size:14px;}
                    .login_but ul{ list-style:none}
                    .login_but ul li{ float:left; width:120px; text-align:center; background:url(/6doffice/Public/images/login_bg.png) no-repeat; height:35px; line-height:35px; margin-bottom:10px; font-size:14px; font-weight:bold}
                    .login_but ul li:hover{ background-position:bottom }
                    .login_but ul li:hover a{color:#E55600}
                    .login_but ul .reg{ margin-right:10px}
                </style>
                <div class="login_but">
                    <ul>
                        <li class="reg"><a href="<?php echo U('Member/Login/index');?>">经纪人注册</a></li>
                        <li ><a href="<?php echo U('Member/Login/index');?>">经纪人登录</a></li>
                        <li class="reg"><a href="<?php echo U(MODULE_NAME.'/Guest/houseSale');?>" target="_blank">游客发布</a></li>
                        <li><a href="<?php echo U(MODULE_NAME.'/Guest/guestManage');?>" target="_blank">游客房源管理</a></li>
                        <li class="reg"><a href="<?php echo U(MODULE_NAME.'/Sell/requireForm');?>" target="_blank">我要求购</a></li>
                        <li><a href="<?php echo U(MODULE_NAME.'/Rent/requireForm');?>" target="_blank">我要求租</a></li>
                    </ul>
                </div><?php endif; ?>
        </div>
        <div style="margin-top:13px;"></div>

        <script src="http://<?php echo ($host); echo U(MODULE_NAME.'/Index/ad','','');?>/id/1" type="text/javascript"></script>

        <?php if($newsOpen == 1): ?><div class="blank"></div>
            <div class="news">
                <h3>二手资讯</h3>
                <ul class="news_fy">
                    <script src='<?php echo ($cfg["url_news"]); ?>data/js/35.js' language='javascript'></script>
                </ul>

            </div><?php endif; ?>
        <div class="blank"></div>
        <DIV id=apf_id_10_slogin class="index7_entrance index_r" style="background:#fafafa"><!-- 方案二 -->
            <UL id=entrance_simple_gj class="entrance_simple_gj entrance_simple_no_gj">
                <LI class=" li_top">
                    <DIV class="div_border home_bg_all">
                        <P class="personal_btn_simple home_bg_all f_l"></P>
                        <DIV class="link_deep_blue f_l text_r"><STRONG><A class=f14 href="<?php echo U('Member/Index/index');?>" rel=nofollow>经纪人管理</A></STRONG><BR>帮助经纪人拓展业务渠道、管理房源、房源营销等服务
                            <P class=p_link_box><A class=p_link_a  href="<?php echo U('Member/Index/index');?>" rel=nofollow  >进入经纪人网络办公<I class="front_global_icon more_icon">&nbsp;</I></A>
                            </P>
                        </DIV>
                    </DIV>
                    <DIV class="clear bor_clear"></DIV>
                </LI>
                <LI class=li_bottom>
                    <DIV class="div_border home_bg_all">
                        <P class="broker_btn_simple home_bg_all f_l"></P>
                        <DIV class="link_deep_blue f_l text_r">
                            <STRONG>
                                <A class=f14 href="company/manage" rel=nofollow>公司管理</A>
                            </STRONG><BR>
                            经纪公司网络管理平台
                            <P class=p_link_box>
                                <A class=p_link_a  href="company/manage" rel=nofollow>进入公司管理通道<I class="front_global_icon more_icon">&nbsp;</I></A>
                            </P>
                        </DIV>
                    </DIV>
                </LI>
            </UL>
        </DIV>


        <div class="blank"></div>
        <DIV id=Index_recommend_broker class=recommend_bro_r>
            <DIV class=plate>
                <DIV class=h2_title><SPAN class=more><A  title="我也要上榜" href="#" target=_blank>我也要上榜&gt;&gt;</A></SPAN><b>经纪人排行榜</b></div>
                <DIV class=content2 style="clear:both">
                    <UL id=recommend_bro_ul class="recommend_bro_ul clear_box">
                        <?php if(is_array($brokerList)): foreach($brokerList as $key=>$item): ?><LI class="li_bro clear_box">
                            <DL>
                                <DT class=home_bg_all>
                                    <A title=<?php echo ($item["realname"]); ?>
                                        href="<?php echo U(MODULE_NAME.'/Shop/index');?>/id/<?php echo ($item["id"]); ?>" target="_blank" hidefoucs="true">
                                        <?php if($item['avatar'] != null): ?><IMG src="/6doffice/Uploads/<?php echo ($item["avatar"]); ?>" width=45 height=60>
                                            <?php else: ?>
                                            <IMG src="/6doffice/Public/images/demoPhoto.jpg" width=45 height=60><?php endif; ?>
                                    </A>
                                </DT>
                                <DD class=dd_name>
                                    <A title=<?php echo ($item["realname"]); ?>  href="<?php echo U(MODULE_NAME.'/Shop/index');?>/id/<?php echo ($item["id"]); ?>"  target=_blank hidefoucs="true"><?php echo ($item["realname"]); ?> </A>
                                </DD>
                                <DD>
                                    <?php if($item['idcard'] == null): ?><SPAN class="home_bg_all f_l rec_icon rec_icon_iden_err" title=实名认证></SPAN>
                                    <?php else: ?>
                                        <SPAN class="home_bg_all f_l rec_icon rec_icon_iden_ok" title=实名认证></SPAN><?php endif; ?>
                                    <?php if($item['aptitude'] == null): ?><SPAN class="home_bg_all f_l rec_icon rec_icon_com_err" title=执业认证></SPAN>
                                    <?php else: ?>
                                        <SPAN class="home_bg_all f_l rec_icon rec_icon_com_ok" title=执业认证></SPAN><?php endif; ?>
                                    <DIV class=clear></DIV>
                                </DD>
                                <DD>
                                    <?php if($item['company_name'] != null): ?><a target="_blank" href="<?php echo U(MODULE_NAME.'/Cshop/index');?>/id/<?php echo ($item["company_id"]); ?>"><?php echo ($item["company_name"]); ?> - <?php echo ($item["outlet_last"]); ?></a>
                                    <?php else: ?>
                                        <?php echo ($item["outlet_first"]); ?> - <?php echo ($item["outlet_last"]); endif; ?>
                                </DD>
                            </DL>
                        </LI><?php endforeach; endif; ?>
                    </UL>
                </DIV>
            </DIV>
        </DIV>
        <!-- -->

        <div class="blank"></div>
        <div class="bj_house">
            <h3>房价走势</h3>
            <div class="blank"></div>
            <div class="search_house"><form action="<?php echo U(MODULE_NAME.'/Community/index');?>" method="get">
                <input type="text" class="xj_input_text house_name" value="请输入小区名称" name="q" onclick="if(this.value='请输入小区名称'){this.value='';this.style.color='#000';}" onblur="if(this.value==''){ this.value='请输入小区名称';this.style.color='#A1A1A1';}else{this.style.color='#000';}"/>
                <input type="submit" class="btn_house" value="搜索小区"/></form>
            </div>
            <p align="right"><a href="<?php echo U(MODULE_NAME.'/Community/index');?>" class="see_more" style="color:#2f5aaf;">查看更多小区>></a></p>
            <table width="276" border="0" cellspacing="0" cellpadding="0" class="tab_house" style="margin: 0pt auto;">
                <?php if(is_array($boroughList)): foreach($boroughList as $key=>$item): ?><tr class="<?php if(($key%2) == 1): ?>bg_blue<?php endif; ?>">
                    <td width="49%"><a target="_blank" title='<?php echo ($item["borough_name"]); ?>' href="<?php echo U(MODULE_NAME.'/Community/general');?>/id/<?php echo ($item["id"]); ?>"><?php echo ($item["cityarea_name"]); ?> - <span class="color_blue"><?php echo ($item["borough_name"]); ?></span></a></td>
                    <td width="35%"><?php if($item['borough_avgprice'] != null): echo ($item["borough_avgprice"]); ?>元/平方<?php else: ?>-<?php endif; ?></td>
                    <?php if($item['percent_change'] != 0): if($item['percent_change'] < 0): ?><td width="10%" class="color_down">↓</td>
                        <?php else: ?>
                            <td width="10%" class="color_up">↑</td><?php endif; ?>
                    <?php else: ?>
                        <td width="6%">-</td><?php endif; ?>
                    <td width="10%"><?php echo (abs($item["percent_change"])); ?>%</td>
                </tr><?php endforeach; endif; ?>

            </table>

        </div>



        <div class="blank"></div>
        <script src="http://<?php echo ($host); echo U(MODULE_NAME.'/Index/ad','','');?>/id/2" type="text/javascript"></script>
    </div>

</div>

<div class="blank"></div>
<div style="width:990px;height:100%; margin:0px auto;">
    <!-- 2011-06-14 增加 开始 -->
    <div class="content">
        <div class="content_left">
            <div class="columnl tjzj1">
                <div class="new_title">
                    <h1>品牌中介 <span>中介合作：<?php echo ($rexian); ?></span></h1>
                    <div class="news_more" style="padding:8px 8px 0 0;"><a target="_blank" href="<?php echo U(MODULE_NAME.'/Company/index');?>">更多&gt;&gt;</a></div>
                </div>
                <div class="co_main">
                    <ul>
                        <?php if(is_array($companyList)): foreach($companyList as $key=>$item): ?><li>
                            <?php if($item['company_logo'] != null): ?><a target="_blank" href="<?php echo ($cfg["url"]); ?>cshop/<?php echo ($item["id"]); ?>"><img src="/6doffice/Uploads/<?php echo ($item["company_logo"]); ?>" /></a>
                                <?php else: ?>
                                <a target="_blank" href="<?php echo ($cfg["url"]); ?>cshop/<?php echo ($item["id"]); ?>"><img src=">/6doffice/Public/images/demoPhoto.jpg.jpg" /></a><?php endif; ?>


                        </li><?php endforeach; endif; ?>
                    </ul>
                </div>

            </div>
        </div>

        <div class="xj_left">
            <div class="xj_gjx">
                <h3><s></s><span>工具箱</span></h3>
                <ul>
                    <li class="ico1"><a target="_blank" href="<?php echo U('Tool/Index/gfnl');?>">贷款计算器</a></li>
                    <li class="ico1"><a target="_blank" href="<?php echo U('Tool/Index/sf');?>">税费计算器</a></li>
                    <li class="ico2"><a target="_blank" href="<?php echo U('Tool/Index/debx');?>">等额本息还款</a></li>
                    <li class="ico3"><a target="_blank" href="<?php echo U('Tool/Index/debj');?>">等额本金还款</a></li>
                    <li class="ico4"><a target="_blank" href="<?php echo U('Tool/Index/gjjdk');?>">公积金贷款计算</a></li>
                    <li class="ico4"><a target="_blank" href="<?php echo U('Tool/Index/tqhd');?>">提前还款计算</a></li>
                </ul>

            </div>
        </div>
    </div>
</div>
<div class="content"><div id="link">
    <script language="javascript">
        function op(k)
        {
            for(p=1;p<3;p++)
            {

                if(k==p){
                    document.getElementById("m"+p).className="lit";
                    document.getElementById("n"+p).style.display="";
                }
                else
                {
                    document.getElementById("m"+p).className="lis";
                    document.getElementById("n"+p).style.display="none";
                }
            }

        }
    </script>
    <ul>
        <div class="lis"></div>
        <li id=m1 class="lit">友情链接</li>
    </ul>

    <div id=n1 class="link_txt">
        <ul>
            <?php if(is_array($lianjie_a)): foreach($lianjie_a as $key=>$item): ?><li><a href="<?php echo ($item["link_url"]); ?>" target="_blank"><img width="88px" height="31px" src="<?php echo ($cfg["url"]); ?>upfile/<?php echo ($item["link_logo"]); ?>" /></a></li><?php endforeach; endif; ?>
        </ul>
    </div>
    <div id=n1 class="link_txt">
        <ul>
            <?php if(is_array($lianjie_s)): foreach($lianjie_s as $key=>$item): ?><li><a href="<?php echo ($item["link_url"]); ?>" target="_blank"><?php echo ($item["link_name"]); ?></a></li><?php endforeach; endif; ?>
        </ul>
    </div>
</div>
    <div style="height:12px; clear:both; overflow:hidden"></div>
    
<!-- 底部链接 -->
<div class="foot">
    <a href="<?php echo ($cfg["url"]); ?>about/about.php" target="_blank">关于我们</a> | <a href="<?php echo ($cfg["url"]); ?>about/talented.php" target="_blank">人才招聘</a> | <a href="<?php echo ($cfg["url"]); ?>about/agreement.php" target="_blank">用户协议</a> | <a href="<?php echo ($cfg["url"]); ?>about/copyright.php" target="_blank">版权声明</a> | <a href="<?php echo ($cfg["url"]); ?>about/contact.php" target="_blank">联系我们</a>
    <br>客服热线：<?php echo ($rexian); ?>&nbsp;&nbsp;&nbsp;&nbsp;客服QQ：<?php echo ($qq); ?>
    <br>Powered by <a href="http://6doffice.com/">6doffice V2</a>  <a href="http://www.miibeian.gov.cn" target="_blank"><?php echo ($beian); ?></a>

    <br>
    <?php echo ($tongji); ?>
</div>
<!-- 底部链接 结束 -->

    <SCRIPT type=text/javascript src="/6doffice/Public/js/Home_Index8.js"></SCRIPT>
    <SCRIPT type=text/javascript>
        jQuery(function(){jQuery('#city_selector').CitySelector('city_float',1000)});var isspider=0;$.HaozuCommon.setAjax('/idx/rprops/',{cityid:14,num:4},function(result){if(result){$('#Index_recommend').html(result);$.HaozuCommon.soj_href('_soj');}});(function($){var opts={'today_publish_props_count':'9,242','htmlid':'apf_id_10'};var haozuHomeLogin=new $.haozuHomeLogin(opts);})(jQuery);$.HaozuCommon.setAjax('/idx/rcomm/',{cityid:14,num:4},function(result){if(result){$('#home_recomm_comm').html(result);$.HaozuCommon.soj_href('_soj');}});$.HaozuCommon.setAjax('/idx/rbroker/',{cityid:14},function(result){if(result){$('#Index_recommend_broker').html(result);$.HaozuCommon.soj_href('_soj');}});var HaozuHomeHotSearch=new $.HaozuHomeHotSearch({'cityid':'14'});$.HaozuCommon.loadAjax();(function($){$(document).ready(function(){FooterSeoHoverBox('foot_seo_hover_label','foot_seo_ul_box');});})(jQuery);</SCRIPT>
</body>
</html>