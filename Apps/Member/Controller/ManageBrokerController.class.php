<?php
/**
 * 资料管理控制器
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/11
 * Time: 下午7:35
 */
namespace Member\Controller;
use Think\Controller;
class ManageBrokerController extends CommonController{
    /**
     * 修改资料
     */
    public function brokerProfile(){

        $member=D('MemberView');
        $member_id = $member->getAuthInfo('id');


        //区域，增加小区使用
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);

        //经纪人特长
        $specialty_option = getArray('specialty');
        $this->assign('specialty_option', $specialty_option);
        $memberInfo = $member->getInfo($member_id,'*',true);
        //获得公司名称
        if($memberInfo['company_id']){
            $company = M('company');
            $memberInfo['company_name']=$company->where(array('id'=>$memberInfo['company_id']))->getField('company_name');
        }
        $cityarea_option2 =getArray('cityarea2');
        $memberInfo['cityarea2_name']=$cityarea_option2[$memberInfo['cityarea2_id']];

        if($memberInfo['borough_id']){
            $borough = D('BoroughView');
            $memberInfo['borough_name'] = $borough->where(array('id'=>$memberInfo['borough_id']))->getField('borough_name');
        }

        $this->assign('dataInfo',$memberInfo);
        //p($memberInfo);


        $this->display();

    }

}