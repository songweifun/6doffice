<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/14
 * Time: 下午5:40
 */
namespace Common\Model;
use Think\Model;
class DoTimeModel extends Model{
    protected $tableName='dotime';


    /**
     * 小区均价统计  每月统计一次
     */
    public function boroughAvg($borough_avg_time) {
        $result=M('borough')->where(array('isdel'=>0))->select();
        $threeMonthBefore = mktime(0,0,0,date('m')-300,date('d'),date('Y'));//统计近三个月的


        foreach ($result as $rs) {
            $percent_change = 0;
            $avg_price = 0;

            $sum_array=M('housesell')->field(array("sum(house_price/house_totalarea)"=>'sum_p',"count(*)"=>'sum_c'))->where(array('borough_id'=>$rs['id'],'created'=>array('egt',$threeMonthBefore),'house_type'=>array('in',array(1,2,3))))->select();
            //p($sum_array);

            if($sum_array['sum_c']<4){
                continue;
            }
            if($sum_array){
                $avg_price = intval($sum_array['sum_p']*10000/$sum_array['sum_c']);
                if($rs['borough_avgprice']){
                    $percent_change = round(($avg_price-$rs['borough_avgprice'])/$rs['borough_avgprice']*100,2);
                }
                if($percent_change){
                    M('borough')->where(array('id'=>$rs['id']))->save(array('borough_avgprice'=>$avg_price,'percent_change'=>$percent_change,'borough_evaluate'=>$avg_price));
                }else{
                    M('borough')->where(array('id'=>$rs['id']))->save(array('borough_avgprice'=>$avg_price,'borough_evaluate'=>$avg_price));
                }
            }
            //echo $rs['id']."<br/>";

            //记录LOG
            //now
            $now_date = mktime(0,0,0,date('m',time(),date('d',time()),date('Y',time())));
            $borough_avgpriceid=M('borough_avgprice')->where(array('borough_id'=>$rs['id'],'add_time'=>$now_date))->getField('id');
            if($borough_avgpriceid){
                M('borough_avgprice')->where(array('borough_id'=>$rs['id'],'add_time'=>$now_date))->save(array('borough_avgprice'=>$avg_price));
            }else{
                M('borough_avgprice')->save(array('borough_id'=>$rs['id'],'borough_avgprice'=>$avg_price,'percent_change'=>$percent_change,'add_time'=>$now_date));
            }

        }
        $totime = mktime(0,0,0,date('m'),date('d'),date('Y'))+$borough_avg_time;
        //p($borough_avg_time);
        return $this->where(array('id'=>1))->save(array('borough_avg'=>$totime));//每隔borough_avg_time 统计一次
        //return $this->query("update fke_dotime set borough_avg='".$totime."'");//每隔borough_avg_time 统计一次
    }


    /**
     * 小区房源数量统计
     */
    function memberNum($member_num_time) {
        $result=M('member')->where(array('user_type'=>1))->select();

        foreach ($result as $rs) {
            $housesell_num=M('housesell')->where(array('status'=>1,'broker_id'=>$rs['id']))->getField('count(*)');
            $houserent_num=M('housesell')->where(array('status'=>1,'broker_id'=>$rs['id']))->getField('count(*)');
            //p($housesell_num);die;
            M('member')->where(array('id'=>$rs['id']))->save(array('sell_num'=>$housesell_num,'rent_num'=>$houserent_num));
        }

        $totime = mktime(0,0,0,date('m'),date('d'),date('Y'))+$member_num_time;
        return $this->where(array('id'=>1))->save(array('member_num'=>$totime));//$member_num_time 统计一次

    }

