<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo ($title); ?></title>
<link href="/6doffice/Public/css/css.css" rel="stylesheet" type="text/css" />
<link href="/6doffice/Public/css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript" src="/6doffice/Public/js/jquery.min.js" charset="utf-8"></script>
<meta name="keywords" content="<?php echo ($cfg["page"]["keyword"]); ?>" />
<meta name="description" content="<?php echo ($cfg["page"]["description"]); ?>" />

  <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/login.css" />
  <script language="JavaScript" type="text/javascript" src="/6doffice/Public/js/FormValid.js"></script>
  <script language="JavaScript" type="text/javascript" src="/6doffice/Public/js/FV_onBlur.js"></script>
  <script language="JavaScript" type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
  <script language="JavaScript" type="text/javascript" src="/6doffice/Public/js/jquery.validate.min.js"></script>
  <script language="JavaScript" type="text/javascript" src="/6doffice/Public/js/messages_zh.min.js"></script>
  <script language="JavaScript" type="text/javascript" src="/6doffice/Public/js/login.js"></script>



  <script type="text/javascript">
    var codeCheckAjaxUrl="<?php echo U(MODULE_NAME.'/Login/codeCheckAjax');?>";
    //alert(codeCheckAjaxUrl)
    $(document).ready(function(){$("#province").change(function(){$("#province option").each(function(i,o){if($(this).attr("selected")){$(".city").hide();$(".city").eq(i).show();}});});$("#province").change();});</script>
  <link href="/6doffice/Public/css/region.css" rel="stylesheet" type="text/css" />

</head>
<body>

