<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <title>ueditor demo</title>
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>
</head>

<body>
<!-- 加载编辑器的容器 -->


<!-- 配置文件 -->
<script type="text/javascript" src="/6doffice/Data/Ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/6doffice/Data/Ueditor/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('content');
</script>
</body>

<textarea name="content" id="content" cols="30" rows="10">eeee</textarea>
<input type="text" name="aafaf" id="afaf" value="fdfdfdfdfdfdfdf">
<script type="text/javascript">
    function getMsgs(){
        var el = parent.document.getElementById("house_desc");
        var txt = document.getElementById("content");
        el.value = txt.value;
    }
    //getMsgs()

    var submit = parent.document.getElementById("submitBtn");
    submit.onclick=function(){
        getMsgs()
        //alert(1111)
    }
</script>
</html>