<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($title); ?> - 增加小区</title>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>

</head>
<body>
<div id="modalWindow">
    <form name="dataForm" method="POST" action="">
        <p>
            <label>小区名字:</label>
            <input type="text" id="name" name="addBoroughName" class="input" value="" />
        </p>
        <p>
            <label>所在区域:</label>
            <select id="addBoroughCityarea"  name="addBoroughCityarea" class="select">
                <option  value="">请选择区域</option>
            </select>
        <span id="quote">
<select name="cityarea2_id">
    <option value="0">请选择</option>
</select>
</span>
            <script language="javascript">
                $("#addBoroughCityarea").change(function(){
                    $("#quote").load("../areas.php?id="+$("#addBoroughCityarea").val());
                });
            </script>
        </p>
        <p>
            <label>小区地址:</label>
            <input type="text" id="address" name="addBoroughAddr" class="input" size="40" value="" />
        </p>
        <p>
            <label>物业类型:</label>
            <select  id="addBoroughType" name="addBoroughType" class="select">
            </select>
        </p>
        <p>
            <input type="button" id="addButton" value="增加小区" onclick="return addBorough()" />
        </p>
    </form>
</div>
<script language="javascript">

    function addBorough(){
        var name = document.getElementById('addBoroughName').value;
        var area_id =  document.getElementById('addBoroughCityarea').value;
        var area2_id =  document.getElementById('cityarea2_id').value;
        var address =  document.getElementById('addBoroughAddr').value;
        var type =  document.getElementById('addBoroughType').value;
        if(!name || !area_id || !address || !type){
            alert("请把信息填全");
            return false;
        }

        $.post('ajax.php?action=saveBorough',{borough_name:name,cityarea_id:area_id,cityarea2_id:area2_id,borough_address:address,borough_type:type},function(data){
            //返回小区ID
            if(data ==0){
                alert('增加小区出错');
                return false;
            }
            if(data.indexOf('|')){
                var temp = data.split('|');
                if(temp[0] < 0){
                    alert("添加小区出错");
                    return false;
                }
                if(temp[1] == -1){
                    alert("你添加的小区已存在");
                }
                window.parent.addToBoroughItem(temp[0],name,address);
                window.parent.TB_remove();
            }else{
                alert('增加小区出错');
                return false;
            }
        });

        return false;
    }
</script>
</body>
</html>