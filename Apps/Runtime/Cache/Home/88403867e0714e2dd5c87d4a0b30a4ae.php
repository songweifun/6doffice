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

    <script src="/6doffice/Public/js/select.js" type="text/javascript"></script>
    <script src="/6doffice/Public/js/js.js" type="text/javascript"></script>
    <link href="/6doffice/Public/css/add.css" rel="stylesheet" type="text/css" />
    <link href="/6doffice/Public/css/menuSearch.css" rel="stylesheet" type="text/css" />
    <script type="text/ecmascript">
        $(function(){
            $(".listing>ol").hover(
                    function(){
                        $(this).addClass("hover")
                        $(this).find(".hr").css({"border-bottom":"#1d78c0 1px solid"})
                    },
                    function(){
                        $(this).removeClass("hover")
                        $(this).find(".hr").css({"border-bottom":"#ccc 1px dashed"})
                    }

            )

            //自家的

        })
    </script>
</head>

<body>

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
        document.topSearchForm.xz.value="新房";
        document.topSearchForm.action = '<?php echo ($cfg["url"]); ?>newHouse/index.php';
    }
    function sale()
    {
        document.topSearchForm.xz.value="二手房";
        document.topSearchForm.action = "<?php echo U(MODULE_NAME.'/Sell/index');?>";
    }
    function rent()
    {
        document.topSearchForm.xz.value="租房";
        document.topSearchForm.action = '<?php echo ($cfg["url"]); ?>rent/index.php';}

    function broker()
    {
        document.topSearchForm.xz.value="经纪人";
        document.topSearchForm.action = "<?php echo U(MODULE_NAME.'/Broker/index');?>";}

    function community()
    {
        document.topSearchForm.xz.value="小区";
        document.topSearchForm.action = "<?php echo U(MODULE_NAME.'/Community/index');?>";}

    function company()
    {
        document.topSearchForm.xz.value="公司";
        document.topSearchForm.action = '<?php echo ($cfg["url"]); ?>company/index.php';}
</SCRIPT>
<div class="topbar_bg">
    <div class="topbar">
        <div style="float:left">
            您当前所在的城市 <b><?php echo ($city); ?></b>
            <?php if($switch_url != null): ?><a href="<?php echo ($cfg["page"]["switch_url"]); ?>" title="切换城市">【切换城市】</a><?php endif; ?>
        </div>
        <div style="float:right">
            <?php if($username != null): ?><span class="s_l">您好，<?php echo ($username); ?>！</span>
            <a class="s_l" href="<?php echo U('Member/Index/index');?>" target="_blank">[我的办公室]</a>
            <a class="s_l" href="<?php echo U('Member/Login/logout');?>" target="_blank">[退出登录]</a>

            <?php else: ?>
            <span class="s_l">您好，欢迎来到<?php echo ($titlec); ?>！</span>
                <a class="s_l" href="<?php echo U('Member/Login/index');?>" target="_blank" title="登录">[登录]</a>
                <a class="s_l" href="<?php echo U('Member/Login/index');?>" target="_blank" title="经纪人注册">[经纪人注册]</a><?php endif; ?>
        </div>
    </div>
</div>

