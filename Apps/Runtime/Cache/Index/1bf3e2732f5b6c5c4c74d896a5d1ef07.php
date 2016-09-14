<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta charset="UTF-8">
    <title>六度写字楼网首页</title>
    <script type="text/javascript" src="/6doffice/Apps/Index/View/Public/js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/6doffice/Apps/Index/View/Public/css/bootstrap.min.css" />
    <script type="text/javascript" src="/6doffice/Apps/Index/View/Public/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="/6doffice/Apps/Index/View/Public/css/list.css" />
<link rel="stylesheet" type="text/css" href="/6doffice/Apps/Index/View/Public/css/show.css" />
<script type="text/javascript" src="/6doffice/Apps/Index/View/Public/js/baidumap_show.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=wFcr45UfFkvNP9kb3zyLn7xCv0pyEzxC"></script>

</head>
<body data-spy="scroll" data-target="#navbar-example" data-offset=0>
<!-- 导航条开始 -->

<nav class="navbar navbar-inverse daohang">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">六度写字楼网</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">城市 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">南京</a></li>
                        <li><a href="#">北京</a></li>
                        <li><a href="#">上海</a></li>

                    </ul>
                </li>

                <li class="active"><a href="#">首页</a></li>
                <li><a href="#">出租</a></li>
                <li><a href="#">出售</a></li>
                <li><a href="#">新盘</a></li>
                <li><a href="#">咨询</a></li>
                <li><a href="#">工具</a></li>
                <li><a href="#">楼盘</a></li>
                <li><a href="#">经纪人</a></li>
                <li><a href="#">论坛</a></li>
                <li><a href="#">SE</a></li>


            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>&nbsp;看房</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;订单</a></li>
                <li><a href="#">登录</a></li>
                <li><a href="#">注册</a></li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<!-- 导航条结束 -->

<!--nestable css-->
<link rel="stylesheet" type="text/css" href="/6doffice/Apps/Index/View/Public/js/nestable/jquery.nestable.css" />

<!-- 搜索框 -->

<div class="container-fluid" >
    <div class="row">

        <div class="well col-sm-12 well_search_1">
            <div class="row">


                <div class="col-sm-4 col-sm-offset-1" style="padding-left: 90px">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm" placeholder="输入写字楼名称">
                <span class="input-group-btn">
                    <button class="btn btn-danger btn-sm" type="button">搜索</button>
                </span>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div>

    </div>




</div>

<!-- 栏目导航分享到 -->

<div class="container" >

    <div class="row">

        <div class="col-sm-6 hidden-xs" style="padding-left: 15px;">
            <ul class="list-inline">
                <li><a href="#">首页&nbsp;&nbsp;></a></li>
                <li><a href="#">南京写字楼&nbsp;&nbsp;></a></li>
                <li><a href="#">秦淮&nbsp;&nbsp;></a></li>
                <li><a href="#">新街口&nbsp;&nbsp;></a></li>

                <li class="active">南京中心&nbsp;&nbsp;</li>
            </ul>
        </div>
        <!-- bashare插件 -->

        <div class="col-sm-4 col-sm-offset-2 hidden-xs" style="padding-left: 15px;">

            <div class="bshare-custom"><div class="bsPromo bsPromo2"></div><a title="分享到微信" class="bshare-weixin" href="javascript:void(0);"></a><a title="分享到新浪微博" class="bshare-sinaminiblog" href="javascript:void(0);"></a><a title="分享到QQ好友" class="bshare-qqim" href="javascript:void(0);"></a><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="分享到一键通" class="bshare-bsharesync" href="javascript:void(0);"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a><span style="float: none;" class="BSHARE_COUNT bshare-share-count">47.7K</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=1&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
        </div>
    </div>
    <hr>



</div><!-- containner结束 -->


<!-- 主体轮播 右侧栏 -->

