<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($title); ?> -  修改密码</title>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>

    <!-- 原来的表单验证 -->
    <script type="text/javascript" src="/6doffice/Public/js/FormValid.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/FV_onBlur.js"></script>
    <script type="text/javascript">
        FormValid.showError = function(errMsg,errName,formName) {
            if (formName=='dataForm') {
                for (key in FormValid.allName) {
                    document.getElementById('errMsg_'+FormValid.allName[key]).innerHTML = '';
                    document.getElementById('errMsg_'+FormValid.allName[key]).style.display = 'none';

                }
                for (key in errMsg) {
                    document.getElementById('errMsg_'+errName[key]).innerHTML = errMsg[key];
                    document.getElementById('errMsg_'+errName[key]).style.display = '';

                }
            }
        }
        var r = null;
        function ckname (inp) {
            $.ajax({type:"GET", url:"<?php echo U(MODULE_NAME.'/ManageBroker/ajaxCheckPwd');?>/r/"+Math.random()+'/password/'+inp.value, dataType:"text",async:false,success:function (msg){
                r = msg;
            }});
            if (r=='0') {
                return false;
            } else {
                return true;
            }
        }
    </script>
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
            <form name="dataForm" method="POST" action="?action=save">
                <table class="memberBoxTable" cellpadding="0" cellspacing="5" border="0">
                    <thead>
                    <tr>
                        <td colspan="4"><span class="concentTitle">修改密码</span></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="row1"><span class="must">*</span>旧的密码：</td>
                        <td colspan="3"><input id="password" class="input" name="password" type="password" size="25" valid="required|custom" custom="ckname" errmsg="旧密码不能为空|旧密码不正确！" />&nbsp; <span class="tip" id="errMsg_password"></span></td>
                    </tr>
                    <tr>
                        <td class="row1"><span class="must">*</span>新的密码：</td>
                        <td colspan="3"><input id="newpass" class="input" name="newpass" type="password" size="25" valid="required|limit"  min="6" errmsg="新密码不能为空|密码不少于6位!" />&nbsp; <span class="tip" id="errMsg_newpass"></span></td>
                    </tr>
                    <tr>
                        <td class="row1"><span class="must">*</span>密码确认：</td>
                        <td colspan="3"><input id="newpass2" class="input" name="newpass2" type="password" size="25" valid="eqaul" eqaulName="newpass" errmsg="两次输入的新密码不同!" />&nbsp;<span class="tip" id="errMsg_newpass2"></span></td>
                    </tr>
                    <tr><td colspan="4" class="br"></td></tr>
                    </tbody>
                </table>
                <div class="submitBtn"><input type="button" value="确认修改" onclick="javascript:if(validator(document.dataForm)){document.dataForm.submit();}"  /></div>
            </form>
        </div>
    </div>

</div>
<script type="text/javascript">
    initValid(document.dataForm);
</script>
</body>
</html>