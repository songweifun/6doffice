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
                    <li class="linkOn"><a href="#"><span>预约房源修改</span></a></li>
                </ul>
            </div>
            <div class="manageBox">

                <div class="houseList">
                    <form name="myform" enctype="text/html" action="" method="POST" id="myform">
                        <input type="hidden" name="to_url" value="<?php echo ($to_url); ?>" />
                        <input type="hidden" name="house_id" value="<?php echo ($house["house_id"]); ?>" />
                        <input type="hidden" name="house_title" value="<?php echo ($house["house_title"]); ?>" />
                        <input type="hidden" name="site" value="<?php echo ($site); ?>" />
                        <table border="0" cellpadding="0" cellspacing="1">
                            <input type="hidden" name="appo_house_id[<?php echo ($item["id"]); ?>]" value="<?php echo ($item["id"]); ?>" />
                            <tbody>
                            <tr>
                                <td colspan="2">您的房源<span style=" color:#E55600;"><b>[<?php echo ($house["house_title"]); ?>]</b></span>已设置的预约刷新时间</td>
                            </tr>
                            <?php $var = '1'; ?>
                            <?php if(is_array($house["update_limit"])): foreach($house["update_limit"] as $limit_id=>$limit): if($var != 1): ?><tbody id="limit<?php echo ($limit_id); ?>" name="limit" style="display:none">
                                    <?php if(is_array($house["update"]["{$limit_id}"])): foreach($house["update"]["{$limit_id}"] as $keys=>$item): ?><tr>
                                        <td>
                                            <?php echo ($item["day"]); ?>&nbsp;
                                            <select name="appo_hours[<?php echo ($limit_id); ?>][<?php echo ($keys); ?>]">
                                                <option>---</option>
                                                <?php if(is_array($hour)): foreach($hour as $key=>$hours): if($hours == $item['hour']): ?><option value="<?php echo ($hours); ?>" selected="selected" ><?php echo ($hours); ?></option>
                                                    <?php else: ?>
                                                        <option value="<?php echo ($hours); ?>"><?php echo ($hours); ?></option><?php endif; endforeach; endif; ?>
                                            </select>
                                            点
                                            <select name="appo_minute[<?php echo ($limit_id); ?>][<?php echo ($keys); ?>]">
                                                <option>---</option>
                                                <?php if(is_array($minute)): foreach($minute as $key=>$minutes): if($minutes == $item['minute']): ?><option value="<?php echo ($minutes); ?>" selected="selected"><?php echo ($minutes); ?></option>
                                                    <?php else: ?>
                                                        <option value="<?php echo ($minutes); ?>"><?php echo ($minutes); ?></option><?php endif; endforeach; endif; ?>
                                            </select>
                                            分
                                        </td>
                                        <td></td>
                                    </tr>
                                        <?php $var++; endforeach; endif; ?>
                                    </tbody>
                            <?php else: ?>
                                    <tbody id="limit<?php echo ($limit_id); ?>" name="limit">
                                    <?php if(is_array($house["update"]["{$limit_id}"])): foreach($house["update"]["{$limit_id}"] as $keys=>$item): ?><tr>
                                            <td>
                                                <?php echo ($item["day"]); ?>&nbsp;
                                                <select name="appo_hours[<?php echo ($limit_id); ?>][<?php echo ($keys); ?>]">
                                                    <option>---</option>
                                                    <?php if(is_array($hour)): foreach($hour as $key=>$hours): if($hours == $item['hour']): ?><option value="<?php echo ($hours); ?>" selected="selected" ><?php echo ($hours); ?></option>
                                                            <?php else: ?>
                                                            <option value="<?php echo ($hours); ?>"><?php echo ($hours); ?></option><?php endif; endforeach; endif; ?>
                                                </select>
                                                点
                                                <select name="appo_minute[<?php echo ($limit_id); ?>][<?php echo ($keys); ?>]">
                                                    <option>---</option>
                                                    <?php if(is_array($minute)): foreach($minute as $key=>$minutes): if($minutes == $item['minute']): ?><option value="<?php echo ($minutes); ?>" selected="selected"><?php echo ($minutes); ?></option>
                                                            <?php else: ?>
                                                            <option value="<?php echo ($minutes); ?>"><?php echo ($minutes); ?></option><?php endif; endforeach; endif; ?>
                                                </select>
                                                分
                                            </td>
                                            <td></td>
                                        </tr>
                                        <?php $var++; endforeach; endif; ?>
                                    </tbody><?php endif; endforeach; endif; ?>


                            <tr>
                                <td colspan="2">
                                    查看已经预约的日期
                                    <select name="appo_date" onchange="showUpdate(this);" onfocus="showLimit(this)">
                                        <?php if(is_array($house["update_limit"])): foreach($house["update_limit"] as $limit_id=>$limit): ?><option value="<?php echo ($limit_id); ?>" ><?php echo ($limit); ?></option><?php endforeach; endif; ?>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div style="width:100%;margin-top:5px;text-align: center;"><input class="listOperationBtn" style="width:100px;" type="button"  value="修改"  /></div>
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
        $('#myform').attr('action','<?php echo U(MODULE_NAME."/Appointment/index");?>/action/editAppo/site/rent');
        $('#myform').submit();

    })

    function showBox(item_id){
        TB_show('房源成交','rentBargain.php?house_id='+item_id+'&height=370&width=400&modal=true&rnd='+Math.random(),false);
    }
    function showBoxOwner(item_id){
        TB_show('业主信息','landlordRentInfo.php?house_id='+item_id+'&height=150&width=400&modal=true&rnd='+Math.random(),false);
    }
    function showBoxtop(item_id){
        TB_show('房源置顶','rentTop.php?house_id='+item_id+'&height=200&width=400&modal=true&rnd='+Math.random(),false);
    }
    function showBoxnum(){
        TB_show('购买条数','rentNum.php?height=200&width=400&modal=true&rnd='+Math.random(),false);
    }

    var limit_close = '';
    function showLimit(MyClick){
        if(!limit_close){
            limit_close = MyClick.value;
        }
    }
    function showUpdate(MyClick){
        if(limit_close)	{
            document.getElementById('limit'+limit_close).style.display = "none";
        }
        limit_close = MyClick.value;
        document.getElementById('limit'+MyClick.value).style.display = "";
    }
</script>
<script src="/6doffice/Public/js/My97DatePicker/WdatePicker.js" language="javascript"></script>
</body>
</html>