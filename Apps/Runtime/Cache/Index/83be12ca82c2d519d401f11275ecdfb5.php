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

<!-- 面包屑 -->

<div class="container" >

    <div class="row">

        <div class="col-sm-12 hidden-xs" style="padding-left: 15px;">
            <ul class="list-inline">
                <li><a href="#">首页&nbsp;&nbsp;></a></li>
                <li><a href="#">南京写字楼&nbsp;&nbsp;></a></li>
                <li class="active">写字楼出租&nbsp;&nbsp;></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 hidden-xs">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-globe" style="color: red;"></span>&nbsp;按区域查询</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-road" style="color: blue"></span>&nbsp;按地铁查询</a></li>
                <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-map-marker" style="color: red;"></span>&nbsp;切换到地图搜索</a></li>
                <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content set_font_row">
                <div role="tabpanel" class="tab-pane active" id="home" style="">

                    <ul class="list-inline">
                        <li><h5><span class="label label-danger">区域：</span></h5></li>
                        <li><a href="">不限</a></li>
                        <li><a href="">鼓楼</a></li>
                        <li><a href="">建邺</a></li>
                        <li><a href="">玄武</a></li>
                        <li><a href="">江宁</a></li>
                        <li><a href="">秦淮</a></li>
                        <li><a href="">雨花</a></li>
                        <li><a href="">栖霞</a></li>
                        <li><a href="">浦口</a></li>
                        <li><a href="">六合</a></li>
                        <li><a href="">高淳</a></li>
                        <li><a href="">溧水</a></li>
                        <li><a href="">南京周边</a></li>
                    </ul>


                    <ul class="list-inline">
                        <li><h5><span class="label label-danger">租金：</span></h5></li>
                        <li><a href="">不限</a></li>
                        <li><a href="">1元/平米·天以下</a></li>
                        <li><a href="">1-2元</a></li>
                        <li><a href="">2-3元</a></li>
                        <li><a href="">3-4元</a></li>
                        <li><a href="">4-5元</a></li>
                        <li><a href="">5-6元</a></li>
                        <li><a href="">6-7元</a></li>
                        <li><a href="">7-8元</a></li>
                        <li><a href="">8-9元</a></li>
                        <li><a href="">9-12元</a></li>
                        <li><a href="">12元/平米·天以上</a></li>

                    </ul>


                    <ul class="list-inline">
                        <li><h5><span class="label label-danger">面积：</span></h5></li>
                        <li><a href="">不限</a></li>
                        <li><a href="">100平米以下</a></li>
                        <li><a href="">100-200平米</a></li>
                        <li><a href="">200-300平米</a></li>
                        <li><a href="">300-500平米</a></li>
                        <li><a href="">500-800平米</a></li>
                        <li><a href="">800-1000平米</a></li>
                        <li><a href="">1000-2000平米</a></li>
                        <li><a href="">2000平米以上</a></li>

                    </ul>

                    <ul class="list-inline">
                        <li><h5><span class="label label-danger">类型：</span></h5></li>
                        <li><a href="">不限</a></li>
                        <li><a href="">纯写字楼</a></li>
                        <li><a href="">商住楼</a></li>
                        <li><a href="">商业综合体楼</a></li>
                        <li><a href="">酒店写字楼</a></li>


                    </ul>

                    <div class="well well-sm" style="margin-left: -13px;margin-top: -1px;padding-left: 12px;">

                    <ul class="list-inline">
                        <li><h5><span class="label label-danger">特色：</span></h5></li>
                        <li><a href="">不限</a></li>
                        <li><a href="">可注册</a></li>
                        <li><a href="">赠送免租期</a></li>
                        <li><a href="">交通便利</a></li>
                        <li><a href="">名企入驻</a></li>
                        <li><a href="">中心商务区</a></li>
                        <li><a href="">地标建筑</a></li>
                        <li><a href="">繁华商圈</a></li>
                        <li><a href="">知名物业</a></li>

                    </ul>
                    </div>

                </div>
                <div role="tabpanel" class="tab-pane" id="profile">

                </div>
                <div role="tabpanel" class="tab-pane" id="messages">...</div>
                <div role="tabpanel" class="tab-pane" id="settings">
                    <div class="well well-lg">

                    </div>
                </div>
            </div>

        </div>
    </div>