<div class="container">
    <div class="row">
        <!-- 主体 -->
        <div class="col-sm-9">
            <div id="fangyuanxinxi"></div>
            <p class="rent_title">【河西中心 金奥旁】5A级写字楼 紧邻费尔蒙酒店 可虚拟注册</p>
            <p class="rent_title_price_area"><span>6.6</span>元/m²•天 <span class="sm_price">12</span>m²</p>
            <!-- 轮播 -->
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="/6doffice/Apps/Index/View/Public/images/1.jpg" alt="..." class="center-block">
                        <div class="carousel-caption">
                            ...
                        </div>
                    </div>
                    <div class="item">
                        <img src="/6doffice/Apps/Index/View/Public/images/2.jpg" alt="..." class="center-block">
                        <div class="carousel-caption">
                            ...
                        </div>
                    </div>
                    <div class="item">
                        <img src="/6doffice/Apps/Index/View/Public/images/3.jpg" alt="..." class="center-block">
                        <div class="carousel-caption">
                            ...
                        </div>
                    </div>
                    <div class="item">
                        <img src="/6doffice/Apps/Index/View/Public/images/4.jpg" alt="..." class="center-block">
                        <div class="carousel-caption">
                            ...
                        </div>
                    </div>
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <table class="table table-striped table-hover xinxi_tab">

                <tr>
                    <td>日租金</td>
                    <td>6.6元/m²•天</td>
                    <td colspan="2"></td>

                    <td>建筑面积</td>
                    <td>12m²</td>
                </tr>
                <tr>
                    <td>月租金</td>
                    <td>2400元/月</td>
                    <td colspan="2"></td>

                    <td>楼层</td>
                    <td>高区</td>
                </tr>
                <tr>
                    <td>楼盘名</td>
                    <td>新地中心</td>
                    <td colspan="2"></td>

                    <td>物业费</td>
                    <td>暂无数据</td>
                </tr>
                <tr>
                    <td>地址</td>
                    <td>建邺 奥体 庐山路188号</td>
                    <td colspan="2"></td>

                    <td>预估月支出</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>地铁</td>
                    <td> 2号线、1号线</td>
                    <td colspan="2"></td>

                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>


            </table>
            <!-- 正文 -->
            <!-- 滚动监听 -->
            <div id="navbar-example" class="dis_nav">
                <!-- 依赖的导航组件 -->
                <nav class="navbar navbar-inverse top_nav_xinxi">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#">Brand</a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav" style="font-size: 16px">

                                <li><a href="#fangyuanxinxi">基本信息</a></li>
                                <li><a href="#fangyuanmiaoshu">房源描述</a></li>
                                <li><a href="#loupanxinxi">楼盘信息</a></li>
                                <li><a href="#jiaotongpeitao">交通配套</a></li>
                                <li><a href="#tongloupanfangyuan">同楼盘房源</a></li>

                            </ul>

                            <ul class="nav navbar-nav navbar-right">
                                <li class="jt_nav_namef"><span class="glyphicon glyphicon-user"></span><span style="font-size: 20px"> 范松伟</span> 六度房产 六度房地产咨询公司新地中心店</li>
                                <li class="jt_nav_phonef"><span class="glyphicon glyphicon-earphone"></span> 151 9599 2303</li>


                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
            </div>

            <!-- 房源描述 -->
            <div class="well well-sm fangyuanmiaoshu" id="fangyuanmiaoshu"><span class="glyphicon glyphicon-unchecked"></span> 房源描述 <span class="fb_bh">发布时间 2016-08-18 房源编号 26399178 </span></div>
            <div class="desc-con">
                <p style="word-wrap:break-word;font-size:13.3333px;"><strong><span style="font-size:24px;"><span style="font-size:24px;">南京新地中心，南京河西标志性建筑</span></span><span style="font-size:24px;">，位于河西商圈核心，商圈内云集多家知名大型商业、知名金融圈机构、公司总部、世界500强企业。</span></strong></p>
                <span style="font-size:24px;"> </span><span style="font-size:24px;"> </span><p style="word-wrap:break-word;font-size:13.3333px;"><strong><span style="font-size:24px;">交通便利，和南京地铁二号线、十号线无缝对接，是国际新5A标准的甲级写字楼。已有金融、科技、贸易等行业公司入驻。</span></strong></p>
                <span style="font-size:24px;"> </span><span style="font-size:24px;"> </span><p style="word-wrap:break-word;font-size:13.3333px;"></p>
                <span style="font-size:24px;"> </span><span style="font-size:24px;"> </span><p style="word-wrap:break-word;font-size:13.3333px;"><strong><span style="font-size:24px;">南京新地中心36层新地中心，顶级36层甲级5A商务办公地点。五星水准的全装全配办公室及办公家具，整个中心配有60间办公室，一个大型会议室，一个中型视频会议室，两个VIP接待室及宽敞的会客区域和茶水间。签约即可直接办公。</span></strong></p>
                <span style="font-size:24px;"> </span><span style="font-size:24px;"> </span><p style="word-wrap:break-word;font-size:13.3333px;"></p>
                <span style="font-size:24px;"> </span><span style="font-size:24px;"> </span><p style="word-wrap:break-word;font-size:13.3333px;"><strong><span style="font-size:24px;">在新地中心-Landing商务中心，客户可免费享用：</span></strong></p>
                <p style="word-wrap:break-word;font-size:13.3333px;"><b style="font-size:24px;line-height:36px;"><span style="color:#e53333;"><br>