    /**
     * 经纪人活跃度统计
     */
    function brokerActiveRate($broker_active_Rate_time) {
        $result=M('member')->where(array('user_type'=>1))->select();
        foreach ($result as $rs) {
            //取得前六天的登陆情况
            $dateNow = mktime(0,0,0,date('m'),date('d'),date('Y'));
            $dateBefore =  $dateNow -518400;
            $loginlog=M('member_loginlog')->field('add_time')->where(array('username'=>$rs['username'],'add_time'=>array('gt',$dateBefore)))->order('add_time asc')->select();
            $active_arr = array_fill(0, 7, 0);
            $activeRate = 0;
            foreach($loginlog as $item){
                for($i=0;$i<=6;$i++){
                    if($dateBefore+$i*86400 == $item ){
                        $activeRate += 1000+pow(2, $i);
                        $active_arr[$i]=1;
                        break;
                    }
                }
            }
            if($active_arr){
                $active_str = implode('|',$active_arr);
            }else{
                $active_str = '';
            }
            $total_loginday=M('member_loginlog')->where(array('username'=>$rs['username']))->getField('count(*)');
            //p($total_loginday);die;
            $registe_day = (time() - $rs['add_time'])/86400;
            $total_rate = $total_loginday / $registe_day;
            M('member')->where(array('id'=>$rs['id']))->save(array('active_str'=>$active_str,'active_rate'=>$activeRate,'active_total'=>$total_rate));
        }
        $totime = mktime(0,0,0,date('m'),date('d'),date('Y'))+$broker_active_Rate_time;
        return $this->where(array('id'=>1))->save(array('broker_active_Rate'=>$totime));//broker_active_Rate 统计一次

    }

    /**
     * 经纪人积分增加统计
     */
    function brokerIntegral($broker_integral_time) {
        $result=M('member')->where(array('user_type'=>1))->select();

        $integral = D('IntegralRule');
        foreach ($result as $rs) {
            //取得昨天的登陆情况
            $dateNow = mktime(0,0,0,date('m'),date('d'),date('Y'));
            $dateNow = $dateNow- 86400;
            //昨天登陆了就加5分
            $haslogin=M('member_loginlog')->field('add_time')->where(array('username'=>$rs['username'],'add_time'=>$dateNow))->select();
            if($haslogin){
                $integral->add($rs['id'],1);
            }




            $last3year = mktime(0,0,0,date('m'),date('d'),date('Y')-3);
            $last2year = mktime(0,0,0,date('m'),date('d'),date('Y')-2);
            $last1year = mktime(0,0,0,date('m'),date('d'),date('Y')-1);

            if($rs['add_time']<$last3year-86400){
                //3年以上
                if(!$integral->getLogByRuleId($rs['id'],4)){
                    $integral->add($rs['id'],4);
                }
            }elseif($rs['add_time']<$last2year-86400){
                //2年以上
                if(!$integral->getLogByRuleId($rs['id'],3)){
                    $integral->add($rs['id'],3);
                }
            }elseif($rs['add_time']<$last1year-86400){
                //1年以上
                if(!$integral->getLogByRuleId($rs['id'],2)){
                    $integral->add($rs['id'],2);
                }
            }
        }
        $totime = mktime(0,0,0,date('m'),date('d'),date('Y'))+$broker_integral_time;
        return $this->where(array('id'=>1))->save(array('broker_integral'=>$totime));//$broker_integral_time 统计一次
    }

    /**
     * 全站数据统计
     */
    function statistics($statistics_time) {
        $borough = M('borough');
        $borough_num = $borough->count();
        M('statistics')->where(array('stat_index'=>'boroughNum'))->save(array('stat_value'=>$borough_num));
        $member = M('member');
        $broker_num = $member->where(array('status'=>0,'user_type'=>1))->count();
        M('statistics')->where(array('stat_index'=>'brokerNum'))->save(array('stat_value'=>$broker_num));
        $houseSell=M('housesell');
        $sumPrice =$houseSell->where('status =1 or status =2')->getField('sum(house_price/house_totalarea)');
        //p($sumPrice);die;

        $housesell_num = $houseSell->where('status =1 or status =2')->count();
        //p($statistics_time);die;
        if($housesell_num){
            $avgPrice = $sumPrice*10000/$housesell_num;
            M('statistics')->where(array('stat_index'=>'avgprice'))->save(array('stat_value'=>$avgPrice));
        }
        $totime = mktime(0,0,0,date('m'),date('d'),date('Y'))+$statistics_time;
        return $this->where(array('id'=>1))->save(array('statistics'=>$totime));//$statistics_time 统计一次
    }

