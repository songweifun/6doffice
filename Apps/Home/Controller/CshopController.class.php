<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/20
 * Time: 上午8:11
 */
namespace Home\Controller;
use Think\Controller;
class CshopController extends CommonController{
    public function index(){
        $id = intval($_GET['id']);
        if($id ==0){
            $this->error('参数错误');
        }
        //店长信息
        $company = M('company');
        $dataInfo = $company->where(array('id'=>$id))->find();
        if(!$dataInfo){
            $this->error('该店铺不存在');
        }



        if($dataInfo['type']!=0){
            $showname='index1';
        }else{
            $showname='index';
        }
        //p($showname);die;
        $this->assign('dataInfo', $dataInfo);

        $this->title = $dataInfo['company_name']."的门店 - ".$this->title;
        //公司网站样式判断
        if($dataInfo['company_style']){
            $this->assign('stylecss',$dataInfo['company_style']);
        }else{
            $this->assign('stylecss','shopStyleDefault.css');
        }
        //实例化和字典
        $houseSell =M('housesell');
        $houseRent = M('houserent');
        $house_fitment_option = getArray('house_fitment');
        //店长二手房列表

        $companySaleList = $houseSell->where('is_checked=1 and status=1  and company_id ='.$id)->order('created desc')->limit(7)->select();

        foreach($companySaleList as $key=>$item){
            if($item['house_totalarea']){
                $companySaleList[$key]['avg_price']=round($item['house_price']*10000/$item['house_totalarea']);
            }else{
                $companySaleList[$key]['avg_price'] ='0';
            }
        }
        $this->assign('companySaleList', $companySaleList);
        //店长租房列表
        $companyRentList = $houseRent->where('is_checked=1 and status=1  and company_id ='.$id)->order('created desc')->limit(7)->select();
        foreach($companyRentList as $key=>$item){
            $companyRentList[$key]['house_fitment'] =$house_fitment_option[$item['house_fitment']];
        }
        $this->assign('companyRentList', $companyRentList);

        //二手房按小区统计出售
        $saleCountBorough = $houseSell->field(array('borough_id','count(*)'=>'house_num'))->where('status =1 and borough_id !=0 and company_id = '.$id)->group('borough_id')->having('house_num >=2')->select();
        $borough = M('borough');
        foreach ($saleCountBorough as $key => $item){
            $saleCountBorough[$key]['borough_name'] = $borough->where(array('id'=>$item['borough_id']))->getField('borough_name');
        }
        $this->assign('saleCountBorough', $saleCountBorough);
        //二手房按价格统计
        $sell_price_option = array(
            array('price'=>'0-40','house_price'=>'40万以下'),
            array('price'=>'40-60','house_price'=>'40-60万'),
            array('price'=>'60-80','house_price'=>'60-80万'),
            array('price'=>'80-100','house_price'=>'80-100万'),
            array('price'=>'100-120','house_price'=>'100-120万'),
            array('price'=>'120-150','house_price'=>'120-150万'),
            array('price'=>'150-200','house_price'=>'150-200万'),
            array('price'=>'200-250','house_price'=>'200-250万'),
            array('price'=>'250-300','house_price'=>'250-300万'),
            array('price'=>'300-500','house_price'=>'300-500万'),
            array('price'=>'500-0','house_price'=>'500万以上'),
        );
        foreach ($sell_price_option as $key=>$item){
            $where = " and status =1 and company_id=".$id;
            $temp = explode('-',$item['price']);
            if($temp[0]){
                $where .= ' and house_price>='.$temp[0];
            }
            if($temp[1]){
                $where .= ' and house_price<='.$temp[1];
            }
            $house_num = $houseSell->where('is_checked = 1'.$where)->count();
            if($house_num){
                $item['house_num'] = $house_num;
                $saleCountPrice[$key] =$item;
            }
        }
        $this->assign('saleCountPrice', $saleCountPrice);
        //二手房按房间数统计
        $house_room_option = array(
            1=>"一室",
            2=>"二室",
            3=>"三室",
            4=>"四室",
            5=>"五室",
            6=>"其他"
        );
        $saleCountRoom = $houseSell->field(array('house_room','count(*)'=>'house_num'))->where('status =1 and company_id = '.$id)->group('house_room')->having('house_num >=0')->select();
        foreach($saleCountRoom as $key=>$item){
            if($house_room_option[$item['house_room']]){
                $saleCountRoom[$key]['room'] = $item['house_room'];
                $saleCountRoom[$key]['house_room'] = $house_room_option[$item['house_room']];
            }else{
                unset($saleCountRoom[$key]);
            }
        }
        $this->assign('saleCountRoom', $saleCountRoom);

        //租房按小区统计
        $rentCountBorough = $houseRent->field(array('borough_id','count(*)'=>'house_num'))->where('status =1 and borough_id !=0 and company_id = '.$id)->group('borough_id')->having('house_num >=2')->select();
        $borough = M('borough');

        foreach ($rentCountBorough as $key => $item){
            $rentCountBorough[$key]['borough_name'] = $borough->where(array('id'=>$item['borough_id']))->getField('borough_name');

        }
        $this->assign('rentCountBorough', $rentCountBorough);
        //租房按价格统计

        $rent_price_option = array(
            array('price'=>'0-600','house_price'=>'600元以下'),
            array('price'=>'600-800','house_price'=>'600-800元'),
            array('price'=>'800-1000','house_price'=>'800-1000元'),
            array('price'=>'1000-1200','house_price'=>'1000-1200元'),
            array('price'=>'1200-1500','house_price'=>'1200-1500元'),
            array('price'=>'1500-2000','house_price'=>'1500-2000元'),
            array('price'=>'2000-3000','house_price'=>'2000-3000元'),
            array('price'=>'3000-4000','house_price'=>'3000-4000元'),
            array('price'=>'4000-5000','house_price'=>'4000-5000元'),
            array('price'=>'5000-0','house_price'=>'5000元以上'),
        );
        foreach ($rent_price_option as $key=>$item){
            $where = " and status =1 and company_id=".$id;
            $temp = explode('-',$item['price']);
            if($temp[0]){
                $where .= ' and house_price>='.$temp[0];
            }
            if($temp[1]){
                $where .= ' and house_price<='.$temp[1];
            }
            $house_num = $houseRent->where('is_checked = 1'.$where)->count();
            if($house_num){
                $item['house_num'] = $house_num;
                $rentCountPrice[$key] =$item;
            }
        }
        $this->assign('rentCountPrice', $rentCountPrice);

        //租房按房间统计
        $house_room_option = array(
            1=>"一室",
            2=>"二室",
            3=>"三室",
            4=>"四室",
            5=>"五室",
            6=>"其他"
        );
        $rentCountRoom = $houseRent->field(array('house_room','count(*)'=>'house_num'))->where('status =1 and company_id = '.$id)->group('house_room')->having('house_num >=0')->select();
        foreach($rentCountRoom as $key=>$item){
            if($house_room_option[$item['house_room']]){
                $rentCountRoom[$key]['room'] = $item['house_room'];
                $rentCountRoom[$key]['house_room'] = $house_room_option[$item['house_room']];
            }else{
                unset($rentCountRoom[$key]);
            }
        }
        $this->assign('rentCountRoom', $rentCountRoom);
        $this->display($showname);
    }

