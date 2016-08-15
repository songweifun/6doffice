<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>六度写字楼网首页</title>
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/bootstrap.css" />
    <script type="text/javascript" src="/6doffice/Public/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/index.css" />
    <style type="text/css">

    </style>
</head>
<body>
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

<!-- 搜索框开始 -->
<style>


</style>
<div class="container">

<div class="row">

    <div class="col-sm-8 col-sm-offset-2">


        <div class="banner_magnr">
            <div class="row">
                <div id="dsy_D02_01" class="news01">
                <div class="s1 col-sm-4 hidden-xs"><a target="_self" href="<?php echo U('index');?>">六度写字楼网</a></div>
                <div class="s2 col-sm-3 col-xs-12">南京【<a target="_blank" href="">切换城市</a>】</div>
            </div>
            </div>

            <!-- <div class="row">
                 <div class="col-sm-10">
                    <ul class="nav nav-pills">
                    <li role="presentation" class="active"><a href="#">查房价</a></li>
                    <li role="presentation"><a href="#">买新房</a></li>
                    <li role="presentation"><a href="#">买二手房</a></li>
                    <li role="presentation"><a href="#">赵租房</a></li>
                    <li role="presentation"><a href="#">装修家居</a></li>
                    <li role="presentation"><a href="#">房产快讯</a></li>
                    <li role="presentation"><a href="#">海外房产</a></li>
                </ul>
                 </div>
                 <div class="col-sm-1">
                    <div class="dropdown">
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        更多
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </div>
            </div>
                 </div>
             </div> -->
            <!-- 列表页 -->
            <div class="row liebiaoye">
                <div class="col-sm-12">
                        <ul class="nav nav-pills">
                            <li role="presentation" class="active"><a href="#">查房价</a></li>
                            <li role="presentation"><a href="#">买新房</a></li>
                            <li role="presentation"><a href="#">买二手房</a></li>
                            <li role="presentation"><a href="#">赵租房</a></li>
                            <li role="presentation"><a href="#">装修家居</a></li>
                            <li role="presentation"><a href="#">房产快讯</a></li>
                            <li role="presentation"><a href="#">海外房产</a></li>
                            <li role="presentation" class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    更多 <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </li>

                        </ul>
                </div>

            </div>
            <!-- 搜索框 -->
            <div class="row newsearch">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <input type="text" class="form-control search_input" placeholder="请输入关键字(楼盘名或地名)" autofocus>
                             <span class="input-group-btn">
                                <button class="btn btn-default serarch_button" type="button"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
            </div>

        </div>


    </div>

</div>

</div>


<!-- 搜索框结束 -->

</body>
</html>