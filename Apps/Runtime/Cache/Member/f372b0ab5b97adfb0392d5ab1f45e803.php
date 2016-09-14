<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($title); ?> - 房源管理</title>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>

    <script type="text/javascript" src="/6doffice/Public/js/thickbox.js"></script>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/thickbox.css" />
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
                    <a href="shopProfile.php">店铺资料</a><br />
                    <a href="shopDiy.php">店铺DIY</a><br />
                    <a href="shopSaleRec.php">店铺推荐</a><br />
                    <a target="_blank" href="<?php echo ($cfg["url"]); ?>shop/evaluate.php?id=<?php echo ($member_id); ?>">服务评价</a><br />
                </li>
            </ul>

        </li>
        <br />

        <li class="item">
            <p>人脉管理</p>
            <ul>
                <li>
                    <a href="snsFriends.php">我的好友</a><br />
                    <a href="snsLinkIn.php">谁来看过我</a><br />
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
                    <li><a href="houseRent.php"><span>发布出租</span></a></li>
                    <li><a href="#" class="linkOn"><span>出售管理</span></a></li>
                    <li><a href="manageRent.php"><span>出租管理</span></a></li>
                </ul>
            </div>
            <div class="manageSub">
                <ul class="manageSubNav">
                    <li><a href="<?php echo U(MODULE_NAME.'/HouseSell/index');?>"><span>出售中</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageSell/sellTopDone');?>"><span>置顶中</span></a></li>
                    <li class="linkOn"><a href="#"><span>回收站</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/ManageSell/sellDone');?>"><span>成交榜</span></a></li>
                </ul>
            </div>
            <div class="manageBox">
                <div class="houseSearch">
                    <form name="searchForm" action="" method="GET">
                        是否过期：<select class="select" name="status">
                        <option value="">不限</option>
                        <option value="2" <?php if($_GET['status']== 2): ?>selected<?php endif; ?>>未过期</option>
                        <option value="3" <?php if($_GET['status']== 3): ?>selected<?php endif; ?>>已过期</option>
                    </select>&nbsp;
                        <input class="input" name="q" type="text" size="30" value="<?php if($q != null): echo ($q); else: ?>输入房源编号或小区名称<?php endif; ?>" onblur="if(this.value ==''||this.value == '输入房源编号或小区名称'){this.value = '输入房源编号或小区名称';}" onfocus="if(this.value == '输入房源编号或小区名称'){this.value = '';}" />&nbsp;<input type="button" value="搜 索"  onclick="javascript:document.searchForm.submit();"  />&nbsp;<a href="#notice">回收站管理必读</a>
                    </form>
                </div>
                <div class="houseList">
                    <table border="0" cellpadding="0" cellspacing="1">
                        <thead class="tableTitle">
                        <tr>
                            <td colspan="6">房源基本信息</td>
                            <td>点击统计</td>
                            <td>下架时间</td>
                            <td>操作</td>
                        </tr>
                        </thead>
                        <form name="myform" action="" method="POST">
                            <input type="hidden" name="to_url" value="<?php echo ($to_url); ?>">
                            <thead class="tableSubTitle">
                            <tr>
                                <td width="13%">房源编号</td>
                                <td width="20%">小区名称</td>
                                <td width="10%">户型</td>
                                <td width="8%">面积</td>
                                <td width="8%">售价</td>
                                <td width="10%">发布时间</td>
                                <td width="10%">总计</td>
                                <td width="10%">&nbsp;</td>
                                <td width="9%">&nbsp;</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($dataList)): foreach($dataList as $key=>$item): ?><tr>
                                <td><input type="checkbox" name="ids[]" value="<?php echo ($item["id"]); ?>" />&nbsp;<a href="<?php echo ($cfg["url_sale"]); ?>d-<?php echo ($item["id"]); ?>.html" title="查看房源详细信息" target="_blank"><?php echo ($item["house_no"]); ?></a></td>
                                <td><?php echo ($item["borough_name"]); ?></td>
                                <td><?php echo ($item["house_room"]); ?>-<?php echo ($item["house_hall"]); ?>-<?php echo ($item["house_toilet"]); ?>-<?php echo ($item["house_veranda"]); ?></td>
                                <td><?php echo ($item["house_totalarea"]); ?>㎡</td>
                                <td class="f90"><?php if($item["house_price"] == 0): ?>面议<?php else: echo ($item["house_price"]); ?>万<?php endif; ?></td>
                                <td><?php echo (date('Y-m-d',$item["created"])); ?></td>
                                <td><?php echo ($item["click_num"]); ?></td>
                                <td><?php if($item["house_downtime"] != null): echo (date('Y-m-d',$item["house_downtime"])); else: ?>&nbsp;<?php endif; ?></td>
                                <td><?php if($item["status"] == 2): ?><a href="<?php echo U(MODULE_NAME.'/ManageSell/added');?>/id/<?php echo ($item["id"]); ?>" title="重新上架房源">上架</a><?php else: ?>已过期<?php endif; ?></td>
                            </tr><?php endforeach; endif; ?>
                            <tr>
                                <td colspan="9" class="listOperation">
                                    <label for="checkBoxAll"><input type="checkbox" id="checkBoxAll" name="checkBoxAll" value="1" onclick="checkAll(this);" />全选</label>
                                    <input id="listOperationBtn" class="listOperationBtn" type="button" value="彻底删除选中的房源" />
                                </td>
                            </tr>
                            </tbody>
                        </form>
                    </table>
                    <?php echo ($pagePanel); ?>
                </div>
            </div>
            <div class="note">
                <p><a name="notice" id="notice"></a>回收站管理必读：</p>
                <ul>
                    <li>回收站内的房源均不对外展示；</li>
                    <li>超过有效期(90天)的房源，不可再上架，请删除；</li>
                    <li>有效期内的房源，点击“上架”后可重新对外展示；</li>
                    <li>选择“是否过期”并搜索，可对已过期和未过期房源进行分别显示；</li>
                    <li>回收站中不提供批量上架功能，请经纪人逐一核实房源的有效性，逐条上架。无效房源请删除；</li>
                    <li>回收站中进行“删除”操作，将彻底删除房源不可回收；</li>
                </ul>
            </div>
        </div>
    </div>

</div>
<script language="javascript">
    $('#listOperationBtn').click(function(){
        if(confirm('你确定彻底删除选中的房源么？')){
            myform.action='<?php echo U(MODULE_NAME."/ManageSell/delete");?>';
            document.myform.submit();}

    })
    function checkAll(formObj){
        if(formObj.checked){
            $('input[type=checkbox]').prop('checked', true);
        }else{
            $('input[type=checkbox]').prop('checked', false);
        }
    }
</script>
</body>
</html>