<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($title); ?> - 用户中心</title>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>
    <!-- 包括增加表单页面，编辑表单，没有action 也是默认这个页面 -->
    <script type="text/javascript" src="/6doffice/Public/js/FormValid.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/FV_onBlur.js"></script>
    <!-- //增加小区的thickBox -->
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/thickbox.css" />
    <script type="text/javascript" src="/6doffice/Public/js/thickbox.js"></script>
    <!-- //autocomplete -->
    <script type="text/javascript" src="/6doffice/Public/js/Autocompleter/lib/jquery.bgiframe.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/Autocompleter/lib/ajaxQueue.js"></script>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/js/Autocompleter/jquery.autocomplete.css" />
    <script type="text/javascript" src="/6doffice/Public/js/Autocompleter/lib/jquery.bgiframe.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/Autocompleter/jquery.autocomplete.js"></script>

</head>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<DIV id=container>
    <DIV id=header>
        <DIV class=myanjuke>
            <DIV class=logo><A href="<?php echo U(MODULE_NAME.'/Index/index');?>"><IMG border=0 src="/6doffice/Public/images/memberlogo.gif"></A></DIV>
            <DIV class=title><A href=""></A></DIV>
            <DIV class=nav><A href="<?php echo U('Home/Index/index');?>"><?php echo ($titlec); ?></A><SPAN>|</SPAN><A target="_blank" href="<?php echo U('Home/Shop/index');?>/id/<?php echo ($member_id); ?>">我的店铺</A><SPAN>|</SPAN><SPAN
                    class=helpicon></SPAN><A target="_blank" href="#">帮助</A></DIV>
            <DIV class=corner_links>
                <UL class=list_menu>
                    <LI class=list_first>您好，<A target="_blank" href="<?php echo U('Home/Shop/index');?>/id/<?php echo ($member_id); ?>"><?php echo ($username); ?></A> 欢迎回来！</LI>
                    <LI><A href="<?php echo U(MODULE_NAME.'/ManageMessage/msgInbox');?>">站内信(<?php echo ($msgCount); ?>)</A> </LI>
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
            <?php if($memberInfo["status"] == 1): ?><div class="bigNote" id="bigNote">
                <div class="noteTxt" style="font-size:14px;">您的帐号尚未开通！请联系 <?php echo ($rexian); ?> 进行开通!</div>
            </div><br /><?php endif; ?>
            <?php if($memberInfo["mobile"] == null): ?><div class="bigNote" id="bigNote">
                <div class="noteTxt" style="font-size:14px;">您还未<a href="brokerProfile.php">完善经纪人资料</a>！</div>
            </div><?php endif; ?>
            <div class="infoTipBox">
                <div class="loginTip"><?php echo ($nowTime); ?>好，<img src="<?php if($memberInfo["avatar"] != null): ?>/6doffice/Uploads/<?php echo ($memberInfo["avatar"]); else: ?>/6doffice/Public/images/demoPhoto_52_52.gif<?php endif; ?>" width="20" height="20" align="absmiddle" /><?php echo ($username); ?>&nbsp;<span><a class="underline" href="brokerPhoto.php">修改我的头像</a></span></div>

                <div class="universityTip"><a class="underline" href="<?php echo ($cfg["url_shop"]); echo ($memberInfo["id"]); ?>" target="_blank">进入我的网上店铺</a><span class="shopTip familyAlpha">&nbsp;(<?php echo ($cfg["url_shop"]); echo ($memberInfo["id"]); ?>)</span></div>
                <br />
                <br />


                <h4>帐号信息</h4>
                <hr>
                <div class="memberProfile">
                    <ul>
                        <li>用户姓名：<span class="familyAlpha color999"><?php echo ($username); ?></span></li>

                        <li>用户类型：
                            <?php if($memberInfo["vip"] == 1): ?><span class="familyAlpha color999">体验套餐</span> 到期时间：<span class="familyAlpha color999"><?php echo (date("Y-m-d",$vip_totime)); ?> <a class="underline" href="#" onclick="showBoxType();return false;">升级为标准套餐</a></span>
                            <?php elseif($memberInfo["vip"] == 2): ?>
                            <span class="familyAlpha color999">标准套餐</span> 到期时间：<span class="familyAlpha color999"><?php echo (date("Y-m-d",$vip_totime)); ?></span>
                            <?php else: ?>
                            <span class="familyAlpha color999">普通用户</span> <a class="underline" href="#" onclick="showBoxType();return false;">升级</a><?php endif; ?>
                        </li>
                        <li>账户状态：<span class="familyAlpha color999"> <?php if($memberInfo["status"] == 1): ?>未开通 <?php else: ?>正常<?php endif; ?></span></li>
                        <li>账户余额：<span class="familyAlpha color999"><?php echo ($memberInfo["money"]); ?>元</span>&nbsp;<span><a class="underline" href="pay.html" target="_blank">我要充值</a></span></li>

                        <li>服务特长：<span class="familyAlpha color999"><?php if($memberInfo["specialty"] != null): echo ($memberInfo["specialty"]); else: ?>还没有设置服务特长 <a class="underline" href="brokerProfile.php" >马上设置</a><?php endif; ?></span></li>

                        <li>你的等级：<img src="/6doffice/Public/images/rank/<?php echo ($memberInfo["brokerRank"]); ?>.png" align="absmiddle" />&nbsp;<span class="familyAlpha color999">(<?php echo ($memberInfo["scores"]); ?>积分)</span></li>
                        <li>你的认证：<?php if($memberInfo["idcard"] == null): ?><span>
                    <a class="underline" href="brokerIdentity.php" ><img src="/6doffice/Public/images/no_brokerIdentity.png" align="absmiddle" alt="未经过 <?php echo ($titlec); ?>实名认证" /></a>
                    </span>
                            <?php else: ?>
                            <img src="/6doffice/Public/images/brokerIdentity.png" align="absmiddle" alt="已通过 <?php echo ($titlec); ?>实名认证" /><?php endif; ?>
                            &nbsp;
                            <?php if($memberInfo["aptitude"] == null): ?><span><a class="underline" href="brokerAptitude.php" ><img src="/6doffice/Public/images/no_brokerAptitude.png" align="absmiddle" alt="未经过 <?php echo ($titlec); ?>执业认证" /></a></span>
                            <?php else: ?>
                            <img src="/6doffice/Public/images/brokerAptitude.png" align="absmiddle" alt="已通过 <?php echo ($titlec); ?>资质认证" /><?php endif; ?>&nbsp;</li>
                        <li>活跃指数：<?php if(is_array($memberInfo["active_str"])): foreach($memberInfo["active_str"] as $key=>$item): if($item == 1): ?><img src="/6doffice/Public/images/activityYes.gif" title="当天来过" /><?php else: ?><img src="/6doffice/Public/images/activityNo.gif" title="当天没来过" /><?php endif; endforeach; endif; ?>&nbsp;&nbsp;上次登录：<span class="familyAlpha color999"><?php echo (date("Y-m-d H:i:s",$memberInfo["last_login"])); ?></span>&nbsp;&nbsp;注册时间：<span class="familyAlpha color999"><?php echo (date("Y-m-d H:i:s",$memberInfo["add_time"])); ?></span></li>
                    </ul>
                </div><br />


                <h4>常用事物管理</h4>
                <hr>
                <ul class="infoTip">
                    <li><img src="/6doffice/Public/images/innerMsg.gif" />&nbsp;邮件：<span class="familyAlpha weightBold"><?php echo ($msgCount); ?>&nbsp;</span>封<a class="underline" href="msgInbox.php">未读邮件</a></li>

                    <li><img src="/6doffice/Public/images/memberMsnIcon.gif" />&nbsp;好友：<span class="familyAlpha weightBold"><?php echo ($firendInviteCount); ?>&nbsp;</span>个<a class="underline" href="snsInviteIn.php">好友邀请</a></li>
                </ul>
                <br />

                <h4>房源管理</h4>
                <hr>
                <ul class="houseTip">
                    <li><a class="underline familyAlpha size14px weightBold" href="manageSale.php">出售中(<?php echo ($saleCount); ?>)</a></li>
                    <li><a class="underline familyAlpha size14px weightBold" href="manageRent.php">出租中(<?php echo ($rentCount); ?>)</a></li>
                    <li><a class="underline familyAlpha size14px weightBold" href="manageSaleRecycle.php">出售下架(<?php echo ($saleRecycleCount); ?>)</a></li>
                    <li><a class="underline familyAlpha size14px weightBold" href="manageRentRecycle.php">出租下架(<?php echo ($rentRecycleCount); ?>)</a></li>
                </ul>
                <br />
                <ul class="houseTip">
                    <li><a class="underline familyAlpha size14px weightBold" href="manageSaleTop.php">出售置顶(<?php echo ($saleTopCount); ?>)</a></li>
                    <li><a class="underline familyAlpha size14px weightBold" href="manageRentTop.php">出租置顶(<?php echo ($rentTopCount); ?>)</a></li>
                </ul>

            </div>




        </div>
    </div>

</div>
<script language="javascript">

    function showBoxType(){
        TB_show('服务升级','vipShop.php?height=170&width=610&modal=true&rnd='+Math.random(),false);
    }
</script>
<script src="<?php echo ($cfg["path"]["js"]); ?>My97DatePicker/WdatePicker.js" language="javascript"></script>
</body>
</html>