<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/17
 * Time: 下午9:51
 */
namespace Home\Controller;
use Think\Controller;
class CommunityController extends CommonController{
    public function index(){
        $this->title = $this->city.'小区 - '.$this->titlec;   //网站名称

        //关键词和描述
        $this->keyword = $this->community_keyword;
        $this->description = $this->community_description;


        //区域字典
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);
        $borough_type_option = getArray('borough_type');
        $this->assign('borough_type_option', $borough_type_option);

        $house_letter_option = range('A','Z');
        $this->assign('house_letter_option', $house_letter_option);

        $where =' and isdel = 0 ';
        //cityarea
        $cityarea = intval($_GET['cityarea']);
        if($cityarea){
            $where .= ' and cityarea_id = '.$cityarea;
           $this->title = $cityarea_option[$cityarea].",".$this->title;
        }

        $dd = D('DdItem');
        $borough_section=$dd->getSonList($cityarea);
        $this->assign('borough_section',$borough_section);

        //cityarea2
        $cityarea2 = intval($_GET['cityarea2']);
        if($cityarea2){
            $where .= ' and cityarea2_id = '.$cityarea2;
            $this->title = $cityarea_option[$cityarea].",".$this->title;
        }

        //type
        $type = intval($_GET['type']);
        if($type){
            $where .= ' and borough_type = '.$type;
            $this->title = $borough_type_option[$type].",".$this->title;
        }

        //q
        $q = $_GET['q']=="可输入小区名、路名或划片学校" ? "":trim($_GET['q']);
        if($q){
            // 小区名、路名或划片学校
            $where.=" and (borough_name like '%".$q."%' or borough_alias like '%".$q."%' or borough_letter like '%".$q."%' or borough_address like '%".$q."%' or elementary_school like '%".$q."%' or middle_school like '%".$q."%' )" ;
            $this->title = $q.",".$this->title;
        }
        //letter
        $letter = $_GET['letter'];
        if($letter){
            $where .= " and borough_letter like '".$letter."%'";
            $this->title = "字母".$letter."开头,".$this->title;
        }

        //list_order 排序转换
        switch ($_GET['list_order']){
            case "house_num desc":
                $list_order = " sell_num+rent_num desc";
                break;
            case "borough_avgprice asc":
                $list_order = " borough_avgprice asc";
                break;
            case "borough_avgprice desc":
                $list_order = " borough_avgprice desc";
                break;
            case "percent_change asc":
                $list_order = " percent_change asc";
                break;
            case "percent_change desc":
                $list_order = " percent_change desc";
                break;
            case "sell_num asc":
                $list_order = " sell_num desc";
                break;
            case "rent_num desc":
                $list_order = " rent_num desc";
                break;
            default:
                $list_order = " sell_num desc";
                break;
        }

        //list_num
        $list_num = intval($_GET['list_num']);
        if(!$list_num){
            $list_num = 10;
        }

        $borough = D('BoroughView');
        $row_count = $borough->where("is_checked=1".$where)->count();
        $Page= new \Think\Page($row_count,$list_num);// 实例化分页类 传入总记录数和每页显示的记录数(10)
        $page_count=ceil($row_count/$list_num);
        $pageno = $_GET['p']?intval($_GET['p']):1;
        $pre_page = $pageno>1?$pageno-1:1;
        $next_page = $pageno<$page_count?$pageno+1:$page_count;
        $this->assign('pageno', $pageno);
        $this->assign('row_count', $row_count);
        $this->assign('page_count',$page_count);
        $this->assign('pre_page', $pre_page);
        $this->assign('next_page',$next_page);

        $dataList =$borough->where('is_checked=1'.$where)->order($list_order)->limit($Page->firstRow.','.$Page->listRows)-> select();
        $member = D('MemberView');

