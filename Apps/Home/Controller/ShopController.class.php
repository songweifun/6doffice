<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/19
 * Time: 上午10:35
 */
namespace Home\Controller;
use Think\Controller;
class ShopController extends CommonController{
    public function index(){
        $id = intval($_GET['id']);
        if($id ==0){
            $this->error('参数错误');
        }
        //店长信息
        $member = D('MemberView');
        $dataInfo = $member->getInfo($id,'*',true);
        if($dataInfo['company_id']){
            $company = M('company');
            $dataInfo['company_name'] = $company->where(array('id'=>$dataInfo['company_id']))->getField('company_name');
        }
        if(!$dataInfo){
            $this->error('经纪人不存在');
        }
        if($this->shop == '1'){//经纪人是否需要实名认证才开通网店  1：是  2：不是
            if($dataInfo['mobile']=='' || $dataInfo['idcard']==''){
                jsurlto('由于还没完善资料或通过实名认证,该经纪人网店还没开通。',U(MODULE_NAME.'/Broker/index'));
            }
        }else{

            if($dataInfo['mobile']==''){
                jsurlto('由于还没完善资料或通过实名认证,该经纪人网店还没开通。',U(MODULE_NAME.'/Broker/index'));
            }
        }//else end

        $integral_array = C('Rank');
        $dataInfo['brokerRank'] = getNumByScore($dataInfo['scores'],$integral_array,'pic');
        $dataInfo['cityarea_name'] = getCaption('cityarea',$dataInfo['cityarea_id']);
        $dataInfo['active_str'] = explode('|',$dataInfo['active_str']);
        $this->assign('dataInfo', $dataInfo);
        $this->title = $dataInfo['realname']."的网店 - ".$this->city.$this->titlec;

        //网店信息
        $shop = M('shop_conf');
        $shopConf = $shop->where(array('broker_id'=>$id))->find();
        if(!$shopConf){
            $shopConf = array(
                'broker_id'=>$id,
                'shop_name'=>$dataInfo['realname']."的网店",
                'shop_notice'=>"欢迎来到".$dataInfo['realname']."的网店",
                'shop_style'=>'shopStyleDefault.css',
                'click_num'=>1
            );
            $shopConf['id']= $shop->add($shopConf);
        }
        $this->assign('shopConf', $shopConf);
        if($shopConf['shop_style']){
            //$page->addCss($shopConf['shop_style']);
        }else{
            //$page->addCss('shopStyleDefault.css');
        }

        //实例化和字典
        $houseSell = M('housesell');
        $houseRent = M('houserent');
        $house_fitment_option = getArray('house_fitment');

        //店长推荐出售房源
        $salePromote = $houseSell->where('status =1 and is_promote =1 and broker_id ='.$id)->order('created desc')->select();

        foreach($salePromote as $key=>$item){
            if($item['house_totalarea']){
                $salePromote[$key]['avg_price']=round($item['house_price']*10000/$item['house_totalarea']);
            }else{
                $salePromote[$key]['avg_price'] ='0';
            }
        }
        $this->assign('salePromote', $salePromote);

        //店长推荐出租房源
        $rentPromote = $houseRent->where('status =1 and is_promote =1 and broker_id ='.$id)->order('created desc')->select();
        foreach($rentPromote as $key=>$item){
            $rentPromote[$key]['house_fitment'] =$house_fitment_option[$item['house_fitment']];
        }
        $this->assign('rentPromote', $rentPromote);


        //店长二手房列表
        $brokerSaleList = $houseSell->where('is_checked=1 and status =1 and broker_id ='.$id)->order('created desc')->limit(8)->select();

        foreach($brokerSaleList as $key=>$item){
            if($item['house_totalarea']){
                $brokerSaleList[$key]['avg_price']=round($item['house_price']*10000/$item['house_totalarea']);
            }else{
                $brokerSaleList[$key]['avg_price'] ='0';
            }
        }
        $this->assign('brokerSaleList', $brokerSaleList);
        //店长租房列表
        $brokerRentList = $houseRent->where('is_checked=1 and status =1 and broker_id ='.$id)->order('created desc')->limit(8)->select();
        foreach($brokerRentList as $key=>$item){
            $brokerRentList[$key]['house_fitment'] =$house_fitment_option[$item['house_fitment']];
        }
        $this->assign('brokerRentList', $brokerRentList);

        //二手房按小区统计出售
        $saleCountBorough = $houseSell->field(array('borough_id','count(*)'=>'house_num'))->where('status =1 and borough_id !=0 and broker_id = '.$id)->group('borough_id')->having('house_num >=2')->select();
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
            $where = " and status =1 and broker_id=".$id;
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
        $saleCountRoom = $houseSell->field(array('house_room','count(*)'=>'house_num'))->where('status =1 and broker_id = '.$id)->group('house_room')->having('house_num >=0')->select();
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
        $rentCountBorough = $houseRent->field(array('borough_id','count(*)'=>'house_num'))->where('status =1 and borough_id !=0 and broker_id = '.$id)->group('borough_id')->having('house_num >=2')->select();
        foreach ($rentCountBorough as $key => $item){
            $rentCountBorough[$key]['borough_name'] = $borough->where(array('id'=>$item['borough_id']))->getField('borough_name');
        }
        $this->assign('rentCountBorough', $rentCountBorough);
        //p($rentCountBorough);die;

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
            $where = " and status =1 and broker_id=".$id;
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
        $rentCountRoom = $houseRent->field(array('house_room','count(*)'=>'house_num'))->where('status =1 and broker_id = '.$id)->group('house_room')->having('house_num >=0')->select();
        foreach($rentCountRoom as $key=>$item){
            if($house_room_option[$item['house_room']]){
                $rentCountRoom[$key]['room'] = $item['house_room'];
                $rentCountRoom[$key]['house_room'] = $house_room_option[$item['house_room']];
            }else{
                unset($rentCountRoom[$key]);
            }
        }
        $this->assign('rentCountRoom', $rentCountRoom);

        //店主人脉
        $brokerFriend = M('broker_friends');
        $brokerFriends = $brokerFriend->where('broker_id ='.$id.' and status =1')->limit(8)->select();
        $member=D('MemberView');
        foreach($brokerFriends as $key=>$v){
            $memberInfo=$member->where(array('id'=>$v['friend_id']))->find();
            //p($v);die;
            $brokerFriends[$key]=array_merge($memberInfo,$v);
        }

        $brokerFriends = array_sortby_multifields($brokerFriends,array('active_rate'=>SORT_DESC));
        //p($brokerFriends);die;

        $this->assign('brokerFriends', $brokerFriends);
        $brokerFriendCount = $brokerFriend->where('broker_id ='.$id.' and status =1')->count();
        $this->assign('brokerFriendCount', $brokerFriendCount);

        //来访用户
        $shop_viewlog = D('ShopViewlog');
        $shopViewer = $shop_viewlog->where('broker_id ='.$id)->order('add_time desc')->limit(8)->select();
        foreach($shopViewer as $key=>$v){
            $memberInfo=$member->where(array('id'=>$v['friend_id']))->find();
            //p($v);die;
            $shopViewer[$key]=array_merge($memberInfo,$v);
        }

        $this->assign('shopViewer', $shopViewer);

        //记录访问log
        if($_COOKIE['AUTH_MEMBER_NAME']){
            $member_id = $member->getAuthInfo('id');
            if($member_id && $member_id <>$id){
                $shop_viewlog->addLog($id,$member_id);
            }
        }

        //增加人气
        if($_COOKIE['VIEW_SHOP_LOG']){
            $view_log = unserialize($_COOKIE['VIEW_SHOP_LOG']);
            if($view_log && !in_array($id,(array)$view_log)){
                //今天没有访问过
                $shop->where(array('broker_id'=>$id))->setInc('click_num',1);
                $view_log[] = $id;
                $view_log_serialize = serialize($view_log);
                setcookie('VIEW_SHOP_LOG',$view_log_serialize,time()+60*60*24*365,'/',$cfg['domain']);
            }
        }else{
            $shop->where(array('broker_id'=>$id))->setInc('click_num',1);
            $view_log = array();
            $view_log[] = $id;
            $view_log_serialize = serialize($view_log);
            setcookie('VIEW_SHOP_LOG',$view_log_serialize,time()+60*60*24*365,'/','');
        }


        $this->menu="shop";

        $this->display();
    }

