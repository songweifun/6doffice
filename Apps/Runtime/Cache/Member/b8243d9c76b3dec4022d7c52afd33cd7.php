<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($title); ?> - 条数</title>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>
    <script>
        $(function(){

            $('#submitBtn').click(function(){
                var ajaxSaveSellTopUrl='<?php echo U(MODULE_NAME."/ManageSell/buySellNum");?>';
                var tourlSellTopDone='<?php echo U(MODULE_NAME."/HouseSell/index");?>'
                var num=$('#num').val();
                $.ajax({
                    url:ajaxSaveSellTopUrl,
                    type:'post',
                    dataType:'json',
                    data:{num:num},
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


        })
    </script>
</head>
<body>
<div id="modalWindow">
    您好，您账户的余额为<font color="#FF0000"> <?php echo ($money); ?> </font>元
    <p>
        每条房源容量的价格为<?php echo ($sellPrice); ?>元
    </p>
    <p>
        条数金额 = <?php echo ($sellPrice); ?> * 条数
    </p>
    <form name="dataForm" method="POST" action="">
        <p>
            <label>您需要购买的条数:</label>
            <input name="num"  maxlength=10 id="num">
        </p>
        <p>
            <font color="#FF0000">（条数必须为整数，如果有小数点将取小数点前面的值为条数）</font>
        </p>

        <p>
            <input id="submitBtn" type="button" value=" 确认购买 " >
        </p>
    </form>
</div>

</body>
</html>