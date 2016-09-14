<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($title); ?> - 置顶</title>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>

    <script language="JavaScript" type="text/javascript" src="/6doffice/Public/js/jquery.validate.min.js"></script>
    <script>
        $(function(){


        $('#topForm').validate(

                {
                    //定义错误信息显示位置
                    errorPlacement: function(error, element) {
                        error.appendTo(element.parent().siblings(".reg_b123").children('font'));
                    },
                    //自定义验证信息
                    rules: {
                        days: {
                            required:true,
                            digits: true,
                        },


                    },
                    messages: {
                        days: {
                            required:"请输入天数",
                            digits: "(天数必须为整数)",
                        },
                    }

                }
        )


            $('#submitBtn').click(function(){
                var ajaxSaveSellTopUrl='<?php echo U(MODULE_NAME."/ManageSell/ajaxSaveSellTop");?>';
                var tourlSellTopDone='<?php echo U(MODULE_NAME."/ManageSell/sellTopDone");?>'
                var days=$('#days').val();
                var house_id=$('#house_id').val();
                $.ajax({
                    url:ajaxSaveSellTopUrl,
                    type:'post',
                    dataType:'json',
                    data:{days:days,house_id:house_id},
                    success:function(result){
                        if(result.status){
                            alert(result.msg)
                            window.parent.location.href=tourlSellTopDone;
                        }else{
                            alert(result.msg)
                        }

                    }
                })

                /*if(confirm('确认将会从您的账户中扣除相应的费用，确认么？')){
                    dataForm.action='<?php echo U(MODULE_NAME."/ManageSell/ajaxSaveSellTop");?>/action/save';
                    dataForm.submit();}*/

            })

        })//$.function end
    </script>

</head>
<body>
<div id="modalWindow">
    您好，您账户的余额为<font color="#FF0000"> <?php echo ($money); ?> </font>元
    <p>
        每天置顶房源的价格为<?php echo ($sellPrice); ?>元
    </p>
    <p>
        置顶金额 = <?php echo ($sellPrice); ?> * 置顶天数
    </p>
    <form name="dataForm" method="POST" action="" id="topForm">
        <input type="hidden"  name="house_id" value="<?php echo ($house_id); ?>" id="house_id">
        <p>
            <label>您需要置顶的天数:</label>
            <input name="days"  maxlength=10 id="days">        </p>
        <p class="reg_b123">
            <font color="#FF0000"></font>
        </p>

        <p>
            <input type="button" value=" 确认置顶 " id="submitBtn">
        </p>
    </form>
</div>

</body>
</html>