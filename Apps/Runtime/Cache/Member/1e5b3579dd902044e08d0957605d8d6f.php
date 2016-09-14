<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($cfg["page"]["title"]); ?></title>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>
</head>
<body>
<div id="modalWindow">
    <form name="dataForm" method="POST" action="">
        <input type="hidden" id="id" name="id" value="<?php echo ($dataInfo["id"]); ?>">
        <p>
            <label>备注:</label>
            <textarea name="remark" id="remark" rows="9" style="width:98%" ><?php echo ($dataInfo["remark"]); ?></textarea>
        </p>
        <p>
            <input type="button" id="addButton" value="提交" onclick="return addBorough()" />
        </p>
    </form>
</div>
<script language="javascript">

    var ajaxSaveBargainRemarkUrl="<?php echo U(MODULE_NAME.'/ManageRent/ajaxSaveBargainRemark');?>";
    var tourlRentDone='<?php echo U(MODULE_NAME."/ManageRent/rentDone");?>'

    function addBorough(){
        var thisid = document.getElementById('id').value;
        var remark = document.getElementById('remark').value;
        if(!remark){
            alert("请把信息填全");
            return false;
        }

        $.ajax({
            url:ajaxSaveBargainRemarkUrl,
            data:{id:thisid,remark:remark},
            dataType: "json",
            type:'post',
            success:function(result){
                if(!result.status){
                    alert('提交错误');
                    return false;
                }
                window.parent.location.href=tourlRentDone;
            }

        })



        return false;
    }
</script>
<script src="<?php echo ($cfg["path"]["js"]); ?>My97DatePicker/WdatePicker.js" language="javascript"></script>
</body>
</html>