    /**
     * 小区图片数量导入
     */
    function boroughPicNum($borough_pic_num_time) {
        $result=M('borough')->select();
        foreach ($result as $rs) {
            $borough_pic_num=M('borough_pic')->where(array('borough_id'=>$rs['id']))->getField('count(*)');
            $borough_draw_num=M('borough_draw')->where(array('borough_id'=>$rs['id']))->getField('count(*)');
            M('borough')->where(array('id'=>$rs['id']))->save(array('layout_picture'=>$borough_pic_num,'layout_drawing'=>$borough_draw_num));
        }
        $totime = mktime(0,0,0,date('m'),date('d'),date('Y'))+$borough_pic_num_time;
        return $this->where(array('id'=>1))->save(array('borough_pic_num'=>$totime));//$borough_pic_num_time 统计一次
    }

    /**
     * 房源刷新统计脚本执行
     */
    function dorefresh($vip1refresh,$vip2refresh) {
        $today = mktime(0,0,0,date('m'),date('d'),date('Y'));
        $data=$this->where(array('id'=>1))->getField('time');
        $housesell=M('housesell');
        $houserent=M('houserent');
        if($today != $data) {
            $housesell->setField('refresh',2);
            $houserent->setField('refresh',2);
            $member = M('member');
            $vip1MemberId = $member->field('id')->where(array('vip'=>1))->select();
            $vip2MemberId = $member->field('id')->where(array('vip'=>2))->select();
            //p($vip2MemberId);die;


            foreach($vip1MemberId as $key=>$v )
            {
                $housesell->where(array('broker_id'=>$v['id']))->save(array('refresh'=>$vip1refresh));
                $houserent->where(array('broker_id'=>$v['id']))->save(array('refresh'=>$vip1refresh));
            }

            foreach($vip2MemberId as $key=>$v )
            {
                $housesell->where(array('broker_id'=>$v['id']))->save(array('refresh'=>$vip2refresh));
                $houserent->where(array('broker_id'=>$v['id']))->save(array('refresh'=>$vip2refresh));
            }

            return $this->where(array('id'=>1))->save(array('time'=>$today));
        }
    }

    /**
     * 房源过期处理
     */
    function houseInvalid($house_invalid_time) {
        $housesell=M('housesell');
        $houserent=M('houserent');
        $sellIdarr=$housesell->field('id')->where(array('updated'=>array('lt',time()-604800),'status'=>1))->select();
        $rentIdarr=$houserent->field('id')->where(array('updated'=>array('lt',time()-604800),'status'=>1,'broker_id'=>array('neq',0)))->select();
        foreach($sellIdarr as $v){
            $sellId[]=$v['id'];
        }
        foreach($rentIdarr as $v){
            $rentId[]=$v['id'];
        }
        //p($rentId);die;
        if($sellId){//如果有超过7天未刷新房源 进行下架处理
            $housesell->where(array('id'=>array('in',$sellId)))->save(array('house_downtime'=>time(),'status'=>2));

        }
        if($rentId){//如果有超过7天未刷新房源 进行下架处理
            $houserent->where(array('id'=>array('in',$sellId)))->save(array('house_downtime'=>time(),'status'=>2));

        }

        //删除发布90天以上的房源包含个人发布
        $deleteSellIdarr = $housesell->field('id')->where(array('created'=>array('lt',time()-7776000)))->select();

        $deleteRentIdarr = $houserent->field('id')->where(array('created'=>array('lt',time()-7776000)))->select();
        foreach($deleteSellIdarr as $v){
            $deleteSellId[]=$v['id'];
        }
        foreach($deleteRentIdarr as $v){
            $deleteRentId[]=$v['id'];
        }
        if($deleteSellId){//如果有90天以上的房源 进行删除处理
            D('HouseSellRelation')->deleteSell($deleteSellId);
        }
        if($deleteRentId){//如果有90天以上的房源 进行删除处理
            D('HouseRentRelation')->deleteRent($deleteRentId);
        }

        $totime = mktime(0,0,0,date('m'),date('d'),date('Y'))+$house_invalid_time;
        return $this->where(array('id'=>1))->save(array('houseInvalid'=>$totime));



    }
}