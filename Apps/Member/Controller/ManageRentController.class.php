<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/9
 * Time: 下午11:06
 */
namespace Member\Controller;
use Think\Controller;
class ManageRentController extends CommonController{//出租管理控制器
    /**
     *刷新
     */
    public function refresh()
    {
        $member=D('MemberView');
        $member_id = $member->getAuthInfo('id');
        $houseRent = D('HouseRentRelation');
        //刷新房源
        $ids = $_POST['ids'];//获得所选中房源的ID

        if (!is_array($ids) || empty($ids)) {
            $this->error('没有选择刷新条目');
        } else {
            array_walk($ids, 'intval');
        }

        foreach ($ids as $id) {
            $houseInfo = $houseRent->where(array('id' => $id))->find();
            //p($houseInfo);
            if ($houseInfo['refresh'] == 0) {
                $this->error('请不要选择可刷新次数为0的房源');
            }
        }

        try {
            $houseRent->where(array('id' => array('in', $ids)))->setDec('refresh', 1);
            $houseRent->refresh($ids);
            jsurlto('刷新房源成功', U(MODULE_NAME . '/HouseRent/index'));
        } catch (Exception $e) {
            $this->error('刷新房源失败');
        }
    }
    /**
     * 下架
     */
    public function notrent(){//下架
        $member=D('MemberView');
        $member_id =$member->getAuthInfo('id');
        $houseRent = D('HouseRentRelation');
        //下架
        $ids = $_POST['ids'];
        if (!is_array($ids) || empty($ids)) {
            $this->error('没有选择下架条目');
        } else {
            array_walk($ids, 'intval');
        }

        try {
            $houseRent->where(array('id'=>array('in',$ids)))->setField('status',2);
            //更新下架时间
            $houseRent->where(array('id'=>array('in',$ids)))->setField('house_downtime',time());
            //取消推荐
            $houseRent->where(array('id'=>array('in',$ids)))->setField('is_promote',0);
            jsurlto('下架房源成功',U(MODULE_NAME.'/Houserent/index'));
        } catch (Exception $e) {
            $this->error('下架失败');
        }

    }//notsell end

    /**
     * 回收站
     */
    public function recycle(){//回收站

        $page->$this;
        $member=D('MemberView');
        $member_id =$member->getAuthInfo('id');
        $houseRent = D('HouseRentView');

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

        $count=$houseRent->getCount(0, $where);
        $Page = new \Think\Page($count,10);//分页类
        //分页样式
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $show = $Page->show();// 分页显示输出
        $dataList=D('HouseRentRelation')->relation(true)->where('1=1'.$where)->limit($Page->firstRow.','.$Page->listRows)->order('created desc')->select();
        $this->dataList=$dataList;
        $this->pagePanel=$show;


        $this->display();

    }

    /**
     * 重新上架
     */
    public function added(){
        //上架
        $houseRent = D('HouseRentView');
        $id = I('get.id',0,'intval');

        try{
            $houseRent->where(array('id'=>$id))->setField('status',1);
            $this->success("重新上架成功");
        }catch (Exception $e){
            $this->error('上架失败');
        }
    }

    /**
     * 彻底删除
     */
    public function delete(){

        $houseRent = D('HouseRentRelation');

        //刷新房源
        $ids = $_POST['ids'];
        if(!is_array($ids) || empty($ids)){
            $this->error('没有选择删除条目');
        }else{
            array_walk($ids,'intval');
        }

        try{
            $houseRent->deleteRent($ids);
            jsurlto('删除房源成功',U(MODULE_NAME.'/ManageRent/recycle'));
        }catch (Exception $e){
            $this->error('删除房源失败');
        }

    }

    /***
     * 成交
     */
    public function rentBargain(){
        $page->$this;

        $houseRent = D('HouseRentRelation');
        $RentBargain = M('houserent_bargain');

        //成交
        $page->name = 'saleBargain';
        if(!$_GET['id']){
            //增加成交
            $house_id = I('get.house_id',0,'intval');
            if($house_id){
                $dataInfo=$houseRent->where(array('id'=>$house_id))->field('borough_name,house_totalarea,house_price')->find();
            }
        }else{
            //编辑成交
            $id = I('get.id',0,'intval');
            $dataInfo = $RentBargain->where(array('id'=>$id))->find();
            $house_id = $dataInfo['house_id'];
        }
        $this->assign('house_id', $house_id);
        $this->assign('dataInfo', $dataInfo);
        //字典
        $bargain_from_option =getArray('bargain_from');
        //p($bargain_from_option);die;
        $this->assign('bargain_from_option', $bargain_from_option);

        $this->display();
    }

