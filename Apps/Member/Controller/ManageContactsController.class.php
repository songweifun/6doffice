<?php
/**
 * 人脉管理控制器
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/10
 * Time: 下午9:58
 */
namespace Member\Controller;
use Think\Controller;
use Think\Crypt\Driver\Think;

class ManageContactsController extends CommonController{

    /**
     * 我的好友
     */
    public function snsFriends(){

        $broker_friend = M('broker_friends');
        $member=D('MemberView');
        $action=I('action');
        if($action=='add'){//添加好友

        }elseif($action=='delete'){//删除好友
            $id = intval($_GET['id']);
            try {
                $friendInfo = $broker_friend->where(array('id' => $id))->find();
                $broker_friend->where(array('status' => 1, 'broker_id' => $friendInfo['friend_id'], 'friend_id' => $friendInfo['broker_id']))->delete();//删除对方好友列表中的自己
                $broker_friend->where(array('id' => $id))->delete();//删除自己的好友列表
                jsurlto('删除成功', U(MODULE_NAME . '/ManageContacts/snsFriends'));
            }catch (Exception $e){
                $this->error("删除失败，请重试");
            }
        }else {
            //模板
            $cityarea_option = getArray('cityarea');
            $broker_type_option = getArray('broker_type');
            $member_id = $member->getAuthInfo('id');
            $where = 'status =1 and broker_id =' . $member_id;
            $count = $broker_friend->where($where)->count();
            $Page = new \Think\Page($count, 5);//分页类
            //分页样式
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $show = $Page->show();// 分页显示输出
            $dataList = $broker_friend->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('id desc')->select();
            import('Class.MyDate', APP_PATH);
            foreach ($dataList as $key => $item) {
                $friend_info = $member->getInfo($item['friend_id'], '*', true);
                $birth_m_t = \MyDate::transform('timestamp', $friend_info['birthday']);
                $birth_m = date('m', $birth_m_t) * 30 + date('d', $birth_m_t);
                $this_m = date('m') * 30 + date('d');
                $next_m = (date('m') + 1) * 30 + date('d');
                $friend_info['cityarea_name'] = $cityarea_option[$friend_info['cityarea_id']];
                $friend_info['broker_type'] = $broker_type_option[$friend_info['broker_type']];
                $friend_info['birth_remember'] = $birth_m < $next_m && $birth_m > $this_m;
                $dataList[$key] = $friend_info;
                $dataList[$key]['id'] = $item['id'];
                $dataList[$key]['friend_id'] = $item['friend_id'];
            }
            $this->assign('to_url', $_SERVER['REQUEST_URI']);
            $this->assign('dataList', $dataList);
            $this->assign('pagePanel', $show);
        }


        $this->display();
    }

    /**
     * 谁来看过我
     */
    public function snsLinkIn(){
        $shop_viewog = M('shop_viewlog');
        $member=D('MemberView');
        $action=I('action');

        //模板
        $cityarea_option = getArray('cityarea');
        $broker_type_option = getArray('broker_type');
        $member_id = $member->getAuthInfo('id');
        $where = ' broker_id ='.$member_id;
        $count = $shop_viewog->where($where)->count();
        $Page = new \Think\Page($count, 45);//分页类
        //分页样式
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $show = $Page->show();// 分页显示输出
        $dataList =$shop_viewog->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('id desc')->select();
        foreach ($dataList as $key => $item){
            $friend_info = $member->getInfo($item['friend_id'],'*',true);
            $dataList[$key]=$friend_info;
            $dataList[$key]['id'] = $item['id'];
            $dataList[$key]['friend_id'] = $item['friend_id'];
            $dataList[$key]['add_time'] = $item['add_time'];
        }
        $this->assign('to_url', $_SERVER['REQUEST_URI']);
        $this->assign('dataList', $dataList);
        $this->assign('pagePanel', $show);//分页条
        $this->display();

    }

}