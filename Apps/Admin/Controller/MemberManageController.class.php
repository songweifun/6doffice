<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/11/28
 * Time: 下午8:50
 */
namespace Admin\Controller;
use Think\Controller;
class MemberManageController extends CommonController{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->cate=CONTROLLER_NAME;
    }

    /**
     * 经纪人列表
     */
    public function index(){
        $this->menu=ACTION_NAME;
        import('Class.Dd',APP_PATH);
        $member=D('Member');
        $where = '1=1 and user_type=1';
        if($_GET['status']){
            $where .= ' and status ='.intval($_GET['status']);
        }
        if($_GET['vip']){
            $where .= ' and vip ='.intval($_GET['vip']);
        }
        if($_GET['isindex']){
            $where .= ' and is_index ='.intval($_GET['isindex']);
        }
        if($_GET['is_open']){
            $where .= ' and is_open ='.intval($_GET['is_open']);
        }
        if($_GET['username']){
            $where .=" and username like '%".trim($_GET['username'])."%'";
        }

        if($_GET['realname']){
            $ids_realname = $member->searchMember('realname',trim($_GET['realname']));
        }
        if($_GET['tel']){
            $ids_tel = $member->searchMember('tel',trim($_GET['tel']));
        }
        if($_GET['email']){
            $where .=" and email like '%".trim($_GET['email'])."%'";
        }
        if($_GET['idcard']){
            $ids_idcard = $member->searchMember('idcard',trim($_GET['idcard']));
        }
        if($_GET['com']){
            $ids_com = $member->searchMember('com',trim($_GET['com']));
        }
        if($_GET['avatar']){
            $ids_avatar = $member->searchMember('avatar',$_GET['avatar']);
        }
        if($_GET['identity']){
            $ids_idcard = $member->searchMember('identity',$_GET['identity']);
        }
        if($_GET['realname'] || $_GET['tel'] || $_GET['email'] || $_GET['idcard'] || $_GET['com'] || $_GET['avatar'] || $_GET['identity'] ){
            $ids = array_merge((array)$ids_realname,(array)$ids_tel,(array)$ids_idcard,(array)$ids_com,(array)$ids_avatar,(array)$ids_idcard);
            $ids = array_unique($ids);
            if($ids){
                $where .=" and id in (".implode(',',$ids).")";
            }else{
                $where .=" and 0";
            }
        }
        $user_type = \Dd::getArray('user_type');

        $Page = new \Think\Page($member->getCount($where), 10);
        $Page->setConfig('header', '共%TOTAL_ROW%条');
        $Page->setConfig('first', '首页');
        $Page->setConfig('last', '共%TOTAL_PAGE%页');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('link', 'indexpagenumb');//pagenumb 会替换成页码
        $Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

        $pageLimit = $Page->firstRow . ',' . $Page->listRows;
        $memberList = $member->getList($pageLimit,'*',$where,'add_time desc');
        foreach ($memberList as $key => $value){
            $memberList[$key]['member_info'] = $member->getMoreInfo($value['id'],1);
        }
        $this->assign('dataList', $memberList);
        $this->assign('pagePanel',$Page->show());//分页条
        $this->display();
    }

    /**
     * 修改名字弹窗
     */
    public function changeName(){

        $this->title =  $this->title.' - 委托信息';

        $member = D('Member');
        $action=I('get.action');

        if($action == 'save'){
            //保存
            //p($_POST);die;
            $id = intval($_POST['id']);
            $_POST = charsetIconv($_POST);
            if($_POST['user_type'] == 1){
                $fieldData = array('realname'=>trim($_POST['realname']));
                $member->updateInfo($id,$fieldData,true,1);
            }else{
                $fieldData = array('first_name'=>trim($_POST['first_name']),'last_name'=>trim($_POST['last_name']));
                $member->updateInfo($id,$fieldData,true,2);
            }
            echo 1;
            exit;
        }else{

            if(!$_GET['id']){
                exit;
            }
            //编辑成交
            $id = intval($_GET['id']);
            $memberInfo = $member->getInfo($id,'*',true);

            $this->assign('dataInfo', $memberInfo);
        }

        $this->display();

    }

    /**
     * 修改密码弹窗
     */
    public function changePw(){

        $member = D('Member');
        $action=I('get.action');

        $this->title =  $this->title.' - 委托信息';
        $id = intval($_GET['id']);
        $datainfo = $member->getInfo($id,'*',false);
        $this->assign('datainfo', $datainfo);
        $this->assign('id', $id);
        if($action == 'update'){

                $id = intval($_POST['id']);
                $passwd = md5($_POST['passwd']);
                $data = array('passwd'=>$passwd);

                if($member->updateInfo($id,$data,false,0)){
                    $this->ajaxReturn(array('status'=>1));

                }else{
                    $this->ajaxReturn(array('status'=>0));
                }

        }

        $this->display();
    }

    /**
     * 修改积分弹窗
     */
    public function changeSc(){
        $member = D('Member');
        $action=I('get.action');
        $this->title =  $this->title.' - 用户积分';
        $id = intval($_GET['id']);
        $datainfo = $member->getInfo($id,'*',false);
        $this->assign('datainfo', $datainfo);
        $this->assign('id', $id);
        if($action == 'update'){

                $id = intval($_POST['id']);
                $scores = intval($_POST['scores']);
            if($member->updateScore($id,$scores)){
                $this->ajaxReturn(array('status'=>1));
            }else{
                $this->ajaxReturn(array('status'=>0));
            }
            exit;
        }
        $this->display();
    }

    /**
     * 修改套餐弹窗
     */
    public function changeVip(){

        $member = D('Member');
        $action=I('get.action');
        $id = intval($_GET['id']);
        $datainfo = $member->getInfo($id,'*',false);
        $this->assign('datainfo', $datainfo);
        $this->assign('id', $id);
        $money = intval($_POST['money']);
        $vip =  intval($_POST['vip']);
        $this->assign('id', $id);

        if($_GET['realname']){
            $ids_realname = $member->searchMember('realname',trim($_GET['realname']));
        }

        if($action == 'save') {
            $_POST['member_id'] = intval($_POST['id']);

            if ($_GET['type'] == 1) {
                $_POST['to_time'] = 2592000 + time();    //30天
            }
            if ($_GET['type'] == 2) {
                $_POST['to_time'] = 7776000 + time();   //90天
            }


            //更改会员标识 并写入时间表
            $member->vipSave($_POST,$_GET['type']);
            $this->ajaxReturn(array('status'=>1));

            exit;
        }

        $this->display();

    }

    /**
     * 充值弹窗
     */
    public function changeMoney(){

        $member = D('Member');
        $action=I('get.action');

        $this->title =  $this->title.' - 用户余额';
        $id = intval($_GET['id']);
        $datainfo = $member->getInfo($id,'*',false);
        $this->assign('datainfo', $datainfo);
        $this->assign('id', $id);
        if($action == 'update'){

                $id = intval($_POST['id']);
                $money = intval($_POST['money']);
                if($member->updatemoney($id,$money)){
                    $this->ajaxReturn(array('status'=>1));


                }else{
                    $this->ajaxReturn(array('status'=>0));

                }

            exit;
        }

        $this->display();

    }

    /**
     * 详细
     */
    public function memberView(){
        $this->menu='index';
        import('Class.Dd',APP_PATH);


        $member = D('Member');
        $id = intval($_GET['id']);
        $userInfo = $member->getInfo($id,'*',true);
        $dd = D('Dd');
        if($userInfo['cityarea_id']){
            $cityarea_arr = \Dd::getArray('cityarea');
            $userInfo['cityarea_id'] = $cityarea_arr[$userInfo['cityarea_id']];
        }
        if($userInfo['broker_type']){
            $broker_type = \Dd::getArray('broker_type');
            $userInfo['broker_type'] = $broker_type[$userInfo['broker_type']];
        }
        $borough = D('Borough');
        if($userInfo['borough_id']){
            $userInfo['borough_id'] = $borough->getInfo($userInfo['borough_id'],'borough_name');
        }
        $this->assign('dataInfo',$userInfo);
        $this->display();

    }
}