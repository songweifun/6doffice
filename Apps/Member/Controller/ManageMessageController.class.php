<?php
/**
 * 站内信控制器
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/11
 * Time: 下午2:26
 */
namespace Member\Controller;
use Think\Controller;
class ManageMessageController extends CommonController{
    /**
     * 撰写信件
     */
    public function msgWrite(){
        $member=D('MemberView');
        $member_id = $member->getAuthInfo('id');
        $member_username = $member->getAuthInfo('username');
        $innernote = M('innernote');
        $action=I('get.action');
        if($action =='save'){//保存


            if($_POST['msg_to'] ==""){
                $this->error("没有填写发送人地址");
            }

            try{
                $reciever = explode(',',$_POST['msg_to']);
                if(is_array($reciever)){
                    foreach($reciever as $a_r){
                        $a_r = trim($a_r);
                        if($a_r == ""){
                            continue;
                        }
                        $insertArray = array(
                            'msg_from'=>$member_username,
                            'msg_to'=>$a_r,
                            'msg_title'=>I('msg_title'),
                            'msg_content'=>I('msg_content'),
                            'replay_to'=>I('reply_to',0,'intval'),
                            'belongs_to'=>0,
                            'add_time'=>time()
                        );
                        //p($insertArray);die;

                        $innernote->add($insertArray);
                    }
                }
                jsurlto('发送成功',U(MODULE_NAME.'/ManageMessage/msgWrite'));
            }catch (Exception $e){
                $this->error("发送失败，请重试",U(MODULE_NAME.'/ManageMessage/msgWrite'));
            }
            exit;

        }else {
            //模板
            $reply_id = intval($_GET['reply_id']);
            if ($reply_id) {//回复信息
                $dataInfo = $innernote->where(array('id' => $reply_id))->find();
            }
            if ($dataInfo) {
                $dataInfo['reply_to'] = $dataInfo['id'];
                $dataInfo['msg_to'] = $dataInfo['msg_from'];
                $dataInfo['msg_title'] = "Re." . $dataInfo['msg_title'];
            } else {
                $dataInfo['msg_to'] = $_GET['msg_to'];
            }
            $this->assign('dataInfo', $dataInfo);
        }


        $this->display();

    }

    /**
     * 收件箱
     */
    public function msgInbox(){

        $member=D('MemberView');
        $member_id = $member->getAuthInfo('id');
        $member_username = $member->getAuthInfo('username');
        $realname=$member->getAuthInfo('realname');
        $innernote = M('innernote');
        $action=I('get.action');
        if($action=='toDel'){
            //删除
            $ids = $_POST['ids']?$_POST['ids']:$_GET['id'];
            if(empty($ids)){
                $this->error('没有选择删除条目');
            }
            if(is_array($ids)){
                array_walk($ids,'intval');
            }else{
                $ids=array($ids);
                array_walk($ids,'intval');
            }
            try{
                $innernote->where(array('id'=>array('in',$ids)))->setField('to_del',1);
                jsurlto('删除成功',U(MODULE_NAME.'/ManageMessage/msgInbox'));
            }catch (Exception $e){
                $this->error("删除失败，请重试");
            }
            exit;
        }else {
            //模板
            $where = " msg_to = '" . $member_username . "'";
            $where .= " and to_del = 0 ";
            $where.=" or msg_to='".$realname."'";
            $count = $innernote->where($where)->count();
            $Page = new \Think\Page($count, 15);//分页类
            //分页样式
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $show = $Page->show();// 分页显示输出
            $dataList = $innernote->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('add_time desc')->select();

            $this->assign('to_url', $_SERVER['REQUEST_URI']);
            $this->assign('dataList', $dataList);
            $this->assign('pagePanel', $show);//分页条
        }

        $this->display();

    }

