<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/21
 * Time: 下午4:36
 */

/*
=======================================================================
网站域名授权代码
*/
$page->authorizeCode1 = 'd8301b4ecf6b545d350dccd05cabfcd4';   //主域名 例如 a.cn
$page->authorizeCode2 = '';    //二级域名  例如 www.a.cn


/*
=======================================================================
网站的基本配置信息
*/

$webConfig = C('BASE');//C('BASE')是一个数组配置项 然后在每个公共控制其中设置$page=$this 再用require引入page.php即可把所有的配置项分配到前台
$page->title = $webConfig['base_title'];   //网站名称
$page->sinaapp = $webConfig['sinaapp'];   //新浪微博关注ID
$page->titlec = $webConfig['base_titlec'];   //网站名称  一定要与上面的名称一直
$page->city = $webConfig['base_city'];   //所在的城市，也就是说网站经营范围
$page->newsOpen = $webConfig['newsopen'];   //是否开启新闻频道  1：开启  2：不开启
$page->bbsOpen = $webConfig['bbsopen'];   //是否开启论坛频道  1：开启  2：不开启
$page->mapcity = $webConfig['base_mapcity'] ;   //地图归属地区 （例如：哈尔滨市 一定要加“市”）
$page->switch_url = $webConfig['switch_url'] ;   //切换城市地址
$page->citySwitch_site = $webConfig['citySwitch_site'] ;   //切换城市地址
$page->shop = $webConfig['base_is_shop'];   //经纪人是否需要实名认证才开通网店  1：是  2：不是
$page->guest = $webConfig['base_is_guest'] ;   //是否开通游客发布功能  1：是  2：不是
$page->memberOpen = $webConfig['base_member_open'] ;   //是否开通免费经纪人注册  1：是  2：不是
$page->googlekey = $webConfig['base_googlekey'];   //google地图KEY
$page->tongji = $webConfig['base_tongji'];  //统计代码
$page->beian = $webConfig['base_beian'] ;  //网站备案号
$page->uc = $webConfig['base_uc'] ;  //是否开启uc     1：是    2：不是
$page->newhouseOpen = $webConfig['newhouseopen'] ;  //是否开启新房频道     1：是    2：不是
$page->lat = $webConfig['lat'] ;
$page->lnt = $webConfig['lnt'] ;
$page->expired_switch = $webConfig['expired_switch'] ;    //1:开启 2：不开启

/*
=======================================================================
公司以及联系信息
*/
$page->gongsi = $webConfig['contact_gongsi']  ;  //公司名称
$page->dizhi = $webConfig['contact_dizhi']  ;  //公司地址
$page->youbian = $webConfig['contact_youbian']  ;  //邮编
$page->chuanzhen = $webConfig['contact_chuanzhen']  ;  //传真
$page->phone = $webConfig['contact_dianhua']  ;  //联系电话
$page->rexian = $webConfig['contact_rexian']  ;  //客服热线
$page->qq = $webConfig['contact_qq'] ;   //QQ号码

/*
=======================================================================
用户服务类型套餐价格
*/
$page->vip1Price = $webConfig['vip_vip1_price'];   //服务套餐1价格
$page->vip1SaleNum = $webConfig['vip_vip1_sale_num'];  //出售房源套数
$page->vip1RentNum = $webConfig['vip_vip1_rent_num'];  //出租房源套数
$page->vip1Vexation = $webConfig['vip_vip1_vexation'];   //急售标签
$page->vip1refresh = $webConfig['vip_vip1_refresh'];   //刷新次数

$page->vip2Price = $webConfig['vip_vip2_price'];    //服务套餐2价格
$page->vip2SaleNum = $webConfig['vip_vip2_sale_num'];  //出售房源套数
$page->vip2RentNum = $webConfig['vip_vip2_rent_num'];  //出租房源套数
$page->vip2Vexation = $webConfig['vip_vip2_vexation'];   //急售标签
$page->vip2refresh = $webConfig['vip_vip2_refresh'];   //刷新次数


/*
=======================================================================
关键词描述
*/
$page->index_keyword = $webConfig['index_keyword'];
$page->index_description = $webConfig['index_description'];

$page->sale_keyword = $webConfig['sale_keyword'];
$page->sale_description = $webConfig['sale_description'];

$page->rent_keyword = $webConfig['rent_keyword'];
$page->rent_description = $webConfig['rent_description'];

$page->broker_keyword = $webConfig['broker_keyword'];
$page->broker_description = $webConfig['broker_description'];

$page->newhouse_keyword = $webConfig['newhouse_keyword'];
$page->newhouse_description = $webConfig['newhouse_description'];

$page->community_keyword = $webConfig['community_keyword'];
$page->community_description = $webConfig['community_description'];

/*
=======================================================================
计划任务时间
*/
$page->borough_avg_time = $webConfig['borough_avg_time'];
$page->broker_integral_time = $webConfig['broker_integral_time'];
$page->broker_active_Rate_time = $webConfig['broker_active_Rate_time'];
$page->statistics_time = $webConfig['statistics_time'];
$page->borough_pic_num_time = $webConfig['borough_pic_num_time'];
$page->house_invalid_time = $webConfig['house_invalid_time'];


/*
=======================================================================
房源主题信息
*/
$page->themesDescription = $webConfig['themesDescription'];
$page->themesMessage = $webConfig['themesMessage'];

/*
=======================================================================
网站的电子商务配置信息
支付宝、出售单价、出租单价
*/
$page->alipay = $webConfig['alipay_name'] ;                  //你的支付宝帐号
$page->partner = $webConfig['alipay_partner'] ;               //支付宝合作ID
$page->security_code = $webConfig['alipay_security_code'] ;   //支付宝安全检验码
$page->sellPrice = $webConfig['alipay_sell_price'] ;   //出售房源置顶单价  单位元
$page->rentPrice = $webConfig['alipay_rent_price'] ;   //出售房源置顶单价  单位元
$page->sellNum = $webConfig['alipay_sell_num'] ;   //购买出售条数单价  单位元
$page->rentNum = $webConfig['alipay_rent_num'] ;   //购买出租条数单价  单位元

?>
