<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/4
 * Time: 下午12:52
 */
namespace Member\Controller;
use Think\Controller;
class ManageSellController extends CommonController{
    public function refresh(){
        $member_id =getAuthInfo('id');
        $houseSell = D('HouseSellRelation');
        //刷新房源
        $ids = $_POST['ids'];//获得所选中房源的ID

        if (!is_array($ids) || empty($ids)) {
            $this->error('没有选择刷新条目');
        } else {
            array_walk($ids, 'intval');
        }

        foreach ($ids as $id) {
            $houseInfo = $houseSell->where(array('id'=>$id))->find();
            //p($houseInfo);
            if ($houseInfo['refresh'] == 0) {
                $this->error('请不要选择可刷新次数为0的房源');
            }
        }

        try {
            $houseSell->where(array('id'=>array('in',$ids)))->setDec('refresh',1);
            $houseSell->refresh($ids);
            jsurlto('刷新房源成功',U(MODULE_NAME.'/Housesell/index'));
        } catch (Exception $e) {
            $this->error('刷新房源失败');
        }





    }//refresh end


    public function notsell(){//下架

        $member_id =getAuthInfo('id');
        $houseSell = D('HouseSellRelation');
        //下架
        $ids = $_POST['ids'];
        if (!is_array($ids) || empty($ids)) {
            $this->error('没有选择下架条目');
        } else {
            array_walk($ids, 'intval');
        }

        try {
            $houseSell->where(array('id'=>array('in',$ids)))->setField('status',2);
            //更新下架时间
            $houseSell->where(array('id'=>array('in',$ids)))->setField('house_downtime',time());
            //取消推荐
            $houseSell->where(array('id'=>array('in',$ids)))->setField('is_promote',0);
            jsurlto('下架房源成功',U(MODULE_NAME.'/Housesell/index'));
        } catch (Exception $e) {
            $this->error('下架失败');
        }

    }//notsell end

    public function recycle(){//回收站

        $page->$this;
        $member_id =getAuthInfo('id');
        $houseSell = D('HouseSellView');

        $where = ' and broker_id = ' . $member_id;
        $q = $_GET['q'] == '输入房源编号或小区名称' ? "" : trim($_GET['q']);
        //$q='长发';
        if ($q) {
            $borough =D('BoroughView');

            $search_bid = $borough->getFields('id', ' borough_name like \'%' . $q . '%\'');
            //p($search_bid);
            if ($search_bid) {
                $search_bid = implode(',', $search_bid);
                $where .= " and (borough_name like '%" . $q . "%' or house_no like '%" . $q . "%' or borough_id in (" . $search_bid . "))";
            } else {
                $where .= " and (borough_name like '%" . $q . "%' or house_no like '%" . $q . "%')";
            }
        }

        $this->q=$q;
        //这里显示状态为2,3（下架，无效）的房源
        $where .=" and (status = 2 or status = 3)";

        $count=$houseSell->getCount(0, $where);
        $Page = new \Think\Page($count,10);//分页类
        //分页样式
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $show = $Page->show();// 分页显示输出
        $dataList=D('HouseSellRelation')->relation(true)->where('1=1'.$where)->limit($Page->firstRow.','.$Page->listRows)->order('created desc')->select();
        $this->dataList=$dataList;
        $this->pagePanel=$show;


        $this->display();

    }

    /**
     * 重新上架
     */
    public function added(){
        //上架
        $houseSell = D('HouseSellView');
        $id = I('get.id',0,'intval');

        try{
            $houseSell->where(array('id'=>$id))->setField('status',1);
            $this->success("重新上架成功");
        }catch (Exception $e){
            $this->error('上架失败');
        }
    }

    /**
     * 删除
     */
    public function delete(){

        $houseSell = D('HouseSellRelation');

        //刷新房源
        $ids = $_POST['ids'];
        if(!is_array($ids) || empty($ids)){
            $this->error('没有选择删除条目');
        }else{
            array_walk($ids,'intval');
        }

        try{
            $houseSell->deleteSell($ids);
            jsurlto('删除房源成功',U(MODULE_NAME.'/ManageSell/recycle'));
        }catch (Exception $e){
            $this->error('删除房源失败');
        }

    }
}