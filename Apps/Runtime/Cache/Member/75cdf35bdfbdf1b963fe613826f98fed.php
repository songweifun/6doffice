<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($title); ?> - 资质认证</title>
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
                    <li><a href="brokerProfile.php"><span>修改资料</span></a></li>
                    <li><a href="brokerIdentity.php"><span>实名认证</span></a></li>
                    <li><a href="brokerPhoto.php"><span>修改头像</span></a></li>
                    <li><a href="pwdEdit.php"><span>修改密码</span></a></li>
                    <li><a href="brokerAptitude.php" class="linkOn"><span>执业认证</span></a></li>
                </ul>
            </div>
            <?php if($memberInfo['aptitude'] != null): ?><div class="bigNote" id="bigNote">
                <div class="noteTxt">通过执业认证，在您的个人信息展示位置将拥有<img src="/6doffice/Public/images/brokerAptitude.png" title=" <?php echo ($title); ?>执业认证标志" align="absmiddle"/>认证标志，让 <?php echo ($title); ?>用户更信赖您的服务。
                </div>
                <div class="closeNote">
                    <a href="javascript:;" onclick="document.getElementById('bigNote').style.display='none'" title="隐藏提示"><img src="/6doffice/Public/images/closeNote.gif" title="隐藏提示" /></a>
                </div>
            </div>
            <form name="dataForm" method="POST" action="?action=save">
                <table class="memberBoxTable" cellpadding="0" cellspacing="5" border="0">
                    <thead>
                    <tr>
                        <td colspan="4"><span class="concentTitle">地产经纪资格证书审核</span></td>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td class="row1">上传证书：</td>
                        <td class="row2">&nbsp;<span class="tip">要求：文件小于2M，图片清晰易于辨认</span><br />
                            <iframe name="uploadAptitudePicture" width="100%" height="35" scrolling="No" frameborder="no"  src="<?php echo U(MODULE_NAME.'/ManageBroker/webuploader');?>/to/uploadAptitudePicture|broker|aptitude" align="left"></iframe>
                        </td>
                        <td colspan="2"><span class="tip">合格证书图片示例</span><br />
                            <input type="hidden" id="aptitude_pic" name="aptitude_pic" valid="required" errmsg="请上传资格证书图片!" >
                            <div id="aptitude_pic_dis"><img class="demoImgBorder" src="/6doffice/Public/images/demoAptitude.jpg" width="220" height="130" title="经纪资格证书例图" /></div>
                        </td>
                    </tr>
                    <tr><td colspan="4" class="br"></td></tr>
                    </tbody>
                </table>
                <?php if($memberInfo['realname'] != null): ?><div class="submitBtn"><input type="button" value="提交审核" onclick="javascript:if(validator(document.dataForm)){document.dataForm.submit();}" /></div>
                <?php else: ?>
                <font color="#FF0000" size="+2">请先完善从业资料在进行执业证书审核!</font><?php endif; ?>
            </form>
            <?php else: ?>
            <div class="sysConfirm" id="sysConfirm">
                <div class="confirmTxt">恭喜^_^，您已通过 <?php echo ($title); ?>执业认证！
                    <p>在您的个人信息展示位置体现<img src="/6doffice/Public/images/brokerAptitude.png" />认证标志。</p>
                </div>
            </div><?php endif; ?>
        </div>
    </div>

</div>
<script language="javascript">
    function uploadAptitudePicture( furl,fname,thumbUrl ){
        document.getElementById('aptitude_pic').value = furl;
        document.getElementById('aptitude_pic_dis').innerHTML = '<a href="/6doffice/Uploads/'+furl+'"><img src="/6doffice/Uploads/'+furl+'" width="220" height="130" title="经纪资格证书"></a>';
    }
</script>
</body>
</html>