        //积分配置文件
        $integral_array = C('RANK');
        foreach ($dataList as $key=> $item){
            //随机取一个专家
            $expert_id=M('borough_adviser')->field('member_id')->where(array('borough_id'=>$item['id'],'status'=>1))->order('rand()')->limit(1)->select();
            //p($expert_id);
            //专家信息
            if($expert_id[0]){
                $dataList[$key]['broker_info'] = $member->getInfo($expert_id[0],'*',true);
                $dataList[$key]['broker_info']['outlet'] = substr($dataList[$key]['broker_info']['outlet'],0,strpos($dataList[$key]['broker_info']['outlet'],'-'));
                $dataList[$key]['broker_info']['brokerRank'] = getNumByScore($dataList[$key]['broker_info']['scores'],$integral_array,'pic');
            }
            $dataList[$key]['cityarea_name'] = $cityarea_option[$item['cityarea_id']];
        }

        $this->assign('dataList', $dataList);
        $this->assign('pagePanel', $Page->show());//分页条

        //右边的优质房源列表
        $boroughList=$borough->where(array('is_checked'=>1))->order('sell_num+rent_num desc')->limit(4)->select();
        $this->assign('boroughList', $boroughList);
        $this->menu='community';
        $this->display();
    }

    public function general(){
        //区域字典
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);

        //id
        $id = intval($_GET['id']);
        if(!$id){
            $this->redirect('index.php');
        }

        //小区
        $borough = D('BoroughView');
        //小区详细信息
        $boroughInfo = $borough->where(array('id'=>$id))->find();
        if(!$boroughInfo){
            $this->redirect('index.php');
        }

        $boroughInfo['cityarea_name'] = $cityarea_option[$boroughInfo['cityarea_id']];
        $boroughInfo['borough_section'] = getCaption('borough_section',$boroughInfo['borough_section']);
        $boroughInfo['borough_support'] = getCaption('borough_support',$boroughInfo['borough_support']);
        $boroughInfo['borough_sight'] = getCaption('borough_sight',$boroughInfo['borough_sight']);
        $boroughInfo['borough_type'] = getCaption('borough_type',$boroughInfo['borough_type']);
        $boroughInfo['unsign_percent_change'] = abs($boroughInfo['percent_change']);

        //小区图片
        $boroughImageList = D('Borough')->getImgList($id,0,4);
        $this->assign('boroughImageList', $boroughImageList);
        $borough_img_num = count($boroughImageList);
        if($borough_img_num%2){
            $borough_img_num = 2-$borough_img_num%2;
            $this->assign('borough_img_num', $borough_img_num);
        }
        if(!$boroughInfo['borough_thumb']){
            if($boroughImageList){
                $boroughInfo['borough_thumb'] = $boroughImageList[0]['pic_url'];
                $borough->where(array('id'=>$boroughInfo['id']))->save(array('borough_thumb'=>$boroughInfo['borough_thumb']));
            }
        }
        $this->assign('dataInfo', $boroughInfo);

        //小区户型图
        $boroughDrawList = D('Borough')->getImgList($id,1,4);
        $this->assign('boroughDrawList', $boroughDrawList);
        $borough_draw_num = count($boroughDrawList);
        if($borough_draw_num%2){
            $borough_draw_num = 2-$borough_draw_num%2;
            $this->assign('borough_draw_num', $borough_draw_num);
        }

        //出售房源
        $houseSell = D('HouseSellRelation');
        $boroughSellList = $houseSell->where(array('is_checked'=>1,'status'=>1,'borough_id'=>$id))->order('order_weight desc')->limit(3)->select();
        foreach ($boroughSellList as $key=> $item){
            if($item['house_totalarea']){
                $boroughSellList[$key]['avg_price']= round($item['house_price']*10000/$item['house_totalarea']);
            }
        }
        $this->assign('boroughSellList', $boroughSellList);
        //租房源
        $houseRent = D('HouseRentView');
        $boroughRentList = $houseRent->where(array('is_checked'=>1,'status'=>1,'borough_id'=>$id))->order('order_weight desc')->limit(3)->select();
        $fitment_arr = getArray('house_fitment');
        foreach ($boroughRentList as $key=>$item){
            $boroughRentList[$key]['house_fitment'] = $fitment_arr[$item['house_fitment']];
        }
        $this->assign('boroughRentList', $boroughRentList);