    /**
     * 二手房
     */
    public function sell(){
        $id = intval($_GET['id']);
        if($id ==0){
            $this->error('参数错误');
        }
        //店长信息
        $company = M('company');
        $dataInfo = $company->where(array('id'=>$id))->find();
        if(!$dataInfo){
            $this->error('该店铺不存在');
        }
        $this->assign('dataInfo', $dataInfo);
        $this->title = $dataInfo['company_name']."的门店 - 二手房 - ".$this->title;
        if($dataInfo['company_style']){
            $this->assign('stylecss',$dataInfo['company_style']);
        }else{
            $this->assign('stylecss','shopStyleDefault.css');
        }
        //实例化和字典
        $houseSell =M('housesell');
        $houseRent = M('houserent');
        $house_fitment_option = getArray('house_fitment');

        //二手房按小区统计出售
        $saleCountBorough = $houseSell->field(array('borough_id','count(*)'=>'house_num'))->where('status =1 and borough_id !=0 and company_id = '.$id)->group('borough_id')->having('house_num >=2')->select();
        $borough = M('borough');
        foreach ($saleCountBorough as $key => $item){
            $saleCountBorough[$key]['borough_name'] = $borough->where(array('id'=>$item['borough_id']))->getField('borough_name');
        }
        $this->assign('saleCountBorough', $saleCountBorough);

        //二手房按价格统计
        $sell_price_option = array(
            array('price'=>'0-40','house_price'=>'40万以下'),
            array('price'=>'40-60','house_price'=>'40-60万'),
            array('price'=>'60-80','house_price'=>'60-80万'),
            array('price'=>'80-100','house_price'=>'80-100万'),
            array('price'=>'100-120','house_price'=>'100-120万'),
            array('price'=>'120-150','house_price'=>'120-150万'),
            array('price'=>'150-200','house_price'=>'150-200万'),
            array('price'=>'200-250','house_price'=>'200-250万'),
            array('price'=>'250-300','house_price'=>'250-300万'),
            array('price'=>'300-500','house_price'=>'300-500万'),
            array('price'=>'500-0','house_price'=>'500万以上'),
        );
        foreach ($sell_price_option as $key=>$item){
            $where = " and status =1 and company_id=".$id;
            $temp = explode('-',$item['price']);
            if($temp[0]){
                $where .= ' and house_price>='.$temp[0];
            }
            if($temp[1]){
                $where .= ' and house_price<='.$temp[1];
            }
            $house_num = $houseSell->where('is_checked = 1'.$where)->count();
            if($house_num){
                $item['house_num'] = $house_num;
                $saleCountPrice[$key] =$item;
            }
        }
        $this->assign('saleCountPrice', $saleCountPrice);
        //二手房按房间数统计
        $house_room_option = array(
            1=>"一室",
            2=>"二室",
            3=>"三室",
            4=>"四室",
            5=>"五室",
            6=>"其他"
        );
        $saleCountRoom = $houseSell->field(array('house_room','count(*)'=>'house_num'))->where('status =1 and company_id = '.$id)->group('house_room')->having('house_num >=0')->select();
        foreach($saleCountRoom as $key=>$item){
            if($house_room_option[$item['house_room']]){
                $saleCountRoom[$key]['room'] = $item['house_room'];
                $saleCountRoom[$key]['house_room'] = $house_room_option[$item['house_room']];
            }else{
                unset($saleCountRoom[$key]);
            }
        }
        $this->assign('saleCountRoom', $saleCountRoom);

        //二手房列表
        $where =' and status=1 and company_id = '.$id;

        //price
        $price = $_GET['price'];
        if($price){
            $tmp = explode('-',$price);
            if($tmp[0]){
                $where .= ' and house_price >= '.intval($tmp[0]);
            }
            if($tmp[1]){
                $where .= ' and house_price <= '.intval($tmp[1]);
            }
        }
        //room
        $room = intval($_GET['room']);
        if($room){
            $where .= ' and house_room = '.$room;
        }

        //小区ID
        $borough_id = intval($_GET['borough_id']);
        if($borough_id){
            $where .= ' and borough_id = '.$borough_id;
        }

        //q
        $q = $_GET['q']=="可输入小区名、路名或划片学校" ? "":$_GET['q'];
        if($q){
            // 小区名、路名或划片学校
            $where_borough ="borough_name like '%".$q."%' or borough_address like '%".$q."%' or elementary_school like '%".$q."%' or middle_school like '%".$q."%'" ;
            $borough = M('borough');
            $borough_idsold=$borough->field('id')->where($where_borough)->select();
            $borough_ids=array();
            foreach($borough_idsold as $id){//组合一维数组
                $borough_ids[]=$id['id'];
            }
            if($borough_ids){
                $borough_ids = implode(',',$borough_ids);
                $where .=" and ( borough_id in (".$borough_ids.") or borough_name like '%".$q."%' )";
            }
        }

        switch ($_GET['list_order']){
            case "avg_price desc":
                $list_order = " house_price/house_totalarea desc";
                break;
            case "avg_price asc":
                $list_order = " house_price/house_totalarea asc";
                break;
            case "created desc":
                $list_order = " created desc";
                break;
            case "created asc":
                $list_order = " created asc";
                break;
            case "house_price asc":
                $list_order = " house_price asc";
                break;
            case "house_price desc":
                $list_order = " house_price desc";
                break;
            case "house_totalarea asc":
                $list_order = " house_totalarea asc";
                break;
            case "house_totalarea desc":
                $list_order = " house_totalarea desc";
                break;
            default:
                $list_order = " update_order desc";
                break;
        }



        //list_num
        $list_num = 10;

        $house = D('HouseSellView');
        $row_count = $house->getCount(1,$where);

        $Page= new \Think\Page($row_count,$list_num);// 实例化分页类 传入总记录数和每页显示的记录数(10)
        //$dataList =$house->query('select * from fke_housesell where is_checked=1'.$where.$list_order.' limit '.$Page->firstRow.','.$Page->listRows);

        //page
        $page_count=ceil($row_count/$list_num);
        $pageno = $_GET['p']?intval($_GET['p']):1;
        $pre_page = $pageno>1?$pageno-1:1;
        $next_page = $pageno<$page_count?$pageno+1:$page_count;
        $this->assign('pageno', $pageno);
        $this->assign('row_count', $row_count);
        $this->assign('page_count',$page_count);
        $this->assign('pre_page', $pre_page);
        $this->assign('next_page',$next_page);


        $dataList =M('housesell')->where('is_checked=1'.$where)->order($list_order)->limit($Page->firstRow.','.$Page->listRows)-> select();
        $member = D('MemberView');
        //积分配置文件
        $integral_array = C('RANK');

        foreach ($dataList as $key=> $item){
            if($item['house_price'] && $item['house_totalarea']){
                $dataList[$key]['avg_price'] = round($item['house_price']*10000/$item['house_totalarea']);
            }else{
                $dataList[$key]['avg_price'] = "未知";
            }
            //图片数量
            $dataList[$key]['pic_num'] = M('housesell_pic')->where(array('id'=>$item['id']))->count();
            //经纪人信息

            $dataList[$key]['broker_info'] = $member->getInfo($item['broker_id'],'*',true);
            $dataList[$key]['broker_info']['outlet'] = substr($dataList[$key]['broker_info']['outlet'],0,strpos($dataList[$key]['broker_info']['outlet'],'-'));
            $dataList[$key]['broker_info']['brokerRank'] = getNumByScore($dataList[$key]['broker_info']['scores'],$integral_array,'pic');

        }



        $this->assign('dataList', $dataList);
        $this->assign('pagePanel', $Page->show());//分页条



        $this->display();
    }
    /**
     * cshop 租房
     */
    public function rent(){
        $id = intval($_GET['id']);
        if($id ==0){
            $this->error('参数错误');
        }
        //店长信息
        $company = M('company');
        $dataInfo = $company->where(array('id'=>$id))->find();
        if(!$dataInfo){
            $this->error('该店铺不存在');
        }
        $this->assign('dataInfo', $dataInfo);
        $this->title = $dataInfo['company_name']."的门店 - 出租 - ".$this->title;
        if($dataInfo['company_style']){
            $this->assign('stylecss',$dataInfo['company_style']);
        }else{
            $this->assign('stylecss','shopStyleDefault.css');
        }
        //实例化和字典
        $houseSell =M('housesell');
        $houseRent = M('houserent');
        $house_fitment_option = getArray('house_fitment');

        //租房按小区统计
        $rentCountBorough = $houseRent->field(array('borough_id','count(*)'=>'house_num'))->where('status =1 and borough_id !=0 and company_id = '.$id)->group('borough_id')->having('house_num >=2')->select();
        $borough = M('borough');
        foreach ($rentCountBorough as $key => $item){
            $rentCountBorough[$key]['borough_name'] = $borough->where(array('id'=>$item['borough_id']))->getField('borough_name');
        }
        $this->assign('rentCountBorough', $rentCountBorough);

        //租房按价格统计

        $rent_price_option = array(
            array('price'=>'0-600','house_price'=>'600元以下'),
            array('price'=>'600-800','house_price'=>'600-800元'),
            array('price'=>'800-1000','house_price'=>'800-1000元'),
            array('price'=>'1000-1200','house_price'=>'1000-1200元'),
            array('price'=>'1200-1500','house_price'=>'1200-1500元'),
            array('price'=>'1500-2000','house_price'=>'1500-2000元'),
            array('price'=>'2000-3000','house_price'=>'2000-3000元'),
            array('price'=>'3000-4000','house_price'=>'3000-4000元'),
            array('price'=>'4000-5000','house_price'=>'4000-5000元'),
            array('price'=>'5000-0','house_price'=>'5000元以上'),
        );
        foreach ($rent_price_option as $key=>$item){
            $where = " and status =1 and company_id=".$id;
            $temp = explode('-',$item['price']);
            if($temp[0]){
                $where .= ' and house_price>='.$temp[0];
            }
            if($temp[1]){
                $where .= ' and house_price<='.$temp[1];
            }
            $house_num = $houseRent->where('is_checked = 1'.$where)->count();
            if($house_num){
                $item['house_num'] = $house_num;
                $rentCountPrice[$key] =$item;
            }
        }
        $this->assign('rentCountPrice', $rentCountPrice);
        //租房按房间统计
        $house_room_option = array(
            1=>"一室",
            2=>"二室",
            3=>"三室",
            4=>"四室",
            5=>"五室",
            6=>"其他"
        );
        $rentCountRoom = $houseRent->field(array('house_room','count(*)'=>'house_num'))->where('status =1 and company_id = '.$id)->group('house_room')->having('house_num >=0')->select();
        foreach($rentCountRoom as $key=>$item){
            if($house_room_option[$item['house_room']]){
                $rentCountRoom[$key]['room'] = $item['house_room'];
                $rentCountRoom[$key]['house_room'] = $house_room_option[$item['house_room']];
            }else{
                unset($rentCountRoom[$key]);
            }
        }
        $this->assign('rentCountRoom', $rentCountRoom);

        //租房列表
        $where =' and status=1 and company_id = '.$id;

        //price
        $price = $_GET['price'];
        if($price){
            $tmp = explode('-',$price);
            if($tmp[0]){
                $where .= ' and house_price >= '.intval($tmp[0]);
            }
            if($tmp[1]){
                $where .= ' and house_price <= '.intval($tmp[1]);
            }
        }
        //room
        $room = intval($_GET['room']);
        if($room){
            $where .= ' and house_room = '.$room;
        }

        //小区ID
        $borough_id = intval($_GET['borough_id']);
        if($borough_id){
            $where .= ' and borough_id = '.$borough_id;
        }

        //q
        $q = $_GET['q']=="可输入小区名、路名或划片学校" ? "":$_GET['q'];
        if($q){
            // 小区名、路名或划片学校
            $where_borough ="borough_name like '%".$q."%' or borough_address like '%".$q."%' or elementary_school like '%".$q."%' or middle_school like '%".$q."%'" ;
            $borough = M('borough');
            $borough_idsold=$borough->field('id')->where($where_borough)->select();
            $borough_ids=array();
            foreach($borough_idsold as $id){//组合一维数组
                $borough_ids[]=$id['id'];
            }
            if($borough_ids){
                $borough_ids = implode(',',$borough_ids);
                $where .=" and ( borough_id in (".$borough_ids.") or borough_name like '%".$q."%' )";
            }
        }

        switch ($_GET['list_order']){
            case "avg_price desc":
                $list_order = " house_price/house_totalarea desc";
                break;
            case "avg_price asc":
                $list_order = " house_price/house_totalarea asc";
                break;
            case "created desc":
                $list_order = " created desc";
                break;
            case "created asc":
                $list_order = " created asc";
                break;
            case "house_price asc":
                $list_order = " house_price asc";
                break;
            case "house_price desc":
                $list_order = " house_price desc";
                break;
            case "house_totalarea asc":
                $list_order = " house_totalarea asc";
                break;
            case "house_totalarea desc":
                $list_order = " house_totalarea desc";
                break;
            default:
                $list_order = " update_order desc";
                break;
        }



        //list_num
        $list_num = 10;

        $house = D('HouseRentView');
        $row_count = $house->getCount(1,$where);

        $Page= new \Think\Page($row_count,$list_num);// 实例化分页类 传入总记录数和每页显示的记录数(10)
        //$dataList =$house->query('select * from fke_housesell where is_checked=1'.$where.$list_order.' limit '.$Page->firstRow.','.$Page->listRows);

        //page
        $page_count=ceil($row_count/$list_num);
        $pageno = $_GET['p']?intval($_GET['p']):1;
        $pre_page = $pageno>1?$pageno-1:1;
        $next_page = $pageno<$page_count?$pageno+1:$page_count;
        $this->assign('pageno', $pageno);
        $this->assign('row_count', $row_count);
        $this->assign('page_count',$page_count);
        $this->assign('pre_page', $pre_page);
        $this->assign('next_page',$next_page);


        $dataList =M('houserent')->where('is_checked=1'.$where)->order($list_order)->limit($Page->firstRow.','.$Page->listRows)-> select();
        $member = D('MemberView');
        //积分配置文件
        $integral_array = C('RANK');

        foreach ($dataList as $key=> $item){
            if($item['house_price'] && $item['house_totalarea']){
                $dataList[$key]['avg_price'] = round($item['house_price']*10000/$item['house_totalarea']);
            }else{
                $dataList[$key]['avg_price'] = "未知";
            }
            //图片数量
            $dataList[$key]['pic_num'] = M('houserent_pic')->where(array('id'=>$item['id']))->count();
            //经纪人信息

            $dataList[$key]['broker_info'] = $member->getInfo($item['broker_id'],'*',true);
            $dataList[$key]['broker_info']['outlet'] = substr($dataList[$key]['broker_info']['outlet'],0,strpos($dataList[$key]['broker_info']['outlet'],'-'));
            $dataList[$key]['broker_info']['brokerRank'] = getNumByScore($dataList[$key]['broker_info']['scores'],$integral_array,'pic');

        }



        $this->assign('dataList', $dataList);
        $this->assign('pagePanel', $Page->show());//分页条



        $this->display();
    }

    /**
     * cshop 关于我们
     */
    public function profile(){
        $id = intval($_GET['id']);
        if($id ==0){
            $this->error('参数错误');
        }
        //店长信息
        $company = M('company');
        $dataInfo = $company->where(array('id'=>$id))->find();
        if(!$dataInfo){
            $this->error('该店铺不存在');
        }
        $this->assign('dataInfo', $dataInfo);
        $this->title = $dataInfo['company_name']."的网店 - 关于我们 - ".$this->title;

        if($dataInfo['company_style']){
            $this->assign('stylecss',$dataInfo['company_style']);
        }else{
            $this->assign('stylecss','shopStyleDefault.css');
        }
        $this->display();
    }
}