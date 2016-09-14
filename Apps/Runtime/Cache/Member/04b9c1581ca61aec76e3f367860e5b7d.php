<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <META http-equiv=Pragma content=no-cache>
    <title><?php echo ($title); ?> -  修改头像</title>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>

    <!-- 原来的表单验证 -->
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
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageBroker/brokerProfile');?>" class="linkOn"><span>修改资料</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageBroker/brokerIdentity');?>"><span>实名认证</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageBroker/brokerPhoto');?>"><span>修改头像</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageBroker/pwdEdit');?>"><span>修改密码</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageBroker/brokerAptitude');?>"><span>执业认证</span></a></li>
                </ul>
            </div>
            <form name="dataInfo" method="POST" action="?action=save">
                <table class="memberBoxTable" cellpadding="0" cellspacing="5" border="0">
                    <thead>
                    <tr>
                        <td colspan="4"><span class="concentTitle">上传头像</span></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="row1">上传头像：</td>
                        <td class="row3">&nbsp;<span class="tip">要求：面部清晰可辨,宽高比3:4。勿上传远照！</span><br /><iframe name="uploadAvatarPicture" width="100%" height="35" scrolling="No" frameborder="no"  src="<?php echo U(MODULE_NAME.'/ManageBroker/webuploader');?>/to/uploadAvatarPicture|broker|avatar" align="left"></iframe></td>
                        <td class="tdContCenter">
                            <span class="tip">审核头像预览</span><br />
                            <input type="hidden" name="avatar_pic" id="avatar" valid="required" errmsg="请上传头像照片!" ><span id="avatar_dis"><?php if($lastAvatar['avatar_pic'] != null): ?><img class="demoImgBorder" src="/6doffice/Uploads/<?php echo ($lastAvatar["avatar_pic"]); ?>?rnd=<?php echo ($cfg["time"]); ?>" width="104" height="124" title="我的头像" /><?php else: ?><img class="demoImgBorder" src="/6doffice/Public/images/demoPhoto.jpg" width="104" height="124" title="默认头像" /><?php endif; ?>
                        </span><br /><br />
                            <span class="tip">状态：
                                <?php if($lastAvatar['status'] == 0): ?>审核中
                                <?php elseif($lastAvatar['status'] == 1): ?>已审核<?php else: ?>审核不通过<?php endif; ?>
                            </span>
                        </td>
                        <td class="tdContCenter"><span class="tip">当前使用头像</span><br /><?php if($memberInfo['avatar'] != null): ?><img class="demoImgBorder" src="/6doffice/Uploads/<?php echo ($memberInfo["avatar"]); ?>" width="104" height="124" title="我的头像" /><?php else: ?><img class="demoImgBorder" src="/6doffice/Public/images/demoPhoto.jpg" width="104" height="124" title="默认头像" /><?php endif; ?><br /><br /><br /></td>
                    </tr>
                    <tr><td colspan="4" class="br"></td></tr>
                    </tbody>
                </table>
                <div class="submitBtn"><input type="button" value="提交审核" onclick="javascript:if(validator(document.dataInfo)){document.dataInfo.submit();}"  /></div>
            </form>
            <div class="note">
                <p><a name="notice" id="notice"></a>上传头像必读：</p>
                <ul>
                    <li>头像是网络经纪人留给客户的第一印象。越有亲和力的头像越有机会赢得客户；</li>
                    <li>合格的头像，要求必需是图片清晰，经纪人面部可清楚辨认的上身证照，请勿使用背景凌乱的大头贴；<a class="underline" href="<?php echo ($cfg["url"]); ?>university/helpBrokerFQ.php#9" target="_blank">合格的头像示例</a></li>
                    <li>我们将在24小时内完成头像审核，只有审核通过的头像才会对外展示，未上传或头像审核未通过，将统一使用 <?php echo ($cfg["page"]["title"]); ?>默认头像；</li>
                </ul>
            </div>
        </div>
    </div>

</div>



<script language="javascript">
    function uploadAvatarPicture( furl,fname,thumbUrl ){
        document.getElementById('avatar').value = furl;
        document.getElementById('avatar_dis').innerHTML = '<a href="/6doffice/Uploads/'+furl+'"><img src="/6doffice/Uploads/'+furl+'" width="106" height="126" title="头像审核"></a>';
    }
</script>
</body>
</html>