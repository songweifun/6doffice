<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($title); ?> - 发送信件</title>
    <script>
        var hosesellajaxurl="<?php echo U(MODULE_NAME.'/HouseSell/ajax');?>"

    </script>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>

    <!-- vlidate -->
    <script type="text/javascript" src="/6doffice/Public/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/messages_zh.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/member/addMsg_formcheck.js"></script>

    <!-- ui autocomplete -->
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/js/uiautocomplete/jquery-ui.css" />
    <script type="text/javascript" src="/6doffice/Public/js/uiautocomplete/jquery-ui.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/member/addMsg_autocomplete.js"></script>
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
                    <a href="<?php echo U(MODULE_NAME.'/ManageContacts/snsInviteIn');?>">好友邀请</a><br />

                </li>
            </ul>

        </li>
        <br />

        <li class="item">
            <p>站内信</p>
            <ul>
                <li>
                    <a href="<?php echo U(MODULE_NAME.'/ManageMessage/msgWrite');?>">撰写信件</a><br />
                    <a href="<?php echo U(MODULE_NAME.'/ManageMessage/msgInbox');?>">收件箱</a><br />
                    <a href="<?php echo U(MODULE_NAME.'/ManageMessage/msgSend');?>">已发信件</a><br />
                    <a href="<?php echo U(MODULE_NAME.'/ManageMessage/msgGarbage');?>">垃圾箱</a><br />

                </li>
            </ul>

        </li>
        <br />


        <li class="item">
            <p>资料管理</p>
            <ul>
                <li>
                    <a href="<?php echo U(MODULE_NAME.'/ManageBroker/brokerProfile');?>">修改资料</a><br />
                    <a href="<?php echo U(MODULE_NAME.'/ManageBroker/brokerIdentity');?>">实名认证</a><br />
                    <a href="<?php echo U(MODULE_NAME.'/ManageBroker/brokerPhoto');?>">修改头像</a><br />
                    <a href="<?php echo U(MODULE_NAME.'/ManageBroker/pwdEdit');?>">修改密码</a><br />
                    <a href="<?php echo U(MODULE_NAME.'/ManageBroker/brokerAptitude');?>">执业认证</a><br />

                </li>
            </ul>

        </li>
    </ul>
    <div class="endLeft"></div>
</div>
        <div class="memberBox">
            <div class="msgOperationBox">
                <ul class="msgOperation">
                    <li class="linkOn"><a href="<?php echo U(MODULE_NAME.'/ManageMessage/msgWrite');?>"><span>撰写信件</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageMessage/msgInbox');?>"><span>收件箱(<?php echo ($msgCount); ?>)</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageMessage/msgSend');?>"><span>已发信件</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageMessage/msgGarbage');?>"><span>垃圾箱</span></a></li>
                </ul>
            </div>
            <div class="manageBox">
                <form id="dataInfo" name="dataInfo" method="post" action="<?php echo U(MODULE_NAME.'/ManageMessage/msgWrite');?>/action/save">
                    <table class="memberBoxTable msgTable" cellpadding="0" cellspacing="5" border="0">
                        <input type="hidden" name="reply_to" value="<?php echo ($dataInfo["reply_to"]); ?>">
                        <tbody>
                        <tr>
                            <td class="row1">收 件 人：</td>
                            <td colspan="3"><input id="msg_to" class="input" name="msg_to" type="text" size="40" value="<?php echo ($dataInfo["msg_to"]); ?>" />&nbsp;<span class="tip">输入收件人用户名</span></td>
                        </tr>
                        <tr>
                            <td class="row1">信件主题：</td>
                            <td colspan="3"><input id="msg_title" class="input" name="msg_title" type="text" size="40" value="<?php echo ($dataInfo["msg_title"]); ?>" />&nbsp;<span class="tip">主题最多25个汉字</span></td>
                        </tr>
                        <tr>
                            <td class="row1">信件内容：</td>
                            <td colspan="3"><textarea class="textarea" name="msg_content" cols="70" rows="10"></textarea></td>
                        </tr>
                        <tr><td colspan="4" class="br"></td></tr>
                        </tbody>
                    </table>
                    <div class="submitBtn"><input type="submit" value="发送信件" /></div>
                </form>
            </div>
        </div>
    </div>

</div>
</body>
</html>