<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/bootstrap.css" />
    <script type="text/javascript" src="/6doffice/Public/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/index.css" />
</head>
<body>

<div style="" id="banner_show" class="banner_show">

    <a target="_blank" class="danmu_inbox" style="margin-left: -1000px; z-index: 2; display: block;" href=" http://mshow.fang.com/c?z=fang&amp;la=0&amp;si=173&amp;cg=142&amp;c=98691&amp;ci=109284&amp;or=14389&amp;l=70481&amp;bg=70484&amp;b=67223&amp;u=http://hengdalongjun.fang.com/ ">
        <span class="bt"> 广告 恒大龙珺 &nbsp;&nbsp; 江宁 &nbsp;&nbsp;  </span>
        <img width="2000" height="464" src="/6doffice/Public/images/39ac1f11b48740b28c1958db92dcf9b0.jpg ">
        <div style="display:none;">

        </div>
        <div style="display:none;">

        </div>
    </a>

    <a target="_blank" class="danmu_inbox" style="margin-left: -1000px; z-index: 1; display: none;" href=" http://mshow.fang.com/c?z=fang&amp;la=0&amp;si=173&amp;cg=142&amp;c=98692&amp;ci=114181&amp;or=14723&amp;l=71752&amp;bg=71755&amp;b=68607&amp;u=http://yanshanjuwk.fang.com/ ">
        <span class="bt"> 广告 五矿晏山居 &nbsp;&nbsp; 玄武 &nbsp;&nbsp;  </span>
        <img width="2000" height="464" src="/6doffice/Public/images/8c2598a2dafd4b5ba013822850eff0e0.jpg ">
        <div style="display:none;">

        </div>
        <div style="display:none;">

        </div>
    </a>


    <script text="javascript">

        var className=document.getElementById("danmu_inbox_id").value;

        var a=document.getElementById("banner_show").getElementsByTagName("a");
        var ABCD = Math.floor(Math.random()*a.length);
        for(i=0;i&lt;a.length;i++){if(i==ABCD){a[i].style.display="";}else{a[i].style.display="none";}}
        document.getElementById("banner_show").style.display="";
        if(a.length&gt;1){ for(i=1;i&lt;=a.length;i++){var id="banner_ctr" + i ; document.getElementById(id).style.display="";
            if(i==(ABCD+1)){document.getElementById(id).className="current";}}}


        //var dianping01Html= $(".bannger_inbox").eq(ABCD).find("div").eq(0).html();
        //var dianpingUrl=$(".bannger_inbox").eq(ABCD).find("div").eq(1).html();

        var dianping01Html= $(className).eq(ABCD).find("div").eq(0).html();
        var dianpingUrl=$(className).eq(ABCD).find("div").eq(1).html();


        var arr=[];
        if(dianping01Html.split(',').length==1&amp;&amp;dianping01Html.split(',')[0].trim().length==0)
        {
            arr=[];
        }else
        {
            arr=dianping01Html.split(',');
            var barrage = new Barrage({text: arr,type:[],
                host:'',url:dianpingUrl,wrapper: 'danmu'+ABCD});
            window.barrage=barrage;
        }

    </script>

    <script src="http://js.soufunimg.com/homepage/new/fang905bj/newsV3/js/zzsc_danmu6V07.js" text="javascript"></script>
    <div class="banner_mag">
        <div class="banner_magnr">
            <div id="dsy_D02_01" class="news01">
                <div class="s1"><a target="_self" href="http://www1.fang.com">搜房网</a></div>
                <div class="s2">南京【<a target="_blank" href="http://www.fang.com/SoufunFamily.htm">切换城市</a>】</div>
            </div>
            <div class="news02">
                <div class="s1"><a target="_self" class="cur" onmouseover="//change('chafangjia');" id="dsy_D02_19" href="http://fangjia.fang.com/nanjing/">查房价</a><a target="_self" onmouseover="//change('maixinfang');" onclick="//setTimeout(function(){document.getElementById('projnames').value=''},300); " id="dsy_D02_02" href="http://newhouse.nanjing.fang.com/house/s/" class="">买新房</a><a target="_self" onmouseover="//change('maiershoufang');" id="dsy_D02_03" href="http://esf.nanjing.fang.com/" class="">买二手房</a><a target="_self" onmouseover="//change('zhaozufang');" id="dsy_D02_04" href="http://zu.nanjing.fang.com/" class="">找租房</a><a target="_self" onmouseover="//change('zhuangxiujiaju')" id="dsy_D02_05" href="http://home.nanjing.fang.com" class="">装修家居</a><a target="_self" onmouseover="//change('fangchankuaixun');" id="dsy_D02_06" href="http://news.nanjing.fang.com/" class="">房产快讯</a><a target="_self" onmouseover="//change('haiwaifangchan');" id="dsy_D02_20" href="http://world.fang.com/" class="">海外房产</a></div>
                <ul class="menu">
                    <li style="width:35px;background:url(http://js.soufunimg.com/homepage/new/fang905bj/new/images/navicon1.gif) no-repeat 48px 8px;position: absolute;top:8px;left:600px;text-shadow: 0 0px 0px #fff;" class="">
                        <a>更多</a>
                        <ul style="padding-bottom:0px;top:26px;"><li style="height:25px;line-height:25px;" class=""><a id="dsy_D02_21" target="_self" href="http://newhouse.nanjing.fang.com/house/s/list/ ">地图找房</a></li>
                            <li style="height:25px;line-height:25px;"><a id="dsy_D02_12" target="_self" href="http://www.fang.com/ask/?city=bj">房产问答</a></li><li style="height:25px;line-height:25px;"><a id="dsy_D02_22" target="_self" href="http://zhishi.fang.com/">房产知识</a></li><li style="background:none;height:25px;line-height:25px;"><a id="dsy_D02_07" target="_self" href="http://www.youtx.com/">短租</a></li>
                            <li style="height:25px;line-height:25px;"><a id="dsy_D02_08" target="_self" href="http://office.nanjing.fang.com/">写字楼</a></li>
                            <li style="height:25px;line-height:25px;"><a id="dsy_D02_09" target="_self" href="http://shop.nanjing.fang.com/">商铺</a></li>
                            <!-- <li style="height:25px;line-height:25px;"><a  href="http://world.fang.com/house/" target="_self"  id="dsy_D02_10">海外房产</a></li>-->
                            <li style="height:25px;line-height:25px;"><a id="dsy_D02_11" target="_self" href="http://njbbs.fang.com/">业主论坛</a></li>
                            <!-- <li style="height:25px;line-height:25px;"><a href="http://www.fang.com/ask/?city=nanjing " target="_self"  id="dsy_D02_12">问答</a></li>-->
                            <li style="height:25px;line-height:25px;"><a id="dsy_D02_13" target="_self" href="http://search.fang.com/so/">综合搜索</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div style="position:relative" id="dsy_D02_14" class="news03">
                <div style="display: block;" id="searchjtId1" class="searchjt"></div><div style="margin-left: 70px; display: none;" id="searchjtId2" class="searchjt"></div><div style="margin-left: 145px; display: none;" id="searchjtId3" class="searchjt"></div><div style="margin-left: 221px; display: none;" id="searchjtId4" class="searchjt"></div><div style="margin-left: 300px; display: none;" id="searchjtId5" class="searchjt"></div><div style="margin-left:382px;display:none;" id="searchjtId6" class="searchjt"></div><div style="margin-left: 465px; display: none;" id="searchjtId7" class="searchjt"></div>

                <input type="text" id="projnames" maxlength="40" value="请输入关键字（楼盘名/地名/开发商等）" onfocus="// focusEvent(event,this);" onblur="// SFUI.toggleHint(this);this.className='sinputstyle';this.onmouseout=function(){this.className='sinputstyle'};" onmousemove="// this.className='sinputstyle';" onmouseout="// this.className='sinputstyle';" onmousedown="// javascript:getId();" flag="chafangjia" class="sinputstyle" name="">
                <a id="pinggu" target="_blank" href=""></a>
                <span class="sbuttonstyle" onclick="// getName()"></span></div>

        </div>

    </div>
    <div style="display: none;" id="banner_pre_next" class="banner_pre_next">
        <a id="dsy_D02_17" class="banner_btn_left" style="cursor: hand;cursor: pointer;">&lt;</a>
        <a id="dsy_D02_18" class="banner_btn_right" style="cursor: hand;cursor: pointer;">&gt;</a>
    </div>
</div>
</body>
</html>