    /**
     * shop sell
     */
    public function sell(){
        $id = intval($_GET['id']);
        if($id ==0){
            $this->error('参数错误');
        }
        //店长信息
        $member = D('MemberView');
        $dataInfo = $member->getInfo($id,'*',true);
        if($dataInfo['company_id']){
            $company = M('company');
            $dataInfo['company_name'] = $company->where(array('id'=>$dataInfo['company_id']))->getField('company_name');
        }
        if(!$dataInfo){
            $this->error('经纪人不存在');
        }
        $integral_array = C('Rank');
        $dataInfo['brokerRank'] = getNumByScore($dataInfo['scores'],$integral_array,'pic');
        $dataInfo['cityarea_name'] = getCaption('cityarea',$dataInfo['cityarea_id']);
        $dataInfo['active_str'] = explode('|',$dataInfo['active_str']);
        $this->assign('dataInfo', $dataInfo);
        $this->title = $dataInfo['realname']."的网店 - 二手房 - ".$this->title;
        //网店信息
        $shop = M('shop_conf');
        $shopConf = $shop->where(array('broker_id'=>$id))->find();
        if(!$shopConf){
            $shopConf = array(
                'broker_id'=>$id,
                'shop_name'=>$dataInfo['realname']."的网店",
                'shop_notice'=>"欢迎来到".$dataInfo['realname']."的网店",
                'shop_style'=>'shopStyleDefault.css',
                'click_num'=>1
            );
            $shopConf['id']= $shop->add($shopConf);
        }
        $this->assign('shopConf', $shopConf);
        if($shopConf['shop_style']){
            $this->assign('stylecss',$shopConf['shop_style']);
        }else{
            $this->assign('stylecss','shopStyleDefault.css');
        }
        //实例化和字典
        $houseSell = M('housesell');
        //二手房按小区统计出售
        $saleCountBorough = $houseSell->field(array('borough_id','count(*)'=>'house_num'))->where('status =1 and borough_id !=0 and broker_id = '.$id)->group('borough_id')->having('house_num >=2')->select();
        $borough = M('borough');
        foreach ($saleCountBorough as $key => $item){
            $saleCountBorough[$key]['borough_name'] = $borough->where(array('id'=>$item['borough_id']))->getField('borough_name');
        }
        $this->assign('saleCountBorough', $saleCountBorough);
        //二手房按小区统计出售
        $saleCountBorough = $houseSell->field(array('borough_id','count(*)'=>'house_num'))->where('status =1 and borough_id !=0 and broker_id = '.$id)->group('borough_id')->having('house_num >=2')->select();
        $borough = M('borough');
        foreach ($saleCountBorough as $key => $item){
            $saleCountBorough[$key]['borough_name'] = $borough->where(array('id'=>$item['borough_id']))->getField('borough_name');
        }
        $this->assign('saleCountBorough', $saleCountBorough);
        //p($saleCountBorough);
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
            $where = " and status =1 and broker_id=".$id;
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
        $saleCountRoom = $houseSell->field(array('house_room','count(*)'=>'house_num'))->where('status =1 and broker_id = '.$id)->group('house_room')->having('house_num >=0')->select();
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
        $where =' and status=1 and broker_id = '.$id;

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
        //p($row_count);
        $Page= new \Think\Page($row_count,$list_num);// 实例化分页类 传入总记录数和每页显示的记录数(10)
        //$dataList =$house->query('select * from fke_housesell where is_checked=1'.$where.$list_order.' limit '.$Page->firstRow.','.$Page->listRows);

        //page
        $page_count=ceil($row_count/$list_num)>1?ceil($row_count/$list_num):1;
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
        foreach ($dataList as $key=> $item) {
            if ($item['house_price'] && $item['house_totalarea']) {
                $dataList[$key]['avg_price'] = round($item['house_price'] * 10000 / $item['house_totalarea']);
            } else {
                $dataList[$key]['avg_price'] = "未知";
            }
            //图片数量
            $dataList[$key]['pic_num'] = M('housesell_pic')->where(array('id' => $item['id']))->count();
        }



        $this->assign('dataList', $dataList);
        $this->assign('pagePanel', $Page->show());//分页条

        $this->menu="shop";
        $this->display();
    }
    /**
     * shop rent
     */
    public function rent(){
        $id = intval($_GET['id']);
        if($id ==0){
            $this->error('参数错误');
        }
        //店长信息
        $member = D('MemberView');
        $dataInfo = $member->getInfo($id,'*',true);
        if($dataInfo['company_id']){
            $company = M('company');
            $dataInfo['company_name'] = $company->where(array('id'=>$dataInfo['company_id']))->getField('company_name');
        }
        if(!$dataInfo){
            $this->error('经纪人不存在');
        }
        $integral_array = C('Rank');
        $dataInfo['brokerRank'] = getNumByScore($dataInfo['scores'],$integral_array,'pic');
        $dataInfo['cityarea_name'] = getCaption('cityarea',$dataInfo['cityarea_id']);
        $dataInfo['active_str'] = explode('|',$dataInfo['active_str']);
        $this->assign('dataInfo', $dataInfo);
        $this->title = $dataInfo['realname']."的网店 - 出租 - ".$this->title;

        //网店信息
        $shop = M('shop_conf');
        $shopConf = $shop->where(array('broker_id'=>$id))->find();
        if(!$shopConf){
            $shopConf = array(
                'broker_id'=>$id,
                'shop_name'=>$dataInfo['realname']."的网店",
                'shop_notice'=>"欢迎来到".$dataInfo['realname']."的网店",
                'shop_style'=>'shopStyleDefault.css',
                'click_num'=>1
            );
            $shopConf['id']= $shop->add($shopConf);
        }
        $this->assign('shopConf', $shopConf);
        if($shopConf['shop_style']){
            $this->assign('stylecss',$shopConf['shop_style']);
        }else{
            $this->assign('stylecss','shopStyleDefault.css');
        }
        //实例化和字典
        $houseRent = M('houserent');
        //租房按小区统计
        $rentCountBorough = $houseRent->field(array('borough_id','count(*)'=>'house_num'))->where('status =1 and borough_id !=0 and broker_id = '.$id)->group('borough_id')->having('house_num >=2')->select();
        $borough = M('borough');
        foreach ($rentCountBorough as $key => $item){
            $rentCountBorough[$key]['borough_name'] = $borough->where(array('id'=>$item['borough_id']))->getField('borough_name');
        }
        $this->assign('rentCountBorough', $rentCountBorough);

        //p($rentCountBorough);
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
            $where = " and status =1 and broker_id=".$id;
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

        $rentCountRoom = $houseRent->field(array('house_room','count(*)'=>'house_num'))->where('status =1 and broker_id = '.$id)->group('house_room')->having('house_num >=0')->select();

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
        $where =' and status=1 and broker_id = '.$id;

        //小区ID
        $borough_id = intval($_GET['borough_id']);
        if($borough_id){
            $where .= ' and borough_id = '.$borough_id;
        }

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
        //p($row_count);
        $Page= new \Think\Page($row_count,$list_num);// 实例化分页类 传入总记录数和每页显示的记录数(10)


        //page
        $page_count=ceil($row_count/$list_num)>1?ceil($row_count/$list_num):1;
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
        foreach ($dataList as $key=> $item) {
            if ($item['house_price'] && $item['house_totalarea']) {
                $dataList[$key]['avg_price'] = round($item['house_price'] * 10000 / $item['house_totalarea']);
            } else {
                $dataList[$key]['avg_price'] = "未知";
            }
            //图片数量
            $dataList[$key]['pic_num'] = M('houserent_pic')->where(array('id' => $item['id']))->count();
        }



        $this->assign('dataList', $dataList);
        $this->assign('pagePanel', $Page->show());//分页条
        $this->menu="shop";
        $this->display();
    }
    /**
     * shop evaluate服务评价
     */
    public function evaluate(){

        $action=I('get.action');
        if($action=='save'){

            $client_ip= ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
            //p($client_ip);die;

            if( $_POST['accurate']==0 or $_POST['accurate']==0 or $_POST['accurate']==0){
                $this->error('请将评价信息完善');
            }

            //判断用户是否评价过
            $clientIp=M('broker_evaluate')->where(array('client_ip'=>$client_ip,'broker_id'=>$_POST['broker_id']))->getField('id');//查用户重复评价经纪人

            if($clientIp){
                $this->error('你已经评价过该经纪人');
            }
            $field_array  = array(
                'broker_id'=>I('broker_id',0,'intval'),
                'client_ip'=>$client_ip,
                'accurate'=>I('accurate',0,'intval'),
                'satisfaction'=>I('satisfaction',0,'intval'),
                'specialty'=>I('specialty',0,'intval'),
                'content'=>I('content'),
                'time'=>time(),
            );
            $member=M('member');

            try{
                $e_accurate=$member->where(array('id'=>I('broker_id',0,'intval')))->getField('e_accurate');
                $e_satisfaction=$member->where(array('id'=>I('broker_id',0,'intval')))->getField('e_satisfaction');
                $e_specialty=$member->where(array('id'=>I('broker_id',0,'intval')))->getField('e_specialty');


                $member->where(array('id'=>I('broker_id',0,'intval')))->save(array('e_accurate'=>$e_accurate+I('accurate',0,'intval')));
                $member->where(array('id'=>I('broker_id',0,'intval')))->save(array('e_satisfaction'=>$e_satisfaction+I('satisfaction',0,'intval')));
                $member->where(array('id'=>I('broker_id',0,'intval')))->save(array('e_specialty'=>$e_specialty+I('specialty',0,'intval')));



                M('broker_evaluate')->add($field_array);

                $this->success('评价成功',U(MODULE_NAME.'/Shop/evaluate',array('id'=>$_POST['broker_id'])));

            }catch ( Exception $e) {
                $this->error('评价失败');
            }
            exit;

        }else{
            $id = intval($_GET['id']);
            if($id ==0){
                $this->error('参数错误');
            }
            //店长信息
            $member = D('MemberView');
            $dataInfo = $member->getInfo($id,'*',true);
            if($dataInfo['company_id']){
                $company = M('company');
                $dataInfo['company_name'] = $company->where(array('id'=>$dataInfo['company_id']))->getField('company_name');
            }
            if(!$dataInfo){
                $this->error('经纪人不存在');
            }
            $integral_array = C('Rank');
            $dataInfo['brokerRank'] = getNumByScore($dataInfo['scores'],$integral_array,'pic');
            $dataInfo['cityarea_name'] = getCaption('cityarea',$dataInfo['cityarea_id']);
            $dataInfo['active_str'] = explode('|',$dataInfo['active_str']);
            $this->assign('dataInfo', $dataInfo);
            $this->title = $dataInfo['realname']."的网店 - 出租 - ".$this->title;

            //网店信息
            $shop = M('shop_conf');
            $shopConf = $shop->where(array('broker_id'=>$id))->find();
            if(!$shopConf){
                $shopConf = array(
                    'broker_id'=>$id,
                    'shop_name'=>$dataInfo['realname']."的网店",
                    'shop_notice'=>"欢迎来到".$dataInfo['realname']."的网店",
                    'shop_style'=>'shopStyleDefault.css',
                    'click_num'=>1
                );
                $shopConf['id']= $shop->add($shopConf);
            }
            $this->assign('shopConf', $shopConf);
            if($shopConf['shop_style']){
                $this->assign('stylecss',$shopConf['shop_style']);
            }else{
                $this->assign('stylecss','shopStyleDefault.css');
            }

            $list_num = intval($_GET['list_num']);
            if(!$list_num){
                $list_num = 10;
            }
            $row_count=M('broker_evaluate')->where(array('broker_id'=>$id))->count();
            $Page= new \Think\Page($row_count,$list_num);// 实例化分页类 传入总记录数和每页显示的记录数(10)


            //page
            $page_count=ceil($row_count/$list_num)>1?ceil($row_count/$list_num):1;
            $pageno = $_GET['p']?intval($_GET['p']):1;
            $pre_page = $pageno>1?$pageno-1:1;
            $next_page = $pageno<$page_count?$pageno+1:$page_count;
            $this->assign('pageno', $pageno);
            $this->assign('row_count', $row_count);
            $this->assign('page_count',$page_count);
            $this->assign('pre_page', $pre_page);
            $this->assign('next_page',$next_page);
            //获取评价列表
            $dataList = M('broker_evaluate')->where(array('broker_id'=>$id))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
            foreach ($dataList as $key=> $item){
                $reg1 = '/((?:\d+\.){3})\d+/';
                $dataList[$key]['ip'] =  preg_replace($reg1, "\\1*", $item['client_ip']);
            }

            $this->assign('dataList', $dataList);
            $this->assign('pagePanel', $Page->show());//分页条

            $evaluateCount = M('broker_evaluate')->where(array('broker_id'=>$id))->count();
            //全站平均水平分值
            $ave = 3.0;
            //获取房屋信息平均值
            if($evaluateCount!=0){
                $aveAccurate = round($dataInfo['e_accurate']/$evaluateCount,1);
                if($aveAccurate>$ave){
                    $aveUp = $aveAccurate-$ave;
                    $percentageAcc = round($aveUp/$ave,2)*100;
                }else{
                    $aveUp = $ave-$aveAccurate;
                    $percentageAcc = round($aveUp/$ave,2)*100;
                }



                //获取服务信息平均值
                $aveSatisfaction = round($dataInfo['e_satisfaction']/$evaluateCount,1);
                if($aveSatisfaction>$ave){
                    $aveUp = $aveSatisfaction-$ave;
                    $percentageSat = round($aveUp/$ave,2)*100;
                }else{
                    $aveUp = $ave-$aveSatisfaction;
                    $percentageSat = round($aveUp/$ave,2)*100;
                }



                //获取专业信息平均值
                $aveSpecialty = round($dataInfo['e_specialty']/$evaluateCount,1);
                if($aveSpecialty>$ave){
                    $aveUp = $aveSpecialty-$ave;
                    $percentageSpe = round($aveUp/$ave,2)*100;
                }else{
                    $aveUp = $ave-$aveSpecialty;
                    $percentageSpe = round($aveUp/$ave,2)*100;
                }
            }

            $start['spe1'] = M('broker_evaluate')->where('specialty=1 and broker_id='.$id)->count();
            $start['spe2'] = M('broker_evaluate')->where('specialty=2 and broker_id='.$id)->count();
            $start['spe3'] = M('broker_evaluate')->where('specialty=3 and broker_id='.$id)->count();
            $start['spe4'] = M('broker_evaluate')->where('specialty=4 and broker_id='.$id)->count();
            $start['spe5'] = M('broker_evaluate')->where('specialty=5 and broker_id='.$id)->count();
            $start['sat1'] = M('broker_evaluate')->where('satisfaction=1 and broker_id='.$id)->count();
            $start['sat2'] = M('broker_evaluate')->where('satisfaction=2 and broker_id='.$id)->count();
            $start['sat3'] = M('broker_evaluate')->where('satisfaction=3 and broker_id='.$id)->count();
            $start['sat4'] = M('broker_evaluate')->where('satisfaction=4 and broker_id='.$id)->count();
            $start['sat5'] = M('broker_evaluate')->where('satisfaction=5 and broker_id='.$id)->count();
            $start['acc1'] = M('broker_evaluate')->where('accurate=1 and broker_id='.$id)->count();
            $start['acc2'] = M('broker_evaluate')->where('accurate=2 and broker_id='.$id)->count();
            $start['acc3'] = M('broker_evaluate')->where('accurate=3 and broker_id='.$id)->count();
            $start['acc4'] = M('broker_evaluate')->where('accurate=4 and broker_id='.$id)->count();
            $start['acc5'] = M('broker_evaluate')->where('accurate=5 and broker_id='.$id)->count();

            //获取好评率
            if($evaluateCount!=0){
                $good = round(($start['sat5']+$start['spe5']+$start['acc5'])/($row_count*3),2)*100;
                $this->assign('good', $good);
            }

            $this->assign('start', $start);
            $this->assign('aveSatisfaction', $aveSatisfaction);
            $this->assign('aveAccurate', $aveAccurate);
            $this->assign('aveSpecialty', $aveSpecialty);

            $this->assign('percentageAcc', $percentageAcc);
            $this->assign('percentageSpe', $percentageSpe);
            $this->assign('percentageSat', $percentageSat);





            //获取
            $this->title = $dataInfo['realname']."的网店 - 经纪人评价 - ".$this->title;
            $this->broker_id=D('MemberView')->getAuthInfo('id');
        }

        $this->menu="shop";
        $this->display();
    }

