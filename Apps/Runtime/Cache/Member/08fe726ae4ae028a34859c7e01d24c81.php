<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($title); ?> - 成交</title>

    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>


    <style>
        p{
            margin: 5px auto;
        }
    </style>
</head>
<body>
<div id="modalWindow">
    <form name="dataForm" method="POST" action="">
        <input type="hidden" id="id" name="id" value="<?php echo ($dataInfo["id"]); ?>">
        <input type="hidden" id="house_id" name="house_id" value="<?php echo ($house_id); ?>">
        <p>
            <label>小区名字:</label>
            <input type="text" id="borough_name" name="borough_name" class="input" value="<?php echo ($dataInfo["borough_name"]); ?>" />
        </p>
        <p>
            <label>房源面积:</label>
            <input type="text" id="house_totalarea" name="house_totalarea" class="input" size="10" value="<?php echo ($dataInfo["house_totalarea"]); ?>" />平方
        </p>
        <p>
            <label>房源售价:</label>
            <input type="text" id="house_price" name="house_price" class="input" size="10" value="<?php echo ($dataInfo["house_price"]); ?>" />万
        </p>
        <p>
            <label>交易来源:</label>
            <select id="bargain_from_id" name="bargain_from" class="select">
                <option value="">请选择交易来源</option>
                <?php if(is_array($bargain_from_option)): foreach($bargain_from_option as $key=>$v): if($key == $dataInfo['bargain_from']): ?><option value="<?php echo ($key); ?>" selected><?php echo ($v); ?></option>
                        <?php else: ?>
                        <option value="<?php echo ($key); ?>"><?php echo ($v); ?></option><?php endif; endforeach; endif; ?>
            </select>
        </p>
        <p>
            <label>买&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;方:</label>
            <input type="text" id="buyer" name="buyer" class="input" size="20" value="<?php echo ($dataInfo["buyer"]); ?>" />
        </p>
        <p>
            <label>买方电话:</label>
            <input type="text" id="buyer_tel" name="buyer_tel" class="input" size="20" value="<?php echo ($dataInfo["buyer_tel"]); ?>" />
        </p>
        <p>
            <label>卖&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;方:</label>
            <input type="text" id="saler" name="saler" class="input" size="20" value="<?php echo ($dataInfo["saler"]); ?>" />
        </p>
        <p>
            <label>卖方电话:</label>
            <input type="text" id="saler_tel" name="saler_tel" class="input" size="20" value="<?php echo ($dataInfo["saler_tel"]); ?>" />
        </p>
        <p>
            <label>成&nbsp;&nbsp;交&nbsp;&nbsp;价:</label>
            <input type="text" id="bargain_price" name="bargain_price" class="input" size="20" value="<?php echo ($dataInfo["bargain_price"]); ?>" />
        </p>
        <p>
            <label>成交时间:</label>
            <input type="text" id="bargain_time" name="bargain_time" class="input" size="20"  value="<?php echo (date('Y-m-d',$dataInfo["bargain_time"])); ?>" onclick="WdatePicker()" />
        </p>
        <p>
            <input type="button" id="addButton" value="提交" onclick="return addBorough()" />
        </p>
    </form>
</div>

<script language="javascript">
    var ajaxSaveBargainUrl="<?php echo U(MODULE_NAME.'/ManageSell/ajaxSaveBargain');?>";
    var tourlSellDone='<?php echo U(MODULE_NAME."/ManageSell/sellDone");?>'

    function addBorough(){
        var thisid = document.getElementById('id').value;
        var borough_name =  document.getElementById('borough_name').value;
        var house_totalarea =  document.getElementById('house_totalarea').value;
        var house_price =  document.getElementById('house_price').value;
        var house_id =  document.getElementById('house_id').value;
        var bargain_from =  document.getElementById('bargain_from_id').value;
        var buyer =  document.getElementById('buyer').value;
        var buyer_tel =  document.getElementById('buyer_tel').value;
        var saler =  document.getElementById('saler').value;
        var saler_tel =  document.getElementById('saler_tel').value;
        var bargain_price =  document.getElementById('bargain_price').value;
        var bargain_time =  document.getElementById('bargain_time').value;
        //alert(bargain_from+'|'+buyer+'|'+buyer_tel+'|'+saler+'|'+saler_tel+'|'+bargain_price+'|'+bargain_time);
        if( !bargain_from || !buyer || !buyer_tel || !saler || !saler_tel ||!bargain_price ||!bargain_time ){

            alert("请把信息填全");
            return false;
        }

        /*$.post('ajax.php?action=saveBargain&request=ajax',{id:thisid,borough_name:borough_name,house_totalarea:house_totalarea,house_price:house_price,house_id:house_id,bargain_from:bargain_from,buyer:buyer,buyer_tel:buyer_tel,saler:saler,saler_tel:saler_tel,bargain_price:bargain_price,bargain_time:bargain_time},function(data){
            //返回ID
            //alert(data);
            if(data ==0){
                alert('提交错误');
                return false;
            }
            //window.parent.TB_remove();
            window.parent.location.href='manageSaleDone.php';
        });*/

        $.ajax({
            url:ajaxSaveBargainUrl,
            data:{id:thisid,borough_name:borough_name,house_totalarea:house_totalarea,house_price:house_price,house_id:house_id,bargain_from:bargain_from,buyer:buyer,buyer_tel:buyer_tel,saler:saler,saler_tel:saler_tel,bargain_price:bargain_price,bargain_time:bargain_time},
            dataType: "json",
            type:'post',
            success:function(result){
                if(!result.status){
                    alert('提交错误');
                    return false;
                }
                window.parent.location.href=tourlSellDone;
            }

        })

        return false;
    }
</script>

<script src="/6doffice/Public/js/My97DatePicker/WdatePicker.js" language="javascript"></script>



</body>
</html>