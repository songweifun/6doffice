<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo ($title); ?> - 房东信息</title>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/css/member.css" />
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/map.js"></script>
</head>
<body>
<div id="modalWindow">
    <table width="100%">
        <tr>
            <td>业主姓名：</td>
            <td><?php echo ($houseInfo["owner_name"]); ?></td>
        </tr>
        <tr>
            <td>业主电话：</td>
            <td><?php echo ($houseInfo["owner_phone"]); ?></td>
        </tr>
        <tr>
            <td>备注：</td>
            <td><?php echo ($houseInfo["owner_notes"]); ?></td>
        </tr>
    </table>

</div>
</body>
</html>