//p($boroughInfo);
        //价格相近小区 +-500
        $boroughSamePriceList =$borough->where('is_checked=1'.' and borough.id<>'.$id.' and isdel =0 and borough_avgprice >='.($boroughInfo['borough_avgprice']-500).' and borough_avgprice<='.($boroughInfo['borough_avgprice']+500))->order('sell_num desc')->limit(2)->select();
        $this->assign('boroughSamePriceList', $boroughSamePriceList);

        //cityarea小区
        $sameCityareaBorough =$borough->where('is_checked=1'.' and isdel =0 and cityarea_id = '.$boroughInfo['cityarea_id'])->order('sell_num desc')->limit(3)->select();
        $this->assign('sameCityareaBorough', $sameCityareaBorough);

        //页面标题
        $this->title = $boroughInfo['borough_name'].'小区信息，'.$boroughInfo['borough_name'].'小区房价 - '.$this->city.$this->titlec;

        //关键词
        $this->keyword =$boroughInfo['borough_name'].','.$boroughInfo['borough_name'].'小区信息,'.$boroughInfo['borough_name'].'小区房价,'.$boroughInfo['borough_name'].'小区房源';

        //增加计数
        M('borough')->where(array('id'=>$boroughInfo['id']))->setInc('click_num',1);
        $this->assign('community_menu','general');

        $this->menu='community';


        $this->display();
    }

    /**
     * community sell
     */
    public function sell(){
        //区域字典
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);

        $house_price_option = array(
            '0-40'=>'40万以下',
            '40-60'=>'40-60万',
            '60-80'=>'60-80万',
            '80-100'=>'80-100万',
            '100-120'=>'100-120万',
            '120-150'=>'120-150万',
            '150-200'=>'150-200万',
            '200-250'=>'200-250万',
            '250-300'=>'250-300万',
            '300-0'=>'300万以上'
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
            '200-250'=>'150-200㎡',
            '250-300'=>'250-300㎡',
            '300-0'=>'300㎡以上'
        );
        $this->assign('house_totalarea_option', $house_totalarea_option);

        //id
        $id = intval($_GET['id']);
        if(!$id){
            $this->redirect('index.php');
        }

        //小区
        $borough = D('BoroughView');
        //小区详细信息
        $boroughInfo = $borough->where(array('id'=>$id))->find();
        if(!$boroughInfo){
            $this->redirect('index.php');
        }

        $boroughInfo['cityarea_name'] = $cityarea_option[$boroughInfo['cityarea_id']];
        $boroughInfo['borough_section'] = getCaption('borough_section',$boroughInfo['borough_section']);
        $boroughInfo['borough_support'] = getCaption('borough_support',$boroughInfo['borough_support']);
        $boroughInfo['borough_sight'] = getCaption('borough_sight',$boroughInfo['borough_sight']);
        $boroughInfo['borough_type'] = getCaption('borough_type',$boroughInfo['borough_type']);
        $boroughInfo['unsign_percent_change'] = abs($boroughInfo['percent_change']);
        //小区图片
        $boroughImageList = D('Borough')->getImgList($id,0,4);
        $this->assign('boroughImageList', $boroughImageList);
        $borough_img_num = count($boroughImageList);
        if($borough_img_num%2){
            $borough_img_num = 2-$borough_img_num%2;
            $this->assign('borough_img_num', $borough_img_num);
        }
        if(!$boroughInfo['borough_thumb']){
            if($boroughImageList){
                $boroughInfo['borough_thumb'] = $boroughImageList[0]['pic_url'];
                $borough->where(array('borough.id'=>$boroughInfo['id']))->save(array('borough_thumb'=>$boroughInfo['borough_thumb']));
            }
        }
        $this->assign('dataInfo', $boroughInfo);

        //小区户型图
        $boroughDrawList = D('Borough')->getImgList($id,1,4);
        $this->assign('boroughDrawList', $boroughDrawList);
        $borough_draw_num = count($boroughDrawList);
        if($borough_draw_num%2){
            $borough_draw_num = 2-$borough_draw_num%2;
            $this->assign('borough_draw_num', $borough_draw_num);
        }

        //小区专家
        $boroughAdviserId = M('borough_adviser')->where(array('borough_id'=>$id,'status'=>1))->order('rand()')->limit(1)->select();
        $integral_array = C('RANK');
        if($boroughAdviserId){
            foreach ($boroughAdviserId as $key => $item){
                $boroughAdviserList[$key] = D('MemberView')->getInfo($item['member_id'],'*',true);
                $boroughAdviserList[$key]['brokerRank'] = getNumByScore($boroughAdviserList[$key]['scores'],$integral_array,'pic');
            }
        }
        $this->assign('boroughAdviserList', $boroughAdviserList);

        //纪录列表

        $where =' and status=1 and borough_id = '.$id;

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
        }
