<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($title); ?> - 推荐橱窗</title>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>
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
                    <a href="<?php echo U(MODULE_NAME.'/ManageShop/shopProfile');?>">店铺资料</a><br />
                    <a href="<?php echo U(MODULE_NAME.'/ManageShop/shopDiy');?>">店铺DIY</a><br />
                    <a href="<?php echo U(MODULE_NAME.'/ManageShop/shopSaleRec');?>">店铺推荐</a><br />
                    <a target="_blank" href="<?php echo ($cfg["url"]); ?>shop/evaluate.php?id=<?php echo ($member_id); ?>">服务评价</a><br />
                </li>
            </ul>

        </li>
        <br />

        <li class="item">
            <p>人脉管理</p>
            <ul>
                <li>
                    <a href="<?php echo U(MODULE_NAME.'/ManageContacts/snsFriends');?>">我的好友</a><br />
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
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageShop/shopProfile');?>"><span>店铺资料</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageShop/shopDiy');?>"><span>店铺DIY</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageShop/shopSaleRec');?>" class="linkOn"><span>橱窗推荐</span></a></li>
                </ul>
            </div>
            <div class="manageSub">
                <ul class="manageSubNav">
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageShop/shopSaleRec');?>"><span>出售中</span></a></li>
                    <li class="linkOn"><a href="<?php echo U(MODULE_NAME.'/ManageShop/shopRentRec');?>"><span>出租中</span></a></li>
                </ul>
            </div>
            <div class="manageBox">
                <div class="houseSearch">
                    <form name="searchForm" action="" method="GET">
                        是否推荐：<select class="select" name="is_promote">
                        <option value="">不限</option>
                        <option value="1"  <?php if($_GET['is_promote']== 1): ?>selected<?php endif; ?>>已推荐</option>
                        <option value="2"  <?php if($_GET['is_promote']== 2): ?>selected<?php endif; ?>>未推荐</option>
                    </select>&nbsp;
                        <input class="input" name="q" type="text" size="28" value="<?php if($q != null): echo ($q); else: ?>输入房源编号或小区名称<?php endif; ?>" onblur="if(this.value ==''||this.value == '输入房源编号或小区名称'){this.value = '输入房源编号或小区名称';}" onfocus="if(this.value == '输入房源编号或小区名称'){this.value = '';}" />&nbsp;<input type="button" value="搜 索" onclick="javascript:document.searchForm.submit();" />&nbsp;<a href="#notice">橱窗推荐操作必读</a><span class="tip"><span class="f90"><?php echo ($houseNum); ?></span>个橱窗已用，<span class="f90"><?php echo ($houseLeft); ?></span>个橱窗可用</span>
                    </form>
                </div>
                <div class="houseList">
                    <table border="0" cellpadding="0" cellspacing="1">
                        <thead class="tableTitle">
                        <tr>
                            <td colspan="6">房源基本信息</td>
                            <td>当前状态</td>
                            <td>操作</td>
                        </tr>
                        </thead>
                        <thead class="tableSubTitle">
                        <tr>
                            <td width="15%">房源编号</td>
                            <td width="24%">小区名称</td>
                            <td width="9%">户型</td>
                            <td width="9%">面积</td>
                            <td width="9%">租金</td>
                            <td width="9%">剩余</td>
                            <td width="15%">&nbsp;</td>
                            <td width="10%">&nbsp;</td>
                        </tr>
                        </thead>
                        <tbody>
                        <form name="myform" enctype="text/html" action="" method="POST">
                            <input type="hidden" name="to_url" value="<?php echo ($to_url); ?>">
                            <?php if(is_array($dataList)): foreach($dataList as $key=>$item): if($item['is_promote'] == 2): ?><tr>
                                <td><input type="checkbox" name="ids[]" value="<?php echo ($item["id"]); ?>" />&nbsp;<a href="<?php echo ($cfg["url_rent"]); ?>d-<?php echo ($item["id"]); ?>.html" title="查看房源详细信息" target="_blank"><?php echo ($item["house_no"]); ?></a></td>
                                <td><?php echo ($item["borough_name"]); ?></td>
                                <td><?php echo ($item["house_room"]); ?>-<?php echo ($item["house_hall"]); ?>-<?php echo ($item["house_toilet"]); ?>-<?php echo ($item["house_veranda"]); ?></td>
                                <td><?php echo ($item["house_totalarea"]); ?>㎡</td>
                                <td class="f90"><?php echo ($item["house_price"]); ?>元</td>
                                <td><?php echo ($item["day_left"]); ?>天</td>
                                <td>未推荐</td>
                                <td><a href="<?php echo U(MODULE_NAME.'/ManageShop/shopRentRec');?>/action/promote/id/<?php echo ($item["id"]); ?>" title="推荐到橱窗">推荐</a></td>
                            </tr>
                            <?php else: ?>
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="<?php echo ($item["id"]); ?>" />&nbsp;<a href="<?php echo ($cfg["url_rent"]); ?>d-<?php echo ($item["id"]); ?>.html" title="查看房源详细信息" target="_blank"><?php echo ($item["house_no"]); ?></a></td>
                                <td><?php echo ($item["borough_name"]); ?></td>
                                <td><?php echo ($item["house_room"]); ?>-<?php echo ($item["house_hall"]); ?>-<?php echo ($item["house_toilet"]); ?>-<?php echo ($item["house_veranda"]); ?></td>
                                <td><?php echo ($item["house_totalarea"]); ?>㎡</td>
                                <td class="f90"><?php echo ($item["house_price"]); ?>元</td>
                                <td><?php echo ($item["day_left"]); ?>天</td>
                                <td class="f90">已推荐</td>
                                <td><a href="<?php echo U(MODULE_NAME.'/ManageShop/shopRentRec');?>/action/cancel/id/<?php echo ($item["id"]); ?>" title="取消橱窗推荐">取消</a></td>
                            </tr><?php endif; endforeach; endif; ?>
                        </form>
                        </tbody>
                    </table>
                    <?php echo ($pagePanel); ?>
                </div>
            </div>
            <div class="note">
                <p><a name="notice" id="notice"></a>橱窗推荐操作必读：</p>
                <ul>
                    <li>被推荐的房源将显示在店铺首页最受客户关注的“店长推荐”位置；</li>
                    <li>最多可推荐8条房源(二手房和租房累计)；</li>
                    <li>选择“是否推荐”并搜索，可对已推荐或未推荐的房源进行分别显示；</li>
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

</script>
</body>
</html>