<?php
return array(
	'index'	=> array(
		'caption' => '��ҳ',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
			'index' => array('caption' => '��վ��Ϣ', 'url' => 'main.php'),	
			'webConfig' => array('caption' => '��վ����', 'url' => 'webConfig/webConfig.php'),		
		),
	),	
	
	'house'	=> array(
		'caption' => '��Դ����',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
			'houseSell' => array('caption' => '���۹���', 'url' => 'house/sell.php?check=0'),
			'houseRent' => array('caption' => '�������', 'url' => 'house/rent.php?check=0'),
			'houseBuy' => array('caption' => '�󹺹���', 'url' => 'house/buy.php'),
			'houseHold' => array('caption' => '�������', 'url' => 'house/hold.php'),
			'consignSale' => array('caption' => 'ί�г���', 'url' => 'house/consign.php'),
			'houseReport' => array('caption' => '��Դ��پٱ�', 'url' => 'house/report.php?status=0'),
		),
	),
	'borough' => array(
		'caption' => 'С������',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
			'boroughCheck' => array('caption' => '�����С��', 'url' => 'borough/check.php'),
			'boroughList' => array('caption' => 'С�������б�', 'url' => 'borough/index.php'),
			'boroughUpdateCheck' => array('caption' => 'С���������', 'url' => 'borough/updateCheck.php?status=0'),
			'boroughEvaluate' => array('caption' => '�����۸���', 'url' => 'borough/evaluate.php'),             'pingguDd' => array('caption' => '����ϵ������', 'url' => 'pinggu/dd.php'),
		),
	),
		'newHouse' => array(
		'caption' => '���̹���',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
			'boroughList' => array('caption' => '�����б�', 'url' => 'newHouse/index.php?check=1'),
		),
	),
		'company' => array(
		'caption' => '��˾����',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
			'companyList' => array('caption' => '�н鹫˾', 'url' => 'company/index.php?type=0'),
			'moveCompanyList' => array('caption' => '��ҹ�˾', 'url' => 'company/index.php?type=1'),
			'decorationCompanyList' => array('caption' => 'װ�޹�˾', 'url' => 'company/index.php?type=2'),
		),
	),
	'trend' => array(
		'caption' => '��������',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
			'houseSellTrend' => array('caption' => '��������ͼ', 'url' => 'trend/sell.php'),
		),
	),
	'member' => array(
		'caption' => '��Ա����',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
		    'user' => array('caption' => 'ϵͳ�û�����', 'url' => 'user/user.php'),
			'group' => array('caption' => '�û������', 'url' => 'user/group.php'),
			'brokerList' => array('caption' => '�����˹���', 'url' => 'member/index.php'),
			'memberIdentity' => array('caption' => '������', 'url' => 'member/identity.php?status=0'),
			'memberAptitude' => array('caption' => '�������', 'url' => 'member/aptitude.php?status=0'),
			'memberAvatar' => array('caption' => 'ͷ�����', 'url' => 'member/avatar.php?status=0'),
			'evaluate' => array('caption' => '���۹���', 'url' => 'member/evaluate.php'),
		),
	),
	
	'about' => array(
		'caption' => '��������',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
	    	'about' => array('caption' => '��������', 'url' => 'about/about.php'),
	    	'talented' => array('caption' => '�˲���Ƹ', 'url' => 'about/talented.php'),
			'agreement' => array('caption' => '�û�Э��', 'url' => 'about/agreement.php'),
			'copyright' => array('caption' => '��Ȩ����', 'url' => 'about/copyright.php'),
			'contact' => array('caption' => '��ϵ����', 'url' => 'about/contact.php'),

		),
	),
	
	'city' => array(
		'caption' => '�����',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
	    	'city' => array('caption' => '���й���', 'url' => 'city/index.php'),
	    	'union' => array('caption' => '���˹���', 'url' => 'city/union.php'),
		

		),
	),
	'system' => array(
		'caption' => 'ϵͳ����',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
	    	'dd' => array('caption' => 'ȫ�ֲ���', 'url' => 'dd/dd.php'),
	    	'appointment' => array('caption' => '��ԴԤԼˢ��', 'url' => 'appointment/index.php'),
			'crontab' => array('caption' => '�ƻ�����ִ��', 'url' => 'webConfig/crontab.php'),
			'integralRule' => array('caption' => '���ֹ���', 'url' => 'rule/index.php'),
			'messageRule' => array('caption' => '�Զ�վ���Ź���', 'url' => 'rule/message.php'),
			'innernote' => array('caption' => 'վ����Ϣ', 'url' => 'innernote/index.php'),
			'map' => array('caption' => '��ͼ����', 'url' => 'map/index.php'),
			'price' => array('caption' => '�۸�����', 'url' => 'webConfig/price.php'),		
			'pay' => array('caption' => '֧������', 'url' => 'webConfig/pay.php'),		
			'seo' => array('caption' => 'SEO�ؼ���', 'url' => 'webConfig/seo.php'),	
			'advertise' => array('caption' => '������', 'url' => 'advertise/index.php'),
			'linkClass' => array('caption' => '�������ӷ���', 'url' => 'link/class.php'),
			'link' => array('caption' => '��������', 'url' => 'link/index.php'),
			'editpwd' => array('caption' => '�޸�����', 'url' => 'user/editpwd.php'),
		),
	),
	
	
); 
	

?>