</span></b></p>
                <p style="word-wrap:break-word;font-size:13.3333px;"><b style="font-size:24px;line-height:36px;"><span style="color:#e53333;">【装修】</span></b><span style="font-size:24px;"><b>五<span style="background-color:#ffffff;">星级，全装全配办公室及</span></b><span style="color:#e53333;"><b><span style="color:#000000;background-color:#ffffff;">办公家具、复印机、传真机、打印机、宽带、电话</span></b></span><b><span style="color:#000000;background-color:#ffffff;">等设施。</span></b></span></p>
                <p style="word-wrap:break-word;font-size:13.3333px;"><span style="font-size:24px;"><b><span style="color:#000000;background-color:#ffffff;"><br>
</span></b></span></p>
                <p style="word-wrap:break-word;font-size:13.3333px;"><strong><span style="font-size:24px;"><span style="color:#e53333;">【租金】</span>同时<span style="background-color:#ffffff;">包括物业管理费、水电费、保洁费、空调费、前台接待服务、电话接听服务、代收包裹、信件、传真</span><span style="background-color:#ffffff;">等服务</span>。</span></strong></p>
                <p style="word-wrap:break-word;font-size:13.3333px;"><strong><span style="font-size:24px;"><br>
</span></strong></p>
                <p style="word-wrap:break-word;font-size:13.3333px;"><strong><span style="font-size:24px;"><span style="color:#e53333;">【租期】</span>灵活办公空间，灵活<span style="background-color:#ffffff;">租期。</span><span style="background-color:#ffffff;">一天至一年均可租赁</span><span style="background-color:#ffffff;">，按</span>需收费，节省不必要的开支。</span></strong></p>
                <p style="word-wrap:break-word;font-size:13.3333px;"><strong><span style="font-size:24px;"><br>
</span></strong></p>
                <p style="word-wrap:break-word;font-size:13.3333px;"><strong><span style="font-size:24px;"><span style="color:#e53333;">【注册】</span>每间办公室均可免费办理独立<span style="background-color:#ffffff;">注册公司</span><span style="background-color:#ffffff;">。</span></span></strong></p>
                <p style="word-wrap:break-word;font-size:13.3333px;"><strong><span style="font-size:24px;"><span style="background-color:#ffffff;"><br>
</span></span></strong></p>
                <p style="word-wrap:break-word;font-size:13.3333px;"><strong><span style="font-size:24px;"><span style="color:#e53333;">【星级酒店式服务】</span><span style="background-color:#ffffff;">免费共享会客区、免费前台行政秘书服务</span><span style="background-color:#ffffff;">，</span>一年节省您数万元费用。</span></strong></p>
                <p style="word-wrap:break-word;font-size:13.3333px;"><strong><span style="font-size:24px;"><br>
