<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/18
 * Time: 下午10:04
 */
namespace Map\Controller;
use Think\Controller;
class IndexController extends Controller{
    public function index(){
        $this->display();
    }
    public function rent(){
        $this->display();
    }
    public function marker(){
        $markers=M('borough')->field('id,lat,lng,borough_address,borough_name,rent_num')->select();
        //p($markers);die;
        $this->ajaxReturn($markers);
    }

    public function getHouseRent(){
        //import('Class.Dd',APP_PATH);
        $houseRent=M('houserent');
        $houseFitmentList = getArray('house_fitment');

        $id=I('get.bid');
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

            $arr['price']=$price;
        }else{
            $arr['price']="";
        }
        //room
        $room = intval($_GET['room']);
        if($room){
            $where .= ' and house_room = '.$room;
            $arr['room']=$room;
        }else{
            $arr['room']="";
        }

        //选择标签
        $source = intval($_GET['source']);
        if($source == 1){
            $where .= " and broker_id != 0 ";
            $arr['source']=$source;
        }elseif($source==2){
            $where .= " and broker_id = 0 ";
            $arr['source']=$source;
        }else{
            $arr['source']="";
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
                $arr['list_order']="house_price asc";
                break;
            case "house_price desc":
                $list_order = " is_top desc,house_price desc";
                $arr['list_order']="house_price desc";
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


        $count=M('houserent')->where('is_checked=1'.$where)->count();

        $Page=new \Think\Page($count,6);

        $page_count=ceil($count/6)>0?ceil($count/6):1;
        $pageno = $_GET['p']?intval($_GET['p']):1;
        $pre_page = $pageno>1?$pageno-1:1;
        $next_page = $pageno<$page_count?$pageno+1:$page_count;
        $Page -> setConfig('header','共%TOTAL_ROW%条');
        $Page -> setConfig('first','首页');
        $Page -> setConfig('last','共%TOTAL_PAGE%页');
        $Page -> setConfig('prev','上一页');
        $Page -> setConfig('next','下一页');
        $Page -> setConfig('link','indexpagenumb');//pagenumb 会替换成页码
        $Page -> setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

        $pageLimit = $Page->firstRow.','.$Page->listRows;

        $houserent=M('houserent')->where('is_checked=1'.$where)->order($list_order)->limit($pageLimit)->select();

        foreach($houserent as $k=>$v){
            $houserent[$k]['house_fitment']=$houseFitmentList[$v['house_fitment']];
            $houserent[$k]['house_title']=mb_substr($houserent[$k]['house_title'],0,14,'utf-8')."....";

        }
        //p($houserent);die;

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
            array('price'=>'5000-10000','house_price'=>'5000-10000元'),
            array('price'=>'10000-0','house_price'=>'10000元以上'),

        );
        $rentCountPrice=array();
        foreach ($rent_price_option as $key=>$item){
            $where = " and status =1 and borough_id=".$id;
            $temp = explode('-',$item['price']);

            if($temp[0]){
                $where .= ' and house_price>='.$temp[0];
            }
            if($temp[1]){
                $where .= ' and house_price<='.$temp[1];
            }
            //p($where);
            $house_num = $houseRent->where('is_checked = 1'.$where)->count();
            if($house_num){
                $item['house_num'] = $house_num;
                $rentCountPrice[] =$item;
            }
        }
        //$this->assign('rentCountPrice', $rentCountPrice);
        //p($rentCountPrice);die;

        //租房按房间统计
        $house_room_option = array(
            1=>"一室",
            2=>"二室",
            3=>"三室",
            4=>"四室",
            5=>"五室",
            6=>"其他"
        );

        $rentCountRoom = $houseRent->field(array('house_room','count(*)'=>'house_num'))->where('status =1 and borough_id = '.$id)->group('house_room')->having('house_num >=0')->select();

        foreach($rentCountRoom as $key=>$item){
            if($house_room_option[$item['house_room']]){
                $rentCountRoom[$key]['room'] = $item['house_room'];
                $rentCountRoom[$key]['house_room'] = $house_room_option[$item['house_room']];
            }else{
                unset($rentCountRoom[$key]);
            }
        }

        //来源
        $sourcearr=array(
            array('source_id'=>1,'source'=>"经纪人"),
            array('source_id'=>2,'source'=>"个人"),
        );



        //p($rentCountRoom);die;
        //$this->assign('rentCountRoom', $rentCountRoom);
        $arr['houserent']=$houserent;
        $arr['count']=$count;
        $arr['pageno']=$pageno;
        $arr['pre_page']=$pre_page;
        $arr['next_page']=$next_page;
        $arr['page_count']=$page_count;
        $arr['rentCountPrice']=$rentCountPrice;
        $arr['rentCountRoom']=$rentCountRoom;
        $arr['sourcearr']=$sourcearr;
        $this->ajaxReturn($arr);
    }
}