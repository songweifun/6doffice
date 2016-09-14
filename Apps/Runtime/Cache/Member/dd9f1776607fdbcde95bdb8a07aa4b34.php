<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($title); ?> - 房源管理</title>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>

    <script type="text/javascript" src="/6doffice/Public/js/thickbox.js"></script>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/thickbox.css" />

    <!-- 引入layer弹窗 -->
    <script type="text/javascript" src="/6doffice/Public/js/layer/layer.js"></script>

</head>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<DIV id=container>
    <DIV id=header>
        <DIV class=myanjuke>
            <DIV class=logo><A href="<?php echo U(MODULE_NAME.'/Index/index');?>"><IMG border=0 src="/6doffice/Public/images/memberlogo.gif"></A></DIV>
            <DIV class=title><A href=""></A></DIV>
            <DIV class=nav><A href="<?php echo ($cfg["url"]); ?>"><?php echo ($cfg["page"]["titlec"]); ?></A><SPAN>|</SPAN><A target="_blank" href="<?php echo ($cfg["url_shop"]); echo ($member_id); ?>">我的店铺</A><SPAN>|</SPAN><SPAN
                    class=helpicon></SPAN><A target="_blank" href="#">帮助</A></DIV>
            <DIV class=corner_links>
                <UL class=list_menu>
                    <LI class=list_first>您好，<A target="_blank" href="<?php echo ($cfg["url_shop"]); echo ($member_id); ?>"><?php echo ($username); ?></A> 欢迎回来！</LI>
                    <LI><A href="<?php echo ($cfg["url"]); ?>member/msgInbox.php">站内信(<?php echo ($msgCount); ?>)</A> </LI>
                    <LI class=list_last><A
                            href="<?php echo ($cfg["url"]); ?>login/login.php?action=logout">退出</A>
                    </LI></UL></DIV></DIV></DIV>
    </DIV>
<div class="main">
    <div class="page">
        <div class="memberLeftNav">
    <div class="title"></div>
    <ul class="navList">
        <li class="item">
            <p>房源管理</p>
            <ul>
                <li>
                    <a href="<?php echo U(MODULE_NAME.'/HouseSell/addSell');?>">发布出售</a><br />
                    <a href="<?php echo U(MODULE_NAME.'/HouseRent/addRent');?>">发布出租</a><br />
                    <a href="<?php echo U(MODULE_NAME.'/HouseSell/index');?>">出售管理</a><br />
                    <a href="<?php echo U(MODULE_NAME.'/HouseRent/index');?>">出租管理</a></li>
            </ul>

        </li><br />

        <li class="item">
            <p>店铺管理</p>
            <ul>
                <li>
                    <a href="shopProfile.php">店铺资料</a><br />
                    <a href="shopDiy.php">店铺DIY</a><br />
                    <a href="shopSaleRec.php">店铺推荐</a><br />
                    <a target="_blank" href="<?php echo ($cfg["url"]); ?>shop/evaluate.php?id=<?php echo ($member_id); ?>">服务评价</a><br />
                </li>
            </ul>

        </li>
        <br />

        <li class="item">
            <p>人脉管理</p>
            <ul>
                <li>
                    <a href="snsFriends.php">我的好友</a><br />
                    <a href="snsLinkIn.php">谁来看过我</a><br />
                    <a href="snsInviteIn.php">好友邀请</a><br />

                </li>
            </ul>

        </li>
        <br />

        <li class="item">
            <p>站内信</p>
            <ul>
                <li>
                    <a href="msgWrite.php">撰写信件</a><br />
                    <a href="msgInbox.php">收件箱</a><br />
                    <a href="msgSend.php">已发信件</a><br />
                    <a href="msgGarbage.php">垃圾箱</a><br />

                </li>
            </ul>

        </li>
        <br />


        <li class="item">
            <p>资料管理</p>
            <ul>
                <li>
                    <a href="brokerProfile.php">修改资料</a><br />
                    <a href="brokerIdentity.php">实名认证</a><br />
                    <a href="brokerPhoto.php">修改头像</a><br />
                    <a href="pwdEdit.php">修改密码</a><br />
                    <a href="brokerAptitude.php">执业认证</a><br />

                </li>
            </ul>

        </li>
    </ul>
    <div class="endLeft"></div>
