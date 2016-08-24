<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/24
 * Time: 下午2:03
 */
namespace Member\Controller;
use Think\Controller;
class HouseSellController extends CommonController{
    //出售管理
    public function index(){

    }

    //发布出售
    public function addSell(){
        $this->name = 'houseSale';
        //获得保存在cookie中的用户id
        $member_id = getAuthInfo('id');
        //关联查询
        $memberInfo=D('MemberRelation')->getInfo($member_id,'*',true);
        $this->assign('memberInfo',$memberInfo);
        //p($memberInfo);die;
        if($memberInfo['mobile']==""){
            $this->redirect(MODULE_NAME.'/',"请先完善你的资料，以便于购房者能够联系你");
        }
        if($page->memberOpen==2){
            if($memberInfo['status']=="1"){
                $this->redirect(MODULE_NAME.'/Index/index',"您的账户尚未开通");
            }
        }
        if(!$_GET['id']) {
                //取用户的分数
                $scores = getAuthInfo('scores');
                //根据分数来得出可发布的买卖房源
                $sellnum = getNumByScore($scores, C('RANK'), 'sell_num');

                //取用户已发房源
                $where = ' and broker_id = ' . $member_id;
                $where .= " and status =1 ";
                $sellCount = D('houseSellView')->getCount(1, $where);


                //比较房源数量
                if (getAuthInfo('vip') == 1) {
                    if ($page->vip1SaleNum <= $sellCount) {
                        $this->error('你正在出售的房源已经超过了' . $page->vip1SaleNum . '条，请把无效的房源删除后再发布新房源！');
                    }
                } elseif (getAuthInfo('vip') == 2) {
                    if ($page->vip2SaleNum <= $sellCount) {
                        $this->error('你正在出售的房源已经超过了' . $page->vip2SaleNum . '条，请把无效的房源删除后再发布新房源！');
                    }
                } else {
                    if ($sellnum + getAuthInfo('addsale') <= $sellCount) {//addsale是什么
                        $page->back('你正在出售的房源已经超过了' . $sellnum . '条，请把无效的房源下架后再发布新房源！');
                    }
                }
        }

        //房源类型
        $house_type_option =getArray('house_type');
        $this->assign('house_type_option', $house_type_option);
        //装修情况
        $house_fitment_option =getArray('house_fitment');
        $this->assign('house_fitment_option', $house_fitment_option);
        //房屋产权
        $belong_option =getArray('belong');
        $this->assign('belong_option', $belong_option);
        //房源特色
        $house_feature_option =getArrayGrouped('house_feature');
        $this->assign('house_feature_option', $house_feature_option);
        $house_feature_group = array(1=>"小区室内",2=>'地段周边',3=>'其它特色');
        $this->assign('house_feature_group', $house_feature_group);

        //区域，增加小区使用
        $cityarea_option =getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);
        //小区物业类型
        $borough_type_option =getArray('borough_type');
        $this->assign('borough_type_option', $borough_type_option);

        //房龄
        for($i = 1980; $i <= date('Y');$i++){
            $house_age_option[] = $i;
        }
        $this->assign('house_age_option', $house_age_option);

        //朝向
        $house_toward_option =getArray('house_toward');
        $this->assign('house_toward_option', $house_toward_option);

        $picture_num = 0;
        $dataInfo['house_feature'] = array();
        //编辑取数据
        if($_GET['id']){
            $id = intval($_GET['id']);
            $dataInfo=M('housesell')->where(array('id'=>$id))->find();
            //print_rr($dataInfo);
            $dataInfo['house_feature'] = explode(',',$dataInfo['house_feature']);
            array_remove_empty($dataInfo['house_feature'],true);
            //$dataInfo['house_installation'] = explode(',',$dataInfo['house_installation']);
            $dataInfo['house_pic']=M('housesell_pic')->where(array('housesell_id'=>$id))->select();
            $picture_num = count($dataInfo['house_pic']);
        }

        $this->assign('dataInfo', $dataInfo);
        $this->assign('to_url', $_SERVER['HTTP_REFERER']);
        $this->assign('picture_num', $picture_num);


        //p($dataInfo);die;
        $this->display();
    }
}