//list_order 排序转换
        switch ($_GET['list_order']){
            case "avg_price desc":
                $list_order = " house_price/house_totalarea desc";
                break;
            case "avg_price asc":
                $list_order = " house_price/house_totalarea asc";
                break;
            case "created desc":
                $list_order = " is_top desc,updated desc";
                break;
            case "created asc":
                $list_order = " is_top desc,updated asc";
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
        $list_num = intval($_GET['list_num']);
        if(!$list_num){
            $list_num = 10;
        }

        $house = D('HouseSellRelation');
        $row_count = $house->where("is_checked=1".$where)->count();
        $Page= new \Think\Page($row_count,$list_num);// 实例化分页类 传入总记录数和每页显示的记录数(10)
        $page_count=ceil($row_count/$list_num);
        $pageno = $_GET['p']?intval($_GET['p']):1;
        $pre_page = $pageno>1?$pageno-1:1;
        $next_page = $pageno<$page_count?$pageno+1:$page_count;
        $this->assign('pageno', $pageno);
        $this->assign('row_count', $row_count);
        $this->assign('page_count',$page_count);
        $this->assign('pre_page', $pre_page);
        $this->assign('next_page',$next_page);

        $dataList =$house->where('is_checked=1'.$where)->order($list_order)->limit($Page->firstRow.','.$Page->listRows)-> select();
        $member = D('MemberView');

        //积分配置文件

        foreach ($dataList as $key=> $item){
            if($item['house_price'] && $item['house_totalarea']){
                $dataList[$key]['avg_price'] = round($item['house_price']*10000/$item['house_totalarea']);
            }else{
                $dataList[$key]['avg_price'] = "未知";
            }
            //图片数量
            $dataList[$key]['pic_num'] = M('housesell_pic')->where(array('housesell_id'=>$item['id']))->count();
            //经纪人信息
            $dataList[$key]['broker_info'] = D('MemberView')->getInfo($item['broker_id'],'*',true);
            $dataList[$key]['broker_info']['outlet'] = substr($dataList[$key]['broker_info']['outlet'],0,strpos($dataList[$key]['broker_info']['outlet'],'-'));

            $dataList[$key]['broker_info']['brokerRank'] = getNumByScore($dataList[$key]['broker_info']['scores'],$integral_array,'pic');
            //是否是专家
            $dataList[$key]['broker_info']['is_expert'] =M('borough_adviser')->where(array('member_id'=>$item['broker_id'],'status'=>1))->count();
        }

        $this->assign('dataList', $dataList);
        $this->assign('pagePanel', $Page->show());//分页条

        //页面标题
        $this->title = $boroughInfo['borough_name'].'二手房，'.$boroughInfo['borough_name'].'房屋出售，'.$boroughInfo['borough_name'].' - '.$this->city.$this->title;

        //关键词
        $this->keyword = $boroughInfo['borough_name'].','.$boroughInfo['borough_name'].'二手房,'.$boroughInfo['borough_name'].'房屋出售';
        //描述
        $this->description='';

        $this->assign('community_menu','sale');

        $this->menu='community';
        $this->display();
    }
    /**
     * community rent
     */

    public function rent(){
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
            '3000-0'=>'3000元以上'
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
            '200-250'=>'150-200㎡',
            '250-300'=>'250-300㎡',
            '300-0'=>'300㎡以上'
        );
        $this->assign('house_totalarea_option', $house_totalarea_option);


        //id
        $id = intval($_GET['id']);
        if(!$id){
            $this->redirect('index.php');
        }

        //小区
        $borough = D('BoroughView');
        //小区详细信息
        $boroughInfo = $borough->where(array('id'=>$id))->find();
        if(!$boroughInfo){
            $this->redirect('index.php');
        }

        $boroughInfo['cityarea_name'] = $cityarea_option[$boroughInfo['cityarea_id']];
        $boroughInfo['borough_section'] = getCaption('borough_section',$boroughInfo['borough_section']);
        $boroughInfo['borough_support'] = getCaption('borough_support',$boroughInfo['borough_support']);
        $boroughInfo['borough_sight'] = getCaption('borough_sight',$boroughInfo['borough_sight']);
        $boroughInfo['borough_type'] = getCaption('borough_type',$boroughInfo['borough_type']);
        $boroughInfo['unsign_percent_change'] = abs($boroughInfo['percent_change']);
        //小区图片
        $boroughImageList = D('Borough')->getImgList($id,0,4);
        $this->assign('boroughImageList', $boroughImageList);
        $borough_img_num = count($boroughImageList);
        if($borough_img_num%2){
            $borough_img_num = 2-$borough_img_num%2;
            $this->assign('borough_img_num', $borough_img_num);
        }
        if(!$boroughInfo['borough_thumb']){
            if($boroughImageList){
                $boroughInfo['borough_thumb'] = $boroughImageList[0]['pic_url'];
                $borough->where(array('borough.id'=>$boroughInfo['id']))->save(array('borough_thumb'=>$boroughInfo['borough_thumb']));
            }
        }
        $this->assign('dataInfo', $boroughInfo);

        //小区户型图
        $boroughDrawList = D('Borough')->getImgList($id,1,4);
        $this->assign('boroughDrawList', $boroughDrawList);
        $borough_draw_num = count($boroughDrawList);
        if($borough_draw_num%2){
            $borough_draw_num = 2-$borough_draw_num%2;
            $this->assign('borough_draw_num', $borough_draw_num);
        }

        //小区专家
        $boroughAdviserId = M('borough_adviser')->where(array('borough_id'=>$id,'status'=>1))->order('rand()')->limit(1)->select();
        $integral_array = C('RANK');
        if($boroughAdviserId){
            foreach ($boroughAdviserId as $key => $item){
                $boroughAdviserList[$key] = D('MemberView')->getInfo($item['member_id'],'*',true);
                $boroughAdviserList[$key]['brokerRank'] = getNumByScore($boroughAdviserList[$key]['scores'],$integral_array,'pic');
            }
        }
        $this->assign('boroughAdviserList', $boroughAdviserList);

        //纪录列表
        $where =' and status=1 and borough_id = '.$id;

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
        }
