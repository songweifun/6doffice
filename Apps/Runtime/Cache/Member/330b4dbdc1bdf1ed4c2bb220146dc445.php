<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($title); ?> - 查看好友</title>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>

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
            <div class="msgOperationBox">
                <ul class="msgOperation">
                    <li class="linkOn"><a href="<?php echo U(MODULE_NAME.'/ManageContacts/snsFriends');?>"><span>我的好友</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageContacts/snsLinkIn');?>"><span>谁来看过我</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageContacts/snsInviteIn');?>"><span>好友邀请</span></a></li>
                </ul>
            </div>
            <div class="manageBox">
                <div class="friendsList">
                    <?php if(is_array($dataList)): foreach($dataList as $key=>$item): ?><table border="0" cellpadding="0" cellspacing="0" onmouseover="document.getElementById('friendsListExt_<?php echo ($key+1); ?>').style.display=''" onmouseout="document.getElementById('friendsListExt_<?php echo ($key+1); ?>').style.display='none'">
                        <tbody>
                        <tr>
                            <td class="rowPhoto"><a href="<?php echo ($cfg["url_shop"]); echo ($item["friend_id"]); ?>" title="<?php echo ($item["realname"]); ?>" target="_blank"><?php if($item["avatar"] != null): ?><img class="demoImgBorder" src="/6doffice/Uploads/<?php echo ($item["avatar"]); ?>" width="42" height="50" /><?php else: ?><img class="demoImgBorder" src="/6doffice/Public/images/demoPhoto.jpg" width="42" height="50" /><?php endif; ?></a></td>
                            <td class="rowName" colspan="2">
                                <p class="p1"><span><a class="font14px fontBold" href="<?php echo ($cfg["url_shop"]); echo ($item["friend_id"]); ?>" target="_blank"><?php echo ($item["realname"]); ?></a>&nbsp;<?php echo ($item["broker_type"]); ?></span><?php if($item['birth_remember'] != null): ?><span><img src="/6doffice/Public/images/snsBirth.gif" align="absmiddle" /> 生日提醒：<a class="underline" href="msgWrite.php?msg_to=<?php echo ($item["username"]); ?>" title="发送生日祝福"><?php echo ($item["realname"]); ?> 快过生日了</a></span><?php endif; ?></p>
                                <p class="p2"><span class="alphaFontFamily">手机：<?php echo ($item["mobile"]); ?></span><span class="alphaFontFamily">出售：<a class="underline" href="<?php echo ($cfg["url_shop"]); ?>sale.php?id=<?php echo ($item["friend_id"]); ?>" target="_blank"><?php echo ($item["sell_num"]); ?>套</a></span></span><span class="alphaFontFamily">出租：<a class="underline" href="<?php echo ($cfg["url_shop"]); ?>rent.php?id=<?php echo ($item["friend_id"]); ?>" target="_blank"><?php echo ($item["rent_num"]); ?>套</a></span></p>
                            </td>
                            <td><img src="/6doffice/Public/images/msgUnread.gif" /> <a href="msgWrite.php?msg_to=<?php echo ($item["username"]); ?>">发送消息</a></td>
                        </tr>
                        </tbody>
                        <tbody id="friendsListExt_<?php echo ($key+1); ?>" class="friendsListExt" style="display:none">
                        <tr>
                            <td colspan="4">
                                <span class="alphaFontFamily">E-mail：<?php echo ($item["email"]); ?></span>
                                <span class="alphaFontFamily">QQ：<?php echo ($item["qq"]); ?></span>
                                <span class="alphaFontFamily">MSN：<?php echo ($item["msn"]); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <span class="alphaFontFamily">服务区域：<?php echo ($item["cityarea_name"]); ?></span>
                                <span class="alphaFontFamily">门店地址：<?php echo ($item["outlet_addr"]); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="tdContRight"><img src="/6doffice/Public/images/deleteIcon.gif" align="absmiddle" /><a href="<?php echo U(MODULE_NAME.'/ManageContacts/snsFriends');?>/action/delete/id/<?php echo ($item["id"]); ?>" onclick="if(confirm('确定要删除该好友吗？')){return true;}else{return false;}">删除好友</a></td>
                        </tr>
                        </tbody>
                    </table><?php endforeach; endif; ?>
                    <?php echo ($pagePanel); ?>
                </div>
                <div><a href="" onclick="showBox();return false;">添加好友</a></div>
            </div>
        </div>
    </div>

</div>
<script>
    function showBox(){
        var url='<?php echo U(MODULE_NAME."/ManageContacts/snsFriends");?>/action/add/'
        layer.open({
            type: 2,
            title: ['添加好友', ''],
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['400px' , '370px'],
            content: url,
            scrollbar: false,
        });
    }
</script>
</body>
</html>