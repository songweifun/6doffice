<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加好友</title>
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
    <!-- bootstrap -->
    <script type="text/javascript" src="/6doffice/Public/js/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/js/bootstrap/css/bootstrap.min.css" />

    <!-- ui autocomplete -->
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/js/uiautocomplete/jquery-ui.css" />
    <script type="text/javascript" src="/6doffice/Public/js/uiautocomplete/jquery-ui.js"></script>
    <script type="text/javascript" src="/6doffice/Public/js/member/addfriend_autocomplete.js"></script>
    <script>
        var hosesellajaxurl="<?php echo U(MODULE_NAME.'/HouseSell/ajax');?>"
        var imagefooturl='/6doffice/Uploads/'
        var addBoroughurl="<?php echo U(MODULE_NAME.'/HouseSell/addBorough');?>"
    </script>
</head>
<body>
<form action="<?php echo U(MODULE_NAME.'/ManageContacts/snsFriends');?>/action/saveFriend" method="">
    <input type="hidden" id="member_id" name="id">

    <table class="table table-bordered table-hover">
        <tr>
            <td>用户名:</td>
            <td><input type="text" name="friend" id="friend_name"></td>
        </tr>
       <tr>
           <td colspan="2" align="center">
               <input type="submit" class="btn btn-primary" value="添加"/>
           </td>
       </tr>
    </table>
</form>

</body>
</html>