//list_order 排序转换
        switch ($_GET['list_order']){
            case "avg_price desc":
                $list_order = " house_price/house_totalarea desc";
                break;
            case "avg_price asc":
                $list_order = " house_price/house_totalarea asc";
                break;
            case "created desc":
                $list_order = " is_top desc,updated desc";
                break;
            case "created asc":
                $list_order = " is_top desc,updated asc";
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
        $list_num = intval($_GET['list_num']);
        if(!$list_num){
            $list_num = 10;
        }

        $house = D('HouseRentRelation');
        $row_count = $house->where("is_checked=1".$where)->count();
        $Page= new \Think\Page($row_count,$list_num);// 实例化分页类 传入总记录数和每页显示的记录数(10)
        $page_count=ceil($row_count/$list_num);
        $pageno = $_GET['p']?intval($_GET['p']):1;
        $pre_page = $pageno>1?$pageno-1:1;
        $next_page = $pageno<$page_count?$pageno+1:$page_count;
        $this->assign('pageno', $pageno);
        $this->assign('row_count', $row_count);
        $this->assign('page_count',$page_count);
        $this->assign('pre_page', $pre_page);
        $this->assign('next_page',$next_page);

        $dataList =$house->where('is_checked=1'.$where)->order($list_order)->limit($Page->firstRow.','.$Page->listRows)-> select();
        $member = D('MemberView');

        //积分配置文件

        foreach ($dataList as $key=> $item){
            if($item['house_price'] && $item['house_totalarea']){
                $dataList[$key]['avg_price'] = round($item['house_price']*10000/$item['house_totalarea']);
            }else{
                $dataList[$key]['avg_price'] = "未知";
            }
            //图片数量
            $dataList[$key]['pic_num'] = M('houserent_pic')->where(array('houserent_id'=>$item['id']))->count();
            //经纪人信息
            $dataList[$key]['broker_info'] = D('MemberView')->getInfo($item['broker_id'],'*',true);
            $dataList[$key]['broker_info']['outlet'] = substr($dataList[$key]['broker_info']['outlet'],0,strpos($dataList[$key]['broker_info']['outlet'],'-'));

            $dataList[$key]['broker_info']['brokerRank'] = getNumByScore($dataList[$key]['broker_info']['scores'],$integral_array,'pic');
            //是否是专家
            $dataList[$key]['broker_info']['is_expert'] =M('borough_adviser')->where(array('member_id'=>$item['broker_id'],'status'=>1))->count();
        }

        $this->assign('dataList', $dataList);
        $this->assign('pagePanel', $Page->show());//分页条

        //页面标题
        $this->title = $boroughInfo['borough_name'].'租房，'.$boroughInfo['borough_name'].'房屋出租，'.$boroughInfo['borough_name'].' - '.$this->city.$this->title;

        //关键词
        $this->keyword = $boroughInfo['borough_name'].','.$boroughInfo['borough_name'].'租房,'.$boroughInfo['borough_name'].'房屋出租';
        //描述
        $this->description='';
        $this->assign('community_menu','rent');

        $this->menu='community';


        $this->display();
    }

    /**
     * community photo
     */
    public function photo(){

        //区域字典
        $cityarea_option = getArray('cityarea');
       $this->assign('cityarea_option', $cityarea_option);

        //id
        $id = intval($_GET['id']);
        if(!$id){
            $this->redirect('index.php');
        }

        //小区
        $borough = M('borough');

        //小区详细信息
        $boroughInfo = $borough->field('id,borough_name,borough_alias')->where(array('id'=>$id))->find();
        //p($boroughInfo);
        $this->assign('dataInfo', $boroughInfo);

        //小区图片
        $boroughImageList = D('Borough')->getImgList($id,0);
        $p_id=intval($_GET['p_id']);
        if(!$p_id){
            $p_id=1;
        }
        $picInfo=$boroughImageList[$p_id-1]['pic_url'];
        $this->assign('pic_url', $picInfo);
        $this->assign('boroughImageList', $boroughImageList);
        $this->assign('next_img_id', $p_id+1);

        $borough_img_num = count($boroughImageList);

        $this->assign('borough_img_num', $borough_img_num);

        //小区详细信息
        $boroughInfo = D('BoroughView')->where(array('id'=>$id))->find();

        if(!$boroughInfo){
            $this->redirect('index.php');
        }

        $boroughInfo['cityarea_name'] = $cityarea_option[$boroughInfo['cityarea_id']];
        $boroughInfo['borough_section'] = getCaption('borough_section',$boroughInfo['borough_section']);
        $boroughInfo['borough_support'] = getCaption('borough_support',$boroughInfo['borough_support']);
        $boroughInfo['borough_sight'] = getCaption('borough_sight',$boroughInfo['borough_sight']);
        $boroughInfo['borough_type'] = getCaption('borough_type',$boroughInfo['borough_type']);
        $boroughInfo['unsign_percent_change'] = abs($boroughInfo['percent_change']);
        if(!$boroughInfo['borough_thumb']){
            if($boroughImageList){
                $boroughInfo['borough_thumb'] = $boroughImageList[0]['pic_url'];
                M('borough')->where(array('id'=>$boroughInfo['id']))->save(array('borough_thumb'=>$boroughInfo['borough_thumb']));
            }
        }
        $this->assign('dataInfo', $boroughInfo);

        //页面标题
        $this->title = $boroughInfo['borough_name'].'小区照片，'.$boroughInfo['borough_name'].'小区实景，'.$boroughInfo['borough_name'].' - '.$this->city.$this->title;

        //关键词
        $this->keyword = $boroughInfo['borough_name'].','.$boroughInfo['borough_name'].'小区照片,'.$boroughInfo['borough_name'].'小区实景';
        //描述
        $this->description='';
        $this->assign('community_menu','photo');
        $this->menu='community';
        $this->display();
    }
    /**
     * community 户型图
     */
    public function structrue(){

        //区域字典
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);

        //id
        $id = intval($_GET['id']);
        if(!$id){
            $this->redirect('index.php');
        }

        //小区
        //$borough = D('Borough');


        //小区图片
        $boroughImageList = D('Borough')->getImgList($id,1);
        $this->assign('boroughImageList', $boroughImageList);
        $d_id=intval($_GET['d_id']);

        if(!$d_id){
            $d_id=1;
        }
        $picInfo=$boroughImageList[$d_id-1]['pic_url'];
        $this->assign('pic_url', $picInfo);
        $this->assign('boroughImageList', $boroughImageList);
        $this->assign('next_img_id', $d_id+1);
        $borough_img_num = count($boroughImageList);
        $this->assign('borough_img_num', $borough_img_num);

        //小区详细信息
        $boroughInfo = D('BoroughView')->where(array('id'=>$id))->find();

        if(!$boroughInfo){
            $this->redirect('index.php');
        }

        $boroughInfo['cityarea_name'] = $cityarea_option[$boroughInfo['cityarea_id']];
        $boroughInfo['borough_section'] = getCaption('borough_section',$boroughInfo['borough_section']);
        $boroughInfo['borough_support'] = getCaption('borough_support',$boroughInfo['borough_support']);
        $boroughInfo['borough_sight'] = getCaption('borough_sight',$boroughInfo['borough_sight']);
        $boroughInfo['borough_type'] = getCaption('borough_type',$boroughInfo['borough_type']);
        $boroughInfo['unsign_percent_change'] = abs($boroughInfo['percent_change']);
        if(!$boroughInfo['borough_thumb']){
            if($boroughImageList){
                $boroughInfo['borough_thumb'] = $boroughImageList[0]['pic_url'];
                M('borough')->where(array('id'=>$boroughInfo['id']))->save(array('borough_thumb'=>$boroughInfo['borough_thumb']));
            }
        }
        $this->assign('dataInfo', $boroughInfo);

        //页面标题
        $this->title = $boroughInfo['borough_name'].'户型图，'.$boroughInfo['borough_name'].'户型结构，'.$boroughInfo['borough_name'].' - '.$this->city.$this->titlec;

        //关键词
        $this->keyword = $boroughInfo['borough_name'].','.$boroughInfo['borough_name'].'户型图,'.$boroughInfo['borough_name'].'户型结构';

        //描述
        $this->description='';
        $this->assign('community_menu','structure');

        $this->menu='community';

        $this->display();
    }
}