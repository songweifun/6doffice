<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文件上传</title>
    <script type="text/javascript" src="/6doffice/Public/js/jquery.min.js"></script>

    <!-- bootstrap -->
    <script type="text/javascript" src="/6doffice/Public/js/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/js/bootstrap/css/bootstrap.min.css" />
    <!-- webupload -->
    <script type="text/javascript" src="/6doffice/Public/js/webupload/webuploader.js"></script>
    <link rel="stylesheet" type="text/css" href="/6doffice/Public/js/webupload/webuploader.css" />
    <script>

        $(function(){
            var swfurl='/6doffice/Public/js/webupload';

            // 初始化Web Uploader
            var uploader = WebUploader.create({

                // 选完文件后，是否自动上传。
                auto: true,

                // swf文件路径
                swf: swfurl + '/Uploader.swf',

                // 文件接收服务端。
                server: '<?php echo U(MODULE_NAME."/HouseRent/upload");?>/action/doupload/to/'+'<?php echo ($_GET['to']); ?>',

                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#filePicker',

                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                }
            });

            // 当有文件添加进来的时候
            uploader.on( 'fileQueued', function( file ) {
                var $li = $(
                                '<div id="' + file.id + '" class="file-item thumbnail">' +
                                '</div>'
                        )


                // $list为容器jQuery实例
                var $list=$('#fileList');
                $list.append( $li );


            });

            // 文件上传过程中创建进度条实时显示。
            uploader.on( 'uploadProgress', function( file, percentage ) {
                var $li = $( '#'+file.id ),
                        $percent = $li.find('.progress span');

                // 避免重复创建
                if ( !$percent.length ) {
                    $percent = $('<p class="progress"><span class="progress-bar"></span></p>')
                            .appendTo( $li )
                            .find('span');
                }

                $percent.css( 'width', percentage * 100 + '%' );
            });



            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on( 'uploadComplete', function( file ) {
                $( '#'+file.id ).remove();
            });

            uploader.on( 'uploadAccept', function( file, response ) {

                var serverData=response._raw.split('||');
                var $list=$('#msgsf');
                //alert(serverData);
                if (serverData[0].substring(0, 7) === "FILEID:") {

                    //document.write("<html> <head><title>上传成功</title> <meta http-equiv=\"content-type\" content=\"text/html; charset=gb2312\"> </head><script> var parentForm;if(window.opener){parentForm = window.opener;}else{parentForm = window.parent;} parentForm.uploadHousePicture('"+ serverData[1]+"','"+serverData[2]+"','"+serverData[3]+"')<\/script> <\/html>");
                    $list.append("<script> var parentForm;if(window.opener){parentForm = window.opener;}else{parentForm = window.parent;} parentForm.uploadHousePicture('"+ serverData[1]+"','"+serverData[2]+"','"+serverData[3]+"');<\/script>");


                } else {
                    $list.append(response._raw)


                }

            });
        })
    </script>
</head>
<body>
<!--dom结构部分-->
<div id="uploader-demo">
    <!--用来存放item-->
    <div id="fileList" class="uploader-list"></div>
    <div id="filePicker">多张上传</div>
</div>
<div id="msgsf"></div>








</body>
</html>