</div><!-- containner结束 -->

<!-- 媒体列表 右侧栏 -->
<div class="container">
    <div class="row">
        <div class="col-sm-9 hidden-xs">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#all_fang" aria-controls="all_fang" role="tab" data-toggle="tab">全部房源</a></li>
                            <li role="presentation"><a href="#geren_fang" aria-controls="geren_fang" role="tab" data-toggle="tab">个人房源</a></li>
                            <li role="presentation"><a href="#qita_fang" aria-controls="qita_fang" role="tab" data-toggle="tab">Messages</a></li>
                            <ul class="nav navbar-nav navbar-right">

                                    <li class=""><a href="#">1/100</a></li>
                                    <li><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
                                    <li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
                            </ul>
                        </ul>



                <div class="well well-small" style="padding: 5px 0px 5px 0">
                    <div class="container-fluid">
                        <div class="row">



                        <div class="col-sm-4" >
                            <div class="input-group">
                                <input type="text" class="form-control input-small" placeholder="输入写字楼名称" style="height: 24px;line-height: 24px;font-size: 10px">
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" type="button" style="font-size: 14px;padding: 1px 10px"><span class="glyphicon glyphicon-search"></span></button>
                                </span>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-4 -->

                            <div style="margin-right: -85px" class="btn-group col-sm-5 col-sm-offset-3 navbar-right" role="group" aria-label="...">
                                <button type="button" class="btn btn-default" style="font-size: 14px;padding: 1px 10px">多图</button>
                                <button type="button" class="btn btn-default" style="font-size: 14px;padding: 1px 10px">月租金</button>
                                <button type="button" class="btn btn-default" style="font-size: 14px;padding: 1px 10px">面积</button>


                                <div class="btn-group" role="group">
                                    <button type="button" style="font-size: 14px;padding: 1px 10px" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        发布时间
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" style="font-size: 14px">
                                        <li><a href="#">1天内</a></li>
                                        <li><a href="#">3天内</a></li>
                                        <li><a href="#">7天内</a></li>
                                        <li><a href="#">不限</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>




                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all_fang">
                                <!-- 媒体对象列表 -->
                                <div class="mengti_l_b">
                                    <ul class="media-list">
                                        <li class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang2.jpg" alt="...">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <div class="houseList">
                                                    <div class="list">
                                                        <h5 class="media-heading"><a href="">龙台国际大厦 双地铁口 精装修 挑高型 户型采光极佳</a></h5>


                                                        <div class="info rel">


                                                            <p class="mt15">
                                                                <a title="黄埔大厦" href="" target="_blank"><span class="spName">黄埔大厦</span></a>
                                                                <span title="瑞金路黄埔路2号" class="ml10 spAddr">瑞金路黄埔路2号</span>
                                                            </p>
                                                            <p class="mt10 dengji">等级：甲级<span class="line">/</span>所在楼层：中区(共30层)</p>
                                                            <p class="mt10 dengji"><a class="marr7" target="_blank" title="访问[卢伟]的个人网上店铺，查看更多房源" href="">卢伟</a><span class="ml10">32秒前更新</span></p>
                                                            <div class="mt12">
                                                                <div class="pt4 floatl"><span class="colorGreen note">可注册</span><span class="colorRed note">交通便利</span><span class="colorBlue note">名企入驻</span></div>
                                                                <div class="floatl note-img"></div>
                                                            </div>
                                                            <div class="area area2">210㎡<p class="tag">建筑面积</p></div>
                                                            <div class="moreInfo">
                                                                <p class="mt5">
                                                                    <span class="price">2.3</span>
                                                                    <span class="ml5">元/平米 · 天</span>
                                                                </p>
                                                                <p class="danjia mt5">
                                                                    14490元<span class="Arial">/</span>月
                                                                </p>
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
                                                    <img class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang2.jpg" alt="...">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <div class="houseList">
                                                    <div class="list">
                                                        <h5 class="media-heading"><a href="">龙台国际大厦 双地铁口 精装修 挑高型 户型采光极佳</a></h5>


                                                        <div class="info rel">


                                                            <p class="mt15">
                                                                <a title="黄埔大厦" href="" target="_blank"><span class="spName">黄埔大厦</span></a>
                                                                <span title="瑞金路黄埔路2号" class="ml10 spAddr">瑞金路黄埔路2号</span>
                                                            </p>
                                                            <p class="mt10 dengji">等级：甲级<span class="line">/</span>所在楼层：中区(共30层)</p>
                                                            <p class="mt10 dengji"><a class="marr7" target="_blank" title="访问[卢伟]的个人网上店铺，查看更多房源" href="">卢伟</a><span class="ml10">32秒前更新</span></p>
                                                            <div class="mt12">
                                                                <div class="pt4 floatl"><span class="colorGreen note">可注册</span><span class="colorRed note">交通便利</span><span class="colorBlue note">名企入驻</span></div>
                                                                <div class="floatl note-img"></div>
                                                            </div>
                                                            <div class="area area2">210㎡<p class="tag">建筑面积</p></div>
                                                            <div class="moreInfo">
                                                                <p class="mt5">
                                                                    <span class="price">2.3</span>
                                                                    <span class="ml5">元/平米 · 天</span>
                                                                </p>
                                                                <p class="danjia mt5">
                                                                    14490元<span class="Arial">/</span>月
                                                                </p>
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
                                                    <img class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang2.jpg" alt="...">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <div class="houseList">
                                                    <div class="list">
                                                        <h5 class="media-heading"><a href="">龙台国际大厦 双地铁口 精装修 挑高型 户型采光极佳</a></h5>


                                                        <div class="info rel">


                                                            <p class="mt15">
                                                                <a title="黄埔大厦" href="" target="_blank"><span class="spName">黄埔大厦</span></a>
                                                                <span title="瑞金路黄埔路2号" class="ml10 spAddr">瑞金路黄埔路2号</span>
                                                            </p>
                                                            <p class="mt10 dengji">等级：甲级<span class="line">/</span>所在楼层：中区(共30层)</p>
                                                            <p class="mt10 dengji"><a class="marr7" target="_blank" title="访问[卢伟]的个人网上店铺，查看更多房源" href="">卢伟</a><span class="ml10">32秒前更新</span></p>
                                                            <div class="mt12">
                                                                <div class="pt4 floatl"><span class="colorGreen note">可注册</span><span class="colorRed note">交通便利</span><span class="colorBlue note">名企入驻</span></div>
                                                                <div class="floatl note-img"></div>
                                                            </div>
                                                            <div class="area area2">210㎡<p class="tag">建筑面积</p></div>
                                                            <div class="moreInfo">
                                                                <p class="mt5">
                                                                    <span class="price">2.3</span>
                                                                    <span class="ml5">元/平米 · 天</span>
                                                                </p>
                                                                <p class="danjia mt5">
                                                                    14490元<span class="Arial">/</span>月
                                                                </p>
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
                                                    <img class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang2.jpg" alt="...">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <div class="houseList">
                                                    <div class="list">
                                                        <h5 class="media-heading"><a href="">龙台国际大厦 双地铁口 精装修 挑高型 户型采光极佳</a></h5>


                                                        <div class="info rel">


                                                            <p class="mt15">
                                                                <a title="黄埔大厦" href="" target="_blank"><span class="spName">黄埔大厦</span></a>
                                                                <span title="瑞金路黄埔路2号" class="ml10 spAddr">瑞金路黄埔路2号</span>
                                                            </p>
                                                            <p class="mt10 dengji">等级：甲级<span class="line">/</span>所在楼层：中区(共30层)</p>
                                                            <p class="mt10 dengji"><a class="marr7" target="_blank" title="访问[卢伟]的个人网上店铺，查看更多房源" href="">卢伟</a><span class="ml10">32秒前更新</span></p>
                                                            <div class="mt12">
                                                                <div class="pt4 floatl"><span class="colorGreen note">可注册</span><span class="colorRed note">交通便利</span><span class="colorBlue note">名企入驻</span></div>
                                                                <div class="floatl note-img"></div>
                                                            </div>
                                                            <div class="area area2">210㎡<p class="tag">建筑面积</p></div>
                                                            <div class="moreInfo">
                                                                <p class="mt5">
                                                                    <span class="price">2.3</span>
                                                                    <span class="ml5">元/平米 · 天</span>
                                                                </p>
                                                                <p class="danjia mt5">
                                                                    14490元<span class="Arial">/</span>月
                                                                </p>
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
                                                    <img class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang2.jpg" alt="...">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <div class="houseList">
                                                    <div class="list">
                                                        <h5 class="media-heading"><a href="">龙台国际大厦 双地铁口 精装修 挑高型 户型采光极佳</a></h5>


                                                        <div class="info rel">


                                                            <p class="mt15">
                                                                <a title="黄埔大厦" href="" target="_blank"><span class="spName">黄埔大厦</span></a>
                                                                <span title="瑞金路黄埔路2号" class="ml10 spAddr">瑞金路黄埔路2号</span>
                                                            </p>
                                                            <p class="mt10 dengji">等级：甲级<span class="line">/</span>所在楼层：中区(共30层)</p>
                                                            <p class="mt10 dengji"><a class="marr7" target="_blank" title="访问[卢伟]的个人网上店铺，查看更多房源" href="">卢伟</a><span class="ml10">32秒前更新</span></p>
                                                            <div class="mt12">
                                                                <div class="pt4 floatl"><span class="colorGreen note">可注册</span><span class="colorRed note">交通便利</span><span class="colorBlue note">名企入驻</span></div>
                                                                <div class="floatl note-img"></div>
                                                            </div>
                                                            <div class="area area2">210㎡<p class="tag">建筑面积</p></div>
                                                            <div class="moreInfo">
                                                                <p class="mt5">
                                                                    <span class="price">2.3</span>
                                                                    <span class="ml5">元/平米 · 天</span>
                                                                </p>
                                                                <p class="danjia mt5">
                                                                    14490元<span class="Arial">/</span>月
                                                                </p>
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
                                                    <img class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang2.jpg" alt="...">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <div class="houseList">
                                                    <div class="list">
                                                        <h5 class="media-heading"><a href="">龙台国际大厦 双地铁口 精装修 挑高型 户型采光极佳</a></h5>


                                                        <div class="info rel">


                                                            <p class="mt15">
                                                                <a title="黄埔大厦" href="" target="_blank"><span class="spName">黄埔大厦</span></a>
                                                                <span title="瑞金路黄埔路2号" class="ml10 spAddr">瑞金路黄埔路2号</span>
                                                            </p>
                                                            <p class="mt10 dengji">等级：甲级<span class="line">/</span>所在楼层：中区(共30层)</p>
                                                            <p class="mt10 dengji"><a class="marr7" target="_blank" title="访问[卢伟]的个人网上店铺，查看更多房源" href="">卢伟</a><span class="ml10">32秒前更新</span></p>
                                                            <div class="mt12">
                                                                <div class="pt4 floatl"><span class="colorGreen note">可注册</span><span class="colorRed note">交通便利</span><span class="colorBlue note">名企入驻</span></div>
                                                                <div class="floatl note-img"></div>
                                                            </div>
                                                            <div class="area area2">210㎡<p class="tag">建筑面积</p></div>
                                                            <div class="moreInfo">
                                                                <p class="mt5">
                                                                    <span class="price">2.3</span>
                                                                    <span class="ml5">元/平米 · 天</span>
                                                                </p>
                                                                <p class="danjia mt5">
                                                                    14490元<span class="Arial">/</span>月
                                                                </p>
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
                            <div role="tabpanel" class="tab-pane" id="geren_fang">...</div>
                            <div role="tabpanel" class="tab-pane" id="qita_fang">...</div>
                        </div>
        </div>
        <!-- 右侧栏 -->
        <div class="col-sm-3 hidden-xs">
           <div class="row">
               <div class="col-sm-12">
                   <button type="button" class="btn btn-danger btn-lg btn-block">个人房东发布</button>
               </div>
               <div class="col-sm-12" style="margin-top: 20px">
                   <button type="button" class="btn btn-primary btn-lg btn-block">中介发布</button>
               </div>

               <div class="col-sm-12" style="margin-top: 20px;">
                   <button type="button" class="btn btn-default btn-lg btn-block" style="border-radius: 0px">最近浏览</button>
                   <div style="border-left: solid 1px #dddddd;border-bottom: solid 1px #dddddd;border-right: solid 1px #dddddd;padding-top:10px">
                       <div class="media" style="margin-bottom: 10px">
                           <div class="media-left media-middle">
                               <a href="#">
                                   <img style="margin-left:40px;" class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang4.jpg" alt="...">
                               </a>
                           </div>
                           <div class="media-body" >
                               <h5 class="media-heading" style="margin-left:50px;">黄埔大厦</h5>
                               <span style="margin-left:50px;">300平米</span>
                               <div style="margin-left:50px;color: red">20000元/月</div>
                           </div>
                       </div>
                       <div class="media" style="margin-bottom: 10px">
                           <div class="media-left media-middle">
                               <a href="#">
                                   <img style="margin-left:40px;" class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang4.jpg" alt="...">
                               </a>
                           </div>
                           <div class="media-body" >
                               <h5 class="media-heading" style="margin-left:50px;">黄埔大厦</h5>
                               <span style="margin-left:50px;">300平米</span>
                               <div style="margin-left:50px;color: red">20000元/月</div>
                           </div>
                       </div>
                       <div class="media" style="margin-bottom: 10px">
                           <div class="media-left media-middle">
                               <a href="#">
                                   <img style="margin-left:40px;" class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang4.jpg" alt="...">
                               </a>
                           </div>
                           <div class="media-body" >
                               <h5 class="media-heading" style="margin-left:50px;">黄埔大厦</h5>
                               <span style="margin-left:50px;">300平米</span>
                               <div style="margin-left:50px;color: red">20000元/月</div>
                           </div>
                       </div>
                       <div class="media" style="margin-bottom: 10px">
                           <div class="media-left media-middle">
                               <a href="#">
                                   <img style="margin-left:40px;" class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang4.jpg" alt="...">
                               </a>
                           </div>
                           <div class="media-body" >
                               <h5 class="media-heading" style="margin-left:50px;">黄埔大厦</h5>
                               <span style="margin-left:50px;">300平米</span>
                               <div style="margin-left:50px;color: red">20000元/月</div>
                           </div>
                       </div>
                       <div class="media" style="margin-bottom: 10px">
                           <div class="media-left media-middle">
                               <a href="#">
                                   <img style="margin-left:40px;" class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang4.jpg" alt="...">
                               </a>
                           </div>
                           <div class="media-body" >
                               <h5 class="media-heading" style="margin-left:50px;">黄埔大厦</h5>
                               <span style="margin-left:50px;">300平米</span>
                               <div style="margin-left:50px;color: red">20000元/月</div>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-sm-12" style="margin-top: 20px;">
                   <button type="button" class="btn btn-default btn-lg btn-block" style="border-radius: 0px">好房推荐</button>
                   <div style="border-left: solid 1px #dddddd;border-bottom: solid 1px #dddddd;border-right: solid 1px #dddddd;padding-top:10px">
                       <div class="media" style="margin-bottom: 10px">
                           <div class="media-left media-middle">
                               <a href="#">
                                   <img style="margin-left:40px;" class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang4.jpg" alt="...">
                               </a>
                           </div>
                           <div class="media-body" >
                               <h5 class="media-heading" style="margin-left:50px;">黄埔大厦</h5>
                               <span style="margin-left:50px;">300平米</span>
                               <div style="margin-left:50px;color: red">20000元/月</div>
                           </div>
                       </div>
                       <div class="media" style="margin-bottom: 10px">
                           <div class="media-left media-middle">
                               <a href="#">
                                   <img style="margin-left:40px;" class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang4.jpg" alt="...">
                               </a>
                           </div>
                           <div class="media-body" >
                               <h5 class="media-heading" style="margin-left:50px;">黄埔大厦</h5>
                               <span style="margin-left:50px;">300平米</span>
                               <div style="margin-left:50px;color: red">20000元/月</div>
                           </div>
                       </div>
                       <div class="media" style="margin-bottom: 10px">
                           <div class="media-left media-middle">
                               <a href="#">
                                   <img style="margin-left:40px;" class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang4.jpg" alt="...">
                               </a>
                           </div>
                           <div class="media-body" >
                               <h5 class="media-heading" style="margin-left:50px;">黄埔大厦</h5>
                               <span style="margin-left:50px;">300平米</span>
                               <div style="margin-left:50px;color: red">20000元/月</div>
                           </div>
                       </div>
                       <div class="media" style="margin-bottom: 10px">
                           <div class="media-left media-middle">
                               <a href="#">
                                   <img style="margin-left:40px;" class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang4.jpg" alt="...">
                               </a>
                           </div>
                           <div class="media-body" >
                               <h5 class="media-heading" style="margin-left:50px;">黄埔大厦</h5>
                               <span style="margin-left:50px;">300平米</span>
                               <div style="margin-left:50px;color: red">20000元/月</div>
                           </div>
                       </div>
                       <div class="media" style="margin-bottom: 10px">
                           <div class="media-left media-middle">
                               <a href="#">
                                   <img style="margin-left:40px;" class="media-object" src="/6doffice/Apps/Index/View/Public/images/fang4.jpg" alt="...">
                               </a>
                           </div>
                           <div class="media-body" >
                               <h5 class="media-heading" style="margin-left:50px;">黄埔大厦</h5>
                               <span style="margin-left:50px;">300平米</span>
                               <div style="margin-left:50px;color: red">20000元/月</div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>

        </div>
    </div>
