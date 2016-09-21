<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/21
 * Time: 下午6:48
 */
namespace Company\Controller;
use Think\Controller;
class IndexController extends CommonController{

    public function index(){

        $company = D('company');
        $company_id = $company->getAuthInfo('id');
        $this->assign('company_id',$company_id);
        $companyInfo = $company->where(array('id'=>$company_id))->find();
        $this->assign('companyInfo',$companyInfo);
        //$this->assign('msgCount',$newMsgCount);
        
        $nowHour = date('H');
        if($nowHour > 17 || $nowHour < 6){
            $nowTime = "晚上";
        }elseif($nowHour > 12){
            $nowTime = "下午";
        }else{
            $nowTime = "早上";
        }
        $this->assign('nowTime',$nowTime);

        $houseSell = M('housesell');
        $houseRent = M('houserent');
        $where = ' and company_id = '.$company_id;
        $where .=" and status = 1 and is_top = 0";
        $saleCount = $houseSell->where('1=1'.$where)->count();
        $this->assign('saleCount', $saleCount);

        $where .=" and is_top = 1 and status = 1";
        $saleTopCount = $houseSell->where('1=1'.$where)->count();
        $this->assign('saleTopCount', $saleTopCount);


        $where .=" and is_top = 1 and status = 1";
        $rentTopCount = $houseRent->where('1=1'.$where)->count();
        $this->assign('rentTopCount', $rentTopCount);

        $where .=" and status = 2";
        $saleRecycleCount = $houseSell->where('1=1'.$where)->count();
        $this->assign('saleRecycleCount', $saleRecycleCount);


        $where .=" and status = 1 and is_top = 0";
        $rentCount = $houseRent->where('1=1'.$where)->count();
        $this->assign('rentCount', $rentCount);

        $where .=" and status = 2";
        $rentRecycleCount = $houseRent->where('1=1'.$where)->count();
        $this->assign('rentRecycleCount', $rentRecycleCount);
        $this->display();
    }
}