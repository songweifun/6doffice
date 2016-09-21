<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/20
 * Time: 上午11:35
 */
namespace Home\Controller;
use Think\Controller;
class RentController extends CommonController{
    /**
     * 出租主页
     */
    public function index(){

        $this->title = $this->city.'租房 - '.$this->titlec;   //网站名称

        //关键词和描述
        $this->keyword = $this->rent_keyword;
        $this->description = $this->rent_description;


        //区域字典
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);
        $house_type_option = getArray('house_type');
        $this->assign('house_type_option', $house_type_option);

        $house_price_option = array(
            '0-600'=>'600元以下',
            '600-800'=>'600-800元',
            '800-1000'=>'800-1000元',
            '1000-1200'=>'1000-1200元',
            '1200-1500'=>'1200-1500元',
            '1500-2000'=>'1500-2000元',
            '2000-3000'=>'2000-3000元',
            '3000-4000'=>'3000-4000元',
            '4000-5000'=>'4000-5000元',
            '5000-0'=>'5000元以上'
        );
        $this->assign('house_price_option', $house_price_option);

        $house_totalarea_option = array(
            '0-50'=>'50㎡以下',
            '50-70'=>'50-70㎡',
            '70-90'=>'70-90㎡',
            '90-110'=>'90-110㎡',
            '110-130'=>'110-130㎡',
            '130-150'=>'130-150㎡',
            '150-200'=>'150-200㎡',
            '200-250'=>'200-250㎡',
            '250-300'=>'250-300㎡',
            '300-500'=>'300-500㎡',
            '500-0'=>'500㎡以上'
        );
        $this->assign('house_totalarea_option', $house_totalarea_option);

        $house_age_option = array(
            '0-1995'=>'1995年前',
            '1995-2000'=>'1995-2000年',
            '2000-2008'=>'2000-2008年',
            '2008-0'=>'2008年后'
        );
        $this->assign('house_age_option', $house_age_option);

        $house_floor_option = array(
            '0-6'=>'6层以下',
            '6-12'=>'6-12层',
            '12-0'=>'12层以上'
        );
        $this->assign('house_floor_option', $house_floor_option);

        //特色
        $house_feature_option = getArray('house_feature');
        $this->assign('house_feature_option', $house_feature_option);

        //totalarea
        $this->assign('totalarea', $_GET['totalarea']);

        $where =' and status=1 ';
        //cityarea
        $cityarea = intval($_GET['cityarea']);
        $this->assign('cityarea', $cityarea);
        if($cityarea){
            $where .= ' and cityarea_id = '.$cityarea;
            $this->title = $cityarea_option[$cityarea].",".$this->title;
        }
        $dd = D('DdItem');
        $borough_section=$dd->getSonList($cityarea);
        $this->assign('borough_section',$borough_section);

        //cityarea2
        $cityarea2 = intval($_GET['cityarea2']);
        $this->assign('cityarea2', $cityarea2);
        if($cityarea2){
            $where .= ' and cityarea2_id = '.$cityarea2;
        }

        //type
        $type = intval($_GET['type']);
        $this->assign('type', $type);
        if($type){
            $where .= ' and house_type = '.$type;
            $this->title = $house_type_option[$type].",".$this->title;
        }

        //feature
        $feature = intval($_GET['feature']);
        $this->assign('feature', $feature);
        if($feature){
            $where .= " and house_feature like '%,".$feature.",%'";
            $this->title = $house_feature_option[$feature].",".$this->title;
        }

        //price
        $price = $_GET['price'];
        $this->assign('price', $price);
        if($price){
            $tmp = explode('-',$price);
            if($tmp[0]){
                $where .= ' and house_price >= '.intval($tmp[0]);
            }
            if($tmp[1]){
                $where .= ' and house_price <= '.intval($tmp[1]);
            }
            $this->title = $house_price_option[$price].",".$this->title;

        }
        //roomoption
        $room_option = array(1=>'一室',2=>'二室',3=>'三室',4=>'四室',5=>'五室',6=>'五室以上');
        $this->assign('room_option', $room_option);

        //room
        $room = intval($_GET['room']);
        $this->assign('room', $room);
        if($room){
            $where .= ' and house_room = '.$room;

            $this->title = $room_option[$room].",".$this->title;
        }

        //house_age

        $house_age = $_GET['house_age'];
        $this->assign('house_age', $house_age);
        if($house_age){
            $tmp = explode('-',$house_age);
            if($tmp[0]){
                $where .= ' and house_age >= '.intval($tmp[0]);
            }
            if($tmp[1]){
                $where .= ' and house_age <= '.intval($tmp[1]);
            }

        }

