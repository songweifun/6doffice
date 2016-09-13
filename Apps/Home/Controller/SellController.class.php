<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/13
 * Time: 下午1:37
 */
namespace Home\Controller;
use Think\Controller;
class SellController extends CommonController{
    public function index(){
        
        $this->title = $this->city.'二手房 - '.$this->titlec;   //网站名称

        //关键词和描述
        $this->keyword = $this->sale_keyword;
        $this->description = $this->sale_description;


        //区域字典
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);
        $house_type_option = getArray('house_type');
        $this->assign('house_type_option', $house_type_option);

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
            '300-500'=>'300-500万',
            '500-0'=>'500万以上'
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
            $_GET['q'] = iconv("utf-8","gb2312",$_GET['q']);
        }

        $q = $_GET['q']=="可输入小区名、路名或划片学校" ? "":trim($_GET['q']);
        if($q){
            // 小区名、路名或划片学校
            $where_borough ="borough_name like '%".$q."%' or borough_address like '%".$q."%' or elementary_school like '%".$q."%' or middle_school like '%".$q."%'" ;
            $borough = M('borough');
            $borough_ids=$borough->where($where_borough)->getField('id');
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

        $house = D('HouseSellView');
        $row_count = $house->getCount(1,$where);

        $Page= new \Think\Page($row_count,$list_num);// 实例化分页类 传入总记录数和每页显示的记录数(10)
        //$dataList =$house->query('select * from fke_housesell where is_checked=1'.$where.$list_order.' limit '.$Page->firstRow.','.$Page->listRows);
        $dataList =$house->where('is_checked=1'.$where)->order($list_order)->limit($Page->firstRow.','.$Page->listRows)-> select();
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

        //p($dataList);die;
        $this->menu='sale';
        $this->display();
    }
}