    /**
     * 评论回复
     */
    public function replay(){
        $this->title =  $this->title.' - 回复信息';
        $action=I('get.action');
        $broker_id=D('MemberView')->getAuthInfo('id');

        if($action == 'reply'){
            //p($_POST);
            $member = D('MemberView');
            $id = intval($_GET['id']);
            $broker_id = intval($_GET['broker_id']);
            if(empty($_POST['reply'])){
                $this->error('请填写内容');
            }
            $id=M('broker_evaluate')->where(array('id'=>$id))->save(array('reply'=>$_POST['reply']));
            //jsurlto('回复成功',U(MODULE_NAME.'/Shop/evaluate',array('id'=>$broker_id)));
            if($id){
                $this->ajaxReturn(array('status'=>true,'msg'=>'回复成功'));
            }else{
                $this->ajaxReturn(array('status'=>false,'msg'=>'回复失败'));
            }


        }else{

            if($broker_id!=intval($_GET['broker_id'])){
                jsurlto('参数错误',U(MODULE_NAME.'/Shop/evaluate',array('id'=>$broker_id)));
            }
            $this->display();
        }

    }

    /**
     * shop profile
     */
    public function profile(){

        $id = intval($_GET['id']);
        if($id ==0){
            $this->error('参数错误');
        }
        //店长信息
        $member = D('MemberView');
        $dataInfo = $member->getInfo($id,'*',true);
        if($dataInfo['company_id']){
            $company = M('company');
            $dataInfo['company_name'] = $company->where(array('id'=>$dataInfo['company_id']))->getField('company_name');
        }
        if(!$dataInfo){
            $this->error('经纪人不存在');
        }
        $integral_array = C('Rank');
        $dataInfo['brokerRank'] = getNumByScore($dataInfo['scores'],$integral_array,'pic');
        $dataInfo['cityarea_name'] = getCaption('cityarea',$dataInfo['cityarea_id']);
        $dataInfo['active_str'] = explode('|',$dataInfo['active_str']);
        $this->assign('dataInfo', $dataInfo);
        $this->title = $dataInfo['realname']."的网店 - 店长介绍 - ".$this->title;

        //网店信息
        $shop = M('shop_conf');
        $shopConf = $shop->where(array('broker_id'=>$id))->find();
        if(!$shopConf){
            $shopConf = array(
                'broker_id'=>$id,
                'shop_name'=>$dataInfo['realname']."的网店",
                'shop_notice'=>"欢迎来到".$dataInfo['realname']."的网店",
                'shop_style'=>'shopStyleDefault.css',
                'click_num'=>1
            );
            $shopConf['id']= $shop->add($shopConf);
        }
        $this->assign('shopConf', $shopConf);
        if($shopConf['shop_style']){
            $this->assign('stylecss',$shopConf['shop_style']);
        }else{
            $this->assign('stylecss','shopStyleDefault.css');
        }
        $this->menu="shop";
        $this->display();
    }


}