</div>


<!-- 手机视图 -->

<div class="container-fluid">
    <div class="row">
        <div class="visible-xs-block">
            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">位置</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample">租金</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">删选</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">排序</button>
                </div>

            </div>

            <div class="collapse" id="collapseExample">
                <div class="well" style="padding: 0px">
                    <div class="btn-group-vertical" role="group" aria-label="..." >
                        <button type="button" class="btn btn-default">不限</button>
                        <button type="button" class="btn btn-default">附近</button>
                        <button type="button" class="btn btn-default">区域</button>

                        <div class="btn-group dropup" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                地铁
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">1号线</a></li>
                                <li><a href="#">2号线</a></li>
                                <li><a href="#">3号线</a></li>
                                <li><a href="#">4号线</a></li>

                            </ul>
                        </div>


                    </div>
                </div>
            </div>
            <div class="collapse" id="collapseExample1">

                <!-- nest table -->
                <div class="row">
                    <div class="col-lg-6">
                        <section class="panel">

                            <div class="panel-body">
                                <div class="dd" id="nestable_list_1">
                                    <ol class="dd-list">
                                        <li class="dd-item" data-id="1">
                                            <div class="dd-handle">不限</div>
                                        </li>

                                        <li class="dd-item" data-id="11">
                                            <div class="dd-handle">区域</div>
                                        </li>
                                        <li class="dd-item" data-id="12">
                                            <div class="dd-handle">附近</div>
                                        </li>
                                        <li class="dd-item" data-id="2">
                                            <div class="dd-handle">地铁</div>
                                            <ol class="dd-list">
                                                <li class="dd-item" data-id="3">
                                                    <div class="dd-handle">1号线</div>
                                                </li>
                                                <li class="dd-item" data-id="4">
                                                    <div class="dd-handle">2号线</div>
                                                </li>
                                                <li class="dd-item" data-id="5">
                                                    <div class="dd-handle">3号线</div>
                                                    <ol class="dd-list">
                                                        <li class="dd-item" data-id="6">
                                                            <div class="dd-handle">林场站</div>
                                                        </li>
                                                        <li class="dd-item" data-id="7">
                                                            <div class="dd-handle">星火路站</div>
                                                        </li>
                                                        <li class="dd-item" data-id="8">
                                                            <div class="dd-handle">东大成贤学院站</div>
                                                        </li>
                                                    </ol>
                                                </li>
                                                <li class="dd-item" data-id="9">
                                                    <div class="dd-handle">4号线</div>
                                                </li>
                                                <li class="dd-item" data-id="10">
                                                    <div class="dd-handle">5号线</div>
                                                </li>
                                            </ol>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </section>

                    </div>

                </div>

            </div>
        </div>
    </div>





<!--body wrapper end-->


</div><!-- container end -->


<div class="text-center" style="background-color: #CD0000;padding: 10px;margin-top: 5px;margin-bottom: 0px;font-size: 14px;color: white;border-radius: 5px">

    <p><a href="">关于我们</a> | <a href="">人才招聘</a> | <a href="">用户协议</a> | <a href="">版权声明</a> | <a href="">联系我们</a></p>
    <p>客服热线：02566078688    客服QQ：752708170</p>
    <p>Powered by 六度网科 V2 苏ICP13058108号-1</p>
</div>



<script src="/6doffice/Apps/Index/View/Public/js/nestable/jquery.nestable.js"></script>
<script src="/6doffice/Apps/Index/View/Public/js/nestable-init.js"></script>

</body>
</html>