<div class="xg_nav">

    <div class="xg_nav">
        <div class="xg_navcont1">
            <div class="xg_logo"><a title="<?php echo ($cfg["page"]["titlec"]); ?>" href="<?php echo U(MODULE_NAME.'/Index/index');?>"><img alt="<?php echo ($cfg["page"]["titlec"]); ?>" src="/6doffice/Public/images/logo.png" height="53" /></a></div>
            <div class="xg_menu">
                <div class="xg_menucont">
                    <ul>

                        <li <?php if($menu == 'index'): ?>class="xg_cur"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Index/index');?>">首  页</a></li>
                        <?php if($newsOpen == 1): ?><li><a href="<?php echo ($cfg["url_news"]); ?>">新  闻</a></li><?php endif; ?>
                        <li <?php if($menu == 'sale'): ?>class="xg_cur"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>">二手房</a></li>
                        <li <?php if($menu == 'rent'): ?>class="xg_cur"<?php endif; ?>><a href="<?php echo ($cfg["url_rent"]); ?>">租  房</a></li>
                        <?php if($newhouseOpen == 1): ?><li <?php if($menu == 'newHouse'): ?>class="xg_cur"<?php endif; ?>><a href="<?php echo ($cfg["url_newHouse"]); ?>">新  房</a></li><?php endif; ?>
                        <li <?php if(($menu == 'broker') or ($menu=='shop')): ?>class="xg_cur"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Broker/index');?>">经纪人</a></li>
                        <li <?php if($menu == 'community'): ?>class="xg_cur"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Community/index');?>">小  区</a></li>
                        <li <?php if($menu == 'company'): ?>class="xg_cur"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Company/index');?>">公  司</a></li>
                        <?php if($bbsOpen == 1): ?><li><a href="<?php echo ($cfg["url_bbs"]); ?>">论  坛</a></li><?php endif; ?>
                    </ul>
                    <!--  <span class="xg_phone"><a href="#">手机</a></span> <span class="xg_ditie"><a href="#">地铁找房</a></span> --><span class="xg_map"><?php if($menu == 'sale'): ?><a href="<?php echo ($cfg["url"]); ?>m/map">地图找房</a><?php elseif($menu == 'rent'): ?><a href="<?php echo ($cfg["url"]); ?>m/maprent">地图找房</a><?php else: ?><a href="<?php echo ($cfg["url"]); ?>m/map">地图找房</a><?php endif; ?></span>  </div>
                <i></i>
            </div>
        </div>


        <div class="xg_line"></div>

        <div class="xg_navsearch">

            <?php if(($menu == 'sale') or ($menu == 'pinggu')): ?><div class="xg_nvain">
                    <form name="topSearchForm" method="GET" action="<?php echo U(MODULE_NAME.'/Sell/index');?>">
                        <?php if($_GET['q']== null): ?><input name="q" type="text" id="ts" class="xg_navinp1" onblur="if(this.value ==''||this.value == '可输入小区名、路名或房源特征'){this.value = '可输入小区名、路名或房源特征';}" onfocus="if(this.value == '可输入小区名、路名或房源特征'){this.value = '';}" value="可输入小区名、路名或房源特征" />
                            <?php else: ?>
                                <input name="q" type="text" id="ts" class="xg_navinp1" onblur="if(this.value ==''||this.value == '可输入小区名、路名或房源特征'){this.value = '可输入小区名、路名或房源特征';}" onfocus="if(this.value == '可输入小区名、路名或房源特征'){this.value = '';}" value="<?php echo ($_GET['q']); ?>" /><?php endif; ?>
                </div>

                <ul id="sddm2">
                    <li>
                        <input name="xz" type="text"  class="x-xz3" id="xz"  onmouseover="mopen('m1')" onmouseout="mclosetime()" value="二手房">
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
                    <INPUT value=""  class=xg_navinp2 type=submit>
                    </form>


            <?php elseif($menu == 'rent'): ?>
                <div class="xg_nvain">
                    <form name="topSearchForm" method="GET" action="<?php echo ($cfg["url"]); ?>rent/index.php">
                        <input name="q" type="text" id="ts" class="xg_navinp1" onblur="if(this.value ==''||this.value == '可输入小区名、路名或房源特征'){this.value = '可输入小区名、路名或房源特征';}" onfocus="if(this.value == '可输入小区名、路名或房源特征'){this.value = '';}" value="<?php if($_GET['q']== null): ?>可输入小区名、路名或房源特征<?php else: echo ($_GET['q']); endif; ?>" />
                </div>
                <ul id="sddm2">
                    <li>
                        <input name="xz" type="text"  class="x-xz3" id="xz"  onmouseover="mopen('m1')" onmouseout="mclosetime()" value="租房">
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
                <INPUT value=""  class=xg_navinp2 type=submit>
                </form>
            <?php elseif($menu == 'community'): ?>
                <div class="xg_nvain">
                    <form name="topSearchForm" method="GET" action="<?php echo U(MODULE_NAME.'/Community/index');?>">
                        <input name="q" type="text" id="ts"  class="xg_navinp1" onblur="if(this.value ==''||this.value == '可输入小区名、路名或划片学校'){this.value = '可输入小区名、路名或划片学校';}" onfocus="if(this.value == '可输入小区名、路名或划片学校'){this.value = '';}" value="<?php if($_GET['q']== null): ?>可输入小区名、路名或划片学校<?php else: echo ($_GET['q']); endif; ?>" />
                </div>
                <ul id="sddm2">
                    <li>
                        <input name="xz" type="text"  class="x-xz3" id="xz"  onmouseover="mopen('m1')" onmouseout="mclosetime()" value="小区">
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
                <INPUT value=""  class=xg_navinp2 type=submit>
                </form>
            <?php elseif($menu == 'company'): ?>
                <div class="xg_nvain">
                    <form name="topSearchForm" method="GET" action="<?php echo U(MODULE_NAME.'/Company/index');?>">
                        <input name="q" type="text"  id="ts" class="xg_navinp1" onblur="if(this.value ==''||this.value == '可输入公司名称'){this.value = '可输入公司名称';}" onfocus="if(this.value == '可输入公司名称'){this.value = '';}" value="<?php if($_GET['q']== null): ?>可输入公司名称<?php else: echo ($_GET['q']); endif; ?>" />
                </div>
                <ul id="sddm2">
                <li>
                    <input name="xz" type="text"  class="x-xz3" id="xz"  onmouseover="mopen('m1')" onmouseout="mclosetime()" value="公司">
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
                <INPUT value=""  class=xg_navinp2 type=submit>
                </form>
            <?php elseif(($menu == 'broker') or ($menu == 'shop')): ?>
                <div class="xg_nvain">
                    <form name="topSearchForm" method="GET" action="<?php echo U(MODULE_NAME.'/Broker/index');?>">
                        <input name="q" type="text" id="ts"  class="xg_navinp1" onblur="if(this.value ==''||this.value == '可输入经纪人名、门店名，或公司名称关键词'){this.value = '可输入经纪人名、门店名，或公司名称关键词';}" onfocus="if(this.value == '可输入经纪人名、门店名，或公司名称关键词'){this.value = '';}" value="<?php if($_GET['q']== null): ?>可输入经纪人名、门店名，或公司名称关键词<?php else: echo ($_GET['q']); endif; ?>" />
                </div>
                <ul id="sddm2">
                    <li><input name="xz" type="text"  class="x-xz3" id="xz"  onmouseover="mopen('m1')" onmouseout="mclosetime()" value="经纪人">
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
                <INPUT value=""  class=xg_navinp2 type=submit>
                </form>
        <?php elseif($menu == 'newHouse'): ?>
                <div class="xg_nvain">
                    <form name="topSearchForm" method="GET" action="<?php echo ($cfg["url"]); ?>newHouse/index.php">
                        <input name="q" type="text" id="ts"  class="xg_navinp1" onblur="if(this.value ==''||this.value == '可输入楼盘名、路名或划片学校'){this.value = '可输入楼盘名、路名或划片学校';}" onfocus="if(this.value == '可输入楼盘名、路名或划片学校'){this.value = '';}" value="<?php if($_GET['q']== null): ?>可输入楼盘名、路名或划片学校<?php else: echo ($_GET['q']); endif; ?>" />
                </div>
                <ul id="sddm2">
                    <li>
                        <input name="xz" type="text"  class="x-xz3" id="xz"  onmouseover="mopen('m1')" onmouseout="mclosetime()" value="新房">
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
                <INPUT value=""  class=xg_navinp2 type=submit>
                </form>
        <?php else: ?>
                <div class="xg_nvain">
                    <form name="topSearchForm" method="GET" action="<?php echo U(MODULE_NAME.'/Sell/index');?>">
                        <input name="q" type="text"  id="ts" class="xg_navinp1" onblur="if(this.value ==''||this.value == '可输入小区名、路名或房源特征'){this.value = '可输入小区名、路名或房源特征';}" onfocus="if(this.value == '可输入小区名、路名或房源特征'){this.value = '';}" value="<?php if($_GET['q']== null): ?>可输入小区名、路名或房源特征<?php else: echo ($_GET['q']); endif; ?>" />
                </div>
                <ul id="sddm2">
                    <li>
                        <input name="xz" type="text"  class="x-xz3" id="xz"  onmouseover="mopen('m1')" onmouseout="mclosetime()" value="二手房">
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
                <INPUT value=""  class=xg_navinp2 type=submit>
                </form><?php endif; ?>

    </div>