    /**
     * 查看消息
     */
    public function msgDetail(){
        $member=D('MemberView');
        $member_id = $member->getAuthInfo('id');
        $member_username = $member->getAuthInfo('username');
        $innernote = M('innernote');
        $msg_id = intval($_GET['id']);
        $dataInfo = $innernote->where(array('id'=>$msg_id))->find();
        //修改邮件的状态
        $innernote->where(array('id'=>$msg_id))->setField('is_new',0);

        $this->assign('dataInfo', $dataInfo);

        $this->display();
    }

    /**
     * 已发信息
     */
    public function msgSend(){

        $member=D('MemberView');
        $member_id = $member->getAuthInfo('id');
        $member_username = $member->getAuthInfo('username');
        $realname=$member->getAuthInfo('realname');
        $innernote = M('innernote');
        $action=I('get.action');
        if($action=='fromDel'){
            //删除
            $ids = $_POST['ids'];
            if(!is_array($ids) || empty($ids)){
                $this->error('没有选择删除条目');
            }
            array_walk($ids,'intval');
            try{
                $where['id']=array('in',$ids);
                $where['belongs_to']=array('in',$ids);
                $where['_logic']='OR';
                $innernote->where($where)->setField('from_del',1);//不物理删除
               $this->success('删除成功');
            }catch (Exception $e){
                $this->error("删除失败，请重试");
            }
            exit;
        }else{
            //模板
            $where = " msg_from = '".$member_username."'";
            $where .=" and from_del = 0 ";

            $count = $innernote->where($where)->count();
            $Page = new \Think\Page($count, 15);//分页类
            //分页样式
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $show = $Page->show();// 分页显示输出
            $dataList = $innernote->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('add_time desc')->select();
            $this->assign('to_url', $_SERVER['REQUEST_URI']);
            $this->assign('dataList', $dataList);
            $this->assign('pagePanel', $show);//分页条
        }

        $this->display();

    }

    /**
     * 垃圾箱
     */
    public function msgGarbage(){

        $member=D('MemberView');
        $member_id = $member->getAuthInfo('id');
        $member_username = $member->getAuthInfo('username');
        $realname=$member->getAuthInfo('realname');
        $innernote = M('innernote');
        $action=I('get.action');

        //模板
        if($action=='addDel'){
            //删除
            $ids = $_POST['ids'];
            //p($ids);die;
            if(!is_array($ids) || empty($ids)){
                $this->error('没有选择删除条目');
            }
            array_walk($ids,'intval');

            try{
                foreach($ids as $id){
                    //组合条件用户名和真是姓名都可以
                    $whereto['id']=$id;
                    $whereto['msg_to']=$member_username;
                    $whereto['_logic']='AND';
                    $mapto['_complex']=$whereto;
                    $mapto['msg_to']=$realname;
                    $mapto['_logic']='OR';

                    $wherefrom['id']=$id;
                    $wherefrom['msg_from']=$member_username;
                    $wherefrom['_logic']='AND';
                    $mapfrom['_complex']=$wherefrom;
                    $mapfrom['msg_from']=$realname;
                    $mapfrom['_logic']='OR';


                    $innernote->where($mapto)->setField('to_del',2);
                    $innernote->where($mapfrom)->setField('from_del',2);//1为回收站 2彻底删除 默认0正常
                }

                $this->success('删除成功',U(MODULE_NAME.'/ManageMessage/msgGarbage'));
            }catch (Exception $e){
                $this->error("删除失败，请重试");
            }
            exit;
        }else{//模板
            $where = "( msg_from = '".$member_username."' and from_del = 1 ) or (msg_to = '".$member_username."' and to_del = 1)";//删除的发送信息 删除的收件信息 from我的 to我的
            $this->assign('username', $member_username);
            $count = $innernote->where($where)->count();
            $Page = new \Think\Page($count, 15);//分页类
            //分页样式
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $show = $Page->show();// 分页显示输出
            $dataList = $innernote->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('add_time desc')->select();
            $this->assign('to_url', $_SERVER['REQUEST_URI']);
            $this->assign('dataList', $dataList);
            $this->assign('pagePanel', $show);//分页条
        }

        $this->display();
    }

}