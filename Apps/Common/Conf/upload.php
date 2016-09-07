<?php 
/**
 * resizeType:缩略类型； 0=长宽转换成参数指定的 1=按比例缩放，长宽约束在参数指定内，2=以宽为约束缩放，3=以高为约束缩放,4 :裁剪左上角
 * pathdir: 'upfile/'+pathdir+'filename' ;//后面要加斜线
 * pos 水印位置 参照九宫图位置 0-9 可以是数组
 * watermarkPic 水印内容   可以是图像文件名，也可以是文字
 * 先测试使用目录，如果目录文件太多需要重新调整图片目录存储位置
 * 
 */

  return array (
  'borough' => array(
  		'picture'=>array(
  			'thumb'=>true,
  			'resizeType'=>1,
  			'thumbResizeType'=>5,
  			'thumbWidth'=>320,
  			'thumbHeight'=>240,
  			'watermark'=>true,
  			'watermarkPos'=>9,
  			'watermarkPic'=>'./Data/water/anleye.png',
  			'thumbDir'=>'borough/picture/',
  			'originalPath'=>'borough/picture/',
  			'width'=>640,
  			'height'=>480,
				'exts' =>array('jpeg','jpg','gif','bmp','png'),
				'rootPath'=>'./Uploads/',
				'saveName'=>date('YmdHis').'_'.mt_rand(),
				'autoSub'=>false,
  		),
  		'drawing'=>array(
  			'thumb'=>true,
  			'resizeType'=>1,
  			'thumbResizeType'=>5,
  			'thumbWidth'=>320,
  			'thumbHeight'=>240,
  			'watermark'=>true,
  			'watermarkPos'=>9,
  			'watermarkPic'=>'./Data/water/anleye.png',
  			'thumbDir'=>'borough/drawing/',
  			'originalPath'=>'borough/drawing/',
  			'width'=>640,
  			'height'=>480,
  			'exts' =>array('jpeg','jpg','gif','bmp','png'),
			'rootPath'=>'./Uploads/',
			'saveName'=>array('date','YmdHis'),
			'autoSub'=>false,
			//'subName'=>'',子目录创建方式可以使用函数,当autosub开启才有效
  		),
  		//小区不需要独立一张图片
/*  	'thumb' =>array(
  			'thumb'=>true,
  			'resizeType'=>5,
  			'thumbResizeType'=>1,
  			'thumbWidth'=>240,
  			'thumbHeight'=>180,
  			'watermarkPos'=>5,
  			'watermarkPic'=>$cfg['path']['root'].'data/anleye.png',
  			'thumbDir'=>'borough/thumb/',
  			'originalPath'=>'borough/picture/',
  			'width'=>640,
  			'height'=>480,
  		),*/
  ),
  'newHouse' => array(
		'thumb' =>array(
  			'thumb'=>true,
  			'resizeType'=>1,
  			'thumbResizeType'=>1,
  			'thumbWidth'=>120,
  			'thumbHeight'=>161,
  			'watermarkPos'=>9,
  			'watermarkPic'=>'./Data/water/anleye.png',
  			'thumbDir'=>'borough/thumb/',
  			'originalPath'=>'borough/picture/',
  			'width'=>268,
  			'height'=>360,
  			'allowType' =>array('jpeg','jpg','gif','bmp','png')
  		),
  ),
  'house' => array(
  		'sell'=>array(
  			'thumb'=>true,
  			'resizeType'=>1,
  			'thumbResizeType'=>5,
  			'thumbWidth'=>320,
  			'thumbHeight'=>240,
  			'watermark'=>true,
  			'watermarkPos'=>9,
  			'watermarkPic'=>'./Data/water/anleye.png',
  			'thumbDir'=>'house/sell/'.date('Y').'/'.date('n').'/',
  			'originalPath'=>'house/sell/'.date('Y').'/'.date('n').'/',
  			'width'=>640,
  			'height'=>480,
				'exts' =>array('jpeg','jpg','gif','bmp','png'),
				'rootPath'=>'./Uploads/',
				'saveName'=>date('YmdHis').'_'.mt_rand(),
				'autoSub'=>false,
			//'subName'=>'',子目录创建方式可以使用函数,当autosub开启才有效
  		),
  		'rent'=>array(
  			'thumb'=>true,
  			'resizeType'=>1,
  			'thumbResizeType'=>5,
  			'thumbWidth'=>320,
  			'thumbHeight'=>240,
  			'watermark'=>true,
  			'watermarkPos'=>9,
  			'watermarkPic'=>$cfg['path']['root'].'data/anleye.png',
  			'thumbDir'=>'house/rent/'.date('Y').'/'.date('n').'/',
  			'originalPath'=>'house/rent/'.date('Y').'/'.date('n').'/',
  			'width'=>640,
  			'height'=>480,
  			'allowType' =>array('jpeg','jpg','gif','bmp','png')
  		),
  ),
  'broker' => array(
  		'identity'=>array(
  			'thumb'=>false,
  			'resizeType'=>1,
  			'watermark'=>false,
  			'originalPath'=>'broker/identity/',
  			'width'=>640,
  			'height'=>480,
  			'allowType' =>array('jpeg','jpg','gif','bmp','png')
  		),
		  		
		'avatar'=>array(
  			'thumb'=>false,
  			'resizeType'=>1,
  			'watermark'=>false,
  			'originalPath'=>'broker/avatar/',
  			'width'=>400,
  			'height'=>300,
  			'allowType' =>array('jpeg','jpg','gif','png')
  		),
		'banner'=>array(
  			'thumb'=>false,
  			'resizeType'=>0,
  			'watermark'=>false,
  			'originalPath'=>'broker/diy/',
  			'width'=>990,
  			'height'=>120,
  			'allowType' =>array('jpeg','jpg','gif','png')
  		),
		'background'=>array(
  			'thumb'=>false,
  			'resizeType'=>1,
  			'watermark'=>false,
  			'originalPath'=>'broker/diy/',
  			'allowType' =>array('jpeg','jpg','gif','png')
  		),
  		'aptitude'=>array(
  			'thumb'=>false,
  			'resizeType'=>1,
  			'watermark'=>false,
  			'originalPath'=>'broker/aptitude/',
  			'width'=>640,
  			'height'=>480,
  			'allowType' =>array('jpeg','jpg','gif','bmp','png')
  		),
  ),
  'ads' => array(
  		'pic'=>array(
  			'noResize'=>1, /* 不进行任何压缩 ，保证图片质量 */
  			'originalPath'=>'extend/pic/',
  			'allowType' =>array('jpeg','jpg','gif','bmp','png')
  		),
  		'flash'=>array(
  			'originalPath'=>'extend/flash/',
  			'allowType' =>array('swf')
  		),
  ),
    'company' => array(
  		'logo'=>array(
  			'noResize'=>0, /* 不进行任何压缩 ，保证图片质量 */
  			'originalPath'=>'company/logo/',
			'width'=>240,
  			'height'=>70,
  			'allowType' =>array('jpeg','jpg','gif','bmp','png')
  		),
  ),
  
   'city' => array(
  		'logo'=>array(
  			'noResize'=>1, /* 不进行任何压缩 ，保证图片质量 */
  			'originalPath'=>'city/logo/',
  			'allowType' =>array('jpeg','jpg','gif','bmp','png')
  		),
  ),
  'link' => array(
  		'logo'=>array(
  			'noResize'=>1, /* 不进行任何压缩 ，保证图片质量 */
  			'originalPath'=>'outlink/',
  			'allowType' =>array('jpeg','jpg','gif','bmp','png')
  		),
  ),

	 'ueditor' => array(
				  'rent'=>array(
						  'thumb'=>true,
						  'resizeType'=>1,
						  'thumbResizeType'=>5,
						  'thumbWidth'=>320,
						  'thumbHeight'=>240,
						  'watermark'=>true,
						  'watermarkPos'=>9,
						  'watermarkPic'=>'./Data/water/anleye.png',
						  'thumbDir'=>'ueditor/rent/'.date('Y').'/'.date('n').'/',
						  'originalPath'=>'ueditor/rent/'.date('Y').'/'.date('n').'/',
						  'width'=>640,
						  'height'=>480,
						  'exts' =>array('jpeg','jpg','gif','bmp','png'),
						  'rootPath'=>'./Uploads/',
						  'saveName'=>date('YmdHis').'_'.mt_rand(),
						  'autoSub'=>false,
					  //'subName'=>'',子目录创建方式可以使用函数,当autosub开启才有效
				  ),
		  ),


);
?>