</div>
<!-- 新增部分结束 -->

<div>
    <div id="content">

    <!-- start -->
    <div class="fcksearch">
        <div class="findpropcond">
            <form action="#" id="propcondform" method="post" target="_blank">
                <div class="PropCond" >
                    当前找房条件：
                    <?php if($_GET['q']!= null): ?><span class="newpropcond">关键词：<?php echo ($_GET['q']); ?>&nbsp;<a class="newpropicon" href="javascript:void(0);" onclick="cancelProp('q')">&nbsp;</a></span><?php endif; ?>
                    <?php if($cityarea != null): ?><span class="newpropcond"><?php echo ($cityarea_option["$cityarea"]); ?>&nbsp;<a class="newpropicon" href="javascript:void(0);" onclick="cancelProp('cityarea')">&nbsp;</a></span><?php endif; ?>
                    <?php if($price != null): ?><span class="newpropcond"><?php echo ($house_price_option["$price"]); ?>&nbsp;<a class="newpropicon" href="javascript:void(0);" onclick="cancelProp('price')">&nbsp;</a></span><?php endif; ?>
                    <?php if($totalarea != null): ?><span class="newpropcond"><?php echo ($house_totalarea_option["$totalarea"]); ?>&nbsp;<a class="newpropicon" href="javascript:void(0);" onclick="cancelProp('totalarea')">&nbsp;</a></span><?php endif; ?>
                    <?php if($room != null): ?><span class="newpropcond"><?php echo ($room_option["$room"]); ?>&nbsp;<a class="newpropicon" href="javascript:void(0);" onclick="cancelProp('room')">&nbsp;</a></span><?php endif; ?>
                    <?php if($type != null): ?><span class="newpropcond"><?php echo ($house_type_option["$type"]); ?>&nbsp;<a class="newpropicon" href="javascript:void(0);" onclick="cancelProp('type')">&nbsp;</a></span><?php endif; ?>
                    <?php if($feature != null): ?><span class="newpropcond"><?php echo ($house_feature_option["$feature"]); ?>&nbsp;<a class="newpropicon" href="javascript:void(0);" onclick="cancelProp('feature')">&nbsp;</a></span><?php endif; ?>
                    <?php if($house_age != null): ?><span class="newpropcond"><?php echo ($house_age_option["$house_age"]); ?>&nbsp;<a class="newpropicon" href="javascript:void(0);" onclick="cancelProp('house_age')">&nbsp;</a></span><?php endif; ?>
                    <?php if($house_floor != null): ?><span class="newpropcond"><?php echo ($house_floor_option["$house_floor"]); ?>&nbsp;<a class="newpropicon" href="javascript:void(0);" onclick="cancelProp('house_floor')">&nbsp;</a></span><?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    <!-- end -->

    <div class="fcklinks" style=" ">
        <div class="filter" style="border:0;margin-top:0">
            <input type="hidden" id="domType" name="domType" value="<?php echo ($_GET['domType']); ?>">
            <input type="hidden" id="cityarea" name="cityarea" value="<?php echo ($_GET['cityarea']); ?>">
            <input type="hidden" id="price" name="price" value="<?php echo ($_GET['price']); ?>">
            <input type="hidden" id="borough" name="borough" value="<?php echo ($_GET['borough']); ?>">
            <input type="hidden" id="totalarea" name="totalarea" value="<?php echo ($_GET['totalarea']); ?>">
            <input type="hidden" id="type" name="type" value="<?php echo ($_GET['type']); ?>">
            <input type="hidden" id="room" name="room" value="<?php echo ($_GET['room']); ?>">
            <input type="hidden" id="feature" name="feature" value="<?php echo ($_GET['feature']); ?>">
            <input type="hidden" id="switch" name="switch" value="<?php echo ($_GET['switch']); ?>">
            <input type="hidden" id="list_num" name="list_num" value="10">
            <input type="hidden" id="list_order" name="list_order" value="">
            <input type="hidden" id="showstyle" name="showstyle" value="<?php echo ($_GET['showstyle']); ?>">
            <input type="hidden" id="pageno" name="pageno" value="<?php echo ($_GET['pageno']); ?>">
            <input type="hidden" id="S_q" name="S_q" value="<?php echo ($_GET['q']); ?>"><!-- |escape:'url' -->
            <input type="hidden" id="q2" name="q2" value="<?php echo ($_GET['q']); ?>">
            <input type="hidden" id="house_age" name="house_age" value="<?php echo ($_GET['house_age']); ?>">
            <input type="hidden" id="house_floor" name="house_floor" value="<?php echo ($_GET['house_floor']); ?>">
            <input type="hidden" id="company" name="company" value="<?php echo ($_GET['company']); ?>">

            <div>
                <ul>
                    <li class="filterTarget">区域：</li>
                    <li <?php if($_GET['cityarea']== null): ?>class="linkOn"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">不限</a></li>

                    <?php if(is_array($cityarea_option)): foreach($cityarea_option as $key=>$item): if($key == $_GET['cityarea']): ?><li class="linkOn" ><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($key); ?>&borough=&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>" ><?php echo ($item); ?></a></li>
                        <?php else: ?>
                            <li><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($key); ?>&borough=&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>" ><?php echo ($item); ?></a></li><?php endif; endforeach; endif; ?>

                </ul>
            </div>
            <?php if($_GET['cityarea']!= null): ?><div style="height:auto;">
                    <div style="height:auto;">
                        <ul id="filterTargetSub" style="_margin-left:38px">
                            <li <?php if($_GET['cityarea2']== null): ?>class="linkOn"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">不限</a></li>
                            <?php if(is_array($borough_section)): foreach($borough_section as $key=>$item): ?><li <?php if($item['di_value'] == $_GET['cityarea2']): ?>class="linkOn"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($item["di_value"]); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>"><?php echo ($item["di_caption"]); ?></a></li><?php endforeach; endif; ?>
                        </ul>
                    </div>
                </div><?php endif; ?>
            <ul>
                <li class="filterTarget">价格：</li>
                <li <?php if($_GET['price']== null): ?>class="linkOn"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">不限</a></li>
                <?php if(is_array($house_price_option)): foreach($house_price_option as $key=>$item): ?><li class="<?php if($key == $_GET['price']): ?>linkOn<?php endif; ?>"><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($key); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>"><?php echo ($item); ?></a></li><?php endforeach; endif; ?>
            </ul>

            <ul>
                <li class="filterTarget">房型：</li>
                <li <?php if($_GET['room']== null): ?>class="linkOn"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">不限</a></li>

                <?php if(is_array($room_option)): foreach($room_option as $key=>$item): ?><li class="<?php if($key == $_GET['room']): ?>linkOn<?php endif; ?>"><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($key); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>"><?php echo ($item); ?></a></li><?php endforeach; endif; ?>
            </ul>

            <ul>
                <li class="filterTarget">面积：</li>
                <li <?php if($_GET['totalarea']== null): ?>class="linkOn"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">不限</a></li>
                <?php if(is_array($house_totalarea_option)): foreach($house_totalarea_option as $key=>$item): ?><li class="<?php if($key == $_GET['totalarea']): ?>linkOn<?php endif; ?>"><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($key); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>"><?php echo ($item); ?></a></li><?php endforeach; endif; ?>
            </ul>

            <ul>
                <li class="filterTarget">类型：</li>
                <li <?php if($_GET['type']== null): ?>class="linkOn"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">不限</a></li>
                <?php if(is_array($house_type_option)): foreach($house_type_option as $key=>$item): ?><li class="<?php if($key == $_GET['type']): ?>linkOn<?php endif; ?>"><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($key); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>"><?php echo ($item); ?></a></li><?php endforeach; endif; ?>
            </ul>

            <ul>
                <li class="filterTarget">特色：</li>
                <li <?php if($_GET['feature']== null): ?>class="linkOn"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">不限</a></li>
                <?php if(is_array($house_feature_option)): foreach($house_feature_option as $key=>$item): ?><li class="<?php if($key == $_GET['feature']): ?>linkOn<?php endif; ?>"><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($key); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>"><?php echo ($item); ?></a></li><?php endforeach; endif; ?>
            </ul>

            <div style=" clear:both;"></div>

        </div>
        <div class="condition_fake_352"></div>
    </div>

    <div class="search-result2" style="z-index:99;">
        <div class="keywords352" id="keywords">
            <form action="<?php echo U(MODULE_NAME.'/Sell/index');?>" id="ls_form_apf_id_12" class="keywordform" method='get'>
                <input type="hidden" id="cityarea" name="cityarea" value="<?php echo ($_GET['cityarea']); ?>">
                <input type="hidden" id="price" name="price" value="<?php echo ($_GET['price']); ?>">
                <input type="hidden" id="borough" name="borough" value="<?php echo ($_GET['borough']); ?>">
                <input type="hidden" id="totalarea" name="totalarea" value="<?php echo ($_GET['totalarea']); ?>">
                <input type="hidden" id="type" name="type" value="<?php echo ($_GET['type']); ?>">
                <input type="hidden" id="room" name="room" value="<?php echo ($_GET['room']); ?>">
                <input type="hidden" id="feature" name="feature" value="<?php echo ($_GET['feature']); ?>">
                <input type="hidden" id="switch" name="switch" value="<?php echo ($_GET['switch']); ?>">
                <input type="hidden" id="list_num" name="list_num" value="10">
                <input type="hidden" id="list_order" name="list_order" value="">
                <input type="hidden" id="showstyle" name="showstyle" value="<?php echo ($_GET['showstyle']); ?>">
                <input type="hidden" id="pageno" name="pageno" value="<?php echo ($_GET['pageno']); ?>">
                <input type="hidden" id="house_age" name="house_age" value="<?php echo ($_GET['house_age']); ?>">
                <input type="hidden" id="house_floor" name="house_floor" value="<?php echo ($_GET['house_floor']); ?>">
                <input type="hidden" id="company" name="company" value="<?php echo ($_GET['company']); ?>">
                <input type="text" maxlength="100" name="q" id="q" class="kw" value="在结果中筛选" onblur="if(this.value ==''||this.value == '在结果中筛选'){this.value = '在结果中筛选';}"
                       onfocus="if(this.value == '在结果中筛选'){this.value = '';}"  />

                <input type="submit" class="search2" value="筛选" /><a class="clearkw clearkw2"  href="<?php echo U(MODULE_NAME.'/Sell/index');?>">清空</a>
            </form>
            <div class="asline"></div>
            <div id="condmenu">
                <ul class="condul">
                    <li class="condlist_tip"><span>更多筛选：</span></li>
                    <li id="condhouseage_id">
                        <a href="javascript:void(0);">
                            <span class="select_item">
                                <span class="txt" id="condhouseage_txt_id">
                                    <?php if($house_age != null): echo ($house_age_option["$house_age"]); ?> <?php else: ?>不限<?php endif; ?>
                                </span>
                                <span class="icon">&nbsp;</span>
                            </span><!--[if IE 7]><!--></a><!--<![endif]--><!--[if IE 8]><!--></a><!--<![endif]--><!--[if !IE]>--></a><!--<![endif]-->
                        <!--[if lte IE 6]>
                        <iframe src="" style="position:absolute;visibility:inherit; top:0px; left:-1px; width:102px; height:132px;z-index:-1;opacity:.0;filter:alpha(opacity=0); -moz-opacity:0;"></iframe>
                        <table>
                            <tr>
                                <td>
                        <![endif]-->
                        <ul>
                            <li><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">不限</a></li>
                            <li <?php if($house_age == '2008-0'): ?>class="selected"<?php endif; ?> ><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=2008-0&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">2008年后</a></li>
                            <li <?php if($house_age == '2000-2008'): ?>class="selected"<?php endif; ?> ><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=2000-2008&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">2000-2008年</a></li>
                            <li  <?php if($house_age == '1995-2000'): ?>class="selected"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=1995-2000&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">1995-2000年</a></li>
                            <li <?php if($house_age == '0-1995'): ?>class="selected"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=0-1995&house_floor=<?php echo ($_GET['house_floor']); ?>&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">1995年前</a></li>
                        </ul>
                        <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                    </li>

                    <li id="condfloor_id">
                        <a href="javascript:void(0);"><span class="select_item"><span class="txt" id="condfloor_txt_id"><?php if($house_floor != null): echo ($house_floor_option["$house_floor"]); ?> <?php else: ?>不限<?php endif; ?></span><span class="icon">&nbsp;</span></span><!--[if IE 7]><!--></a><!--<![endif]--><!--[if IE 8]><!--></a><!--<![endif]--><!--[if !IE]>--></a><!--<![endif]-->
                        <!--[if lte IE 6]>
                        <iframe src="" style="position:absolute;visibility:inherit; top:0px; left:-1px; width:99px; height:105px;z-index:-1;opacity:.0;filter:alpha(opacity=0); -moz-opacity:0;"></iframe>
                        <table><tr><td>
                        <![endif]-->
                        <ul>
                            <li><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">不限</a></li>
                            <li <?php if($house_floor == '0-6'): ?>class="selected"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=0-6&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">6层以下</a></li>
                            <li <?php if($house_floor == '6-12'): ?>class="selected"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=6-12&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">6-12层</a></li>
                            <li <?php if($house_floor == '12-0'): ?>class="selected"<?php endif; ?>><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?cityarea=<?php echo ($_GET['cityarea']); ?>&cityarea2=<?php echo ($_GET['cityarea2']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&house_age=<?php echo ($_GET['house_age']); ?>&house_floor=12-0&company=<?php echo ($_GET['company']); ?>&q=<?php echo ($_GET['q']); ?>&list_order=<?php echo ($_GET['list_order']); ?>">12层以上</a></li>
                        </ul>
                        <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                    </li>

                    <li id="condbrand_id" style="display:none">
                        <a href="javascript:void(0);">
                            <span class="select_item">
                                <span class="txt" id="condbrand_txt_id"></span>
                                <span class="icon">&nbsp;</span>
                            </span>
                            <!--[if IE 7]><!--></a><!--<![endif]--><!--[if IE 8]><!--></a><!--<![endif]--><!--[if !IE]>--></a><!--<![endif]-->
                        <!--[if lte IE 6]><table><tr><td><![endif]-->
                        <ul id="condbrand_item_id">
                            <li  ><a href="">不限</a></li>

                        </ul>
                        <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                    </li>
                </ul>
            </div>
            <div class="asline"></div>



            <div class="condmap">
                <?php if($menu == 'sale'): ?><a class="mapicon" target="_blank" hidefocus="true" href="<?php echo ($cfg["url"]); ?>m/map">&nbsp;</a><?php endif; ?>
                <?php if($menu == 'rent'): ?><a class="mapicon" target="_blank" hidefocus="true" href="<?php echo ($cfg["url"]); ?>m/maprent">&nbsp;</a><?php endif; ?>
            </div>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>
</div>
<div class="blank"></div>
<div class="content">
    <!--中部左侧开始-->
    <div class="sale_xx_left">
        <div id="c">
            <ul>
                <input type="hidden" id="switch" name="switch" value="<?php echo ($_GET['switch']); ?>">
                <li <?php if($_GET['switch']== null): ?>class="li2"<?php else: ?>class="li1"<?php endif; ?>><span><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?q=<?php echo ($_GET['q']); ?>&letter=<?php echo ($_GET['letter']); ?>&cityarea=<?php echo ($_GET['cityarea']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&list_order=<?php echo ($_GET['list_order']); ?>" >全部</a></span></li>
                <?php if($guest == 1): ?><li <?php if($_GET['switch']== 'owner'): ?>class="li2"<?php else: ?>class="li1"<?php endif; ?>><span><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?switch=owner">个人</a></span></li><?php endif; ?>
                <li <?php if($_GET['switch']== 'vexation'): ?>class="li2"<?php else: ?>class="li1"<?php endif; ?>><span><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?switch=vexation">急售</a></span></li>
                <li <?php if($_GET['switch']== 'morePic'): ?>class="li2"<?php else: ?>class="li1"<?php endif; ?>><span><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?switch=morePic">多图</a></span></li>

                <li <?php if($_GET['switch']== 'promote'): ?>class="li2"<?php else: ?>class="li1"<?php endif; ?>><span><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?switch=promote">店长</a></span></li>
                <li class="li1"><span><a target="_blank" href="<?php echo ($cfg["url"]); ?>sale/requireList.php">求购信息</a></span></li>
                <li class="li1"><span><a target="_blank" href="<?php echo ($cfg["url"]); ?>m/map">地图找房</a></span></li>
            </ul>
            <!-- 上一页 下一页 -->
            <div class="filter_right">
                <table>
                    <tr>

                        <td>
                            <?php if($pageno > 1): ?><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?q=<?php echo ($_GET['q']); ?>&letter=<?php echo ($_GET['letter']); ?>&cityarea=<?php echo ($_GET['cityarea']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&list_order=<?php echo ($_GET['list_order']); ?>&p=<?php echo ($pageno-1); ?>" onfocus=blur()>
                                <img src="/6doffice/Public/images/sale01a.jpg" border="0" class="RL-Prev"/>
                            </a>
                            <?php else: ?>
                            <a href="javascript:void(0);">
                                <img src="/6doffice/Public/images/sale01.jpg" border="0" class="RL-Prev"/>
                            </a><?php endif; ?>
                        </td>
                        <td id="RL_NoPage"><?php echo ($pageno); ?>/<?php echo ($page_count); ?></td>
                        <td>
                            <?php if(($pageno < $page_count) and ($pageno < 100)): ?><a href="<?php echo U(MODULE_NAME.'/Sell/index');?>?q=<?php echo ($_GET['q']); ?>&letter=<?php echo ($_GET['letter']); ?>&cityarea=<?php echo ($_GET['cityarea']); ?>&borough=<?php echo ($_GET['borough']); ?>&price=<?php echo ($_GET['price']); ?>&totalarea=<?php echo ($_GET['totalarea']); ?>&room=<?php echo ($_GET['room']); ?>&type=<?php echo ($_GET['type']); ?>&feature=<?php echo ($_GET['feature']); ?>&switch=<?php echo ($_GET['switch']); ?>&showstyle=<?php echo ($_GET['showstyle']); ?>&list_num=<?php echo ($_GET['list_num']); ?>&list_order=<?php echo ($_GET['list_order']); ?>&p=<?php echo ($pageno+1); ?>" onfocus=blur()>
                                <img src="/6doffice/Public/images/sale02a.jpg" border="0" class="RL-Next"/>
                            </a>
                            <?php else: ?>
                            <a href="javascript:void(0);">
                                <img src="/6doffice/Public/images/sale02.jpg" border="0" class="RL-Prev"/>
                            </a><?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div></div>

        <div class="all_fy_bg">
            <div class="all_fy_bgl">
                <?php if($_GET['list_order']== 'default'): ?><a onClick="quickSearch('default','list_order');return false;" href="javascript:" class="input_mrpxx" onfocus=blur()>默认排序</a>
                    <?php else: ?>
                    <a onClick="quickSearch('default','list_order');return false;" href="javascript:" class="input_mrpx" onfocus=blur()>默认排序</a><?php endif; ?>
                <?php if($_GET['list_order']== 'house_price asc'): ?><a onClick="quickSearch('house_price desc','list_order');return false;" href="javascript:" class="input_zj" onfocus=blur()>总价&darr;</a>
                    <?php else: ?>
                <a onClick="quickSearch('house_price asc','list_order');return false;" href="javascript:" class="input_pxbg56" onfocus=blur()>总价&uarr;</a><?php endif; ?>
                <?php if($_GET['list_order']== 'house_totalarea asc'): ?><a onClick="quickSearch('house_totalarea desc','list_order');return false;" href="javascript:" class="input_zj" onfocus=blur()>面积&darr;</a>
                    <?php else: ?>
                    <a onClick="quickSearch('house_totalarea asc','list_order');return false;" href="javascript:" class="input_pxbg56" onfocus=blur()>面积&uarr;</a><?php endif; ?>
                <?php if($_GET['list_order']== 'avg_price asc'): ?><a onClick="quickSearch('avg_price desc','list_order');return false;" href="javascript:" class="input_zj" onfocus=blur()>单价&darr;</a>
                    <?php else: ?>
                    <a onClick="quickSearch('avg_price asc','list_order');return false;" href="javascript:" class="input_pxbg56" onfocus=blur()>单价&uarr;</a><?php endif; ?>


                <?php if($_GET['list_order']== 'created asc'): ?><a onClick="quickSearch('created desc','list_order');return false;" href="javascript:"  class="input_zj" onfocus=blur()>时间&uarr;</a>
                    <?php else: ?>
                    <a onClick="quickSearch('created asc','list_order');return false;" href="javascript:"  class="input_pxbg56" onfocus=blur()>时间&darr;</a><?php endif; ?>



            </div>
            <div class="all_fy_bgr">
                <?php if(($_GET['showstyle']== null) or ($_GET['showstyle']== 'listshow')): ?><a  onClick="quickSearch('listshow','showstyle');return false;" href="javascript:"  class="input_lb_selected">
                        <?php else: ?>
                    <a  onClick="quickSearch('listshow','showstyle');return false;" href="javascript:"  class="input_lb"><?php endif; ?>

                <?php if($_GET['showstyle']== 'drawingshow'): ?><a  onClick="quickSearch('drawingshow','showstyle');return false;" href="javascript:" class="input_fxt_selected"></a>
                    <?php else: ?>
                    <a  onClick="quickSearch('drawingshow','showstyle');return false;" href="javascript:" class="input_fxt"></a><?php endif; ?>
                <?php if($_GET['showstyle']== 'roompicshow'): ?><a  onClick="quickSearch('roompicshow','showstyle');return false;" href="javascript:" class="input_snt_selected"></a>
                    <?php else: ?>
                    <a  onClick="quickSearch('roompicshow','showstyle');return false;" href="javascript:" class="input_snt"></a><?php endif; ?>

            </div>
        </div>

        <div class="content_b1">
            <?php if(($_GET['showstyle']== null) or ($_GET['showstyle']== 'listshow')): ?><div class="listing">
                <!--  列表循环体开始  -->
                <?php if(is_array($dataList)): foreach($dataList as $key=>$item): ?><ol id="list_body" >
                            <div class="h15"></div>
                            <div class="property2">
                                <div class="photo">
                                    <?php if($item['house_thumb'] != null): ?><a href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["borough_name"]); echo ($item["house_room"]); ?>居" target="_blank"><img src="/6doffice/Uploads/<?php echo ($item["house_thumb"]); ?>" width="100" height="80" /></a>

                                        <?php else: ?>
                                        <a href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["borough_name"]); echo ($item["house_room"]); ?>居" target="_blank"><img src="/6doffice/Public/images/housePhotoDefault.gif" width="100" height="80" /></a><?php endif; ?>
                                </div>
                                <div class="details" style="margin-left:10px;">
                                    <h4>
                                        <a class="color000" href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["borough_name"]); ?>" target="_blank"><?php echo ($item["house_title"]); ?></a><!--{include file="inc/four_tag.tpl"}-->
                                    </h4>
                                    <address>小区：<?php echo ($item["borough_name"]); ?></address>
                                    <div class="all_fyyy"><p>单价：<?php echo ($item["avg_price"]); ?>元/平米</p><p>面积：<?php echo ($item["house_totalarea"]); ?>平米</p><p>楼层：<?php echo ($item["house_floor"]); ?>/<?php echo ($item["house_topfloor"]); ?></p><br /><p>户型：<?php echo ($item["house_room"]); ?>室<?php echo ($item["house_hall"]); ?>厅</p>
                                    </div>
                                    <div class="broker_name"><p><font color="#999999"><?php if($item['broker_info']['realname'] != null): ?>经纪人：<a target="_blank" href="<?php echo ($cfg["url"]); ?>shop/<?php echo ($item["broker_id"]); ?>"><?php echo ($item["broker_info"]["realname"]); ?></a><?php else: ?>房东：<?php echo ($item["owner_name"]); endif; ?>  <?php echo (date("m月d日",$item["updated"])); ?>发布</font></p></div>
                                </div>
                                <div class="price"><span><?php if($item['house_price'] == 0): ?>面议<?php else: echo ($item["house_price"]); endif; ?></span>万元</div>
                                <div class="tags"><?php if($item['is_vexation'] == 1): ?><img src="/6doffice/Public/images/sale_js.gif" title="急售" alt="急售" /><?php endif; ?>&nbsp;<?php if($item['is_top'] == 1): ?><img src="/6doffice/Public/images/newpush.gif" title="新推" alt="新推" /><?php endif; if($item['broker_id'] == 0): ?><img src="/6doffice/Public/images/owner.gif" title="无中介费" alt="无中介费" /><?php endif; ?>&nbsp;</div>
                            </div>
                            <div class="h23"></div>
                            <div class="hr"></div>

                        </ol><?php endforeach; endif; ?>
                <!--  列表循环体结束  -->
            </div><?php endif; ?>
            <?php if($_GET['showstyle']== 'roompicshow'): ?><!--  列表循环体开始  -->
                <?php if(is_array($dataList)): foreach($dataList as $key=>$item): ?><ol id="list_body" class="big_img">
                    <li class="big_img" <?php if($item['is_rowlast'] != 1): ?>style="margin-right:21px; *margin-right:10px;_margin-right:12px; "<?php endif; ?>>
                    <div class="property_snt big_link_all" style="border-bottom:none;">
                        <div class="er_snt_aa" style=" padding:0;">
                            <table width="220" border="0" align="center" cellpadding="0" cellspacing="0"ststyle="margin-left:0px; margin-top:2px;" >
                                <tr>
                                    <td height="165" align="center" valign="top">
                                        <?php if($item['house_thumb'] != null): ?><a href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["borough_name"]); ?>" target="_blank"><img src="/6doffice/Uploads/<?php echo ($item["house_thumb"]); ?>" width="216" height="165" border="0" /></a>

                                            <?php else: ?>
                                            <a href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["borough_name"]); ?>" target="_blank"><img src="/6doffice/Public/images/housePhotoDefault.gif" width="216" height="165" border="0" /></a><?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="24" align="left" valign="bottom" class="font_00359d" style="padding:0 5px;"><a href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["borough_name"]); ?>" target="_blank"><?php echo ($item["borough_name"]); ?></a></td>
                                </tr>
                                <tr>
                                    <td height="27" align="left" valign="middle" style="border-bottom:1px #71a6db solid; color:#7e7e7e; padding:0 5px;"><?php echo ($item["house_room"]); ?>室<?php echo ($item["house_hall"]); ?>厅 | <?php echo ($item["house_totalarea"]); ?>平米 |</td>
                                </tr>
                                <tr>
                                    <td align="left" bgcolor="#f6f6f6"><table width="210" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td height="33" align="left" valign="middle" bgcolor="#f6f6f6" class="price_zz">售价：<span><?php echo ($item["house_price"]); ?></span><span class="aabb">万元</span></td>
                                            <td align="right" valign="middle" bgcolor="#f6f6f6"><!--{include file="inc/four_tag.tpl"}--></td>
                                        </tr>
                                    </table></td>
                                </tr>
                                <tr>
                                    <td height="45" align="left" bgcolor="#f6f6f6" class="font_2f5aaf" style="line-height:21px; padding:0 5px;"><?php echo ($item["house_title"]); ?><br /></td>
                                </tr>
                                <tr>
                                    <td height="5" align="left" bgcolor="#f6f6f6"></td>
                                </tr>
                            </table>
                            <span class="xj_c xj_c01"></span> <span class="xj_c xj_c06"></span> <span class="xj_c xj_c03"></span> </div>
                        <div class="bottom_shadow"></div>
                    </div>
                    </li>
                </ol><?php endforeach; endif; endif; ?>



            <?php if($_GET['showstyle']== 'drawingshow'): ?><!--  列表循环体开始  -->
            <?php if(is_array($dataList)): foreach($dataList as $key=>$item): ?><ol id="list_body" class="big_img">
                <li class="big_img"  <?php if($item['is_rowlast'] != 1): ?>style="margin-right:21px;*margin-right:10px; _margin-right:12px;"<?php endif; ?>>
                <div class="property_snt big_link_all" style="border-bottom:none;">
                    <div class="er_snt_aa" style=" padding:0;">
                        <table width="220" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:0px; margin-top:2px;">
                            <tr>
                                <?php if($item['house_drawing'] != null): ?><td height="165" align="center" valign="top"><a href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["borough_name"]); ?>" target="_blank"><img src="/6doffice/Uploads/<?php echo ($item["house_drawing"]); ?>" width="216" height="165" border="0" /></a></td>

                                    <?php else: ?>
                                    <td height="165" align="center" valign="top"><a href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["borough_name"]); ?>" target="_blank"><img src="/6doffice/Public/images/housePhotoDefault.gif" width="216" height="165" border="0" /></a></td><?php endif; ?>
                            </tr>
                            <tr>
                                <td height="24" align="left" valign="bottom" class="font_00359d" style="padding:0 5px;"><a href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["borough_name"]); ?>" target="_blank"><?php echo ($item["borough_name"]); ?></a></td>
                            </tr>
                            <tr>
                                <td height="27" align="left" valign="middle" style="border-bottom:1px #71a6db solid; color:#7e7e7e; padding:0 5px;"><?php echo ($item["house_room"]); ?>室<?php echo ($item["house_hall"]); ?>厅 | <?php echo ($item["house_totalarea"]); ?>平米 |</td>
                            </tr>
                            <tr>
                                <td align="left" bgcolor="#f6f6f6"><table width="210" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="33" align="left" valign="middle" bgcolor="#f6f6f6" class="price_zz">售价：<span><?php echo ($item["house_price"]); ?></span><span class="aabb">万元</span></td>
                                        <td align="right" valign="middle" bgcolor="#f6f6f6"><!--{include file="inc/four_tag.tpl"}--></td>
                                    </tr>
                                </table></td>
                            </tr>
                            <tr>
                                <td height="45" align="left" bgcolor="#f6f6f6" class="font_2f5aaf" style="line-height:21px; padding:0 5px;"><?php echo ($item["house_title"]); ?></td>
                            </tr>
                            <tr>
                                <td height="5" align="left" bgcolor="#f6f6f6"></td>
                            </tr>
                        </table>
                        <span class="xj_c xj_c01"></span> <span class="xj_c xj_c06"></span> <span class="xj_c xj_c03"></span> </div>
                    <div class="bottom_shadow"></div>
                </div>
                </li>
            </ol><?php endforeach; endif; endif; ?>
            <!--{include file="inc/page_fenye.tpl"}-->
            <div class="multipage-div">
                <div class="contain">
                    <!-- 二手房列表分页 -->
                    <?php echo ($pagePanel); ?>
                    <!-- 二手房列表分页 结束 -->
                </div>
                <div class="result">共有  <span style="color:#61a00d; font-weight:bold;"><?php echo ($row_count); ?></span> 套符合要求的房子</div>
            </div>
        </div>



    </div>
    <div class="sale_xx_right">
        <div class="hz_list_pub">
            <div class="gpf_content">
                <h2 class="title_top">您有房屋出售吗？</h2>
                <p class="text">您通过此处发布购房者无需缴纳<span>中介费</span></p>
                <div class="pub_btn_box">
                    <a target="_blank" class="pub_but" hidefocus="true" title="个人房东发布" href="<?php echo ($cfg["url"]); ?>guest/houseSale.php"></a>
                </div>
            </div>
        </div>
        <div class="region">
            <h3>浏览过的房源</h3>
            <?php if($browseList != null): if(is_array($browseList)): foreach($browseList as $key=>$item): ?><div class="region_main">
                <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

                    <tr>
                        <td width="58%" rowspan="3" align="left">
                            <a href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["borough_name"]); ?>" target="_blank">
                            <?php if($item['house_thumb'] != null): ?><img style="padding:1px; border:1px #d7d7d7 solid;" src="/6doffice/Uploads/<?php echo ($item["house_thumb"]); ?>" width="75px" height="50px" alt="<?php echo ($item["borough_name"]); ?>" title="<?php echo ($item["borough_name"]); ?>" />

                                <?php else: ?>
                                <img style="padding:1px; border:1px #d7d7d7 solid;" src="/6doffice/Public/images/housePhotoDefault.gif" width="75px" height="50px" alt="<?php echo ($item["borough_name"]); ?>" title="<?php echo ($item["borough_name"]); ?>" /><?php endif; ?>

                        </a></td>

                        <td width="42%" align="left" class="font_2f5aaf"><strong><a href="<?php echo U(MODULE_NAME.'/Sell/detail');?>/id/<?php echo ($item["id"]); ?>" title="<?php echo ($item["borough_name"]); ?>" target="_blank"><?php echo ($item["borough_name"]); ?></a></strong></td>

                    </tr>
                    <tr>
                        <td align="left"><?php echo ($item["house_room"]); ?>室<?php echo ($item["house_hall"]); ?>厅</td>
                    </tr>
                    <tr>
                        <td align="left" class="Community_z"><?php echo ($item["house_price"]); ?>万</td>
                    </tr>

                </table>
            </div><?php endforeach; endif; ?>
            <?php else: ?>
            <img src="/6doffice/Public/images/browse.gif"><?php endif; ?>


        </div>

        <div class="blank"></div>