</div>
        <div class="memberBox">
            <div class="memberBoxTab">
                <ul>
                    <li><a href="<?php echo U(MODULE_NAME.'/Housesell/addSell');?>"><span>发布出售</span></a></li>
                    <li><a href="houseRent.php"><span>发布出租</span></a></li>
                    <li><a href="#" class="linkOn"><span>出售管理</span></a></li>
                    <li><a href="manageRent.php"><span>出租管理</span></a></li>
                </ul>
            </div>
            <div class="manageSub">
                <ul class="manageSubNav">
                    <li class="linkOn"><a href="#"><span>出售中</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageSell/sellTopDone');?>"><span>置顶中</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageSell/recycle');?>"><span>回收站</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageSell/sellDone');?>"><span>成交榜</span></a></li>
                </ul>
            </div>
            <div class="manageBox">
                <div class="houseSearch">
                    <form name="searchForm" action="" method="GET">
                        <input type="text" class="input" name="q" size="30" value="<?php if($q != null): echo ($q); else: ?>输入房源编号或小区名称<?php endif; ?>" onblur="if(this.value ==''||this.value == '输入房源编号或小区名称'){this.value = '输入房源编号或小区名称';}" onfocus="if(this.value == '输入房源编号或小区名称'){this.value = '';}" />&nbsp;<input type="button" value="搜 索" onclick="javascript:document.searchForm.submit();" />&nbsp;<a href="#notice">出售房源管理必读</a><span class="tip">您已发布<span class="f90"><?php echo ($houseNum); ?></span>条出售房源，<?php if($houseLeft >= 0): ?>还可发布<span class="f90"><?php echo ($houseLeft); ?></span>条出售房源<?php else: ?>已超出<span class="f90"><?php echo (abs($houseLeft)); ?></span>条<?php endif; ?> <?php if($memberVip == 0): ?>| <a href="#" onclick="showBoxnum();return false;">购买条数</a><?php endif; ?></span>
                    </form>
                </div>
                <div class="houseList">
                    <table border="0" cellpadding="0" cellspacing="1">
                        <thead class="tableTitle">
                        <tr>
                            <td colspan="5">房源基本信息</td>
                            <td colspan="5">操作</td>
                        </tr>
                        </thead>
                        <thead class="tableSubTitle">
                        <tr>
                            <td width="12%">房源编号</td>
                            <td width="15%">小区名称</td>
                            <td width="10%">户型</td>
                            <td width="8%">面积</td>
                            <td width="8%">售价</td>

                            <td width="8%">可刷新</td>
                            <td width="18%">预约刷新</td>
                            <td width="28%">常用操作</td>

                        </tr>
                        </thead>
                        <tbody>
                        <form name="myform" enctype="text/html" action="" method="POST">
                            <input type="hidden" name="to_url" value="<?php echo ($to_url); ?>">
                            <?php if(is_array($dataList)): foreach($dataList as $key=>$item): ?><tr>
                                <td><input type="checkbox" name="ids[]" value="<?php echo ($item["id"]); ?>" />&nbsp;<a href="<?php echo ($cfg["url_sale"]); ?>d-<?php echo ($item["id"]); ?>.html" title="查看房源详细信息" target="_blank"><?php echo ($item["house_no"]); ?></a></td>
                                <td><?php echo ($item["borough_name"]); ?></td>
                                <td><?php echo ($item["house_room"]); ?>-<?php echo ($item["house_hall"]); ?>-<?php echo ($item["house_toilet"]); ?>-<?php echo ($item["house_veranda"]); ?></td>
                                <td><?php echo ($item["house_totalarea"]); ?>㎡</td>
                                <td class="f90"><?php if($item["house_price"] == 0): ?>面议<?php else: echo ($item["house_price"]); ?>万<?php endif; ?></td>
                                <td><?php echo ($item["refresh"]); ?>次</td>
                                <td> <!--增加预约刷新按钮 hyjfc.com-->
                                    <?php if($item["is_appo"] != null): ?><img src="/6doffice/Public/images/time.gif" width="23" height="16" align="absmiddle"  />
                                    <a href="<?php echo U(MODULE_NAME.'/Appointment/index');?>/action/appoShowHouse/site/sale/house_id/<?php echo ($item["id"]); ?>" title="查看">查看</a>|<a href="<?php echo U(MODULE_NAME.'/Appointment/index');?>/action/appoDel/site/sale/house_id/<?php echo ($item["id"]); ?>" title="取消">取消</a>

                                    <?php else: ?>
                                    <a href="<?php echo U(MODULE_NAME.'/Appointment/index');?>/action/appoRefresh/site/sale/ids/<?php echo ($item["id"]); ?>" title="立即预约">立即预约</a><?php endif; ?></td>
                                <td><a href="<?php echo U(MODULE_NAME.'/HouseSell/addsell');?>/action/edit/id/<?php echo ($item["id"]); ?>" title="编辑房源信息">编辑</a>&nbsp;<a href="?house_id=<?php echo ($item["id"]); ?>" onclick="showBox(<?php echo ($item["id"]); ?>);return false;" title="该房源已成交">成交</a>&nbsp;<a href="?house_id=<?php echo ($item["id"]); ?>" onclick="showBoxtop(<?php echo ($item["id"]); ?>);return false;" title="将此房源置顶">置顶</a>&nbsp;<a href="?house_id=<?php echo ($item["id"]); ?>" onclick="showBoxOwner(<?php echo ($item["id"]); ?>);return false;" title="查看房东信息">房东</a></td>

                            </tr><?php endforeach; endif; ?>
                            <tr>
                                <td colspan="10" class="listOperation">
                                    <label for="checkBoxAll"><input type="checkbox" id="checkBoxAll" name="checkBoxAll" value="1" onclick="checkAll(this);" />全选</label>
                                    <input id="listOperationBtn1" class="listOperationBtn" type="button" value="刷新选中的房源"  />&nbsp;
                                    <input id="listOperationBtn2" class="listOperationBtn" type="button" value="批量预约刷新房源"  />&nbsp;
                                    <input id="listOperationBtn3" class="listOperationBtn" type="button" value="下架选中的房源" />
                                </td>
                            </tr>
                        </form>
                        </tbody>
                    </table>
                    <?php echo ($pagePanel); ?>
                </div>
            </div>
            <div class="note">
                <p><a name="notice" id="notice"></a>出售房源管理必读：</p>
                <ul>


                    <li>每日刷新房源一次，还可有效提高房源在二手房栏目中的排名位置，提升房源点击率；</li>
                    <li>点击房源编号链接浏览房源详细信息；</li>
                    <li>通过“编辑”可对已发布的房源信息进行修改；</li>
                    <li>下架房源将进入回收站，可以在回收站中彻底删除；</li>
                    <li>若房源已成交，点击“成交”操作并输入相关的成交信息，可方便经纪人日后在“成交榜”中进行交易业绩和客户资料管理。已成交的房源将不再对外展示；</li>
                    <li>星级经纪人可发布30条出售房源，钻石级经纪人可发布60条出售房源；超过数量限制将不能再发布，请及时将无效房源下架或删除；</li>
                </ul>
            </div>
        </div>
    </div>

