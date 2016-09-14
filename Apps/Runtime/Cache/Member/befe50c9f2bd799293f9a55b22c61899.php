<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/x.xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($title); ?> - 店铺资料</title>
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
                    <a href="<?php echo U(MODULE_NAME.'/ManageContacts/snsLinkIn');?>">谁来看过我</a><br />
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
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageShop/shopProfile');?>" class="linkOn"><span>店铺资料</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageShop/shopDiy');?>"><span>店铺DIY</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageShop/shopSaleRec');?>"><span>橱窗推荐</span></a></li>
                </ul>
            </div>
            <form name="myform" action="<?php echo U(MODULE_NAME.'/ManageShop/shopProfile');?>/action/save" method="POST">
                <table class="memberBoxTable" cellpadding="0" cellspacing="5" border="0">
                    <thead>
                    <tr>
                        <td colspan="4"><span class="concentTitle">修改店铺资料</span></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="row1">店铺网址：</td>
                        <td colspan="3">&nbsp;<a href="<?php echo ($cfg["url_shop"]); echo ($member_id); ?>" class="underline alphaFontFamily" target="_blank" title="进入我的店铺"><?php echo ($cfg["url_shop"]); echo ($member_id); ?></a></td>
                    </tr>
                    <tr>
                        <td class="row1">店铺名称：</td>
                        <td colspan="3"><input id="shop_name" class="input" name="shop_name" type="text" size="35" maxlength="20" value="<?php echo ($dataInfo["shop_name"]); ?>" />&nbsp;<span class="tip">店铺名称最多20个汉字</span></td>
                    </tr>
                    <tr>
                        <td class="row1">店铺公告：</td>
                        <td colspan="3"><textarea class="textarea" name="shop_notice" cols="70" rows="10"><?php echo ($dataInfo["shop_notice"]); ?></textarea><br />&nbsp;<span class="tip">店铺公告最多300个汉字</span></td>
                    </tr>
                    <tr><td colspan="4" class="br"></td></tr>
                    </tbody>
                </table>
                <div class="submitBtn"><input type="button" value="确认修改" onclick="document.myform.submit(); " /></div>
            </form>
        </div>
    </div>

</div>
</body>
</html>