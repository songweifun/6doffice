<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/19
 * Time: 上午8:07
 */
namespace Home\Controller;
use Think\Controller;
class BrokerController extends CommonController{
    public function index(){
        $this->title = $this->city.'经纪人 - '.$this->titlec;   //网站名称

        //区域字典
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);

        $specialty_option = getArray('specialty');
        $this->assign('specialty_option', $specialty_option);

        $where =' status=0 and user_type = 1 ';
        //cityarea
        $cityarea = intval($_GET['cityarea']);
        if($cityarea){
            $where .= ' and cityarea_id = '.$cityarea;
        }

        //specialty
        $specialty = intval($_GET['specialty']);
        if($specialty){
            $where .= ' and specialty = '.$specialty;
        }
        $dd = D('DdItem');
        $borough_section=$dd->getSonList($cityarea);
        $this->assign('borough_section',$borough_section);
        //cityarea2
        $cityarea2 = intval($_GET['cityarea2']);
        if($cityarea2){
            $where .= ' and cityarea2_id = '.$cityarea2;
            $this->title = $cityarea_option[$cityarea]." - ".$this->title;
        }
        //company_id
        $company = M('company');
        $company_id = intval($_GET['company_id']);
        if($company_id){
            $companyName = $company->where(array('id'=>$company_id))->getField('company_name');
            $this->assign('companyName',$companyName);
            $where .= ' and company_id = '.$company_id;
            $this->title = $companyName."的团队精英 - ".$this->title;
        }


        //认证
        $identity = intval($_GET['identity']);

        if($identity==''){
            $where .= " and mobile <>'' ";
        }
        if($identity==1){
            $where .= " and idcard <>'' ";
        }
        if($identity==2){
            $where .= " and aptitude <>'' ";
        }

        //q
        $q = $_GET['q']=="可输入经纪人名、门店名，或公司名称关键词" ? "":trim($_GET['q']);
        if($q){
            // 可输入经纪人名、门店名，或公司名称关键词
            $where.=" and ( outlet like '%".$q."%' or realname like '%".$q."%' or company like '%".$q."%' )" ;
        }
        //list_order 排序转换
        switch ($_GET['list_order']){
            case "active_rate desc":
                $list_order = " active_rate desc, active_total desc";
                break;
            case "sell_num desc":
                $list_order = " sell_num+rent_num desc";
                break;
            case "scores desc":
                $list_order = " scores desc";
                break;
            case "add_time desc":
                $list_order = " add_time desc";
                break;
            default:
                $list_order = " active_rate desc , active_total desc";
                break;
        }
        //list_num
        $list_num = intval($_GET['list_num']);
        if(!$list_num){
            $list_num = 10;
        }
        $member=D('MemberView');
        $row_count = $member->where("1=1 and".$where)->count();
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

        $dataList =$member->where('1=1 and'.$where)->order($list_order)->limit($Page->firstRow.','.$Page->listRows)-> select();
        //积分配置文件
        $integral_array = C('RANK');
        $houseSell = M('housesell');
        $houseRent = M('houserent');

        foreach ($dataList as $key=> $item){
            //区域
            $dataList[$key]['cityarea_name'] = getCaption('cityarea',$item['cityarea_id']);

            if($item['company_id']){
                $dataList[$key]['company_name'] = $company->where(array('id'=>$item['company_id']))->getField('company_name');
            }
            //积分图片
            $where_house = " and status=1 and broker_id = ".$item['id'];
            $dataList[$key]['brokerRank'] = getNumByScore($item['scores'],$integral_array,'pic');
            $dataList[$key]['active_str'] = explode('|',$item['active_str']);
            $dataList[$key]['last_login'] = time2Units(time()-$item['last_login']);
            if($item['rent_num'] >= 2 && $item['sell_num'] >= 2){
                //都是够数
                $sellList = $houseSell->where("1=1 and (is_checked = 0 or is_checked = 1 )".$where_house)->order('created desc')->limit(2)->select();
                $rentList = $houseRent->where("1=1 and (is_checked = 0 or is_checked = 1 )".$where_house)->order('created desc')->limit(2)->select();
            }elseif($item['rent_num'] < 2 && $item['sell_num'] > 2){
                //租房不够
                $getSellNum = 2-$item['rent_num']+1;
                $sellList = $houseSell->where("1=1 and (is_checked = 0 or is_checked = 1 )".$where_house)->order('created desc')->limit($getSellNum+1)->select();
                $rentList = $houseRent->where("1=1 and (is_checked = 0 or is_checked = 1 )".$where_house)->order('created desc')->limit(2)->select();
                for ($i = 2 ;$i<=count($sellList); $i++){
                    $sellList[$i]['is_sell']=1;
                    $rentList[] = $sellList[$i];
                    unset($sellList[$i]);
                }
            }elseif($item['rent_num'] > 2 && $item['sell_num'] < 2){
                //售房不够
                $getRentNum = 2-$item['sell_num']+1;
                $sellList = $houseSell->where("1=1 and (is_checked = 0 or is_checked = 1 )".$where_house)->order('created desc')->limit(2)->select();
                $rentList = $houseRent->where("1=1 and (is_checked = 0 or is_checked = 1 )".$where_house)->order('created desc')->limit($getRentNum+1)->select();
                for ($i = 2 ;$i<=count($rentList); $i++){
                    $rentList[$i]['is_rent']=1;
                    $sellList[] = $rentList[$i];
                    unset($rentList[$i]);
                }
            }else{
                //都不够
                $sellList = $houseSell->where("1=1 and (is_checked = 0 or is_checked = 1 )".$where_house)->order('created desc')->limit(2)->select();
                $rentList = $houseRent->where("1=1 and (is_checked = 0 or is_checked = 1 )".$where_house)->order('created desc')->limit(2)->select();
            }
            foreach ($sellList as $skey=>$sitem){
                $sellList[$skey]['house_title'] = substrs($sitem['house_title'],46 );
            }
            foreach ($rentList as $rkey=>$ritem){
                $rentList[$rkey]['house_title'] = substrs($ritem['house_title'],46 );
            }
            $dataList[$key]['sell_list'] = $sellList;
            $dataList[$key]['rent_list'] = $rentList;
        }

        $this->assign('dataList', $dataList);
        $this->assign('pagePanel', $Page->show('5'));//分页条
        $arrRecommendBroker=$member->where('status=0 and user_type = 1')->order('sell_num+rent_num desc')->limit(10)->select();

        foreach ($arrRecommendBroker as $key=> $item){
            //积分图片
            $arrRecommendBroker[$key]['brokerRank'] = getNumByScore($item['scores'],$integral_array,'pic');
            $arrRecommendBroker[$key]['active_str'] = explode('|',$item['active_str']);
        }
        $this->assign('arrRecommendBroker', $arrRecommendBroker);
        $this->assign('menu', 'broker');


        $this->display();
    }
}