</div>
<script language="javascript">
    $('#listOperationBtn1').click(function(){

        if(confirm('你确认刷新选中的房源么？')){
            myform.action='<?php echo U(MODULE_NAME."/ManageSell/refresh");?>';
            myform.submit();}

    })

    $('#listOperationBtn2').click(function(){

        if(confirm('你确认预约刷新选中的房源么？')){
            myform.action='<?php echo U(MODULE_NAME."/Appointment/index");?>/action/appoRefresh/site/sale';
            myform.submit();}

    })

    $('#listOperationBtn3').click(function(){

        if(confirm('你确认下架选中的房源么？')){
            myform.action='<?php echo U(MODULE_NAME."/ManageSell/notsell");?>';
            myform.submit();}

    })
    function checkAll(formObj){
        if(formObj.checked){
            $('input[type=checkbox]').prop('checked', true);
        }else{
            $('input[type=checkbox]').prop('checked', false);
        }
    }
    function showBox(item_id){
        var url='<?php echo U(MODULE_NAME."/ManageSell/sellBargain");?>/house_id/'+item_id
        layer.open({
            type: 2,
            title: ['房源成交', ''],
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['400px' , '370px'],
            content: url,
            scrollbar: false,
        });
        //TB_show('房源成交','saleBargain.php?house_id='+item_id+'&height=370&width=400&modal=true&rnd='+Math.random(),false);
    }
    function showBoxOwner(item_id){

        var url='<?php echo U(MODULE_NAME."/ManageSell/landlordInfo");?>/house_id/'+item_id
        layer.open({
            type: 2,
            title: ['业主信息', ''],
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['400px' , '150px'],
            content: url,
            scrollbar: false,
        });

        //TB_show('业主信息','landlordSaleInfo.php?house_id='+item_id+'&height=150&width=400&modal=true&rnd='+Math.random(),false);
    }
    function showBoxtop(item_id){
        var url='<?php echo U(MODULE_NAME."/ManageSell/sellTop");?>/house_id/'+item_id
        layer.open({
            type: 2,
            title: ['房源置顶', ''],
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['400px' , '200px'],
            content: url,
            scrollbar: false,
        });
        //TB_show('房源置顶','saleTop.php?house_id='+item_id+'&height=200&width=400&modal=true&rnd='+Math.random(),false);
    }
    function showBoxnum(){
        var url='<?php echo U(MODULE_NAME."/ManageSell/buySellNum");?>'
        layer.open({
            type: 2,
            title: ['购买条数', ''],
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['400px' , '200px'],
            content: url,
            scrollbar: false,
        });

        //TB_show('购买条数','saleNum.php?height=200&width=400&modal=true&rnd='+Math.random(),false);
    }
</script>
<script src="/6doffice/Public/js/My97DatePicker/WdatePicker.js" language="javascript"></script>
</body>
</html>