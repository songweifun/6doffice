<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title><?php echo ($title); ?> - 成交房源管理</title>
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
                    <a href="snsInviteIn.php">好友邀请</a><br />

                </li>
            </ul>

        </li>
        <br />

        <li class="item">
            <p>站内信</p>
            <ul>
                <li>
                    <a href="msgWrite.php">撰写信件</a><br />
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
            <div class="memberBoxTab">
                <ul>
                    <li><a href="<?php echo U(MODULE_NAME.'/Housesell/addSell');?>"><span>发布出售</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/HouseRent/addRent');?>"><span>发布出租</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/Housesell/index');?>"><span>出售管理</span></a></li>
                    <li><a href="#" class="linkOn"><span>出租管理</span></a></li>
                </ul>
            </div>
            <div class="manageSub">
                <ul class="manageSubNav">
                    <li><a href="<?php echo U(MODULE_NAME.'/HouseSell/index');?>"><span>出售中</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageSell/sellTopDone');?>"><span>置顶中</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageSell/recycle');?>"><span>回收站</span></a></li>
                    <li class="linkOn"><a href="#"><span>成交榜</span></a></li>
                </ul>
            </div>
            <div class="manageBox">
                <div class="houseSearch">
                    <form name="searchForm" action="" method="GET">
                        成交时间：<input class="input" id="from_date" name="from_date" type="text" size="10" value="<?php echo ($smarty["get"]["from_date"]); ?>" onclick="WdatePicker({maxDate:'#F{$dp.$D(\'to_date\')}',skin:'whyGreen'})" /> - <input class="input" id="to_date"  name="to_date" type="text" size="10" value="<?php echo ($smarty["get"]["to_date"]); ?>" onClick="WdatePicker({minDate:'#F{$dp.$D(\'from_date\')}',skin:'whyGreen'})" />&nbsp;
                        交易来源：<select class="select" name="bargain_from">
                        <option value="">不限</option>
                        <?php if(is_array($bargain_from_option)): foreach($bargain_from_option as $key=>$v): if($key == $Think.get.bargain_from): ?><option value="<?php echo ($key); ?>" selected><?php echo ($v); ?></option>
                                <?php else: ?>
                                <option value="<?php echo ($key); ?>"><?php echo ($v); ?></option><?php endif; endforeach; endif; ?>
                    </select>&nbsp;
                        <input class="input" name="q" type="text" size="36" value="<?php if($q != null): echo ($q); else: ?>输入小区名，或租客/房东信息，或备注信息<?php endif; ?>" onblur="if(this.value ==''||this.value == '输入小区名，或租客/房东信息，或备注信息'){this.value = '输入小区名，或租客/房东信息，或备注信息';}" onfocus="if(this.value == '输入小区名，或租客/房东信息，或备注信息'){this.value = '';}" />
                        <input type="button" value="查询"  onclick="javascript:document.searchForm.submit();"  />
                    </form>
                </div>
                <div class="houseList">
                    <table border="0" cellpadding="0" cellspacing="1">
                        <thead class="tableTitle">
                        <tr>
                            <td colspan="3">房源基本信息</td>
                            <td colspan="7">成交信息</td>
                            <td>操作</td>
                        </tr>
                        </thead>
                        <thead class="tableSubTitle">
                        <tr>
                            <td width="17%">小区名称</td>
                            <td width="7%">面积</td>
                            <td width="7%">租金</td>
                            <td width="11%">交易来源</td>
                            <td width="7%">租客</td>
                            <td width="10%">租客电话</td>
                            <td width="7%">房东</td>
                            <td width="10%">房东电话</td>
                            <td width="7%">成交租金</td>
                            <td width="9%">成交时间</td>
                            <td width="8%">&nbsp;</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($dataList)): foreach($dataList as $key=>$item): ?><tr>
                            <td><?php if($item['house_id'] != null): ?><a href="<?php echo ($cfg["url_sale"]); ?>d-<?php echo ($item["house_id"]); ?>.html" target="_blank"><?php echo ($item["borough_name"]); ?></a><?php else: echo ($item["borough_name"]); endif; ?></td>
                            <td><?php echo ($item["house_totalarea"]); ?>㎡</td>
                            <td class="f90"><?php if($item['house_price'] == 0): ?>面议<?php else: echo ($item["house_price"]); ?>元<?php endif; ?></td>
                            <td><?php echo ($item["bargain_from"]); ?></td>
                            <td><?php echo ($item["buyer"]); ?></td>
                            <td><?php echo ($item["buyer_tel"]); ?></td>
                            <td><?php echo ($item["saler"]); ?></td>
                            <td><?php echo ($item["saler_tel"]); ?></td>
                            <td class="f90"><?php echo ($item["bargain_price"]); ?>元</td>
                            <td><?php echo (date('Y-m-d',$item["bargain_time"])); ?></td>
                            <td>
                                <a href="?action=edit&id=<?php echo ($item["id"]); ?>" title="编辑成交信息" onclick="showBox(<?php echo ($item["id"]); ?>);return false;">编辑</a>
                                <?php if($item['remark'] != null): ?><a href="?action=remark&id=<?php echo ($item["id"]); ?>" title="备注" onclick="showRemark(<?php echo ($item["id"]); ?>);return false;"><img src="/6doffice/Public/images/saleDoneNote.gif" /></a>
                                    <?php else: ?>
                                    <a href="?action=remark&id=<?php echo ($item["id"]); ?>" title="添加备注" onclick="showRemark(<?php echo ($item["id"]); ?>);return false;"><img src="/6doffice/Public/images/saleDoneUnnote.gif" /></a><?php endif; ?>
                            </td>
                        </tr><?php endforeach; endif; ?>
                        <tr>
                            <td colspan="11" class="listOperation">
                                <input class="listOperationBtn" type="button" value="添加交易记录" onclick="showBox(0);return false;" />
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?php echo ($pagePanel); ?>
                </div>
            </div>
            <div class="note">
                <p><a name="notice" id="notice"></a>成交榜管理必读：</p>
                <ul>
                    <li>“成交榜”提供经纪人管理日常交易业绩及客户资料，仅供本人查看；</li>
                    <li>“交易查询”可对历史交易进行时间分类查询、交易来源分类查询，还可针对小区名，买/卖方姓名或电话，或备注信息进行搜索；</li>
                    <li>交易来源，即交易双方是来自 <?php echo ($cfg["page"]["title"]); ?>还是来自 <?php echo ($cfg["page"]["title"]); ?>以外的线下渠道；</li>
                    <li>点击“小区名称”链接浏览历史成交房源详细信息；</li>
                    <li>通过“编辑”可对交易记录错误信息进行修正；</li>
                    <li><img src="/6doffice/Public/images/saleDoneUnnote.gif" />表示无备注，点击可添加备注；<img src="/6doffice/Public/images/saleDoneNote.gif" />表示有备注，点击可修改备注；</li>
                    <li>通过“添加交易记录”可以直接增加个人通过其它渠道成交的交易记录；</li>
                </ul>
            </div>
        </div>
    </div>

</div>
<script language="javascript">
    function showBox(item_id){
        var url='<?php echo U(MODULE_NAME."/ManageRent/rentBargain");?>/id/'+item_id
        layer.open({
            type: 2,
            title: ['房源成交', ''],
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['400px' , '370px'],
            content: url,
            scrollbar: false,
        });

    }
    function showRemark(item_id){
        var url='<?php echo U(MODULE_NAME."/ManageRent/remark");?>/id/'+item_id

        layer.open({
            type: 2,
            title: ['房源备注', ''],
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['400px' , '300px'],
            content: url,
        });

    }
</script>
<script src="/6doffice/Public/js/My97DatePicker/WdatePicker.js" language="javascript"></script>
</body>
</html>