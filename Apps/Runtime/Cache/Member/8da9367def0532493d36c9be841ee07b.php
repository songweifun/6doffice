<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title><?php echo ($title); ?> - 房源管理</title>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>
    <!-- 引入layer弹窗 -->
    <script type="text/javascript" src="/6doffice/Public/js/layer/layer.js"></script>

    <script type="text/javascript"><!--
    function noTop(){
        var cf=confirm("您确定取消该置顶？");
        if (cf==true)
        {
            return true;
        }else{
            return false;
        }
    }
    //--></script>
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
                    <li><a href="<?php echo U(MODULE_NAME.'/HouseRent/addRent');?>"><span>发布出租</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/Housesell/index');?>"><span>出售管理</span></a></li>
                    <li><a href="#" class="linkOn"><span>出租管理</span></a></li>
                </ul>
            </div>
            <div class="manageSub">
                <ul class="manageSubNav">
                    <li><a href="<?php echo U(MODULE_NAME.'/HouseRent/index');?>"><span>出租中</span></a></li>
                    <li class="linkOn"><a href="#"><span>置顶中</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageRent/recycle');?>"><span>回收站</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageRent/RentDone');?>"><span>成交榜</span></a></li>
                </ul>
            </div>
            <div class="manageBox">
                <div class="houseSearch">
                    <form name="searchForm" action="" method="GET">

                        <input class="input" name="q" type="text" size="30" value="<?php if($q != null): echo ($q); else: ?>输入房源编号或小区名称<?php endif; ?>" onblur="if(this.value ==''||this.value == '输入房源编号或小区名称'){this.value = '输入房源编号或小区名称';}" onfocus="if(this.value == '输入房源编号或小区名称'){this.value = '';}" />&nbsp;<input type="button" value="搜 索"  onclick="javascript:document.searchForm.submit();"  />&nbsp;<a href="#notice">置顶房源必读</a>
                    </form>
                </div>
                <div class="houseList">
                    <table border="0" cellpadding="0" cellspacing="1">
                        <thead class="tableTitle">
                        <tr>
                            <td colspan="6">房源基本信息</td>
                            <td>点击统计</td>
                            <td>到期时间</td>
                            <td>操作</td>
                        </tr>
                        </thead>
                        <thead class="tableSubTitle">
                        <tr>
                            <td width="13%">房源编号</td>
                            <td width="18%">小区名称</td>
                            <td width="10%">户型</td>
                            <td width="8%">面积</td>
                            <td width="8%">租金</td>
                            <td width="10%">发布时间</td>
                            <td width="10%">总计</td>
                            <td width="10%">&nbsp;</td>
                            <td width="19%">&nbsp;</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($dataList)): foreach($dataList as $key=>$item): ?><tr>
                            <td>&nbsp;<a href="<?php echo ($cfg["url_sale"]); ?>d-<?php echo ($item["id"]); ?>.html" title="查看房源详细信息" target="_blank"><?php echo ($item["house_no"]); ?></a></td>
                            <td><?php echo ($item["borough_name"]); ?></td>
                            <td><?php echo ($item["house_room"]); ?>-<?php echo ($item["house_hall"]); ?>-<?php echo ($item["house_toilet"]); ?>-<?php echo ($item["house_veranda"]); ?></td>
                            <td><?php echo ($item["house_totalarea"]); ?>㎡</td>
                            <td class="f90"><?php if($item["house_price"] == 0): ?>面议<?php else: echo ($item["house_price"]); ?>元<?php endif; ?></td>
                            <td><?php echo (date('Y-m-d',$item["created"])); ?></td>
                            <td><?php echo ($item["click_num"]); ?></td>
                            <td><?php echo (date('Y-m-d',$item["to_time"])); ?></td>
                            <td><a href="<?php echo U(MODULE_NAME.'/HouseRent/addRent');?>/action/edit/id/<?php echo ($item["id"]); ?>" title="编辑房源信息">编辑</a>&nbsp;<a href="?house_id=<?php echo ($item["id"]); ?>" onclick="showBox(<?php echo ($item["id"]); ?>);return false;" title="该房源已成交">成交</a>&nbsp;<a href="<?php echo U(MODULE_NAME.'/ManageRent/RentTopDone');?>/action/noTop/id/<?php echo ($item["id"]); ?>" onclick="javascript:return noTop();">取消</a></td>
                        </tr><?php endforeach; endif; ?>
                        <tr>
                            <td colspan="9" class="listOperation">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?php echo ($pagePanel); ?>
                </div>
            </div>
            <div class="note">
                <p><a name="notice" id="notice"></a>置顶管理必读：</p>
                <ul>
                    <li>置顶的房源在相应栏目的顶部位置，排序规则按照置顶时间降序排列；</li>
                    <li>通过“编辑”可对已发布的房源信息进行修改；</li>
                </ul>
            </div>
        </div>
    </div>

</div>
<script language="javascript">
    function checkAll(formObj){
        if(formObj.checked){
            $('input[type=checkbox]').prop('checked', true);
        }else{
            $('input[type=checkbox]').prop('checked', false);
        }
    }
    function showBox(item_id){
        var url='<?php echo U(MODULE_NAME."/ManageRent/RentBargain");?>/house_id/'+item_id
        layer.open({
            type: 2,
            title: ['房源成交', ''],
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['400px' , '370px'],
            content: url,
            scrollbar: false,
        });
    }
</script>
<script src="/6doffice/Public/js/My97DatePicker/WdatePicker.js" language="javascript"></script>
</body>
</html>