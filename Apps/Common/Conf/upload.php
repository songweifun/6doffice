<?php 
/**
 * resizeType:�������ͣ� 0=����ת���ɲ���ָ���� 1=���������ţ�����Լ���ڲ���ָ���ڣ�2=�Կ�ΪԼ�����ţ�3=�Ը�ΪԼ������,4 :�ü����Ͻ�
 * pathdir: 'upfile/'+pathdir+'filename' ;//����Ҫ��б��
 * pos ˮӡλ�� ���վŹ�ͼλ�� 0-9 ����������
 * watermarkPic ˮӡ����   ������ͼ���ļ�����Ҳ����������
 * �Ȳ���ʹ��Ŀ¼�����Ŀ¼�ļ�̫����Ҫ���µ���ͼƬĿ¼�洢λ��
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
			//'subName'=>'',��Ŀ¼������ʽ����ʹ�ú���,��autosub��������Ч
  		),
  		//С������Ҫ����һ��ͼƬ
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
			//'subName'=>'',��Ŀ¼������ʽ����ʹ�ú���,��autosub��������Ч
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
  			'noResize'=>1, /* �������κ�ѹ�� ����֤ͼƬ���� */
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
  			'noResize'=>0, /* �������κ�ѹ�� ����֤ͼƬ���� */
  			'originalPath'=>'company/logo/',
			'width'=>240,
  			'height'=>70,
  			'allowType' =>array('jpeg','jpg','gif','bmp','png')
  		),
  ),
  
   'city' => array(
  		'logo'=>array(
  			'noResize'=>1, /* �������κ�ѹ�� ����֤ͼƬ���� */
  			'originalPath'=>'city/logo/',
  			'allowType' =>array('jpeg','jpg','gif','bmp','png')
  		),
  ),
  'link' => array(
  		'logo'=>array(
  			'noResize'=>1, /* �������κ�ѹ�� ����֤ͼƬ���� */
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
					  //'subName'=>'',��Ŀ¼������ʽ����ʹ�ú���,��autosub��������Ч
				  ),
		  ),


);
?>