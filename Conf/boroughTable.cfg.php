<?php
/**
 * type: dd / timestamp / image / custom / default:string
 *
 */
return array(
	'borough_name'	=> array('caption' => '小区名称',	'table' => 'borough'),
	'borough_alias'	=> array('caption' => '小区别名',	'table' => 'borough'),
	'cityarea_id'	=> array('caption' => '所在区域','table' => 'borough','type'=>'dd','dd_name'=>'cityarea'),
	'borough_address'	=> array('caption' => '小区地址','table' => 'borough'),
	'borough_section'	=> array('caption' => '所属板块','table' => 'borough','type'=>'dd','dd_name'=>'borough_section'),
	'borough_type'	=> array('caption' => '物业类型','table' => 'borough','type'=>'dd','dd_name'=>'borough_type'),
	'elementary_school'	=> array('caption' => '划片小学','table' => 'borough'),
	'middle_school'	=> array('caption' => '划片中学','table' => 'borough'),
	'sell_time'	=> array('caption' => '开盘时间','table' => 'borough'),
	'borough_avgprice'	=> array('caption' => '开盘均价','table' => 'borough'),
	'borough_thumb'	=> array('caption' => '小区缩略图','table' => 'borough','type'=>'image','num'=>1),
	'sell_price'=> array('caption' => '开盘起价','table' => 'borough'),
	'room_type'=> array('caption' => '主推户型','table' => 'borough'),
	'sell_phone'=> array('caption' => '销售热线','table' => 'borough'),
	'borough_developer'	=> array('caption' => '开发商','table' => 'borough_info'),
	'borough_company'	=> array('caption' => '物业公司','table' => 'borough_info'),
	'borough_costs'	=> array('caption' => '物业费','table' => 'borough_info'),
	'borough_totalarea'	=> array('caption' => '建筑面积','table' => 'borough_info'),
	'borough_area'	=> array('caption' => '占地面积','table' => 'borough_info'),
	'borough_green'	=> array('caption' => '绿化率','table' => 'borough_info'),
	'borough_volume'	=> array('caption' => '容积率','table' => 'borough_info'),
	'borough_parking'	=> array('caption' => '停车位','table' => 'borough_info'),
	'borough_number'	=> array('caption' => '总户数','table' => 'borough_info'),
	'borough_completion'	=> array('caption' => '竣工日期','table' => 'borough_info'),
	'borough_support'	=> array('caption' => '小区配套','table' => 'borough_info','type'=>'dd','dd_name'=>'borough_support'),
	'borough_bus'	=> array('caption' => '公交线路','table' => 'borough_info'),
	'borough_shop'	=> array('caption' => '商场购物','table' => 'borough_info'),
	'borough_hospital'	=> array('caption' => '药店医院','table' => 'borough_info'),
	'borough_bank'	=> array('caption' => '银行','table' => 'borough_info'),
	'borough_dining'	=> array('caption' => '餐馆','table' => 'borough_info'),
	'borough_sight'	=> array('caption' => '公园景观','table' => 'borough_info','type'=>'dd','dd_name'=>'borough_sight'),
	'borough_content'	=> array('caption' => '小区简介','table' => 'borough_info'),
	'project_site'	=> array('caption' => '项目网站','table' => 'borough_info'),
	'company_site'	=> array('caption' => '公司网站','table' => 'borough_info'),
	'sale_office'	=> array('caption' => '售楼处','table' => 'borough_info'),
	'sale_licence'	=> array('caption' => '销售许可证','table' => 'borough_info'),
	'borough_draw'	=> array('caption' => '小区户型图','table' => 'borough_draw','type'=>'image','num'=>10),
	'borough_pic'	=> array('caption' => '小区实景图','table' => 'borough_pic','type'=>'image','num'=>10),
);

?>