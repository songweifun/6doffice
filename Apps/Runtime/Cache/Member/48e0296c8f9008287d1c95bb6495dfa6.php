<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ($title); ?> - 添加/编辑房源</title>
    <script>
        var hosesellajaxurl="<?php echo U(MODULE_NAME.'/HouseSell/ajax');?>"
        var imagefooturl='/6doffice/Uploads/'
        var addBoroughurl="<?php echo U(MODULE_NAME.'/HouseSell/addBorough');?>"
    </script>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>

    <!-- vlidate -->
    <script type="text/javascript" src="/6doffice/Public/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/messages_zh.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/member/addrent_formcheck.js"></script>
    <!-- ui autocomplete -->
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/js/uiautocomplete/jquery-ui.css" />
    <script type="text/javascript" src="/6doffice/Public/js/uiautocomplete/jquery-ui.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/member/addrent_autocomplete.js"></script>
    <!-- layer model -->
    <script type="text/javascript" src="/6doffice/Public/js/layer/layer.js"></script>



    <!-- ueditor -->
    <!-- 配置文件 -->
    <script type="text/javascript" src="/6doffice/Data/Ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/6doffice/Data/Ueditor/ueditor.all.js"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        $(function(){
            var serverUrl="<?php echo U(MODULE_NAME.'/HouseRent/ueditorUpload');?>"
            //var url =getUEBasePath();
            //alert(serverUrl)
            var ue = UE.getEditor('content',{
                initialFrameWidth:'100%',  //初始化编辑器宽度,默认1000
                initialFrameHeight:220,  //初始化编辑器高度,默认320
                textarea:'house_desc',
                //是否启用元素路径，默认是显示
                elementPathEnabled : false
                ,maximumWords:1000       //允许的最大字符数
                //是否保持toolbar的位置不动,默认true
                ,autoFloatEnabled:false
                //工具栏上的所有的功能按钮和下拉框，可以在new编辑器的实例时选择自己需要的重新定义
                , toolbars: [[
                    'fullscreen', 'source', '|', 'undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
                    'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                    'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                    'directionalityltr', 'directionalityrtl', 'indent', '|',
                    'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                    'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                    'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|',
                    'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
                    'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
                    'print', 'preview', 'searchreplace', 'drafts', 'help'
                ]]
                ,serverUrl: serverUrl


            });

        })
    </script>


    <script type="text/javascript">


        function addToBoroughItem(bid,bname,b_addr){
            $("#borough_id").val(bid);
            $("#borough_name").val(bname);
            $("#borough_addr").val(b_addr);
            $("#borough_addr_tr").css("display","");
        }

        function checkBoxNum(){
            var form = document.forms['dataForm'];
            var i,j=0;
            for (i=0; i<form.length; i++){
                var e=form[i];
                if (e.checked && e.type=='checkbox' && e.name=='house_feature[]') {
                    j++;
                    if(j==5){
                        alert("房源特色最多只能选择4项！");
                        return false;
                        break;
                    }
                }
            }
        }
        function mianyi(){
            $("#h_price").val("0");
            $("#h_priceInfo").html("");
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
                    <li><a href="<?php echo U(MODULE_NAME.'/HouseSell/addSell');?>"><span>发布出售</span></a></li>
                    <li><a href="#" class="linkOn"><span>发布出租</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/HouseSell/index');?>"><span>出售管理</span></a></li>
                    <li><a href="<?php echo U(MODULE_NAME.'/HouseRent/index');?>"><span>出租管理</span></a></li>
                </ul>
            </div>
            <?php if($memberInfo["mobile"] == null): ?><div class="bigNote" id="bigNote">
                <div class="noteTxt">在完善<a href="brokerProfile.php">从业资料</a>前，您所发布的房源暂时无法对外展示！
                </div>
                <div class="closeNote">
                    <a href="javascript:;" onclick="document.getElementById('bigNote').style.display='none'" title="关闭提示"><img src="/6doffice/Public/images/closeNote.gif" title="关闭提示" /></a>
                </div>
            </div><?php endif; ?>
            <form id="dataForm" name="dataForm" action="<?php echo U(MODULE_NAME.'/HouseRent/save');?>" method="POST" onsubmit="return checkForm(this)">
                <input type="hidden" name="id" value="<?php echo ($dataInfo["id"]); ?>">
                <input type="hidden" name="cid" value="<?php echo ($_GET['cid']); ?>">
                <input type="hidden" name="to_url" value="<?php echo ($to_url); ?>">
                <table class="memberBoxTable" cellpadding="0" cellspacing="5" border="0">
                    <thead>
                    <tr>
                        <td colspan="4"><span class="concentTitle">第一步：房源基本信息（必填项）</span></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="row1">房源标题：</td>
                        <td colspan="3">
                            <input class="input" name="house_title" type="text" size="30" value="<?php echo ($dataInfo["house_title"]); ?>"  valid="required" errmsg="请输入房源标题!"  />&nbsp;
                            <span class="tip">好的标题能有效提升房源点击率，最多20个汉字</span>
                            <p id="errMsg_house_title" class="errorMessage" ></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="row1">房屋类型：</td>
                        <td colspan="3">
                            <?php if(is_array($house_type_option)): foreach($house_type_option as $key=>$item): if($key == $dataInfo["house_type"]): ?><label for="house_type_<?php echo ($key); ?>"><input  type="radio" name="house_type" id="house_type_<?php echo ($key); ?>" value="<?php echo ($key); ?>" valid="requireChecked" errmsg="请选择房源类型!" checked /><?php echo ($item); ?> </label>
                            <?php else: ?>
                            <label for="house_type_<?php echo ($key); ?>"><input  type="radio" name="house_type" id="house_type_<?php echo ($key); ?>" value="<?php echo ($key); ?>" valid="requireChecked" errmsg="请选择房源类型!" /><?php echo ($item); ?> </label><?php endif; endforeach; endif; ?>
                            <p id="errMsg_house_type" class="errorMessage"></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="row1">小区名称：</td>
                        <td colspan="3">
                            <input type="hidden" id="borough_id" name="borough_id" value="<?php echo ($dataInfo["borough_id"]); ?>" >
                            <input id="borough_name" class="input" name="borough_name" type="text" size="30" value="<?php echo ($dataInfo["borough_name"]); ?>"  errmsg="请输入小区名称!" />
                            <span class="tip">例：输入“大名城”或拼音首字母“dmc”，从下拉列表中选择</span>
                            <p id="errMsg_borough_name" class="errorMessage" display="none"></p>
                        </td>
                    </tr>
                    <tr id="borough_addr_tr" style="display:none;">
                        <td class="row1">小区地址：</td>
                        <td colspan="3"><input id="borough_addr" type="text" class="input" name="borough_addr"  size="30" value="<?php echo ($dataInfo["borough_addrest"]); ?>" disabled /></td>
                    </tr>

                    <tr>
                        <td class="row1">楼&nbsp;&nbsp;&nbsp;&nbsp;层：</td>
                        <td colspan="3">
                            第<input class="input" name="house_floor" type="text" size="1" value="<?php echo ($dataInfo["house_floor"]); ?>"  valid="required|isInt" errmsg="请输入所在楼层!|请输入整数！"  /> 层 /
                            共<input class="input" name="house_topfloor" type="text" size="1" value="<?php echo ($dataInfo["house_topfloor"]); ?>" valid="required|isInt" errmsg="请输入楼层总数!|请输入整数！" /> 层
                            <p id="errMsg_house_floor" class="errorMessage" display="none"></p><p id="errMsg_house_topfloor" class="errorMessage" display="none"></p>
                        </td>
                    </tr>

                    <tr>
                        <td class="row1">户&nbsp;&nbsp;&nbsp;&nbsp;型：</td>
                        <td colspan="3">
                            <select class="select" name="house_room">
                                <?php $__FOR_START_850203926__=1;$__FOR_END_850203926__=5;for($i=$__FOR_START_850203926__;$i < $__FOR_END_850203926__;$i+=1){ if($i == $dataInfo["house_room"]): ?><option value="<?php echo ($i); ?>" selected><?php echo ($i); ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo ($i); ?>"><?php echo ($i); ?></option><?php endif; } ?>
                                <?php if($dataInfo['house_room'] > 5): ?><option value="6" selected>5室以上</option>
                                    <?php else: ?>
                                    <option value="6">5室以上</option><?php endif; ?>
                            </select> 室
                            <select class="select" name="house_hall">
                                <?php $__FOR_START_1454427163__=1;$__FOR_END_1454427163__=6;for($i=$__FOR_START_1454427163__;$i < $__FOR_END_1454427163__;$i+=1){ if($i == $dataInfo["house_hall"]): ?><option value="<?php echo ($i); ?>" selected><?php echo ($i); ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo ($i); ?>"><?php echo ($i); ?></option><?php endif; } ?>
                            </select> 厅
                            <select class="select" name="house_toilet">
                                <?php $__FOR_START_914977187__=1;$__FOR_END_914977187__=6;for($i=$__FOR_START_914977187__;$i < $__FOR_END_914977187__;$i+=1){ if($i == $dataInfo["house_toilet"]): ?><option value="<?php echo ($i); ?>" selected><?php echo ($i); ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo ($i); ?>"><?php echo ($i); ?></option><?php endif; } ?>
                            </select> 卫
                            <select class="select" name="house_veranda">
                                <?php $__FOR_START_2106479417__=1;$__FOR_END_2106479417__=6;for($i=$__FOR_START_2106479417__;$i < $__FOR_END_2106479417__;$i+=1){ if($i == $dataInfo["house_veranda"]): ?><option value="<?php echo ($i); ?>" selected><?php echo ($i); ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo ($i); ?>"><?php echo ($i); ?></option><?php endif; } ?>
                            </select> 阳&nbsp;<span class="tip">如果户型超过五室请在“房源描述”里进行说明</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="row1">租&nbsp;&nbsp;&nbsp;&nbsp;金：</td>
                        <td colspan="3">
                            <input id="h_price" class="input" name="house_price" type="text" size="10" value="<?php echo ($dataInfo["house_price"]); ?>"  valid="required|isNumber" errmsg="请输入租金!|请输入数字！"  />&nbsp;元/月
                            <p id="errMsg_house_price" class="errorMessage" display="none"></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="row1">付款方式：</td>
                        <td colspan="3">


                            <select class="select" name="house_deposit" valid="required" errmsg="请选择付款方式！">
                                <option value="">请选择</option>
                                <?php if(is_array($rent_deposittype_option)): foreach($rent_deposittype_option as $key=>$v): if($key == $dataInfo['house_deposit']): ?><option value="<?php echo ($key); ?>" selected><?php echo ($v); ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo ($key); ?>"><?php echo ($v); ?></option><?php endif; endforeach; endif; ?>
                            </select>

                            <p id="errMsg_rent_deposittype_option" class="errorMessage" display="none"></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="row1">建筑面积：</td>
                        <td colspan="3">
                            <input id="house_totalarea" class="input" name="house_totalarea" type="text" size="10" value="<?php echo ($dataInfo["house_totalarea"]); ?>" valid="required|isNumber" errmsg="请输入建筑面积!|请输入数字！" />&nbsp;平米
                            <p id="errMsg_house_totalarea" class="errorMessage" display="none">
                        </td>
                    </tr>

                    <tr>
                        <td class="row1">房&nbsp;&nbsp;&nbsp;&nbsp;龄：</td>
                        <td colspan="3">
                            <select class="select" name="house_age" valid="required" errmsg="请选择房龄！">
                                <option value="">请选择</option>
                                <?php if(is_array($house_age_option)): foreach($house_age_option as $key=>$v): if($v == $dataInfo['house_age']): ?><option value="<?php echo ($v); ?>" selected><?php echo ($v); ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo ($v); ?>"><?php echo ($v); ?></option><?php endif; endforeach; endif; ?>
                            </select>
                            年&nbsp;
                            <p id="errMsg_house_age" class="errorMessage" display="none"></p>
                        </td>
                    </tr>

                    <tr>
                        <td class="row1">装修情况：</td>
                        <td colspan="3">
                            <?php if(is_array($house_fitment_option)): foreach($house_fitment_option as $key=>$item): if($key == $dataInfo['house_fitment']): ?><label for="house_fitment_<?php echo ($key); ?>"><input  type="radio" name="house_fitment" id="house_fitment_<?php echo ($key); ?>" value="<?php echo ($key); ?>" valid="requireChecked" errmsg="请选择装修情况!" checked /><?php echo ($item); ?> </label>
                            <?php else: ?>
                            <label for="house_fitment_<?php echo ($key); ?>"><input  type="radio" name="house_fitment" id="house_fitment_<?php echo ($key); ?>" value="<?php echo ($key); ?>" valid="requireChecked" errmsg="请选择装修情况!" /><?php echo ($item); ?> </label><?php endif; endforeach; endif; ?>
                            <p id="errMsg_house_fitment" class="errorMessage" display="none"></p>
                        </td>
                    </tr>

                    <tr>
                        <td class="row1">房源描述：</td>
                        <td colspan="3"><span class="tip">&nbsp;详细、生动地描述房源全面信息，赢得客户，避免无效带看</span><br>
                            <div style="width:100%;" class="contentdiv">
                                
                                <!--

                                <iframe id="house_desc___Frame" src="/6doffice/Data/FCKeditor/editor/fckeditor.html?InstanceName=house_desc&amp;Toolbar=Basic" width="100%" height="220" frameborder="no" scrolling="no"></iframe>

                                 -->
                                <!--

                                <iframe id="inside" name="inside" src="<?php echo U(MODULE_NAME.'/HouseRent/ueditor');?>" width="100%" height="220" frameborder="no" scrolling="no"></iframe>
                                -->
                                <textarea name="" id="content"  style="width: 100%;height: 220px"><?php echo ($dataInfo["house_desc"]); ?></textarea>



                            </div>

                            <p><br>&nbsp;<span class="tip">请勿在房源描述内添加其它房产网站链接</span><br>&nbsp;<span class="tip">请勿在房源描述内留联系电话</span></p>
                        </td>
                    </tr>
                    <tr><td colspan="4" class="br"></td></tr>
                    </tbody>
                </table>
                <table class="memberBoxTable" cellpadding="0" cellspacing="5" border="0">
                    <thead>
                    <tr>
                        <td colspan="4"><span class="concentTitle">第二步：补充信息（选填项）</span></td>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td class="row1">朝&nbsp;&nbsp;&nbsp;&nbsp;向：</td>
                        <td colspan="3">
                            <?php if(is_array($house_toward_option)): foreach($house_toward_option as $key=>$item): if($key == $dataInfo['house_toward']): ?><label for="house_toward_<?php echo ($key); ?>"><input  type="radio" name="house_toward" id="house_toward_<?php echo ($key); ?>" value="<?php echo ($key); ?>"  errmsg="请选择房屋朝向!" checked /><?php echo ($item); ?> </label>
                            <?php else: ?>
                            <label for="house_toward_<?php echo ($key); ?>"><input  type="radio" name="house_toward" id="house_toward_<?php echo ($key); ?>" value="<?php echo ($key); ?>"  errmsg="朝向必择!" /><?php echo ($item); ?> </label><?php endif; endforeach; endif; ?>
                            <p id="errMsg_house_toward" class="errorMessage" display="none"></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="row1">房源特色：</td>
                        <td colspan="3">
                            <?php if(is_array($house_feature_option)): foreach($house_feature_option as $key=>$group): ?><p><?php echo ($house_feature_group["$key"]); ?>：&nbsp;
                                <?php if(is_array($group)): foreach($group as $feature_id=>$house_feature): if(in_array($feature_id,$dataInfo['house_feature'])): ?><label for="house_feature_<?php echo ($feature_id); ?>"><input  type="checkbox" name="house_feature[]" id="house_feature_<?php echo ($feature_id); ?>" value="<?php echo ($feature_id); ?>" checked onclick="return checkBoxNum()" /><?php echo ($house_feature); ?> </label>
                                <?php else: ?>
                                <label for="house_feature_<?php echo ($feature_id); ?>"><input  type="checkbox" name="house_feature[]" id="house_feature_<?php echo ($feature_id); ?>" value="<?php echo ($feature_id); ?>" onclick="return checkBoxNum()"  /><?php echo ($house_feature); ?> </label><?php endif; endforeach; endif; ?>
                            </p><?php endforeach; endif; ?>
                            <span class="tip">最多选择4项</span>
                            <p id="errMsg_house_feature" class="errorMessage" display="none"></p>
                    </tr>
                    <tr>
                        <td class="row1">房源配套：</td>
                        <td colspan="3">
                            <?php if(is_array($house_installation_option)): foreach($house_installation_option as $key=>$item): if(in_array($key,$dataInfo['house_support'])): ?><label for="house_support_<?php echo ($key); ?>"><input  type="checkbox" name="house_support[]" id="house_support_<?php echo ($key); ?>" value="<?php echo ($key); ?>"  checked /><?php echo ($item); ?> </label>
                            <?php else: ?>
                            <label for="house_support_<?php echo ($key); ?>"><input  type="checkbox" name="house_support[]" id="house_support_<?php echo ($key); ?>" value="<?php echo ($key); ?>" /><?php echo ($item); ?> </label><?php endif; ?>
                            <?php if($key % 7 == 0): ?><br><?php endif; endforeach; endif; ?>
                    </tr>
                    <tr>
                        <td class="row1">户型图：</td>
                        <td colspan="3">


                            <span style="float:left">
                              <iframe name="uploadHouseDrawing" width="100%" height="35" scrolling="No" frameborder="no"  src="<?php echo U(MODULE_NAME.'/HouseRent/webuploader');?>/to/uploadHouseDrawing|borough|drawing" align="left"></iframe>

                            </span>

                            <span class="tip" style="float:left; padding-top:10px;">上传户型图</span>

                            <input type="hidden" id="house_drawing" name="house_drawing" value="<?php echo ($dataInfo["house_drawing"]); ?>">
                            <p id="house_drawing_dis" style="clear:both;">
                                <?php if($dataInfo['house_drawing'] != null): ?><img src="/6doffice/Uploads/<?php echo ($dataInfo["house_drawing"]); ?>" width="120" height="90"><?php endif; ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="row1">房屋视频：</td>
                        <td><span class="tip">&nbsp;可粘贴优酷土豆的站外引用代码</span><br />
                            <input id="video" class="input" name="video" type="text" size="60" value='<?php echo ($dataInfo["video"]); ?>' />
                        </td>
                    </tr>
                    <tr>
                        <td class="row1">室内照片：</td>
                        <td>
                            <span class="tip" style="margin-left:15px; line-height:30px">&nbsp;可选择多个图片同时上传</span>

                            <span>
                                <iframe name="uploadHouseDrawing" width="100%" height="45" scrolling="No" frameborder="no"  src="<?php echo U(MODULE_NAME.'/HouseRent/webuploader');?>/to/uploadHousePicture|house|rent" align="left"></iframe>
                            </span>
                            <div id="divFileProgressContainer"></div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div id="house_picture_dis">
                                <?php if(is_array($dataInfo["house_pic"])): foreach($dataInfo["house_pic"] as $key=>$item): ?><div class="upload_shower" id="container_picture_<?php echo ($smarty["foreach"]["house_pic"]["index"]); ?>">
                                    <a href="/6doffice/Uploads/<?php echo ($item["pic_url"]); ?>"><img src="/6doffice/Uploads/<?php echo ($item["pic_url"]); ?>" width="160" height="120"></a>
                                    <br/><input type="text" name="house_picture_desc[]" value="<?php echo ($item["pic_desc"]); ?>" size="12">
                                    <input type="hidden" name="house_picture_url[]" value="<?php echo ($item["pic_url"]); ?>">
                                    <input type="hidden" name="house_picture_thumb[]" value="<?php echo ($item["pic_thumb"]); ?>">
                                    <input type="button" name="deletePicture_<?php echo ($smarty["foreach"]["house_pic"]["index"]); ?>" onclick="dropContainer('container_picture_<?php echo ($key); ?>')" value="删">
                                </div><?php endforeach; endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php if($dataInfo['id'] == null): ?><tr>
                        <td class="row1">小区照片：</td>
                        <td><span class="tip">&nbsp;小于500K</span><br />
                            <iframe name="uploadBoroughPicture" width="100%" height="35" scrolling="No" frameborder="no"  src="<?php echo U(MODULE_NAME.'/HouseRent/webuploader');?>/to/uploadBoroughPicture|borough|picture" align="left"></iframe>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="borough_picture_dis"></div>
                        </td>
                    </tr><?php endif; ?>
                    </tbody>
                </table>
                <table class="memberBoxTable" cellpadding="0" cellspacing="5" border="0">
                    <thead>
                    <tr>
                        <td colspan="4"><span class="concentTitle">第三步：业主信息（选填）</span></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="row1">业主姓名：</td>
                        <td><span class="tip">&nbsp;请输入此房源的业主姓名</span><br />
                            <input id="owner_name" class="input" name="owner_name"  type="text" size="40" value='<?php echo ($dataInfo["owner_name"]); ?>' />
                        </td>
                    </tr>
                    <tr>
                        <td class="row1">联系电话：</td>
                        <td><span class="tip">&nbsp;请输入此房源的业主联系电话</span><br />
                            <input id="owner_phone" class="input" name="owner_phone" type="text" size="40" value='<?php echo ($dataInfo["owner_phone"]); ?>' />
                        </td>
                    </tr>
                    <tr>
                        <td class="row1">备注：</td>
                        <td><span class="tip">&nbsp;业主备注信息</span><br />
                            <textarea name="owner_notes" cols="40" rows="5" class="textarea" id="owner_notes"><?php echo ($dataInfo["owner_notes"]); ?></textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="submitPromsie">
                    <input  class="checkbox" id="check_agree" name="check_agree" type="checkbox" checked />我承诺我所发布的房源信息全部属实，我接受 <?php echo ($titlec); ?>的用户协议
                    <p style="color: red" id="errMsg_house_check" class="errorMessage" display="none"></p>

                </div>

                <?php if($dataInfo['id'] != null): ?><div class="submitBtn" id="submitBtn"><input type="submit" value="确认编辑" /></div>
                <?php else: ?>
                <div class="submitBtn" id="submitBtn"><input type="submit" value="立即发布" /></div><?php endif; ?>
            </form>
        </div>
    </div>

</div>



<script type="text/javascript">



    function checkForm(formDom){
        var Content =UE.getEditor('content').getContent();
        if(Content==null||Content==""){
            alert('内容不能为空');
            return false;
        }else{
           return $('#dataForm').valid();
        }
    }

    function uploadHouseDrawing( furl,fname,thumbUrl ){
        document.getElementById('house_drawing').value = furl;
        document.getElementById('house_drawing_dis').innerHTML = '<a href="/6doffice/Uploads/'+furl+'"><img src="/6doffice/Uploads/'+thumbUrl+'" width="120" height="90"></a>';
    }
    var pictureIndex=<?php echo ($picture_num); ?>;
    //var borough_name_val = $('#borough_name').val();

    function uploadHousePicture( furl,fname,thumbUrl ){
        var borough_name_val = $('#borough_name').val();
        //alert(borough_name_val);
        document.getElementById('house_picture_dis').innerHTML += '<div class="upload_shower" id="container_picture_'+pictureIndex+'">\
	<a href="/6doffice/Uploads/'+furl+'"><img src="/6doffice/Uploads/'+thumbUrl+'" width="160" height="120"></a>\
	<br/><input type="text" name="house_picture_desc[]" value="'+borough_name_val+'" size="15">\
	<input type="hidden" name="house_picture_url[]" value="'+furl+'">\
	<input type="hidden" name="house_picture_thumb[]" value="'+thumbUrl+'">\
	<input type="button" name="deletePicture_'+pictureIndex+'" onclick="dropContainer(\'container_picture_'+pictureIndex+'\')" value="删">\
	</div>';
        pictureIndex++;
    }

    var boroughIndex=0;
    function uploadBoroughPicture( furl,fname,thumbUrl ){
        var borough_name_val = $('#borough_name').val();
        document.getElementById('borough_picture_dis').innerHTML += '<div class="upload_shower" id="container_borough_picture_'+boroughIndex+'">\
	<a href="/6doffice/Uploads/'+furl+'"><img src="/6doffice/Uploads/'+thumbUrl+'" width="160" height="120"></a>\
	<br/><input type="text" name="borough_picture_desc[]" value="'+borough_name_val+'" size="15">\
	<input type="hidden" name="borough_picture_url[]" value="'+furl+'">\
	<input type="hidden" name="borough_picture_thumb[]" value="'+thumbUrl+'">\
	<input type="button" name="delete_borough_picture_'+boroughIndex+'" onclick="dropContainer(\'container_borough_picture_'+boroughIndex+'\')" value="删">\
	</div>';
        boroughIndex++;
    }
    //删除图片节点
    function dropContainer(containerId){
        var containerEle = document.getElementById(containerId);
        var parentEle = containerEle.parentElement;
        parentEle.removeChild(containerEle);
    }
</script>
</body>
</html>