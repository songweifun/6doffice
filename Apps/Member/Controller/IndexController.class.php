<?php
namespace Member\Controller;
use Think\Controller;
class IndexController extends CommonController{
    public function index(){
        $this->name='index';
        $this->title=C('BASE.base_title');
        $this->username = $_COOKIE['AUTH_MEMBER_REALNAME'] ? $_COOKIE['AUTH_MEMBER_REALNAME'] :$_COOKIE['AUTH_MEMBER_NAME'];
        $this->member_id =getAuthInfo('id');
        //未读邮件
        $newMsgCount = 0;
        if($_COOKIE['AUTH_MEMBER_NAME']){
            $newMsgCount=M('innernote')->where(array('to_del'=>0,'is_new'=>1,'msg_to'=>$_COOKIE['AUTH_MEMBER_NAME']))->count();
        }
        $this->msgCount=$newMsgCount;

        $_SESSION["file_info"] = array();
        $this->assign('session_id', session_id());


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

        //p($this->vip_totime);die;




        $this->display();
    }
}