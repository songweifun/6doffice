<?php
namespace Member\Controller;
use Think\Controller;
class IndexController extends CommonController{
    public function index(){


        $this->name='index';
        $this->title=C('BASE.base_title');



        $nowHour = date('H');
        if($nowHour > 17 || $nowHour < 6){
            $this->nowTime = "晚上";
        }elseif($nowHour > 12){
            $this->nowTime = "下午";
        }else{
            $this->nowTime = "早上";
        }
        //获得保存在cookie中的用户id
        $member_id = getAuthInfo('id');
        //关联查询
        $memberInfo=D('MemberRelation')->getInfo($member_id,'*',true);
        //计算等级
        $memberInfo['brokerRank']=getNumByScore($memberInfo['scores'],C('RANK'),'pic');
        //最近7天的活动状况拆分为数组
        $memberInfo['active_str'] = explode('|',$memberInfo['active_str']);
        //获得专长
        $memberInfo['specialty'] =getCaption('specialty',$memberInfo['specialty']);
        $this->memberInfo=$memberInfo;
        //p($memberInfo);die();
        //会员到期时间
        $vip_totime_arr=M('member_vip')->field('to_time')->where(array('member_id'=>$member_id))->find();
        $this->vip_totime=$vip_totime_arr['to_time'];
        //好友邀请数量
        $this->firendInviteCount=M('broker_friends')->where(array('status'=>0,'friend_id'=>$member_id))->count();
        //获得出售房源数
        $where = ' and broker_id = '.$member_id;
        $where .=" and status = 1 and is_top = 0";
        $this->saleCount = D('HouseSellView')->getCount(0,$where);
        //买卖置顶
        $where = ' and broker_id = '.$member_id;
        $where .=" and is_top = 1 and status = 1";
        $this->saleTopCount = D('HouseSellView')->getCount(0,$where);
        //出售回收站
        $where = ' and broker_id = '.$member_id;
        $where .=" and status = 2";
        $this->saleRecycleCount=D('HouseSellView')->getCount(0,$where);
        //获得出租房源数
        $where = ' and broker_id = '.$member_id;
        $where .=" and status = 1 and is_top = 0";
        $this->rentCount = D('HouseRentView')->getCount(0,$where);
        //出租置顶
        $where = ' and broker_id = '.$member_id;
        $where .=" and is_top = 1 and status = 1";
        $this->rentTopCount=D('HouseRentView')->getCount(0,$where);
        //出租回收站
        $where = ' and broker_id = '.$member_id;
        $where .=" and status = 2";
        $this->rentRecycleCount=D('HouseRentView')->getCount(0,$where);
        //p($this);die;

        //p($this->vip_totime);die;




        $this->display();
    }
}