        //house_floor
        $house_floor = $_GET['house_floor'];
        $this->assign('house_floor', $house_floor);
        if($house_floor){
            $tmp = explode('-',$house_floor);
            if($tmp[0]){
                $where .= ' and house_floor >= '.intval($tmp[0]);
            }
            if($tmp[1]){
                $where .= ' and house_floor <= '.intval($tmp[1]);
            }

        }

        //q
        if($_GET['b']){
            //$_GET['q'] = iconv("utf-8","gb2312",$_GET['q']);
        }

        $q = $_GET['q']=="可输入小区名、路名或划片学校" ? "":trim($_GET['q']);
        //echo $q;die;
        if($q){
            // 小区名、路名或划片学校
            $where_borough ="borough_name like '%".$q."%' or borough_address like '%".$q."%' or elementary_school like '%".$q."%' or middle_school like '%".$q."%'" ;
            $borough = M('borough');
            $borough_idsold=$borough->field('id')->where($where_borough)->select();
            $borough_ids=array();
            foreach($borough_idsold as $id){//组合一维数组
                $borough_ids[]=$id['id'];
            }
            //p($borough_ids);die;
            if($borough_ids){
                $borough_ids = implode(',',$borough_ids);
                $where .=" and ( borough_id in (".$borough_ids.") or borough_name like '%".$q."%' )";
            }else{
                //没有搜索到
                $where= ' and 0 ';
            }
            $this->title = $q.",".$this->title;
        }

        //选择标签
        $switch = $_GET['switch'];
        if($switch == "owner"){
            $where .= " and broker_id = 0 ";
            $this->title = "房东房源 - ".$this->title;
        }
        if($switch == "promote"){
            $where .=" and is_promote =1";
            $this->title = "店长推荐 - ".$this->title;
        }
        if($switch == "morePic"){
            $where .=" and is_more_pic =1";
            $this->title = "多图房源 - ".$this->title;
        }
        if($switch == "vexation"){
            $where .=" and is_vexation =1";
            $this->title = "急售房源 - ".$this->title;
        }

        //totalarea
        $totalarea = $_GET['totalarea'];
        if($totalarea){
            $tmp = explode('-',$totalarea);
            if($tmp[0]){
                $where .= ' and house_totalarea >= '.intval($tmp[0]);
            }
            if($tmp[1]){
                $where .= ' and house_totalarea <= '.intval($tmp[1]);
            }
            $this->title = $house_totalarea_option[$totalarea].",".$this->title;
        }
        //list_order 排序转换
        switch ($_GET['list_order']){
            case "avg_price desc":
                $list_order = " is_top desc,house_price/house_totalarea desc";
                break;
            case "avg_price asc":
                $list_order = " is_top desc,house_price/house_totalarea asc";
                break;
            case "created desc":
                $list_order = " is_top desc,updated desc";
                break;
            case "created asc":
                $list_order = " is_top desc,updated asc";
                break;
            case "house_price asc":
                $list_order = " is_top desc,house_price asc";
                break;
            case "house_price desc":
                $list_order = " is_top desc,house_price desc";
                break;
            case "house_totalarea asc":
                $list_order = " is_top desc,house_totalarea asc";
                break;
            case "house_totalarea desc":
                $list_order = " is_top desc,house_totalarea desc";
                break;
            default:
                $list_order = " is_top desc,update_order desc";
                break;
        }

        //list_num
        $list_num = intval($_GET['list_num']);
        if(!$list_num){
            $list_num = 10;
        }

        $house = D('HouseRentView');
        $row_count = $house->getCount(1,$where);

        $Page= new \Think\Page($row_count,$list_num);// 实例化分页类 传入总记录数和每页显示的记录数(10)

        //page
        $page_count=ceil($row_count/$list_num)>0?ceil($row_count/$list_num):1;
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

        //p($dataList);die;
        $this->menu='rent';

        //执行脚本，房源置顶过期
        $topHouseId=M('houserent_top')->field('houserent_id')->where(array('to_time'=>array('elt',time())))->select();
        if($topHouseId){
            foreach($topHouseId as $item){
                M('houserent')->where(array('id'=>$item['houserent_id']))->setField('is_top',0);
                M('houserent_top')->where(array('houserent_id'=>$item['houserent_id']))->delete();
            }
        }

