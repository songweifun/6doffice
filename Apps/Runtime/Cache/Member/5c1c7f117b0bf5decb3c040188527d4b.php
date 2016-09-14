<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>预约刷新管理</title>
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
                            <a href="<?php echo U(MODULE_NAME.'/Housesell/addsell');?>">发布出售</a><br />
                            <a href="../member/houseRent.php">发布出租</a><br />
                            <a href="<?php echo U(MODULE_NAME.'/Housesell/index');?>">出售管理</a><br />
                            <a href="../member/manageRent.php">出租管理</a></li>
                    </ul>

                </li><br />

                <li class="item">
                    <p>店铺管理</p>
                    <ul>
                        <li>
                            <a href="../member/shopProfile.php">店铺资料</a><br />
                            <a href="../member/shopSaleRec.php">店铺推荐</a><br />
                            <a href="../member/shopStyle.php">店铺风格</a><br />

                        </li>
                    </ul>

                </li>
                <br />

                <li class="item">
                    <p>人脉管理</p>
                    <ul>
                        <li>
                            <a href="../member/snsFriends.php">我的好友</a><br />
                            <a href="../member/snsLinkIn.php">谁来看过我</a><br />
                            <a href="../member/snsInviteIn.php">好友邀请</a><br />

                        </li>
                    </ul>

                </li>
                <br />

                <li class="item">
                    <p>站内信</p>
                    <ul>
                        <li>
                            <a href="../member/msgWrite.php">撰写信件</a><br />
                            <a href="../member/msgInbox.php">收件箱</a><br />
                            <a href="../member/msgSend.php">已发信件</a><br />
                            <a href="../member/msgGarbage.php">垃圾箱</a><br />

                        </li>
                    </ul>

                </li>
                <br />

                <li class="item">
                    <p>资料管理</p>
                    <ul>
                        <li>
                            <a href="../member/brokerProfile.php">修改资料</a><br />
                            <a href="../member/brokerIdentity.php">实名认证</a><br />
                            <a href="../member/brokerPhoto.php">修改头像</a><br />
                            <a href="../member/pwdEdit.php">修改密码</a><br />
                            <a href="../member/brokerAptitude.php">执业认证</a><br />
                        </li>
                    </ul>

                </li>
            </ul>
            <div class="endLeft"></div>
        </div>
        <div class="memberBox">
            <div class="memberBoxTab">
                <ul>
                    <li><a href="#" class="linkOn"><span>预约刷新</span></a></li>
                </ul>
            </div>
            <div class="manageSub">
                <ul class="manageSubNav">
                    <li class="linkOn"><a href="#"><span>预约房源</span></a></li>
                </ul>
            </div>
            <div class="manageBox">

                <div class="houseList">
                    <form name="myform" enctype="text/html" action="" method="POST" id="myform">
                        <input type="hidden" name="to_url" value="<?php echo ($to_url); ?>" />
                        <?php if(is_array($house)): foreach($house as $key=>$item): ?><table border="0" cellpadding="0" cellspacing="1">
                            <input type="hidden" name="appo_house_id[<?php echo ($item["id"]); ?>]" value="<?php echo ($item["id"]); ?>" />
                            <input type="hidden" name="appo_house_title[<?php echo ($item["id"]); ?>]" value="<?php echo ($item["house_title"]); ?>" />
                            <input type="hidden" name="site" value="<?php echo ($site); ?>" />
                            <tbody>
                            <tr>
                                <td colspan="2">本次预约的房源为<span style=" color:#E55600;"><b>[<?php echo ($item["house_title"]); ?>]</b></span></td>
                            </tr>
                            <tr>
                                <td colspan="2">第一次刷新
                                    <select name="appo_hours[<?php echo ($item["id"]); ?>][]">
                                    <option>---</option>
                                    <?php if(is_array($hour)): foreach($hour as $key=>$hours): ?><option value="<?php echo ($hours); ?>"><?php echo ($hours); ?></option><?php endforeach; endif; ?>
                                </select>
                                    点
                                    <select name="appo_minute[<?php echo ($item["id"]); ?>][]">
                                        <option>---</option>
                                        <?php if(is_array($minute)): foreach($minute as $key=>$minutes): ?><option value="<?php echo ($minutes); ?>"><?php echo ($minutes); ?></option><?php endforeach; endif; ?>
                                    </select>
                                    分
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">第二次刷新
                                    <select name="appo_hours[<?php echo ($item["id"]); ?>][]">
                                        <option>---</option>
                                        <?php if(is_array($hour)): foreach($hour as $key=>$hours): ?><option value="<?php echo ($hours); ?>"><?php echo ($hours); ?></option><?php endforeach; endif; ?>
                                    </select>
                                    点
                                    <select name="appo_minute[<?php echo ($item["id"]); ?>][]">
                                        <option>---</option>
                                        <?php if(is_array($minute)): foreach($minute as $key=>$minutes): ?><option value="<?php echo ($minutes); ?>"><?php echo ($minutes); ?></option><?php endforeach; endif; ?>
                                    </select>
                                    分
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">第三次刷新
                                    <select name="appo_hours[<?php echo ($item["id"]); ?>][]">
                                        <option>---</option>
                                        <?php if(is_array($hour)): foreach($hour as $key=>$hours): ?><option value="<?php echo ($hours); ?>"><?php echo ($hours); ?></option><?php endforeach; endif; ?>
                                    </select>
                                    点
                                    <select name="appo_minute[<?php echo ($item["id"]); ?>][]">
                                        <option>---</option>
                                        <?php if(is_array($minute)): foreach($minute as $key=>$minutes): ?><option value="<?php echo ($minutes); ?>"><?php echo ($minutes); ?></option><?php endforeach; endif; ?>
                                    </select>
                                    分
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">第四次刷新
                                    <select name="appo_hours[<?php echo ($item["id"]); ?>][]">
                                        <option>---</option>
                                        <?php if(is_array($hour)): foreach($hour as $key=>$hours): ?><option value="<?php echo ($hours); ?>"><?php echo ($hours); ?></option><?php endforeach; endif; ?>
                                    </select>
                                    点
                                    <select name="appo_minute[<?php echo ($item["id"]); ?>][]">
                                        <option>---</option>
                                        <?php if(is_array($minute)): foreach($minute as $key=>$minutes): ?><option value="<?php echo ($minutes); ?>"><?php echo ($minutes); ?></option><?php endforeach; endif; ?>
                                    </select>
                                    分
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">第五次刷新
                                    <select name="appo_hours[<?php echo ($item["id"]); ?>][]">
                                        <option>---</option>
                                        <?php if(is_array($hour)): foreach($hour as $key=>$hours): ?><option value="<?php echo ($hours); ?>"><?php echo ($hours); ?></option><?php endforeach; endif; ?>
                                    </select>
                                    点
                                    <select name="appo_minute[<?php echo ($item["id"]); ?>][]">
                                        <option>---</option>
                                        <?php if(is_array($minute)): foreach($minute as $key=>$minutes): ?><option value="<?php echo ($minutes); ?>"><?php echo ($minutes); ?></option><?php endforeach; endif; ?>
                                    </select>
                                    分
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    选择天数
                                    <select name="appo_date[<?php echo ($item["id"]); ?>]">
                                        <?php if(is_array($date)): foreach($date as $key=>$item): ?><option value="<?php echo ($key); ?>"><?php echo ($item); ?></option><?php endforeach; endif; ?>
                                    </select>&nbsp;按以上设置自动刷新
                                </td>
                            </tr>
                            </tbody>
                        </table><?php endforeach; endif; ?>
                        <div style="width:100%;margin-top:5px;text-align: center;"><input class="listOperationBtn" style="width:100px;" type="button"  value="提交" /></div>
                    </form>
                </div>

            </div>
            <div class="note">
                <p><a name="notice" id="notice"></a>预约刷新必读：</p>
                <ul>
                    <li>系统将根据每日可刷新的次数执行。如果刷新条数超过系统可刷新的条数，则跳过该房源的预约刷新。</li>
                    <li>本日的操作的预约时间将到当天的时间才执行。</li>
                    <li>如果预约的时间点操作系统设置每个时间点最多的刷新次数，则该房源预约的时间将会自动转到一个次数较少的时间。</li>
                    <li>如果预约的时间已经落后现在的时间，则预约时间会根据现在的小时数增加30分钟到60分钟不等。</li>
                    <li>预约时间的天数由系统设置。</li>
                    <li>如果预约的时间没有选择则自动跳过该时间段或删除该时间段。</li>
                </ul>
            </div>
        </div>
    </div>

</div>
<script language="javascript">
    $('.listOperationBtn').click(function(){
        $('#myform').attr('action','<?php echo U(MODULE_NAME."/Appointment/index");?>/action/submitAppo/site/rent');
        $('#myform').submit();

    })


</script>
<script src="/6doffice/Public/js/My97DatePicker/WdatePicker.js" language="javascript"></script>
</body>
</html>