<div class="body">

  <div class="reg">
    <div class="reg_a">
      <div style="height:26px; clear:both; overflow:hidden; width:100%"></div>
      <div class="reg_b1">
        <div class="reg_b11"><font class="t20 b"><font color="#FF0000">免费注册经纪人</font></font></div>
      </div>
      <div class="reg_b31"><font class="t20 b">如果您已拥有帐户，请在下面登录</font></div>
      <?php echo (cookie('AUTH_MEMBER_NAME')); ?>
    </div>
    <div class="reg_b">
      <!-- reg -->

      <form name="registerform" id="registerform" method="POST" action="<?php echo U(MODULE_NAME.'/Login/register');?>" class="cmxform">
        <input type="hidden" name="action" value="register">
        <input type="hidden" name="user_type" value="1">
        <div class="reg_b1">
          <div class="reg_b12">
            <div class="reg_b121"><font class="t14">您的用户名：</font></div>
            <div class="reg_b122">
              <input type="text" value="<?php echo ($_POST['username']); ?>" class="input_region" name="username">
            </div>
            <div class="reg_b123" id="errMsg_username"></div>
          </div>
          <div class="h5"></div>
          <div class="reg_b12">
            <div class="reg_b121"><font class="t14">您的密码：</font></div>
            <div class="reg_b122">
              <input type="password" value="" class="input_region" name="passwd" id="passwd">
            </div>
            <div class="reg_b123" id="errMsg_passwd"></div>
          </div>
          <div style="height:4px; clear:both; overflow: hidden"></div>
          <div class="reg_b12">
            <div class="reg_b121"><font class="t14">重复密码：</font></div>
            <div class="reg_b122">
              <input type="password" value="" class="input_region" name="passwd2">
            </div>
            <div class="reg_b123" id="errMsg_passwd2"></div>
          </div>
          <div class="h5"></div>
          <div class="reg_b12">
            <div class="reg_b121"><font class="t14">电子邮箱：</font></div>
            <div class="reg_b122">
              <input type="text" value="<?php echo ($_POST['email']); ?>" class="input_region" name="email" id="Email" >
            </div>
            <div class="reg_b123" id="errMsg_email"></div>
          </div>
          <div style="height:4px; clear:both; overflow:hidden;"></div>
          <div class="reg_b12">
            <div class="reg_b121"><font class="t14">真实姓名：</font></div>
            <div class="reg_b122">
              <input type="text" value="<?php echo ($_POST['realname']); ?>" class="input_region" name="realname" maxlength="16">
            </div>
            <div class="reg_b123" id="errMsg_realname"></div>
          </div>
          <div style=" height:4px; clear:both; overflow:hidden;"></div>
          <div class="reg_b12">
            <div class="reg_b121"><font class="t14">服务区域：</font></div>
            <div class="reg_b124">
              <select  name="cityarea_id" value="<?php echo ($_POST['mobile']); ?>"  valid="required" errmsg="请选择服务区域!">
                <option>请选择</option>
                <?php if(is_array($cityarea)): foreach($cityarea as $key=>$v): ?><option value="<?php echo ($key); ?>"><?php echo ($v); ?></option><?php endforeach; endif; ?>
              </select>
            </div>

            <div class="reg_b123" id="errMsg_cityarea_id"></div><span class="reg_b123" id="errMsg_citypart_id" style="display:none; width:0px; height:0px;"></span>


          </div>
          <div style="height:7px; clear:both; overflow:hidden;"></div>
          <div class="reg_b12">
            <div class="reg_b121"><font class="t14">所属公司：</font></div>

            <div class="reg_b122">
              <input id="outlet_first"  name="outlet_first" type="text" value="" class="input_region"  >
            </div>
            <div class="reg_b123" id="errMsg_outlet_first"></div>
          </div>
          <div style="height:1px; clear:both; overflow:hidden;"></div>
          <div class="reg_b12">
            <div class="reg_b121"><font class="t14">所属门店：</font></div>
            <div class="reg_b122">
              <input id="outlet_last" type="text" value="" class="input_region" name="outlet_last" >
            </div>
            <div class="reg_b123" id="errMsg_outlet_last"></div>
          </div>
          <div style="height:3px; clear:both; overflow:hidden;"></div>
          <div class="reg_b12">
            <div class="reg_b121"><font class="t14">联系电话：</font></div>
            <div class="reg_b122">
              <input type="text" value="" class="input_region" name="mobile">
            </div>
            <div class="reg_b123" id="errMsg_mobile"></div>
          </div>
          <div class="h5"></div>
          <div class="reg_b12">
            <div class="reg_b121"><font class="t14">注册校验：</font></div>
            <div class="reg_b126">
              <input name="verify" type="text" class="input_region_yzm"  id="verifycode"/>
            </div>
            <div class="reg_b127"><img onclick="this.src=this.src +'/' + Math.random();" id="valid_pic" src="<?php echo U(MODULE_NAME.'/Login/verify',array('id'=>1));?>"></div>
            <div class="reg_b127" style="float:left; width:61px;"><span><a href="javascript:void(0)" onclick="document.getElementById('valid_pic').src+='/' + Math.random();"><font>换一换</font></a></span></div>
            <div style="float:left; width:110px;" class="reg_b123" id="errMsg_vaild"></div>
          </div>
          <div style="height:18px; clear:both; overflow:hidden"></div>
          <div class="reg_b123"><font color="#FF0000">
            <?php echo ($errorMsg); ?>
          </font></div>
          <div class="reg_b12">
            <div class="reg_b128"><img src="/6doffice/Public/images/reg_button.jpg" width="115" height="37" style="cursor:pointer;"/></div>
            <div class="reg_b129">
            </div>
          </div>
          <div style="height:20px; clear:both; overflow:hidden;"></div>
        </div>
      </form>
      <!-- end reg from -->
      <div class="reg_b2"></div>
      <form onsubmit="return validator(this)" action="<?php echo U(MODULE_NAME.'/Login/login');?>" method="post" name="loginform" id="loginform">
        <input type="hidden" value="login" name="action">
        <input type="hidden" value="" name="back_to">
        <div class="reg_b3">
          <div style="height:3px; clear:both; overflow:hidden"></div>
          <div class="reg_b32">
            <div class="reg_b321">用户名：</div>
            <div class="reg_b322">
              <input type="text" name="username" class="input_region">
            </div>
          </div>
          <div style="height:11px; clear:both; overflow:hidden;"></div>
          <div class="reg_b32">
            <div class="reg_b321">密&nbsp;&nbsp;码：</div>
            <div class="reg_b322">
              <input type="password" name="passwd" class="input_region">
            </div>
          </div>
          <div style="height:10px; clear:both; overflow:hidden;"></div>



          <div class="reg_b32">
            <div class="reg_b321">验证码：</div>
            <div class="" style="width:82px;float:left;margin-top: 6px;margin-left:14px;">
              <input type="text" name="verify2" class="" style="width:76px; _width:77px; height:25px; line-height:25px; background:url(/6doffice/Public/images/input_region_yzm.gif); border:0; padding-left:6px; color:#000; font-size:13px;" >
            </div>
            <div class="reg_b127" style="margin-top: 5px"><img onclick="this.src=this.src +'/' + Math.random();" id="valid_pic2" src="<?php echo U(MODULE_NAME.'/Login/verify',array('id'=>2));?>"></div>
            <div class="reg_b127" style="float:left; width:61px;margin-top: 5px;margin-left: 10px"><span><a href="javascript:void(0)" onclick="document.getElementById('valid_pic2').src+='/' + Math.random();"><font>换一换</font></a></span></div>


          </div>

          <div style="height:11px; clear:both; overflow:hidden;"></div>
          <div class="reg_b32">
            <div class="reg_b321">&nbsp;</div>
            <div class="reg_b324">
              <input name="notForget" value="1" type="checkbox" id="remberme" checked="checked" />
              &nbsp;下次直接登录（慎用） <span>
              <!--<a href="#">忘记密码？</a></span>-->
            </div>
          </div>
          <div style="height:4px; clear:both; overflow:hidden"></div>
          <div class="reg_b123"><font color="#FF0000">
            <?php echo ($errorMsg1); ?>
          </font></div>
          <div class="reg_b32">
            <div class="reg_b321"></div>
            <div class="reg_b323">
              <input type="image" src="/6doffice/Public/images/login.jpg" />
            </div>
          </div>
          <div style="height:33px; clear:both; overflow:hidden"></div>
          <div class="reg_b33">
            <div style="height:10px; clear:both; overflow:hidden;"></div>
            <ul>
              <li><font class="b" style="font-size:13px; _font-size:12px;">登陆注册有问题请联系：<?php echo ($rexian); ?></font></li>


            </ul>
            <div style="height:10px; clear:both; overflow:hidden"></div>
          </div>
        </div>
      </form>
    </div>
    <div class="reg_c"></div>
  </div>
</div>

<div class="blank"></div>
<!--{include file="inc/foot.tpl"}-->
</body>
</html>