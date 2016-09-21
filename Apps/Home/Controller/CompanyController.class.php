<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/19
 * Time: 下午10:43
 */
namespace Home\Controller;
use Think\Controller;
class CompanyController extends CommonController{
    public function index(){

        $this->title = $this->city.'公司 - '.$this->titlec;   //网站名称

        //区域字典
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);

        $where ='';
        //cityarea
        $cityarea = intval($_GET['cityarea']);
        if($cityarea){
            $where .= ' and b.cityarea_id = '.$cityarea;
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

        //选择标签
        $switch = $_GET['switch'];
        if($switch == ""){
            $where .= " and type = 0 ";
            $this->title = "中介公司 - ".$this->title;
        }
        if($switch == "move"){
            $where .= " and type = 1 ";
            $this->title = "搬家公司 - ".$this->title;
        }
        if($switch == "decoration"){
            $where .=" and type =2";
            $this->title = "装修公司 - ".$this->title;
        }

        //q
        $q = $_GET['q']=="可输入经纪人名、门店名，或公司名称关键词" ? "":trim($_GET['q']);
        if($q){
            // 可输入经纪人名、门店名，或公司名称关键词
            $where.=" and company_name like '%".$q."%'" ;
        }

        //list_num
        $list_num = intval($_GET['list_num']);
        if(!$list_num){
            $list_num = 10;
        }

        $company = M('company');
        $row_count = $company->where('1=1'.$where)->count();
        //p($row_count);
        $Page= new \Think\Page($row_count,$list_num);// 实例化分页类 传入总记录数和每页显示的记录数(10)


        //page
        $page_count=ceil($row_count/$list_num)>1?ceil($row_count/$list_num):1;
        $pageno = $_GET['p']?intval($_GET['p']):1;
        $pre_page = $pageno>1?$pageno-1:1;
        $next_page = $pageno<$page_count?$pageno+1:$page_count;
        $this->assign('pageno', $pageno);
        $this->assign('row_count', $row_count);
        $this->assign('page_count',$page_count);
        $this->assign('pre_page', $pre_page);
        $this->assign('next_page',$next_page);
        $dataList =$company->where('1=1'.$where)->order($list_order)->limit($Page->firstRow.','.$Page->listRows)-> select();
        $member = D('MemberView');
        //查询经纪人数量
        foreach ($dataList as $key=> $item){
            $dataList[$key]['brokerCount'] = $member->where(array('company_id'=>$item['id']))->count();
        }
        $this->assign('dataList', $dataList);

        //推荐的中介公司
        $commendDataList = $company->where('status=1 and type=0')->order($list_order)->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('commendDataList', $commendDataList);

        $this->assign('pagePanel', $Page->show());//分页条


        $this->menu='company';
        $this->display();
    }

    /**
     * 加入公司
     */
    public function join(){
        $company = M('company');
        $companyId = $_GET['company_id'];
        $dataInfo = $company->where(array('id'=>$companyId))->find();
        $this->assign('dataInfo',$dataInfo);
        $action=I('get.action');
        $realname = $_COOKIE['AUTH_MEMBER_REALNAME'] ? $_COOKIE['AUTH_MEMBER_REALNAME'] :$_COOKIE['AUTH_MEMBER_NAME'];

        if($action=='join'){
            $member=D('MemberView');
        //判断经纪人是否登录
            if($realname){
                $memberId = $member->getAuthInfo('id');
                $memberCompanyId = $member->getAuthInfo('company_id');
                //经纪人已经登录

                if($companyId==$memberCompanyId){
                    //jsurlto('您已经是该公司经纪人',U(MODULE_NAME.'/Company/index'));
                    $this->ajaxReturn(array('status'=>false,'msg'=>'您已经是该公司经纪人'));

                }

                try{
                    //更新经纪人所属公司
                    $member->where(array('id'=>$memberId))->save(array('company_id'=>$companyId));
                    //jsurlto('加入成功',U(MODULE_NAME.'/cshop/index',array('id'=>$companyId)));
                    $this->ajaxReturn(array('status'=>true,'msg'=>'加入成功'));
                }catch (Exception $e){
                    $this->ajaxReturn(array('status'=>false,'msg'=>'加入失败'));

                }

            }else{
                //经纪人未登录
                //jsurlto('您还未登录，无法加入',U('Member/Login/index'));
                $this->ajaxReturn(array('status'=>false,'msg'=>'您还未登录，无法加入'));
            }
        }
        $this->display();
    }

    public function login(){
        $this->display();
    }
}