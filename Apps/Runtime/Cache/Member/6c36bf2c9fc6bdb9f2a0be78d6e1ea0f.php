<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <META http-equiv=Pragma content=no-cache>
    <title><?php echo ($title); ?> -  店铺DIY</title>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>

    <script type="text/javascript" src="/6doffice/Public/js/FormValid.js"></script>
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
            <div class="memberBoxTab">
                <ul>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageShop/shopProfile');?>"><span>店铺资料</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageShop/shopDiy');?>" class="linkOn"><span>店铺DIY</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageShop/shopSaleRec');?>"><span>橱窗推荐</span></a></li>
                </ul>
            </div>
            <form name="dataInfo" method="POST" action="<?php echo U(MODULE_NAME.'/ManageShop/shopDiy');?>/action/save">
                <table class="memberBoxTable" cellpadding="0" cellspacing="5" border="0">
                    <thead>
                    <tr>
                        <td colspan="3"><span class="concentTitle">头部BANNER</span></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="row1">&nbsp;</td>
                        <td width="1120" class="row3"><span class="tip">BANNER预览</span><br /><input type="hidden" name="banner" id="banner"><span id="banner_dis"><?php if($memberInfo['banner'] != null): ?><img class="demoImgBorder" src="/6doffice/Uploads/<?php echo ($memberInfo["banner"]); ?>" width="535" height="64" title="店铺BANNER" /><?php else: ?>没有上传banner<?php endif; ?></span><br /><br /></td>
                    </tr>
                    <tr>
                        <td class="row1">上传BANNER：</td>
                        <td class="row3">&nbsp;<span class="tip">要求：清晰明了，宽度990 高度120</span><br /><iframe name="uploadBanner" width="100%" height="35" scrolling="No" frameborder="no"  src="<?php echo U(MODULE_NAME.'/ManageShop/webuploader');?>/to/uploadBanner|broker|banner" align="left"></iframe></td>

                    </tr>
                    <tr><td colspan="3" class="br"></td></tr>
                    </tbody>
                </table>

                <table class="memberBoxTable" cellpadding="0" cellspacing="5" border="0">
                    <thead>
                    <tr>
                        <td colspan="3"><span class="concentTitle">背景图片</span></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="row1">&nbsp;</td>
                        <td width="1120" class="row3"><span class="tip">背景图片预览</span><br /><input type="hidden" name="background" id="background" ><span id="background_dis"><?php if($memberInfo['background'] != null): ?><img class="demoImgBorder" src="/6doffice/Uploads/<?php echo ($memberInfo["background"]); ?>" width="70%" title="背景图片" /><?php else: ?>没有上传背景图<?php endif; ?></span><br /><br /></td>
                    </tr>
                    <tr>
                        <td class="row1">上传背景图：</td>
                        <td class="row3">&nbsp;<span class="tip">要求：清晰明了，宽度990 高度120</span><br /><iframe name="uploadBackground" width="100%" height="35" scrolling="No" frameborder="no"  src="<?php echo U(MODULE_NAME.'/ManageShop/webuploader');?>/to/uploadBackground|broker|background" align="left"></iframe></td>

                    </tr>
                    <tr><td colspan="3" class="br"></td></tr>
                    </tbody>
                </table>
                <div class="submitBtn"><input type="button" value="确认提交" onclick="javascript:if(validator(document.dataInfo)){document.dataInfo.submit();}"  /></div>
            </form>
            <div class="note">
                <p><a name="notice" id="notice"></a>店铺DIY必读：</p>
                <ul>
                    <li>上传的BANNER将会显示在经纪人店铺的头部，宽度一定严格按照990*120执行否则会出现模糊；</li>
                    <li>上传的背景图将会以平铺的方式显示在经纪人店铺的背景中；</li>

                </ul>
            </div>
        </div>
    </div>

</div>



<script language="javascript">
    function uploadBanner( furl,fname,thumbUrl ){
        document.getElementById('banner').value = furl;
        document.getElementById('banner_dis').innerHTML = '<a href="/6doffice/Uploads/'+furl+'"><img src="/6doffice/Uploads/'+furl+'" width="535" height="64" title="banner上传"></a>';
    }
    function uploadBackground( furl,fname,thumbUrl ){
        document.getElementById('background').value = furl;
        document.getElementById('background_dis').innerHTML = '<a href="/6doffice/Uploads/'+furl+'"><img src="/6doffice/Uploads/'+furl+'" width="70%" title="背景图上传"></a>';
    }
</script>
</body>
</html>