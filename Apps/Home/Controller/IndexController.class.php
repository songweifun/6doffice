<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController{

    public function index(){
        $page=$this;
        //网站名称
        $this->title = $page->city.'二手房，'.$page->city.'租房 - '. $page->titlec.' 专业的'.$page->city.'房产网站';
        //关键词和描述
        $this->keyword = $page->index_keyword;
        $this->description = $page->index_description;
        //echo $page->index_keyword;

        $houseSell = D('HouseSellView');
        $houseRent = D('houseRentView');
        $borough = M('borough');
        $statistics = M('statistics');
        //$consign = M('house_consign');
        $member = D('MemberView');
        //最新发布
        $todaySell=$houseSell->getCount(6," and timestampdiff(day ,from_unixtime(created, '%Y-%m-%d'),now())<=1");
        $todayRent=$houseRent->getCount(6," and timestampdiff(day ,from_unixtime(created, '%Y-%m-%d'),now())<=1");
        $addFangNum= $todaySell+$todayRent;
        $this->assign('addFangNum', $addFangNum);
        //区域字典
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);
        //面积
        $house_totalarea_option = array(
            '0-50'=>'50㎡以下',
            '50-70'=>'50-70㎡',
            '70-90'=>'70-90㎡',
            '90-110'=>'90-110㎡',
            '110-130'=>'110-130㎡',

        );
        $this->assign('house_totalarea_option', $house_totalarea_option);

        //二手房价
        $house_price_option = array(
            '0-40'=>'40万以下',
            '40-60'=>'40-60万',
            '60-80'=>'60-80万',
            '80-100'=>'80-100万',
            '100-120'=>'100-120万',
            '120-150'=>'120-150万',
        );
        $this->assign('house_price_option', $house_price_option);

        //租房价格
        $house_price_rent_option = array(
            '0-600'=>'600元以下',
            '600-800'=>'600-800元',
            '800-1000'=>'800-1000元',
            '1000-1200'=>'1000-1200元',
            '1200-1500'=>'1200-1500元',
            '1500-2000'=>'1500-2000元',
            '2000-3000'=>'2000-3000元',
        );
        $this->assign('house_price_rent_option', $house_price_rent_option);

        //取得首页友情文字链接
        $lianjie = M('outlink');
        $lianjie_s=$lianjie->where(array('link_type'=>1))->order('list_order asc')->select();
        $this->assign('lianjie_s', $lianjie_s);

        //取得首页友情图片链接
        $lianjie_a = $lianjie->where(array('link_type'=>2))->order('list_order asc')->select();
        $this->assign('lianjie_a', $lianjie_a);
        //取得推荐中介公司
        $company=M('company');
        $companyList=$company->where(array('status'=>1,'type'=>0))->limit("0,6")->select();
        $this->assign('companyList', $companyList);
        //猜你喜欢出售
        $houseSellLike=M('housesell')->where(array('status'=>1,'is_like'=>1,'is_checked'=>1))->order('order_weight desc')->limit('0,3')->select();
        foreach ($houseSellLike as $key =>$item ){
            $houseSellLike[$key]['title'] = substrs($item['house_title'],14);
            $houseSellLike[$key]['cityarea_name'] = $cityarea_option[$item['cityarea_id']];
            $houseSellLike[$key]['description'] = $item['house_room'].'室'.$item['house_hall'].'厅，'.$item['house_totalarea'].'平米';
        }
        $this->assign('houseSellLike', $houseSellLike);
        //猜你喜欢出租
        $houseRentLike=M('houserent')->where(array('status'=>1,'is_like'=>1,'is_checked'=>1))->order('order_weight desc')->limit('0,3')->select();
        foreach ($houseRentLike as $key =>$item ){
            $houseRentLike[$key]['title'] = substrs($item['house_title'],14);
            $houseRentLike[$key]['cityarea_name'] = $cityarea_option[$item['cityarea_id']];
            $houseRentLike[$key]['description'] = $item['house_room'].'室'.$item['house_hall'].'厅，'.$item['house_totalarea'].'平米';
        }
        $this->assign('houseRentLike', $houseRentLike);
        //主题推荐
        $houseSellThemes=M('housesell')->where(array('status'=>1,'is_themes'=>1,'is_checked'=>1))->order('order_weight desc')->limit(4)->select();
        foreach ($houseSellThemes as $key =>$item ){
            $houseSellThemes[$key]['title'] = substrs($item['house_title'],14);
            $houseSellThemes[$key]['cityarea_name'] = $cityarea_option[$item['cityarea_id']];
            $houseSellThemes[$key]['description'] = $item['house_room'].'室'.$item['house_hall'].'厅，'.$item['house_totalarea'].'平米';
        }
        $this->assign('houseSellThemes', $houseSellThemes);

        //主题推荐
        $houseSellThemes1=M('housesell')->where(array('status'=>1,'is_themes'=>1,'is_checked'=>1))->order('order_weight desc')->limit('0,1')->select();
        foreach ($houseSellThemes as $key =>$item ){
            $houseSellThemes[$key]['title'] = substrs($item['house_title'],14);
            $houseSellThemes[$key]['cityarea_name'] = $cityarea_option[$item['cityarea_id']];
            $houseSellThemes[$key]['description'] = $item['house_room'].'室'.$item['house_hall'].'厅，'.$item['house_totalarea'].'平米';
        }
        $this->assign('houseSellThemes1', $houseSellThemes);

        //经纪人列表
        $brokerList=$member->where(array('status'=>0,'user_type'=>1))->order('e_accurate desc')->limit('0,5')->select();

        foreach ($brokerList as $key =>$item ){
            if($item['company_id']){
                $brokerList[$key]['company_name'] = $company->where(array('id'=>$item['company_id']))->getField('company_name');
            }
        }
        $this->assign('brokerList', $brokerList);

        //优质二手房
        $houseSellBest =M('housesell')->where(array('status'=>1,'is_index'=>1,'is_checked'=>1))->order('order_weight desc')->limit('0,5')->select();
        foreach ($houseSellBest as $key =>$item ){
            $houseSellBest[$key]['title'] = substrs($item['house_title'],14);
            $houseSellBest[$key]['cityarea_name'] = $cityarea_option[$item['cityarea_id']];
            $houseSellBest[$key]['description'] = $item['house_room'].'室'.$item['house_hall'].'厅，'.$item['house_totalarea'].'平米';
        }
        $this->assign('houseSellBest', $houseSellBest);
        //优质租房
        $houseRentBest=M('houserent')->where(array('status'=>1,'is_index'=>1,'is_checked'=>1))->order('order_weight desc')->limit('0,5')->select();
        foreach ($houseRentBest as $key =>$item ){
            $houseRentBest[$key]['title'] =substrs($item['house_title'],14);
            $houseRentBest[$key]['cityarea_name'] = substr($cityarea_option[$item['cityarea_id']],0,-2);
            $houseRentBest[$key]['description'] = $item['house_room'].'室'.$item['house_hall'].'厅，'.$item['house_totalarea'].'平米';
        }
        $this->assign('houseRentBest', $houseRentBest);

        //最新二手房
        $houseSellNew =M('housesell')->where(array('status'=>1,'is_checked'=>1))->order('update_order desc')->limit('0,10')->select();
        foreach ($houseSellNew as $key =>$item ){
            $houseSellNew[$key]['borough_name'] = $borough->where(array('id'=>$item['borough_id']))->getField('borough_name');
            $houseSellNew[$key]['cityarea_name'] = $cityarea_option[$item['cityarea_id']];
            $houseSellNew[$key]['description'] = $item['house_room'].'室';
        }
        $this->assign('houseSellNew', $houseSellNew);
        //最新租房
        $houseRentNew =M('houserent')->where(array('status'=>1,'is_checked'=>1))->order('update_order desc')->limit('0,10')->select();
        foreach ($houseRentNew as $key =>$item ){
            $houseRentNew[$key]['borough_name'] = $borough->where(array('id'=>$item['borough_id']))->getField('borough_name');
            $houseRentNew[$key]['cityarea_name'] = $cityarea_option[$item['cityarea_id']];
            $houseRentNew[$key]['description'] = $item['house_room'].'室';
        }
        $this->assign('houseRentNew', $houseRentNew);

        //小区列表
        $boroughList = $borough->where(array('isdel'=>0,'is_checked'=>1))->order('sell_num+rent_num desc')->limit('0,13')->select();
        foreach ($boroughList as $key =>$item ){
            $boroughList[$key]['cityarea_name'] = $cityarea_option[$item['cityarea_id']];
            $boroughList[$key]['borough_name'] = substrs($item['borough_name'],14);
        }
       $this->assign('boroughList', $boroughList);

        $boroughHot = $borough->where(array('isdel'=>0,'is_checked'=>1))->order('sell_num+rent_num desc')->limit('0,4')->select();
       $this->assign('boroughHot', $boroughHot);


        $allNum = $statistics->where(array('stat_class'=>'allNum'))->select();
        $allNum=array_to_hashmap($allNum,'stat_index','stat_value');
        $this->assign('statistics', $allNum);
        //p($allNum);die;

        //取二手房均价
        $val = $statistics->where(array('stat_class'=>'val'))->select();
        $val=array_to_hashmap($val,'stat_index','stat_value');
        $this->assign('val', $val);


        //字典
        $house_type_option = getArray('house_type');
       $this->assign('house_type_option', $house_type_option);

        //特色
        $house_toword_option = getArray('house_toward');
       $this->assign('house_toword_option', $house_toword_option);

       $this->assign('menu', 'index');

        //p($house_toword_option);die;
        $this->host=$_SERVER['SERVER_NAME'];


        $this->display();

        //小区均价与评估价更新
        $dotime = D('DoTime');

        $today = mktime(0,0,0,date('m'),date('d'),date('Y'));
        $toTime = $dotime->find();
        //p($today);die;

        if($today>$toTime['borough_avg']){
            $borough_avg_time=$this->borough_avg_time;
            $dotime->boroughAvg($borough_avg_time);
        }

         //经纪人房源数量统计
        if($today>$toTime['member_num']){
            $dotime->memberNum($this->member_num_time);
        }

        //经纪人活跃度统计
        if($today>$toTime['broker_active_rate']){
            $dotime->brokerActiveRate($this->broker_active_Rate_time);
        }

        //经纪人登录积分增加
        if($today>$toTime['broker_integral']){
            $dotime->brokerIntegral($this->broker_integral_time);
        }

        //全站统计
        if($today>$toTime['statistics']){
            $dotime->statistics($this->statistics_time);
        }

        //小区图片数量导入
        if($today>$toTime['borough_pic_num']){
            $dotime->boroughPicNum($this->borough_pic_num_time);
        }

        //房源刷新执行
        $dotime->dorefresh($this->vip1refresh,$this->vip2refresh);


        //房源过期处理
        if ($this->expired_switch==1){
            if($today>$toTime['houseInvalid']){
                $dotime->houseInvalid($this->house_invalid_time);
            }
        }
    }

    /**
     * 广告
     */
    public function ad(){
        //p($_SERVER);die;
        $id=I('id',0,'intval');
        $ads=M('ads');
        $adInfo=$ads->where(array('id'=>$id,'status'=>0))->find();
        $this->assign('dataInfo', $adInfo);

        $this->display();

    }

    public function swfapi(){
        $trend=M('housesell_trend');
        $rel=$trend->order('time desc')->limit(6)->select();
        echo "&curveKey=price&";
        foreach($rel as $key=>$row){

            echo "&num".$key."=".$row["number"];

        }

        echo "&\r\n";

        foreach($rel as $key=>$row){

            echo "&price".$key."=".$row["price"];

        }
        echo "&\r\n";

        foreach($rel as $key=>$row){

            echo "&area".$key."=".$row["area"];

        }
        echo "&\r\n";

        foreach($rel as $key=>$row){

            echo "&date".$key."=".$row["time"];

        }
    }

}