    /**
     * ajax保存成交
     */

    public function ajaxSaveBargain(){
        if(!IS_AJAX) $this->error('非法访问');
        $member=D('MemberView');
        $member_id =$member->getAuthInfo('id');
        $id=I('post.id',0,'intval');
        $house_id=I('house_id',0,'intval');
        $broker_id=$member_id;
        $RentBargain = M('houserent_bargain');
        if($id){//存在为编辑

            $updateField = array(
                'borough_name'=>I('borough_name'),
                'house_totalarea'=>I('house_totalarea',0,'intval'),
                'house_price'=>I('house_price',0,'intval'),
                'bargain_from'=>I('bargain_from',0,'intval'),
                'buyer'=>I('buyer'),
                'buyer_tel'=>I('buyer_tel'),
                'saler'=>I('saler'),
                'saler_tel'=>I('saler_tel'),
                'bargain_price'=>I('bargain_price',0,'intval'),
            );
            $bargain_id=$RentBargain->where(array('id'=>$id))->save($updateField);

        }else{

            import('Class.myDate',APP_PATH);

            $insertField = array(
                'house_id' =>$house_id,
                'broker_id' =>$broker_id,
                'borough_name'=>I('borough_name'),
                'house_totalarea'=>I('house_totalarea',0,'intval'),
                'house_price'=>I('house_price',0,'intval'),
                'bargain_from'=>I('bargain_from',0,'intval'),
                'buyer'=>I('buyer'),
                'buyer_tel'=>I('buyer_tel'),
                'saler'=>I('saler'),
                'saler_tel'=>I('saler_tel'),
                'bargain_price'=>I('bargain_price',0,'intval'),
                'bargain_time'=>\MyDate::transform('timestamp',I('bargain_time')),
                'add_time'=>time()
            );
            //p($insertField);die;
            $bargain_id=$RentBargain->add($insertField);

        }
        if($bargain_id){
            //修改房源的状态
            $house = D('HouseRentRelation');
            $house->where(array('id'=>$house_id))->setField('status',4);
            //echo $bargain_id;
            $this->ajaxReturn(array('status'=>true));
        }else{
            $this->ajaxReturn(array('status'=>false));
        }

    }

    /**
     * 成交榜
     */
    public function rentDone(){
        $page=$this;
        $member=D('MemberView');
        $member_id =$member->getAuthInfo('id');
        $RentBargain = M('houserent_bargain');
        //字典
        $bargain_from_option =getArray('bargain_from');
        $this->assign('bargain_from_option', $bargain_from_option);
        $where = ' broker_id = '.$member_id;
        import('Class.myDate',APP_PATH);
        //搜索
        if($_GET['from_date']){
            $from_date = \MyDate::transform('timestamp',$_GET['from_date']);
            $where .= ' and bargain_time >= '.$from_date;
        }

        if($_GET['to_date']){
            $to_date = \MyDate::transform('timestamp',$_GET['to_date']);
            $where .= ' and bargain_time <= '.$to_date;
        }

        if($_GET['bargain_from']){
            $where .= ' and bargain_from = '.intval($_GET['bargain_from']);
        }

        $q = $_GET['q'] =="输入小区名，或买/卖方信息，或备注信息"?"":$_GET['q'];

        if($q){
            $where .= " and (borough_name like '%".$q
                ."%' or buyer like '%".$q
                ."%' or buyer_tel like '%".$q
                ."%' or saler like '%".$q
                ."%' or saler_tel like '%".$q
                ."%' or remark like '%".$q."%')";
        }

        $this->assign('q', $q);

        $count=$RentBargain->where($where)->count();
        $Page = new \Think\Page($count,10);//分页类
        //分页样式
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $show = $Page->show();// 分页显示输出
        $dataList=$RentBargain->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('add_time desc')->select();
        foreach($dataList as $key => $item){
            $dataList[$key]['bargain_from']=$bargain_from_option[$item['bargain_from']];
        }
        //p($dataList);die;
        $this->dataList=$dataList;
        $this->pagePanel=$show;


        $this->display();

    }

    /**
     * 备注
     */
    public function remark(){
        $rentBargain = M('houserent_bargain');
        $id = I('get.id',0,'intval');
        if(!$id){
            exit;
        }
        $dataInfo = $rentBargain->where(array('id'=>$id))->find();
        $this->assign('dataInfo', $dataInfo);
        $this->display();
    }

    /**
     * ajax添加备注
     */
    public function ajaxSaveBargainRemark(){

        if(!IS_AJAX) $this->error('非法访问');
        $rentBargain = M('houserent_bargain');
        $id=I('id',0,'intval');
        $remark=I('remark');
        if($rentBargain->where(array('id'=>$id))->setField('remark',$remark)){
            $this->ajaxReturn(array('status'=>true));
        }else{
            $this->ajaxReturn(array('status'=>false));
        }


    }

