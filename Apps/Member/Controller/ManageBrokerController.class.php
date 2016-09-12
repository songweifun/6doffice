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

        $member=D('MemberView');//视图模型用于查找
        $member_id = $member->getAuthInfo('id');
        $action=I('get.action');
        if($action=='save'){

            //p($_POST);die;

            $member=D('MemberRelation');//关联模型用于更新插入

            $borough_name=I('post.borough_name');
            $borough_id=M('borough')->where(array('borough_name'=>$borough_name))->getField('id');
            if(!$borough_id) $this->error('您所选择的居中小区不存在');
            $id=I('id',0,'intval');
            try {
                if (M('broker_info')->where(array('id' => $id))->getField('id')) {

                    //update
                    $updateField = array(
                        //'id'=>$id,
                        'email' => I('email'),
                        'broker_info' => array(
                            //'id'=>$id,
                            'cityarea_id' => I('cityarea_id', 0, 'intval'),
                            'cityarea2_id' => I('cityarea2_id', 0, 'intval'),
                            'mobile' => I('mobile'),
                            'signed' => I('signed'),
                            'company' => I('company'),
                            'outlet' => I('outlet_first') . '-' . I('outlet_last'),
                            'outlet_addr' => I('outlet_addr'),
                            'com_tell' => I('com_tell'),
                            'com_fax' => I('com_fax'),
                            'gender' => I('gender', 0, 'intval'),
                            'birthday' => I('birthday'),
                            'borough_id' => $borough_id,
                            'qq' => I('qq'),
                            'msn' => I('msn'),
                            'specialty' => I('specialty'),
                            'introduce' => I('introduce'),
                            'broker_type' => I('broker_type', 0, 'intval'),
                        )
                    );
                    $member->relation(true)->where(array('id' => $id))->save($updateField);
                    //p($updateField);die;
                    //$this->db->update($this->tNameBrokerInfo,$updateField,'id='.$memberInfo['id']);
                } else {
                    $insertField = array(
                        'id' => $id,
                        'cityarea_id' => I('cityarea_id', 0, 'intval'),
                        'cityarea2_id' => I('cityarea2_id', 0, 'intval'),
                        'mobile' => I('mobile'),
                        'signed' => I('signed'),
                        'company' => I('company'),
                        'outlet' => I('outlet_first') . '-' . I('outlet_last'),
                        'outlet_addr' => I('outlet_addr'),
                        'com_tell' => I('com_tell'),
                        'com_fax' => I('com_fax'),
                        'gender' => I('gender', 0, 'intval'),
                        'birthday' => I('birthday'),
                        'borough_id' => $borough_id,
                        'qq' => I('qq'),
                        'msn' => I('msn'),
                        'specialty' => I('specialty'),
                        'introduce' => I('introduce'),
                        'broker_type' => I('broker_type', 0, 'intval'),
                    );
                    $member->where(array('id' => $id))->setField('email', I('email'));
                    M('broker_info')->save($insertField);
                }
                jsurlto('修改成功', U(MODULE_NAME . '/ManageBroker/brokerProfile'));
            }catch (Exception $e){
                $this->error('保存出错了');
            }


        }else{//模板显示
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
                //echo $memberInfo['borough_name'];
            }

            $this->assign('dataInfo',$memberInfo);
            //p($memberInfo);
        }


        $this->display();

    }

    /**
     * 实名认证
     */
    public function brokerIdentity(){

        $member=D('MemberView');//视图模型用于查找
        $member_id = $member->getAuthInfo('id');
        $action=I('get.action');
        $identity = M('broker_identity');

        if($action == 'save'){
            try{
                $insertField = array(

                    'idcard'=>I('idcard'),
                    'idcard_pic'=>I('idcard_pic'),
                    'broker_id'=>$member_id,
                    'status'=>0,
                    'add_time'=>time()
                );
                $identity->save($insertField);
                jsurlto('申请已提交，请等待审核通过',U(MODULE_NAME . '/ManageBroker/brokerIdentity'));

            }catch (Exception $e){
                $this->error("申请保存失败，请重试");
            }
            exit;
        }else{
            $memberInfo = $member->getInfo($member_id,'*',true);
            $memberInfo['idcard'] = trim($memberInfo['idcard']);
            $memberInfo['mobile'] = trim($memberInfo['mobile']);
            $this->assign('memberInfo',$memberInfo);
        }

        $this->display();

    }

    /**
     * 身份证上传框架
     */
    public function webuploader(){
        $this->display();
    }

    /**
     * 修改头像
     */
    public function brokerPhoto(){

        $member=D('MemberView');//视图模型用于查找
        $member_id = $member->getAuthInfo('id');
        $action=I('get.action');
        $avatar = M('broker_avatar');
        if($action == 'save'){
            //p($_POST);die;
            try{
                $insertField = array(
                    'broker_id'=>$member_id,
                    'avatar_pic'=>I('avatar_pic'),
                    'status'=>0,
                    'add_time'=>time()
                );
                $avatar->add($insertField);
                jsurlto('申请已提交，请等待审核通过',U(MODULE_NAME . '/ManageBroker/brokerPhoto'));
            }catch (Exception $e){
                $this->error("申请保存失败，请重试");
            }
            exit;
        }else{

            $memberInfo = $member->getInfo($member_id,'*',true);
            $this->assign('memberInfo',$memberInfo);
            //取最后一次提交的审核头像
            $lastAvatar =$avatar->where(array('broker_id'=>$member_id))->order('add_time desc')->find();
            $this->assign('lastAvatar',$lastAvatar);
            //p($lastAvatar);
        }
        $this->display();

    }

    /**
     * 修改密码
     */
    public function pwdEdit(){
        $member=D('MemberView');//视图模型用于查找
        $member_id = $member->getAuthInfo('id');
        $action=I('get.action');
        if($action == 'save'){
            try{
                $check=$member->where(array('passwd'=>md5($_POST['password']),'id'=>$member_id))->find();
                if($check){
                    $updateInfo = array(
                        'passwd'=>md5($_POST['newpass'])
                    );

                    M('member')->where(array('id'=>$member_id))->save($updateInfo);
                }else{
                    $this->error('旧密码不正确');
                }
                jsurlto('修改密码成功',U(MODULE_NAME . '/ManageBroker/pwdEdit'));
            }catch (Exception $e){
                $this->error("修改密码失败，请重试");
            }
            exit;
        }else{

            $memberInfo = $member->getInfo($member_id,'*',true);
            $this->assign('memberInfo',$memberInfo);
        }

        $this->display();
    }

    /**
     * ajax验证旧密码
     */
    public function ajaxCheckPwd(){
        $member=D('MemberView');//视图模型用于查找
        $member_id = $member->getAuthInfo('id');
        $pwd = $_GET['password'];
        $check=$member->where(array('passwd'=>md5($pwd),'id'=>$member_id))->find();

        if($check){
            echo 1;
        }else{
            echo 0;
        }
        exit;
    }

    /**
     * 职业认证
     */
    public function brokerAptitude(){

        $member=D('MemberView');//视图模型用于查找
        $member_id = $member->getAuthInfo('id');
        $action=I('get.action');

        $aptitude = M('broker_aptitude');
        if($action == 'save'){
            try{
                $insertField = array(
                    'aptitude_pic'=>I('aptitude_pic'),
                    'broker_id'=>$member_id,
                    'status'=>0,
                    'add_time'=>time()
                );
                $aptitude->save($insertField);
                jsurlto('brokerAptitude.php','申请已提交，请等待审核通过');
            }catch (Exception $e){
                $this->error("申请保存失败，请重试");
            }
            exit;
        }else{
            $memberInfo = $member->getInfo($member_id,'*',true);
            $this->assign('memberInfo',$memberInfo);
        }

        $this->display();

    }

}