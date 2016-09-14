<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($title); ?> - 店铺资料</title>
    <script>
        var hosesellajaxurl="<?php echo U(MODULE_NAME.'/HouseSell/ajax');?>"
    </script>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>
    <!-- 日期插件 -->
    <script type="text/javascript" src="/6doffice/Public/js/My97DatePicker/WdatePicker.js"></script>

    <!-- vlidate -->
    <script type="text/javascript" src="/6doffice/Public/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/messages_zh.min.js"></script>

    <!-- ui autocomplete -->
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/js/uiautocomplete/jquery-ui.css" />
    <script type="text/javascript" src="/6doffice/Public/js/uiautocomplete/jquery-ui.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/member/addrent_autocomplete.js"></script>

    <!-- 引入layer弹窗 -->
    <script type="text/javascript" src="/6doffice/Public/js/layer/layer.js"></script>
    <style>
        em.error{
            color:red;
            float: right;
            margin-left: -10px;
        }
    </style>

    <script type="text/javascript">
        //验证完了执行的事件
        /*$.validator.setDefaults({
            submitHandler: function() {
                alert("提交事件!");
            }
        });*/

        $(function(){
            $.validator.addMethod("isTel", function (value, element) {
             var length = value.length;
             var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
             var tel = /^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/;
             return this.optional(element) || tel.test(value) || (length == 11 && mobile.test(value));
             }, "请正确填写您的联系方式");
            var volidator=$('#dataInfo').validate({
                /*errorContainer: "div.error",
                errorLabelContainer: $("#dataInfo div.error"),
                wrapper: "li",*/
                //自定义验证信息
                rules: {
                    mobile: {
                        required: true,
                        isTel:true

                    },
                    email: {
                        required: true,
                        email: true
                    },
                    cityarea_id: {
                        required: true

                    },
                    outlet_first: {
                        required: true

                    },
                    outlet_last: {
                        required: true

                    }

                },
                messages: {
                    mobile: {
                        required: "请输入移动电话!",

                    },
                    email: {
                        required: "请输入Email地址!"
                    },
                    cityarea_id: {
                        required: "请选择服务区域!"
                    },
                    outlet_first: {
                        required: "请填写所属公司!"

                    },
                    outlet_last: {
                        required: "请填写所属门店!"

                    }
                },//message end
                errorElement:"em"
            });
            //volidator.showErrors('11111')
            /*$('.submitBtn').click(function(){
                if($('#dataInfo').valid()){
                    $('#dataInfo').submit()
                }else{
                    layer.open({
                        type: 1,
                        title:'',
                        area: ['200px', '300px'],
                        shadeClose: true, //点击遮罩关闭
                        content: $("#dataInfo div.error").html()
                    });
                }
            })*/
        })
        function addToBoroughItem(bid,bname,b_addr){
            $("#borough_id").val(bid);
            $("#borough_name").val(bname);
            $("#borough_addr").val(b_addr);
            $("#borough_addr_tr").css("display","");
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
            <?php if($dataInfo["mobile"] == null): ?><div class="bigNote" id="bigNote">
                <div class="noteTxt">在完善<a href="<?php echo U(MODULE_NAME.'/ManageBroker/brokerProfile');?>">从业资料</a>前，您所发布的房源暂时无法对外展示！
                </div>
                <div class="closeNote">
                    <a href="javascript:;" onclick="document.getElementById('bigNote').style.display='none'" title="隐藏提示"><img src="/6doffice/Public/images/closeNote.gif" title="隐藏提示" /></a>
                </div>
            </div><?php endif; ?>
            <form name="dataInfo" method="POST" action="?action=save" id="dataInfo">
                <input type="hidden" name="id" value="<?php echo ($dataInfo["id"]); ?>">
                <table class="memberBoxTable" cellpadding="0" cellspacing="5" border="0">
                    <thead>
                    <tr>
                        <td colspan="4"><span class="concentTitle">从业资料 - 让客户信赖你！</span></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="row1">用 户 名：</td>
                        <td colspan="3"><input id="username" class="input" name="username" type="text" size="25" value="<?php echo ($dataInfo["username"]); ?>" disabled="disabled" /></td>
                    </tr>

                    <tr>
                        <td class="row1"><span class="must">*</span>真实姓名：</td>
                        <td colspan="3">

                            <input id="realname" class="input" name="realname" type="text" size="25" value="<?php echo ($dataInfo["realname"]); ?>" disabled="disabled" />


                        </td>
                    </tr>

                    <tr>
                        <td class="row1"><span class="must">*</span>移动电话：</td>
                        <td colspan="3"><input id="mobile" class="input" name="mobile" type="text" size="25" valid="required|isTelephone" errmsg="请输入移动电话!|请输入正确的移动电话号码" value="<?php echo ($dataInfo["mobile"]); ?>" />&nbsp;<span class="tip">显示为看房电话，请留手机或小灵通号码，方便客户随时联系你</span></td>
                    </tr>
                    <tr>
                        <td class="row1"><span class="must">*</span>Email：</td>
                        <td colspan="3"><input id="email" class="input" name="email" type="text" size="25" valid="required|isEmail" errmsg="请输入Email地址!|Email地址格式不对!" value="<?php echo ($dataInfo["email"]); ?>" />&nbsp;<span class="tip">请输入有效且常用的Email邮箱地址，这是找回密码的唯一方式</span></td>
                    </tr>

                    </tbody>
                    <tbody id="jobFile" style="display: <?php if($dataInfo['broker_type'] == 2): ?>none<?php else: ?>''<?php endif; ?>">
                    <tr>
                        <td class="row1"><span class="must">*</span>服务区域：</td>
                        <td colspan="3"><select class="select" name="cityarea_id" id="addBoroughCityarea" valid="required" errmsg="请选择服务区域!">
                            <option value="">请选择</option>
                            <?php if(is_array($cityarea_option)): foreach($cityarea_option as $key=>$item): if($key == $dataInfo['cityarea_id']): ?><option value="<?php echo ($key); ?>" selected ><?php echo ($item); ?></option>
                                    <?php else: ?>
                                    <option value="<?php echo ($key); ?>"><?php echo ($item); ?></option><?php endif; endforeach; endif; ?>
                        </select>

                            &nbsp;<span class="tip">选择服务区域，让你的客户更有针对性；</span></td>
                    </tr>
                    <tr>
                        <td class="row1"><span class="must">*</span>所属门店：</td>
                        <td colspan="3">
                            <?php if($dataInfo['company_id'] != null): echo ($dataInfo["company_name"]); ?>

                            <?php else: ?>

                            <input id="outlet_first" class="input" name="outlet_first" type="text" size="8" valid="required" errmsg="请填写所属公司!" value="<?php echo ($dataInfo["outlet_first"]); ?>" /><?php endif; ?>
                            &nbsp;-<input id="outlet_last" class="input" name="outlet_last" valid="required" errmsg="请填写所属门店!" type="text" size="7" value="<?php echo ($dataInfo["outlet_last"]); ?>" />&nbsp;<span class="tip">公司简称-门店，例：六度房产-新街口店，或 六度房产-总部</span></td>
                    </tr>
                    <tr>
                        <td class="row1">服务特长：</td>
                        <td colspan="3">

                            <?php if(is_array($specialty_option)): foreach($specialty_option as $key=>$item): if($key == $dataInfo['specialty']): ?><label for="specialty_<?php echo ($key); ?>"><input  type="radio" name="specialty" id="specialty_<?php echo ($key); ?>" value="<?php echo ($key); ?>"  checked /><?php echo ($item); ?> </label>
                            <?php else: ?>
                            <label for="specialty_<?php echo ($key); ?>"><input  type="radio" name="specialty" id="specialty_<?php echo ($key); ?>" value="<?php echo ($key); ?>"  /><?php echo ($item); ?> </label><?php endif; endforeach; endif; ?>

                        </td>
                    </tr>

                    <tr>
                        <td class="row1">公司全称：</td>
                        <td colspan="3"><input id="company" class="input" name="company" type="text" size="25" value="<?php echo ($dataInfo["company"]); ?>" /></td>
                    </tr>

                    <tr>
                        <td class="row1">门店地址：</td>
                        <td colspan="3"><input id="outlet_addr" class="input" name="outlet_addr" type="text" size="25" value="<?php echo ($dataInfo["outlet_addr"]); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="row1">在线QQ：</td>
                        <td colspan="3"><input id="qq" class="input" name="qq" type="text" size="25" value="<?php echo ($dataInfo["qq"]); ?>" />&nbsp;

                            <span class="tip">此QQ会表现在你的网店和房源等信息上</span></td>
                    </tr>
                    <tr>
                        <td class="row1">固定电话：</td>
                        <td colspan="3"><input id="com_tell" class="input" name="com_tell" type="text" size="25" value="<?php echo ($dataInfo["com_tell"]); ?>" />&nbsp;<span class="tip">格式如：<?php echo ($phone); ?></span></td>
                    </tr>

                    <tr>
                        <td class="row1">传&nbsp;&nbsp;&nbsp;&nbsp;真：</td>
                        <td colspan="3"><input id="com_fax" class="input" name="com_fax" type="text" size="25" value="<?php echo ($dataInfo["com_fax"]); ?>" />&nbsp;<span class="tip">格式如：<?php echo ($phone); ?></span></td>
                    </tr>
                    <tr><td colspan="4" class="br"></td></tr>
                    </tbody>
                </table>
                <table class="memberBoxTable" cellpadding="0" cellspacing="5" border="0">
                    <thead>
                    <tr>
                        <td colspan="4"><span class="concentTitle">个人资料 - 让好友了解你！</span></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="row1">性别：</td>
                        <td colspan="3">
                            <?php if($dataInfo['gender'] == 0): ?><input id="gender" name="gender" type="radio" value="0" checked />帅哥&nbsp;<input id="gender" name="gender" value="1" type="radio" />美女<?php endif; ?>
                            <?php if($dataInfo['gender'] == 1): ?><input id="gender" name="gender" value="0" type="radio"/>帅哥&nbsp;<input id="gender" name="gender" value="1" type="radio"  checked />美女<?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="row1">出生日期：</td>
                        <td colspan="3"><input id="birthday" class="input" name="birthday" type="text" size="25" value="<?php echo ($dataInfo["birthday"]); ?>" onClick="WdatePicker()" /></td>
                    </tr>
                    <tr>
                        <td class="row1">现住小区：</td>
                        <td colspan="3"><input type="hidden" id="borough_id" class="input" name="borough_id" size="25" value="<?php echo ($dataInfo["borough_id"]); ?>" /><input id="borough_name" class="input" name="borough_name" type="text" size="25" value="<?php echo ($dataInfo["borough_name"]); ?>" />&nbsp;<span class="tip">例：输入“大名城”或拼音首字母“dmc”，从下拉列表中选择</span></td>
                    </tr>
                    <tr id="borough_addr_tr" style="display:none;">
                        <td class="row1">小区地址：</td>
                        <td colspan="3">
                            <input id="borough_addr" type="text" class="input" name="borough_addr"  size="30" disabled />
                        </td>
                    </tr>
                    <tr>
                        <td class="row1">MSN：</td>
                        <td colspan="3"><input id="msn" class="input" name="msn" type="text" size="25" value="<?php echo ($dataInfo["msn"]); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="row1">个性签名：</td>
                        <td colspan="3"><input id="signed" class="input" name="signed" type="text" size="40" value="<?php echo ($dataInfo["signed"]); ?>" />&nbsp;<span class="tip">如你的座右铭、人生格言等，不超过30个汉字</span></td>
                    </tr>
                    <tr>
                        <td class="row1">自我介绍：</td>
                        <td colspan="3"><span class="tip">&nbsp;不超过200个汉字<br><textarea class="textarea" name="introduce" cols="70" rows="8"><?php echo ($dataInfo["introduce"]); ?></textarea></td>
                    </tr>
                    <tr><td colspan="4" class="br"></td></tr>
                    </tbody>
                </table>
                <div class="submitBtn"><input type="submit" value="确认修改"  /></div>
                <div class="error" style="color: red;text-align: center"></div>
            </form>

        </div>
    </div>

</div>
</body>
</html>