    /**
     * 置顶
     */
    public  function rentTop(){
        $page=$this;
        $member=D('MemberView');
        $money =$member->getAuthInfo('money');
        $house_id = I('house_id',0,'intval');
        $this->assign('house_id', $house_id);
        $this->assign('money', $money);
        $this->display();

    }

    /**
     * 异步保存置顶
     */
    public function ajaxSaveRentTop(){

        $page=$this;


        $houserent = D('HouseRentRelation');
        $member=D('MemberRelation');



        $days=I('days',0,'intval');
        $house_id=I('house_id',0,'intval');
        $member_id = getAuthInfo('id');  //获取会员ID
        //计算余额是否够用
        $price = $days*$page->rentPrice;
        $memberInfo = $member->getInfo($member_id,'*',true);

        $to_time = $days*86400+time();
        if(!$days){
            $this->ajaxReturn(array('status'=>false,"msg"=>'请输入置顶天数'));
        }
        if($memberInfo['money'] >= $price){
            //扣除费用
            $member->where(array('id'=>$member_id))->save(array('money'=>$memberInfo['money']-$price));
            //更改出售房源状态
            $houserent->where(array('id'=>$house_id))->setField('is_top',1);
            $data=array(

                'member_id'=>$member_id,
                'houserent_id'=>$house_id,
                'add_time'=>time(),
                'to_time'=>$to_time,

            );
            M('houserent_top')->add($data);
            $this->ajaxReturn(array('status'=>true,"msg"=>'置顶成功!'));
        }else{
            $this->ajaxReturn(array('status'=>false,"msg"=>'余额不足，请充值！'));
        }

    }

    /**
     * 置顶中
     */
    public function RentTopDone(){
        $page=$this;

        $member_id = getAuthInfo('id');
        $houseRent = D('HouseRentView');
        $action=I('action');
        if($action=='noTop'){
            $to_url = $_SERVER['HTTP_REFERER'];
            $id=I('id',0,'intval');
            try{
                $houseRent->where(array('id'=>$id))->setField('is_top',0);
                jsurlto('取消置顶成功！',$to_url);
            }catch (Exception $e){
                $this->error('取消置顶失败');
            }
            exit;

        }else{

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
            $where .=" and is_top = 1 and status = 1";
            $count=$houseRent->getCount(0, $where);
            $Page = new \Think\Page($count,10);//分页类
            //分页样式
            $Page->setConfig('prev','上一页');
            $Page->setConfig('next','下一页');
            $show = $Page->show();// 分页显示输出
            $dataList=D('HouseRentRelation')->relation(true)->where('1=1'.$where)->limit($Page->firstRow.','.$Page->listRows)->order('created desc')->select();
            foreach ($dataList as $key => $value){
                $dataList[$key]['to_time']=M('houserent_top')->where(array('houserent_id'=>$value['id']))->getField('to_time');
            }
            $this->dataList=$dataList;
            $this->pagePanel=$show;

        }

        $this->display();


    }

    /**
     * 房东
     */
    public function landlordInfo(){
        $page=$this;
        $house_id=I('house_id',0,'intval');
        $houserent = D('HouseRentView');
        $houseInfo=$houserent->where(array('id'=>$house_id))->find();
        $this->assign('houseInfo', $houseInfo);
        $this->display();
    }

    /**
     * 购买条数
     */

    public function buyRentNum(){
        $page=$this;
        if(IS_AJAX){
            $member=D('MemberRelation');
            $member_id = getAuthInfo('id');  //获取会员ID
            $num=I('num',0,'intval');
            //计算余额是否够用
            $price = $num*$page->rentPrice;
            $memberInfo = $member->getInfo($member_id,'*',true);
            if(!$num){
                $this->ajaxReturn(array('status'=>false,"msg"=>'请输入购买条数'));
            }

            if($memberInfo['money'] >= $price){
                //扣除费用
                $member->where(array('id'=>$member_id))->save(array('money'=>$memberInfo['money']-$price));
                //增加出售条数
                $member->where(array('id'=>$member_id))->save(array('addsale'=>$memberInfo['addsale']+$num));

                $this->ajaxReturn(array('status'=>true,"msg"=>'购买成功!'));
            }else{
                $this->ajaxReturn(array('status'=>false,"msg"=>'余额不足，请充值！'));
            }

        }else{

            $money = getAuthInfo('money');
            $this->assign('money', $money);
            $this->display();

        }

    }


}