</span></strong></p>
                <p style="word-wrap:break-word;font-size:13.3333px;"><strong><span style="font-size:24px;color:#000000;background-color:#dfc5a4;">即租即用，省掉您前期装修、配置办公设施的昂贵费用和宝贵时间。</span></strong></p>
                <p style="word-wrap:break-word;font-size:13.3333px;"><strong><span style="font-size:24px;color:#000000;background-color:#dfc5a4;"><br>
</span></strong></p>
                <p style="word-wrap:break-word;font-size:13.3333px;"></p>
                <p style="word-wrap:break-word;font-size:13.3333px;"><strong><span style="color:#e53333;font-size:24px;">我们是开发商，不收取任何中介费用！</span></strong></p>					</div>
            <!-- 楼盘信息 -->
            <div class="well well-sm loupanxinxi" id="loupanxinxi"><span class="glyphicon glyphicon-unchecked"></span> 楼盘信息 <span class="geng_duo"><a href="">更多信息</a> </span></div>
            <div class="lou_xin">
                <table class="table table-striped table-hover xinxi_tab">

                <tr>
                    <td>日租金</td>
                    <td>6.6元/m²•天</td>
                    <td colspan="2"></td>

                    <td>建筑面积</td>
                    <td>12m²</td>
                </tr>
                <tr>
                    <td>月租金</td>
                    <td>2400元/月</td>
                    <td colspan="2"></td>

                    <td>楼层</td>
                    <td>高区</td>
                </tr>
                <tr>
                    <td>楼盘名</td>
                    <td>新地中心</td>
                    <td colspan="2"></td>

                    <td>物业费</td>
                    <td>暂无数据</td>
                </tr>
                <tr>
                    <td>地址</td>
                    <td>建邺 奥体 庐山路188号</td>
                    <td colspan="2"></td>

                    <td>预估月支出</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>地铁</td>
                    <td> 2号线、1号线</td>
                    <td colspan="2"></td>

                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>


            </table>
            </div>
            <!-- 交通地图 -->
            <div class="well well-sm jiaotongpeitao" id="jiaotongpeitao"><span class="glyphicon glyphicon-unchecked"></span> 交通配套 </div>

            <div id="panorama"></div>
            <!-- 其他房源 -->
            <div class="well well-sm jiaotongpeitao" id="tongloupanfangyuan"><span class="glyphicon glyphicon-unchecked"></span> 同楼盘信息 </div>
            <div role="tabpanel" class="tab-pane active" id="all_fang" style="font-size: 12px">
                <!-- 媒体对象列表 -->


                <div class="mengti_l_b">
                    <ul class="media-list">
                        <li class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang1.jpg" alt="...">
                                </a>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading"><a href="">龙台国际大厦 双地铁口 精装修 挑高型 户型采光极佳</a></h5>
                                <div class="media">
                                    <div class="houseList">
                                        <div class="list">


                                            <div class="info">

                                                <div class="media-body" style="">
                                                    <p class="mt15">
                                                        <a title="黄埔大厦" href="" target="_blank"><span class="spName">黄埔大厦</span></a>
                                                        <span title="瑞金路黄埔路2号" class="ml10 spAddr">瑞金路黄埔路2号</span>
                                                    </p>
                                                    <p class="mt10">等级：甲级<span class="line">/</span>所在楼层：中区(共30层)</p>
                                                    <p class="mt10"><a class="marr7" target="_blank" title="访问[卢伟]的个人网上店铺，查看更多房源" href="">卢伟</a><span class="ml10">32秒前更新</span></p>
                                                    <div class="mt12">
                                                        <div class="pt4 floatl"><span class="colorGreen note">可注册</span><span class="colorRed note">交通便利</span><span class="colorBlue note">名企入驻</span></div>
                                                        <div class="floatl note-img"></div>
                                                    </div>


                                                </div>
                                                <div class="" style="display: table-cell;vertical-align: middle;padding-left: 10px;width: 5500px">

                                                    <div class="list" style="display: table-cell;width: 200px;">210㎡<p class="tag">建筑面积</p></div>
                                                    <div class="" style="display: table-cell;width: 200px">
                                                        <p class="">
                                                            <span class="price">2.3</span>
                                                            <span class="">元/平米 · 天</span>
                                                        </p>
                                                        <p class="danjia">
                                                            14490元<span class="Arial">/</span>月
                                                        </p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div><!-- mediobody -->
                        </li>
                    </ul>
                </div>
                <div class="mengti_l_b">
                    <ul class="media-list">
                        <li class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang1.jpg" alt="...">
                                </a>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading"><a href="">龙台国际大厦 双地铁口 精装修 挑高型 户型采光极佳</a></h5>
                                <div class="media">
                                    <div class="houseList">
                                        <div class="list">


                                            <div class="info">

                                                <div class="media-body" style="">
                                                    <p class="mt15">
                                                        <a title="黄埔大厦" href="" target="_blank"><span class="spName">黄埔大厦</span></a>
                                                        <span title="瑞金路黄埔路2号" class="ml10 spAddr">瑞金路黄埔路2号</span>
                                                    </p>
                                                    <p class="mt10">等级：甲级<span class="line">/</span>所在楼层：中区(共30层)</p>
                                                    <p class="mt10"><a class="marr7" target="_blank" title="访问[卢伟]的个人网上店铺，查看更多房源" href="">卢伟</a><span class="ml10">32秒前更新</span></p>
                                                    <div class="mt12">
                                                        <div class="pt4 floatl"><span class="colorGreen note">可注册</span><span class="colorRed note">交通便利</span><span class="colorBlue note">名企入驻</span></div>
                                                        <div class="floatl note-img"></div>
                                                    </div>


                                                </div>
                                                <div class="" style="display: table-cell;vertical-align: middle;padding-left: 10px;width: 5500px">

                                                    <div class="list" style="display: table-cell;width: 200px;">210㎡<p class="tag">建筑面积</p></div>
                                                    <div class="" style="display: table-cell;width: 200px">
                                                        <p class="">
                                                            <span class="price">2.3</span>
                                                            <span class="">元/平米 · 天</span>
                                                        </p>
                                                        <p class="danjia">
                                                            14490元<span class="Arial">/</span>月
                                                        </p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div><!-- mediobody -->
                        </li>
                    </ul>
                </div>
                <div class="mengti_l_b">
                    <ul class="media-list">
                        <li class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang1.jpg" alt="...">
                                </a>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading"><a href="">龙台国际大厦 双地铁口 精装修 挑高型 户型采光极佳</a></h5>
                                <div class="media">
                                    <div class="houseList">
                                        <div class="list">


                                            <div class="info">

                                                <div class="media-body" style="">
                                                    <p class="mt15">
                                                        <a title="黄埔大厦" href="" target="_blank"><span class="spName">黄埔大厦</span></a>
                                                        <span title="瑞金路黄埔路2号" class="ml10 spAddr">瑞金路黄埔路2号</span>
                                                    </p>
                                                    <p class="mt10">等级：甲级<span class="line">/</span>所在楼层：中区(共30层)</p>
                                                    <p class="mt10"><a class="marr7" target="_blank" title="访问[卢伟]的个人网上店铺，查看更多房源" href="">卢伟</a><span class="ml10">32秒前更新</span></p>
                                                    <div class="mt12">
                                                        <div class="pt4 floatl"><span class="colorGreen note">可注册</span><span class="colorRed note">交通便利</span><span class="colorBlue note">名企入驻</span></div>
                                                        <div class="floatl note-img"></div>
                                                    </div>


                                                </div>
                                                <div class="" style="display: table-cell;vertical-align: middle;padding-left: 10px;width: 5500px">

                                                    <div class="list" style="display: table-cell;width: 200px;">210㎡<p class="tag">建筑面积</p></div>
                                                    <div class="" style="display: table-cell;width: 200px">
                                                        <p class="">
                                                            <span class="price">2.3</span>
                                                            <span class="">元/平米 · 天</span>
                                                        </p>
                                                        <p class="danjia">
                                                            14490元<span class="Arial">/</span>月
                                                        </p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div><!-- mediobody -->
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- 右侧栏 -->
        <div class="col-sm-3">
            <!-- 头像 -->
            <!--  大头注释
            <div class="row">
                <div class="col-sm-12">
                    <div class="thumbnail">
                        <img src="/6doffice/Apps/Index/View/Public/images/fsw.JPG" alt="...">
                        <div class="caption">
                            <h3>范松伟</h3>
                            <p>南京六度房地产咨询有限公司</p>
                            <p><a href="#" class="btn btn-default" role="button">写字楼出租<span style="color: red">50</span>套</a> <a href="#" class="btn btn-default" role="button">访问店铺</a></p>
                            <p><button class="btn btn-danger btn-block" style="font-size: 25px"><span class="glyphicon glyphicon-phone-alt"></span>151 9599 2303</button></p>
                        </div>
                    </div>
                </div>
            </div>
            -->

            <div class="row well" style="padding-left: 0px;padding-right: 0px">
                <div class="col-sm-7">
                    <div class="thumbnail">
                        <img src="/6doffice/Apps/Index/View/Public/images/fsw.JPG" alt="...">

                    </div>
                </div>
                <div class="col-sm-5" style="margin-top: 40px">
                    <h3 style="font-weight: bolder;font-family: Arial">范松伟</h3>
                    <div class="floatl" style="margin:20px auto;"><span class="colorGreen note">优</span><span class="colorRed note">真</span><span class="colorBlue note">诚</span></div>

                    <p>六度房地产</p>
                    <p>新街口店</p>
                </div>
                <button class="btn btn-primary btn-block">
                    写字楼出租50套访问店铺

                </button>
                <button class="btn btn-danger btn-block" style="font-size: 25px"><span class="glyphicon glyphicon-phone-alt"></span>151 9599 2303</button>

            </div>

            <!-- 相似房源推荐 -->
            <button class="btn btn-default btn-block btn-success">相似房源推荐</button>


                    <div class="thumbnail" style="border: 0px;margin-top: 10px">
                        <img src="/6doffice/Apps/Index/View/Public/images/7.jpg" alt="...">
                        <div class="caption">
                            <h5 style="color: #FF6600;margin: 10px">1.48 元/m²•天</h5>
                            <p style="margin-left: 10px">花神大道23号</p>
                        </div>
                    </div>
                    <div class="thumbnail" style="border: 0px;margin-top: 10px">
                <img src="/6doffice/Apps/Index/View/Public/images/6.jpg" alt="...">
                <div class="caption">
                    <h5 style="color: #FF6600;margin: 10px">3.30 元/m²•天</h5>
                    <p style="margin-left: 10px">石头城66号</p>
                </div>
            </div>
                    <div class="thumbnail" style="border: 0px;margin-top: 10px">
                <img src="/6doffice/Apps/Index/View/Public/images/5.jpg" alt="...">
                <div class="caption">
                    <h5 style="color: #FF6600;margin: 10px">2.80 元/m²•天</h5>
                    <p style="margin-left: 10px">江苏饭店</p>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $('#navbar-example').on('activate.bs.scrollspy', function () {

        $('.top_nav_xinxi').addClass('navbar-fixed-top');
        $('#navbar-example').css('display','block');





    })



    $(window).scroll(function () {
        var t = document.documentElement.scrollTop || document.body.scrollTop;
        if (t<200) {
            $('.top_nav_xinxi').removeClass('navbar-fixed-top');
            $('#navbar-example').css('display','none');


        }
    });
</script>





</body>
</html>