        //右边浏览过房源
        //p($_COOKIE['RRecentlyGoods']);
        if($_COOKIE['RRecentlyGoods']){
            $browseHouse=M('houserent')->where(array('id'=>array('in',$_COOKIE['RRecentlyGoods'])))->select();
            $this->assign('browseList', $browseHouse);
        }

        //p($browseHouse);


        //右边的优质房源列表
        $bestList = M('houserent')->where('is_checked=1 and is_index =1')->order('order_weight desc')->limit(4)->select();

        foreach ($bestList as $key =>$item ){
            $bestList[$key]['title'] =substrs($item['house_title'],15);
            $bestList[$key]['description'] = $item['house_room'].'室'.$item['house_hall'].'厅，'.$item['house_totalarea'].'平米';
        }
        $this->assign('bestList', $bestList);
        $this->display();
    }

    /**
     * 租赁详情
     */
    public function detail(){

        $member = D('MemberView');
        if($_COOKIE['AUTH_MEMBER_NAME']){
            $member_id = $member->getAuthInfo('id');
            $user_type = $member->getAuthInfo('user_type');
            $this->assign('user_type', $user_type);
        }
        //区域字典
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);

        $house_price_option = array(
            '0-600'=>'600元以下',
            '600-800'=>'600-800元',
            '800-1000'=>'800-1000元',
            '1000-1200'=>'1000-1200元',
            '1200-1500'=>'1200-1500元',
            '1500-2000'=>'1500-2000元',
            '2000-3000'=>'2000-3000元',
            '3000-4000'=>'3000-4000元',
            '4000-5000'=>'4000-5000元',
            '5000-0'=>'5000元以上'
        );
        $this->assign('house_price_option', $house_price_option);

        //房屋产权
        $belongLists =getArray('belong');
        $house = D('HouseRentRelation');
        //房源特色
        $house_feature_option = getArray('house_feature');
        $this->assign('house_feature_option', $house_feature_option);
        //id
        $id = I('get.id');

        if(!$id){
            $this->redirect('index');
        }

        //将浏览过的房源写入cookies
        cookiesmyrent($id);

        //详细信息
        $dataInfo = $house->relation(true)->where(array('id'=>$id))->find();
        //p($dataInfo);
        if(!$dataInfo){
            $this->redirect('index','该房源不存在或已删除');
        }
        //房屋类型
        $houseTypeLists = getArray('house_type');
        $dataInfo['house_type'] = $houseTypeLists[$dataInfo['house_type']];
        $dataInfo['updated'] = time2Units(time()-$dataInfo['updated']);
        $dataInfo['cityarea_name'] = $cityarea_option[$dataInfo['cityarea_id']];
        $dataInfo['house_toward'] = getCaption('house_toward',$dataInfo['house_toward']);//取字典名称

        if($dataInfo['house_feature']){
            $dataInfo['house_feature'] =  getCaption('rent_feature',$dataInfo['house_feature']);
        }

        $dataInfo['house_fitment'] =  getCaption('house_fitment',$dataInfo['house_fitment']);
        $dataInfo['house_support'] =  getCaption('house_installation',$dataInfo['house_support']);
        $dataInfo['house_deposit'] =  getCaption('rent_deposittype',$dataInfo['house_deposit']);


        $this->assign('dataInfo', $dataInfo);
        //p($dataInfo);
        $houseImageList=$dataInfo['houserent_pic'];
        $this->assign('houseImageList',$houseImageList);
        if(!$dataInfo['house_thumb'] && $houseImageList) {
            //没有缩略图，把房源图片抽出一张

            $rand_key = array_rand($houseImageList);
            $dataInfo['house_thumb'] = $houseImageList[$rand_key]['pic_thumb'] ? $houseImageList[$rand_key]['pic_thumb'] : $houseImageList[$rand_key]['pic_url'];
            M('houserent')->where(array('id'=>$id))->save(array('house_thumb'=>$dataInfo['house_thumb']));
        }



        //经纪人详细情况

        $brokerInfo = $member->getInfo($dataInfo['broker_id'],'*',true);
        if($brokerInfo['company_id']){
            $company = M('company');
            $brokerInfo['company_name'] = $company->where(array('id'=>$brokerInfo['company_id']))->getField('company_name');
            $brokerInfo['company_phone'] = $company->where(array('id'=>$brokerInfo['company_id']))->getField('company_phone');
        }

        //积分配置文件
        $integral_array = C('RANK');
        $brokerInfo['brokerRank'] = getNumByScore($brokerInfo['scores'],$integral_array,'pic');
        $this->assign('brokerInfo', $brokerInfo);
        //p($brokerInfo);

        //获取搬家公司信息
        $company = M('company');
        $moveCompanyList=$company->where(array('status'=>1,'type'=>1))->limit(9)->select();
        $this->assign('moveCompanyList', $moveCompanyList);


        //获取装修公司信息
        $decorationCompanyList = $company->where(array('status'=>1,'type'=>2))->limit(9)->select();
        $this->assign('decorationCompanyList', $decorationCompanyList);
        //p($decorationCompanyList);

        //小区
        $borough = D('BoroughView');

        if($dataInfo['borough_id']){
            //小区详细信息
            $boroughInfo=$borough->where(array('id'=>$dataInfo['borough_id']))->find();
            $boroughInfo['cityarea_name'] = $cityarea_option[$boroughInfo['cityarea_id']];
            $boroughInfo['borough_support'] = getCaption('borough_support',$boroughInfo['borough_support']);
            $this->assign('boroughInfo', $boroughInfo);
            $boroughImageList = D('Borough')->getImgList($dataInfo['borough_id'],0,6);
            $this->assign('boroughImageList', $boroughImageList);

            if(!$dataInfo['house_thumb'] && $boroughImageList){
                //没有缩略图，把小区图片抽出一张
                $rand_key = array_rand($boroughImageList);
                $dataInfo['house_thumb'] = $boroughImageList[$rand_key]['pic_thumb']?$boroughImageList[$rand_key]['pic_thumb']:$boroughImageList[$rand_key]['pic_url'];
                $house->where(array('id'=>$id))->save(array('house_thumb'=>$dataInfo['house_thumb']));
            }

            //该小区价格相近房源
            $where = " and status =1 and id <> ".$id ." and (borough_id = ".$dataInfo['borough_id']." or borough_name = '".$dataInfo['borough_name']."') and house_price > ".($dataInfo['house_price']-10)." and house_price <".($dataInfo['house_price']+10);
            $borougSamePrice = $house->where('1=1'.$where," and (is_checked = 0 or is_checked = 1 )")->order('order_weight desc')->limit(7)->select();

            $this->assign('borougSamePrice', $borougSamePrice);
        }

        //同区域的价格相近房源
        $where = " and status =1 and id <> ".$id ." and cityarea_id = ".$dataInfo['cityarea_id']." and house_price > ".($dataInfo['house_price']-10)." and house_price <".($dataInfo['house_price']+10);
        $cityareaSamePrice = $house->where('1=1'.$where," and (is_checked = 0 or is_checked = 1 )")->order('order_weight desc')->limit(4)->select();

        $this->assign('cityareaSamePrice', $cityareaSamePrice);

        //该经纪人的其他房源
        if($dataInfo['broker_id']) {
            $where = " and status =1 and id <> " . $id . " and broker_id = " . $dataInfo['broker_id'];
            $brokerOthersList = $house->where('1=1' . $where, " and (is_checked = 0 or is_checked = 1 )")->order('order_weight desc')->limit(4)->select();
            $this->assign('brokerOthersList', $brokerOthersList);
        }

        //标题
        $this->title = $dataInfo['borough_name'].'出租，'.$dataInfo['house_room'].'室'.$dataInfo['house_hall'].'厅'.$dataInfo['house_toilet'].'卫'.$dataInfo['house_veranda'].'阳，'.$dataInfo['house_title'].' - '.$this->city.$this->titlec;

        //关键词
        $this->keyword = $dataInfo['borough_name'].'出租,'.$dataInfo['borough_name'].'房屋出租,'.$dataInfo['borough_name'].'租房,'.$dataInfo['borough_name'];

        //描述
        $this->description='';

        //点击增加统计
        $house->addClick($id);


        $this->menu='rent';
        $this->display();
    }
    /**
     * 我要求租
     */
    public function requireForm(){

        $houseWanted = M('house_wanted');
        $action=I('get.action');

        if($action =="save"){
            //p($_POST);die;
            //回复
            $wanted_type=2;
            $statistics = M('statistics');
            $house_no=$statistics->where(array('stat_index'=>'houseWanted_no'))->getField('stat_value')+1;
            $statistics->where(array('stat_index'=>'houseWanted_no'))->setInc('stat_value',1);
            $requireid=I('id',0,'intval');
            try{
                if($requireid){
                    $updateField = array(
                        'linkman'=>I('linkman'),
                        'link_tell'=>I('link_tell'),
                        'open_tell'=>I('open_tell',0,'intval'),
                        'requirement'=>I('requirement'),
                    );
                    $id=$houseWanted->where(array('id'=>$requireid))->save($updateField);
                }else{
                    $insertField = array(
                        'wanted_type'=>$wanted_type,
                        'house_no'=> $house_no,
                        'linkman'=>I('linkman'),
                        'link_tell'=>I('link_tell'),
                        'open_tell'=>I('open_tell',0,'intval'),
                        'requirement'=>I('requirement'),
                        'add_time'=>time(),
                    );
                    $id=$houseWanted->add($insertField);

                }
                if($_GET['consign']){
                    //$this->redirect('requireExpert?id='.$id);
                }else{
                    $this->redirect(MODULE_NAME.'/Rent/requireDone',array('id'=>$id));
                }
            }catch (Exception $e){
                $this->error('出错了');
            }
        }else {

            //区域字典
            $cityarea_option = getArray('cityarea');
            $this->assign('cityarea_option', $cityarea_option);

            $house_price_option = array(
                '0-600' => '600元以下',
                '600-800' => '600-800元',
                '800-1000' => '800-1000元',
                '1000-1200' => '1000-1200元',
                '1200-1500' => '1200-1500元',
                '1500-2000' => '1500-2000元',
                '2000-3000' => '2000-3000元',
                '3000-4000' => '3000-4000元',
                '4000-5000' => '4000-5000元',
                '5000-0' => '5000元以上'
            );
            $this->assign('house_price_option', $house_price_option);

            //详细信息
            $id = $_GET['id'] ? intval($_GET['id']) : 0;
            if ($id) {
                $dataInfo = $houseWanted->where(array('id'=>$id))->find();
                if (!$dataInfo) {
                    $this->error('信息不存在或已删除',U(MODULE_NAME.'/Rent/requirelist'));
                }
                $dataInfo['requirement_short'] = substrs($dataInfo['requirement'], 40);
                $this->assign('dataInfo', $dataInfo);
            }
        }
        $this->display();
    }

    /**
     * 发布求租成功显示页
     */
    public function requireDone(){

        $id = intval($_GET['id']);
        if(!$id){
            $this->redirect('requireList');
        }
        //区域字典
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);

        $house_price_option = array(
            '0-600'=>'600元以下',
            '600-800'=>'600-800元',
            '800-1000'=>'800-1000元',
            '1000-1200'=>'1000-1200元',
            '1200-1500'=>'1200-1500元',
            '1500-2000'=>'1500-2000元',
            '2000-3000'=>'2000-3000元',
            '3000-4000'=>'3000-4000元',
            '4000-5000'=>'4000-5000元',
            '5000-0'=>'5000元以上'
        );
        $this->assign('house_price_option', $house_price_option);
        //详细信息
        $houseWanted = M('house_wanted');
        $dataInfo = $houseWanted->where(array('id'=>$id))->find();

        if(!$dataInfo){
            jsurlto('信息不存在或已删除',U(MODULE_NAME.'/Rent/requireList'));
        }
        $this->assign('dataInfo', $dataInfo);
        $this->display();
    }

    /**
     * 求租详情
     */
    public function requireDetail(){


        //id
        $id = intval($_GET['id']);
        if(!$id){
            $this->redirect('requireList');
        }
        $houseWanted = M('house_wanted');
        $action=I('get.action');
        $code=I('vaild');

        if($action =="reply"){
            //p($_POST);die;
            //回复

            if (!$this->check_verify($code,3)) {
                $this->error("验证码错误");
            }
            if(!$id){
                $this->redirect("requireList");
            }
            if(!$_POST['linkman']){
                $this->error("请填写联系人");
            }
            if(!$_POST['content']){
                $this->error("请填写内容");
            }
            try{
                $insertField = array(
                    'wanted_id'=>$id,
                    'linkman'=>I('linkman'),
                    'content'=>I('content'),
                    'add_time'=>time(),
                );
                M('house_wantedreply')->add($insertField);
                $this->redirect(MODULE_NAME.'/Rent/requireDetail',array('id'=>$id));

            }catch (Exception $e){
                $this->error('出错了');
            }
            exit;
        }else{


            //区域字典
            $cityarea_option = getArray('cityarea');
            $this->assign('cityarea_option', $cityarea_option);

            $house_price_option = array(
                '0-600'=>'600元以下',
                '600-800'=>'600-800元',
                '800-1000'=>'800-1000元',
                '1000-1200'=>'1000-1200元',
                '1200-1500'=>'1200-1500元',
                '1500-2000'=>'1500-2000元',
                '2000-3000'=>'2000-3000元',
                '3000-4000'=>'3000-4000元',
                '4000-5000'=>'4000-5000元',
                '5000-0'=>'5000元以上'
            );
            $this->assign('house_price_option', $house_price_option);
            //详细信息
            $dataInfo = $houseWanted->where(array('id'=>$id))->find();

            if(!$dataInfo){
                $this->error('信息不存在或已删除',U(MODULE_NAME.'/Rent/requireList'));
            }
            $dataInfo['requirement_short'] = substrs($dataInfo['requirement'],40);
            $this->assign('dataInfo', $dataInfo);
            //回复列表
            $replyList=M('house_wantedreply')->where(array('wanted_id'=>$id))->order('add_time desc')->select();
            $this->assign('replyList', $replyList);

            $this->assign('reply_num', count($replyList));

            $this->display();
        }

    }

    /**
     * 验证码
     */
    public function verify(){
        $id=I('get.id','','intval');
        $config = array(
            'imageW'=>75,
            'imageH'=>30,
            'fontSize'=>12,
            'length' => 3, // 验证码位数
            'useNoise' => false, // 关闭验证码杂点
            'reset' => false, // 验证成功后是否重置

        );
        $Verify=new \Think\Verify($config);
        $Verify->entry($id);


    }
    /**
     * 封装的验证码检测方法
     * @param $code
     * @param string $id
     * @return bool
     */
    function check_verify($code, $id = ''){

        $verify = new \Think\Verify();
        $verify->reset=false;// 验证成功后是否重置
        return $verify->check($code, $id);
    }

    /**
     * 求租列表
     */
    public function requireList(){
        

        //区域字典
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);
        $house_type_option = getArray('house_type');
        $this->assign('house_type_option', $house_type_option);

        $house_price_option = array(
            '0-600'=>'600元以下',
            '600-800'=>'600-800元',
            '800-1000'=>'800-1000元',
            '1000-1200'=>'1000-1200元',
            '1200-1500'=>'1200-1500元',
            '1500-2000'=>'1500-2000元',
            '2000-3000'=>'2000-3000元',
            '3000-4000'=>'3000-4000元',
            '4000-5000'=>'4000-5000元',
            '5000-0'=>'5000元以上'
        );
        $this->assign('house_price_option', $house_price_option);

        $where =' wanted_type=2 and status=1 and is_solve =0 ';

        //q
        $q = $_GET['q']=="输入求租联系人或联系电话" ? "":$_GET['q'];
        if($q){
            // 小区名、路名或划片学校
            $where .=" and (linkman like '%".$q."%' or link_tell like '%".$q."%')" ;
        }
        //list_order 排序转换
        $list_order = " add_time desc";

        $list_num = 10;

        $houseWanted = M('house_wanted');
        $row_count = $houseWanted->where($where)->count();
        $this->assign('row_count',$row_count);

        $Page= new \Think\Page($row_count,$list_num);// 实例化分页类 传入总记录数和每页显示的记录数(10)
        $dataList =$houseWanted->where($where)->order($list_order)->limit($Page->firstRow.','.$Page->listRows)-> select();
        foreach ($dataList as $key=> $item){
            $dataList[$key]['requirement_short'] = substrs($item['requirement'],58);
            $item['expert_id'] = trim($item['expert_id'],',');
            $dataList[$key]['expert_num'] = count(explode(',',$item['expert_id']));
        }

        $this->assign('dataList', $dataList);
        $this->assign('pagePanel', $Page->show());//分页条
        $this->display();
    }

    /**
     * 举报
     */
    public function report(){
        $this->title =  $this->title.' - 虚假举报';
        $action=I('get.action');
        if($action == 'save'){
            //保存在ajax页面
            $house_id = intval($_POST['house_id']);
            $house = M('houserent');
            $report_target=$house->where(array('id'=>$house_id))->getField('broker_id');

            $reason = $_POST['reason'];
            $report = M('report');
            $dataFiled = array(
                'house_type'=>'rent',
                'house_id'=>$house_id,
                'report_target'=>$report_target,
                'reason'=>$reason,
                'addtime'=>time(),
            );
            try{
                $report->add($dataFiled);
                $this->ajaxReturn(array('status'=>true));
            }catch (Exception $e){
                $this->ajaxReturn(array('status'=>false));
            }
            exit;
        }
        $this->display();
    }
}