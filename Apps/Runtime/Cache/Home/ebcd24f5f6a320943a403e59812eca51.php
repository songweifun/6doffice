<?php if (!defined('THINK_PATH')) exit(); if($dataInfo['ad_type'] == 1): ?>document.write('<a href="<?php echo ($dataInfo["link_url"]); ?>" target="_blank"><img width="<?php echo ($dataInfo["width"]); ?>"  height="<?php echo ($dataInfo["height"]); ?>" src="/6doffice/Uploads/<?php echo ($dataInfo["image_url"]); ?>"></a>');
<?php elseif($dataInfo['ad_type'] == 2): ?>
document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="<?php echo ($dataInfo["width"]); ?>" height="<?php echo ($dataInfo["height"]); ?>" id="Untitled-1" align="middle"><param name="allowScriptAccess" value="sameDomain" /><param name="movie" value="/6doffice/Uploads/<?php echo ($dataInfo["flash_url"]); ?>" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="/6doffice/Uploads/<?php echo ($dataInfo["flash_url"]); ?>" quality="high" bgcolor="#ffffff" width="<?php echo ($dataInfo["width"]); ?>"  height="<?php echo ($dataInfo["height"]); ?>" name="mymovie" align="middle" allowScriptAccess="sameDomain"  type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object> ');
<?php elseif($dataInfo['ad_type'] == 3): ?>
document.write('<a href="<?php echo ($dataInfo["link_url"]); ?>" target="_blank"><?php echo ($dataInfo["text"]); ?></a>');
<?php elseif($dataInfo['ad_type'] == 4): ?>
document.write('<a href="<?php echo ($dataInfo["link_url"]); ?>" target="_blank"><?php echo ($dataInfo["code"]); ?></a>');<?php endif; ?>