<script src="http://<?php echo ($host); echo U(MODULE_NAME.'/Index/ad','','');?>/id/8" type="text/javascript"></script>

<div class="blank"></div>
<script src="http://<?php echo ($host); echo U(MODULE_NAME.'/Index/ad','','');?>/id/9" type="text/javascript"></script>

    </div>
</div>
<!--中部右侧结束-->
<!-- 大框架结尾 -->
</div>


<!-- 底部链接 -->
<div class="foot">
    <a href="<?php echo ($cfg["url"]); ?>about/about.php" target="_blank">关于我们</a> | <a href="<?php echo ($cfg["url"]); ?>about/talented.php" target="_blank">人才招聘</a> | <a href="<?php echo ($cfg["url"]); ?>about/agreement.php" target="_blank">用户协议</a> | <a href="<?php echo ($cfg["url"]); ?>about/copyright.php" target="_blank">版权声明</a> | <a href="<?php echo ($cfg["url"]); ?>about/contact.php" target="_blank">联系我们</a>
    <br>客服热线：<?php echo ($rexian); ?>&nbsp;&nbsp;&nbsp;&nbsp;客服QQ：<?php echo ($qq); ?>
    <br>Powered by <a href="http://6doffice.com/">6doffice V2</a>  <a href="http://www.miibeian.gov.cn" target="_blank"><?php echo ($beian); ?></a>

    <br>
    <?php echo ($tongji); ?>
</div>
<!-- 底部链接 结束 -->

</body>
</html>